<?php

use App\Migrations\MigrationV20260203_200101;
use App\Migrations\MigrationV20260204_072309;
use App\Migrations\MigrationV20260218_222902;

include 'vendor/autoload.php';

$migrations = [
    MigrationV20260203_200101::class,
    MigrationV20260204_072309::class,
    MigrationV20260218_222902::class,
];

echo "===================================", PHP_EOL;
echo "=== Atualizando schema do banco ===", PHP_EOL;
echo "===================================", PHP_EOL;

foreach ($migrations as $migrationName) {
    $migration = new $migrationName();

    $migration->up();

    echo "--- ", $migration->description(), "✅", PHP_EOL;
}