<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use App\Models\Client;
use App\Models\Poney;

class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère la date d'aujourd'hui
        $today = now()->format('Y-m-d');
    
        // Rendez-vous passés
        $rendezVousPasses = RendezVous::with(['client', 'poney'])
            ->whereDate('date_heure', '<', $today)
            ->orderBy('date_heure', 'desc') // Du plus récent au plus ancien
            ->get();
    
        // Rendez-vous d'aujourd'hui
        $rendezVousAujourdhui = RendezVous::with(['client', 'poney'])
            ->whereDate('date_heure', $today)
            ->orderBy('date_heure', 'asc')
            ->get();
    
        // Rendez-vous futurs
        $rendezVousFuturs = RendezVous::with(['client', 'poney'])
            ->whereDate('date_heure', '>', $today)
            ->orderBy('date_heure', 'asc') // Du plus proche au plus lointain
            ->get();
    
        // Calcule le nombre de poneys disponibles pour aujourd'hui
        $totalPoneys = Poney::count(); // Nombre total de poneys
        $poneysUtilises = 0;
    
        // Parcourt tous les rendez-vous d'aujourd'hui pour calculer les poneys utilisés
        foreach ($rendezVousAujourdhui as $rdv) {
            // Convertit manuellement en Carbon si nécessaire
            $rdv->date_heure = \Carbon\Carbon::parse($rdv->date_heure);
    
            // Heure de début et de fin du rendez-vous actuel
            $debutRdv = $rdv->date_heure;
            $finRdv = $rdv->date_heure->copy()->addHours(2); // Durée de 2h
    
            // Récupère les rendez-vous qui se chevauchent avec le rendez-vous actuel
            $rendezVousChevauchants = RendezVous::where(function ($query) use ($debutRdv, $finRdv) {
                $query->where(function ($q) use ($debutRdv, $finRdv) {
                    // Rendez-vous qui commencent avant et se terminent après le début du rendez-vous actuel
                    $q->where('date_heure', '<', $finRdv)
                      ->where('date_heure', '>=', $debutRdv->copy()->subHours(2));
                })->orWhere(function ($q) use ($debutRdv, $finRdv) {
                    // Rendez-vous qui commencent pendant le rendez-vous actuel
                    $q->where('date_heure', '>=', $debutRdv)
                      ->where('date_heure', '<', $finRdv);
                });
            })->get();
    
            // Additionne le nombre de personnes pour chaque rendez-vous chevauchant
            foreach ($rendezVousChevauchants as $rdvChevauchant) {
                $poneysUtilises += $rdvChevauchant->nombre_personnes;
            }
        }
    
        // Calcule le nombre de poneys disponibles
        $poneysDisponibles = $totalPoneys - $poneysUtilises;
    
        // Passe les données à la vue
        return view('rendez-vous.index', compact('rendezVousPasses', 'rendezVousAujourdhui', 'rendezVousFuturs', 'poneysDisponibles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = \App\Models\Client::all();
        $poneys = \App\Models\Poney::all();
        return view('rendez-vous.create', compact('clients', 'poneys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'poney_id' => 'required|exists:poneys,id',
            'date_heure' => 'required|date',
            'nombre_personnes' => 'required|integer|min:1',
        ]);
    
        // Convertir la date_heure en objet Carbon
        $dateHeureDebut = \Carbon\Carbon::parse($request->date_heure);
        $dateHeureFin = $dateHeureDebut->copy()->addHours(2); // Durée de 2h
    
        // Récupère le nombre total de poneys
        $totalPoneys = Poney::count();
    
        // Récupère les rendez-vous qui se chevauchent avec le nouveau rendez-vous
        $rendezVousChevauchants = RendezVous::where(function ($query) use ($dateHeureDebut, $dateHeureFin) {
            $query->where(function ($q) use ($dateHeureDebut, $dateHeureFin) {
                // Rendez-vous qui commencent avant et se terminent après le début du nouveau rendez-vous
                $q->where('date_heure', '<', $dateHeureFin)
                  ->where('date_heure', '>=', $dateHeureDebut->copy()->subHours(2));
            })->orWhere(function ($q) use ($dateHeureDebut, $dateHeureFin) {
                // Rendez-vous qui commencent pendant le nouveau rendez-vous
                $q->where('date_heure', '>=', $dateHeureDebut)
                  ->where('date_heure', '<', $dateHeureFin);
            });
        })->get();
    
        // Calcule le nombre de poneys utilisés
        $poneysUtilises = 0;
        foreach ($rendezVousChevauchants as $rendezVous) {
            $poneysUtilises += $rendezVous->nombre_personnes;
        }
    
        // Calcule le nombre de poneys disponibles
        $poneysDisponibles = $totalPoneys - $poneysUtilises;
    
        // Vérifie si le nombre de poneys disponibles est suffisant
        if ($request->nombre_personnes > $poneysDisponibles) {
            return redirect()->back()->withErrors([
                'nombre_personnes' => 'Il n\'y a pas assez de poneys disponibles pour ce groupe.',
            ])->withInput();
        }
    
        // Créer le nouveau rendez-vous
        RendezVous::create([
            'client_id' => $request->client_id,
            'poney_id' => $request->poney_id,
            'date_heure' => $request->date_heure,
            'nombre_personnes' => $request->nombre_personnes,
        ]);
    
        // Mettre à jour le nombre de poneys disponibles
        $poneysDisponibles -= $request->nombre_personnes;
    
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous créé avec succès.');
    }
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RendezVous $rendezVous)
    {
        $clients = \App\Models\Client::all();
        $poneys = \App\Models\Poney::all();
        return view('rendez-vous.edit', compact('rendezVous', 'clients', 'poneys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RendezVous $rendezVous)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'poney_id' => 'required|exists:poneys,id',
            'date_heure' => 'required|date',
            'nombre_personnes' => 'required|integer|min:1',
        ]);
    
        $rendezVous->update($request->all());
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    // Récupère le rendez-vous manuellement
    $rendezVous = RendezVous::find($id);

    // Debugging : Affiche les informations du rendez-vous
    // dd($rendezVous);

    if ($rendezVous) {
        // Supprime le rendez-vous
        $rendezVous->delete();
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous supprimé avec succès.');
    } else {
        return redirect()->route('rendez-vous.index')->with('error', 'Rendez-vous non trouvé.');
    }
}
}
