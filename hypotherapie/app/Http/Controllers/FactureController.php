<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Facture;
use App\Models\Client;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $factures = \App\Models\Facture::with('client')->get();
        return view('factures.index', compact('factures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = \App\Models\Client::all();
        return view('factures.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'montant' => 'required|numeric',
            'date_facture' => 'required|date',
        ]);
    
        \App\Models\Facture::create($request->all());
        return redirect()->route('factures.index')->with('success', 'Facture ajoutée avec succès.');
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
    public function edit(Facture $facture)
    {
        $clients = \App\Models\Client::all();
        return view('factures.edit', compact('facture', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facture $facture)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'montant' => 'required|numeric',
            'date_facture' => 'required|date',
        ]);
    
        $facture->update($request->all());
        return redirect()->route('factures.index')->with('success', 'Facture modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facture $facture)
    {
        $facture->delete();
        return redirect()->route('factures.index')->with('success', 'Facture supprimée avec succès.');
    }

    public function historique(Request $request)
    {
        // Récupère la liste des mois disponibles
        $moisDisponibles = Facture::select(DB::raw("DATE_FORMAT(date_facture, '%Y-%m') as mois"))
            ->groupBy('mois')
            ->orderBy('mois', 'desc')
            ->pluck('mois');
    
        // Récupère le mois sélectionné (ou le mois en cours par défaut)
        $moisChoisi = $request->query('mois', now()->format('Y-m'));
    
        // Récupère les factures du mois sélectionné
        $factures = Facture::where(DB::raw("DATE_FORMAT(date_facture, '%Y-%m')"), $moisChoisi)
            ->with('client')
            ->get();
    
        // Calcule le total des factures du mois
        $totalRecettes = $factures->sum('montant');
    
        return view('recettes.index', compact('moisDisponibles', 'moisChoisi', 'factures', 'totalRecettes'));
    }
    

}
