<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'montant', 'date_facture'];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function setMontantAttribute($value)
    {
        $this->attributes['montant'] = abs($value); // Montant toujours positif
    }


}