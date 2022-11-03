-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2022 a las 15:40:57
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `imaq_schema`
--
CREATE DATABASE IF NOT EXISTS `imaq_schema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `imaq_schema`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `actualizaAlquiler`$$
CREATE DEFINER=`jv`@`localhost` PROCEDURE `actualizaAlquiler` ()   BEGIN
UPDATE alquileres
SET
alerta = case when fecha_alquiler < fecha_devolucion then 'Vencido' 
when fecha_alquiler > fecha_devolucion and datediff(fecha_alquiler,fecha_devolucion) >20  then 'Alquilado vigente'
when fecha_alquiler > fecha_devolucion and datediff(fecha_alquiler,fecha_devolucion) <=20  then 'Alquilado poca vigencia'
when fecha_alquiler = fecha_devolucion then 'Alquilado sin Vigencia'
ELSE alerta end;
END$$

DROP PROCEDURE IF EXISTS `actualizaExistencias`$$
CREATE DEFINER=`jv`@`localhost` PROCEDURE `actualizaExistencias` (IN `codigo_referencia_input` VARCHAR(255))   BEGIN
set @numero=0;
update existencias set consecutivo = @numero:=@numero+1 where codigo_referencia = codigo_referencia_input;
END$$

DROP PROCEDURE IF EXISTS `actualizaRemision`$$
CREATE DEFINER=`jv`@`localhost` PROCEDURE `actualizaRemision` ()   BEGIN
UPDATE remisiones
SET
alerta = case when fecha < fecha_caducado then 'Remision vencida' 
when fecha > fecha_caducado and datediff(fecha,fecha_caducado) >20  then 'Remision vigente'
when fecha > fecha_caducado and datediff(fecha,fecha_caducado) <=20  then 'Remision poca vigencia'
when fecha = fecha_caducado then 'Remision sin vigencia'
ELSE alerta end;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquileres`
--

