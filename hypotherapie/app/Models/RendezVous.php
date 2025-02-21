<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'rendez_vous';

    // Champs autorisés pour l'assignation massive
    protected $fillable = ['client_id', 'poney_id', 'date_heure', 'date_heure_fin', 'nombre_personnes'];

    // protected $dates = ['date_heure'];

    protected $casts = [
        'date_heure' => 'datetime',
        'date_heure_fin' => 'datetime', // ✅ Ajout pour convertir automatiquement en Carbon
    ];

    // Relation avec le modèle Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relation avec le modèle Poney
    public function poney()
    {
        return $this->belongsTo(Poney::class);
    }

    public function poneys()
    {
        return $this->belongsToMany(Poney::class, 'rendez_vous_poney');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class) ?? collect();
    }


}