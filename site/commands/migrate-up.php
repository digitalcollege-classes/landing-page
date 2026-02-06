<?php

require_once 'vendor/autoload.php';

$migrationPath = 'app/Migrations/';
$historyFile = 'migrations_applied.json'; 

// Gera arquivo arquivo json, se não existir.
if (!file_exists($historyFile)) {
    file_put_contents($historyFile, json_encode([]));
}

// Lê o arquivo do histórico
$applied = json_decode(file_get_contents($historyFile), true);
if (!is_array($applied)) $applied = [];

// Busca arquivos de migração
$allFiles = glob($migrationPath . '*.php');
$migrationFiles = array_filter($allFiles, function ($file) {
    return !str_contains($file, 'Interface.php');
});

// Diff entre as migrações disponíveis e as aplicadas
$toApply = array_filter($migrationFiles, function ($file) use ($applied) {
    return !in_array($file, $applied);
});

echo "===================================", PHP_EOL;
echo "=== Atualizando schema do banco ===", PHP_EOL;
echo "===================================", PHP_EOL;

if (empty($toApply)) {
    echo "Banco atualizado!", PHP_EOL;
    exit;
}

foreach ($toApply as $file) {
    // Extrai o nome da classe a partir do nome do arquivo
    $className = pathinfo($file, PATHINFO_FILENAME);
    echo "Aplicando: $className... ",PHP_EOL;

    try {
        // Inclui e instancia a classe
        require_once $file;
        $fullClassName = "App\\Migrations\\$className";
        
        if (!class_exists($fullClassName)) {
            throw new Exception("Classe $fullClassName não encontrada no arquivo.");
        }

        $migration = new $fullClassName();
        
        // Executa a migração
        $migration->up();

        // 5. Atualiza o histórico e salva o JSON imediatamente
        $applied[] = $file;
        file_put_contents($historyFile, json_encode($applied, JSON_PRETTY_PRINT));

        if (method_exists($migration, 'description')) {
            echo "--- Description: " . $migration->description() . "Sucesso! ✅", PHP_EOL;
        }

    } catch (Exception $e) {
        echo "ERRO! ❌", PHP_EOL;
        echo "Motivo: " . $e->getMessage() . PHP_EOL;
        exit(1);
    }
}