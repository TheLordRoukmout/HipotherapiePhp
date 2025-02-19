<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures</title>
</head>
<body>
@extends('layouts.app')
@section('content')
    <h1>Liste des Factures</h1>
    <a href="{{ route('factures.create') }}">Ajouter une Facture</a>
    <table border="1">
        <thead>
            <tr>
                <th>Client</th>
                <th>Montant</th>
                <th>Date de la Facture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
            <tr>
                <td>{{ $facture->client->nom }}</td>
                <td>{{ $facture->montant }} €</td>
                <td>{{ $facture->date_facture }}</td>
                <td>
                    <a href="{{ route('factures.edit', $facture->id) }}">Modifier</a>
                    <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
</body>
</html>