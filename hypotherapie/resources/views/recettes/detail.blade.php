@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📆 Recettes du mois de {{ \Carbon\Carbon::parse($mois)->translatedFormat('F Y') }}</h1>

    <!-- Tableau des Recettes -->
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

    <!-- Bouton de retour -->
    <div class="mt-6">
        <a href="{{ route('recettes.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
            ⬅ Retour à l'historique
        </a>
    </div>
</div>
@endsection
