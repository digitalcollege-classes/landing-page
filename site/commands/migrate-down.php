<?php

declare(strict_types=1);

use App\Migrations\Core\MigrationManager;

include 'vendor/autoload.php';

try {
    $manager = new MigrationManager();
    
    // Verifica se foi passado um argumento para número de steps
    $steps = isset($argv[1]) ? (int)$argv[1] : 1;
    
    echo "===================================", PHP_EOL;
    echo "=== Revertendo schema do banco ===", PHP_EOL;
    echo "===================================", PHP_EOL;
    echo PHP_EOL;
    
    if ($steps === 0) {
        // Rollback de todas as migrations
        echo "Revertendo TODAS as migrations...", PHP_EOL;
        echo PHP_EOL;
        $count = $manager->rollbackAll();
    } else {
        // Rollback de N migrations
        echo "Revertendo {$steps} migration(s)...", PHP_EOL;
        echo PHP_EOL;
        $count = $manager->rollback($steps);
    }
    
    if ($count === 0) {
        echo "Nenhuma migration para reverter.", PHP_EOL;
        echo PHP_EOL;
    }
    
    echo "===================================", PHP_EOL;
    echo "=== Concluído! ===", PHP_EOL;
    echo "=== {$count} migration(s) revertida(s) ===", PHP_EOL;
    echo "===================================", PHP_EOL;
    
} catch (Exception $e) {
    echo PHP_EOL;
    echo "===================================", PHP_EOL;
    echo "=== Erro ao reverter migrations ===", PHP_EOL;
    echo "===================================", PHP_EOL;
    echo $e->getMessage(), PHP_EOL;
    exit(1);
}