<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">➕ Ajouter un Poney</h1>

        <form action="{{ route('poneys.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Champ Nom -->
            <div>
                <label for="nom" class="block text-gray-700 font-medium">Nom :</label>
                <input type="text" name="nom" id="nom" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Champ Temps de Travail -->
            <div>
                <label for="temps_travail" class="block text-gray-700 font-medium">Temps de travail (h) :</label>
                <input type="number" name="temps_travail" id="temps_travail" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Bouton Ajouter -->
            <div class="flex justify-center">
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 transition">
                    ➕ Ajouter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
