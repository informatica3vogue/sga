-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2017 a las 21:52:55
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `control_actividades`
--
CREATE DATABASE IF NOT EXISTS `control_actividades` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `control_actividades`;

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `INITCAP`(x char(30)) RETURNS char(30) CHARSET utf8
BEGIN
SET @str='';
SET @l_str='';
WHILE x REGEXP ' ' DO
SELECT SUBSTRING_INDEX(x, ' ', 1) INTO @l_str;
SELECT SUBSTRING(x, LOCATE(' ', x)+1) INTO x;
SELECT CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(@l_str,1,1)),LOWER(SUBSTRING(@l_str,2)))) INTO @str;
END WHILE;
RETURN LTRIM(CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(x,1,1)),LOWER(SUBSTRING(x,2)))));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
`id_actividad` int(11) NOT NULL,
  `referencia` varchar(45) NOT NULL,
  `fecha_procesamiento` datetime NOT NULL,
  `fecha_solicitud` date DEFAULT NULL,
  `solicitante` varchar(500) NOT NULL,
  `requerimiento` varchar(5000) NOT NULL,
  `marginado` varchar(255) DEFAULT NULL,
  `estado` varchar(45) NOT NULL,
  `referencia_origen` varchar(45) DEFAULT NULL,
  `con_conocimiento` varchar(500) DEFAULT NULL,
  `fecha_finalizacion` datetime DEFAULT NULL,
  `id_seccion` int(11) NOT NULL,
  `id_usuario_recepcion` int(11) DEFAULT NULL,
  `id_dependencia_origen` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id_actividad`, `referencia`, `fecha_procesamiento`, `fecha_solicitud`, `solicitante`, `requerimiento`, `marginado`, `estado`, `referencia_origen`, `con_conocimiento`, `fecha_finalizacion`, `id_seccion`, `id_usuario_recepcion`, `id_dependencia_origen`) VALUES
(1, 'UIF-1-2017', '2017-08-16 00:15:01', '2017-08-16', 'Ing. Americo Luna', 'Mantenimiento de sistema de la Sala de lo Constitucional', 'Urgente', 'Pendiente', 'UIF-1-2017', 'José Enrique García Guzmán / Desarrollador', NULL, 1, 1, 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE IF NOT EXISTS `articulo` (
`id_articulo` int(11) NOT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  `articulo` varchar(45) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `existencia` double DEFAULT NULL,
  `fecha_procesamiento` datetime DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_linea` int(11) DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_dependencia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

CREATE TABLE IF NOT EXISTS `asignacion` (
`id_asignacion` int(11) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `fecha_finalizacion` datetime DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asignacion`
--

INSERT INTO `asignacion` (`id_asignacion`, `estado`, `fecha_asignacion`, `fecha_finalizacion`, `id_usuario`, `id_actividad`) VALUES
(1, 'Activo', '2017-08-16', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE IF NOT EXISTS `bitacora` (
`id_bitacora` int(11) NOT NULL,
  `accion` varchar(900) NOT NULL,
  `tipo_accion` enum('INSERT','UPDATE','DELETE','LOGIN','LOGOUT') NOT NULL,
  `fecha_procesamiento` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_bitacora`, `accion`, `tipo_accion`, `fecha_procesamiento`, `id_usuario`) VALUES
