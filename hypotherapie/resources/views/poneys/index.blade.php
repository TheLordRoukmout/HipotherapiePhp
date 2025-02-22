<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Poneys</title>
</head>
<body>
@extends('layouts.app')
@section('content')
    <h1>Liste des Poneys</h1>
    <a href="{{ route('poneys.create') }}">Ajouter un Poney</a>
    
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Temps de travail max (h)</th>
                <th>Temps travaillé aujourd'hui (h)</th>
                <th>Temps restant (h)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($poneys as $poney)
            <tr>
                <td>{{ $poney->nom }}</td>
                <td>{{ $poney->temps_travail }}</td>

                {{-- Calcul du temps de travail utilisé aujourd'hui --}}
                @php
                    // Vérifier si le poney a des rendez-vous aujourd'hui
                    $tempsTravailUtilise = isset($rendezVous[$poney->id])
                        ? collect($rendezVous[$poney->id])->sum(function($rdv) {
                            return \Carbon\Carbon::parse($rdv->date_heure)
                                    ->diffInHours(\Carbon\Carbon::parse($rdv->date_heure_fin));
                        })
                        : 0;

                    // Calculer le temps restant
                    $tempsRestant = max(0, $poney->temps_travail - $tempsTravailUtilise);
                @endphp

                <td>{{ $tempsTravailUtilise }}h</td>
                <td style="color: {{ $tempsRestant == 0 ? 'red' : 'green' }};">
                    {{ $tempsRestant }}h
                </td>

                @if($tempsRestant == 0)
                    <p style="color: red;">⚠ Ce poney ne peut plus travailler aujourd'hui !</p>
                @endif



                <td>{{ $tempsTravailUtilise }}h</td>
                <td 
                    style="color: {{ $tempsRestant == 0 ? 'red' : 'green' }};">
                    {{ $tempsRestant }}h
                </td>

                <td>
                    <a href="{{ route('poneys.edit', $poney) }}">Modifier</a>
                    <form action="{{ route('poneys.destroy', $poney) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>

                    {{-- Alerte si le poney a atteint son quota --}}
                    @if($tempsRestant == 0)
                        <p style="color: red;">⚠ Ce poney ne peut plus travailler aujourd'hui !</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
</body>
</html>
