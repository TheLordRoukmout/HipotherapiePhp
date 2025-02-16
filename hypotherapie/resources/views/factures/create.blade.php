<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Facture</title>
</head>
<body>
    <h1>Ajouter une Facture</h1>
    <form action="{{ route('factures.store') }}" method="POST">
        @csrf
        <label for="client_id">Client :</label>
        <select name="client_id" id="client_id" required>
            @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->nom }}</option>
            @endforeach
        </select>
        <br>
        <label for="montant">Montant :</label>
        <input type="number" name="montant" id="montant" step="0.01" required>
        <br>
        <label for="date_facture">Date de la Facture :</label>
        <input type="date" name="date_facture" id="date_facture" required>
        <br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>