<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Poneys</title>
</head>
<body>
    <h1>Liste des Poneys</h1>
    <a href="{{ route('poneys.create') }}">Ajouter un Poney</a>
    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Temps de travail (heures)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($poneys as $poney)
            <tr>
                <td>{{ $poney->nom }}</td>
                <td>{{ $poney->temps_travail }}</td>
                <td>
                    <a href="{{ route('poneys.edit', $poney) }}">Modifier</a>
                    <form action="{{ route('poneys.destroy', $poney) }}" method="POST" style="display:inline;">
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