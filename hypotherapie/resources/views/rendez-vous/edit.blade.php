<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">✏ Modifier un Rendez-vous</h1>

        <form action="{{ route('rendez-vous.update', $rendezVous->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Sélection Client -->
            <div>
                <label for="client_id" class="block text-gray-700 font-medium">Client :</label>
                <select name="client_id" id="client_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $rendezVous->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Sélection Poney -->
            <div>
                <label for="poney_id" class="block text-gray-700 font-medium">Poney :</label>
                <select name="poney_id" id="poney_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach($poneys as $poney)
                    <option value="{{ $poney->id }}" {{ $rendezVous->poney_id == $poney->id ? 'selected' : '' }}>
                        {{ $poney->nom }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Date et Heure -->
            <div>
                <label for="date_heure" class="block text-gray-700 font-medium">Date et Heure :</label>
                <input type="datetime-local" name="date_heure" id="date_heure" required
                    value="{{ \Carbon\Carbon::parse($rendezVous->date_heure)->format('Y-m-d\TH:i') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Nombre de Personnes -->
            <div>
                <label for="nombre_personnes" class="block text-gray-700 font-medium">Nombre de Personnes :</label>
                <input type="number" name="nombre_personnes" id="nombre_personnes" min="1" required
                    value="{{ $rendezVous->nombre_personnes }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Bouton Modifier -->
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
