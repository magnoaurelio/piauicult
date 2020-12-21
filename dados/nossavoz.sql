-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 03-Jul-2017 às 10:19
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nossavoz`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `artista`
--

CREATE TABLE IF NOT EXISTS `artista` (
  `artcodigo` int(11) NOT NULL AUTO_INCREMENT,
  `arttipocodigo` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inscodigo` int(11) DEFAULT NULL,
  `artnome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artusual` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artdatanasc` date DEFAULT NULL,
  `artendereco` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artbairro` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artcep` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artuf` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artcidade` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artcomplemento` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artsexo` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artfone` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artcelular` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artemail` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artsite` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artfoto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artbiografia` longtext COLLATE utf8_unicode_ci,
  `artcpf` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`artcodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Extraindo dados da tabela `artista`
--

INSERT INTO `artista` (`artcodigo`, `arttipocodigo`, `inscodigo`, `artnome`, `artusual`, `artdatanasc`, `artendereco`, `artbairro`, `artcep`, `artuf`, `artcidade`, `artcomplemento`, `artsexo`, `artfone`, `artcelular`, `artemail`, `artsite`, `artfoto`, `artbiografia`, `artcpf`) VALUES
(1, '10', NULL, 'MAGNO AURELIO DE SA CARDOSO', 'Magno Aurelio', '1956-11-02', 'Rua Candia Soares 2811', 'Acarape', '64002-110', 'PI', 'Teresina', 'Norte', 'M', '86 3213-6248', '86 9 9977-7403', 'magnosacardoso@hotmail.com', 'magnusoft.com.br', 'ART_27062017104254_1.jpg', '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;">É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação. A vantagem de usar Lorem Ipsum é que ele tem uma distribuição normal de letras, ao contrário de "Conteúdo aqui, conteúdo aqui", fazendo com que ele tenha uma aparência similar a de um texto legível. Muitos softwares de publicação e editores de páginas na internet agora usam Lorem Ipsum como texto-modelo padrão, e uma rápida busca por ''lorem ipsum'' mostra vários websites ainda em sua fase de construção. Várias versões novas surgiram ao longo dos anos, eventualmente por acidente, e às vezes de propósito (injetando humor, e coisas do gênero).</span></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;">Existem muitas variações disponíveis de passagens de Lorem Ipsum, mas a maioria sofreu algum tipo de alteração, seja por inserção de passagens com humor, ou palavras aleatórias que não parecem nem um pouco convincentes. Se você pretende usar uma passagem de Lorem Ipsum, precisa ter certeza de que não há algo embaraçoso escrito escondido no meio do texto. Todos os geradores de Lorem Ipsum na internet tendem a repetir pedaços predefinidos conforme necessário, fazendo deste o primeiro gerador de Lorem Ipsum autêntico da internet. Ele usa um dicionário com mais de 200 palavras em Latim combinado com um punhado de modelos de estrutura de frases para gerar um Lorem Ipsum com aparência razoável, livre de repetições, inserções de humor, palavras não características, etc.</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;"><br></span><br></p>', ''),
(2, '5', NULL, 'RUBENS BARBOSA LIMA', 'Rubens Lima', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_27062017104254_2.jpg', NULL, ''),
(3, '5', NULL, 'RONALDO MARTINS BRINGEL', 'Ronaldo Bringel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_27062017104254_3.jpg', NULL, ''),
(4, '5', NULL, 'MARIA DE FATIMA SILVA BARBOSA LIMA', 'Fátima Lima', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F', NULL, NULL, NULL, NULL, 'ART_27062017104254_4.jpg', NULL, ''),
(5, '5', NULL, 'LAURENICE FRANCA DE NODRONHA PESSOA', 'Laurenice Franca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F', NULL, NULL, NULL, NULL, 'ART_27062017104254_5.jpg', NULL, ''),
(6, '5', NULL, 'ROSANGELA DE FÁTIMA AMORIM', 'Rosinha Amorim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F', NULL, NULL, NULL, NULL, 'ART_27062017104254_6.jpg', NULL, ''),
(7, '5', NULL, 'LAZARO ', 'Lazaro do Piaui', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_27062017104254_7.jpg', NULL, ''),
(8, '5', NULL, 'MARIA JOSE FONTELES', 'Zeze Fonteles', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F', NULL, NULL, NULL, NULL, 'ART_27062017104254_8.jpg', NULL, ''),
(9, '1', NULL, 'CLIMÉRIO FERREIRA', 'Climério Fereira', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_28062017125132_3.jpg', NULL, ''),
(10, '3', NULL, 'RAIMUNDO AURÉLIO MELO', 'Aurélio Melo', NULL, NULL, NULL, NULL, 'PI', NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_28062017190754_3.jpg', '<h3 class="post-title entry-title" itemprop="name" style="margin: 0.75em 0px 0px; position: relative; font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 24px; line-height: normal; font-family: Georgia, Utopia, &quot;Palatino Linotype&quot;, Palatino, serif; color: rgb(34, 34, 34); letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 249, 238); text-decoration-style: initial; text-decoration-color: initial;"><span style="font-size: 18px;">Maestro Aurélio Melo</span></h3><div class="post-body entry-content" id="post-body-4923437583734226572" itemprop="description articleBody" style="width: 570px; font-size: 15.4px; line-height: 1.4; position: relative; color: rgb(34, 34, 34); font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: normal; letter-spacing: normal; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 249, 238); text-decoration-style: initial; text-decoration-color: initial;"><span style="font-family: Verdana;"><br></span><div align="justify"><span style="color: rgb(0, 0, 0);"><span style="font-family: Verdana;"><span style="font-size: 14px;">O músico, compositor, arranjador e regente</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Raimundo Aurélio Melo,</span></strong><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">iniciou sua carreira musical em Teresina no inicio dos anos 70 como trombonista da banda estudantil do Colégio Álvaro Ferreira, no Bairro Piçarra. De lá pra cá, tem uma trajetoria musical com um histórico de dedicação e bom desempenhado das funções por onde tem atuado.</span></span></span></div><div align="justify"><span style="font-family: Verdana;"><span style="color: rgb(51, 102, 255);"><br></span></span></div><div align="justify"><span style="font-family: Verdana;"><span style="color: black;"><span style="font-size: 14px;">De sua larga folha de serviço prestado a música piauiense poderiamos dizer que: foi músico da</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">banda 16 de Agosto</span></strong><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">da Prefeitura de Teresina no inicio dos anos 70; fundou com outros colegas, ainda na década de 70, o</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Grupo Cadeia</span></strong><span style="font-size: 14px;">, que se utilizava dos ritmos regionais para fazer um trabalho autoral; fundou na década de 90, o</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Grupo Ensaio Vocal</span></strong><span style="font-size: 14px;">, um conjunto vocal que utiliza arranjos vocais sofisticados; é regente e fundador de vários corais na cidade de Teresina e região, dentre estes o</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Coral UFPI</span></strong><span style="font-size: 14px;">; é o atual regente da</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Orquestra Sinfônica de Teresina</span></strong><span style="font-size: 14px;">.</span></span></span></div><div align="justify"><span style="font-family: Verdana;"><span style="color: black;"><br></span><span style="color: rgb(0, 0, 0);"><span style="font-size: 14px;">Estudou Teoria Musical, Harmonia Tradicional, Regência Coral com os professores Reginaldo Carvalho e Alberto Caplan. Harmonia Funcional com Ian Guest e Regência orquestral com Ernani Aguiar. Participou de painés de Regência Coral com os professores Pe. Pedro Ferreira, Carlyle Weiss e Mara Campos.</span></span></span></div><span style="font-family: Verdana;"><br></span><div align="center"><span style="font-family: Verdana;"><span style="font-size: 14px;">Grupo Candeia</span></span></div><div align="justify"><span style="font-family: Verdana;"><span style="font-size: 14px;">Participou, na Rede Globo de Televisão, dos programas "</span><strong><span style="font-size: 14px;">Concertos para a Juventude</span></strong><span style="font-size: 14px;">" com a</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Banda 16 de Agosto</span></strong><span style="font-size: 14px;">, da Prefeitura Municipal de Teresina e do programa "</span><strong><span style="font-size: 14px;">Som Brasil</span></strong><span style="font-size: 14px;">" com o</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Grupo Candeia</span></strong><span style="font-size: 14px;">.</span></span></div><div align="justify"><span style="font-family: Verdana;"><br></span></div><div align="justify"><span style="font-family: Verdana;"><span style="font-size: 14px;">Com o Grupo</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Ensaio Vocal</span></strong><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">gravou os Cds: "</span><strong><span style="font-size: 14px;">Canto do Povo de Um Lugar</span></strong><span style="font-size: 14px;">" e "</span><strong><span style="font-size: 14px;">Ensaio Vocal Canta Chico Buarque</span></strong><span style="font-size: 14px;">", que mais tarde originou o show com o mesmo nome e que possibilitou uma excursão por cidades de Portugal e Espanha.</span></span></div><div align="justify"><span style="font-family: Verdana;"><span style="font-size: 14px;"><br></span><span style="color: rgb(0, 0, 0);"><span style="font-size: 14px;">Como compositor de música coral, foi finalistas nos concursos de Minas Gerais com a obra "</span><strong><span style="font-size: 14px;">Rataplâ</span></strong><span style="font-size: 14px;">" e em S. Paulo e com "</span><strong><span style="font-size: 14px;">Laura-Quero Água</span></strong><span style="font-size: 14px;">"</span></span></span></div><div align="justify"><span style="font-family: Verdana;"><br></span></div><div align="center"><span style="font-family: Verdana;"><span style="font-size: 14px;">Aurélio Melo em performance no Grupo Candeia</span></span></div><div align="justify"><span style="font-family: Verdana;"><span style="font-size: 14px;">Publicou o livro</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Arranjos Corais</span></strong><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">através do projeto de editoração da Universidade Federal do Piauí. Para o repertório instrumental clássico compôs várias peças orquestrais, entre elas: "</span><strong><span style="font-size: 14px;">Sinfonia na Chapada</span></strong><span style="font-size: 14px;">", "</span><strong><span style="font-size: 14px;">Sinfonia de Teresina</span></strong><span style="font-size: 14px;">", "</span><strong><span style="font-size: 14px;">Missa de São Benedito</span></strong><span style="font-size: 14px;">" e "</span><strong><span style="font-size: 14px;">Martelo</span></strong><span style="font-size: 14px;">".</span></span></div><div align="justify"><span style="font-family: Verdana;"><span style="font-size: 14px;">Conquistou 3° e 4° lugares como compositor de MPB no "</span><strong><span style="font-size: 14px;">Festival Canta Nordeste</span></strong><span style="font-size: 14px;">" da Rede Globo, em 93 e 95 respectivamente, com as músicas: "</span><strong><span style="font-size: 14px;">Que Xote</span></strong><span style="font-size: 14px;">" e "</span><strong><span style="font-size: 14px;">Meio Tom</span></strong><span style="font-size: 14px;">", com interpretação do grupo</span><span style="font-size: 14px;">&nbsp;</span><strong><span style="font-size: 14px;">Ensaio Vocal</span></strong><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">do qual é membro e fundador.</span></span></div><div align="justify"><span style="font-family: Verdana;"><br></span></div><span style="color: rgb(0, 0, 0);"><span style="font-family: Verdana;"><span style="font-size: 14px;">Atualmente é Regente titular da Orquestra Sinfônica de Teresina, dos Corais do Sebrae-Pi, da UFPI, Séc. de Educação e Diretor da Escola de Música de Teresina.</span></span></span></div><p><br></p>', NULL),
(11, '5', NULL, 'FRANCILIO TRINDADE DECARVALHO', 'Francílio Bibio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_28062017212415_3.jpg', NULL, ''),
(12, '12', NULL, 'ENSAIO VOCAL', 'Ensaio Vocal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ART_28062017214922_3.jpg', NULL, ''),
(13, '1', NULL, 'ABRAÃO LINCOLN', 'Abraão Lincoln', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_28062017221818_3.jpg', NULL, ''),
(14, '1', NULL, 'MAGNALDO DE SÁ CARDOSO', 'Magnaldo Cardoso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_02072017194410_3.jpeg', NULL, NULL),
(15, '1', NULL, 'FRANCISCO DE ASSIS COSTA', 'Fco Costa(Manin)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_29062017110456_3.jpeg', NULL, ''),
(16, '10', NULL, 'LUIS CORDEIRO FILHO', 'Peinha do Cavaco', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_29062017150324_3.jpg', NULL, ''),
(17, '3', NULL, 'LUIZ ANTÔNIO OLIVEIRA PAIVA E SILVA', 'Luizão Paiva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017122652_3.jpg', NULL, ''),
(18, '3', NULL, 'ADELSON VIANA GÓIS DA SILVA', 'Adelson Viana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017121139_3.jpg', NULL, ''),
(19, '3', NULL, 'JÚLIO CÉSAR MEDEITOS FORTES', 'Júlio Medeiros', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017121837_3.jpg', NULL, ''),
(20, '3', NULL, 'JOÃO BERCHMANS DE CARVALHO SOBRINHO', 'Berchmans ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017120506_3.JPG', NULL, ''),
(21, '3', NULL, 'GARIBALDI GINO BAHURY DE SOUSA RAMOS', 'Garibaldi Ramos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017122121_3.jpg', NULL, ''),
(22, '3', NULL, 'ADALBERTO TEIXEIRA', 'Bebeto Batera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017123312_3.jpeg', NULL, ''),
(23, '3', NULL, 'ANTONIO ADOLFO', 'Antonio Adolfo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017162328_3.jpg', NULL, ''),
(25, '3', NULL, 'JAQUES MORELEMBAUM', 'J Morelembaum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017163044_3.jpg', NULL, ''),
(26, '9', NULL, 'MANOEL MESSIAS DO ESPIRITO E SAMBA', 'Manoel Messias', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017150603_3.jpg', NULL, NULL),
(27, '1', NULL, 'ALEXANDRE RABELO ', 'Naca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017163155_3.jpg', NULL, ''),
(28, '3', NULL, 'GERALDO BRITO', 'Geraldo Brito', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017154808_3.jpg', NULL, ''),
(29, '3', NULL, 'RAMSÉS RAMOS', 'Ramsés Ramos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_30062017155937_3.jpg', NULL, ''),
(30, '2', NULL, 'ANDERSON NÓBREGA', 'Anderson Nóbrega', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_02072017174810_3.jpg', NULL, NULL),
(31, '2', NULL, 'TARCISO VILARINHO', 'Tarcisio Bandoim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_01072017120319_3.jpg', NULL, NULL),
(32, '13', NULL, 'GRUPO CANDEIA', 'Grupo Candeia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ART_01072017122746_3.jpg', NULL, NULL),
(33, '10', NULL, 'JOSÉ RODRIGUES', 'Zé Rodrigues', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_01072017122204_3.jpg', NULL, NULL),
(34, '4', NULL, 'ROSA CARLO SILVA', 'Rosa Carlo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'F', NULL, NULL, NULL, NULL, 'ART_01072017124845_3.jpeg', NULL, NULL),
(35, '4', NULL, 'GILBERTO GOMES DE SOUSA', 'Gilberto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, NULL, 'ART_02072017174621_3.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `artista_tipo`
--

CREATE TABLE IF NOT EXISTS `artista_tipo` (
  `arttipocodigo` int(2) NOT NULL AUTO_INCREMENT,
  `arttiponome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`arttipocodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `artista_tipo`
--

INSERT INTO `artista_tipo` (`arttipocodigo`, `arttiponome`) VALUES
(1, 'Compositor'),
(2, 'Músico'),
(3, 'Arranjador'),
(4, 'Produtor'),
(5, 'Interprete'),
(6, 'Diretor Musical'),
(7, 'Programador Musical'),
(8, 'Arte Grafica'),
(9, 'Compositor, Intérprete, Músico'),
(10, 'Compositor e Músico'),
(11, 'Maestro'),
(12, 'Grupo Vocal'),
(13, 'Grupo Musical');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disco`
--

