<?php

declare(strict_types=1);

namespace App\Migrations\Core;

use App\Connection\DatabaseConnection;
use PDO;

class MigrationManager
{
    private const MIGRATIONS_TABLE = 'migrations';
    
    private PDO $pdo;
    private string $migrationsPath;
    
    public function __construct()
    {
        $this->pdo = DatabaseConnection::open();
        // Define o caminho como a pasta pai (Migrations)
        $this->migrationsPath = dirname(__DIR__);
        $this->ensureMigrationsTableExists();
    }
    
    /**
     * Cria a tabela de controle de migrations se não existir
     */
    private function ensureMigrationsTableExists(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS " . self::MIGRATIONS_TABLE . " (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL UNIQUE,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_migration (migration)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ";
        
        $this->pdo->exec($sql);
    }
    
    /**
     * Descobre todas as migrations disponíveis na pasta
     */
    public function discoverMigrations(): array
    {
        $migrations = [];
        
        // Busca arquivos com padrão novo: {timestamp}_{description}.php
        $newPatternFiles = glob($this->migrationsPath . '/[0-9]*_*.php');
        
        // Busca arquivos com padrão antigo: MigrationV{timestamp}.php
        $oldPatternFiles = glob($this->migrationsPath . '/MigrationV*.php');
        
        // Combina ambos os padrões
        $files = array_merge($newPatternFiles, $oldPatternFiles);
        
        foreach ($files as $file) {
            $fileNameWithExt = basename($file);
            $fileNameWithoutExt = basename($file, '.php');
            
            // Ignora a interface e o manager
            if (in_array($fileNameWithoutExt, ['MigrationInterface', 'MigrationManager'])) {
                continue;
            }
            
            // Tenta identificar o padrão do arquivo
            if (preg_match('/^(\d{8}_\d{6})_(.+)$/', $fileNameWithoutExt, $matches)) {
                // Padrão novo: {timestamp}_{description}.php
                $timestamp = $matches[1];
                $className = "Migration{$timestamp}";
                $migrationKey = $fileNameWithoutExt; // Usa o nome completo como chave
            } elseif (preg_match('/^MigrationV(\d{8}_\d{6})$/', $fileNameWithoutExt, $matches)) {
                // Padrão antigo: MigrationV{timestamp}.php
                $className = $fileNameWithoutExt;
                $migrationKey = $fileNameWithoutExt;
            } else {
                continue; // Arquivo não segue nenhum padrão conhecido
            }
            
            $fullClassName = "App\\Migrations\\{$className}";
            
            // Tenta carregar via autoload primeiro
            if (!class_exists($fullClassName)) {
                // Se não existe, faz require manual (necessário para padrão novo)
                require_once $file;
            }
            
            if (class_exists($fullClassName)) {
                $migrations[$migrationKey] = $fullClassName;
            }
        }
        
        // Ordena por chave (que contém timestamp)
        ksort($migrations);
        
        return $migrations;
    }
    
    /**
     * Retorna as migrations que já foram executadas
     */
    public function getExecutedMigrations(): array
    {
        $stmt = $this->pdo->query(
            "SELECT migration FROM " . self::MIGRATIONS_TABLE . " ORDER BY migration"
        );
        
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Retorna as migrations pendentes (ainda não executadas)
     */
    public function getPendingMigrations(): array
    {
        $allMigrations = $this->discoverMigrations();
        $executedMigrations = $this->getExecutedMigrations();
        
        $pending = [];
        foreach ($allMigrations as $name => $class) {
            if (!in_array($name, $executedMigrations)) {
                $pending[$name] = $class;
            }
        }
        
        return $pending;
    }
    
    /**
     * Registra uma migration como executada
     */
    public function markAsExecuted(string $migrationName): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT IGNORE INTO " . self::MIGRATIONS_TABLE . " (migration) VALUES (:migration)"
        );
        
        $stmt->execute(['migration' => $migrationName]);
    }
    
