<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Client</title>
</head>
<body>
    <h1>Ajouter un Client</h1>
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="telephone">Téléphone :</label>
        <input type="text" name="telephone" id="telephone">
        <br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>