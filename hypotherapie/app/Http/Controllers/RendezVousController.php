<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rendezVous = \App\Models\RendezVous::with(['client', 'poney'])->get();
        return view('rendez-vous.index', compact('rendezVous'));
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
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'poney_id' => 'required|exists:poneys,id',
            'date_heure' => 'required|date',
            'nombre_personnes' => 'required|integer|min:1',
        ]);
    
        \App\Models\RendezVous::create($request->all());
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous ajouté avec succès.');
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
    public function destroy(string $id)
    {
        $rendezVous->delete();
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous supprimé avec succès.');
    }
}
