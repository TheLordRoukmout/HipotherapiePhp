<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-2xl bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">🐴 Attribuer des poneys au rendez-vous</h1>

        <!-- 🔥 Section pour afficher les participants déjà enregistrés -->
        <h3 class="text-lg font-semibold text-gray-700 mb-3">👥 Participants déjà attribués</h3>
        @if($rendezVous->participants->isEmpty())
            <p class="text-gray-500">Aucun participant n'a encore été ajouté.</p>
        @else
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Nom du participant</th>
                            <th class="px-4 py-3 text-left">Poney attribué</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rendezVous->participants as $participant)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $participant->nom }}</td>
                            <td class="px-4 py-3">{{ $participant->poney->nom }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <hr class="my-6">

        <!-- 🔥 Formulaire pour ajouter des nouveaux participants -->
        <form action="{{ route('rendez-vous.sauvegarderAttribution', $rendezVous->id) }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Client principal -->
            <h3 class="text-lg font-semibold text-gray-700">🧑‍🤝‍🧑 Client principal</h3>
            <div>
                <label class="block text-gray-700 font-medium">Nom :</label>
                <input type="text" value="{{ $rendezVous->client->nom }}" disabled
                    class="w-full px-4 py-2 border rounded-lg bg-gray-100">
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Poney attribué :</label>
                <select name="poneys_ids[]" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach($poneys as $poney)
                        <option value="{{ $poney->id }}">{{ $poney->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Ajout des autres participants -->
            <h3 class="text-lg font-semibold text-gray-700">➕ Ajouter des participants</h3>
            <div id="participants-container" class="space-y-3">
                <!-- Zone où les nouveaux participants seront ajoutés -->
            </div>

            <button type="button" onclick="ajouterParticipant()"
                class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow hover:bg-blue-600 transition">
                ➕ Ajouter un participant
            </button>

            <button type="submit"
                class="w-full px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition">
                ✅ Attribuer les poneys
            </button>
        </form>
    </div>
</div>

<script>
    function ajouterParticipant() {
        let container = document.getElementById('participants-container');
        let index = container.children.length; // Nombre actuel de participants ajoutés
        let div = document.createElement('div');
        div.classList.add("p-3", "border", "rounded-lg", "bg-gray-50", "space-y-2");

        div.innerHTML = `
            <label class="block text-gray-700 font-medium">Nom du participant :</label>
            <input type="text" name="participants[${index}][nom]" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

            <label class="block text-gray-700 font-medium">Poney attribué :</label>
            <select name="participants[${index}][poney_id]" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($poneys as $poney)
                    <option value="{{ $poney->id }}">{{ $poney->nom }}</option>
                @endforeach
            </select>
        `;
        container.appendChild(div);
    }
</script>
@endsection
