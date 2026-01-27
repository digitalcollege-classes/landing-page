<?php

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dbPath = __DIR__ . '/database.sqlite';
            self::$instance = new PDO("sqlite:{$dbPath}");
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::createTables();
        }

        return self::$instance;
    }

    private static function createTables(): void
    {
        self::$instance->exec("
            CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL,
                senha TEXT NOT NULL,
                criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        self::$instance->exec("
            CREATE TABLE IF NOT EXISTS palestrantes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL,
                tema TEXT NOT NULL,
                bio TEXT,
                criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
}
