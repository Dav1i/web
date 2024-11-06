-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/11/2024 às 02:03
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hospital`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administracoes`
--

CREATE TABLE `administracoes` (
  `id` int(11) NOT NULL,
  `receita_id` int(11) NOT NULL,
  `data_hora_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enfermeiros`
--

CREATE TABLE `enfermeiros` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `coren` varchar(20) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enfermeiros`
--

INSERT INTO `enfermeiros` (`id`, `nome`, `coren`, `usuario`, `senha`) VALUES
(1, 'jose', '123', 'b', '$2y$10$yNUm60fZmUWL5jhrvOomFe1kk21N0WWbWy/Dp5/FlX6nvivIXlkDa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `especialidade` varchar(255) DEFAULT NULL,
  `crm` varchar(20) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicos`
--

INSERT INTO `medicos` (`id`, `nome`, `especialidade`, `crm`, `usuario`, `senha`) VALUES
(1, 'pablo', 'pe', '1234', 'a', '$2y$10$o5Q0G0Cq02WtshCDxlp4BOmq.lTc6fbzlJPqK2rsmWu2EEGWUHitK');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `leito` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome`, `leito`) VALUES
(1, 'caio', '9'),
(2, 'tulio', '2');

-- --------------------------------------------------------

--
-- Estrutura para tabela `receitas`
--

CREATE TABLE `receitas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `nome_medicamento` varchar(255) NOT NULL,
  `data_administracao` date NOT NULL,
  `hora_administracao` time NOT NULL,
  `dose` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `receitas`
--

INSERT INTO `receitas` (`id`, `paciente_id`, `medico_id`, `nome_medicamento`, `data_administracao`, `hora_administracao`, `dose`) VALUES
(1, 1, 0, 'paulada', '2024-11-08', '21:44:00', '500kg'),
(2, 2, 0, 'xarope', '2024-11-02', '23:55:00', '500kg'),
(3, 2, 0, 'xarope', '2024-11-27', '15:43:00', '161g');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administracoes`
--
ALTER TABLE `administracoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receita_id` (`receita_id`);

--
-- Índices de tabela `enfermeiros`
--
ALTER TABLE `enfermeiros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administracoes`
--
ALTER TABLE `administracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `enfermeiros`
--
ALTER TABLE `enfermeiros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `administracoes`
--
ALTER TABLE `administracoes`
  ADD CONSTRAINT `administracoes_ibfk_1` FOREIGN KEY (`receita_id`) REFERENCES `receitas` (`id`);

--
-- Restrições para tabelas `receitas`
--
ALTER TABLE `receitas`
  ADD CONSTRAINT `receitas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
