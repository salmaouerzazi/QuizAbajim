<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateTestNotification extends Command
{
    protected $signature = 'notifications:test';
    protected $description = 'Crée une notification de test pour déboguer';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Création d\'une notification de test...');
        
        // 1. Vérifier si la table existe
        try {
            $tables = DB::select('SHOW TABLES LIKE "quiz_notifications_users"');
            if (empty($tables)) {
                $this->error('La table quiz_notifications_users n\'existe pas!');
                return 1;
            }
            $this->info('Table quiz_notifications_users trouvée.');
            
            // 2. Vérifier la structure de la table
            $columns = DB::select('SHOW COLUMNS FROM quiz_notifications_users');
            $this->info('Structure de la table: ' . json_encode($columns));
            
            // 3. Obtenir les IDs de notification existants
            $notifications = DB::select('SELECT id FROM quiz_notifications ORDER BY id DESC LIMIT 1');
            
            if (empty($notifications)) {
                $this->error('Aucune notification principale trouvée. Création d\'une notification de test...');
                DB::table('quiz_notifications')->insert([
                    'title' => 'Notification de test',
                    'message' => 'Ceci est une notification de test',
                    'sender_type' => 'admin',
                    'sender_id' => 1,
                    'target_type' => 'multiple',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $notificationId = DB::getPdo()->lastInsertId();
            } else {
                $notificationId = $notifications[0]->id;
            }
            $this->info('Utilisation de la notification ID: ' . $notificationId);
            
            // 4. Obtenir les IDs d'utilisateurs enfants
            $children = DB::select('SELECT id FROM users WHERE role = "child" LIMIT 5');
            if (empty($children)) {
                $this->error('Aucun utilisateur enfant trouvé!');
                return 1;
            }
            
            // 5. Créer des notifications pour chaque enfant
            foreach ($children as $child) {
                $childId = $child->id;
                try {
                    // Essayer d'insérer avec SQL brut
                    $sql = "INSERT INTO quiz_notifications_users 
                           (notification_id, receiver_id, is_read, created_at, updated_at) 
                           VALUES ($notificationId, $childId, 0, NOW(), NOW())";
                    
                    $this->info("Exécution: $sql");
                    DB::unprepared($sql);
                    $this->info("Notification créée pour l'enfant ID: $childId");
                } catch (\Exception $e) {
                    $this->error("Erreur lors de la création de notification pour l'enfant $childId: " . $e->getMessage());
                }
            }
            
            $this->info('Commande exécutée avec succès!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Erreur: ' . $e->getMessage());
            return 1;
        }
    }
}
