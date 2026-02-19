<?php

namespace App\Middleware;

class RoleMiddleware extends AbstractMiddleware
{
    private string $requiredRole;

    public function __construct(string $role)
    {
        $this->requiredRole = $role;
    }

    public function handle(array $request): bool
    {
        
        $userRole = $_SESSION['user_role'] ?? 'user';

        if ($userRole !== $this->requiredRole) {
            http_response_code(403); 
            echo json_encode(['error' => 'Acesso negado: Permissão insuficiente.']);
            exit;
        }

        return parent::handle($request);
    }
}