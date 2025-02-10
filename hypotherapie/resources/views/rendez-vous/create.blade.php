
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Rendez-vous</title>
</head>
<body>
    <h1>Ajouter un Rendez-vous</h1>
    <form action="{{ route('rendez-vous.store') }}" method="POST">
        @csrf
        <label for="client_id">Client :</label>
        <select name="client_id" id="client_id" required>
            @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->nom }}</option>
            @endforeach
        </select>
        <br>
        <label for="poney_id">Poney :</label>
        <select name="poney_id" id="poney_id" required>
            @foreach($poneys as $poney)
            <option value="{{ $poney->id }}">{{ $poney->nom }}</option>
            @endforeach
        </select>
        <br>
        <label for="date_heure">Date et Heure :</label>
        <input type="datetime-local" name="date_heure" id="date_heure" required>
        <br>
        <label for="nombre_personnes">Nombre de Personnes :</label>
        <input type="number" name="nombre_personnes" id="nombre_personnes" min="1" required>
        <br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>