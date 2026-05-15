<?php

declare(strict_types=1);

namespace App\Migrations\Core;

interface MigrationInterface
{
    public function description(): string;

    public function up(): void;

    public function down(): void;
}
