-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-05-2024 a las 02:56:32
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rematesdyd`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_cant_sales_user`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_cant_sales_user` (IN `idUser` INT, IN `estado` INT)   SELECT  tb2.id AS no_venta,tb2.nombre_cliente, pq.nombre combo,tb2.precio_venta_paquete precio_venta,tb2.porcentaje_paquete porcentaje,tpvh.descripcion vehiculo, tb2.fecha_pago,tb2.fecha as fecha_venta
from venta AS tb2 
INNER JOIN detalle_paquete  dtp on tb2.id_detalle_paquete=dtp.id 
INNER JOIN paquete  pq ON dtp.id_paquete=pq.id
INNER JOIN tipo_vehiculo tpvh ON dtp.id_tipo_vehiculo=tpvh.id
 WHERE  tb2.id_usuario=idUser AND tb2.id_estado_venta=estado$$

DROP PROCEDURE IF EXISTS `sp_expenses`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_expenses` (IN `month` INT)   SELECT IFNULL(ROUND(SUM(tb2.precio_venta_paquete*tb2.porcentaje_paquete/100)),0) egreso, 'Pago empleados' concepto 
from venta AS tb2  
WHERE  DATE_FORMAT(tb2.fecha,'%m')= month 
AND tb2.id_detalle_paquete IS NOT NULL  AND tb2.id_estado_venta=2 AND DATE_FORMAT(tb2.fecha,'%Y') = YEAR(CURDATE())
UNION ALL
SELECT  c.importe_total egreso ,c.compracol  concepto from compra c 
WHERE c.estado_id=2 AND  DATE_FORMAT(c.fecha_emision,'%m')=month AND DATE_FORMAT(c.fecha_emision,'%Y') = YEAR(CURDATE())$$

DROP PROCEDURE IF EXISTS `sp_expenses_month`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_expenses_month` (IN `MONTH` INT)   SELECT IFNULL(SUM(c.importe_total),0) egreso,
(SELECT IFNULL(SUM(ROUND(tb2.precio_venta_paquete*tb2.porcentaje_paquete/100)),0) egreso
from venta AS tb2  
WHERE  DATE_FORMAT(tb2.fecha,'%m')= MONTH
AND tb2.id_detalle_paquete IS NOT NULL  AND tb2.id_estado_venta=2 AND DATE_FORMAT(tb2.fecha,'%Y') = YEAR(CURDATE()) ) nomina
from compra c 
WHERE c.estado_id=2 AND  DATE_FORMAT(c.fecha_emision,'%m')=month AND DATE_FORMAT(c.fecha_emision,'%Y') = YEAR(CURDATE())$$

DROP PROCEDURE IF EXISTS `sp_groupSalesProduct`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_groupSalesProduct` (IN `sp_id_venta` INT)   SELECT DISTINCT(dcp.id_producto), prd.nombre producto,  dvp.id_venta, dvp.precio_venta, (dvp.precio_venta*sum(dvp.cantidad)) total_venta,sum(dvp.cantidad) cantidad_vendida FROM detalle_venta_productos dvp
inner join  detalle_compra_productos dcp on dvp.id_detalle_producto=dcp.id_detalle_compra
INNER join producto prd on  dcp.id_producto=prd.id
where id_venta=sp_id_venta
GROUP by dcp.id_producto$$

DROP PROCEDURE IF EXISTS `sp_incomexproduct`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_incomexproduct` (IN `month` INT)   SELECT    ROUND(SUM(dvp.margen_ganancia*dvp.cantidad)) gananciasxproducto 
from venta AS vt
INNER JOIN detalle_venta_productos dvp ON vt.id=dvp.id_venta
WHERE   
DATE_FORMAT(vt.fecha,'%m')=month  AND  DATE_FORMAT(vt.fecha,'%Y') = YEAR(CURDATE())$$

DROP PROCEDURE IF EXISTS `sp_incomexproduct_day`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_incomexproduct_day` (IN `fechaini` DATE, IN `fechafin` DATE)   SELECT    ROUND(SUM(dvp.margen_ganancia*dvp.cantidad)) gananciasxproducto 
from venta AS vt
INNER JOIN detalle_venta_productos dvp ON vt.id=dvp.id_venta
WHERE   
DATE_FORMAT(vt.fecha,'%Y-%m-%d')  >= fechaini  AND DATE_FORMAT(vt.fecha,'%Y-%m-%d') <= fechafin$$

