<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use App\Models\Client;
use App\Models\Poney;
use App\Models\Parametre;
use Carbon\Carbon;

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
    // Validation des champs
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'poney_id' => 'required|exists:poneys,id',
        'date' => 'required|date',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i|after:heure_debut',
        'nombre_personnes' => 'required|integer|min:1',
    ]);

    // Fusionner la date et l'heure
    $dateHeureDebut = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->heure_debut);
    $dateHeureFin = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->heure_fin);

    // Vérifier le nombre total de poneys
    $totalPoneys = Poney::count();

    // Vérifier le nombre de poneys déjà utilisés sur cette journée
    $poneysUtilises = RendezVous::whereDate('date_heure', $request->date)->count();

    // Calculer les poneys disponibles
    $poneysDisponibles = $totalPoneys - $poneysUtilises;

    // Si plus de poneys disponibles, empêcher la réservation
    if ($poneysDisponibles <= 0) {
        return redirect()->back()->withErrors([
            'poney_id' => 'Impossible de créer un rendez-vous : plus de poneys disponibles pour cette journée.',
        ])->withInput();
    }

    // Vérifier si le poney sélectionné est disponible
    if (!RendezVous::poneyEstDisponible($request->poney_id, $dateHeureDebut, $dateHeureFin)) {
        return redirect()->back()->withErrors([
            'poney_id' => 'Ce poney est déjà réservé sur cette plage horaire.',
        ])->withInput();
    }

    // Création du rendez-vous
    RendezVous::create([
        'client_id' => $request->client_id,
        'poney_id' => $request->poney_id,
        'date_heure' => $dateHeureDebut,
        'date_heure_fin' => $dateHeureFin,
        'nombre_personnes' => $request->nombre_personnes,
    ]);

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




}
