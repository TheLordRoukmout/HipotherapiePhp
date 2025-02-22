<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">📅 Ajouter un Rendez-vous</h1>

        <form action="{{ route('rendez-vous.store') }}" method="POST" class="space-y-4">
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

            <!-- Sélection Poney -->
            <div>
                <label for="poney_id" class="block text-gray-700 font-medium">Poney :</label>
                <select name="poney_id" id="poney_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach ($poneys as $poney)
                        @php
                            $tempsTravailUtilise = isset($rendezVous[$poney->id])
                                ? collect($rendezVous[$poney->id])->sum(function($rdv) {
                                    return \Carbon\Carbon::parse($rdv->date_heure)
                                            ->diffInHours(\Carbon\Carbon::parse($rdv->date_heure_fin));
                                })
                                : 0;

                            $tempsRestant = max(0, $poney->temps_travail - $tempsTravailUtilise);
                        @endphp

                        <option value="{{ $poney->id }}" {{ $tempsRestant <= 0 ? 'disabled' : '' }}>
                            {{ $poney->nom }} (Restant : {{ $tempsRestant }}h)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sélection Date -->
            <div>
                <label for="date" class="block text-gray-700 font-medium">Date :</label>
                <input type="date" name="date" id="date" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Sélection Heure de début -->
            <div>
                <label for="heure_debut" class="block text-gray-700 font-medium">Heure de début :</label>
                <input type="time" name="heure_debut" id="heure_debut" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Sélection Heure de fin -->
            <div>
                <label for="heure_fin" class="block text-gray-700 font-medium">Heure de fin :</label>
                <input type="time" name="heure_fin" id="heure_fin" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Sélection Nombre de personnes -->
            <div>
                <label for="nombre_personnes" class="block text-gray-700 font-medium">Nombre de personnes :</label>
                <input type="number" name="nombre_personnes" id="nombre_personnes" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Sélection Prix à l'heure -->
            <div>
                <label for="prix_heure" class="block text-gray-700 font-medium">Prix à l'heure (€) :</label>
                <input type="number" name="prix_heure" id="prix_heure" value="20" step="0.01" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Affichage du Prix Total -->
            <div class="text-gray-700 font-semibold">
                <strong>Prix total :</strong> <span id="prix_total">0</span> €
            </div>

            <!-- Bouton Créer -->
            <div class="flex justify-center">
                <button type="submit"
                    class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow hover:bg-green-600 transition">
                    ✅ Créer le rendez-vous
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function calculerPrixTotal() {
        let heureDebut = document.getElementById("heure_debut").value;
        let heureFin = document.getElementById("heure_fin").value;
        let nombrePersonnes = document.getElementById("nombre_personnes").value;
        let prixHeure = document.getElementById("prix_heure").value;
        let prixTotalSpan = document.getElementById("prix_total");

        if (heureDebut && heureFin && prixHeure && nombrePersonnes) {
            let debut = new Date("1970-01-01T" + heureDebut);
            let fin = new Date("1970-01-01T" + heureFin);
            let dureeHeures = (fin - debut) / (1000 * 60 * 60); // Convertir en heures

            if (dureeHeures > 0) {
                let prixTotal = dureeHeures * prixHeure * nombrePersonnes;
                prixTotalSpan.innerText = prixTotal.toFixed(2);
            } else {
                prixTotalSpan.innerText = "0";
            }
        }
    }

    document.getElementById("heure_debut").addEventListener("change", calculerPrixTotal);
    document.getElementById("heure_fin").addEventListener("change", calculerPrixTotal);
    document.getElementById("nombre_personnes").addEventListener("input", calculerPrixTotal);
    document.getElementById("prix_heure").addEventListener("input", calculerPrixTotal);
</script>
@endsection