DROP TABLE IF EXISTS `alquileres`;
CREATE TABLE `alquileres` (
  `index_id` int(11) NOT NULL,
  `equipo` varchar(60) NOT NULL,
  `cliente` varchar(60) NOT NULL,
  `fecha_alquiler` date NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `fecha_alerta` date NOT NULL,
  `alerta` varchar(60) NOT NULL DEFAULT 'Alquilado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `alquileres`:
--

--
-- Volcado de datos para la tabla `alquileres`
--

INSERT INTO `alquileres` (`index_id`, `equipo`, `cliente`, `fecha_alquiler`, `fecha_devolucion`, `fecha_alerta`, `alerta`) VALUES
(1, 'd', 'Exa S.A', '2022-11-03', '2022-11-04', '2022-11-04', 'Vencido'),
(2, 'd', 'sss', '2022-11-02', '2022-11-02', '2022-11-02', 'Alquilado sin Vigencia'),
(4, 'Montacarga x100', 'sss', '2022-11-03', '2022-11-02', '2022-11-16', 'Alquilado poca vigencia'),
(5, 'Montacarga x100', 'sss', '2022-11-02', '2022-11-02', '2022-11-02', 'Alquilado sin Vigencia'),
(6, 'Montacarga x100', 'pepsiCo', '2022-11-02', '2022-11-03', '2022-11-03', 'Vencido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `index_id` int(11) NOT NULL,
  `nombre_cliente` varchar(60) NOT NULL,
  `identificacion` varchar(45) NOT NULL,
  `tipo_identificacion` varchar(2) NOT NULL,
  `email` varchar(60) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `direccion` varchar(60) NOT NULL,
  `contacto_cliente` varchar(100) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `clientes`:
--

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`index_id`, `nombre_cliente`, `identificacion`, `tipo_identificacion`, `email`, `telefono`, `direccion`, `contacto_cliente`, `activo`) VALUES
(1, 'pepsiCo', '109830', 'CC', 'kael@hotmail.com', '3435743', 'calle 13 #34', 'Andres', 1),
(2, 'sss', 'ere', 'tr', 'dsf', 'ewrwt', '34 ', 'Camilo', 1),
(3, 'Exa S.A', '4345454365', 'CC', 'hito@hotmail.com', '(320) 327-6658)', 'calle 15 # 13', 'Jose', 1),
(4, 'Coca Cola', '324443-5', 'NI', 'cocacola@gmail.com', '(234) 243-5345)', 'calle 45 # 56-77 ', 'Yuri', 1),
(5, 'dsa', 'dsa', 'ds', 'kael404@hotmail.com', '', 'dsa', 'Luis', 1),
(6, 'dsadsa', 'dsadsa', 'ds', 'sakdsa@fdksfds.com', '', 'dsadsa', 'Maria', 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `consecutivoot`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `consecutivoot`;
CREATE TABLE `consecutivoot` (
`consecutivo` bigint(12)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto_cliente`
--

DROP TABLE IF EXISTS `contacto_cliente`;
CREATE TABLE `contacto_cliente` (
  `index_id` int(11) NOT NULL,
  `identificacion` varchar(45) NOT NULL,
  `primer_nombre` varchar(45) NOT NULL,
  `segundo_nombre` varchar(45) DEFAULT NULL,
  `primer_apellido` varchar(45) NOT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `identificacion_cliente` varchar(45) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `contacto_cliente`:
--

--
-- Volcado de datos para la tabla `contacto_cliente`
--

INSERT INTO `contacto_cliente` (`index_id`, `identificacion`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `telefono`, `email`, `identificacion_cliente`, `activo`) VALUES
(1, '12344', 'Luis', 'Carlos', 'Mercedez', 'Saenz', '(437) 555-5445', 'kael404@hotmail.com', 'fdsa', 1),
(2, '', 'Yuri', '45', 'sdf', 'sdf', 'sdsa', 'ssf', 'fdsa', 0),
(3, 'ewsdf', 'gfd', 'gdf', 'gfd', 'ssfsdg', 'fsd', 'fs', 'sdf', 0),
(4, '544322', 'Maria', 'Jimena', 'Gomez', 'Hurtado', '901353314', 'maria@gmail.com', '109830 pepsiCo', 1),
(5, '5444422', 'Maria', 'Fernanda', 'Carrillo', 'Perez', '(345) 235-4444', 'ma@hotmail.com', 'Exa S.A', 0),
(6, 'dsa', 'dsa', 'ds', 'dsa', 'dsa', '', 'informacion@imaq.co', 'pepsiCo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

DROP TABLE IF EXISTS `cotizaciones`;
CREATE TABLE `cotizaciones` (
  `index_id` int(11) NOT NULL,
  `cod_cotizacion` varchar(45) NOT NULL,
  `fecha_cotizacion` date NOT NULL,
  `hoja_trabajo` varchar(45) NOT NULL DEFAULT 'NA',
  `nombre_creador` varchar(60) NOT NULL,
  `cliente` varchar(60) NOT NULL,
  `sucursal` varchar(60) NOT NULL,
  `marca` varchar(45) NOT NULL,
  `modelo` varchar(45) NOT NULL,
  `serie` varchar(45) NOT NULL,
  `repuestos` varchar(500) NOT NULL,
  `valor` float DEFAULT NULL,
  `ejecucion` varchar(45) DEFAULT NULL,
  `cod_orden_compra` varchar(45) DEFAULT NULL,
  `cod_factura` varchar(45) DEFAULT NULL,
  `codigocliente` int(11) NOT NULL,
  `vigencia` date NOT NULL DEFAULT current_timestamp(),
  `ciudad` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `cotizaciones`:
--

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`index_id`, `cod_cotizacion`, `fecha_cotizacion`, `hoja_trabajo`, `nombre_creador`, `cliente`, `sucursal`, `marca`, `modelo`, `serie`, `repuestos`, `valor`, `ejecucion`, `cod_orden_compra`, `cod_factura`, `codigocliente`, `vigencia`, `ciudad`) VALUES
(1, '1', '2022-10-10', '2', 'Sandra', 'sss', 'distriPepsi', 'Cat', 'Montacarga x100', '233432-23', 'joidsjiojfds', 5435, 'sdffds', '002', '543543', 1, '2022-11-02', 'Bogota'),
(2, '2', '2022-11-15', 'NA', 'Sandra', 'Coca Cola', 'distriPepsi', 'Willi', 'Nivelador', 'fds', 'dsd', 3333, '333', '002', '332', 2, '2022-11-02', 'Bogota'),
(3, '3', '2022-11-23', 'NA', 'Caroline', 'Exa S.A', 'Distribuidora la 14', 'Cat', 'Nivelador', '555-5', 'saddsa', 12000, 'cxzc', '003', 'dsada', 4, '2022-11-02', 'Bogota'),
(11, '4', '2022-11-22', 'NA', 'Maria', 'Exa S.A', 'Distribuidora la 14', 'Mercedez', 'Montacarga x100', '555-5', 'njnk', 4500, 'ndksad', '003', '323', 3, '2022-11-02', 'Bogota'),
(12, '5', '2022-11-20', 'NA', 'Camilo', 'Coca Cola', 'Distribuidora la 14', 'Cat', 'Nivelador', '555-5', 'nk', 67, 'y7u', '002', 't7', 4, '2022-11-02', 'Bogota'),
(13, '6', '2022-11-16', 'NA', 'Jeisson', 'Coca Cola', 'montacarga Medellin', 'Toyota', 'J34', 'BJK', 'bj', 67, 'jk', '002', 'nkl', 4, '2022-11-16', 'Cali');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

DROP TABLE IF EXISTS `detallefactura`;
CREATE TABLE `detallefactura` (
  `index_id` int(11) NOT NULL,
  `codigocotizacion` int(11) NOT NULL,
  `codigoproducto` int(11) NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `detallefactura`:
--

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`index_id`, `codigocotizacion`, `codigoproducto`, `precio`, `cantidad`, `activo`) VALUES
(1, 1, 1, 4500, 3, 1),
(2, 1, 3, 3400, 2, 1),
(3, 1, 2, 33000, 2, 1),
(4, 1, 4, 5000, 4, 1),
(5, 1, 3, 4500, 1, 1),
(6, 1, 1, 4500, 1, 1),
(7, 1, 2, 4500, 1, 1),
(8, 1, 1, 4500, 1, 1),
(9, 1, 2, 4500, 1, 1),
(10, 1, 1, 4500, 1, 1),
(11, 1, 2, 4500, 1, 1),
(12, 1, 1, 4500, 1, 1),
(13, 1, 2, 4500, 1, 1),
(14, 1, 3, 4500, 1, 1),
(15, 1, 3, 4500, 1, 1),
(16, 1, 3, 4500, 1, 1),
(17, 1, 3, 4500, 1, 1),
(18, 1, 3, 4500, 1, 1),
(19, 1, 3, 4500, 1, 1),
(20, 1, 2, 500, 2, 1),
(21, 2, 1, 350000, 2, 1),
(23, 3, 4, 34500, 3, 1),
(24, 4, 3, 56000, 4, 1),
(25, 4, 4, 40000, 4, 1),
(26, 5, 138, 4000, 6, 1),
(27, 6, 1, 600000, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

DROP TABLE IF EXISTS `equipos`;
CREATE TABLE `equipos` (
  `index_id` int(11) NOT NULL,
  `codigo_equipo` varchar(45) NOT NULL,
  `nombre_modelo` varchar(45) NOT NULL,
  `codigo_marca` varchar(45) NOT NULL,
  `cod_serial` varchar(45) NOT NULL,
  `referencia` varchar(45) NOT NULL,
  `estado_fisico` varchar(45) DEFAULT NULL,
  `estado_alquiler` varchar(45) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `equipos`:
--

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`index_id`, `codigo_equipo`, `nombre_modelo`, `codigo_marca`, `cod_serial`, `referencia`, `estado_fisico`, `estado_alquiler`, `activo`) VALUES
(1, 'A1', 'Axus', 'E112', '12323-3', 'F114', 'mantenimiento', 'Alquilado', 1),
(2, 'cc', 'd', 'd', 'd', 'dd', 'dd', 'd', 0),
(3, 'A2', 'Montacarga x100', '454 Cat', '233432-23', '333-4', 'optimo', 'alquilado', 1),
(4, 'A3', 'Nivelador', 'Cat', '555-5', 'C115', 'Optimo', 'Disponible', 0),
(5, 'fds', 'fds', 'Mercedez', 'fds', 'fds', 'fds', 'fds', 1),
(6, 'dsa', 'dsa', 'Mercedez', 'dsa', 'dsa', 'sda', 'dsa', 0),
(7, '', '', '', '', '', '', '', 0),
(8, 'cds', 'J34', 'Mercedez', 'BJK', 'YUI', 'Optimo', 'Alquilado', 1),
(9, 'rfd', 'Axus', 'Cat', '8667', 'yhjj', 'Optimo', 'Alquilado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencias`
--

DROP TABLE IF EXISTS `existencias`;
CREATE TABLE `existencias` (
  `index_id` int(11) NOT NULL,
  `codigo_referencia` varchar(45) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `codigo_orden_compra` varchar(45) NOT NULL,
  `consecutivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `existencias`:
--

--
-- Volcado de datos para la tabla `existencias`
--

INSERT INTO `existencias` (`index_id`, `codigo_referencia`, `cantidad`, `fecha_ingreso`, `codigo_orden_compra`, `consecutivo`) VALUES
(50749, 'A100', 1, '2022-10-01', '003', 1),
(50750, 'A100', 1, '2022-10-01', '003', 2),
(50751, 'A100', 1, '2022-10-01', '003', 3),
(50752, 'A100', 1, '2022-10-01', '003', 4),
(50753, 'A100', 1, '2022-10-01', '003', 5),
(50754, 'A100', 1, '2022-10-01', '003', 6),
(50755, 'A100', 1, '2022-10-01', '003', 7),
(50756, 'A100', 1, '2022-10-01', '003', 8),
(50757, 'A100', 1, '2022-10-01', '003', 9),
(50758, 'A100', 1, '2022-10-01', '003', 10),
(50762, 'n1', 1, '2022-10-07', '001', 4),
(50763, 'n1', 1, '2022-10-07', '001', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_general`
--

DROP TABLE IF EXISTS `info_general`;
CREATE TABLE `info_general` (
  `index_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `cliente` varchar(60) NOT NULL DEFAULT 'NA',
  `tecnico` varchar(60) NOT NULL DEFAULT 'NA',
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `total_horas` time NOT NULL,
  `marca` varchar(60) NOT NULL DEFAULT 'NA',
  `modelo` varchar(60) NOT NULL DEFAULT 'NA',
  `serie` varchar(60) NOT NULL DEFAULT 'NA',
  `activo_fijo` varchar(60) NOT NULL DEFAULT 'NA',
  `estado` varchar(60) NOT NULL DEFAULT 'NA',
  `descripcion_actividad` varchar(200) NOT NULL DEFAULT 'NA',
  `requiere_autorizacion` varchar(2) NOT NULL DEFAULT 'NA',
  `repuestos_cotizar` varchar(200) NOT NULL DEFAULT 'NA',
  `codigo_referencia` varchar(45) NOT NULL DEFAULT 'NA',
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `horas` int(11) NOT NULL,
  `costo_unidad` float NOT NULL,
  `costo_total` float NOT NULL,
  `cod_cotizacion` varchar(45) NOT NULL DEFAULT 'NA',
  `fecha_envio` date NOT NULL,
  `codigo_orden_compra` varchar(45) NOT NULL DEFAULT 'NA',
  `codigo_factura` varchar(45) NOT NULL DEFAULT 'NA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `info_general`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE `movimientos` (
  `index_id` int(11) NOT NULL,
  `codigo_referencia` varchar(45) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `fecha_entrada` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `movimientos`:
--

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`index_id`, `codigo_referencia`, `cantidad`, `fecha_salida`, `fecha_entrada`) VALUES
(78, 'A100', 10, NULL, '2022-09-01'),
(79, 'A100', 10, NULL, '2022-09-01'),
(80, 'A100', 5, '2022-09-05', NULL),
(81, 'B101', 10, NULL, '2022-09-05'),
(82, 'A100', 10, NULL, '2022-09-01'),
(83, 'A100', 3, '2022-09-02', NULL),
(84, 'A100', 10, NULL, '2022-09-05'),
(85, 'A100', 5, '2022-09-02', NULL),
(86, 'A100', 3, '2022-09-05', NULL),
(87, 'A100', 10, NULL, '2022-09-15'),
(88, 'A100', 10, NULL, '2022-09-16'),
(89, 'A100', 10, NULL, '2022-09-16'),
(90, 'A100', 10, '2022-09-03', NULL),
(91, 'A100', 10, NULL, '2022-09-02'),
(92, 'A100', 5, '2022-09-02', NULL),
(93, 'A100', 10, NULL, '2022-09-01'),
(94, 'A100', 5, '2022-09-05', NULL),
(95, 'B101', 10, NULL, '2022-09-05'),
(96, 'B101', 6, '2022-09-02', NULL),
(97, 'A100', 10, NULL, '2022-09-08'),
(98, 'B101', 10, NULL, '2022-09-10'),
(99, 'B101', 5, '2022-09-05', NULL),
(100, 'A100', 10, NULL, '2022-09-01'),
(101, 'A100', 5, '2022-09-03', NULL),
(102, 'A100', 10, NULL, '2022-09-09'),
(103, 'A100', 5, '2022-09-05', NULL),
(104, 'A100', 10, NULL, '2022-09-05'),
(105, 'A100', 5, '2022-09-30', NULL),
(106, 'A100', 10, NULL, '2022-09-08'),
(107, 'A100', 5, '2022-09-02', NULL),
(108, 'A100', 10, NULL, '2022-09-05'),
(109, 'A100', 10, NULL, '2022-09-05'),
(110, 'B101', 10, NULL, '2022-09-09'),
(111, 'B101', 5, '2022-09-05', NULL),
(112, 'A100', 10, NULL, '2022-09-05'),
(113, 'A100', 5, '2022-09-05', NULL),
(114, 'A100', 10, NULL, '2022-09-09'),
(115, 'A100', 5, '2022-09-05', NULL),
(116, 'A100', 10, NULL, '2022-09-02'),
(117, 'A100', 5, '2022-09-02', NULL),
(118, 'A100', 10, NULL, '2022-09-05'),
(119, 'A100', 5, '2022-09-05', NULL),
(120, 'A100', 10, NULL, '2022-09-02'),
(121, 'A100', 10, NULL, '2022-09-07'),
(122, 'A100', 10, NULL, '2022-09-01'),
(123, 'DA', 10000, NULL, '2022-09-05'),
(124, 'A100', 10, NULL, '2022-09-01'),
(125, 'SA', 10000, NULL, '2022-09-05'),
(126, 'A100', 10000, NULL, '2022-09-05'),
(127, 'A100', 10000, NULL, '2022-09-05'),
(128, 'B101', 10, NULL, '2022-09-02'),
(129, 'A100', 10000, NULL, '2022-09-05'),
(130, 'A100', 10, NULL, '2022-09-05'),
(131, 'A100', 10, NULL, '2022-09-05'),
(132, 'A100', 10, NULL, '2022-09-05'),
(133, 'A100', 10, NULL, '2022-09-05'),
(134, 'A100', 10, NULL, '2022-09-05'),
(135, 'A100', 10, NULL, '2022-09-01'),
(136, 'A100', 10, NULL, '2022-09-05'),
(137, 'A100', 10, NULL, '2022-09-05'),
(138, 'B101', 10, NULL, '2022-09-05'),
(139, '', 0, NULL, '0000-00-00'),
(140, '', 0, NULL, '0000-00-00'),
(141, '', 0, NULL, '0000-00-00'),
(142, '', 0, NULL, '0000-00-00'),
(143, '', 0, NULL, '0000-00-00'),
(144, '', 0, NULL, '0000-00-00'),
(145, '', 0, NULL, '0000-00-00'),
(146, '', 0, NULL, '0000-00-00'),
(147, '', 0, NULL, '0000-00-00'),
(148, '', 0, NULL, '0000-00-00'),
(149, '', 0, NULL, '0000-00-00'),
(150, '', 0, NULL, '0000-00-00'),
(151, '', 0, NULL, '0000-00-00'),
(152, 'B101', 10, NULL, '2022-09-05'),
(153, 'B101', 10, NULL, '2022-09-05'),
(154, 'B101', 3, '2020-05-05', NULL),
(155, 'B101', 3, '2020-05-05', NULL),
(156, 'A100', 3, NULL, '2022-09-05'),
(157, 'B101', 3, '2020-05-05', NULL),
(158, 'B101', 3, '2020-05-05', NULL),
(159, 'A100', 10, NULL, '2022-09-05'),
(160, 'B101', 10, NULL, '2022-09-05'),
(161, 'B101', 10, NULL, '2022-09-05'),
(162, 'B101', 10, NULL, '2022-09-05'),
(163, 'B101', 10, NULL, '2022-09-05'),
(164, 'B101', 10, NULL, '2022-09-05'),
(165, 'B101', 10, NULL, '2022-09-05'),
(176, 'B101', 10, NULL, '2022-09-01'),
(177, 'B101', 10, NULL, '2022-09-01'),
(178, 'A100', 10, NULL, '2022-09-03'),
(179, 'B101', 10, NULL, '2022-09-06'),
(180, 'A100', 10, NULL, '2022-09-06'),
(181, 'A100', 3, '2022-09-07', NULL),
(182, 'A102', 10, NULL, '2022-09-06'),
(183, 'A102', 2, '2022-09-06', NULL),
(184, 'B101', 2, '2022-09-07', NULL),
(185, 'A100', 43, NULL, '2022-09-02'),
(186, 'S15', 10, NULL, '2022-09-02'),
(187, 'A102', 10, NULL, '2022-09-02'),
(188, 'B101', 3, '2022-09-01', NULL),
(189, 'H56', 10, NULL, '2022-09-07'),
(190, 'B101', 20, NULL, '2022-09-02'),
(191, 'B101', 10, '2022-09-02', NULL),
(192, 'B101', 5, '2022-09-08', NULL),
(193, 'B101', 5, '2022-09-13', NULL),
(194, 'B101', 5, NULL, '2022-09-13'),
(195, 'B101', 2, '2022-09-13', NULL),
(196, 'n1', 10, NULL, '2022-10-07'),
(197, 'n1', 2, '2022-10-20', NULL),
(198, 'B101', 1, '2022-10-07', NULL),
(199, 'AX100', 10, NULL, '2022-10-21'),
(200, 'X200', 20, NULL, '2022-10-20'),
(201, 'X200', 10, '2022-10-20', NULL),
(202, 'X200', 8, '2022-10-13', NULL),
(203, 'A100', 20, NULL, '2022-10-01'),
(204, 'n1', 5, NULL, '2022-10-07'),
(205, 'A100', 10, '2022-10-18', NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `nombre_cliente`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `nombre_cliente`;
CREATE TABLE `nombre_cliente` (
`index_id` int(11)
,`codigo_orden_trabajo` varchar(45)
,`tipo_orden_trabajo` varchar(45)
,`cliente` varchar(45)
,`nombre_cliente` varchar(60)
,`sucursal` varchar(45)
,`nombre_sucursal` varchar(60)
,`persona_encargada` varchar(60)
,`tecnico` varchar(60)
,`observaciones` text
,`fecha_orden_trabajo` date
,`equipo` varchar(45)
,`nombre_modelo` varchar(45)
,`marca` varchar(45)
,`estado_equipo` varchar(45)
,`hora_inicio` time
,`hora_finalizacion` time
,`voltaje` varchar(60)
,`amperaje` varchar(60)
,`clavija` varchar(60)
,`modelo` varchar(60)
,`serie` varchar(60)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_compra`
--

DROP TABLE IF EXISTS `ordenes_compra`;
CREATE TABLE `ordenes_compra` (
  `index_id` int(11) NOT NULL,
  `codigo_orden` varchar(45) NOT NULL,
  `codigo_referencia` varchar(45) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_unitario` float NOT NULL,
  `precio_total` float NOT NULL,
  `codigo_solicitante` varchar(45) NOT NULL,
  `concepto` varchar(45) NOT NULL,
  `codigo_cliente_salida` varchar(45) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `estatus` varchar(60) NOT NULL,
  `cod_cotizacion` varchar(60) NOT NULL,
  `cod_factura` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `ordenes_compra`:
--

--
-- Volcado de datos para la tabla `ordenes_compra`
--

INSERT INTO `ordenes_compra` (`index_id`, `codigo_orden`, `codigo_referencia`, `cantidad`, `precio_unitario`, `precio_total`, `codigo_solicitante`, `concepto`, `codigo_cliente_salida`, `fecha_ingreso`, `fecha_salida`, `estatus`, `cod_cotizacion`, `cod_factura`) VALUES
(1, '001', 'A100', 1, 450000, 450000, 'Sandra', '2', 'pepsiCo', '2022-03-14', '2022-04-04', '0', '0', '0'),
(2, '002', 'A102', 2, 3200, 6400, 'Sandra', 'dd', 'Exa S.A', '2022-08-17', '2022-09-01', '0', '0', '0'),
(3, '003', 'B101', 1, 2300, 2300, 'Sandra', 'fdsf', 'pepsiCo', '2022-09-01', '2022-09-03', '0', '0', '0'),
(4, 'ds', 'A100', 43434, 2, 43, 'Sandra', 'dsfdsffsd', 'pepsiCo', '2022-09-29', '2022-10-19', 'fdsfsd', 'A123', 'fdsfds');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_trabajo`
--

DROP TABLE IF EXISTS `orden_trabajo`;
CREATE TABLE `orden_trabajo` (
  `index_id` int(11) NOT NULL,
  `codigo_orden_trabajo` varchar(45) DEFAULT 'NA',
  `tipo_orden_trabajo` varchar(45) DEFAULT 'NA',
  `cliente` varchar(45) DEFAULT 'NA',
  `sucursal` varchar(45) DEFAULT 'NA',
  `persona_encargada` varchar(60) DEFAULT 'NA',
  `tecnico` varchar(60) DEFAULT 'NA',
  `observaciones` text DEFAULT NULL,
  `fecha_orden_trabajo` date DEFAULT NULL,
  `equipo` varchar(45) DEFAULT 'NA',
  `marca` varchar(45) DEFAULT 'NA',
  `estado_equipo` varchar(45) DEFAULT 'NA',
  `hora_inicio` time DEFAULT '00:00:00',
  `hora_finalizacion` time DEFAULT '00:00:00',
  `voltaje` varchar(60) DEFAULT 'NA',
  `amperaje` varchar(60) DEFAULT 'NA',
  `clavija` varchar(60) DEFAULT 'NA',
  `modelo` varchar(60) DEFAULT 'NA',
  `serie` varchar(60) DEFAULT 'NA',
  `firma_cliente` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `orden_trabajo`:
--

--
-- Volcado de datos para la tabla `orden_trabajo`
--

INSERT INTO `orden_trabajo` (`index_id`, `codigo_orden_trabajo`, `tipo_orden_trabajo`, `cliente`, `sucursal`, `persona_encargada`, `tecnico`, `observaciones`, `fecha_orden_trabajo`, `equipo`, `marca`, `estado_equipo`, `hora_inicio`, `hora_finalizacion`, `voltaje`, `amperaje`, `clavija`, `modelo`, `serie`, `firma_cliente`) VALUES
(162, '162', 'Correctivo', '1', 'distriPepsi', 'fdgf', 'Jeisson', 'gfd', '2022-10-05', 'Nivelador', 'Willi', 'ghjghj', '11:50:00', '08:54:00', NULL, NULL, NULL, NULL, NULL, NULL),
(163, '163', 'Mantenimiento', '1', 'distriPepsi', 'Maria Gutierrez', 'America', 'Pintura, acrilico', '2022-10-10', 'Montacarga x100', 'Willi', 'Optimo', '14:47:00', '14:48:00', NULL, NULL, NULL, NULL, NULL, NULL),
(164, '164', 'Mantenimiento', '1', 'Distribuidora la 14', 'xz', 'Jeisson', 'xz', '2022-10-05', 'Montacarga x100', 'Willi', 'xz', '10:11:00', '14:07:00', NULL, NULL, NULL, NULL, NULL, NULL),
(167, '167', 'Mantenimiento', '1', 'sfd', 'rr', 'Jeisson', 'd', '2022-10-27', 'Nivelador', 'Willi', 'd', '17:10:00', '15:11:00', NULL, NULL, NULL, NULL, NULL, NULL),
(169, '168', 'Correctivo', '1', 'distriPepsi', 'dsad', 'Sandtiago', 'saddsa', '2022-10-12', 'Axus', 'Mercedez', 'dsads', '23:21:00', '22:21:00', NULL, NULL, NULL, NULL, NULL, NULL),
(172, '170', 'Mantenimiento', '1', 'distriPepsi', 'DS', 'Jeisson', 'DS', '2022-10-11', 'Nivelador', 'Willi', 'DS', '20:39:00', '23:36:00', NULL, NULL, NULL, NULL, NULL, NULL),
(173, '173', 'Correctivo', '1', 'DistriMax', 'FD', 'Andres', 'FDS', '2022-10-11', 'Nivelador', 'Willi', 'FDS', '23:37:00', '01:37:00', NULL, NULL, NULL, NULL, NULL, NULL),
(174, '174', 'Mantenimiento', '1', 'Distribuidora la 14', 'ds', 'Sandra', 'ds', '2022-09-29', 'Nivelador', 'Willi', 'ds', '20:56:00', '00:52:00', NULL, NULL, NULL, NULL, NULL, NULL),
(175, '175', 'Mantenimiento', '2', 'sfd', 'fd', 'Mercedes', 'fds', '2022-10-12', 'Montacarga x100', 'Cat', 'fds', '00:53:00', '20:57:00', NULL, NULL, NULL, NULL, NULL, NULL),
(177, '177', 'Correctivo', '3', 'distriPepsi', 'dsadsa', 'Yuri', 'dsadsa', '2022-10-20', 'Montacarga x100', 'Mercedez', 'dsadsa', '00:58:00', '20:02:00', NULL, NULL, NULL, NULL, NULL, NULL),
(178, '178', 'Mantenimiento', '2', 'distriPepsi', 'dsa', 'Jeisson', 'dsa', '2022-10-13', 'd', 'Willi', 'dsa', '00:17:00', '23:17:00', NULL, NULL, NULL, NULL, NULL, NULL),
(179, '179', 'Mantenimiento', '1', 'Distribuidora la 14', 'ds', 'Jeisson', 'ds', '2022-10-20', 'Nivelador', 'Willi', 'ds', '00:18:00', '00:18:00', NULL, NULL, NULL, NULL, NULL, NULL),
(180, '180', 'Mantenimiento', '1', 'Distribuidora la 14', 'sa', 'Sandra', 'sa', '2022-10-12', 'Montacarga x100', 'Willi', 'sa', '21:23:00', '21:24:00', NULL, NULL, NULL, NULL, NULL, NULL),
(181, '181', 'Correctivo', '1', 'DistriMax', 'Luis', 'Jeisson', 's', '2022-10-12', 'Montacarga x100', 'Willi', 's', '21:53:00', '03:50:00', NULL, NULL, NULL, NULL, NULL, NULL),
(188, '185', 'Correctivo', '4', 'distriPepsi', 'DUUDUDUDUUDU', 'Andres', 'UDUDUDUUD', '2022-10-26', 'Montacarga x100', 'Willi', 'DUDUDUUD', '13:29:00', '18:25:00', NULL, NULL, NULL, NULL, NULL, NULL),
(189, '189', 'Mantenimiento', '4', 'distriPepsi', 'saassasas', 'America', 'sasassaas', '2022-10-13', 'Montacarga x100', 'Willi', 'saassasaas', '17:26:00', '18:27:00', NULL, NULL, NULL, NULL, NULL, NULL),
(190, '190', 'Mantenimiento', '1', 'distriPepsi', 'dasds', 'Mercedes', 'dsadsad', '2022-10-06', 'Nivelador', 'Willi', 'dsads', '16:30:00', '00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(191, '191', 'Mantenimiento', '3', 'distriPepsi', 'dsads', 'America', 'dsads', '2022-10-21', 'Montacarga x100', 'Willi', 'dsads', '13:37:00', '00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(192, '192', 'Correctivo', '4', 'DistriMax', 'tettetet', 'Mercedes', 'tetette', '2022-10-13', 'Montacarga x100', 'Cat', 'tetete', '00:00:00', '00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(193, '193', 'Correctivo', '4', 'Distribuidora la 14', 'ssa', 'America', 'sassa', '2022-10-13', 'Montacarga x100', 'Willi', 'sas', '16:39:00', '15:39:00', NULL, NULL, NULL, NULL, NULL, NULL),
(194, '194', 'Diagnostico', '2', 'distriPepsi', 'dsa', 'Sandtiago', 'dsa', '2022-10-13', 'Montacarga x100', 'Willi', 'dsa', '19:47:00', '20:47:00', NULL, NULL, NULL, NULL, NULL, NULL),
(195, '195', 'Diagnostico', '1', 'DistriMax', 'dddd', 'Sandra', 'ddddd', '2022-10-11', 'Montacarga x100', 'fds', 'ddddd', '15:53:00', '19:49:00', NULL, NULL, NULL, NULL, NULL, NULL),
(196, '196', 'Preventivo', '1', 'distriPepsi', 'dsa', 'America', 'dsa', '2022-10-05', 'Montacarga x100', 'Willi', 'dsa', '18:25:00', '20:25:00', NULL, NULL, NULL, NULL, NULL, NULL),
(198, '198', 'Preventivo', '1', 'Distribuidora la 14', 'cxz', 'Jeisson', 'cxz', '2022-10-07', 'Montacarga x100', 'Willi', 'cxz', '16:29:00', '19:26:00', NULL, NULL, NULL, NULL, NULL, 'dsa'),
(199, '199', 'Preventivo', '1', 'Distribuidora la 14', 'dsa', 'Jeisson', 'dsa', '2022-10-12', 'Axus', 'Mercedez', 'dsa', '16:33:00', '19:30:00', 'dsa', 'dsa', 'dsa', 'dsa', 'dsa', 'dsa'),
(200, '200', 'Diagnostico', '1', 'DistriMax', 'xz<', 'Yuri', 'xz<', '2022-10-26', 'Axus', 'Mercedez', 'xz<', '16:37:00', '16:38:00', 'xz<', 'xz<', 'xz<', 'xz<', 'xz<', 'localhost/versionF_app/vistas_modelos/referencias/images/poster04.jpeg'),
(201, 'dsa', 'Diagnostico', '4', 'DistriMax', 'Yuri', 'Mercedes', 'dsadas', '2022-10-05', 'Nivelador', 'Mercedez', 'dsa', '20:43:00', '16:46:00', 'dsad', 'dsa', 'dsa', '', 'dsa', 'dsa'),
(202, '202', 'Preventivo', '1', 'Distribuidora la 14', 'dsa', 'Jeisson', 'dsa', '2022-10-19', 'Axus', 'Mercedez', 'dsa', '18:04:00', '14:09:00', 'dsa', 'dsa', 'dsa', 'dsa', 'dsa', NULL),
(203, '203', 'Correctivo', '3', 'DistriMax', 'mmm', 'Sandtiago', 'cxz', '2022-09-27', 'Montacarga x100', 'Willi', 'cxz', '17:54:00', '17:54:00', 'cxz', 'cxz', 'sa', 'dsa', 'sda', NULL),
(204, 'njk', 'nj', 'Coca Cola', 'DistriMax', 'Yuri', 'Mercedes', 'hilknk', '2022-10-18', 'Montacarga x100', '', 'opsfd', '19:11:00', '21:11:00', 'njk', 'bj', 'h', 'nj', 'jk', NULL),
(205, '203', 'Preventivo', 'Coca Cola', 'DistriMax', 'Yuri', 'Mercedes', 'hjskdand', '2022-11-28', 'Montacarga x100', 'Toyota', 'Optimo', '12:26:00', '12:26:00', '678', '78', '78', '678', '777', NULL),
(206, '206', 'Correctivo', '1', 'Distribuidora la 14', 'Maria', 'Jeisson', 'Pintura', '2022-11-17', 'Montacarga x100', 'Toyota', 'Optimo', '12:04:00', '15:02:00', '67', '678', '678', '78', '678', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referencias`
--

DROP TABLE IF EXISTS `referencias`;
CREATE TABLE `referencias` (
  `index_id` int(11) NOT NULL,
  `nombre_referencia` varchar(45) NOT NULL,
  `codigo_referencia` varchar(45) NOT NULL,
  `alto` float DEFAULT NULL,
  `largo` float DEFAULT NULL,
  `ancho` float DEFAULT NULL,
  `marca` varchar(45) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_inicial` float NOT NULL,
  `ruta_foto` varchar(300) DEFAULT NULL,
  `ruta_server` varchar(300) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `referencias`:
--

--
-- Volcado de datos para la tabla `referencias`
--

INSERT INTO `referencias` (`index_id`, `nombre_referencia`, `codigo_referencia`, `alto`, `largo`, `ancho`, `marca`, `descripcion`, `precio_inicial`, `ruta_foto`, `ruta_server`, `activo`) VALUES
(1, 'Nivelador', 'A100', 54, 5, 5, 'Cat', 'rerf', 5334, '<img src=\"/versionF_app/vistas_modelos/referencias/images/Captura de pantalla (4).png\" style=\"width: 300px;height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/Captura de pantalla (4).png', 0),
(2, 'freno', 'fds', 543, 54, 54, 'fds', '543', 54, '<img src=\"/versionF_app/vistas_modelos/referencias/images/Captura de pantalla (12).png\" style=\"height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/Captura de pantalla (12).png', 0),
(3, 'llanta', 'w5', 543, 543, 543, 'Willi', '543', 543, '<img src=\"/vistas_modelos/referencias/images/Captura de pantalla (7).png\" style=\"width:300px;height: 100px;\">', '/vistas_modelos/referencias/images/Captura de pantalla (7).png', 0),
(4, 'freno2', 'fds', 543, 54, 54, 'fds', 're', 435, '<img src=\"/referencias/images/Captura de pantalla (1).png\" style=\"height: 100px;\">', '/referencias/images/Captura de pantalla (1).png', 0),
(136, 'ghf', 'hgf', 54, 54, 54, 'Cat', 'fgd', 54, '<img src=\"/referencias/images/Captura de pantalla (6).png\" style=\"width:300px;height: 100px;\">', '/referencias/images/Captura de pantalla (6).png', 0),
(137, 'sdf', 'fds', 0, 54, 5, 'Willi', 'sdv', 54, '<img src=\"/referencias/images/Captura de pantalla (5).png\" style=\"height: 100px;\">', '/referencias/images/Captura de pantalla (5).png', 0),
(138, 'gfd', 'gfd', 0, 0, 0, 'Willi', 'gfd', 444, '<img src=\"/versionF_app/vistas_modelos/referencias/images/Captura de pantalla (12).png\" style=\"height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/Captura de pantalla (12).png', 0),
(139, 'mksd', 'nk', 545, 5, 54, 'Mercedez', '54', 45354, '<img src=\"/versionF_app/vistas_modelos/referencias/images/poster04.jpeg\" style=\"width: 200px;\">', '/versionF_app/vistas_modelos/referencias/images/poster04.jpeg', 0),
(140, 'cxz', 'cxz', 0, 0, 45, 'Cat', 'rs', 4, '<img src=\"/referencias/images/poster04.jpeg\" style=\"width:300px;height: 100px;\">', '/referencias/images/poster04.jpeg', 0),
(141, 'ds', 's', 34, 4, 4, 'fds', '432', 43, '<img src=\"/versionF_app/vistas_modelos/referencias/images/poster04.jpeg\" style=\"height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/poster04.jpeg', 0),
(142, 'fd', 'fd', 43, 43, 43, 'Willi', '43', 43, '<img src=\"/referencias/images/poster04.jpeg\" style=\"width:300px;height: 100px;\">', '/referencias/images/poster04.jpeg', 0),
(143, 'fd', 'fd', 5, 5, 5, 'Willi', 'df', 54, '<img src=\"/versionF_app/vistas_modelos/referencias/images/poster04.jpeg\" style=\"width:300px;height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/poster04.jpeg', 0),
(144, 'gf', 'gfd', 54, 54, 54, 'Cat', 'fd', 45, '<img src=\"/versionF_app/vistas_modelos/referencias/images/poster03.jpeg\" style=\"width:300px;height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/poster03.jpeg', 0),
(145, 'dsf', 'fd', 45, 54, 5, 'Willi', 'f', 54, '<img src=\"/versionF_app/vistas_modelos/referencias/images/perro.jpg\" style=\"width:300px;height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/perro.jpg', 0),
(146, 'dsa', 'dsa', 432, 432, 43, 'Cat', 'fds', 432, '<a href=\"/versionF_app/vistas_modelos/referencias/images/poster03.jpeg\">ver</a>', '/versionF_app/vistas_modelos/referencias/images/poster03.jpeg', 0),
(147, 'sad', '432', 43, 43, 43, 'Willi', 'dsadas', 432, '<img src=\"/versionF_app/vistas_modelos/referencias/images/poster03.jpeg\" style=\"width:300px;height: 100px;\">', '/versionF_app/vistas_modelos/referencias/images/poster03.jpeg', 0),
(148, 'fhfhj', 'fgfv', 7, 6, 6, 'Cat', 'fghfh', 576, '<a href=\"/versionF_app/vistas_modelos/referencias/images/perro.jpg\" download>Descargar</a>', '/versionF_app/vistas_modelos/referencias/images/perro.jpg', 1),
(149, 'fh', 'gh', 0, 0, 76, 'Mercedez', 'hgf', 76675, '<a href=\"/versionF_app/vistas_modelos/referencias/images/imagenes-grandes-de-paisajes-cascada.webp\" download>Descargar</a>', '/versionF_app/vistas_modelos/referencias/images/imagenes-grandes-de-paisajes-cascada.webp', 1),
(150, 'sdf', 'fds', 534, 543, 543, 'Mercedez', '543', 543, '<a href=\"/versionF_app/vistas_modelos/referencias/images/paris-7427636.jpg\" download>Descargar</a>', '/versionF_app/vistas_modelos/referencias/images/paris-7427636.jpg', 1),
(151, 'dsjdas', '4354', 432, 432, 432, 'Cat', '342', 342, '<a href=\"/versionF_app/vistas_modelos/referencias/images/african-american-7481724.jpg\" download>Descargar</a>', '/versionF_app/vistas_modelos/referencias/images/african-american-7481724.jpg', 1),
(152, 'sfds', 'fds', 543, 543, 543, 'Cat', '543', 543, '<a href=\"/versionF_app/vistas_modelos/referencias/images/LOGO IMAQ .jpg\" download>Descargar</a>', '/versionF_app/vistas_modelos/referencias/images/LOGO IMAQ .jpg', 1),
(153, 'df', '543', 54, 54, 54, 'Cat', '543', 543, '<a href=\"/versionF_app/vistas_modelos/referencias/images/flor.jpg.jpg\" download>Descargar</a>', '/versionF_app/vistas_modelos/referencias/images/flor.jpg.jpg', 1),
(154, 'fsd', 'fd', 543, 543, 543, 'Cat', '543', 543, '<a href=\"/versionF_app/vistas_modelos/referencias/images/foto.jpg.jpg\" download>Descargar</a>', '/versionF_app/vistas_modelos/referencias/images/foto.jpg.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remisiones`
--

DROP TABLE IF EXISTS `remisiones`;
CREATE TABLE `remisiones` (
  `index_id` int(11) NOT NULL,
  `numero_remision` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `cliente` varchar(60) NOT NULL,
  `sucursal` varchar(60) NOT NULL,
  `tecnico` varchar(60) NOT NULL,
  `nombre_referencia` varchar(60) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `codigo_cotizacion` varchar(45) NOT NULL,
  `codigo_ordenes_compra` varchar(45) NOT NULL,
  `codigo_factura` varchar(45) NOT NULL,
  `fecha_caducado` date NOT NULL,
  `alerta` varchar(60) NOT NULL DEFAULT 'Remision vigente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `remisiones`:
--

--
-- Volcado de datos para la tabla `remisiones`
--

INSERT INTO `remisiones` (`index_id`, `numero_remision`, `fecha`, `cliente`, `sucursal`, `tecnico`, `nombre_referencia`, `cantidad`, `codigo_cotizacion`, `codigo_ordenes_compra`, `codigo_factura`, `fecha_caducado`, `alerta`) VALUES
(1, 'asds', '2022-11-21', 'Exa S.A', 'distriPepsi', 'Andres', 'Freno jk', 45, 'zx&amp;amp;lt;x', '002', 'dsa', '2022-11-03', 'Remision poca vigencia'),
(2, 'dsa', '2022-10-05', 'sss', 'distriPepsi', 'Andres', 'Freno jk', 3, 'A123', '002', '123', '2022-11-02', 'Remision vencida'),
(3, 'sa', '2022-10-13', 'Exa S.A', 'Distribuidora la 14', 'Sandra', 'Axus', 4, 'A123', '', 'SA', '2022-11-02', 'Remision vencida'),
(4, '7', '2022-11-21', 'Exa S.A', 'montacarga Medellin', 'Sandra', 'Nivelador', 6, '6', '002', '77', '2022-11-03', 'Remision poca vigencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `renta_equipos`
--

DROP TABLE IF EXISTS `renta_equipos`;
CREATE TABLE `renta_equipos` (
  `index_id` int(11) NOT NULL,
  `cod_equipo` varchar(45) NOT NULL,
  `identificacion_cliente` varchar(45) NOT NULL,
  `identificacion_comercial` varchar(45) NOT NULL,
  `fecha_alquiler` date NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `fecha_mantenimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `renta_equipos`:
--

--
-- Volcado de datos para la tabla `renta_equipos`
--

INSERT INTO `renta_equipos` (`index_id`, `cod_equipo`, `identificacion_cliente`, `identificacion_comercial`, `fecha_alquiler`, `fecha_devolucion`, `fecha_mantenimiento`) VALUES
(1, 'A1', '100203', 'we', '0000-00-00', '2022-07-09', '2022-06-20'),
(2, 'A1', 'pepsiCo', '12929', '2022-07-12', '2022-08-17', '2022-08-15'),
(3, '12', '3443', '223', '2022-08-24', '2022-08-04', '2022-08-17'),
(4, 'cc', 'sss', '565676', '2022-08-10', '2022-08-26', '2022-08-30'),
(5, 'A1 Axus', 'pepsiCo', 'NIT', '2022-08-03', '2022-08-26', '2022-08-29'),
(6, 'A1 Axus', 'pepsiCo', '11222', '2022-09-01', '2022-09-04', '2022-09-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuestos_suge`
--

DROP TABLE IF EXISTS `repuestos_suge`;
CREATE TABLE `repuestos_suge` (
  `index_id` int(11) NOT NULL,
  `repuestos_sugeridos` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `orden_trabajo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `repuestos_suge`:
--

--
-- Volcado de datos para la tabla `repuestos_suge`
--

INSERT INTO `repuestos_suge` (`index_id`, `repuestos_sugeridos`, `cantidad`, `orden_trabajo`) VALUES
(0, 'hfgh', 54, 'U'),
(1, 'cfdff', 34, 'G'),
(2, 'DSA', 45, 'J'),
(3, 'DSA', 45, 'J');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable_cliente`
--

DROP TABLE IF EXISTS `responsable_cliente`;
CREATE TABLE `responsable_cliente` (
  `index_id` int(11) NOT NULL,
  `identificacion_cliente` varchar(45) NOT NULL,
  `identificacion_usuario` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `responsable_cliente`:
--

--
-- Volcado de datos para la tabla `responsable_cliente`
--

INSERT INTO `responsable_cliente` (`index_id`, `identificacion_cliente`, `identificacion_usuario`) VALUES
(1, 'pepsiCo', '1010221137 Sandra Gonzalez'),
(2, 'pepsiCo', 'Sandra Gonzalez'),
(3, 'Exa S.A', 'Carlos Lopez'),
(4, 'Exa S.A', 'Maria Guevara');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `index_id` int(11) NOT NULL,
  `rol` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `roles`:
--

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`index_id`, `rol`) VALUES
(1, 'administrador'),
(2, 'cliente'),
(3, 'usuario'),
(4, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salidas`
--

DROP TABLE IF EXISTS `salidas`;
CREATE TABLE `salidas` (
  `index_id` int(11) NOT NULL,
  `codigo_referencia` varchar(45) NOT NULL,
  `cantidad` float NOT NULL,
  `fecha_salida` date NOT NULL,
  `codigo_orden_salida` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `salidas`:
--

--
-- Volcado de datos para la tabla `salidas`
--

INSERT INTO `salidas` (`index_id`, `codigo_referencia`, `cantidad`, `fecha_salida`, `codigo_orden_salida`) VALUES
(51, 'A100', 5, '2022-09-02', 'HH'),
(52, 'A100', 3, '2022-09-05', 'hh'),
(53, 'A100', 10, '2022-09-03', 'ff'),
(54, 'A100', 5, '2022-09-02', 'fd'),
(55, 'A100', 5, '2022-09-05', '5'),
(56, 'B101', 6, '2022-09-02', 'HH'),
(57, 'B101', 5, '2022-09-05', 'gg'),
(58, 'A100', 5, '2022-09-03', 'GG'),
(59, 'A100', 5, '2022-09-05', 'DD'),
(60, 'A100', 5, '2022-09-30', 'BVB'),
(61, 'A100', 5, '2022-09-02', 'hj'),
(62, 'B101', 5, '2022-09-05', 'h'),
(63, 'A100', 5, '2022-09-05', 'j'),
(64, 'A100', 5, '2022-09-05', 'ds'),
(65, 'A100', 5, '2022-09-02', 'gg'),
(66, 'A100', 5, '2022-09-05', 'ghg'),
(67, 'B101', 3, '2020-05-05', '566'),
(68, 'B101', 3, '2020-05-05', '566'),
(69, 'B101', 3, '2020-05-05', '566'),
(70, 'B101', 3, '2020-05-05', '566'),
(71, 'A100', 5, '2022-09-06', '00000'),
(72, 'A102', 2, '2022-09-06', '00000'),
(73, 'B101', 2, '2022-09-07', '0055'),
(74, 'B101', 5, '2022-09-01', '554'),
(75, 'B101', 10, '2022-09-02', 'hh'),
(76, 'B101', 5, '2022-09-08', 'hh'),
(77, 'B101', 5, '2022-09-13', '334'),
(78, 'B101', 2, '2022-09-13', '32'),
(79, 'n1', 2, '2022-10-20', '232'),
(80, 'B101', 1, '2022-10-07', 'dsa'),
(81, 'X200', 10, '2022-10-20', '002'),
(82, 'X200', 8, '2022-10-13', '232'),
(83, 'A100', 10, '2022-10-18', '002');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal_cliente`
--

DROP TABLE IF EXISTS `sucursal_cliente`;
CREATE TABLE `sucursal_cliente` (
  `index_id` int(11) NOT NULL,
  `nombre_sucursal` varchar(60) NOT NULL,
  `identificacion_cliente` varchar(45) NOT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `contacto_cliente` varchar(100) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `sucursal_cliente`:
--

--
-- Volcado de datos para la tabla `sucursal_cliente`
--

INSERT INTO `sucursal_cliente` (`index_id`, `nombre_sucursal`, `identificacion_cliente`, `direccion`, `contacto_cliente`, `activo`) VALUES
(1, 'Distribuidora la 14', 'ere sss', 'calle 23', '', 1),
(2, 'sfd', 'dsankdss', 'das', '', 0),
(3, 'distriPepsi', '109830 pepsiCo', 'CARRERA 13A 5A 20', '', 1),
(4, 'DistriMax', 'sss', 'Calle 32 # 44', 'Yuri', 0),
(5, 'fds', 'Exa S.A', 'fsd', 'Luis', 1),
(6, 'montacarga Medellin', 'Coca Cola', 'Cra 1b #3 - 63', 'Yuri', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_marca`
--

DROP TABLE IF EXISTS `tipos_marca`;
CREATE TABLE `tipos_marca` (
  `index_id` int(11) NOT NULL,
  `marca` varchar(60) NOT NULL,
  `codigo_marca` varchar(45) NOT NULL,
  `activo` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `tipos_marca`:
--

--
-- Volcado de datos para la tabla `tipos_marca`
--

INSERT INTO `tipos_marca` (`index_id`, `marca`, `codigo_marca`, `activo`) VALUES
(1, 'Mercedez', '344', 1),
(2, 'Cat', '454', 1),
(3, 'Willi', '2333', 0),
(4, 'fds', 'fdsf', 1),
(5, 'Toyota', '1', 1),
(6, 'ss', '34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `index_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `clave` varchar(255) NOT NULL,
  `identificacion_usuario` varchar(45) DEFAULT NULL,
  `primer_nombre` varchar(45) DEFAULT NULL,
  `segundo_nombre` varchar(45) DEFAULT NULL,
  `primer_apellido` varchar(45) DEFAULT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 4,
  `firma_tecnico` varchar(300) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `usuarios`:
--   `role_id`
--       `roles` -> `index_id`
--

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`index_id`, `nombre`, `clave`, `identificacion_usuario`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `role_id`, `firma_tecnico`, `activo`) VALUES
(60, 'Jeisson', '$2y$10$c7mwta0ln1/b6cEHyeGsPeuE/Nld80iL6F2R/bndBMcxLk0SxULNW', '465789754', 'Jeisson', 'Fernando', 'Vasquez', 'Guevara', 1, NULL, 0),
(63, 'Maria', '$2y$10$HlDL0EPxzXVKrzLQp6YeN.UuE.uNXC.B0qarMJDWXMFSw.7TUzN9e', '54543', 'Maria', 'Janeth', 'Guevara', 'Parrado', 2, NULL, 1),
(71, 'Mercedes', '$2y$10$vgnP0GsueXks.eQAqla/1uu1Yl.mkDUrXxfFPcxPRewH4FJVPStEG', '54657', 'Mercedes', 'Clara', 'fg', 'dgffd', 3, NULL, 1),
(72, 'Andres', '$2y$10$ZWbc3CSLL2sm/Hv9RtPUK.4I/2QuzjVq0K8tM/mKAQF2V/wSJRR4i', '5465', 'Andres', 'Octavio', 'Melendez', 'Saenz', 4, NULL, 1),
(73, 'America', '$2y$10$JhElj/74wYpQo.TUW0dNqeLHovBJsO4y94dgD5HZcoZEg9S7SgskK', '4565467', 'America', 'Milena', 'Gonzalez', 'Guevara', 4, NULL, 1),
(74, 'SandraM', '$2y$10$ZD2dT9B6ke9kVJVaiDHqgODrVZOrFgufw3OnIeRUNyusOJ3Txkf1u', '1010221137', 'Sandra', 'Milena', 'Gonzalez', 'Guevara', 1, NULL, 1),
(75, 'Santiago', '$2y$10$KcEbpt3MGurDlvbXo6UwoOt0wC2e/JKqCvjXKL6sFsLH.oZiPK2.a', '6546', 'Sandtiago', 'fds', 'fds', 'fds', 3, NULL, 1),
(76, 'Yuri', '$2y$10$a8.TzNck2/kfhAz.A958g.Sz0XvYPQDzE1/lMlvyt125A1kCkz45a', '547937960', 'Yuri', 'Andrea', 'Gonzalez', 'Guevara', 3, NULL, 1),
(77, 'Juan', '$2y$10$umS7EQOkICsdnJg.nAz43OQ7jnbi5n.jo4uU52zagd4K9oB.fSwS2', '5465', 'Juan', 'andres', 'Guevara', 'Guevara', 4, NULL, 1),
(79, 'Angel', '$2y$10$4UU755BDZWcbhWoU4iBmeevc63YVvFTPf3pPBcF1lagAGsW3d/rYK', '45545445', 'Angel', 'Jose', 'Guevara', 'Herrera', 4, NULL, 1),
(80, 'usuario', '$2y$10$phfauy57DKIa0ylZH0/HFeD7ppHZi73K5qLMP2qouy.D3NmTopiDa', 'sxdada', 'dsad', 'dsad', 'dsa', 'dsa', 4, NULL, 0),
(81, 'jik', '$2y$10$hbIGzz7G0yM6eoVgK4e7C.zrNmzpqPbZFdv0ZVmAhHfkTqO1gVbuq', 'BJK', 'BJK', 'BHJ', 'BJK', 'HJ', 4, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_cantidad`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_cantidad`;
CREATE TABLE `vista_cantidad` (
`codigo_referencia` varchar(45)
,`cantidad` double
);

-- --------------------------------------------------------

--
-- Estructura para la vista `consecutivoot`
--
DROP TABLE IF EXISTS `consecutivoot`;

DROP VIEW IF EXISTS `consecutivoot`;
CREATE ALGORITHM=UNDEFINED DEFINER=`jv`@`localhost` SQL SECURITY DEFINER VIEW `consecutivoot`  AS SELECT max(`orden_trabajo`.`index_id`) + 1 AS `consecutivo` FROM `orden_trabajo``orden_trabajo`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `nombre_cliente`
--
DROP TABLE IF EXISTS `nombre_cliente`;

DROP VIEW IF EXISTS `nombre_cliente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`jv`@`localhost` SQL SECURITY DEFINER VIEW `nombre_cliente`  AS SELECT `o`.`index_id` AS `index_id`, `o`.`codigo_orden_trabajo` AS `codigo_orden_trabajo`, `o`.`tipo_orden_trabajo` AS `tipo_orden_trabajo`, `o`.`cliente` AS `cliente`, `c`.`nombre_cliente` AS `nombre_cliente`, `o`.`sucursal` AS `sucursal`, `sc`.`nombre_sucursal` AS `nombre_sucursal`, `o`.`persona_encargada` AS `persona_encargada`, `o`.`tecnico` AS `tecnico`, `o`.`observaciones` AS `observaciones`, `o`.`fecha_orden_trabajo` AS `fecha_orden_trabajo`, `o`.`equipo` AS `equipo`, `e`.`nombre_modelo` AS `nombre_modelo`, `o`.`marca` AS `marca`, `o`.`estado_equipo` AS `estado_equipo`, `o`.`hora_inicio` AS `hora_inicio`, `o`.`hora_finalizacion` AS `hora_finalizacion`, `o`.`voltaje` AS `voltaje`, `o`.`amperaje` AS `amperaje`, `o`.`clavija` AS `clavija`, `o`.`modelo` AS `modelo`, `o`.`serie` AS `serie` FROM (((`orden_trabajo` `o` left join `clientes` `c` on(`o`.`cliente` = `c`.`index_id`)) left join `sucursal_cliente` `sc` on(`sc`.`index_id` = `o`.`sucursal`)) left join `equipos` `e` on(`e`.`index_id` = `o`.`equipo`))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_cantidad`
--
DROP TABLE IF EXISTS `vista_cantidad`;

DROP VIEW IF EXISTS `vista_cantidad`;
CREATE ALGORITHM=UNDEFINED DEFINER=`jv`@`localhost` SQL SECURITY DEFINER VIEW `vista_cantidad`  AS SELECT `existencias`.`codigo_referencia` AS `codigo_referencia`, sum(`existencias`.`cantidad`) AS `cantidad` FROM `existencias` GROUP BY `existencias`.`codigo_referencia``codigo_referencia`  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `contacto_cliente`
--
ALTER TABLE `contacto_cliente`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`index_id`),
  ADD KEY `codigocotizacion` (`codigocotizacion`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `existencias`
--
ALTER TABLE `existencias`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `info_general`
--
ALTER TABLE `info_general`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `referencias`
--
ALTER TABLE `referencias`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `remisiones`
--
ALTER TABLE `remisiones`
  ADD PRIMARY KEY (`index_id`),
  ADD UNIQUE KEY `numero_remision` (`numero_remision`);

--
-- Indices de la tabla `renta_equipos`
--
ALTER TABLE `renta_equipos`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `repuestos_suge`
--
ALTER TABLE `repuestos_suge`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `responsable_cliente`
--
ALTER TABLE `responsable_cliente`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `salidas`
--
ALTER TABLE `salidas`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `sucursal_cliente`
--
ALTER TABLE `sucursal_cliente`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `tipos_marca`
--
ALTER TABLE `tipos_marca`
  ADD PRIMARY KEY (`index_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`index_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `contacto_cliente`
--
ALTER TABLE `contacto_cliente`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `existencias`
--
ALTER TABLE `existencias`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50764;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `orden_trabajo`
--
ALTER TABLE `orden_trabajo`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT de la tabla `referencias`
--
ALTER TABLE `referencias`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `remisiones`
--
ALTER TABLE `remisiones`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `renta_equipos`
--
ALTER TABLE `renta_equipos`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `repuestos_suge`
--
ALTER TABLE `repuestos_suge`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `responsable_cliente`
--
ALTER TABLE `responsable_cliente`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `salidas`
--
ALTER TABLE `salidas`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `sucursal_cliente`
--
ALTER TABLE `sucursal_cliente`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipos_marca`
--
ALTER TABLE `tipos_marca`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `index_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`index_id`);

DELIMITER $$
--
-- Eventos
--
DROP EVENT IF EXISTS `actualizaAlquiler`$$
CREATE DEFINER=`root`@`localhost` EVENT `actualizaAlquiler` ON SCHEDULE EVERY 1 MINUTE STARTS '2022-11-02 09:12:39' ENDS '2024-11-02 09:12:39' ON COMPLETION NOT PRESERVE ENABLE DO CALL actualizaAlquiler()$$

DROP EVENT IF EXISTS `actualizaRemision`$$
CREATE DEFINER=`root`@`localhost` EVENT `actualizaRemision` ON SCHEDULE EVERY 1 MINUTE STARTS '2022-11-02 12:30:00' ENDS '2024-11-02 12:30:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL actualizaRemision()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