    /**
     * Remove o registro de uma migration (para rollback)
     */
    public function markAsReverted(string $migrationName): void
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM " . self::MIGRATIONS_TABLE . " WHERE migration = :migration"
        );
        
        $stmt->execute(['migration' => $migrationName]);
    }
    
    /**
     * Executa todas as migrations pendentes
     */
    public function runPendingMigrations(): int
    {
        $pending = $this->getPendingMigrations();
        
        if (empty($pending)) {
            return 0;
        }
        
        $count = 0;
        foreach ($pending as $name => $class) {
            $migration = new $class();
            
            echo "🔄 Executando: {$migration->description()}", PHP_EOL;
            
            try {
                $this->pdo->beginTransaction();
                
                $migration->up();
                $this->markAsExecuted($name);
                
                $this->pdo->commit();
                
                echo "   ✅ {$name}", PHP_EOL;
                $count++;
            } catch (\Exception $e) {
                $this->pdo->rollBack();
                echo "   ❌ Erro: {$e->getMessage()}", PHP_EOL;
                throw $e;
            }
            
            echo PHP_EOL;
        }
        
        return $count;
    }
    
    /**
     * Reverte a última migration executada
     */
    public function rollbackLastMigration(): bool
    {
        $executedMigrations = $this->getExecutedMigrations();
        
        if (empty($executedMigrations)) {
            return false;
        }
        
        // Pega a última migration executada
        $lastMigration = end($executedMigrations);
        $allMigrations = $this->discoverMigrations();
        
        if (!isset($allMigrations[$lastMigration])) {
            echo "❌ Migration não encontrada: {$lastMigration}", PHP_EOL;
            return false;
        }
        
        $class = $allMigrations[$lastMigration];
        $migration = new $class();
        
        echo "🔄 Revertendo: {$migration->description()}", PHP_EOL;
        
        try {
            $this->pdo->beginTransaction();
            
            $migration->down();
            $this->markAsReverted($lastMigration);
            
            $this->pdo->commit();
            
            echo "   ✅ {$lastMigration}", PHP_EOL;
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            echo "   ❌ Erro: {$e->getMessage()}", PHP_EOL;
            throw $e;
        }
    }
    
    /**
     * Reverte um número específico de migrations
     */
    public function rollback(int $steps = 1): int
    {
        $count = 0;
        
        for ($i = 0; $i < $steps; $i++) {
            if ($this->rollbackLastMigration()) {
                $count++;
                echo PHP_EOL;
            } else {
                break;
            }
        }
        
        return $count;
    }
    
    /**
     * Reverte todas as migrations
     */
    public function rollbackAll(): int
    {
        $executedMigrations = $this->getExecutedMigrations();
        return $this->rollback(count($executedMigrations));
    }
    
    /**
     * Exibe o status de todas as migrations
     */
    public function showStatus(): void
    {
        $allMigrations = $this->discoverMigrations();
        $executedMigrations = $this->getExecutedMigrations();
        
        echo "===================================", PHP_EOL;
        echo "=== Status das Migrations ===", PHP_EOL;
        echo "===================================", PHP_EOL;
        echo PHP_EOL;
        
        if (empty($allMigrations)) {
            echo "Nenhuma migration encontrada.", PHP_EOL;
            return;
        }
        
        foreach ($allMigrations as $name => $class) {
            $migration = new $class();
            $isExecuted = in_array($name, $executedMigrations);
            $status = $isExecuted ? "✅ Executada" : "⏳ Pendente";
            
            // Formata o nome do arquivo de forma mais legível
            $displayName = str_replace('_', ' ', $name);
            
            echo "{$status} | {$displayName}", PHP_EOL;
            echo "           {$migration->description()}", PHP_EOL;
            echo PHP_EOL;
        }
        
        $totalExecuted = count($executedMigrations);
        $totalPending = count($allMigrations) - $totalExecuted;
        
        echo "-----------------------------------", PHP_EOL;
        echo "Total: " . count($allMigrations) . " migrations", PHP_EOL;
        echo "Executadas: {$totalExecuted}", PHP_EOL;
        echo "Pendentes: {$totalPending}", PHP_EOL;
        echo "===================================", PHP_EOL;
    }
}
