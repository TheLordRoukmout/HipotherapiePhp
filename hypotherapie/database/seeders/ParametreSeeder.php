<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parametre;

class ParametreSeeder extends Seeder
{
    public function run()
    {
        Parametre::updateOrCreate(['cle' => 'heure_par_personne'], ['valeur' => 2]);
        Parametre::updateOrCreate(['cle' => 'prix_par_personne'], ['valeur' => 15]);
    }
}