DROP PROCEDURE IF EXISTS `sp_incomexsales`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_incomexsales` (IN `fechaini` DATE, IN `fechafin` DATE)   SELECT  IFNULL(sum(vt.precio_venta_paquete),0) as total_venta, count(*) cantidad FROM venta vt WHERE vt.id_detalle_paquete IS NOT NULL 
AND DATE_FORMAT(vt.fecha,'%Y-%m-%d')  >= fechaini  AND DATE_FORMAT(vt.fecha,'%Y-%m-%d') <= fechafin$$

DROP PROCEDURE IF EXISTS `sp_incomexservice`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_incomexservice` (IN `month` INT)   SELECT  
IFNULL(SUM(ROUND(tb2.precio_venta_paquete) - ROUND(tb2.precio_venta_paquete*tb2.porcentaje_paquete/100)),0) gananciasxservicio 
from venta AS tb2 
WHERE    
DATE_FORMAT(tb2.fecha,'%m')=month
AND tb2.id_detalle_paquete IS NOT NULL AND DATE_FORMAT(tb2.fecha,'%Y') = YEAR(CURDATE())$$

DROP PROCEDURE IF EXISTS `sp_incomexservice_day`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_incomexservice_day` (IN `fechaini` DATE, IN `fechafin` DATE)   SELECT  
IFNULL(SUM(ROUND(tb2.precio_venta_paquete) - ROUND(tb2.precio_venta_paquete*tb2.porcentaje_paquete/100)),0) gananciasxservicio  
from venta AS tb2 
WHERE    
(DATE_FORMAT(tb2.fecha,'%Y-%m-%d')  >= fechaini  AND DATE_FORMAT(tb2.fecha,'%Y-%m-%d') <= fechafin )
AND tb2.id_detalle_paquete IS NOT NULL$$

DROP PROCEDURE IF EXISTS `sp_products`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_products` (IN `area` VARCHAR(20))   SELECT  pd.nombre producto,m.nombre marca ,tp.descripcion tipo_producto,CONCAT(um.nombre,' - ' ,um.abreviatura) as unidad_medida,ps.nombre presentacion,ar.nombre area,
(SELECT  IFNULL(SUM(dc.cantidad),0) from detalle_compra_productos dc WHERE dc.id_producto=pd.id) - (SELECT    IFNULL(SUM(dv.cantidad),0) from detalle_compra_productos dc  INNER join detalle_venta_productos dv  ON dc.id_detalle_compra=dv.id_detalle_producto WHERE dc.id_producto=pd.id ) cant_disponible, 
pd.id,pd.id_tipo_producto,pd.id_marca,pd.id_unidad_medida,pd.id_presentacion,pd.precio_venta,pd.imagen
FROM  producto  pd
INNER JOIN marca m ON pd.id_marca=m.id
INNER JOIN tipo_producto tp ON pd.id_tipo_producto=tp.id
INNER JOIN unidad_medida um ON pd.id_unidad_medida=um.id
INNER JOIN presentacion ps ON pd.id_presentacion=ps.id
INNER JOIN area ar ON pd.id_area=ar.id
WHERE ar.id IN(area)$$

DROP PROCEDURE IF EXISTS `sp_products_all`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_products_all` ()   SELECT  pd.nombre producto,m.nombre marca ,tp.descripcion tipo_producto,CONCAT(um.nombre,' - ' ,um.abreviatura) as unidad_medida,ps.nombre presentacion,ar.nombre area,
(SELECT  IFNULL(SUM(dc.cantidad),0) from detalle_compra_productos dc WHERE dc.id_producto=pd.id) - (SELECT    IFNULL(SUM(dv.cantidad),0) from detalle_compra_productos dc  INNER join detalle_venta_productos dv  ON dc.id_detalle_compra=dv.id_detalle_producto WHERE dc.id_producto=pd.id ) cant_disponible,
pd.id,pd.id_tipo_producto,pd.id_marca,pd.id_unidad_medida,pd.id_presentacion,pd.precio_venta,pd.imagen
FROM  producto  pd
INNER JOIN marca m ON pd.id_marca=m.id
INNER JOIN tipo_producto tp ON pd.id_tipo_producto=tp.id
INNER JOIN unidad_medida um ON pd.id_unidad_medida=um.id
INNER JOIN presentacion ps ON pd.id_presentacion=ps.id
INNER JOIN area ar ON pd.id_area=ar.id$$

DROP PROCEDURE IF EXISTS `sp_salesxday`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_salesxday` (IN `day` INT)   SELECT COUNT(id) cantidadxdia FROM venta   WHERE  DATE_FORMAT(fecha,'%m') =MONTH(CURRENT_DATE())  AND  DATE_FORMAT(fecha,'%Y') = YEAR(CURDATE()) AND   DATE_FORMAT(fecha,'%d') =day   AND id_detalle_paquete IS NOT NULL$$

DROP PROCEDURE IF EXISTS `sp_salesxmonth`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_salesxmonth` (IN `month` INT)   SELECT COUNT(id) cantidadxmes FROM venta   WHERE  DATE_FORMAT(fecha,'%m') =month  AND  DATE_FORMAT(fecha,'%Y') = YEAR(CURDATE())  AND id_detalle_paquete IS NOT NULL$$

DROP PROCEDURE IF EXISTS `sp_salesxuser`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_salesxuser` ()   SELECT tb1.id id_user, tb1.identificacion,tb1.name,
(SeLECT count(tb2.id) from venta AS tb2 WHERE  tb1.id=tb2.id_usuario AND tb2.id_detalle_paquete IS NOT NULL) cant_servicios,
(SeLECT count(tb2.id) from venta AS tb2 WHERE  tb1.id=tb2.id_usuario AND tb2.id_estado_venta=1 AND tb2.id_detalle_paquete IS NOT NULL) pendiente, 
(SeLECT  ROUND(SUM(tb2.precio_venta_paquete*tb2.porcentaje_paquete/100)) from venta AS tb2  WHERE  tb1.id=tb2.id_usuario AND tb2.id_estado_venta=1) pend_pago
from users AS  tb1$$

DROP PROCEDURE IF EXISTS `sp_sell_prd_stock`$$
CREATE DEFINER=`u163943142_adrojas`@`127.0.0.1` PROCEDURE `sp_sell_prd_stock` (IN `param_id_product` INT)   SELECT 
dcp.id_detalle_compra,
dcp.cantidad cant_compra_prd,
dcp.precio_compra,
(SELECT IFNULL(SUM(dv.cantidad),0) from  detalle_venta_productos dv  WHERE dv.id_detalle_producto = dcp.id_detalle_compra) cant_ventas_realizadas,
IFNULL((dcp.cantidad) - (SELECT   IFNULL(SUM(dv.cantidad),0) from  detalle_venta_productos dv  WHERE dv.id_detalle_producto = dcp.id_detalle_compra),0) restante  
from 
detalle_compra_productos dcp INNER join producto pd on dcp.id_producto=pd.id
where dcp.id_producto=param_id_product
AND   IFNULL((dcp.cantidad) - (SELECT   IFNULL(SUM(dv.cantidad),0) from  detalle_venta_productos dv  WHERE dv.id_detalle_producto = dcp.id_detalle_compra),0)  <> 0
ORDER BY restante  DESC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrousel`
--

DROP TABLE IF EXISTS `carrousel`;
CREATE TABLE IF NOT EXISTS `carrousel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagen` varchar(80) DEFAULT NULL,
  `orden` int DEFAULT NULL,
  `titulo` varchar(80),
  `subtitulo` varchar(80),
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(80) DEFAULT NULL,
  `imagen` varchar(80) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `imagen` varchar(80) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(80) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `detalle` varchar(800) DEFAULT NULL,
  `imagen` varchar(80) DEFAULT NULL,
  `descuento` int DEFAULT NULL,
  `categorias_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_productos_categorias_idx` (`categorias_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'ADMIN', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_menu`
--

DROP TABLE IF EXISTS `system_menu`;
CREATE TABLE IF NOT EXISTS `system_menu` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logo` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_menu_role`
--

DROP TABLE IF EXISTS `system_menu_role`;
CREATE TABLE IF NOT EXISTS `system_menu_role` (
  `id_role` int UNSIGNED DEFAULT NULL,
  `id_menu` int UNSIGNED DEFAULT NULL,
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id_role` (`id_role`),
  KEY `id_menu` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_submenu`
--

DROP TABLE IF EXISTS `system_submenu`;
CREATE TABLE IF NOT EXISTS `system_submenu` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_menu` int UNSIGNED DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `url` varchar(200) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `permiso_requerido` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logo` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_menu` (`id_menu`),
  KEY `permiso_requerido` (`permiso_requerido`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `estado` bigint DEFAULT '1',
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `celular` varchar(25) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(10) DEFAULT NULL,
  `lugar_expedicion` varchar(60) DEFAULT NULL,
  `cargo` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categorias_id`) REFERENCES `mydb`.`categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
