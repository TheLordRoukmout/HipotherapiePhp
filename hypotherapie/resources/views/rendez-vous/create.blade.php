<form action="{{ route('rendez-vous.store') }}" method="POST">
        @csrf

        <div>
            <label for="client_id">Client :</label>
            <select name="client_id" id="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                @endforeach
            </select>
            @error('client_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="poney_id">Poney :</label>
            <select name="poney_id" id="poney_id" required>
                @foreach($poneys as $poney)
                    <option value="{{ $poney->id }}" {{ old('poney_id') == $poney->id ? 'selected' : '' }}>
                        {{ $poney->nom }}
                    </option>
                @endforeach
            </select>
            @error('poney_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="date">Date :</label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" required>
            @error('date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="heure_debut">Heure de début :</label>
            <input type="time" name="heure_debut" id="heure_debut" value="{{ old('heure_debut') }}" required>
            @error('heure_debut')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="heure_fin">Heure de fin :</label>
            <input type="time" name="heure_fin" id="heure_fin" value="{{ old('heure_fin') }}" required>
            @error('heure_fin')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="nombre_personnes">Nombre de personnes :</label>
            <input type="number" name="nombre_personnes" id="nombre_personnes" value="{{ old('nombre_personnes') }}" required>
            @error('nombre_personnes')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Créer le rendez-vous</button>
    </form>