-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2017 at 06:09 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_incalake`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(128) NOT NULL,
  `descripcion_categoria` varchar(255) DEFAULT NULL,
  `id_idioma` int(11) NOT NULL,
  `id_codigo_categoria` int(11) NOT NULL,
  `id_usuarios` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `descripcion_categoria`, `id_idioma`, `id_codigo_categoria`, `id_usuarios`) VALUES
(31, 'Turismo Astronómico', 'Turismo Astronómico', 1, 7, 1),
(32, 'Astronomical Tourism', 'Astronomical Tourism', 2, 7, 1),
(33, 'Tourisme astronomique', 'Tourisme astronomique', 3, 7, 1),
(34, 'Astronomischer Tourismus', 'Astronomischer Tourismus', 4, 7, 1),
(35, 'Turismo astronômico', 'Turismo astronômico', 5, 7, 1),
(36, 'Turismo Cultural', 'Turismo Cultural', 1, 8, 1),
(37, 'Cultural tourism', 'Cultural tourism', 2, 8, 1),
(38, 'Tourisme culturel', 'Tourisme culturel', 3, 8, 1),
(39, 'Kulturtourismus', 'Kulturtourismus', 4, 8, 1),
(40, 'O turismo cultural', 'O turismo cultural', 5, 8, 1),
(41, 'Turismo de Aventura', 'Turismo de Aventura', 1, 9, 1),
(42, 'Adventure trip', 'Adventure trip', 2, 9, 1),
(43, 'Tourisme d\'aventure', 'Tourisme d\'aventure', 3, 9, 1),
(44, 'Abenteuer-Tourismus', 'Abenteuer-Tourismus', 4, 9, 1),
(45, 'Turismo de aventura', 'Turismo de aventura', 5, 9, 1),
(46, 'Turismo de Salud', 'Turismo de Salud', 1, 10, 1),
(47, 'Health tourism', 'Health tourism', 2, 10, 1),
(48, 'Tourisme santé', 'Tourisme santé', 3, 10, 1),
(49, 'Gesundheitstourismus', 'Gesundheitstourismus', 4, 10, 1),
(50, 'Turismo de saúde', 'Turismo de saúde', 5, 10, 1),
(51, 'Turismo de Sol y Playa', 'Turismo de Sol y Playa', 1, 11, 1),
(52, 'Sun and Beach Tourism', 'Sun and Beach Tourism', 2, 11, 1),
(53, 'Tourisme Soleil et Plage', 'Tourisme Soleil et Plage', 3, 11, 1),
(54, 'Sonne und Strand Tourismus', 'Sonne und Strand Tourismus', 4, 11, 1),
(55, 'Sun e Turismo Praia', 'Sun e Turismo Praia', 5, 11, 1),
(56, 'Turismo Ecológico', 'Turismo Ecológico', 1, 12, 1),
(57, 'Eco tourism', 'Eco tourism', 2, 12, 1),
(58, 'Ökotourismus', 'Ökotourismus', 3, 12, 1),
(59, 'Ökotourismus', 'Ökotourismus', 4, 12, 1),
(60, 'Eco tourism', 'Eco tourism', 5, 12, 1),
(61, 'Turismo Gastronómico', 'Turismo Gastronómico', 1, 13, 1),
(62, 'Gastronomic tourism', 'Gastronomic tourism', 2, 13, 1),
(63, 'Tourisme gastronomique', 'Tourisme gastronomique', 3, 13, 1),
(64, 'Gastronomietourismus', 'Gastronomietourismus', 4, 13, 1),
(65, 'turismo gastronômico', 'turismo gastronômico', 5, 13, 1),
(66, 'Turismo Místico', 'Turismo Místico', 1, 14, 1),
(67, 'Mystic Tourism', 'Mystic Tourism', 2, 14, 1),
(68, 'Tourisme Mystic', 'Tourisme Mystic', 3, 14, 1),
(69, 'Mystic Tourismus', 'Mystic Tourismus', 4, 14, 1),
(70, 'Turismo místico', 'Turismo místico', 5, 14, 1),
(71, 'Turismo Romántico', 'Turismo Romántico', 1, 15, 1),
(72, 'Romantic Turism', 'Romantic Turism', 2, 15, 1),
(73, 'Tourisme romantique', 'Tourisme romantique', 3, 15, 1),
(74, 'Romantischer Tourismus', 'Romantischer Tourismus', 4, 15, 1),
(75, 'Turismo romântico', 'Turismo romântico', 5, 15, 1),
(76, 'Turismo Urbano', 'Turismo Urbano', 1, 16, 1),
(77, 'Tourist Attractions', 'Tourist Attractions', 2, 16, 1),
(78, 'Tourisme urbain', 'Tourisme urbain', 3, 16, 1),
(79, 'Städtetourismus', 'Städtetourismus', 4, 16, 1),
(80, 'Turismo urbano', 'Turismo urbano', 5, 16, 1),
(81, 'Turismo Vivencial', 'Turismo Vivencial', 1, 17, 1),
(82, 'Experiential Tourism', 'Experiential Tourism', 2, 17, 1),
(83, 'Tourisme expérientiel', 'Tourisme expérientiel', 3, 17, 1),
(84, 'Experiential Tourismus', 'Experiential Tourismus', 4, 17, 1),
(85, 'Turismo vivencial', 'Turismo vivencial', 5, 17, 1),
(86, 'Turismo de diversión', 'Turismo de diversión', 1, 18, 1),
(87, 'Fun tourism', 'Fun tourism', 2, 18, 1),
(88, 'Fun Tourisme', 'Fun Tourisme', 3, 18, 1),
(89, 'Tourismus Fun', 'Tourismus Fun', 4, 18, 1),
(90, 'Fun Turismo', 'Fun Turismo', 5, 18, 1),
(91, 'Turismo LGTBIQ', 'Turismo LGTBIQ', 1, 19, 1),
(92, 'Tourism LGTBIQ', 'Tourism LGTBIQ', 2, 19, 1),
(93, 'LGBTIQ touristique', 'LGBTIQ touristique', 3, 19, 1),
(94, 'Tourismus LGBTIQ', 'Tourismus LGBTIQ', 4, 19, 1),
(95, 'LGBTIQ turismo', 'LGBTIQ turismo', 5, 19, 1),
(96, 'Turismo de Naturaleza', 'Turismo de Naturaleza', 1, 20, 1),
(97, 'Nature tourism', 'Nature tourism', 2, 20, 1),
(98, 'Nature Tourisme', 'Nature Tourisme', 3, 20, 1),
(99, 'Naturtourismus', 'Naturtourismus', 4, 20, 1),
(100, 'Turismo de natureza', 'Turismo de natureza', 5, 20, 1),
(101, 'Turismo Religioso', 'Turismo Religioso', 1, 21, 1),
(102, 'Religious Tourism', 'Religious Tourism', 2, 21, 1),
(103, 'Tourisme religieux', 'Tourisme religieux', 3, 21, 1),
(104, 'Religiöser Tourismus', 'Religiöser Tourismus', 4, 21, 1),
(105, 'Turismo religioso', 'Turismo religioso', 5, 21, 1),
(106, 'Turismo Rural Comunitario', 'Turismo Rural Comunitario', 1, 22, 1),
(107, 'Community Rural Tourism', 'Community Rural Tourism', 2, 22, 1),
(108, 'Tourisme Rural Communautaire', 'Tourisme Rural Communautaire', 3, 22, 1),
(109, 'Rural Community Tourismus', 'Rural Community Tourismus', 4, 22, 1),
(110, 'Turismo Rural Comunidade', 'Turismo Rural Comunidade', 5, 22, 1),
(111, 'Turismo de Negocios o Eventos', 'Turismo de Negocios o Eventos', 1, 23, 1),
(112, 'Business or Event Tourism', 'Business or Event Tourism', 2, 23, 1),
(113, 'Tourisme d\'affaires ou d\'événements', 'Tourisme d\'affaires ou d\'événements', 3, 23, 1),
(114, 'Geschäftstourismus oder Veranstaltungen', 'Geschäftstourismus oder Veranstaltungen', 4, 23, 1),
(115, 'Turismo de negócios ou eventos', 'Turismo de negócios ou eventos', 5, 23, 1),
(116, 'Turismo de Ayuda Humanitaria', 'Turismo de Ayuda Humanitaria', 1, 24, 1),
(117, 'Humanitarian Aid Tourism', 'Humanitarian Aid Tourism', 2, 24, 1),
(118, 'Tourisme d\'aide humanitaire', 'Tourisme d\'aide humanitaire', 3, 24, 1),
(119, 'Tourismus Humanitäre Hilfe', 'Tourismus Humanitäre Hilfe', 4, 24, 1),
(120, 'Ajuda Humanitária Turismo', 'Ajuda Humanitária Turismo', 5, 24, 1),
(121, 'Turismo deportivo', 'Turismo deportivo', 1, 25, 1),
(122, 'Sports tourism', 'Sports tourism', 2, 25, 1),
(123, 'le tourisme sportif', 'le tourisme sportif', 3, 25, 1),
(124, 'Sporttourismus', 'Sporttourismus', 4, 25, 1),
(125, 'Turismo desportivo', 'Turismo desportivo', 5, 25, 1),
(126, 'Turismo de compras', 'Turismo de compras', 1, 26, 1),
(127, 'Shopping tourism', 'Shopping tourism', 2, 26, 1),
(128, 'Tourisme commercial', 'Tourisme commercial', 3, 26, 1),
(129, 'Shopping-Tourismus', 'Shopping-Tourismus', 4, 26, 1),
(130, 'Turismo de compras', 'Turismo de compras', 5, 26, 1),
(131, 'Otros', 'Otros', 1, 27, 1),
(132, 'Others', 'Others', 2, 27, 1),
(133, 'D\'autres', 'D\'autres', 3, 27, 1),
(134, 'andere', 'Andere', 4, 27, 1),
(135, 'Outros', 'Outros', 5, 27, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `fk_categoria_idioma1_idx` (`id_idioma`) USING BTREE,
  ADD KEY `fk_categoria_codigo_categoria1_idx` (`id_codigo_categoria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_categoria_codigo_categoria1` FOREIGN KEY (`id_codigo_categoria`) REFERENCES `codigo_categoria` (`id_codigo_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_categoria_idioma1` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
