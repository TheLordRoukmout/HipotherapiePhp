<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📅 Liste des Rendez-vous</h1>

    <!-- Bouton Ajouter un Rendez-vous -->
    <div class="mb-4">
        <a href="{{ route('rendez-vous.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
            ➕ Ajouter un Rendez-vous
        </a>
    </div>

    <!-- Section Rendez-vous Passés -->
    <h2 class="text-xl font-semibold text-gray-700 mb-3">🔴 Rendez-vous passés</h2>
    @if($rendezVousPasses->isEmpty())
        <p class="text-gray-500">Aucun rendez-vous passé.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-center">Personnes</th>
                        <th class="px-4 py-3 text-center">Horaire</th>
                        <!-- <th class="px-4 py-3 text-center">Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($rendezVousPasses as $rdv)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $rdv->client->nom }}</td>
                        <td class="px-4 py-3 text-center">{{ $rdv->nombre_personnes }}</td>
                        <td class="px-4 py-3 text-center">{{ $rdv->date_heure->format('d/m/Y H:i') }}</td>
                        <!-- <td class="px-4 py-3 text-center space-x-2">
                            <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">✏ Modifier</a>
                            <form action="{{ route('rendez-vous.destroy', $rdv->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">🗑 Supprimer</button>
                            </form>
                        </td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Section Rendez-vous d'Aujourd'hui -->
    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-3">🟢 Rendez-vous aujourd'hui</h2>
    <p class="text-gray-600">Nombre de poneys disponibles : <span class="font-bold">{{ $poneysDisponibles }}</span></p>
    @if($rendezVousAujourdhui->isEmpty())
        <p class="text-gray-500">Aucun rendez-vous aujourd'hui.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-center">Personnes</th>
                        <th class="px-4 py-3 text-center">Horaire</th>
                        <th class="px-4 py-3 text-center">Poney</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rendezVousAujourdhui as $rdv)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $rdv->client->nom }}</td>
                        <td class="px-4 py-3 text-center">{{ $rdv->nombre_personnes }}</td>
                        <td class="px-4 py-3 text-center">{{ $rdv->date_heure->format('d/m/Y H:i') }} - {{ $rdv->date_heure_fin->format('H:i') }}</td>
                        <td class="px-4 py-3 text-center">{{ $rdv->poney->nom }}</td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">✏ Modifier</a>
                            <form action="{{ route('rendez-vous.destroy', $rdv->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">🗑 Supprimer</button>
                            </form>
                            <a href="{{ route('rendez-vous.attribuer', $rdv->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">🐴 Attribuer un Poney</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Section Rendez-vous Futurs -->
    <h2 class="text-xl font-semibold text-gray-700 mt-6 mb-3">🟡 Rendez-vous futurs</h2>
    @if($rendezVousFuturs->isEmpty())
        <p class="text-gray-500">Aucun rendez-vous futur.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="w-full border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-center">Personnes</th>
                        <th class="px-4 py-3 text-center">Horaire</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rendezVousFuturs as $rdv)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $rdv->client->nom }}</td>
                        <td class="px-4 py-3 text-center">{{ $rdv->nombre_personnes }}</td>
                        <td class="px-4 py-3 text-center">{{ $rdv->date_heure->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">✏ Modifier</a>
                            <form action="{{ route('rendez-vous.destroy', $rdv->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">🗑 Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
