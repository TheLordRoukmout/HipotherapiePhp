<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🧑‍🤝‍🧑 Liste des Clients</h1>

    <!-- Bouton Ajouter un Client -->
    <div class="mb-4">
        <a href="{{ route('clients.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
            ➕ Ajouter un Client
        </a>
    </div>

    <!-- Tableau des Clients -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Téléphone</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $client->nom }}</td>
                    <td class="px-4 py-3">{{ $client->email }}</td>
                    <td class="px-4 py-3">{{ $client->telephone }}</td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('clients.edit', $client->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            ✏ Modifier
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
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
