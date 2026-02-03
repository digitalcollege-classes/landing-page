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
