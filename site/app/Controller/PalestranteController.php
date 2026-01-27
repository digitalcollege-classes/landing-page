<?php

declare(strict_types=1);

class PalestranteController extends AbstractController
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
            $tema = trim($_POST["tema"] ?? "");
            $bio = trim($_POST["bio"] ?? "");

            $erros = [];
            if ($nome === "") {
                $erros[] = "O nome é obrigatório.";
            }
            if ($email === "") {
                $erros[] = "O email é obrigatório.";
            }
            if ($tema === "") {
                $erros[] = "O tema é obrigatório.";
            }

            if (empty($erros)) {
                $stmt = $this->db->prepare(
                    "INSERT INTO palestrantes (nome, email, tema, bio) VALUES (:nome, :email, :tema, :bio)",
                );
                $stmt->execute([
                    "nome" => $nome,
                    "email" => $email,
                    "tema" => $tema,
                    "bio" => $bio,
                ]);
                $this->redirect("/admin/palestrantes/listar");
                return;
            }

            $this->view(
                "palestrantes/add",
                compact("erros", "nome", "email", "tema", "bio"),
            );
            return;
        }

        $nome = "";
        $email = "";
        $tema = "";
        $bio = "";
        $erros = [];
        $this->view(
            "palestrantes/add",
            compact("erros", "nome", "email", "tema", "bio"),
        );
    }

    public function edit(?string $id = null): void
    {
        if ($id === null) {
            $this->redirect("/admin/palestrantes/listar");
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM palestrantes WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $palestrante = $stmt->fetch();

        if (!$palestrante) {
            $this->redirect("/admin/palestrantes/listar");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = trim($_POST["nome"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $tema = trim($_POST["tema"] ?? "");
            $bio = trim($_POST["bio"] ?? "");

            $erros = [];
            if ($nome === "") {
                $erros[] = "O nome é obrigatório.";
            }
            if ($email === "") {
                $erros[] = "O email é obrigatório.";
            }
            if ($tema === "") {
                $erros[] = "O tema é obrigatório.";
            }

            if (empty($erros)) {
                $stmt = $this->db->prepare(
                    "UPDATE palestrantes SET nome = :nome, email = :email, tema = :tema, bio = :bio WHERE id = :id",
                );
                $stmt->execute([
                    "nome" => $nome,
                    "email" => $email,
                    "tema" => $tema,
                    "bio" => $bio,
                    "id" => $id,
                ]);
                $this->redirect("/admin/palestrantes/listar");
                return;
            }

            $palestrante["nome"] = $nome;
            $palestrante["email"] = $email;
            $palestrante["tema"] = $tema;
            $palestrante["bio"] = $bio;
            $this->view("palestrantes/edit", compact("erros", "palestrante"));
            return;
        }

        $erros = [];
        $this->view("palestrantes/edit", compact("erros", "palestrante"));
    }

    public function delete(?string $id = null): void
    {
        if ($id === null) {
            $this->redirect("/admin/palestrantes/listar");
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM palestrantes WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $palestrante = $stmt->fetch();

        if (!$palestrante) {
            $this->redirect("/admin/palestrantes/listar");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $stmt = $this->db->prepare(
                "DELETE FROM palestrantes WHERE id = :id",
            );
            $stmt->execute(["id" => $id]);
            $this->redirect("/admin/palestrantes/listar");
            return;
        }

        $this->view("palestrantes/delete", compact("palestrante"));
    }

    public function list(?string $id = null): void
    {
        $stmt = $this->db->query("SELECT * FROM palestrantes ORDER BY id DESC");
        $palestrantes = $stmt->fetchAll();
        $this->view("palestrantes/list", compact("palestrantes"));
    }
}
