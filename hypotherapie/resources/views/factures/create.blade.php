<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">➕ Ajouter une Facture</h1>

        <form action="{{ route('factures.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Sélection Client -->
            <div>
                <label for="client_id" class="block text-gray-700 font-medium">Client :</label>
                <select name="client_id" id="client_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Champ Montant -->
            <div>
                <label for="montant" class="block text-gray-700 font-medium">Montant (€) :</label>
                <input type="number" name="montant" id="montant" step="0.01" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <!-- Sélection Date de Facture -->
            <div>
                <label for="date_facture" class="block text-gray-700 font-medium">Date de la Facture :</label>
                <input type="date" name="date_facture" id="date_facture" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Bouton Ajouter -->
            <div class="flex justify-center">
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 transition">
                    ✅ Ajouter la Facture
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
