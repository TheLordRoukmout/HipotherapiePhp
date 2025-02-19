<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Projet Laravel</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Menu à gauche -->
        <nav class="sidebar">
            @include('partials.menu')
        </nav>

        <!-- Contenu principal à droite -->
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>