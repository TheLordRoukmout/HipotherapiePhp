<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>
</head>
<body>
    <h1>Liste des Clients</h1>
    <a href="{{ route('clients.create') }}">Ajouter un Client</a>
    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $client->nom }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->telephone }}</td>
                <td>
                    <a href="{{ route('clients.edit', $client->id) }}">Modifier</a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
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