<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Projet Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Menu à gauche (Sidebar) -->
        <nav class="w-64 bg-gray-900 text-white fixed h-full">
            @include('partials.menu')
        </nav>

        <!-- Contenu principal -->
        <div class="flex-1 ml-64 p-6">
            <main class="bg-white shadow-md rounded-lg p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
