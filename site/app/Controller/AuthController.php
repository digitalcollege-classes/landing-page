<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\Usuario;

class AuthController extends AbstractController {

    public function login(): void
    { 
        
        if($_POST) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user =  new Usuario();
            $result = $user->find($email);
            if($result["password"] == $password)
            {
                session_start();
                $_SESSION["user_id"] = $result["id"];
                $_SESSION["user_role"] = "admin";
                echo '<script type="text/javascript">';
                echo 'window.location.href="../usuarios/listar";';
                echo '</script>';
                die();
            } else {
                echo 'Credenciais Inválidas, tente novamente!';
            }
            
            }
        $this->view('auth/login');
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];


        session_destroy();

        echo '<script type="text/javascript">';
        echo 'window.location.href="/admin/auth/login";';
        echo '</script>';
        die();
    }
}