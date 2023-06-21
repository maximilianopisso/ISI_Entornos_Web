-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2023 a las 20:49:57
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ibwallet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credenciales`
--

CREATE TABLE `credenciales` (
  `clave` varchar(15) NOT NULL,
  `user_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`clave`, `user_id`) VALUES
('clave1111', 1),
('clave2222', 2),
('clave3333', 3),
('clave4444', 4),
('clave5555', 5),
('clave6666', 6),
('clave7777', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `cue_id` int(11) NOT NULL,
  `cue_user_id` int(11) NOT NULL,
  `cue_nro_cuenta` varchar(15) NOT NULL,
  `cue_tipo_cuenta` enum('CA','CC') NOT NULL,
  `cue_tipo_moneda` enum('PESO','DOLAR') NOT NULL,
  `cue_cbu` varchar(22) NOT NULL,
  `cue_alias` varchar(20) DEFAULT NULL,
  `cue_saldo` double NOT NULL DEFAULT 1000.5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`cue_id`, `cue_user_id`, `cue_nro_cuenta`, `cue_tipo_cuenta`, `cue_tipo_moneda`, `cue_cbu`, `cue_alias`, `cue_saldo`) VALUES
(1, 1, '1110007388304', 'CA', 'PESO', '8178931111100090844390', 'PEPE.GRILLO.NOBO', 5525.04),
(2, 1, '1110003463080', 'CC', 'PESO', '8178931111100090844390', 'PEPE.ARBOL.PEZ', 1700),
(3, 1, '1110003983649', 'CA', 'DOLAR', '1167527311100013827383', 'PEPE.ZAPATO.SOL', 15200),
(4, 1, '1110001622195', 'CA', 'PESO', '9697408911100016221953', 'BBE.FORMA.DOS', 5775.46),
(5, 2, '1110007166460', 'CC', 'PESO', '1423372211100045866114', 'LABIO.ROJO', 8500),
(6, 2, '1110001227573', 'CA', 'DOLAR', '9377438511100028664801', 'SOL.PRETAL', 6306.02),
(7, 2, '1110009512721', 'CA', 'DOLAR', '6976629311100095127218', 'SORBO.LARGO', 85695.24),
(8, 3, '1110004561845', 'CA', 'PESO', '9280460711100045618456', 'LABIO.ROJO', 9024.58),
(9, 4, '1110004207647', 'CA', 'PESO', '5657934311100042076471', 'SOL.PRETAL', 12471.5),
(10, 4, '1110009741655', 'CA', 'DOLAR', '7104932211100005711573', 'SORBO.LARGO', 22051.25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `mov_id` int(11) NOT NULL,
  `mov_cuenta_origen_id` int(11) NOT NULL,
  `mov_cuenta_destino_id` int(11) NOT NULL,
  `mov_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mov_nro_transaccion` varchar(30) NOT NULL,
  `mov_descripcion` varchar(50) NOT NULL,
  `mov_importe` double NOT NULL,
  `mov_saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`mov_id`, `mov_cuenta_origen_id`, `mov_cuenta_destino_id`, `mov_fecha`, `mov_nro_transaccion`, `mov_descripcion`, `mov_importe`, `mov_saldo`) VALUES
(150, 1, 4, '2023-06-20 01:51:21', '1687225881949', 'Transferencia de dinero', 167.5, 4400),
(151, 4, 1, '2023-06-20 01:51:21', '1687225881949', 'Ingreso de dinero', 167.5, 6907.99),
(152, 1, 4, '2023-06-20 01:52:06', '16872259268936', 'Transferencia de dinero', 13, 4387),
(153, 4, 1, '2023-06-20 01:52:06', '16872259268936', 'Ingreso de dinero', 13, 6920.99),
(154, 1, 4, '2023-06-20 01:52:29', '16872259494482', 'Transferencia de dinero', 80.01, 4306.99),
(155, 4, 1, '2023-06-20 01:52:29', '16872259494483', 'Ingreso de dinero', 80.01, 7001),
(156, 1, 4, '2023-06-20 01:53:13', '16872259932769', 'Transferencia de dinero', 120, 4186.99),
(157, 4, 0, '2023-06-20 01:53:13', '16872259932769', 'Ingreso de dinero', 120, 7121),
(158, 1, 4, '2023-06-20 01:57:07', '16872262271204', 'Transferencia de dinero', 100, 4086.99),
(159, 4, 1, '2023-06-20 01:57:07', '16872262271204', 'Ingreso de dinero', 100, 7221),
(160, 1, 4, '2023-06-20 01:57:40', '16872262608938', 'Transferencia de dinero', 1241.2, 2845.79),
(161, 4, 1, '2023-06-20 01:57:40', '16872262608938', 'Ingreso de dinero', 1241.2, 8462.2),
(162, 4, 1, '2023-06-20 01:57:51', '16872262717159', 'Transferencia de dinero', 5000, 3462.2),
(163, 1, 4, '2023-06-20 01:57:51', '16872262717159', 'Ingreso de dinero', 5000, 7845.79),
(164, 1, 4, '2023-06-20 01:58:20', '16872263007444', 'Transferencia de dinero', 65, 7780.79),
(165, 4, 1, '2023-06-20 01:58:20', '16872263007444', 'Ingreso de dinero', 65, 3527.2),
(166, 1, 4, '2023-06-20 01:58:30', '16872263105483', 'Transferencia de dinero', 80.79, 7700),
(167, 4, 1, '2023-06-20 01:58:30', '16872263105483', 'Ingreso de dinero', 80.79, 3607.99),
(168, 1, 2, '2023-06-20 02:03:28', '1687226608639', 'Transferencia de dinero', 23, 7677),
(169, 2, 1, '2023-06-20 02:03:28', '1687226608639', 'Ingreso de dinero', 23, 1715.51),
(170, 1, 4, '2023-06-20 02:13:15', '16872271956563', 'Transferencia de dinero', 77, 7600),
(171, 4, 1, '2023-06-20 02:13:15', '16872271956563', 'Ingreso de dinero', 77, 3684.99),
(172, 1, 4, '2023-06-21 00:53:50', '16873088309232', 'Transferencia de dinero', 32, 7568),
(173, 4, 1, '2023-06-21 00:53:50', '16873088309232', 'Ingreso de dinero', 32, 3716.99),
(174, 1, 4, '2023-06-21 04:39:21', '16873223618179', 'Transferencia de dinero', 152.25, 7415.75),
(175, 4, 1, '2023-06-21 04:39:21', '16873223618179', 'Ingreso de dinero', 152.25, 3869.24),
(176, 1, 4, '2023-06-21 04:39:34', '16873223743957', 'Transferencia de dinero', 15.75, 7400),
(177, 4, 1, '2023-06-21 04:39:34', '16873223743957', 'Ingreso de dinero', 15.75, 3884.99),
(178, 2, 1, '2023-06-21 12:33:57', '1687350837358', 'Transferencia de dinero', 15.51, 1700),
(179, 1, 2, '2023-06-21 12:33:57', '1687350837358', 'Ingreso de dinero', 15.51, 7415.51),
(180, 1, 4, '2023-06-21 12:56:43', '16873522033648', 'Transferencia de dinero', 152.52, 7262.99),
(181, 4, 1, '2023-06-21 12:56:43', '16873522033648', 'Ingreso de dinero', 152.52, 4037.51),
(182, 1, 4, '2023-06-21 12:56:56', '16873522161533', 'Transferencia de dinero', 20.2, 7242.79),
(183, 4, 1, '2023-06-21 12:56:56', '16873522161533', 'Ingreso de dinero', 20.2, 4057.71),
(184, 1, 4, '2023-06-21 12:57:25', '16873522458151', 'Transferencia de dinero', 1524.25, 5718.54),
(185, 4, 1, '2023-06-21 12:57:25', '16873522458151', 'Ingreso de dinero', 1524.25, 5581.96),
(186, 1, 4, '2023-06-21 12:57:39', '16873522599791', 'Transferencia de dinero', 41.5, 5677.04),
(187, 4, 1, '2023-06-21 12:57:39', '16873522599791', 'Ingreso de dinero', 41.5, 5623.46),
(188, 1, 4, '2023-06-21 13:32:59', '16873543790155', 'Transferencia de dinero', 152, 5525.04),
(189, 4, 1, '2023-06-21 13:32:59', '16873543790155', 'Ingreso de dinero', 152, 5775.46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `user_nombre` varchar(50) NOT NULL,
  `user_apellido` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_contacto` varchar(50) DEFAULT NULL,
  `user_sexo` enum('M','F','O') DEFAULT NULL,
  `user_intentos` int(11) NOT NULL DEFAULT 3,
  `user_habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `user_nombre`, `user_apellido`, `user_email`, `user_password`, `user_contacto`, `user_sexo`, `user_intentos`, `user_habilitado`) VALUES
(1, 'Maximiliano', 'Pisso', 'mpisso@gmail.com', '7e713a2eef2ca385b216ad6722b58558de3cad1f6e016f2cd1bdffac62d22d0d', '3413346634', 'M', 3, 1),
(2, 'Tamara', 'Sultano', 'tsultano@gmail.com', '8e66383abdf7de949387ce429c9a36ca10e074b8edd8878cb38f2785be141177', '3413458541', 'F', 0, 0),
(3, 'Maria', 'Gomez', 'mgomez@gmail.com', '9cb52876243af5d83d94e749abcb31a51356e255058d27717798d9e0dbd89f72', '3416548562', 'F', 2, 1),
(4, 'Emiliano', 'Cinquini', 'ecinquini@gmail.com', '1a20f6dad182e8b73b7a7793ca9b4cdaea33bf4efd59ab03291b967389c4faaa', '3415493162', 'M', 3, 1),
(5, 'Vicente', 'Vásquez', 'vicente.vasquez@example.com', 'ce950e64929630ffe525beb3e2f59269602daccccae41d6c369159e35215c3b6', '3415968778', 'M', 3, 1),
(6, 'Marcos', 'Abila', 'marcos.abila@hotmail.com', '6a8299a2284437e6da4531d72d48f53aa967e9db7bc00fc6152d82fd119dddb2', '3415968778', 'M', 3, 1),
(7, 'Gisella', 'Love', 'gise.love@gmail.com', '6234113fef7a822f5bbbb65d2f14efe0d84a6931b8d058c40c3e25c8a1882058', '3415968778', 'F', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`cue_id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`mov_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  MODIFY `user_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `cue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `mov_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
