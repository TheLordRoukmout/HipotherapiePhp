<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Page d'accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 texte-center">
    @extends('layouts.app')

    @section('content')
        <h1 class="text-4xl text-blue-500 font-bold mt-10">Bienvenue sur la page d'accueil !</h1>
        <p class="px-4 py-2 text-blue-500 rounded mt-5">projet Php pour le cours de web.</p>
    @endsection
</body>
</html>