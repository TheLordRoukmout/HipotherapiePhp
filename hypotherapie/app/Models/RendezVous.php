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
        'date_heure_fin' => 'datetime',
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

    public static function poneyEstDisponible($poney_id, $dateHeureDebut, $dateHeureFin)
    {
        // Vérifie si un rendez-vous existe déjà avec ce poney sur cette plage horaire
        $conflict = self::where('poney_id', $poney_id)
            ->where(function ($query) use ($dateHeureDebut, $dateHeureFin) {
                $query->whereBetween('date_heure', [$dateHeureDebut, $dateHeureFin])
                      ->orWhereBetween('date_heure_fin', [$dateHeureDebut, $dateHeureFin])
                      ->orWhere(function ($q) use ($dateHeureDebut, $dateHeureFin) {
                          $q->where('date_heure', '<=', $dateHeureDebut)
                            ->where('date_heure_fin', '>=', $dateHeureFin);
                      });
            })->exists();
    
        return !$conflict; // Retourne "true" si le poney est DISPONIBLE
    }
    

}