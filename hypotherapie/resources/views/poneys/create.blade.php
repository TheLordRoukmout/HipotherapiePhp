<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Poney</title>
</head>
<body>
    <h1>Ajouter un Poney</h1>
    <form action="{{ route('poneys.store') }}" method="POST">
        @csrf
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="temps_travail">Temps de travail (heures) :</label>
        <input type="number" name="temps_travail" id="temps_travail" required>
        <br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>