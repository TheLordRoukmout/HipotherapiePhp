<?php

namespace App\Http\Controllers;

use App\Models\Poney;
use Illuminate\Http\Request;

class PoneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poneys = \App\Models\Poney::all();
        $rendezVous = \App\Models\RendezVous::whereDate('date_heure', now()->format('Y-m-d'))->get()->groupBy('poney_id');

        return view('poneys.index', compact('poneys', 'rendezVous'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('poneys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'temps_travail' => 'required|integer',
        ]);

        \App\Models\Poney::create($request->all());
        return redirect()->route('poneys.index')->with('success', 'Poney ajouté avec succès !.');
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
    public function edit(Poney $poney)
    {
        return view('poneys.edit', compact('poney'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poney $poney)
    {
        $request->validate([
            'nom' => 'required',
            'temps_travail' => 'required|integer',
        ]);
    
        $poney->update($request->all());
        return redirect()->route('poneys.index')->with('success', 'Poney modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poney $poney)
    {
        $poney->delete(); // Supprime le poney
        return redirect()->route('poneys.index')->with('success', 'Poney supprimé avec succès.');
    }

    public function suivi()
    {
        $poneys = Poney::all()->map(function ($poney) {
            $tempsTravailUtilise = RendezVous::where('poney_id', $poney->id)
                ->whereDate('date_heure', now()->format('Y-m-d'))
                ->sum(DB::raw('TIMESTAMPDIFF(HOUR, date_heure, date_heure_fin)'));

            $poney->temps_restant = max(0, $poney->temps_travail - $tempsTravailUtilise);
            return $poney;
        });

        return view('poneys.suivi', compact('poneys'));
    }

}
