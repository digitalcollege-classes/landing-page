<?php

declare(strict_types=1);

class UsuarioController extends AbstractController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function add(?string $id = null): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = trim($_POST["nome"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $senha = $_POST["senha"] ?? "";

            $erros = [];
            if ($nome === "") {
                $erros[] = "O nome é obrigatório.";
            }
            if ($email === "") {
                $erros[] = "O email é obrigatório.";
            }
            if ($senha === "") {
                $erros[] = "A senha é obrigatória.";
            }

            if (empty($erros)) {
                $stmt = $this->db->prepare(
                    "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)",
                );
                $stmt->execute([
                    "nome" => $nome,
                    "email" => $email,
                    "senha" => password_hash($senha, PASSWORD_DEFAULT),
                ]);
                $this->redirect("/admin/usuarios/listar");
                return;
            }

            $this->view("usuarios/add", compact("erros", "nome", "email"));
            return;
        }

        $nome = "";
        $email = "";
        $erros = [];
        $this->view("usuarios/add", compact("erros", "nome", "email"));
    }

    public function edit(?string $id = null): void
    {
        if ($id === null) {
            $this->redirect("/admin/usuarios/listar");
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $usuario = $stmt->fetch();

        if (!$usuario) {
            $this->redirect("/admin/usuarios/listar");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = trim($_POST["nome"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $senha = $_POST["senha"] ?? "";

            $erros = [];
            if ($nome === "") {
                $erros[] = "O nome é obrigatório.";
            }
            if ($email === "") {
                $erros[] = "O email é obrigatório.";
            }

            if (empty($erros)) {
                if ($senha !== "") {
                    $stmt = $this->db->prepare(
                        "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id",
                    );
                    $stmt->execute([
                        "nome" => $nome,
                        "email" => $email,
                        "senha" => password_hash($senha, PASSWORD_DEFAULT),
                        "id" => $id,
                    ]);
                } else {
                    $stmt = $this->db->prepare(
                        "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id",
                    );
                    $stmt->execute([
                        "nome" => $nome,
                        "email" => $email,
                        "id" => $id,
                    ]);
                }
                $this->redirect("/admin/usuarios/listar");
                return;
            }

            $usuario["nome"] = $nome;
            $usuario["email"] = $email;
            $this->view("usuarios/edit", compact("erros", "usuario"));
            return;
        }

        $erros = [];
        $this->view("usuarios/edit", compact("erros", "usuario"));
    }

    public function delete(?string $id = null): void
    {
        if ($id === null) {
            $this->redirect("/admin/usuarios/listar");
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $usuario = $stmt->fetch();

        if (!$usuario) {
            $this->redirect("/admin/usuarios/listar");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->execute(["id" => $id]);
            $this->redirect("/admin/usuarios/listar");
            return;
        }

        $this->view("usuarios/delete", compact("usuario"));
    }

    public function list(?string $id = null): void
    {
        $stmt = $this->db->query("SELECT * FROM usuarios ORDER BY id DESC");
        $usuarios = $stmt->fetchAll();
        $this->view("usuarios/list", compact("usuarios"));
    }
}
