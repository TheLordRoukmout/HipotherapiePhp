<script src="https://cdn.tailwindcss.com"></script>
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🐴 Liste des Poneys</h1>

    <div class="mb-4">
        <a href="{{ route('poneys.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
            ➕ Ajouter un Poney
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-center">Temps de travail max (h)</th>
                    <th class="px-4 py-3 text-center">Temps travaillé aujourd'hui (h)</th>
                    <th class="px-4 py-3 text-center">Temps restant (h)</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($poneys as $poney)
                @php
                    $tempsTravailUtilise = isset($rendezVous[$poney->id])
                        ? collect($rendezVous[$poney->id])->sum(fn($rdv) => 
                            \Carbon\Carbon::parse($rdv->date_heure)->diffInHours(\Carbon\Carbon::parse($rdv->date_heure_fin)))
                        : 0;

                    $tempsRestant = max(0, $poney->temps_travail - $tempsTravailUtilise);
                    $bgColor = $tempsRestant == 0 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600';
                @endphp

                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $poney->nom }}</td>
                    <td class="px-4 py-3 text-center">{{ $poney->temps_travail }}h</td>
                    <td class="px-4 py-3 text-center">{{ $tempsTravailUtilise }}h</td>
                    <td class="px-4 py-3 text-center {{ $bgColor }} font-semibold rounded-md">
                        {{ $tempsRestant }}h
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('poneys.edit', $poney) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            ✏ Modifier
                        </a>
                        <form action="{{ route('poneys.destroy', $poney) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                🗑 Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