CREATE TABLE IF NOT EXISTS `disco` (
  `discodigo` int(11) NOT NULL AUTO_INCREMENT,
  `disnome` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `artcodigo` text COLLATE utf8_unicode_ci,
  `disimagem` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disbolacha` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disfrente` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disfundo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disdata` date DEFAULT NULL,
  `disgravadora` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diseditoracao` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dismix` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dismasterizacao` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`discodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `disco`
--

INSERT INTO `disco` (`discodigo`, `disnome`, `artcodigo`, `disimagem`, `disbolacha`, `disfrente`, `disfundo`, `disdata`, `disgravadora`, `diseditoracao`, `dismix`, `dismasterizacao`) VALUES
(1, 'NOSSA VOZ, NOSSOS CANTOS', '1;2;3;4;5;7;6;8;14;15', 'IMG_28062017124713_3.jpg', NULL, NULL, NULL, '2017-06-28', NULL, NULL, NULL, NULL),
(2, 'CANTARES', '1;2;3;16', 'IMG_28062017124813_3.jpg', NULL, NULL, NULL, '2017-06-28', NULL, NULL, NULL, NULL),
(3, 'ENSAIO VOCAL - CANTA CHICO', '10;12', 'IMG_28062017191537_3.JPG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'GELEIA GIROU', '3;1;2;13', 'IMG_28062017124850_3.jpg', NULL, NULL, NULL, '2017-06-28', NULL, NULL, NULL, NULL),
(5, 'CANÇÃO DO AMOR TRANQUILO', '9;1;16', 'IMG_02072017190621_3.jpg', NULL, NULL, NULL, '2017-06-28', NULL, NULL, NULL, NULL),
(6, 'O CANTO DE UM POVO DE UM LUGAR', '10;1;12;16', 'IMG_28062017190512_3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'CANTA NORDESTE II', '1;11', 'IMG_28062017213822_3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'MÚSICA POPULAR NORDESTINA', '18', 'IMG_30062017123742_3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'PIAUI DÁ SAMBA', '1;26', 'IMG_02072017132736_3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'TOQUE DE NODBREZA', '30', 'IMG_01072017120724_3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'SUÍTE DE TERREIRO', '32;10;33', 'IMG_01072017122832_3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

CREATE TABLE IF NOT EXISTS `genero` (
  `gencodigo` int(11) NOT NULL AUTO_INCREMENT,
  `gennome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`gencodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `genero`
--

INSERT INTO `genero` (`gencodigo`, `gennome`) VALUES
(1, 'Mpb'),
(2, 'Baião'),
(3, 'Carimbó'),
(4, 'Lambada'),
(5, 'Maracatu'),
(6, 'Frevo'),
(7, 'Forró'),
(8, 'Samba'),
(9, 'Samba Enredo'),
(10, 'Xote');

-- --------------------------------------------------------

--
-- Estrutura da tabela `instrumento`
--

CREATE TABLE IF NOT EXISTS `instrumento` (
  `inscodigo` int(5) NOT NULL AUTO_INCREMENT,
  `insnome` varchar(35) DEFAULT NULL,
  `insassessorio1` varchar(25) DEFAULT NULL,
  `insassessorio2` varchar(25) DEFAULT NULL,
  `insassessorio3` varchar(25) DEFAULT NULL,
  `insquant` int(3) DEFAULT NULL,
  `insfoto` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`inscodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Extraindo dados da tabela `instrumento`
--

INSERT INTO `instrumento` (`inscodigo`, `insnome`, `insassessorio1`, `insassessorio2`, `insassessorio3`, `insquant`, `insfoto`) VALUES
(1, 'Surdo', 'Talabaque', 'Marreta', '', 0, 'surdo.jpg'),
(2, 'Contra Surdo', 'Talabaque', 'Marreta', '', 0, 'surdo.jpg'),
(3, 'Caixa de Guerra', 'Talabaque', 'Baquetas', '', 1, 'caixa_guerra.jpg'),
(4, 'Repique de M&aacute;o', '', '', '', 0, 'repique.jpg'),
(5, 'Chocalho', '', '', '', 0, 'chocalho.jpg'),
(6, 'Cuica', '', '', '', 0, 'cuica.jpg'),
(7, 'Pandeiro', '', '', '', 0, 'pandeiro.jpg'),
(8, 'Agogo', 'Ferro', '', '', 0, 'agogo.jpg'),
(9, 'Reco-reco', 'Ferro', '', '', 0, 'reco_reco.jpg'),
(10, 'Pratos', '', '', '', 0, 'pratos.jpg'),
(11, 'Apito', '', '', '', 0, 'apito.jpg'),
(12, 'Cavaquinho', '', '', '', 0, 'cavaco.jpg'),
(13, 'Violao 6', '', '', '', 0, 'violao6.jpg'),
(14, 'Violao 7', '', '', '', 0, 'violao7.jpg'),
(15, 'Banjo', '', '', '', 0, 'banjo.jpg'),
(16, 'Bandolim', '', '', '', 0, 'bandolim.jpg'),
(17, 'Flauta', '', '', '', 0, 'flauta.jpg'),
(18, 'Voz', NULL, NULL, NULL, NULL, NULL),
(19, 'Vocal', NULL, NULL, NULL, NULL, NULL),
(20, 'Coral', NULL, NULL, NULL, NULL, NULL),
(21, 'Apito', NULL, NULL, NULL, 0, 'Arquivo20170307040315.jpg'),
(22, 'teste', NULL, NULL, NULL, NULL, NULL),
(23, 'teste2', NULL, NULL, NULL, NULL, NULL),
(24, 'Surdo', 'Talabaque', 'Marreta', NULL, 0, 'surdo.jpg'),
(25, 'Surdo', 'Talabaque', 'Marreta', NULL, 0, 'INS_03072017044835_3.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE IF NOT EXISTS `livro` (
  `livcodigo` int(11) NOT NULL AUTO_INCREMENT,
  `livnome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `livtipo` int(11) DEFAULT NULL,
  `livisbn` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `livautor` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `livgenero` int(11) DEFAULT NULL,
  `livfoto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `livimagem` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `livano` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `liveditora` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `livpagina` int(11) DEFAULT NULL,
  `livresumo` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`livcodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`livcodigo`, `livnome`, `livtipo`, `livisbn`, `livautor`, `livgenero`, `livfoto`, `livimagem`, `livano`, `liveditora`, `livpagina`, `livresumo`) VALUES
(1, 'NOSSA VOZ, NOSSOS CANTOS', 1, NULL, 'MAGNO AURÉLIO DE SA CARDOSO', 1, NULL, NULL, '2017', NULL, 42, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `musica`
--

CREATE TABLE IF NOT EXISTS `musica` (
  `muscodigo` int(11) NOT NULL AUTO_INCREMENT,
  `musnome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `musregistro` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `musduracao` time DEFAULT NULL,
  `musdata` date DEFAULT NULL,
  `musautor` text COLLATE utf8_unicode_ci,
  `artcodigo` text COLLATE utf8_unicode_ci,
  `gencodigo` int(11) DEFAULT NULL,
  `musfaixa` int(11) DEFAULT NULL,
  `musletra` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `musaudio` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `musarranjo` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`muscodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `musica`
--

INSERT INTO `musica` (`muscodigo`, `musnome`, `musregistro`, `musduracao`, `musdata`, `musautor`, `artcodigo`, `gencodigo`, `musfaixa`, `musletra`, `musaudio`, `musarranjo`) VALUES
(1, 'Tipo Assim... Super Heroi', NULL, '00:00:00', NULL, '1;14', '3', 1, NULL, 'LETRA_30062017105201_3.jpg', 'AUDIO_01072017135141_3.mp3', '17'),
(2, 'Sim... As Vezes Sim', NULL, NULL, NULL, '1', '2', NULL, NULL, 'LETRA_01072017135830_3.jpg', 'AUDIO_01072017135656_3.mp3', '19;21;22'),
(3, 'Sandra', NULL, '03:04:00', NULL, '1', '3', NULL, NULL, 'LETRA_01072017140352_3.jpg', 'AUDIO_01072017140352_3.mp3', '18'),
(4, 'Canto, Terra e Coração', NULL, NULL, NULL, '1;15', '5', NULL, NULL, 'LETRA_01072017140844_3.jpg', 'AUDIO_01072017140844_3.mp3', '19'),
(5, 'Navios Tumbeiros', NULL, NULL, NULL, '1', '4;8', NULL, NULL, 'LETRA_01072017141158_3.jpg', 'AUDIO_01072017141158_3.mp3', '18'),
(6, 'Poesia', NULL, NULL, NULL, '1', '3', NULL, NULL, 'LETRA_01072017141428_3.jpg', 'AUDIO_01072017142628_3.mp3', '20'),
(7, 'Lampiao', NULL, NULL, NULL, '1', '7', NULL, NULL, 'LETRA_01072017141709_3.jpg', 'AUDIO_01072017141709_3.mp3', '18'),
(8, 'Infancia de Fanzenda', NULL, NULL, NULL, '1', '3', NULL, NULL, 'LETRA_01072017142241_3.jpg', 'AUDIO_01072017155034_3.mp3', '18'),
(9, 'Dor Por', NULL, NULL, NULL, '1', '2', 1, NULL, 'LETRA_01072017142325_3.jpg', 'AUDIO_01072017142325_3.mp3', '28'),
(10, 'Aboio', NULL, '03:00:00', NULL, '1', '1;6', NULL, NULL, 'LETRA_01072017143103_3.jpg', 'AUDIO_28062017114048_1.mp3', '18'),
(11, 'Rio Parnaíba, Velho Monge', NULL, '03:04:00', '2017-06-28', '1;16', '9', 1, NULL, 'LETRA_28062017131442_3.jpg', 'AUDIO_02072017114737_3.mp3', '9'),
(12, 'Rio Parnaíba, Velho Monge', NULL, NULL, NULL, '1;16', '12', 1, NULL, 'LETRA_28062017193758_3.jpg', 'AUDIO_02072017113941_3.mp3', '10'),
(13, 'Desejo', NULL, NULL, NULL, '13', '3', 1, NULL, NULL, NULL, NULL),
(14, 'Pensamentos', NULL, NULL, NULL, '1', '11', 1, NULL, NULL, NULL, NULL),
(15, 'Desejo', NULL, NULL, NULL, '13;1', '3', 1, NULL, NULL, NULL, NULL),
(16, 'Os Bilinguinguins do Magro de Aço (GRES SAMBÃO)', NULL, NULL, NULL, '1;26;27', '26', 9, NULL, NULL, 'AUDIO_02072017121018_3.mp3', '1'),
(17, 'Olho D´água de Sangue', NULL, NULL, NULL, '1', '3', 1, NULL, NULL, NULL, '21;29'),
(18, 'Rio Parnaíba, Velho Monge', NULL, NULL, NULL, '1;16', '8', 1, NULL, NULL, NULL, '23'),
(19, 'Toque de Nobreza', NULL, NULL, NULL, '30', '30', 1, NULL, NULL, NULL, '30'),
(20, 'Teresina', NULL, NULL, NULL, '10;33', '32', 10, NULL, NULL, NULL, '10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `musica_disco`
--

CREATE TABLE IF NOT EXISTS `musica_disco` (
  `mdcodigo` int(11) NOT NULL AUTO_INCREMENT,
  `muscodigo` int(11) NOT NULL,
  `discodigo` int(11) NOT NULL,
  PRIMARY KEY (`mdcodigo`),
  KEY `muscodigo` (`muscodigo`,`discodigo`),
  KEY `discodigo` (`discodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53 ;

--
-- Extraindo dados da tabela `musica_disco`
--

INSERT INTO `musica_disco` (`mdcodigo`, `muscodigo`, `discodigo`) VALUES
(49, 1, 1),
(40, 1, 2),
(36, 1, 4),
(48, 2, 1),
(37, 3, 4),
(39, 6, 2),
(47, 10, 1),
(34, 11, 3),
(52, 11, 5),
(41, 11, 6),
(38, 13, 4),
(33, 14, 7),
(51, 16, 9),
(50, 20, 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `notid` int(11) NOT NULL AUTO_INCREMENT,
  `nottitulo` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `notfoto` varchar(200) NOT NULL,
  `notfoto1` varchar(200) NOT NULL,
  `notfoto2` varchar(200) NOT NULL,
  `notfoto3` varchar(200) NOT NULL,
  `notfoto4` varchar(200) NOT NULL,
  `notfoto5` varchar(200) NOT NULL,
  `notfoto6` varchar(200) NOT NULL,
  `notnoticia` text NOT NULL,
  `notdata` varchar(25) NOT NULL,
  `artcodigo` varchar(3) NOT NULL,
  `notvisita` int(11) NOT NULL,
  `nottipo` varchar(10) NOT NULL,
  `notestado` varchar(10) NOT NULL,
  `notinclui` varchar(45) NOT NULL,
  `notaltera` varchar(45) NOT NULL,
  `notexclui` varchar(45) NOT NULL,
  `notmesano` varchar(15) NOT NULL,
  `usuid` int(5) NOT NULL,
  `home` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`notid`),
  KEY `notdata` (`notdata`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rodape`
--

CREATE TABLE IF NOT EXISTS `rodape` (
  `rodcodigo` int(50) NOT NULL AUTO_INCREMENT,
  `rodtitulo` varchar(100) DEFAULT NULL,
  `rodtexto` text,
  `rodimagem` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`rodcodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `rodape`
--

INSERT INTO `rodape` (`rodcodigo`, `rodtitulo`, `rodtexto`, `rodimagem`) VALUES
(1, 'A idéia', 'Uma boa idéia discutida entre amigos há quase 20 anos, foi o que nos levou a este maravilhoso Projeto. Os Compositores, Músicos, Arranjadores e Produtores unindo-se com amigos e irmãos piauienses para fazer Cultura.', 'IMG_29062017123727_3.jpg'),
(2, 'Sobre o CD', 'Foi decidido que seriam 10 músicas e estas deveriam vir através de:  CD + CANCIONEIRO. CD com vários arranjadores e vários intérpretes. O Cancioneiro com músicas em partituras musicais e letras cifradas para violão e guitarra.', 'IMG_29062017124211_3.jpg'),
(3, 'Participantes', 'O projeto é composto por 10 músicas, 9 arranjadores, 8 intérpretes, 18 músicos, 28 instrumentos, 94 funções em stúdio. Ainda 2 Studios de Gravação, Mixagem e Masterização com 4 profissionais altamente especializados', 'IMG_29062017124822_3.jpg'),
(4, 'Patrocinadores', 'Fazer parcerias através de convênios com instituições que abraçacem o Projeto com esta dimensão. Contamos com a sensibilidade Cultural de <strong>5 Empresas</strong> na esfera Municipal, Estadual, Federal e Privada para realização deste Trabalho Cultural.', 'IMG_29062017124905_3.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `topo`
--

CREATE TABLE IF NOT EXISTS `topo` (
  `topcodigo` int(5) NOT NULL AUTO_INCREMENT,
  `toptitulo` varchar(100) DEFAULT NULL,
  `toptexto` text,
  `topimagem` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`topcodigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `topo`
--

INSERT INTO `topo` (`topcodigo`, `toptitulo`, `toptexto`, `topimagem`) VALUES
(1, 'Teatro 4 de Setembro. Um espetáculo!', 'Aqui aonde começam todos os Nossos Contos Cantados', 'IMG_29062017155052_3.jpg'),
(2, 'Therezina,  não trocarei jamais!', 'A vida Pulsa em cada olhar atento. Venha! pra se encantar nesta Cidade de Sonhos.', 'IMG_29062017155906_3.jpg'),
(3, 'Therezina,  nosso maior Encanto.', 'Therezina, o tempo esquenta aquece o peito, de quem vive triste sem calor.', 'IMG_29062017160024_3.jpg');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `musica_disco`
--
ALTER TABLE `musica_disco`
  ADD CONSTRAINT `musica_disco_ibfk_1` FOREIGN KEY (`muscodigo`) REFERENCES `musica` (`muscodigo`),
  ADD CONSTRAINT `musica_disco_ibfk_2` FOREIGN KEY (`discodigo`) REFERENCES `disco` (`discodigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
