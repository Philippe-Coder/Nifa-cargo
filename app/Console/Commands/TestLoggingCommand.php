<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DemandeLoggingService;
use Illuminate\Support\Facades\Log;
use Exception;

class TestLoggingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:logging';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester le système de logging de NIF CARGO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Test du système de logging NIF CARGO...');
        
        // Test 1: Log de création
        $this->info('📝 Test 1: Log de création de demande');
        DemandeLoggingService::logCreation([
            'type' => 'maritime',
            'origine' => 'Test Origine',
            'destination' => 'Test Destination'
        ], 1, true);
        
        // Test 2: Log d'erreur de validation
        $this->info('⚠️  Test 2: Log d\'erreur de validation');
        DemandeLoggingService::logValidationError([
            'email' => ['Email invalide'],
            'poids' => ['Poids requis']
        ], ['email' => 'invalid-email'], 'TEST_VALIDATION');
        
        // Test 3: Log d'erreur de base de données simulée
        $this->info('💥 Test 3: Log d\'erreur de base de données');
        try {
            throw new Exception('Test database error simulation');
        } catch (Exception $e) {
            $errorId = DemandeLoggingService::logDatabaseError($e, [
                'operation' => 'test'
            ], 'TEST_DB_ERROR');
            $this->info("   Code d'erreur généré: {$errorId}");
        }
        
        // Test 4: Log d'accès non autorisé
        $this->info('🔒 Test 4: Log d\'accès non autorisé');
        DemandeLoggingService::logUnauthorizedAccess(123, 'TEST_UNAUTHORIZED');
        
        // Test 5: Vérifier les canaux de logging
        $this->info('📊 Test 5: Test des canaux de logging individuels');
        Log::channel('database')->error('Test log database channel');
        Log::channel('validation')->warning('Test log validation channel');
        Log::channel('security')->warning('Test log security channel');
        Log::channel('demandes')->info('Test log demandes channel');
        Log::channel('application')->error('Test log application channel');
        
        $this->info('✅ Tests de logging terminés !');
        $this->info('📁 Vérifiez les fichiers de logs dans storage/logs/');
        
        // Lister les fichiers de logs créés
        $logPath = storage_path('logs');
        $logFiles = glob($logPath . '/*.log');
        
        if ($logFiles) {
            $this->info('📋 Fichiers de logs créés:');
            foreach ($logFiles as $file) {
                $fileName = basename($file);
                $size = filesize($file);
                $this->line("   - {$fileName} ({$size} bytes)");
            }
        } else {
            $this->warn('⚠️  Aucun fichier de log trouvé dans storage/logs/');
        }
        
        return 0;
    }
}
