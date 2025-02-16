<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Champs autorisés pour l'assignation massive
    protected $fillable = ['nom', 'email', 'telephone'];

    // Relation avec le modèle RendezVous
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    public function factures(){
        return $this->hasMany(Facture::class);
    }
}