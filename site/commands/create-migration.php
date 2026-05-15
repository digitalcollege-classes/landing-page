<?php

declare(strict_types=1);

include 'vendor/autoload.php';

// Verifica se a descrição foi fornecida
if ($argc < 2) {
    echo "Erro: É necessário fornecer uma descrição para a migration", PHP_EOL;
    echo PHP_EOL;
    echo "Uso: php create-migration.php \"Descrição da migration\"", PHP_EOL;
    echo "Exemplo: php create-migration.php \"Cria tabela de produtos\"", PHP_EOL;
    exit(1);
}

$description = $argv[1];

// Gera o timestamp no formato usado no projeto: YYYYMMDD_HHMMSS
$timestamp = date('Ymd_His');

// Converte a descrição para snake_case para o nome do arquivo
$descriptionSnakeCase = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '_', $description), '_'));

$className = "Migration{$timestamp}";
$fileName = "{$timestamp}_{$descriptionSnakeCase}.php";
$filePath = __DIR__ . "/../app/Migrations/{$fileName}";

// Verifica se o arquivo já existe
if (file_exists($filePath)) {
    echo "Erro: Migration já existe: {$fileName}", PHP_EOL;
    exit(1);
}

// Template da migration
$template = <<<PHP
<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;
use App\Migrations\Core\MigrationInterface;

class {$className} implements MigrationInterface
{
    public function description(): string
    {
        return "{$description}";
    }

    public function up(): void
    {
        \$sql = "
            -- SQL para aplicar a migration
        ";

        DatabaseConnection::open()->exec(\$sql);
    }

    public function down(): void
    {
        \$sql = "
            -- SQL para reverter a migration
        ";

        DatabaseConnection::open()->exec(\$sql);
    }
}

PHP;

// Cria o arquivo da migration
if (file_put_contents($filePath, $template) === false) {
    echo "Erro ao criar o arquivo da migration", PHP_EOL;
    exit(1);
}

echo "===================================", PHP_EOL;
echo "=== Migration criada com sucesso! ===", PHP_EOL;
echo "===================================", PHP_EOL;
echo PHP_EOL;
echo "Arquivo: app/Migrations/{$fileName}", PHP_EOL;
echo "Classe: {$className}", PHP_EOL;
echo "Descrição: {$description}", PHP_EOL;
echo PHP_EOL;
echo "Próximos passos:", PHP_EOL;
echo "   1. Adicionar o SQL nos métodos up() e down()", PHP_EOL;
echo "   2. Executar: make migrate_up", PHP_EOL;
echo PHP_EOL;
echo "===================================", PHP_EOL;
