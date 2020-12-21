-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12/03/2019 às 20:41
-- Versão do servidor: 10.2.17-MariaDB
-- Versão do PHP: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u744585102_picul`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `festival_tipo`
--

CREATE TABLE `festival_tipo` (
  `festipocodigo` int(11) NOT NULL,
  `festiponome` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `festival_tipo`
--

INSERT INTO `festival_tipo` (`festipocodigo`, `festiponome`) VALUES
(1, 'Musical'),
(2, 'Artes Cènicas');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `festival_tipo`
--
ALTER TABLE `festival_tipo`
  ADD PRIMARY KEY (`festipocodigo`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `festival_tipo`
--
ALTER TABLE `festival_tipo`
  MODIFY `festipocodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
