<?php

/**
 * Script para popular o banco de dados com dados de exemplo
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Palestra;
use App\Model\Palestrante;
use App\Model\Usuario;

echo "=== POPULANDO BANCO DE DADOS COM DADOS DE EXEMPLO ===\n\n";

try {
    $pdo = Palestra::db();
        
    // Inserir palestrantes
    echo "Inserindo palestrantes...\n";
    $palestrantes = [
        ['nome' => 'Ana Silva', 'email' => 'ana.silva@email.com', 'especialidade' => 'PHP e Laravel'],
        ['nome' => 'Carlos Santos', 'email' => 'carlos.santos@email.com', 'especialidade' => 'JavaScript e React'],
        ['nome' => 'Maria Oliveira', 'email' => 'maria.oliveira@email.com', 'especialidade' => 'Python e Data Science'],
        ['nome' => 'João Pereira', 'email' => 'joao.pereira@email.com', 'especialidade' => 'DevOps e Cloud Computing'],
        ['nome' => 'Fernanda Costa', 'email' => 'fernanda.costa@email.com', 'especialidade' => 'Design Patterns'],
        ['nome' => 'Pedro Lima', 'email' => 'pedro.lima@email.com', 'especialidade' => 'Arquitetura de Software'],
        ['nome' => 'Julia Fernandes', 'email' => 'julia.fernandes@email.com', 'especialidade' => 'Banco de Dados'],
        ['nome' => 'Roberto Alves', 'email' => 'roberto.alves@email.com', 'especialidade' => 'Segurança da Informação'],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO palestrantes (nome, email, especialidade) VALUES (?, ?, ?)");
    foreach ($palestrantes as $p) {
        $stmt->execute([$p['nome'], $p['email'], $p['especialidade']]);
    }
    echo "✓ " . count($palestrantes) . " palestrantes inseridos\n\n";
    
    // Inserir palestras
    echo "Inserindo palestras...\n";
    $palestras = [
        [
            'titulo' => 'Introdução ao PHP Moderno',
            'palestrante' => 'Ana Silva',
            'descricao' => 'Explorando as novidades do PHP 8.x e boas práticas de desenvolvimento',
            'horario' => '09:00 - 10:00'
        ],
        [
            'titulo' => 'React: Do Básico ao Avançado',
            'palestrante' => 'Carlos Santos',
            'descricao' => 'Aprenda a criar aplicações web modernas com React',
            'horario' => '10:30 - 11:30'
        ],
        [
            'titulo' => 'Machine Learning com Python',
            'palestrante' => 'Maria Oliveira',
            'descricao' => 'Fundamentos de ML e aplicações práticas usando Python',
            'horario' => '13:00 - 14:00'
        ],
        [
            'titulo' => 'Docker e Kubernetes na Prática',
            'palestrante' => 'João Pereira',
            'descricao' => 'Como containerizar aplicações e orquestrar containers',
            'horario' => '14:30 - 15:30'
        ],
        [
            'titulo' => 'Design Patterns: Iterator e Observer',
            'palestrante' => 'Fernanda Costa',
            'descricao' => 'Entendendo e aplicando padrões de projeto no dia a dia',
            'horario' => '16:00 - 17:00'
        ],
        [
            'titulo' => 'Microserviços e Clean Architecture',
            'palestrante' => 'Pedro Lima',
            'descricao' => 'Arquitetando sistemas escaláveis e manuteníveis',
            'horario' => '17:30 - 18:30'
        ],
        [
            'titulo' => 'SQL vs NoSQL: Quando Usar Cada Um',
            'palestrante' => 'Julia Fernandes',
            'descricao' => 'Comparativo e casos de uso de bancos relacionais e não relacionais',
            'horario' => '09:00 - 10:00'
        ],
        [
            'titulo' => 'OWASP Top 10: Protegendo sua Aplicação',
            'palestrante' => 'Roberto Alves',
            'descricao' => 'Principais vulnerabilidades e como preveni-las',
            'horario' => '10:30 - 11:30'
        ],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO palestra (titulo, palestrante, descricao, horario) VALUES (?, ?, ?, ?)");
    foreach ($palestras as $p) {
        $stmt->execute([$p['titulo'], $p['palestrante'], $p['descricao'], $p['horario']]);
    }
    echo "✓ " . count($palestras) . " palestras inseridas\n\n";
    
    // Inserir usuários
    echo "Inserindo usuários...\n";
    // Senha padrão para todos: "password" (hash bcrypt)
    $senhaHash = password_hash('password', PASSWORD_BCRYPT);
    
    $usuarios = [
        ['nome' => 'Alberto Souza', 'email' => 'alberto.souza@email.com'],
        ['nome' => 'Beatriz Lima', 'email' => 'beatriz.lima@email.com'],
        ['nome' => 'Carlos Eduardo', 'email' => 'carlos.eduardo@email.com'],
        ['nome' => 'Diana Martins', 'email' => 'diana.martins@email.com'],
        ['nome' => 'Eduardo Costa', 'email' => 'eduardo.costa@email.com'],
        ['nome' => 'Fabiana Rocha', 'email' => 'fabiana.rocha@email.com'],
        ['nome' => 'Gabriel Santos', 'email' => 'gabriel.santos@email.com'],
        ['nome' => 'Helena Oliveira', 'email' => 'helena.oliveira@email.com'],
        ['nome' => 'Igor Ferreira', 'email' => 'igor.ferreira@email.com'],
        ['nome' => 'Juliana Almeida', 'email' => 'juliana.almeida@email.com'],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    foreach ($usuarios as $u) {
        $stmt->execute([$u['nome'], $u['email'], $senhaHash]);
    }
    echo "✓ " . count($usuarios) . " usuários inseridos\n\n";
    
    echo "=== DADOS INSERIDOS COM SUCESSO! ===\n\n";
    
    // Verificar os dados
    echo "Resumo:\n";
    echo "- Palestrantes: " . $pdo->query("SELECT COUNT(*) FROM palestrantes")->fetchColumn() . "\n";
    echo "- Palestras: " . $pdo->query("SELECT COUNT(*) FROM palestra")->fetchColumn() . "\n";
    echo "- Usuários: " . $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn() . "\n";
    
} catch (\Exception $e) {
    echo "ERRO: " . $e->getMessage() . "\n";
    exit(1);
}
