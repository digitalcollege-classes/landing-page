<?php

use App\Migrations\MigrationV20260203_200101;
use App\Migrations\MigrationV20260204_072309;

include 'vendor/autoload.php';

$migrations = [
    MigrationV20260203_200101::class,
    MigrationV20260204_072309::class,
];

foreach ($migrations as $migration) {
    (new $migration)->down();
}