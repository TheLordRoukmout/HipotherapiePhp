@extends('layouts.app')

@section('content')
    <h1>Attribuer des poneys au rendez-vous</h1>

    <!-- 🔥 Section pour afficher les participants déjà enregistrés -->
    <h3>Participants déjà attribués</h3>
    @if($rendezVous->participants->isEmpty())
        <p>Aucun participant n'a encore été ajouté.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom du participant</th>
                    <th>Poney attribué</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rendezVous->participants as $participant)
                    <tr>
                        <td>{{ $participant->nom }}</td>
                        <td>{{ $participant->poney->nom }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <hr>

    <!-- 🔥 Formulaire pour ajouter des nouveaux participants -->
    <form action="{{ route('rendez-vous.sauvegarderAttribution', $rendezVous->id) }}" method="POST">
        @csrf
        
        <h3>Client principal</h3>
        <div>
            <label>Nom :</label>
            <input type="text" value="{{ $rendezVous->client->nom }}" disabled>
        </div>

        <div>
            <label>Poney attribué :</label>
            <select name="poneys_ids[]" required>
                @foreach($poneys as $poney)
                    <option value="{{ $poney->id }}">
                        {{ $poney->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3>Ajouter les autres participants</h3>
        <div id="participants-container">
            <!-- Zone où les nouveaux participants seront ajoutés -->
        </div>

        <button type="button" onclick="ajouterParticipant()">+ Ajouter un participant</button>

        <button type="submit" class="btn btn-primary">Attribuer les poneys</button>
    </form>

    <script>
        function ajouterParticipant() {
            let container = document.getElementById('participants-container');
            let index = container.children.length; // Nombre actuel de participants ajoutés
            let div = document.createElement('div');
            
            div.innerHTML = `
                <label>Nom du participant :</label>
                <input type="text" name="participants[${index}][nom]" required>
                <label>Poney attribué :</label>
                <select name="participants[${index}][poney_id]" required>
                    @foreach($poneys as $poney)
                        <option value="{{ $poney->id }}">{{ $poney->nom }}</option>
                    @endforeach
                </select>
            `;
            container.appendChild(div);
        }
    </script>
@endsection
