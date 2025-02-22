<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['rendez_vous_id', 'nom', 'poney_id']; // Ajout de rendez_vous_id

    // Relation avec RendezVous
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    // Relation avec Poney
    public function poney()
    {
        return $this->belongsTo(Poney::class);
    }
}
