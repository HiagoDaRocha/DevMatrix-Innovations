CREATE DATABASE IF NOT EXISTS bancoExemplo;
CREATE USER IF NOT EXISTS 'userExemplo'@'%' IDENTIFIED BY 'userExemplo';
GRANT ALL PRIVILEGES ON bancoExemplo.* TO 'userExemplo'@'%';
FLUSH PRIVILEGES;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS  `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `login` VARCHAR(50) NOT NULL UNIQUE,
  `telefone` VARCHAR(20) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL UNIQUE,
  `cargo` VARCHAR(50) NOT NULL,
  `descricao` TEXT NOT NULL,
  `birthday` DATE NOT NULL,
  `curriculo` VARCHAR(255) NOT NULL,
  `permissoes` TINYINT NOT NULL,
  `imagens` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

-- --------------------------------------------------------

--
-- Table structure for table `box`
--

CREATE TABLE IF NOT EXISTS  `box` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `texto` TEXT NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `usuarios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trabalho`
--

CREATE TABLE IF NOT EXISTS  `trabalho` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `titulo` VARCHAR(255),
  `texto` TEXT,
  FOREIGN KEY (`user_id`) REFERENCES `usuarios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chamados_concluidos`
--

CREATE TABLE IF NOT EXISTS  `chamados_concluidos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `titulo` VARCHAR(255),
  `texto` TEXT,
  `data_hora_chamado_concluido` DATETIME,
  FOREIGN KEY (`id_user`) REFERENCES `usuarios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT,
  MODIFY `permissoes` INT DEFAULT 0;

ALTER TABLE `usuarios` AUTO_INCREMENT = 1;


--
-- AUTO_INCREMENT for table `box`
--
ALTER TABLE `box`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `trabalho`
--
ALTER TABLE `trabalho`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `chamados_concluidos`
--
ALTER TABLE `chamados_concluidos`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;