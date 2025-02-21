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
    <a href="{{ route('factures.create') }}" class="btn btn-primary">Ajouter une Facture</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Client</th>
                <th>Montant</th>
                <th>Date de la Facture</th>
                <th>Rendez-vous</th>  <!-- 🔹 Nouvelle colonne -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($factures as $facture)
                <tr>
                    <td>{{ $facture->client->nom }}</td>
                    <td>{{ number_format($facture->montant, 2, ',', ' ') }} €</td>
                    <td>{{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</td>
                    <td>
                        @if($facture->rendezVous)
                            <a href="{{ route('rendez-vous.show', $facture->rendezVous->id) }}">
                                #{{ $facture->rendezVous->id }} ({{ \Carbon\Carbon::parse($facture->rendezVous->date_heure)->format('d/m/Y H:i') }})
                            </a>
                        @else
                            Aucun
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('factures.edit', $facture->id) }}" class="btn btn-warning">Modifier</a>
                        <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Aucune facture disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

</body>
</html>