<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Http\Request;

// controller mis en place mais abandonné lors du développement car il ne me servait a rien


class ParametreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heureParPersonne = Parametre::where('cle', 'heure_par_personne')->first();
        $prixParPersonne = Parametre::where('cle', 'prix_par_personne')->first();
        
        // Valeurs par défaut si les paramètres n'existent pas
        $heureParPersonne = $heureParPersonne ?? new Parametre(['cle' => 'heure_par_personne', 'valeur' => 2]); // Exemple de valeur par défaut
        $prixParPersonne = $prixParPersonne ?? new Parametre(['cle' => 'prix_par_personne', 'valeur' => 15]); // Exemple de valeur par défaut

        return view('parametres.index', compact('heureParPersonne', 'prixParPersonne'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Heure de début du rendez-vous
        $dateHeureDebut = $request->date_heure;
    
        // Heure de fin fixée à 2 heures après le début
        $dateHeureFin = \Carbon\Carbon::parse($dateHeureDebut)->addHours(2);
    
        // Crée le rendez-vous
        RendezVous::create([
            'client_id' => $request->client_id,
            'poney_id' => $request->poney_id,
            'date_heure' => $dateHeureDebut,
            'nombre_personnes' => $request->nombre_personnes,
        ]);
    
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous créé avec succès !');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Mettre à jour les paramètres
    public function update(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'heure_par_personne' => 'required|numeric',
            'prix_par_personne' => 'required|numeric',
        ]);

        // Mettre à jour l'heure par personne
        Parametre::updateOrCreate(
            ['cle' => 'heure_par_personne'],
            ['valeur' => $request->heure_par_personne, 'updated_at' => now()]
        );  

        // Mettre à jour le prix par personne
        Parametre::updateOrCreate(
            ['cle' => 'prix_par_personne'],
            ['valeur' => $request->prix_par_personne, 'updated_at' => now()]
        );

        return redirect()->route('parametres.index')->with('success', 'Paramètres mis à jour avec succès !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
