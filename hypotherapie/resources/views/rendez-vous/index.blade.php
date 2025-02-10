<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Rendez-vous</title>
</head>
<body>
    <h1>Liste des Rendez-vous</h1>
    <a href="{{ route('rendez-vous.create') }}">Ajouter un Rendez-vous</a>
    <table border="1">
        <thead>
            <tr>
                <th>Client</th>
                <th>Poney</th>
                <th>Date et Heure</th>
                <th>Nombre de Personnes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rendezVous as $rdv)
            <tr>
                <td>{{ $rdv->client->nom }}</td>
                <td>{{ $rdv->poney->nom }}</td>
                <td>{{ $rdv->date_heure }}</td>
                <td>{{ $rdv->nombre_personnes }}</td>
                <td>
                    <a href="{{ route('rendez-vous.edit', $rdv->id) }}">Modifier</a>
                    <form action="{{ route('rendez-vous.destroy', $rdv->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>