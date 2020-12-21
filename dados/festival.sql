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
-- Estrutura para tabela `festival`
--

CREATE TABLE `festival` (
  `fescodigo` int(11) NOT NULL,
  `fesnome` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesmostra` int(11) DEFAULT 0,
  `artcodigo` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesimagem` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesfoto1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesfoto2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesfoto3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesdata` date DEFAULT NULL,
  `fesperiodo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `muscodigo` int(11) DEFAULT NULL,
  `discodigo` int(11) DEFAULT NULL,
  `precodigo` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesacesso` int(11) DEFAULT NULL,
  `fespreco` decimal(16,2) DEFAULT NULL,
  `fesquantidade` int(5) DEFAULT NULL,
  `fessobre` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesoutros` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `procodigo` int(11) DEFAULT NULL,
  `fesprodutor` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `fesarte` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `vidcodigo` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `festival`
--
ALTER TABLE `festival`
  ADD PRIMARY KEY (`fescodigo`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `festival`
--
ALTER TABLE `festival`
  MODIFY `fescodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
