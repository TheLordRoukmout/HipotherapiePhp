@extends('layouts.app')

@section('content')
    <h1>Recettes du mois de {{ \Carbon\Carbon::parse($mois)->translatedFormat('F Y') }}</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Client</th>
                <th>Montant</th>
                <th>Date</th>
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
    <a href="{{ route('recettes.index') }}">Retour à l'historique</a>
@endsection
