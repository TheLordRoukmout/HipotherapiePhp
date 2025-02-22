<!-- je n'ai pas fait le system de login donc page non utile pour l'instant -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Client</title>
</head>
<body>
    <h1>Bienvenue, Client !</h1>
    <p>Vous avez accès à vos informations personnelles.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
</body>
</html>