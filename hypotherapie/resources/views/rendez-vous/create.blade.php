@extends('layouts.app')

@section('content')
    <h1>Ajouter un Rendez-vous</h1>

    <form action="{{ route('rendez-vous.store') }}" method="POST">
        @csrf

        <div>
            <label for="client_id">Client :</label>
            <select name="client_id" id="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="poney_id">Poney :</label>
            <select name="poney_id" id="poney_id" required>
                @foreach($poneys as $poney)
                    <option value="{{ $poney->id }}">{{ $poney->nom }}</option>
                @endforeach
            </select>
            <select name="poney_id" required>
                @foreach ($poneys as $poney)
                    @php
                        // Vérifier le temps de travail utilisé aujourd'hui
                        $tempsTravailUtilise = isset($rendezVous[$poney->id])
                            ? collect($rendezVous[$poney->id])->sum(function($rdv) {
                                return \Carbon\Carbon::parse($rdv->date_heure)
                                        ->diffInHours(\Carbon\Carbon::parse($rdv->date_heure_fin));
                            })
                            : 0;

                        // Calculer le temps restant
                        $tempsRestant = max(0, $poney->temps_travail - $tempsTravailUtilise);
                    @endphp

                    <option value="{{ $poney->id }}" {{ $tempsRestant <= 0 ? 'disabled' : '' }}>
                        {{ $poney->nom }} (Restant : {{ $tempsRestant }}h)
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="date">Date :</label>
            <input type="date" name="date" id="date" required>
        </div>

        <div>
            <label for="heure_debut">Heure de début :</label>
            <input type="time" name="heure_debut" id="heure_debut" required>
        </div>

        <div>
            <label for="heure_fin">Heure de fin :</label>
            <input type="time" name="heure_fin" id="heure_fin" required>
        </div>

        <div>
            <label for="nombre_personnes">Nombre de personnes :</label>
            <input type="number" name="nombre_personnes" id="nombre_personnes" required>
        </div>

        <div>
            <label for="prix_heure">Prix à l'heure (€) :</label>
            <input type="number" name="prix_heure" id="prix_heure" value="20" step="0.01" required>
        </div>

        <div>
            <strong>Prix total :</strong> <span id="prix_total">0</span> €
        </div>

        <button type="submit">Créer le rendez-vous</button>
    </form>

    <!-- C'est juste pour afficher le calcul de prix en direct rien avoir avec le back j'espere que ça causera pas de problème -->
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
