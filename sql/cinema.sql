-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/06/2025 às 18:26
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
-- Banco de dados: `cinema`
--
CREATE DATABASE IF NOT EXISTS `cinema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cinema`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `filmes`
--

CREATE TABLE `filmes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `lancamento` date NOT NULL,
  `sinopse` varchar(200) NOT NULL,
  `duracao` time NOT NULL,
  `avaliacao` decimal(3,1) NOT NULL,
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filmes`
--

INSERT INTO `filmes` (`id`, `titulo`, `lancamento`, `sinopse`, `duracao`, `avaliacao`, `usuarioId`) VALUES
(1, 'Monstros S.A.', '2002-02-01', 'Monstros assustadores descobrem que risadas de crianças são mais poderosas que gritos, mudando o destino de Monstrópolis e a vida de Sulley e Mike.', '01:32:00', 8.1, 1),
(2, 'Procurando Nemo', '2003-07-04', 'Marlin, um peixe-palhaço protetor, viaja pelo oceano com a esquecida Dory para encontrar seu filho Nemo, capturado por um mergulhador.', '01:40:00', 8.2, 2),
(3, 'Os Incríveis', '2004-12-10', 'Uma família de super-heróis aposentados precisa voltar à ação para salvar o mundo de um vilão misterioso e reencontrar seus poderes.', '01:55:00', 8.0, 3),
(4, 'Carros', '2006-06-30', 'O arrogante carro de corrida Relâmpago McQueen se perde e aprende sobre amizade e o verdadeiro valor da vida na cidade de Radiator Springs.', '01:57:00', 7.2, 1),
(5, 'WALL-E', '2008-06-27', 'Um robô solitário na Terra abandonada por humanos segue uma sonda espacial, EVE, em uma aventura que pode salvar a humanidade no espaço.', '01:38:00', 8.4, 2),
(6, 'Up - Altas Aventuras', '2009-09-04', 'Carl, um idoso que amarra balões em sua casa para viajar à América do Sul, encontra um jovem escoteiro clandestino em sua jornada.', '01:36:00', 8.3, 3),
(7, 'Divertida Mente', '2015-06-18', 'As emoções de Riley - Alegria, Tristeza, Medo, Raiva e Nojinho - buscam restaurar o equilíbrio em sua mente após uma mudança de cidade.', '01:35:00', 8.1, 1),
(8, 'Toy Story 3', '2010-08-20', 'Woody, Buzz e os brinquedos encaram o desafio de serem doados a uma creche após Andy ir para a faculdade, buscando um novo lar e reencontrando velhos amigos em uma aventura emocionante.', '01:43:00', 8.3, 2),
(9, 'Universidade Monstros', '2013-06-21', 'Mike e Sulley, rivais na universidade, precisam superar suas diferenças para se tornarem os melhores amigos assustadores.', '01:44:00', 7.3, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `senha`) VALUES
(1, 'admin', 'admin@admin.com', 'admin'),
(2, 'fulano', 'fulano@gmail.com', 'fulano123'),
(3, 'beltrano', 'beltrano@hotmail.com', 'beltrano123'),
(4, 'Sicrano', 'sicrano@outlook.com', 'sicrano123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filmes`
--
ALTER TABLE `filmes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioFilme` (`usuarioId`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `filmes`
--
ALTER TABLE `filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `filmes`
--
ALTER TABLE `filmes`
  ADD CONSTRAINT `usuarioFilme` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
