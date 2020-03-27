-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-03-2020 a las 09:27:49
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema-de-facturacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Direccion` varchar(30) NOT NULL,
  `Estado` varchar(10) NOT NULL DEFAULT 'activo',
  `Agregado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `Nombre`, `Telefono`, `Email`, `Direccion`, `Estado`, `Agregado`) VALUES
(7, 'gaston', '15123456', 'gasty@mail.com', 'av. rivadavia ', 'activo', '2020-02-05 17:44:23'),
(8, 'carlos', '3546812', 'carlos@mail.com', 'av.santa fe', 'activo', '2020-02-05 19:44:23'),
(12, 'pedro', '21646156', 'pedro@mail.com', 'av.cordoba', 'activo', '2020-02-06 01:49:40'),
(13, 'juan', '32155', 'juan@mail.com', 'av.corrientes', 'activo', '2020-02-21 02:40:06'),
(14, 'fernando', '23168463', 'fernando@mail.com', 'av.la plata', 'activo', '2020-02-21 02:40:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_facturas`
--

CREATE TABLE `detalle_facturas` (
  `id_detalle` int(30) NOT NULL,
  `id_factura` int(30) NOT NULL,
  `id_producto` bigint(30) UNSIGNED NOT NULL,
  `cantidad` int(30) NOT NULL,
  `precio_venta` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_facturas`
--

INSERT INTO `detalle_facturas` (`id_detalle`, `id_factura`, `id_producto`, `cantidad`, `precio_venta`) VALUES
(19, 88, 7790070228536, 2, 123),
(20, 88, 7790070411839, 5, 43.5),
(21, 88, 7790130000744, 7, 77),
(22, 89, 7790070228536, 1, 99),
(23, 89, 7790639002416, 3, 34),
(24, 89, 7791905023081, 1, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_cliente` int(30) NOT NULL,
  `id_vendedor` int(30) NOT NULL,
  `total_venta` float NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `fecha`, `id_cliente`, `id_vendedor`, `total_venta`, `estado`) VALUES
(88, '2020-03-26 05:19:09', 7, 3, 1002.5, 'pendiente'),
(89, '2020-03-27 05:22:10', 14, 6, 251, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Codigo` bigint(13) UNSIGNED NOT NULL,
  `Producto` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Estado` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'activo',
  `Agregado` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Codigo`, `Producto`, `Estado`, `Agregado`, `Precio`) VALUES
(7790070228536, 'Aceite Ideal Girasol x 1500 cc', 'activo', '0000-00-00 00:00:00', 99),
(7790070230454, 'Aceite Ideal Girasol x 900 cc', 'activo', '0000-00-00 00:00:00', 75),
(7790070411839, 'Arroz Gallo Parboil bolsa x 500 gr', 'activo', '0000-00-00 00:00:00', 43.5),
(7790130000744, 'Aceto balsámico Monterrey x 250 cc', 'activo', '0000-00-00 00:00:00', 77),
(7790272004457, 'Aceite Cada Día Girasol x 1500 cc', 'activo', '0000-00-00 00:00:00', 121),
(7790272004785, 'Aceite Cada Día Girasol x 900 cc', 'activo', '0000-00-00 00:00:00', 75),
(7790639002416, 'Agua Mineralizada Cellier Favaloro Sin gas x 2 lt', 'activo', '0000-00-00 00:00:00', 34),
(7790639002423, 'Agua Mineralizada Cellier Favaloro Con gas x 2 lt', 'activo', '0000-00-00 00:00:00', 34),
(7790740502454, 'Acondicionador Plusbelle Hidratación x 1 lt', 'activo', '0000-00-00 00:00:00', 99),
(7790940000026, 'Algodón Doncella Hidrófilo clásico x 140 gr', 'activo', '0000-00-00 00:00:00', 77),
(7791120031656, 'Arroz Apóstoles Largo fino x 1 kg', 'activo', '0000-00-00 00:00:00', 54.5),
(7791120098246, 'Arroz Apóstoles No se pasa x 1 kg', 'activo', '0000-00-00 00:00:00', 64),
(7791274198182, 'Acondicionador Algabo Aguacate y argan x 930 ml', 'activo', '0000-00-00 00:00:00', 81),
(7791274198199, 'Acondicionador Algabo Coco y leche x 930 ml', 'activo', '0000-00-00 00:00:00', 81),
(7791274198205, 'Acondicionador Algabo Manzanilla y magnolia x 930 ', 'activo', '0000-00-00 00:00:00', 81),
(7791293034911, 'Acondicionador Sedal Nutrición x 340 ml', 'activo', '0000-00-00 00:00:00', 120),
(7791905023067, 'Acondicionador Polyana Nutrición doypack x 300 ml', 'activo', '0000-00-00 00:00:00', 50),
(7791905023074, 'Acondicionador Polyana Hidratación doypack x 300 m', 'activo', '0000-00-00 00:00:00', 50),
(7791905023081, 'Acondicionador Polyana Balance doypack x 300 ml', 'activo', '0000-00-00 00:00:00', 50),
(7791905023098, 'Acondicionador Polyana Ceramidas doypack x 300 ml', 'activo', '0000-00-00 00:00:00', 50),
(7792180000569, 'Aceite Florencia Girasol x 900 cc', 'activo', '0000-00-00 00:00:00', 75),
(7792180000583, 'Aceite Florencia Girasol x 1500 cc', 'activo', '0000-00-00 00:00:00', 121),
(7794870001344, 'Arroz Primor Largo fino 00000 x 1 kg', 'activo', '0000-00-00 00:00:00', 53.5),
(7794870001887, 'Aceite Primor Girasol x 900 cc', 'activo', '0000-00-00 00:00:00', 75),
(7798065733461, 'Agua Mineral Natural Sierra de los Padres Con gas ', 'activo', '0000-00-00 00:00:00', 41),
(7798065733485, 'Agua Mineral Natural Sierra de los Padres Sin gas ', 'activo', '0000-00-00 00:00:00', 41),
(7798065733669, 'Agua de Mesa Nihuil Sin gas x 2 lt', 'activo', '0000-00-00 00:00:00', 34),
(7798316700082, 'Arroz Primor Parboil x 1 kg', 'activo', '0000-00-00 00:00:00', 66.5),
(7798316700396, 'Aceite Primor Girasol x 1500 cc', 'activo', '0000-00-00 00:00:00', 121),
(9000000000101, 'Atún Supermercado Desmenuzado al natural x 170 gr', 'activo', '0000-00-00 00:00:00', 69);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'gaston', 'gasty@mail.com', NULL, '$2y$10$bIECk/UMB1M5iIg9pf9sE.6kfgzh/Sf7fuWcxn96KVKi82SYsRJ/O', NULL, '2020-03-14 03:47:19', '2020-03-14 03:47:19'),
(2, 'admin', 'admin@admin.com', NULL, '$2y$10$bIECk/UMB1M5iIg9pf9sE.6kfgzh/Sf7fuWcxn96KVKi82SYsRJ/O', NULL, '2020-03-24 14:45:12', '2020-03-24 14:45:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `id_vendedor` int(10) NOT NULL,
  `Nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id_vendedor`, `Nombre`) VALUES
(3, 'vazquez'),
(6, 'vendedor_2'),
(7, 'vendedor_3'),
(8, 'vendedor_4');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id_vendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  MODIFY `id_detalle` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id_vendedor` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
