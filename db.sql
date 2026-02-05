DROP TABLE IF EXISTS `tb_alunos`;

CREATE TABLE IF NOT EXISTS `tb_alunos` (
     `id` int NOT NULL AUTO_INCREMENT,
     `nome` varchar(100) NOT NULL,
     `endereco` varchar(255) DEFAULT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tb_alunos`
    VALUES
        (1,'Francisquinha','Rua Vicente Leite, 1010'),
        (2,'Chiquinho','Rua dos Tabajaras, 123')
;

DROP TABLE IF EXISTS `palestrante`;

CREATE TABLE IF NOT EXISTS `palestrante` (
     `id` int NOT NULL AUTO_INCREMENT,
     `nome` varchar(100) NOT NULL,
     `email` varchar(255) NOT NULL,
     `especialidade` varchar(255) NOT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `palestra`;

CREATE TABLE IF NOT EXISTS `palestra` (
     `id` int NOT NULL AUTO_INCREMENT,
     `titulo` varchar(255) NOT NULL,
     `palestrante` varchar(100) NOT NULL,
     `descricao` text NOT NULL,
     `horario` varchar(50) NOT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
