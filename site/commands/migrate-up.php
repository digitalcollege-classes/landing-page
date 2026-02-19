<?php

use App\Migrations\MigrationV20260203_200101;
use App\Migrations\MigrationV20260204_072309;
use App\Migrations\MigrationV20260219_000001;
use App\Migrations\MigrationV20260219_000002;
use App\Migrations\MigrationV20260219_000003;

include 'vendor/autoload.php';

$migrations = [
    MigrationV20260203_200101::class,
    MigrationV20260204_072309::class,
    MigrationV20260219_000001::class,
    MigrationV20260219_000002::class,
    MigrationV20260219_000003::class,
];

echo "===================================",PHP_EOL;
echo "=== Atualizando schema do banco ===",PHP_EOL;
echo "===================================",PHP_EOL;

foreach ($migrations as $migrationName) {
    $migration = new $migrationName();

    $migration->up();

    echo "--- ",$migration->description(),"✅",PHP_EOL;
}