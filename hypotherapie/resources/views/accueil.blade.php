<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Page d'accueil</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <h1>Bienvenue sur la page d'accueil !</h1>
        <p>Ceci est une page personnalisée.</p>
    @endsection
</body>
</html>