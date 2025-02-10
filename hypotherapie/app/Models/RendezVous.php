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
    protected $fillable = ['client_id', 'poney_id', 'date_heure', 'nombre_personnes'];

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
}