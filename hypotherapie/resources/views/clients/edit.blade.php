<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">✏ Modifier un Client</h1>

        <form action="{{ route('clients.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Champ Nom -->
            <div>
                <label for="nom" class="block text-gray-700 font-medium">Nom :</label>
                <input type="text" name="nom" id="nom" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Champ Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium">Email :</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Champ Téléphone -->
            <div>
                <label for="telephone" class="block text-gray-700 font-medium">Téléphone :</label>
                <input type="text" name="telephone" id="telephone"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Bouton Ajouter -->
            <div class="flex justify-center">
                <button type="submit"
                    class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition">
                    ✅ Modifier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
