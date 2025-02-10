<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Poney</title>
</head>
<body>
    <h1>Modifier un Poney</h1>
    <form action="{{ route('poneys.update', $poney->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="{{ $poney->nom }}" required>
        <br>
        <label for="temps_travail">Temps de travail (heures) :</label>
        <input type="number" name="temps_travail" id="temps_travail" value="{{ $poney->temps_travail }}" required>
        <br>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>