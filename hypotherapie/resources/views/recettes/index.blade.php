<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📊 Historique des Recettes</h1>

    <!-- Formulaire de sélection du mois -->
    <form action="{{ route('recettes.index') }}" method="GET" class="mb-6">
        <label for="mois" class="text-gray-700 font-medium">📅 Sélectionner un mois :</label>
        <select name="mois" id="mois" onchange="this.form.submit()"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach($moisDisponibles as $mois)
                <option value="{{ $mois }}" {{ $mois == $moisChoisi ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($mois)->translatedFormat('F Y') }}
                </option>
            @endforeach
        </select>
    </form>

    <h2 class="text-xl font-semibold text-gray-700 mb-3">
        🗓 Factures du mois de {{ \Carbon\Carbon::parse($moisChoisi)->translatedFormat('F Y') }}
    </h2>
    <p class="text-lg font-bold text-green-600 mb-4">
        💰 Total des factures : {{ number_format($totalRecettes, 2, ',', ' ') }} €
    </p>

    <!-- Tableau des Factures -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Client</th>
                    <th class="px-4 py-3 text-left">Montant</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factures as $facture)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $facture->client->nom }}</td>
                    <td class="px-4 py-3 font-semibold text-green-600">{{ number_format($facture->montant, 2, ',', ' ') }} €</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($facture->date_facture)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('factures.edit', $facture->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            ✏ Modifier
                        </a>
                        <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')">
                                🗑 Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection