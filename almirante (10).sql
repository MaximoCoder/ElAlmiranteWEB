-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 01:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `almirante`
--
CREATE DATABASE IF NOT EXISTS `almirante` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `almirante`;

-- --------------------------------------------------------

--
-- Table structure for table `asignación`
--

CREATE TABLE `asignación` (
  `IdUsuario` int(11) NOT NULL,
  `IdRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `asignación`
--

INSERT INTO `asignación` (`IdUsuario`, `IdRol`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `IdCategoría` int(11) NOT NULL,
  `NombreCategoría` varchar(120) NOT NULL,
  `Estado` varchar(7) NOT NULL,
  `FechaCreación` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`IdCategoría`, `NombreCategoría`, `Estado`, `FechaCreación`) VALUES
(1, 'Especialidades', 'Activa', '2003-10-24'),
(2, 'Camarones', 'Activa', '2003-10-24'),
(3, 'Entradas', 'Activa', '2003-10-24'),
(4, 'Caldos', 'Activa', '2003-10-24'),
(5, 'Otros', 'Activa', '2003-10-24'),
(6, 'Bebidas', 'Activa', '2003-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `detalleorden`
--

CREATE TABLE `detalleorden` (
  `IdDetalleOrden` int(11) NOT NULL,
  `IdOrden` int(11) NOT NULL,
  `IdPlatillo` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalleorden`
--

INSERT INTO `detalleorden` (`IdDetalleOrden`, `IdOrden`, `IdPlatillo`, `Cantidad`, `PrecioUnitario`, `Subtotal`) VALUES
(1, 1, 27, 2, 170.00, 340.00),
(2, 1, 28, 1, 170.00, 170.00),
(4, 3, 41, 2, 135.00, 270.00),
(5, 4, 27, 2, 170.00, 340.00),
(6, 5, 31, 1, 460.00, 460.00),
(7, 5, 21, 1, 160.00, 160.00),
(8, 5, 44, 1, 600.00, 600.00),
(9, 5, 27, 2, 170.00, 340.00),
(10, 6, 27, 1, 170.00, 170.00),
(13, 7, 37, 1, 150.00, 150.00),
(14, 8, 27, 1, 170.00, 170.00),
(15, 9, 20, 1, 180.00, 180.00),
(16, 10, 21, 1, 160.00, 160.00),
(17, 10, 44, 1, 600.00, 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `detalleventa`
--

CREATE TABLE `detalleventa` (
  `IdDetalleVenta` int(11) NOT NULL,
  `IdVenta` int(11) NOT NULL,
  `IdPlatillo` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalleventa`
--

INSERT INTO `detalleventa` (`IdDetalleVenta`, `IdVenta`, `IdPlatillo`, `Cantidad`, `PrecioUnitario`, `Subtotal`) VALUES
(1, 1, 27, 2, 170.00, 340.00),
(2, 1, 28, 1, 170.00, 170.00),
(4, 2, 41, 2, 135.00, 270.00),
(5, 3, 27, 2, 170.00, 340.00),
(6, 4, 31, 1, 460.00, 460.00),
(7, 4, 21, 1, 160.00, 160.00),
(8, 4, 44, 1, 600.00, 600.00),
(9, 4, 27, 2, 170.00, 340.00),
(10, 5, 27, 1, 170.00, 170.00),
(13, 6, 37, 1, 150.00, 150.00),
(14, 7, 27, 1, 170.00, 170.00),
(15, 8, 20, 1, 180.00, 180.00),
(16, 9, 21, 1, 160.00, 160.00),
(17, 9, 44, 1, 600.00, 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `orden`
--

CREATE TABLE `orden` (
  `IdOrden` int(11) NOT NULL,
  `IdVenta` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `FechaOrden` datetime NOT NULL,
  `MontoOrden` decimal(10,2) NOT NULL,
  `EstadoOrden` varchar(20) NOT NULL,
  `Observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orden`
--

INSERT INTO `orden` (`IdOrden`, `IdVenta`, `IdCliente`, `FechaOrden`, `MontoOrden`, `EstadoOrden`, `Observaciones`) VALUES
(1, 1, 4, '2024-11-07 02:29:39', 510.00, 'Pendiente', ''),
(3, 2, 4, '2024-11-07 02:34:34', 270.00, 'Pendiente', ''),
(4, 3, 4, '2024-11-07 02:52:58', 340.00, 'Pendiente', ''),
(5, 4, 4, '2024-11-07 02:57:03', 1560.00, 'Pendiente', ''),
(6, 5, 4, '2024-11-07 03:59:58', 170.00, 'Pendiente', ''),
(7, 6, 4, '2024-11-09 05:03:42', 150.00, 'Pendiente', ''),
(8, 7, 4, '2024-11-09 05:08:16', 170.00, 'Pendiente', ''),
(9, 8, 4, '2024-11-09 05:12:39', 180.00, 'Pendiente', ''),
(10, 9, 2, '2024-11-15 18:17:43', 760.00, 'Pendiente', 'No me gusta el aguacate!!!');

-- --------------------------------------------------------

--
-- Table structure for table `platillo`
--

CREATE TABLE `platillo` (
  `IdPlatillo` int(11) NOT NULL,
  `NombrePlatillo` varchar(150) NOT NULL,
  `DescripcionPlatillo` varchar(299) NOT NULL,
  `PrecioPlatillo` decimal(5,2) NOT NULL,
  `Disponibilidad` varchar(45) NOT NULL,
  `IdCategoria` int(11) NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `platillo`
--

INSERT INTO `platillo` (`IdPlatillo`, `NombrePlatillo`, `DescripcionPlatillo`, `PrecioPlatillo`, `Disponibilidad`, `IdCategoria`, `img`) VALUES
(20, 'Bardal', 'Deliciosa combinación de mariscos frescos que incluye callo de hacha, pulpo, jaiba y camarón. Servido con nuestra salsa coctelera especial, un toque de limón y vinagre. Una explosión de sabores marinos en cada bocado, ideal para los amantes de los mariscos que buscan frescura y sabor.', 180.00, 'Disponible', 3, 'Bardal.jpg'),
(21, 'Camarones Empanizados', 'Deliciosos camarones empanizados, crujientes por fuera y tiernos por dentro, acompañados de papas a la francesa. Incluye un aro de cebolla crujiente, una fresca guarnición de lechuga y tomate, y una porción de arroz blanco. Una combinación perfecta de sabores y texturas que satisfará todos tus anto', 160.00, 'Disponible', 2, 'CamaronesEmpanizados.jpg'),
(23, 'Camarones rellenos de queso', 'Suculentos camarones rellenos de queso fundido y envueltos en tocino crujiente. Acompañados de papas a la francesa doradas, un aro de cebolla crujiente, una fresca guarnición de lechuga y tomate, y una porción de arroz blanco. Una explosión de sabores que combina lo mejor del mar y la tierra en cad', 185.00, 'Disponible', 2, 'CamaronesRellenosDeQueso.jpg'),
(24, 'Tostadas de ceviche', 'Dos crujientes tostadas coronadas con nuestro fresco ceviche y rodajas de aguacate cremoso. Una combinación perfecta de texturas y sabores cítricos que capturan la esencia del mar en cada bocado.', 65.00, 'Disponible', 3, 'tostadasCeviche.jpg'),
(27, 'Orden de Tacos ', 'Disfruta de una selección de nuestros tacos más populares. Elige tres piezas entre: Tacos Gobernador con camarones y queso, Tacos Mazatlán estilo marinero, o Tacos al Pastor con su toque tradicional. Una experiencia culinaria que te permite saborear lo mejor de nuestra cocina en una sola orden.', 170.00, 'Disponible', 1, 'TacosGobernador,MazatlanyPastor.png'),
(28, 'Mojarra Frita', 'Disfruta de nuestra crujiente mojarra frita, acompañada de fresca lechuga, jugosos tomates, un delicioso aro de cebolla, papas fritas doradas y arroz blanco. ¡Un festín de sabores del mar que no te puedes perder!', 170.00, 'Disponible', 1, 'MojarraFrita.jpg'),
(29, 'Mariscada personal', 'Deléitate con nuestra mariscada personal, que incluye unos filetes de pescado empanizado y camarones empanizados, todo en una presentación perfecta. Acompañado de papas fritas crujientes y un aro de cebolla dorado, este platillo se sirve sobre una fresca base de lechuga y tomate. ¡Una explosión de ', 175.00, 'Disponible', 1, 'MariscadaPersonal.jpg'),
(31, 'Mariscada Tridente', 'Disfruta de nuestra mariscada tridente, un festín de sabores que incluye arroz blanco, fresca lechuga y tomate, camarones empanizados, filetes de pescado empanizados, crujientes aros de cebolla, papas fritas doradas, y deliciosas tostadas de ceviche. ¡Una experiencia gastronómica completa que delei', 460.00, 'Disponible', 1, 'Mariscada Tridente.jpg'),
(34, 'Aguachile Tradicional', 'Deliciosa preparación de camarones frescos marinados en una vibrante salsa de chile, limón y especias. Servido con rodajas de pepino y cebolla morada, este platillo ofrece un equilibrio perfecto entre picante y cítrico que despierta todos los sentidos. Una experiencia refrescante y auténtica de la ', 180.00, 'Disponible', 3, 'Aguachile_Tradicional.png'),
(35, 'Aguachile Diabla', 'Una explosión de sabor y calor en cada bocado. Camarones frescos bañados en una intensa salsa roja de chiles picantes y especias, con un toque de limón para equilibrar. Acompañado de rodajas de pepino y cebolla morada para refrescar el paladar. Advertencia: Este platillo no es para los débiles de c', 180.00, 'Disponible', 3, 'Aguachile_Diabla.png'),
(37, 'Cazuela', 'Sumérgete en un festín marino con nuestra abundante cazuela. Una combinación rica y humeante de mariscos variados, cocidos lentamente en un caldo sabroso con verduras frescas y especias aromáticas. Servida directamente en su recipiente de barro tradicional, esta cazuela captura la esencia de los sa', 150.00, 'Disponible', 4, 'Cazuela.png'),
(40, 'Coctel de camarones', 'Refrescante y sabroso, nuestro coctel de camarones es una delicia marina por excelencia. Tiernos camarones bañados en una salsa coctelera casera con toques de limón fresco, servidos en una copa elegante con un borde de limón. Acompañado de aguacate cremoso, cebolla crujiente y cilantro fresco. La c', 180.00, 'Disponible', 3, 'Coctel de camarones.jpg'),
(41, 'Filete de pescado empanizado', 'Delicioso filete de pescado con una cobertura dorada y crujiente, acompañado de una variedad de guarniciones que complementan perfectamente su sabor. Servido con papas fritas crujientes, un aro de cebolla dorado, una fresca guarnición de lechuga y tomate, y una porción de arroz blanco esponjoso. Un', 135.00, 'Disponible', 1, 'Filete de Pescado.jpg'),
(44, 'Mariscada Suprema', 'Festín marino para compartir. Incluye mojarra frita, camarones rellenos envueltos en tocino, camarones empanizados, filete de pescado, aros de cebolla y papas fritas. Acompañado de lechuga, tomate y arroz blanco. Una abundante selección de sabores del mar para disfrutar en familia o con amigos.', 600.00, 'Disponible', 1, 'MariscadaSuprema.jpg'),
(48, 'Prueba', 'Prueba de producto', 10.00, 'Disponible', 6, 'pexels-pixabay-45170.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `IdRol` int(11) NOT NULL,
  `NombreRol` varchar(100) NOT NULL,
  `DescripciónRol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`IdRol`, `NombreRol`, `DescripciónRol`) VALUES
(1, 'Admin', 'Administrador de la pagina web');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud`
--

CREATE TABLE `solicitud` (
  `IdSolicitud` int(11) NOT NULL,
  `DisponibilidadEntrevista` varchar(120) NOT NULL,
  `CurriculumURL` varchar(500) NOT NULL,
  `Experiencia` varchar(200) NOT NULL,
  `EstadoSolicitud` bit(1) NOT NULL,
  `FechaSolicitud` date NOT NULL,
  `IdVacante` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nombre` mediumtext NOT NULL,
  `Correo` varchar(319) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `FechaCreacion` datetime NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nombre`, `Correo`, `Password`, `FechaCreacion`, `Estado`, `Code`) VALUES
(2, 'Maximo Gonzalez Nacianceno', 'admin@test.com', '$2y$10$7NfPh/pLfD.Y9XbUvwArbOCV7ozXAK1KMX4ibkLYoAx4D81rBHqxO', '2024-08-31 01:26:25', b'1', NULL),
(3, 'Pepito pruebas', 'pepito@pepito.com', '$2y$10$08fNDmWkkEtHgNKFRPgtGeBokB7UNHCp3L2FBvEkIivmW6/Ojdu8q', '2024-08-31 01:30:23', b'0', NULL),
(4, 'ame', 'ame@gmai.com', '$2y$10$yk80wSueuPuLyyWtq/DXFeg/WkVjxIlmtYEGCpDtYhMaFqz2gB5Fe', '2024-09-30 21:07:52', b'1', '54410');

-- --------------------------------------------------------

--
-- Table structure for table `vacante`
--

CREATE TABLE `vacante` (
  `IdVacante` int(11) NOT NULL,
  `nombreVacante` varchar(255) DEFAULT NULL,
  `descripcionVacante` text DEFAULT NULL,
  `Activa` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `vacante`
--

INSERT INTO `vacante` (`IdVacante`, `nombreVacante`, `descripcionVacante`, `Activa`) VALUES
(2, 'Cajero', 'Requisitos: \n-Experiencia en manejar caja registradora\n-Limpieza y buena atención al cliente\n-Edad: 18 a 55 años\n-Disponibilidad de horario (Turnos completos y medio tiempo)\n\nOfrecemos:\n-Sueldo semanal: $1,800\n-Comedor subsidiado\n-Uniforme\n-Descuento en restaurante\n-Descanso de 2 días a escoger', b'1'),
(3, 'Mesero', 'Requisitos: \n-Saber meserear\n-Limpieza y buena atención al cliente\n-Edad: 18 a 55 años \n\nOfrecemos: \n-Sueldo semanal: $2,200 \n-Propinas', b'1'),
(5, 'Lavaloza', 'Requisitos: \n-Saber lavar platos y ollas\n-Limpieza y trabajo en equipo\n-Edad: 18 a 55 años \n\nOfrecemos: \n-Sueldo semanal: $3,000\n-Propinas', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `IdVenta` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `FechaVenta` datetime NOT NULL,
  `MontoTotal` decimal(10,2) NOT NULL,
  `TipoPago` varchar(20) NOT NULL,
  `EstadoPago` varchar(20) NOT NULL,
  `IdPagoPaypal` varchar(255) DEFAULT NULL,
  `EstadoVenta` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`IdVenta`, `IdCliente`, `FechaVenta`, `MontoTotal`, `TipoPago`, `EstadoPago`, `IdPagoPaypal`, `EstadoVenta`) VALUES
(1, 4, '2024-11-07 02:29:39', 510.00, 'pago en tienda', 'Pendiente', NULL, 'pendiente'),
(2, 4, '2024-11-07 02:34:34', 270.00, 'pago en tienda', 'Pendiente', NULL, 'pendiente'),
(3, 4, '2024-11-07 02:52:58', 340.00, 'pago en tienda', 'Pendiente', NULL, 'pendiente'),
(4, 4, '2024-11-07 02:57:03', 1560.00, 'pago en tienda', 'Pendiente', NULL, 'pendiente'),
(5, 4, '2024-11-07 03:59:58', 170.00, 'pago en tienda', 'Pendiente', NULL, 'pendiente'),
(6, 4, '2024-11-09 05:03:42', 150.00, 'Pago en linea', 'Completado', '8EU7784094237412Y', 'pendiente'),
(7, 4, '2024-11-09 05:08:16', 170.00, 'Pago en linea', 'Completado', '0TJ620130D083651C', 'pendiente'),
(8, 4, '2024-11-09 05:12:39', 180.00, 'Pago en linea', 'Completado', '02T36548K7212522F', 'pendiente'),
(9, 2, '2024-11-15 18:17:43', 760.00, 'pago en tienda', 'Pendiente', NULL, 'pendiente');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asignación`
--
ALTER TABLE `asignación`
  ADD PRIMARY KEY (`IdUsuario`,`IdRol`),
  ADD KEY `fk_Usuario_has_Rol_Rol1_idx` (`IdRol`),
  ADD KEY `fk_Usuario_has_Rol_Usuario1_idx` (`IdUsuario`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IdCategoría`);

--
-- Indexes for table `detalleorden`
--
ALTER TABLE `detalleorden`
  ADD PRIMARY KEY (`IdDetalleOrden`),
  ADD KEY `IdOrden` (`IdOrden`),
  ADD KEY `IdPlatillo` (`IdPlatillo`) USING BTREE;

--
-- Indexes for table `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`IdDetalleVenta`),
  ADD KEY `IdVenta` (`IdVenta`),
  ADD KEY `IdPlatillo` (`IdPlatillo`) USING BTREE;

--
-- Indexes for table `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`IdOrden`),
  ADD KEY `IdVenta` (`IdVenta`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- Indexes for table `platillo`
--
ALTER TABLE `platillo`
  ADD PRIMARY KEY (`IdPlatillo`),
  ADD KEY `fk_categoria` (`IdCategoria`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indexes for table `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`IdSolicitud`,`IdVacante`,`IdUsuario`),
  ADD KEY `fk_Solicitud_Vacante1_idx` (`IdVacante`),
  ADD KEY `fk_Solicitud_Usuario1_idx` (`IdUsuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- Indexes for table `vacante`
--
ALTER TABLE `vacante`
  ADD PRIMARY KEY (`IdVacante`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IdCategoría` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `detalleorden`
--
ALTER TABLE `detalleorden`
  MODIFY `IdDetalleOrden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `detalleventa`
--
ALTER TABLE `detalleventa`
  MODIFY `IdDetalleVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orden`
--
ALTER TABLE `orden`
  MODIFY `IdOrden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `platillo`
--
ALTER TABLE `platillo`
  MODIFY `IdPlatillo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vacante`
--
ALTER TABLE `vacante`
  MODIFY `IdVacante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asignación`
--
ALTER TABLE `asignación`
  ADD CONSTRAINT `fk_Usuario_has_Rol_Rol1` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Usuario_has_Rol_Usuario1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalleorden`
--
ALTER TABLE `detalleorden`
  ADD CONSTRAINT `detalleorden_ibfk_1` FOREIGN KEY (`IdOrden`) REFERENCES `orden` (`IdOrden`),
  ADD CONSTRAINT `detalleorden_ibfk_2` FOREIGN KEY (`IdPlatillo`) REFERENCES `platillo` (`IdPlatillo`);

--
-- Constraints for table `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `detalleventa_ibfk_1` FOREIGN KEY (`IdVenta`) REFERENCES `venta` (`IdVenta`),
  ADD CONSTRAINT `detalleventa_ibfk_2` FOREIGN KEY (`IdPlatillo`) REFERENCES `platillo` (`IdPlatillo`);

--
-- Constraints for table `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`IdVenta`) REFERENCES `venta` (`IdVenta`),
  ADD CONSTRAINT `orden_ibfk_2` FOREIGN KEY (`IdCliente`) REFERENCES `usuario` (`IdUsuario`);

--
-- Constraints for table `platillo`
--
ALTER TABLE `platillo`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`IdCategoria`) REFERENCES `categoria` (`IdCategoría`);

--
-- Constraints for table `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `fk_Solicitud_Usuario1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Solicitud_Vacante1` FOREIGN KEY (`IdVacante`) REFERENCES `vacante` (`IdVacante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`IdCliente`) REFERENCES `usuario` (`IdUsuario`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"almirante\",\"table\":\"vacante\"},{\"db\":\"punto_venta_java\",\"table\":\"usuario\"},{\"db\":\"punto_venta_java\",\"table\":\"proveedor\"},{\"db\":\"punto_venta_java\",\"table\":\"producto\"},{\"db\":\"punto_venta_java\",\"table\":\"detalle\"},{\"db\":\"punto_venta_java\",\"table\":\"configuracion\"},{\"db\":\"punto_venta_java\",\"table\":\"clientes\"},{\"db\":\"almirante\",\"table\":\"rol\"},{\"db\":\"almirante\",\"table\":\"usuario\"},{\"db\":\"almirante\",\"table\":\"detalleorden\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'almirante', 'categoria', '{\"sorted_col\":\"`categoria`.`Estado` ASC\"}', '2024-11-14 18:51:19'),
('root', 'almirante', 'vacante', '[]', '2024-11-17 17:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2024-11-16 22:20:06', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `punto_venta_java`
--
CREATE DATABASE IF NOT EXISTS `punto_venta_java` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `punto_venta_java`;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `ID` int(11) NOT NULL,
  `DNI` int(20) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `TELEFONO` bigint(15) NOT NULL,
  `DIRECCION` varchar(100) NOT NULL,
  `RAZON_SOCIAL` varchar(100) NOT NULL,
  `FECHA` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`ID`, `DNI`, `NOMBRE`, `TELEFONO`, `DIRECCION`, `RAZON_SOCIAL`, `FECHA`) VALUES
(1, 1234, 'Juan Estevez', 1238961900, 'Chiquinquirá', '', '2022-02-28 14:39:27'),
(6, 1001789654, 'Pedro Rosales', 3008765429, 'Fusagasugá', '', '2022-02-28 17:25:02'),
(11, 1035678900, 'Maluma Baby', 3105809976, 'Medellín', '122334', '2022-03-12 11:36:33'),
(13, 1234561728, 'Margot Robbie', 3156782343, 'Manizales', '123115', '2023-02-21 15:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `RUT` bigint(20) DEFAULT NULL,
  `TELEFONO` bigint(20) DEFAULT NULL,
  `DIRECCION` varchar(100) NOT NULL,
  `RAZON_SOCIAL` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`ID`, `NOMBRE`, `RUT`, `TELEFONO`, `DIRECCION`, `RAZON_SOCIAL`) VALUES
(1, 'Empresa XYZ', 1234567890, 3219113222, 'BARBOSA', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `detalle`
--

CREATE TABLE `detalle` (
  `ID` int(11) NOT NULL,
  `CODIGO_PRODUCTO` varchar(30) DEFAULT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `PRECIO` decimal(10,2) NOT NULL,
  `ID_VENTA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalle`
--

INSERT INTO `detalle` (`ID`, `CODIGO_PRODUCTO`, `CANTIDAD`, `PRECIO`, `ID_VENTA`) VALUES
(1, '10', 10, 25000.00, 0),
(2, '4', 4, 1200.00, 0),
(3, '89', 89, 25000.00, 0),
(4, '4', 4, 1200.00, 0),
(5, '12', 12, 25000.00, 0),
(6, '100', 100, 25000.00, 0),
(7, '30', 30, 25000.00, 0),
(8, '34', 34, 1200.00, 0),
(9, '30', 30, 25000.00, 0),
(10, '34', 34, 1200.00, 0),
(11, '13', 13, 25000.00, 0),
(12, '4', 4, 25000.00, 0),
(13, '2', 2, 1200.00, 0),
(14, '56', 56, 25000.00, 0),
(15, '5', 5, 25000.00, 0),
(16, '4', 4, 25000.00, 0),
(17, '12', 12, 1200.00, 0),
(18, '5', 5, 25000.00, 0),
(19, '4', 4, 25000.00, 0),
(20, '12', 12, 25000.00, 0),
(21, '4', 4, 2000000.00, 0),
(22, '4', 4, 25000.00, 0),
(23, '1', 1, 25000.00, 0),
(24, '2', 2, 25000.00, 0),
(25, '6', 6, 25000.00, 0),
(26, '', 5, 25000.00, 0),
(27, '', 5, 25000.00, 0),
(28, 'e100', 8, 25000.00, 0),
(29, 'prueba', 13, 2700.89, 0),
(30, 't67', 4, 1200.00, 0),
(31, 't67', 67, 1200.00, 0),
(32, 't67', 23, 1200.00, 0),
(33, 't67', 1, 1200.00, 0),
(34, 'g89', 34, 2000000.00, 0),
(35, 't67', 3, 1200.00, 0),
(36, 'g89', 23, 2000000.00, 0),
(37, 't67', 12, 1200.00, 0),
(38, 't67', 124, 1200.00, 0),
(39, '678', 2, 1200.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `ID` int(11) NOT NULL,
  `CODIGO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(255) NOT NULL,
  `PROVEEDOR` varchar(100) NOT NULL,
  `STOCK` int(11) NOT NULL,
  `PRECIO` decimal(10,2) NOT NULL,
  `FECHA` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`ID`, `CODIGO`, `DESCRIPCION`, `PROVEEDOR`, `STOCK`, `PRECIO`, `FECHA`) VALUES
(2, '678', 'Jabon Dove', 'Martín Caceres', 117, 1200.00, '2022-03-01 17:18:22'),
(4, 'e100', 'Silla Rimax', 'Martín Caceres', 492, 25000.00, '2022-03-04 10:39:15'),
(6, 'g89', 'Computador Compumax', 'Margot Robbie', 143, 2000000.00, '2022-03-11 16:50:40');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `ID` int(20) NOT NULL,
  `RUT` bigint(20) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `TELEFONO` bigint(15) NOT NULL,
  `DIRECCION` varchar(100) NOT NULL,
  `RAZON_SOCIAL` varchar(100) NOT NULL,
  `FECHA` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`ID`, `RUT`, `NOMBRE`, `TELEFONO`, `DIRECCION`, `RAZON_SOCIAL`, `FECHA`) VALUES
(1, 1082345900, 'Martín Caceres', 3000897000, 'Pereira', 'PEj8', '2022-02-28 17:25:27'),
(4, 10098903456, 'Margot Robbie', 3154670220, 'Barranquilla', '', '2022-03-11 16:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `CORREO` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `ROL` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`ID`, `NOMBRE`, `CORREO`, `PASSWORD`, `ROL`) VALUES
(1, 'Juan Carlos Estevez', 'juan@example.com', '1234', 'Administrador'),
(11, 'Pedro Prueba', 'prueba@mail.com', '1234', 'Asistente');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `ID` int(11) NOT NULL,
  `CLIENTE` varchar(100) NOT NULL,
  `VENDEDOR` varchar(100) NOT NULL,
  `TOTAL` decimal(12,2) NOT NULL,
  `FECHA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`ID`, `CLIENTE`, `VENDEDOR`, `TOTAL`, `FECHA`) VALUES
(35, 'Margot Robbie', 'Juan Carlos Estevez', 2400.00, '16/11/2024');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detalle`
--
ALTER TABLE `detalle`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
