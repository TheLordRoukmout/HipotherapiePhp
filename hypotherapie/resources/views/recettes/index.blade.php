@extends('layouts.app')

@section('content')
    <h1>Historique des Recettes</h1>

    <!-- Formulaire de sélection du mois -->
    <form action="{{ route('recettes.index') }}" method="GET">
        <label for="mois">Sélectionner un mois :</label>
        <select name="mois" id="mois" onchange="this.form.submit()">
            @foreach($moisDisponibles as $mois)
                <option value="{{ $mois }}" {{ $mois == $moisChoisi ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($mois)->translatedFormat('F Y') }}
                </option>
            @endforeach
        </select>
    </form>

    <h2>Factures du mois de {{ \Carbon\Carbon::parse($moisChoisi)->translatedFormat('F Y') }}</h2>
    <p><strong>Total des factures :</strong> {{ $totalRecettes }} €</p>

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
@endsection
