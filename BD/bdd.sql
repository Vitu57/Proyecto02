-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2019 a las 17:56:57
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_incidencias`
--

CREATE TABLE `tbl_incidencias` (
  `id_incidencias` int(4) NOT NULL,
  `inicio_incidencias` datetime NOT NULL COMMENT 'Inicio de incidencia',
  `final_incidencias` datetime DEFAULT NULL COMMENT 'Final de incidencia',
  `informe_incidencias` varchar(300) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL COMMENT 'Descripcion',
  `id_recursos` int(4) NOT NULL COMMENT 'Recurso',
  `id_usuarios` int(4) NOT NULL COMMENT 'Usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_recursos`
--

CREATE TABLE `tbl_recursos` (
  `id_recursos` int(4) NOT NULL,
  `nombre_recursos` varchar(25) NOT NULL COMMENT 'Nombre del recurso',
  `estado_recursos` enum('disponible','ocupado','incidencia') NOT NULL COMMENT 'Estado',
  `id_tiporecursos` int(4) NOT NULL COMMENT 'Tipo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_recursos`
--

INSERT INTO `tbl_recursos` (`id_recursos`, `nombre_recursos`, `estado_recursos`, `id_tiporecursos`) VALUES
(1, 'Yoga', 'disponible', 1),
(2, 'Baile', 'disponible', 1),
(3, 'Presentaciones', 'disponible', 1),
(4, 'Gimnasio', 'disponible', 1),
(5, 'Informatica_1', 'disponible', 1),
(6, 'Informatica_2', 'disponible', 1),
(7, 'Cocina', 'disponible', 1),
(8, 'Despacho_1', 'disponible', 1),
(9, 'Despacho_2', 'disponible', 1),
(10, 'Actos', 'disponible', 1),
(11, 'Reuniones', 'disponible', 1),
(12, 'Proyector_portatil_1', 'disponible', 2),
(13, 'Proyector_portatil_2', 'disponible', 2),
(14, 'Portatil_1', 'disponible', 2),
(15, 'Portatil_2', 'disponible', 2),
(16, 'Portatil_3', 'disponible', 2),
(17, 'Mobil_1', 'disponible', 2),
(18, 'Mobil_2', 'disponible', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reservas`
--

CREATE TABLE `tbl_reservas` (
  `id_reservas` int(4) NOT NULL,
  `inicio_reservas` datetime DEFAULT NULL COMMENT 'Inicio de reserva',
  `final_reservas` datetime DEFAULT NULL COMMENT 'Final de reserva',
  `id_usuarios` int(4) NOT NULL,
  `id_recursos` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tiporecursos`
--

CREATE TABLE `tbl_tiporecursos` (
  `id_tiporecursos` int(4) NOT NULL,
  `nombre_tiporecursos` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_tiporecursos`
--

INSERT INTO `tbl_tiporecursos` (`id_tiporecursos`, `nombre_tiporecursos`) VALUES
(1, 'Sala'),
(2, 'Objeto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_usuarios` int(4) NOT NULL,
  `nombre_usuarios` varchar(25) NOT NULL,
  `pwd_usuarios` varchar(50) NOT NULL,
  `estado_usuarios` varchar(25) NOT NULL,
  `admin_usuarios` int(1) NOT NULL,
  `informatico_usuarios` int(1) NOT NULL,
  `normal_usuarios` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usuarios`, `nombre_usuarios`, `pwd_usuarios`, `estado_usuarios`, `admin_usuarios`, `informatico_usuarios`, `normal_usuarios`) VALUES
(1, 'Gerard', '81dc9bdb52d04dc20036dbd8313ed055', 'enabled', 1, 0, 0),
(2, 'Sergio', '81dc9bdb52d04dc20036dbd8313ed055', 'enabled', 1, 0, 0),
(3, 'Victor', '81dc9bdb52d04dc20036dbd8313ed055', 'enabled', 0, 1, 0),
(4, 'Jesus', '81dc9bdb52d04dc20036dbd8313ed055', 'enabled', 0, 1, 0),
(5, 'Juanma', '81dc9bdb52d04dc20036dbd8313ed055', 'enabled', 0, 0, 1),
(6, 'Daniel', '81dc9bdb52d04dc20036dbd8313ed055', 'enabled', 0, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_incidencias`
--
ALTER TABLE `tbl_incidencias`
  ADD PRIMARY KEY (`id_incidencias`),
  ADD KEY `FK_usuarios_incidencias` (`id_usuarios`),
  ADD KEY `FK_recursos_incidencias` (`id_recursos`);

--
-- Indices de la tabla `tbl_recursos`
--
ALTER TABLE `tbl_recursos`
  ADD PRIMARY KEY (`id_recursos`),
  ADD KEY `FK_tiporecursos_recursos` (`id_tiporecursos`);

--
-- Indices de la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  ADD PRIMARY KEY (`id_reservas`),
  ADD KEY `FK_usuarios_reservas` (`id_usuarios`),
  ADD KEY `FK_recursos_reservas` (`id_recursos`);

--
-- Indices de la tabla `tbl_tiporecursos`
--
ALTER TABLE `tbl_tiporecursos`
  ADD PRIMARY KEY (`id_tiporecursos`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_incidencias`
--
ALTER TABLE `tbl_incidencias`
  MODIFY `id_incidencias` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tbl_recursos`
--
ALTER TABLE `tbl_recursos`
  MODIFY `id_recursos` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  MODIFY `id_reservas` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `tbl_tiporecursos`
--
ALTER TABLE `tbl_tiporecursos`
  MODIFY `id_tiporecursos` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usuarios` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_incidencias`
--
ALTER TABLE `tbl_incidencias`
  ADD CONSTRAINT `FK_recursos_incidencias` FOREIGN KEY (`id_recursos`) REFERENCES `tbl_recursos` (`id_recursos`),
  ADD CONSTRAINT `FK_usuarios_incidencias` FOREIGN KEY (`id_usuarios`) REFERENCES `tbl_usuarios` (`id_usuarios`);

--
-- Filtros para la tabla `tbl_recursos`
--
ALTER TABLE `tbl_recursos`
  ADD CONSTRAINT `FK_tiporecursos_recursos` FOREIGN KEY (`id_tiporecursos`) REFERENCES `tbl_tiporecursos` (`id_tiporecursos`);

--
-- Filtros para la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  ADD CONSTRAINT `FK_recursos_reservas` FOREIGN KEY (`id_recursos`) REFERENCES `tbl_recursos` (`id_recursos`),
  ADD CONSTRAINT `FK_usuarios_reservas` FOREIGN KEY (`id_usuarios`) REFERENCES `tbl_usuarios` (`id_usuarios`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
