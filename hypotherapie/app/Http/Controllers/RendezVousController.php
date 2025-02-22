<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use App\Models\Client;
use App\Models\Poney;
use App\Models\Parametre;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RendezVousController extends Controller
{
    /**
     * Afficher la liste des rendez-vous.
     */
    public function index()
    {
        $today = now()->format('Y-m-d');

        // Chargement des rendez-vous avec relations
        $rendezVousPasses = RendezVous::with(['client', 'poney'])
            ->whereDate('date_heure', '<', $today)
            ->orderBy('date_heure', 'desc')
            ->get();

        $rendezVousAujourdhui = RendezVous::with(['client', 'poney'])
            ->whereDate('date_heure', $today)
            ->orderBy('date_heure', 'asc')
            ->get();

        $rendezVousFuturs = RendezVous::with(['client', 'poney'])
            ->whereDate('date_heure', '>', $today)
            ->orderBy('date_heure', 'asc')
            ->get();

        // Calcul du nombre de poneys disponibles aujourd'hui
        $totalPoneys = Poney::count();
        $poneysUtilises = RendezVous::whereDate('date_heure', $today)->count();
        $poneysDisponibles = $totalPoneys - $poneysUtilises;

        return view('rendez-vous.index', compact('rendezVousPasses', 'rendezVousAujourdhui', 'rendezVousFuturs', 'poneysDisponibles'));
    }

    /**
     * Afficher le formulaire de création d'un rendez-vous.
     */
    public function create()
    {
        $clients = Client::all();
        $poneys = Poney::all();
        return view('rendez-vous.create', compact('clients', 'poneys'));
    }

    /**
     * Enregistrer un nouveau rendez-vous.
     */
    public function store(Request $request)
    {
        // ✅ Validation des champs
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'poney_id' => 'required|exists:poneys,id',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'nombre_personnes' => 'required|integer|min:1',
            'prix_heure' => 'required|numeric|min:0', // ✅ Prix à l'heure ne peut pas être négatif
        ]);
    
        // ✅ Fusionner la date et l'heure
        $dateHeureDebut = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->heure_debut);
        $dateHeureFin = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->heure_fin);
    
        // ✅ Vérifier le nombre total de poneys
        $totalPoneys = Poney::count();
        $poneysUtilises = RendezVous::whereDate('date_heure', $request->date)->count();
        $poneysDisponibles = $totalPoneys - $poneysUtilises;
    
        // ❌ Si plus de poneys disponibles, empêcher la réservation
        if ($poneysDisponibles <= 0) {
            return redirect()->back()->withErrors([
                'poney_id' => 'Impossible de créer un rendez-vous : plus de poneys disponibles pour cette journée.',
            ])->withInput();
        }
    
        // ❌ Vérifier si le poney sélectionné est disponible
        if (!RendezVous::poneyEstDisponible($request->poney_id, $dateHeureDebut, $dateHeureFin)) {
            return redirect()->back()->withErrors([
                'poney_id' => 'Ce poney est déjà réservé sur cette plage horaire.',
            ])->withInput();
        }

        $poney = Poney::find($request->poney_id);

    // Calcul du temps de travail déjà utilisé aujourd'hui
    $tempsTravailUtilise = RendezVous::where('poney_id', $poney->id)
        ->whereDate('date_heure', $request->date)
        ->sum(DB::raw('TIMESTAMPDIFF(HOUR, date_heure, date_heure_fin)'));

    // Vérifier si le poney peut encore travailler
    $heureFin = is_numeric($request->heure_fin) ? floatval($request->heure_fin) : 0;
    $heureDebut = is_numeric($request->heure_debut) ? floatval($request->heure_debut) : 0;
    $tempsTravailMax = is_numeric($poney->temps_travail) ? floatval($poney->temps_travail) : 0;
    $tempsUtilise = is_numeric($tempsTravailUtilise) ? floatval($tempsTravailUtilise) : 0;
    
    if (($tempsUtilise + ($heureFin - $heureDebut)) > $tempsTravailMax) {
        return redirect()->back()->withErrors([
            'poney_id' => 'Ce poney a atteint son temps de travail maximal pour aujourd\'hui.',
        ])->withInput();
    }

        // ✅ CRÉER LE RENDEZ-VOUS
        $rendezVous = RendezVous::create([
            'client_id' => $request->client_id,
            'poney_id' => $request->poney_id,
            'date_heure' => $dateHeureDebut,
            'date_heure_fin' => $dateHeureFin,
            'nombre_personnes' => $request->nombre_personnes,
        ]);
    
        // ✅ CALCULER LE MONTANT (Correction du problème de négatif)
        $montant = abs($this->calculerMontant($rendezVous, $request->prix_heure)); // 🔥 Ajout de abs() pour être sûr que c'est positif
    
        // 🔍 DEBUG : Vérifie si le montant est bien positif avant d'enregistrer la facture
        \Log::info("Montant calculé pour la facture: $montant");
        
        // ✅ CRÉER LA FACTURE
        \App\Models\Facture::create([
            'client_id' => $rendezVous->client_id,
            'rendez_vous_id' => $rendezVous->id,
            'montant' => $montant,
            'date_facture' => now(),
            'statut' => 'impayée',
        ]);

        $poneys = Poney::all()->map(function ($poney) {
            $tempsTravailUtilise = RendezVous::where('poney_id', $poney->id)
                ->whereDate('date_heure', now()->format('Y-m-d'))
                ->sum(DB::raw('TIMESTAMPDIFF(HOUR, date_heure, date_heure_fin)'));
            
            $poney->temps_restant = max(0, $poney->temps_travail - $tempsTravailUtilise);
            return $poney;
        });
        
    
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous créé avec succès.');
    }    

    

    /**
     * Afficher le formulaire d'édition d'un rendez-vous.
     */
    public function edit(RendezVous $rendezVous)
    {
        $clients = Client::all();
        $poneys = Poney::all();
        return view('rendez-vous.edit', compact('rendezVous', 'clients', 'poneys'));
    }

    /**
     * Mettre à jour un rendez-vous existant.
     */
    public function update(Request $request, RendezVous $rendezVous)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'poney_id' => 'required|exists:poneys,id',
            'date_heure' => 'required|date',
            'nombre_personnes' => 'required|integer|min:1',
        ]);

        // Récupérer la durée par personne depuis les paramètres
        $heureParPersonne = Parametre::where('cle', 'heure_par_personne')->value('valeur') ?? 2;
        $dureeTotale = $heureParPersonne * $request->nombre_personnes;

        // Déterminer l'heure de début et l'heure de fin
        $dateHeureDebut = Carbon::parse($request->date_heure);
        $dateHeureFin = $dateHeureDebut->copy()->addHours($dureeTotale);

        // Mettre à jour le rendez-vous
        $rendezVous->update([
            'client_id' => $request->client_id,
            'poney_id' => $request->poney_id,
            'date_heure' => $dateHeureDebut,
            'date_heure_fin' => $dateHeureFin,
            'nombre_personnes' => $request->nombre_personnes,
        ]);

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    /**
     * Supprimer un rendez-vous.
     */
    public function destroy($id)
    {
        $rendezVous = RendezVous::find($id);

        if ($rendezVous) {
            $rendezVous->delete();
            return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous supprimé avec succès.');
        }

        return redirect()->route('rendez-vous.index')->with('error', 'Rendez-vous non trouvé.');
    }

        /**
     * Afficher la page d'attribution des poneys.
     */
    public function attribuer($id)
    {
        $rendezVous = RendezVous::with(['client', 'poney', 'participants.poney'])->findOrFail($id);
        $poneys = Poney::all();
        $clients = Client::all();

        return view('rendez-vous.attribution', compact('rendezVous', 'poneys', 'clients'));
    }

        /**
     * Sauvegarder l'attribution des poneys à un rendez-vous.
     */
    public function sauvegarderAttribution(Request $request, $id)
    {
        $request->validate([
            'poneys_ids' => 'required|array',
            'poneys_ids.*' => 'exists:poneys,id',
            'participants' => 'nullable|array',
            'participants.*.nom' => 'required|string',
            'participants.*.poney_id' => 'required|exists:poneys,id',
        ]);

        $rendezVous = RendezVous::findOrFail($id);

        // Supprime les anciens participants pour éviter les doublons
        $rendezVous->participants()->delete();

        // Ajoute le client principal comme premier participant
        \App\Models\Participant::create([
            'rendez_vous_id' => $rendezVous->id,
            'nom' => $rendezVous->client->nom, // Le nom du client principal
            'poney_id' => $request->poneys_ids[0], // Le premier poney choisi
        ]);

        // Ajoute les autres participants
        foreach ($request->participants as $participant) {
            \App\Models\Participant::create([
                'rendez_vous_id' => $rendezVous->id,
                'nom' => $participant['nom'],
                'poney_id' => $participant['poney_id'],
            ]);
        }

        return redirect()->route('rendez-vous.index')->with('success', 'Poneys attribués avec succès.');
    }

    public function show(RendezVous $rendezVous)
    {
        return view('rendez-vous.show', compact('rendezVous'));
    }

    private function calculerMontant($rendezVous)
    {
        // Définir un tarif horaire par personne (exemple : 20€/heure)
        $tarifHoraire = 20;

        // Vérifier que les dates sont bien définies
        if (!$rendezVous->date_heure || !$rendezVous->date_heure_fin) {
            return 0; // Si les dates ne sont pas valides, renvoyer 0€
        }

        // Calcul de la durée en heures
        $dureeHeures = $rendezVous->date_heure_fin->diffInHours($rendezVous->date_heure);

        // Calcul du montant total
        return $dureeHeures * $tarifHoraire * $rendezVous->nombre_personnes;
    }

}
