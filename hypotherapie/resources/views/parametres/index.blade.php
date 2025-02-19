<!-- resources/views/parametres/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Paramètres</h1>
    {{ $heureParPersonne->valeur ?? 2 }} <!-- Valeur par défaut : 2 -->
    {{ $prixParPersonne->valeur ?? 15 }} <!-- Valeur par défaut : 15 -->
    <form action="{{ route('parametres.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="heure_par_personne">Heure par personne :</label>
            <input type="number" name="heure_par_personne" id="heure_par_personne" value="{{ $heureParPersonne->valeur }}" required>
        </div>

        <div>
            <label for="prix_par_personne">Prix par personne :</label>
            <input type="number" name="prix_par_personne" id="prix_par_personne" value="{{ $prixParPersonne->valeur }}" required>
        </div>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection