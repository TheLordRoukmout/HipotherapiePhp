<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poney extends Model
{
    use HasFactory;

    // Champs autorisés pour l'assignation massive
    protected $fillable = ['nom', 'temps_travail'];

    // Relation avec le modèle RendezVous
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
        return $this->belongsToMany(RendezVous::class, 'rendez_vous_poney');
    }
}