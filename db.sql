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

-- Remove tabelas existentes para garantir que o script possa ser executado multiplas vezes
DROP TABLE IF EXISTS `palestras`;
DROP TABLE IF EXISTS `palestrantes`;
DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `palestrantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `especialidade` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `palestrantes` (`nome`, `email`, `especialidade`) VALUES
('Joaozinho', 'joao@example.com', 'Engenharia de Software'),
('Mariazinha', 'maria@example.com', 'Inteligencia Artificial'),
('Carlinhos', 'carlos@example.com', 'Seguranca da Informacao');

CREATE TABLE `palestras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text,
  `horario` varchar(50) DEFAULT NULL,
  `palestrante_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `palestrante_id` (`palestrante_id`),
  CONSTRAINT `palestras_ibfk_1` FOREIGN KEY (`palestrante_id`) REFERENCES `palestrantes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `palestras` (`titulo`, `descricao`, `horario`, `palestrante_id`) VALUES
('Desenvolvimento Web Moderno com PHP', 'Uma visao sobre as novas features e frameworks do PHP.', '10:00 - 11:00', 1),
('Machine Learning na Pratica', 'Como aplicar algoritmos de ML em problemas reais de negocio.', '11:30 - 12:30', 2),
('Fundamentos de Ciberseguranaa para Devs', 'Proteja suas aplicacoes contra as ameaças mais comuns.', '14:00 - 15:00', 3);

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`nome`, `endereco`) VALUES
('Ana', 'Rua das Flores, 123, Bom Jardim'),
('Bruno', 'Avenida Principal, 456, Pirambu'),
('Carla', 'Praça da Matriz, 789, Centro');