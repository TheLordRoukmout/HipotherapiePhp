<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📜 Liste des Factures</h1>

    <!-- Boutons d'action -->
    <div class="flex space-x-4 mb-4">
        <a href="{{ route('factures.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
            ➕ Ajouter une Facture
        </a>
        <a href="{{ route('recettes.index') }}" class="px-4 py-2 bg-indigo-500 text-white rounded-md shadow hover:bg-indigo-600">
            📅 Factures Mensuelles
        </a>
    </div>

    <!-- Tableau des Factures -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Client</th>
                    <th class="px-4 py-3 text-left">Montant</th>
                    <th class="px-4 py-3 text-left">Date de la Facture</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factures as $facture)
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
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Aucune facture disponible.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
