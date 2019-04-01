-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2019 a las 21:42:45
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `secure_login`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_attempts`
--

CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  `IP` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_exitosos`
--

CREATE TABLE `login_exitosos` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  `IP` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido` varchar(25) DEFAULT NULL,
  `Horarios` varchar(128) DEFAULT NULL,
  `FechaActualizacion` varchar(30) DEFAULT NULL,
  `Foto` varchar(255) DEFAULT NULL,
  `ResponsableSistemaPlus` int(3) NOT NULL DEFAULT '0',
  `PuedeCotizar` tinyint(1) NOT NULL DEFAULT '0',
  `PuedeModificarArticulos` tinyint(1) NOT NULL DEFAULT '0',
  `PuedeModificarContactos` tinyint(1) NOT NULL DEFAULT '0',
  `PuedeComprar` tinyint(1) NOT NULL DEFAULT '0',
  `PuedeHacerLegajos` tinyint(1) NOT NULL DEFAULT '0',
  `nivelUsuario` int(1) NOT NULL DEFAULT '9' COMMENT '0 super, 9 nada',
  `usuarioTrabajando` tinyint(1) NOT NULL DEFAULT '0',
  `Token` char(128) DEFAULT NULL,
  `venceToken` varchar(30) DEFAULT NULL,
  `web` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
