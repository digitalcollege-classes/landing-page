<?php

declare(strict_types=1);

class Usuario
{
    public string $nome;
    public string $email;
    public string $endereco;

    public static function all(): array
    {
        // vai buscar no banco (no futuro)

        $usuarios = [
            [
                'id' => 1,
                'nome' => 'Chiquim',
                'email' => 'chiquim@email.com',
                'endereco' => 'Rua das Taquaras, 123 - Alameda dos Anjos',
            ],
            [
                'id' => 42,
                'nome' => 'Mariazinha',
                'email' => 'mariazinha@email.com',
                'endereco' => 'Rua das Taquaras, 123 - Alameda dos Anjos',
            ],
        ];

        return $usuarios;
    }
}

