<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class CustomMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations with custom maintenance page';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Activation du mode maintenance...');
        
        // Créer le fichier de maintenance personnalisé
        $maintenanceView = View::make('vendor.maintenance.index')->render();
        File::put(public_path('maintenance.html'), $maintenanceView);
        
        // Activer le mode maintenance
        File::put(storage_path('framework/down'), json_encode([
            'time' => time(),
            'message' => 'Mise à jour du système en cours',
            'retry' => 60,
        ]));
        
        $this->info('Exécution des migrations...');
        
        try {
            // Exécuter les migrations
            $exitCode = Artisan::call('migrate', ['--force' => true]);
            
            if ($exitCode === 0) {
                $this->info('Migrations exécutées avec succès !');
            } else {
                $this->error('Erreur lors de l\'exécution des migrations');
            }
            
            return $exitCode;
            
        } catch (\Exception $e) {
            $this->error('Erreur: ' . $e->getMessage());
            return 1;
        } finally {
            // Désactiver le mode maintenance
            File::delete(storage_path('framework/down'));
            File::delete(public_path('maintenance.html'));
            $this->info('Mode maintenance désactivé');
        }
    }
}
