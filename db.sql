DROP TABLE IF EXISTS `tb_alunos`;

CREATE TABLE IF NOT EXISTS `tb_alunos` (
     `id` INT NOT NULL AUTO_INCREMENT,
     `nome` VARCHAR(100) NOT NULL,
     `email` VARCHAR(150) NOT NULL,
     `endereco` VARCHAR(255) DEFAULT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tb_alunos`
VALUES
    (1,'Francisquinha','francisquinha@email.com','Rua Vicente Leite, 1010'),
    (2,'Chiquinho','chiquinho@email.com','Rua dos Tabajaras, 123');

