<?php

declare(strict_types=1);

use App\Migrations\Core\MigrationManager;

include 'vendor/autoload.php';

try {
    $manager = new MigrationManager();
    
    echo "===================================", PHP_EOL;
    echo "=== Atualizando schema do banco ===", PHP_EOL;
    echo "===================================", PHP_EOL;
    echo PHP_EOL;
    
    $count = $manager->runPendingMigrations();
    
    if ($count === 0) {
        echo "Nenhuma migration pendente para executar.", PHP_EOL;
        echo PHP_EOL;
    }
    
    echo "===================================", PHP_EOL;
    echo "=== Concluído! ===", PHP_EOL;
    echo "=== {$count} migration(s) executada(s) ===", PHP_EOL;
    echo "===================================", PHP_EOL;
    
} catch (Exception $e) {
    echo PHP_EOL;
    echo "===================================", PHP_EOL;
    echo "=== Erro ao executar migrations ===", PHP_EOL;
    echo "===================================", PHP_EOL;
    echo $e->getMessage(), PHP_EOL;
    exit(1);
}