(1, 'Inicio de sesion', 'LOGIN', '2017-08-08 11:00:34', 1),
(2, 'se ha creado un memorandum, fecha creacion: 08-08-17, \\n  tipo de memorandum: Externo, \\n con la referencia: UIF-1-2017', 'INSERT', '2017-08-08 11:06:20', 1),
(3, 'se ingreso repositorio nuevo, fecha de creacion: 08-08-2017, \\n titulo de repositorio: Documentos, \\n observacion: Documentos aldfaljfhalsfhasfasf, \\n tipo de repositorio: Privado', 'INSERT', '2017-08-08 11:10:42', 1),
(4, 'Cierre de sesion', 'LOGOUT', '2017-08-08 11:16:21', 1),
(5, 'Inicio de sesion', 'LOGIN', '2017-08-15 22:00:46', 1),
(6, 'Inicio de sesion', 'LOGIN', '2017-08-15 23:46:12', 1),
(7, 'se agrego nueva actividad: referencia: UIF-1-2017, \\n referencia_origen: ljhljhljhlj, \\n fecha_solicitud: 16-08-2017, \\n solicitante: ljhljhljhljh, \\n requerimiento: kjkjhllhljhjh, \\n fecha_procesamiento: 16-08-2017, \\n marginado: ljhljh, \\n con conocimiento: José Enrique García Guzmán / Desarrollador, \\n dependencia solicitante: Departamento de Informática, \\n archivos adjuntados: 0', 'INSERT', '2017-08-16 00:15:01', 2),
(8, 'Cierre de sesion', 'LOGOUT', '2017-08-16 00:16:49', 1),
(9, 'Inicio de sesion', 'LOGIN', '2017-08-16 00:17:14', 1),
(10, 'Cierre de sesion', 'LOGOUT', '2017-08-16 00:17:43', 1),
(11, 'Inicio de sesion', 'LOGIN', '2017-08-16 00:17:51', 2),
(12, 'se agrego un nuevo seguimiento actividad con referencia: UIF-1-2017, \\n accion realizada: Se comenzo a dar el mtto. al sistema de los modulos solicitados, \\n archivos adjuntados: 0, \\n estado de la actividad: Pendiente.', 'INSERT', '2017-08-16 00:18:41', 2),
(13, 'Cierre de sesion', 'LOGOUT', '2017-08-16 00:18:49', 2),
(14, 'Inicio de sesion', 'LOGIN', '2017-08-16 00:18:53', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
`id_cargos` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `referencia` varchar(45) DEFAULT NULL,
  `observacion` varchar(45) DEFAULT NULL,
  `id_dependencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo_bodega`
--

CREATE TABLE IF NOT EXISTS `cargo_bodega` (
`id_cargo_bodega` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `referencia` varchar(45) DEFAULT NULL,
  `observacion` varchar(45) DEFAULT NULL,
  `id_dependencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
`id_categoria` int(11) NOT NULL,
  `categoria` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE IF NOT EXISTS `dependencia` (
`id_dependencia` int(11) NOT NULL,
  `abreviatura` varchar(45) NOT NULL,
  `tipo` enum('Interna','Externa') NOT NULL,
  `dependencia` int(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`id_dependencia`, `abreviatura`, `tipo`, `dependencia`) VALUES
(33, 'UIF', 'Interna', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descargos`
--

CREATE TABLE IF NOT EXISTS `descargos` (
`id_descargos` int(11) unsigned NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `observacion` varchar(900) DEFAULT NULL,
  `id_dependencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_solicitud_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descargos_articulos`
--

CREATE TABLE IF NOT EXISTS `descargos_articulos` (
`id_descargo_articulo` int(11) NOT NULL,
  `cantidad` double DEFAULT NULL,
  `id_articulo` int(11) NOT NULL,
  `id_descargos` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descargo_articulo_bodega`
--

CREATE TABLE IF NOT EXISTS `descargo_articulo_bodega` (
`id_descargo_articulo_bodega` int(11) NOT NULL,
  `cantidad` double DEFAULT NULL,
  `id_articulo` int(11) NOT NULL,
  `id_descargo_bodega` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descargo_bodega`
--

CREATE TABLE IF NOT EXISTS `descargo_bodega` (
`id_descargo_bodega` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `observacion` varchar(900) DEFAULT NULL,
  `id_dependencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_solicitud`
--

CREATE TABLE IF NOT EXISTS `detalle_solicitud` (
`id_detalle_solicitud` int(11) NOT NULL,
  `cantidad` double DEFAULT NULL,
  `id_articulo` int(11) NOT NULL,
  `id_solicitud_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docu_actividad`
--

CREATE TABLE IF NOT EXISTS `docu_actividad` (
`id_docu_actividad` int(11) NOT NULL,
  `documento` varchar(500) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `id_actividad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docu_bodega`
--

CREATE TABLE IF NOT EXISTS `docu_bodega` (
`id_docu_bodega` int(11) NOT NULL,
  `documento` varchar(500) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `id_descargo_bodega` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docu_permiso`
--

CREATE TABLE IF NOT EXISTS `docu_permiso` (
`id_docu_permiso` int(11) NOT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docu_repositorio`
--

CREATE TABLE IF NOT EXISTS `docu_repositorio` (
`id_docu_repositorio` int(11) NOT NULL,
  `documento` varchar(300) DEFAULT NULL,
  `tipo` varchar(6) DEFAULT NULL,
  `id_repositorio` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `docu_repositorio`
--

INSERT INTO `docu_repositorio` (`id_docu_repositorio`, `documento`, `tipo`, `id_repositorio`) VALUES
(22, 'curriculumvitaejos', 'pdf', 3),
(23, 'cvjosegarcia-e139b4fa812d336e0e761156a9162478.pdf', 'pdf', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docu_seguimiento`
--

CREATE TABLE IF NOT EXISTS `docu_seguimiento` (
`id_docu_seguimiento` int(11) NOT NULL,
  `documento` varchar(500) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `id_seguimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
`id_empleado` int(11) NOT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `num_tarjeta_marcacion` int(10) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `estado_civil` varchar(45) DEFAULT NULL,
  `DUI` varchar(45) DEFAULT NULL,
  `NIT` varchar(45) DEFAULT NULL,
  `NUP` varchar(45) DEFAULT NULL,
  `ISSS` varchar(45) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `fecha_contratacion` date DEFAULT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `tipo_contratacion` varchar(45) DEFAULT NULL,
  `tipo_sangre` varchar(15) DEFAULT NULL,
  `persona_encargada` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `codigo`, `num_tarjeta_marcacion`, `nombre`, `apellido`, `estado_civil`, `DUI`, `NIT`, `NUP`, `ISSS`, `direccion`, `fecha_contratacion`, `titulo`, `cargo`, `tipo_contratacion`, `tipo_sangre`, `persona_encargada`) VALUES
(1, 'JG101', 10123, 'José Enrique', 'García Guzmán', 'Soltero', '04886058-3', '0614-140194-118-0', '0000000000000000000', '0000000000000000000', 'San Salvador', '2017-08-01', 'Estudiante de Ingenieria', 'Desarrollador', 'Por contrato', 'O+', 'Mamá'),
(2, NULL, NULL, 'Alejandro Antonio', 'Henriquez Rivas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Desarrollador', NULL, NULL, NULL),
(3, NULL, NULL, 'David Mauricio', 'Caceres Gonzalez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Analista', NULL, NULL, NULL),
(4, 'MA100', 123, 'Alejandro Marcelo', 'Martínez Navas', 'Soltero/a', '00000000-0', '0000-000000-000-0', '000000000000', '000000000', 'Santa Tecla', '2017-08-09', 'Ingeniero', 'Analista', 'Contrato', 'O+', 'Mamá'),
(5, NULL, NULL, 'Giorgio', 'Magaña García', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DBA', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_seccion`
--

CREATE TABLE IF NOT EXISTS `empleado_seccion` (
`id_empleado_seccion` int(11) NOT NULL,
  `estado` varchar(15) DEFAULT NULL,
  `observacion` blob,
  `fecha_procesamiento` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_seccion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado_seccion`
--

INSERT INTO `empleado_seccion` (`id_empleado_seccion`, `estado`, `observacion`, `fecha_procesamiento`, `fecha_final`, `id_empleado`, `id_seccion`) VALUES
(1, 'Activo', NULL, NULL, NULL, 1, 1),
(2, 'Activo', NULL, '2017-08-15', NULL, 2, 1),
(3, 'Activo', NULL, '2017-08-15', NULL, 3, 1),
(4, 'Activo', NULL, '2017-08-15', NULL, 4, 1),
(5, 'Activo', NULL, '2017-08-15', NULL, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
`id_grupo` int(11) NOT NULL,
  `grupo` varchar(100) DEFAULT NULL,
  `id_usuario_propietario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_empleado`
--

CREATE TABLE IF NOT EXISTS `grupo_empleado` (
`id_grupo_empleado` int(11) NOT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea`
--

CREATE TABLE IF NOT EXISTS `linea` (
`id_linea` int(11) NOT NULL,
  `linea` varchar(45) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_dependencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE IF NOT EXISTS `marca` (
`id_marca` int(11) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `id_dependencia` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memorandum`
--

CREATE TABLE IF NOT EXISTS `memorandum` (
`id_memorandum` int(11) NOT NULL,
  `referencia` varchar(45) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `para` varchar(75) DEFAULT NULL,
  `de` varchar(75) DEFAULT NULL,
  `asunto` varchar(45) DEFAULT NULL,
  `descripcion` blob,
  `con_copia` varchar(100) DEFAULT NULL,
  `tipo_memorandum` varchar(15) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_dependencia` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memorandum`
--

INSERT INTO `memorandum` (`id_memorandum`, `referencia`, `fecha_creacion`, `para`, `de`, `asunto`, `descripcion`, `con_copia`, `tipo_memorandum`, `id_usuario`, `id_dependencia`) VALUES
(9, 'UIF-1-2017', '2017-08-08 11:06:20', 'Ing. Navas Martinez', 'David Mauricio Caceres Gonzalez', 'Urgente', 0x3c70207374796c653d22666f6e742d66616d696c793a202671756f743b536f757263652053616e732050726f2671756f743b2c20417269616c2c2048656c7665746963612c2047656e6576612c2073616e732d73657269663b20666f6e742d73697a653a20313770783b206261636b67726f756e642d636f6c6f723a20726762283233352c203233352c20323335293b223e456c266e6273703b3c7370616e207374796c653d22666f6e742d7765696768743a203730303b223e6d656d6f72c3a16e64756d3c2f7370616e3e266e6273703b6573206c61206d616e65726120646520636f6d756e6963617220656e20666f726d61206272657665206173756e746f7320646520636172c3a1637465722061646d696e69737472617469766f206120706572736f6e617320646520756e6120656d70726573612c20696e73746974756369c3b36e206f20646570656e64656e63696120646520676f626965726e6f2e3c2f703e3c70207374796c653d22666f6e742d66616d696c793a202671756f743b536f757263652053616e732050726f2671756f743b2c20417269616c2c2048656c7665746963612c2047656e6576612c2073616e732d73657269663b20666f6e742d73697a653a20313770783b206261636b67726f756e642d636f6c6f723a20726762283233352c203233352c20323335293b223e526567756c61726d656e7465206573746520646f63756d656e746f20736520656c61626f726120656e20686f6a617320646520706170656c206d656469612063617274612e2054616d6269c3a96e2068617920666f726d61746f7320717565206c6c6576616e20696d707265736f20656c206e6f6d627265206465204d454d4f52414e44554d2e266e6273703b28456c20706c7572616c206465206c612070616c61627261206573207661726961626c65207920746f646f7320736f6e20636f72726563746f73204d656d6f72616e64612c266e6273703b204d656d6f72c3a16e64756d732c266e6273703b204d656d6f72616e646f73206f204d656d6f72c3a16e64756d6573292e3c2f703e, 'José Enrique García Guzmán / Desarrollador', 'Externo', 1, 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_interno`
--

CREATE TABLE IF NOT EXISTS `memo_interno` (
`id_memo_interno` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_memorandum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo`
--

CREATE TABLE IF NOT EXISTS `motivo` (
`id_motivo` int(11) NOT NULL,
  `motivo` varchar(45) DEFAULT NULL,
  `cantidad_dias` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
`id_permiso` int(11) NOT NULL,
  `num_permiso` int(11) DEFAULT NULL,
  `fecha_dif` date DEFAULT NULL,
  `fecha_drh` date DEFAULT NULL,
  `hora_desde` time DEFAULT NULL,
  `hora_hasta` time DEFAULT NULL,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL,
  `anulacion` varchar(45) DEFAULT NULL,
  `observacion` varchar(45) DEFAULT NULL,
  `motivo_otros` varchar(150) DEFAULT NULL,
  `codigo_rrhh` varchar(10) DEFAULT NULL,
  `fecha_procesamiento` date DEFAULT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_motivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositorio`
--

CREATE TABLE IF NOT EXISTS `repositorio` (
`id_repositorio` int(11) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `tipo_repositorio` enum('Privado','Compartido') DEFAULT NULL,
  `observacion` varchar(500) DEFAULT NULL,
  `id_dependencia` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `repositorio`
--

INSERT INTO `repositorio` (`id_repositorio`, `fecha_creacion`, `alias`, `tipo_repositorio`, `observacion`, `id_dependencia`) VALUES
(3, '2017-08-08', 'Documentos', 'Privado', 'Documentos aldfaljfhalsfhasfasf', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
`id_rol` int(11) NOT NULL,
  `rol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE IF NOT EXISTS `seccion` (
`id_seccion` int(11) NOT NULL,
  `seccion` varchar(100) NOT NULL,
  `id_dependencia` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id_seccion`, `seccion`, `id_dependencia`) VALUES
(1, 'Informatica', 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE IF NOT EXISTS `seguimiento` (
`id_seguimiento` int(11) NOT NULL,
  `accion_realizada` varchar(900) NOT NULL,
  `fecha_seguimiento` datetime NOT NULL,
  `id_actividad` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `seguimiento`
--

INSERT INTO `seguimiento` (`id_seguimiento`, `accion_realizada`, `fecha_seguimiento`, `id_actividad`, `id_usuario`) VALUES
(1, 'Se comenzo a dar el mtto. al sistema de los modulos solicitados', '2017-08-16 00:18:41', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_articulo`
--

CREATE TABLE IF NOT EXISTS `solicitud_articulo` (
`id_solicitud_articulo` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `observacion` blob,
  `estado` varchar(25) DEFAULT NULL,
  `referencia` varchar(25) DEFAULT NULL,
  `observacion_cancelacion` blob,
  `fecha_cancelacion` datetime DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono_emp`
--

CREATE TABLE IF NOT EXISTS `telefono_emp` (
`id_telefono_emp` int(11) NOT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE IF NOT EXISTS `unidad` (
`id_unidad` int(11) NOT NULL,
  `unidad_medida` varchar(45) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_dependencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `contrasenia` varchar(45) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `cargo`, `usuario`, `contrasenia`, `estado`, `fecha`, `id_seccion`, `id_empleado`, `id_rol`) VALUES
(1, 'José Enrique', 'García Guzmán', 'Desarrollador', 'jgarcia', '3960f34456ca258218fcd6725194e18b', 'Activo', '2017-08-01', 1, 1, 1),
(2, NULL, NULL, NULL, 'ahenriquez', '3960f34456ca258218fcd6725194e18b', 'Activo', NULL, 1, 2, 1),
(3, NULL, NULL, NULL, 'dcaceres', '3960f34456ca258218fcd6725194e18b', 'Activo', NULL, 1, 3, 1),
(4, NULL, NULL, NULL, 'amartinez', '3960f34456ca258218fcd6725194e18b', 'Activo', NULL, 1, 4, 1),
(5, NULL, NULL, NULL, 'gmagaña', '3960f34456ca258218fcd6725194e18b', 'Activo', NULL, 1, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_repositorio`
--

CREATE TABLE IF NOT EXISTS `usuario_repositorio` (
`id_usuario_repositorio` int(11) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `tipo` enum('Propietario','Externo') NOT NULL,
  `fecha_procesamiento` datetime NOT NULL,
  `fecha_finalizacion` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_repositorio` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_repositorio`
--

INSERT INTO `usuario_repositorio` (`id_usuario_repositorio`, `estado`, `tipo`, `fecha_procesamiento`, `fecha_finalizacion`, `id_usuario`, `id_repositorio`) VALUES
(3, 'Activo', 'Propietario', '2017-08-08 11:10:42', '0000-00-00 00:00:00', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
 ADD PRIMARY KEY (`id_actividad`), ADD KEY `id_seccion` (`id_seccion`), ADD KEY `id_dependencia_origen` (`id_dependencia_origen`), ADD FULLTEXT KEY `busqueda` (`requerimiento`,`solicitante`);

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
 ADD PRIMARY KEY (`id_articulo`), ADD KEY `id_marca` (`id_marca`), ADD KEY `id_linea` (`id_linea`), ADD KEY `id_unidad` (`id_unidad`), ADD KEY `id_categoria` (`id_categoria`), ADD KEY `id_dependencia` (`id_dependencia`), ADD KEY `id_linea_2` (`id_linea`);

--
-- Indices de la tabla `asignacion`
--
ALTER TABLE `asignacion`
 ADD PRIMARY KEY (`id_asignacion`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
 ADD PRIMARY KEY (`id_bitacora`), ADD KEY `id_bitacora` (`id_bitacora`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
 ADD PRIMARY KEY (`id_cargos`), ADD KEY `id_articulo` (`id_articulo`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_dependencia` (`id_dependencia`);

--
-- Indices de la tabla `cargo_bodega`
--
ALTER TABLE `cargo_bodega`
 ADD PRIMARY KEY (`id_cargo_bodega`), ADD KEY `id_dependencia` (`id_dependencia`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_articulo` (`id_articulo`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
 ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
 ADD PRIMARY KEY (`id_dependencia`);

--
-- Indices de la tabla `descargos`
--
ALTER TABLE `descargos`
 ADD PRIMARY KEY (`id_descargos`), ADD KEY `id_dependencia` (`id_dependencia`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_solicitud_articulo` (`id_solicitud_articulo`);

--
-- Indices de la tabla `descargos_articulos`
--
ALTER TABLE `descargos_articulos`
 ADD PRIMARY KEY (`id_descargo_articulo`), ADD KEY `id_articulo` (`id_articulo`), ADD KEY `id_descargos` (`id_descargos`);

--
-- Indices de la tabla `descargo_articulo_bodega`
--
ALTER TABLE `descargo_articulo_bodega`
 ADD PRIMARY KEY (`id_descargo_articulo_bodega`), ADD KEY `id_descargo_bodega` (`id_descargo_bodega`), ADD KEY `id_articulo` (`id_articulo`);

--
-- Indices de la tabla `descargo_bodega`
--
ALTER TABLE `descargo_bodega`
 ADD PRIMARY KEY (`id_descargo_bodega`), ADD KEY `id_dependencia` (`id_dependencia`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
 ADD PRIMARY KEY (`id_detalle_solicitud`), ADD KEY `id_articulo` (`id_articulo`), ADD KEY `id_solicitud_articulo` (`id_solicitud_articulo`);

--
-- Indices de la tabla `docu_actividad`
--
ALTER TABLE `docu_actividad`
 ADD PRIMARY KEY (`id_docu_actividad`), ADD KEY `id_actividad` (`id_actividad`), ADD KEY `id_actividad_2` (`id_actividad`);

--
-- Indices de la tabla `docu_bodega`
--
ALTER TABLE `docu_bodega`
 ADD PRIMARY KEY (`id_docu_bodega`), ADD KEY `id_descargo_bodega` (`id_descargo_bodega`);

--
-- Indices de la tabla `docu_permiso`
--
ALTER TABLE `docu_permiso`
 ADD PRIMARY KEY (`id_docu_permiso`), ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `docu_repositorio`
--
ALTER TABLE `docu_repositorio`
 ADD PRIMARY KEY (`id_docu_repositorio`), ADD KEY `id_repositorio` (`id_repositorio`);

--
-- Indices de la tabla `docu_seguimiento`
--
ALTER TABLE `docu_seguimiento`
 ADD PRIMARY KEY (`id_docu_seguimiento`), ADD KEY `id_seguimiento` (`id_seguimiento`), ADD KEY `id_seguimiento_2` (`id_seguimiento`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
 ADD PRIMARY KEY (`id_empleado`), ADD FULLTEXT KEY `busqueda_empleado` (`codigo`,`nombre`,`apellido`,`DUI`,`NIT`,`NUP`,`ISSS`);

--
-- Indices de la tabla `empleado_seccion`
--
ALTER TABLE `empleado_seccion`
 ADD PRIMARY KEY (`id_empleado_seccion`), ADD KEY `id_empleado` (`id_empleado`), ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
 ADD PRIMARY KEY (`id_grupo`), ADD KEY `id_grupo` (`id_grupo`), ADD KEY `id_grupo_2` (`id_grupo`), ADD KEY `id_grupo_3` (`id_grupo`), ADD KEY `id_usuario_propietario` (`id_usuario_propietario`);

--
-- Indices de la tabla `grupo_empleado`
--
ALTER TABLE `grupo_empleado`
 ADD PRIMARY KEY (`id_grupo_empleado`), ADD KEY `id_grupo` (`id_grupo`), ADD KEY `id_empleado` (`id_empleado`), ADD KEY `id_grupo_empleado` (`id_grupo_empleado`), ADD KEY `id_grupo_2` (`id_grupo`), ADD KEY `id_empleado_2` (`id_empleado`);

--
-- Indices de la tabla `linea`
--
ALTER TABLE `linea`
 ADD PRIMARY KEY (`id_linea`), ADD KEY `id_dependencia` (`id_dependencia`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
 ADD PRIMARY KEY (`id_marca`), ADD KEY `id_dependencia` (`id_dependencia`), ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `memorandum`
--
ALTER TABLE `memorandum`
 ADD PRIMARY KEY (`id_memorandum`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_dependencia` (`id_dependencia`), ADD FULLTEXT KEY `busqueda` (`para`,`de`,`asunto`);

--
-- Indices de la tabla `memo_interno`
--
ALTER TABLE `memo_interno`
 ADD PRIMARY KEY (`id_memo_interno`), ADD KEY `id_empleado` (`id_empleado`), ADD KEY `id_memorandum` (`id_memorandum`);

--
-- Indices de la tabla `motivo`
--
ALTER TABLE `motivo`
 ADD PRIMARY KEY (`id_motivo`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
 ADD PRIMARY KEY (`id_permiso`), ADD KEY `id_empleado` (`id_empleado`), ADD KEY `id_motivo` (`id_motivo`), ADD KEY `id_motivo_2` (`id_motivo`);

--
-- Indices de la tabla `repositorio`
--
ALTER TABLE `repositorio`
 ADD PRIMARY KEY (`id_repositorio`), ADD KEY `id_dependencia` (`id_dependencia`), ADD FULLTEXT KEY `busqueda` (`alias`,`observacion`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
 ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
 ADD PRIMARY KEY (`id_seccion`), ADD KEY `id_dependencia` (`id_dependencia`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
 ADD PRIMARY KEY (`id_seguimiento`), ADD KEY `id_actividad` (`id_actividad`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `solicitud_articulo`
--
ALTER TABLE `solicitud_articulo`
 ADD PRIMARY KEY (`id_solicitud_articulo`), ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `telefono_emp`
--
ALTER TABLE `telefono_emp`
 ADD PRIMARY KEY (`id_telefono_emp`), ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
 ADD PRIMARY KEY (`id_unidad`), ADD KEY `id_dependencia` (`id_dependencia`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id_usuario`), ADD KEY `id_empleado` (`id_empleado`), ADD KEY `id_rol` (`id_rol`), ADD FULLTEXT KEY `busqueda_usuario` (`nombre`,`apellido`,`cargo`,`usuario`);

--
-- Indices de la tabla `usuario_repositorio`
--
ALTER TABLE `usuario_repositorio`
 ADD PRIMARY KEY (`id_usuario_repositorio`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_repositorio` (`id_repositorio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
MODIFY `id_articulo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `asignacion`
--
ALTER TABLE `asignacion`
MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
MODIFY `id_cargos` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cargo_bodega`
--
ALTER TABLE `cargo_bodega`
MODIFY `id_cargo_bodega` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dependencia`
--
ALTER TABLE `dependencia`
MODIFY `id_dependencia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `descargos`
--
ALTER TABLE `descargos`
MODIFY `id_descargos` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `descargos_articulos`
--
ALTER TABLE `descargos_articulos`
MODIFY `id_descargo_articulo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `descargo_articulo_bodega`
--
ALTER TABLE `descargo_articulo_bodega`
MODIFY `id_descargo_articulo_bodega` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `descargo_bodega`
--
ALTER TABLE `descargo_bodega`
MODIFY `id_descargo_bodega` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
MODIFY `id_detalle_solicitud` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `docu_actividad`
--
ALTER TABLE `docu_actividad`
MODIFY `id_docu_actividad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `docu_bodega`
--
ALTER TABLE `docu_bodega`
MODIFY `id_docu_bodega` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `docu_permiso`
--
ALTER TABLE `docu_permiso`
MODIFY `id_docu_permiso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `docu_repositorio`
--
ALTER TABLE `docu_repositorio`
MODIFY `id_docu_repositorio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `docu_seguimiento`
--
ALTER TABLE `docu_seguimiento`
MODIFY `id_docu_seguimiento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `empleado_seccion`
--
ALTER TABLE `empleado_seccion`
MODIFY `id_empleado_seccion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `grupo_empleado`
--
ALTER TABLE `grupo_empleado`
MODIFY `id_grupo_empleado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `linea`
--
ALTER TABLE `linea`
MODIFY `id_linea` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `memorandum`
--
ALTER TABLE `memorandum`
MODIFY `id_memorandum` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `memo_interno`
--
ALTER TABLE `memo_interno`
MODIFY `id_memo_interno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `motivo`
--
ALTER TABLE `motivo`
MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `repositorio`
--
ALTER TABLE `repositorio`
MODIFY `id_repositorio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
MODIFY `id_seccion` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `solicitud_articulo`
--
ALTER TABLE `solicitud_articulo`
MODIFY `id_solicitud_articulo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `telefono_emp`
--
ALTER TABLE `telefono_emp`
MODIFY `id_telefono_emp` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `usuario_repositorio`
--
ALTER TABLE `usuario_repositorio`
MODIFY `id_usuario_repositorio` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `actividad_ibfk_2` FOREIGN KEY (`id_dependencia_origen`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
ADD CONSTRAINT `articulo_ibfk_2` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `articulo_ibfk_3` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `articulo_ibfk_4` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `articulo_ibfk_5` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asignacion`
--
ALTER TABLE `asignacion`
ADD CONSTRAINT `asignacion_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `asignacion_ibfk_2` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cargos`
--
ALTER TABLE `cargos`
ADD CONSTRAINT `cargos_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `cargos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `cargos_ibfk_3` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cargo_bodega`
--
ALTER TABLE `cargo_bodega`
ADD CONSTRAINT `cargo_bodega_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `cargo_bodega_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `cargo_bodega_ibfk_3` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `descargos`
--
ALTER TABLE `descargos`
ADD CONSTRAINT `descargos_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `descargos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `descargos_ibfk_3` FOREIGN KEY (`id_solicitud_articulo`) REFERENCES `solicitud_articulo` (`id_solicitud_articulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `descargos_articulos`
--
ALTER TABLE `descargos_articulos`
ADD CONSTRAINT `descargos_articulos_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `descargos_articulos_ibfk_2` FOREIGN KEY (`id_descargos`) REFERENCES `descargos` (`id_descargos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `descargo_articulo_bodega`
--
ALTER TABLE `descargo_articulo_bodega`
ADD CONSTRAINT `descargo_articulo_bodega_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `descargo_articulo_bodega_ibfk_2` FOREIGN KEY (`id_descargo_bodega`) REFERENCES `descargo_bodega` (`id_descargo_bodega`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `descargo_bodega`
--
ALTER TABLE `descargo_bodega`
ADD CONSTRAINT `descargo_bodega_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `descargo_bodega_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_solicitud`
--
ALTER TABLE `detalle_solicitud`
ADD CONSTRAINT `detalle_solicitud_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `articulo` (`id_articulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `detalle_solicitud_ibfk_2` FOREIGN KEY (`id_solicitud_articulo`) REFERENCES `solicitud_articulo` (`id_solicitud_articulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `docu_actividad`
--
ALTER TABLE `docu_actividad`
ADD CONSTRAINT `docu_actividad_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `docu_bodega`
--
ALTER TABLE `docu_bodega`
ADD CONSTRAINT `docu_bodega_ibfk_1` FOREIGN KEY (`id_descargo_bodega`) REFERENCES `descargo_bodega` (`id_descargo_bodega`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `docu_permiso`
--
ALTER TABLE `docu_permiso`
ADD CONSTRAINT `docu_permiso_ibfk_1` FOREIGN KEY (`id_permiso`) REFERENCES `permiso` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `docu_repositorio`
--
ALTER TABLE `docu_repositorio`
ADD CONSTRAINT `docu_repositorio_ibfk_1` FOREIGN KEY (`id_repositorio`) REFERENCES `repositorio` (`id_repositorio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `docu_seguimiento`
--
ALTER TABLE `docu_seguimiento`
ADD CONSTRAINT `docu_seguimiento_ibfk_1` FOREIGN KEY (`id_seguimiento`) REFERENCES `seguimiento` (`id_seguimiento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado_seccion`
--
ALTER TABLE `empleado_seccion`
ADD CONSTRAINT `empleado_seccion_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `empleado_seccion_ibfk_2` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`id_usuario_propietario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `grupo_empleado`
--
ALTER TABLE `grupo_empleado`
ADD CONSTRAINT `grupo_empleado_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `grupo_empleado_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `linea`
--
ALTER TABLE `linea`
ADD CONSTRAINT `linea_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `marca`
--
ALTER TABLE `marca`
ADD CONSTRAINT `marca_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `marca_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memorandum`
--
ALTER TABLE `memorandum`
ADD CONSTRAINT `memorandum_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `memorandum_ibfk_2` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_interno`
--
ALTER TABLE `memo_interno`
ADD CONSTRAINT `memo_interno_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `memo_interno_ibfk_2` FOREIGN KEY (`id_memorandum`) REFERENCES `memorandum` (`id_memorandum`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `repositorio`
--
ALTER TABLE `repositorio`
ADD CONSTRAINT `repositorio_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
ADD CONSTRAINT `seccion_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
ADD CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividad` (`id_actividad`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `seguimiento_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud_articulo`
--
ALTER TABLE `solicitud_articulo`
ADD CONSTRAINT `solicitud_articulo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefono_emp`
--
ALTER TABLE `telefono_emp`
ADD CONSTRAINT `telefono_emp_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `unidad`
--
ALTER TABLE `unidad`
ADD CONSTRAINT `unidad_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_repositorio`
--
ALTER TABLE `usuario_repositorio`
ADD CONSTRAINT `usuario_repositorio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `usuario_repositorio_ibfk_2` FOREIGN KEY (`id_repositorio`) REFERENCES `repositorio` (`id_repositorio`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
