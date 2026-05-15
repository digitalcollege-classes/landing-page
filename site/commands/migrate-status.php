<?php

declare(strict_types=1);

use App\Migrations\Core\MigrationManager;

include 'vendor/autoload.php';

try {
    $manager = new MigrationManager();
    $manager->showStatus();
    
} catch (Exception $e) {
    echo "===================================", PHP_EOL;
    echo "=== Erro ao verificar status ===", PHP_EOL;
    echo "===================================", PHP_EOL;
    echo $e->getMessage(), PHP_EOL;
    exit(1);
}
