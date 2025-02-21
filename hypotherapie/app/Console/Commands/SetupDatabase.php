<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SetupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer la base de données si elle n\'existe pas et exécuter les migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');

        // Se connecter sans spécifier la base
        $defaultConnection = Config::get('database.connections.mysql');
        $defaultConnection['database'] = null;

        Config::set('database.connections.temp', $defaultConnection);

        try {
            // Vérifier si la base existe
            $exists = DB::connection('temp')->select("SHOW DATABASES LIKE '$database'");


            if (empty($exists)) {
                // Créer la base
                DB::connection('temp')->statement("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                $this->info("Base de données `$database` créée avec succès.");
            } else {
                $this->info("La base de données `$database` existe déjà.");
            }

            // Exécuter les migrations après la création de la base
            $this->call('migrate', ['--seed' => true]);
        } catch (\Exception $e) {
            $this->error("Erreur : " . $e->getMessage());
        }
    }
}
