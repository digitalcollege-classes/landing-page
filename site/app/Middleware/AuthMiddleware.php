<?php

namespace App\Middleware;

class AuthMiddleware extends AbstractMiddleware
{
    public function handle(array $request): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401); 
            echo json_encode(['error' => 'Voce precisa estar logado.']);
            exit; 
        }

        return parent::handle($request);
    }
}