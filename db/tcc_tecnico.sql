--
-- Database: `tccTecnico`
--

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `login` VARCHAR(50) NOT NULL UNIQUE,
  `telefone` VARCHAR(20) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
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


INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `login`, `telefone`, `cpf`, `cargo`, `descricao`, `birthday`, `curriculo`, `permissoes`, `imagens`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$P2buT7xizOZvjO0j2/yWEOPl2oqNqAI51ILnT4VfLXQJ/qz2w94lW', 'admin', '51123456789', '123.456.789-00', 'Administrador', 'Descrição do Administrador', '1990-01-01', 'curriculo.pdf', 1, 'login-de-usuario.png');


-- --------------------------------------------------------

--
-- Table structure for table `box`
--

CREATE TABLE `box` (
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

CREATE TABLE `trabalho` (
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

CREATE TABLE `chamados_concluidos` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `titulo` VARCHAR(255),
  `texto` TEXT,
  `data_hora_chamado_concluido` DATETIME,
  FOREIGN KEY (`id_user`) REFERENCES `usuarios`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `box`
--
ALTER TABLE `box`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trabalho`
--
ALTER TABLE `trabalho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chamados_concluidos`
--
ALTER TABLE `chamados_concluidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
