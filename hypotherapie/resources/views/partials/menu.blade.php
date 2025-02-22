<nav class="w-64 h-screen bg-gray-900 text-white fixed top-0 left-0 shadow-lg">
    <div class="flex items-center justify-center py-6">
        <h1>Hippopo</h1>
    </div>
    <ul class="space-y-2 px-4">
        <li>
            <a href="{{ route('accueil') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
                🏠 <span class="ml-3">Accueil</span>
            </a>
        </li>
        <li>
            <a href="{{ route('poneys.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
                🐴 <span class="ml-3">Poneys</span>
            </a>
        </li>
        <li>
            <a href="{{ route('clients.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
                🧑‍🤝‍🧑 <span class="ml-3">Clients</span>
            </a>
        </li>
        <li>
            <a href="{{ route('rendez-vous.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
                📅 <span class="ml-3">Rendez-vous</span>
            </a>
        </li>
        <li>
            <a href="{{ route('factures.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
                💰 <span class="ml-3">Factures</span>
            </a>
        </li>
        {{-- <li>
            <a href="{{ route('parametres.index') }}" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
                ⚙️ <span class="ml-3">Paramètres</span>
            </a>
        </li> --}}
    </ul>
</nav>
