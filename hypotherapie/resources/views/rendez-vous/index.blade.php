<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Rendez-vous</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }
        .btn-primary {
            background-color: #007bff; /* Bleu */
        }
        .btn-warning {
            background-color: #ffc107; /* Jaune */
        }
        .btn-danger {
            background-color: #dc3545; /* Rouge */
        }
        .btn-info{
            background-color:rgb(28, 90, 17); /* Rouge */  
        }
        .btn:hover {
            opacity: 0.8;
        }
        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
@extends('layouts.app')
@section('content')
    <h1>Liste des Rendez-vous</h1>
    <a href="{{ route('rendez-vous.create') }}" class="btn btn-primary">Ajouter un Rendez-vous</a>

    <!-- Section Rendez-vous passés -->
    <h2>Rendez-vous passés</h2>
    @if($rendezVousPasses->isEmpty())
        <p>Aucun rendez-vous passé.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Nombre de Personnes</th>
                    <th>Horaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rendezVousPasses as $rdv)
                    <tr>
                        <td>{{ $rdv->client->nom }}</td>
                        <td>{{ $rdv->nombre_personnes }}</td>
                        <td>
                            {{ $rdv->date_heure->format('d/m/Y H:i') }} <!-- Affiche la date et l'heure -->
                        </td>
                        <td>
                            <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('rendez-vous.destroy', $rdv->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Section Rendez-vous d'aujourd'hui -->
    <h2>Rendez-vous d'aujourd'hui</h2>
    <div>
        Nombre de poneys disponibles : {{ $poneysDisponibles }}
    </div>
    @if($rendezVousAujourdhui->isEmpty())
        <p>Aucun rendez-vous aujourd'hui.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Nombre de Personnes</th>
                    <th>Horaire</th>
                    <th>Noms du poney</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rendezVousAujourdhui as $rdv)
                    <tr>
                        <td>{{ $rdv->client->nom }}</td>
                        <td>{{ $rdv->nombre_personnes }}</td>
                        <td>
                            {{ $rdv->date_heure->format('d/m/Y H:i') }} - {{ $rdv->date_heure_fin->format('H:i') }}
                        </td>
                        <td>{{ $rdv->poney->nom }}</td>
                        <td>
                            <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('rendez-vous.destroy', $rdv->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">Supprimer</button>
                                <a href="{{ route('rendez-vous.attribuer', $rdv->id) }}" class="btn btn-info">Attribuer un Poney</a>
                            </form>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Section Rendez-vous futurs -->
    <h2>Rendez-vous futurs</h2>
    @if($rendezVousFuturs->isEmpty())
        <p>Aucun rendez-vous futur.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Nombre de Personnes</th>
                    <th>Horaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rendezVousFuturs as $rdv)
                    <tr>
                        <td>{{ $rdv->client->nom }}</td>
                        <td>{{ $rdv->nombre_personnes }}</td>
                        <td>
                            {{ $rdv->date_heure->format('d/m/Y H:i') }} <!-- Affiche la date et l'heure -->
                        </td>
                        <td>
                            <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('rendez-vous.destroy', $rdv->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
</body>
</html>