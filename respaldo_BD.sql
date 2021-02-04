-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-01-2021 a las 14:45:27
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemaevaluacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividadalumno`
--

DROP TABLE IF EXISTS `actividadalumno`;
CREATE TABLE IF NOT EXISTS `actividadalumno` (
  `idActividadProgramada` int(11) NOT NULL,
  `idAlumno` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idNivelDesempeno` tinyint(4) DEFAULT NULL,
  `observacion` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `rutaEvidencia` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idActividadProgramada`,`idAlumno`),
  KEY `idAlumno` (`idAlumno`),
  KEY `idNivelDesempeno` (`idNivelDesempeno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `actividadalumno`
--

INSERT INTO `actividadalumno` (`idActividadProgramada`, `idAlumno`, `idNivelDesempeno`, `observacion`, `rutaEvidencia`) VALUES
(2, '0000000001', NULL, '', 'ruta'),
(2, '0000000002', NULL, '', 'ruta'),
(2, '0000000003', NULL, '', 'ruta'),
(2, '0000000004', NULL, '', 'ruta'),
(2, '0000000006', NULL, '', 'ruta'),
(2, '0000000007', NULL, '', 'ruta'),
(2, '0000000008', NULL, '', 'ruta'),
(2, '0000000009', NULL, '', 'ruta'),
(2, '0000000010', NULL, '', 'ruta'),
(2, '0000000011', NULL, '', 'ruta'),
(4, '0000000001', NULL, '', 'ruta'),
(4, '0000000002', NULL, '', 'ruta'),
(4, '0000000003', NULL, '', 'ruta'),
(4, '0000000004', NULL, '', 'ruta'),
(4, '0000000006', NULL, '', 'ruta'),
(4, '0000000007', NULL, '', 'ruta'),
(4, '0000000008', NULL, '', 'ruta'),
(4, '0000000009', NULL, '', 'ruta'),
(4, '0000000010', NULL, '', 'ruta'),
(4, '0000000011', NULL, '', 'ruta'),
(6, '0000000001', NULL, '', 'ruta'),
(6, '0000000002', NULL, '', 'ruta'),
(6, '0000000003', NULL, '', 'ruta'),
(6, '0000000004', NULL, '', 'ruta'),
(6, '0000000006', NULL, '', 'ruta'),
(6, '0000000007', NULL, '', 'ruta'),
(6, '0000000008', NULL, '', 'ruta'),
(6, '0000000009', NULL, '', 'ruta'),
(6, '0000000010', NULL, '', 'ruta'),
(6, '0000000011', NULL, '', 'ruta'),
(9, '0000000001', NULL, '', 'ruta'),
(9, '0000000002', NULL, '', 'ruta'),
(9, '0000000003', NULL, '', 'ruta'),
(9, '0000000004', NULL, '', 'ruta'),
(9, '0000000006', NULL, '', 'ruta'),
(9, '0000000007', NULL, '', 'ruta'),
(9, '0000000008', NULL, '', 'ruta'),
(9, '0000000009', NULL, '', 'ruta'),
(9, '0000000010', NULL, '', 'ruta'),
(9, '0000000011', NULL, '', 'ruta'),
(10, '0000000001', NULL, '', 'ruta'),
(10, '0000000002', NULL, '', 'ruta'),
(10, '0000000003', NULL, '', 'ruta'),
(10, '0000000004', NULL, '', 'ruta'),
(10, '0000000006', NULL, '', 'ruta'),
(10, '0000000007', NULL, '', 'ruta'),
(10, '0000000008', NULL, '', 'ruta'),
(10, '0000000009', NULL, '', 'ruta'),
(10, '0000000010', NULL, '', 'ruta'),
(10, '0000000011', NULL, '', 'ruta'),
(11, '0000000001', NULL, '', 'ruta'),
(11, '0000000002', NULL, '', 'ruta'),
(11, '0000000003', NULL, '', 'ruta'),
(11, '0000000004', NULL, '', 'ruta'),
(11, '0000000006', NULL, '', 'ruta'),
(11, '0000000007', NULL, '', 'ruta'),
(11, '0000000008', NULL, '', 'ruta'),
(11, '0000000009', NULL, '', 'ruta'),
(11, '0000000010', NULL, '', 'ruta'),
(11, '0000000011', NULL, '', 'ruta'),
(12, '0000000001', NULL, '', 'ruta'),
(12, '0000000002', NULL, '', 'ruta'),
(12, '0000000003', NULL, '', 'ruta'),
(12, '0000000004', NULL, '', 'ruta'),
(12, '0000000006', NULL, '', 'ruta'),
(12, '0000000007', NULL, '', 'ruta'),
(12, '0000000008', NULL, '', 'ruta'),
(12, '0000000009', NULL, '', 'ruta'),
(12, '0000000010', NULL, '', 'ruta'),
(12, '0000000011', NULL, '', 'ruta'),
(14, '0000000001', NULL, '', 'ruta'),
(14, '0000000002', NULL, '', 'ruta'),
(14, '0000000003', NULL, '', 'ruta'),
(14, '0000000004', NULL, '', 'ruta'),
(14, '0000000006', NULL, '', 'ruta'),
(14, '0000000007', NULL, '', 'ruta'),
(14, '0000000008', NULL, '', 'ruta'),
(14, '0000000009', NULL, '', 'ruta'),
(14, '0000000010', NULL, '', 'ruta'),
(14, '0000000011', NULL, '', 'ruta'),
(15, '0000000001', NULL, '', 'ruta'),
(15, '0000000002', NULL, '', 'ruta'),
(15, '0000000003', NULL, '', 'ruta'),
(15, '0000000004', NULL, '', 'ruta'),
(15, '0000000006', NULL, '', 'ruta'),
(15, '0000000007', NULL, '', 'ruta'),
(15, '0000000008', NULL, '', 'ruta'),
(15, '0000000009', NULL, '', 'ruta'),
(15, '0000000010', NULL, '', 'ruta'),
(15, '0000000011', NULL, '', 'ruta'),
(16, '0000000001', NULL, '', 'ruta'),
(16, '0000000002', NULL, '', 'ruta'),
(16, '0000000003', NULL, '', 'ruta'),
(16, '0000000004', NULL, '', 'ruta'),
(16, '0000000006', NULL, '', 'ruta'),
(16, '0000000007', NULL, '', 'ruta'),
(16, '0000000008', NULL, '', 'ruta'),
(16, '0000000009', NULL, '', 'ruta'),
(16, '0000000010', NULL, '', 'ruta'),
(16, '0000000011', NULL, '', 'ruta'),
(17, '0000000001', NULL, '', 'ruta'),
(17, '0000000002', NULL, '', 'ruta'),
(17, '0000000003', NULL, '', 'ruta'),
(17, '0000000004', NULL, '', 'ruta'),
(17, '0000000006', NULL, '', 'ruta'),
(17, '0000000007', NULL, '', 'ruta'),
(17, '0000000008', NULL, '', 'ruta'),
(17, '0000000009', NULL, '', 'ruta'),
(17, '0000000010', NULL, '', 'ruta'),
(17, '0000000011', NULL, '', 'ruta'),
(18, '0000000001', NULL, '', 'ruta'),
(18, '0000000002', NULL, '', 'ruta'),
(18, '0000000003', NULL, '', 'ruta'),
(18, '0000000004', NULL, '', 'ruta'),
(18, '0000000006', NULL, '', 'ruta'),
(18, '0000000007', NULL, '', 'ruta'),
(18, '0000000008', NULL, '', 'ruta'),
(18, '0000000009', NULL, '', 'ruta'),
(18, '0000000010', NULL, '', 'ruta'),
(18, '0000000011', NULL, '', 'ruta'),
(19, '0000000001', NULL, '', 'ruta'),
(19, '0000000002', NULL, '', 'ruta'),
(19, '0000000003', NULL, '', 'ruta'),
(19, '0000000004', NULL, '', 'ruta'),
(19, '0000000006', NULL, '', 'ruta'),
(19, '0000000007', NULL, '', 'ruta'),
(19, '0000000008', NULL, '', 'ruta'),
(19, '0000000009', NULL, '', 'ruta'),
(19, '0000000010', NULL, '', 'ruta'),
(19, '0000000011', NULL, '', 'ruta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividadprogramada`
--

DROP TABLE IF EXISTS `actividadprogramada`;
CREATE TABLE IF NOT EXISTS `actividadprogramada` (
  `idActividadProgramada` int(11) NOT NULL AUTO_INCREMENT,
  `idPlanTrabajo` int(11) NOT NULL,
  `idNivelDesempeno` tinyint(4) DEFAULT NULL,
  `idPeriodoEvaluacion` tinyint(4) DEFAULT NULL,
  `idCicloEscolar` int(11) NOT NULL,
  `nivelDesempenoPonderado` tinyint(4) DEFAULT NULL,
  `observacion` varchar(300) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'a',
  PRIMARY KEY (`idActividadProgramada`),
  UNIQUE KEY `idPlanTrabajo_2` (`idPlanTrabajo`,`fecha`),
  UNIQUE KEY `idPlanTrabajo` (`idPlanTrabajo`,`fecha`,`hora`),
  UNIQUE KEY `fecha` (`fecha`,`hora`),
  KEY `idNivelDesempeno` (`idNivelDesempeno`),
  KEY `idPeriodoEvaluacion` (`idPeriodoEvaluacion`),
  KEY `idCicloEscolar` (`idCicloEscolar`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `actividadprogramada`
--

INSERT INTO `actividadprogramada` (`idActividadProgramada`, `idPlanTrabajo`, `idNivelDesempeno`, `idPeriodoEvaluacion`, `idCicloEscolar`, `nivelDesempenoPonderado`, `observacion`, `fecha`, `hora`, `estatus`) VALUES
(2, 1, 1, 1, 1, NULL, NULL, '2021-01-20', '08:00:00', 'a'),
(4, 2, 1, 1, 1, NULL, NULL, '2021-01-20', '09:00:00', 'a'),
(6, 3, 1, 1, 1, NULL, NULL, '2021-01-20', '10:00:00', 'a'),
(9, 2, 1, 1, 1, NULL, NULL, '2021-01-22', '10:00:00', 'a'),
(10, 1, 1, 1, 1, NULL, NULL, '2021-01-23', '16:00:00', 'a'),
(11, 5, 1, 1, 1, NULL, NULL, '2021-01-23', '15:00:00', 'a'),
(12, 1, 1, 1, 1, NULL, NULL, '2021-01-24', '08:00:00', 'a'),
(14, 2, 1, 1, 1, NULL, NULL, '2021-01-24', '14:00:00', 'a'),
(15, 3, 1, 1, 1, NULL, NULL, '2021-01-24', '12:00:00', 'a'),
(16, 1, 1, 1, 1, NULL, NULL, '2021-01-26', '08:00:00', 'a'),
(17, 2, 1, 1, 1, NULL, NULL, '2021-01-26', '10:00:00', 'a'),
(18, 3, 1, 1, 1, NULL, NULL, '2021-01-26', '13:00:00', 'a'),
(19, 1, 1, 1, 1, NULL, NULL, '2021-01-27', '08:00:00', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE IF NOT EXISTS `alumno` (
  `idAlumno` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idEscuela` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `ap1` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `ap2` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `curp` varchar(18) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `grupo` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `grado` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `turno` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `nombreTutor` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `facebook` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `preferennciaContacto` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'a',
  `rutaExpediente` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rutaPerfil` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`idAlumno`),
  UNIQUE KEY `curp` (`curp`),
  KEY `idEscuela` (`idEscuela`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`idAlumno`, `idEscuela`, `nombre`, `ap1`, `ap2`, `curp`, `grupo`, `grado`, `turno`, `nombreTutor`, `direccion`, `telefono`, `email`, `facebook`, `preferennciaContacto`, `estatus`, `rutaExpediente`, `rutaPerfil`) VALUES
('0000000001', 1, 'SEBASTIAN ALEXANDER', 'ALAMEA', 'INDA', 'AAIS150220HSLLNBA1', 'A', '3', 'v', 'Mama de Alexander', 'Ahome, Cohuibampo', '6689874563', 'email_1@email.com', 'Mama de Alexander', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000001', 'http://sistemaevaluacion/img/a0000000001.png'),
('0000000002', 1, 'JOSE MANUEL', 'CASTRO', 'VALENZUELA', 'CAVM150807HSLSLNA9', 'A', '3', 'v', 'Mama de Manule', 'Ahome, Cohuibampo', '6688979854', 'email_2@email.com', 'Mama de Manule', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000002', 'http://sistemaevaluacion/img/a0000000002.png'),
('0000000003', 1, 'AZIS DONALDO', 'CHAVEZ', 'DIAZ', 'CADA150208HSLHZZA1', 'A', '3', 'v', 'Mama de Donaldo', 'Ahome, Cohuibampo', '6687961616', 'email_3@email.com', 'Mama de Donaldo', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000003', 'http://sistemaevaluacion/img/a0000000003.png'),
('0000000004', 1, 'YEIMI ANGELIQUE', 'COTA', 'VALENZUELA', 'COVY150124MSLTLMA1', 'A', '3', 'v', 'Mama de ANGELIQUE', 'Ahome, Cohuibampo', '6688799798', 'email_4@email.com', 'Mama de ANGELIQUE', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000004', 'http://sistemaevaluacion/img/a0000000004.png'),
('0000000006', 1, 'JESUS', 'VAZQUEZ', 'VALENZUELA', 'COVY150124MSLTLMA2', 'A', '3', 'v', 'Mama de JESUS', 'Ahome, Cohuibampo', '6688799791', 'email_4@email.com', 'Mama de JESUS', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000006', 'http://sistemaevaluacion/img/a0000000006.png'),
('0000000007', 1, 'MARIO', 'BARRERAS', 'VALENZUELA', 'COVY150124MSLTLMA3', 'A', '3', 'v', 'Mama de MARIO', 'Ahome, Cohuibampo', '6688799792', 'email_4@email.com', 'Mama de MARIO', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000007', 'http://sistemaevaluacion/img/a0000000007.png'),
('0000000008', 1, 'JUAN', 'INDA', 'VALENZUELA', 'COVY150124MSLTLMA4', 'A', '3', 'v', 'Mama de JUAN', 'Ahome, Cohuibampo', '6688799793', 'email_4@email.com', 'Mama de JUAN', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000008', 'http://sistemaevaluacion/img/a0000000008.png'),
('0000000009', 1, 'PEPITO', 'DIAZ', 'VALENZUELA', 'COVY150124MSLTLMA5', 'A', '3', 'v', 'Mama de PEPITO', 'Ahome, Cohuibampo', '6688799794', 'email_4@email.com', 'Mama de PEPITO', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000009', 'http://sistemaevaluacion/img/a0000000009.png'),
('0000000010', 1, 'ALEJANDRA', 'LOPEZ', 'VALENZUELA', 'COVY150124MSLTLMA6', 'A', '3', 'v', 'Mama de ALEJANDRA', 'Ahome, Cohuibampo', '6688799795', 'email_4@email.com', 'Mama de ALEJANDRA', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000010', 'http://sistemaevaluacion/img/a0000000010.png'),
('0000000011', 1, 'MARIOA', 'QUINTANA', 'VALENZUELA', 'COVY150124MSLTLMA7', 'A', '3', 'v', 'Mama de MARIOA', 'Ahome, Cohuibampo', '6688799796', 'email_4@email.com', 'Mama de MARIOA', 'Whatsapp', 'a', 'Ciclo 2021-2022/0000000011', 'http://sistemaevaluacion/img/a0000000011.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aprendizajeesperado`
--

DROP TABLE IF EXISTS `aprendizajeesperado`;
CREATE TABLE IF NOT EXISTS `aprendizajeesperado` (
  `idAprendizajeEsperado` int(11) NOT NULL AUTO_INCREMENT,
  `idAreaFormacion` tinyint(4) DEFAULT NULL,
  `descripcion` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idAprendizajeEsperado`),
  KEY `idAreaFormacion` (`idAreaFormacion`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `aprendizajeesperado`
--

INSERT INTO `aprendizajeesperado` (`idAprendizajeEsperado`, `idAreaFormacion`, `descripcion`, `estatus`) VALUES
(1, 1, 'Solicita la palabra para participar y escucha las ideas de sus companeros.', 'a'),
(2, 1, 'Expresa con eficacia sus ideas acerca de diversos temas y atiende lo que se dice en interacciones con otras personas.', 'a'),
(3, 1, 'Narra anecdotas, siguiendo la secuencia y el orden de las ideas, con entonacion y volumen apropiado para hacerse escuchar y entender.', 'a'),
(4, 1, 'Menciona caracteristicas de objetos y personas que conoce y observa.', 'a'),
(5, 1, 'Explica como es, como ocurrio o como funciona algo, ordenando las ideas para que los demas comprendan.', 'a'),
(6, 1, 'Responde a por que o como sucedio algo en relacion con experiencias y hechos que comenta.', 'a'),
(7, 1, 'Argumenta por que estade acuerdo o endesacuerdo con ideas yafirmaciones de otraspersonas.', 'a'),
(8, 1, 'Da instrucciones paraorganizar y realizardiversas actividades enjuegos y para armarobjetos.', 'a'),
(9, 1, 'Conoce palabras yexpresiones que seutilizan en su mediofamiliar y localidad, yreconoce su significado.', 'a'),
(10, 1, 'Identifica algunasdiferencias en lasformas de hablar de lagente.', 'a'),
(11, 1, 'Explica las razones porlas que elige un materialde su interes, cuandoexplora los acervos.', 'a'),
(12, 1, 'Expresa su opinionsobre textosinformativos leidos envoz alta por otrapersona.', 'a'),
(13, 1, 'Expresa ideas paraconstruir textosinformativos.', 'a'),
(14, 1, 'Comenta e identificaalgunas caracteristicasde textos informativos.', 'a'),
(15, 1, 'Narra historias que leson familiares, hablaacerca de lospersonajes y suscaracteristicas, de lasacciones y los lugaresdonde se desarrollan.', 'a'),
(16, 1, 'Comenta, a partir de lalectura que escucha detextos literarios, ideasque relaciona conexperiencias propias oalgo que no conocia.', 'a'),
(17, 1, 'Describe personajes ylugares que imagina alescuchar cuentos,fabulas, leyendas yotros relatos literarios.', 'a'),
(18, 1, 'Cuenta historias deinvencion propia yexpresa opinionessobre las de otroscompaneros.', 'a'),
(19, 1, 'Construyecolectivamentenarraciones con laexpresion de las ideasque quiere comunicarpor escrito y que dicta ala educadora.', 'a'),
(20, 1, 'Expresa graficamentenarraciones conrecursos personales.', 'a'),
(21, 1, 'Aprende poemas y losdice frente a otraspersonas.', 'a'),
(22, 1, 'Identifica la rima enpoemas leidos en vozalta.', 'a'),
(23, 1, 'Dice rimas, canciones,trabalenguas,adivinanzas y otrosjuegos del lenguaje.', 'a'),
(24, 1, 'Construyecolectivamente rimassencillas.', 'a'),
(25, 1, 'Dice relatos de latradicion oral que le sonfamiliares.', 'a'),
(26, 1, 'Escribe su nombre condiversos propositos eidentifica el de algunoscompaneros.', 'a'),
(27, 1, 'Identifica su nombre yotros datos personalesen diversosdocumentos.', 'a'),
(28, 1, 'Comenta noticias que sedifunden en periodicos,radio, television y otrosmedios.', 'a'),
(29, 1, 'Interpreta instructivos,cartas, recados ysenalamientos.', 'a'),
(30, 1, 'Escribe instructivos,cartas, recados ysenalamientosutilizando recursospropios.', 'a'),
(31, 1, 'Produce textos parainformar algo de interesa la comunidad escolaro a los padres defamilia.', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areaformacion`
--

DROP TABLE IF EXISTS `areaformacion`;
CREATE TABLE IF NOT EXISTS `areaformacion` (
  `idAreaFormacion` tinyint(4) NOT NULL,
  `descripcion` varchar(54) COLLATE utf8_spanish2_ci NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idAreaFormacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `areaformacion`
--

INSERT INTO `areaformacion` (`idAreaFormacion`, `descripcion`, `estatus`) VALUES
(1, 'Lenguaje y Comunicacion', 'a'),
(2, 'Pensamiento Matematico', 'a'),
(3, 'Exploracion y compresension del mundo natural y social', 'a'),
(4, 'Lengua Extranjera', 'a'),
(5, 'Artes', 'a'),
(6, 'Educacion Fisica', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cicloescolar`
--

DROP TABLE IF EXISTS `cicloescolar`;
CREATE TABLE IF NOT EXISTS `cicloescolar` (
  `idCicloEscolar` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `inicioCiclo` date DEFAULT NULL,
  `finCiclo` date DEFAULT NULL,
  `diasHabiles` smallint(6) DEFAULT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`idCicloEscolar`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cicloescolar`
--

INSERT INTO `cicloescolar` (`idCicloEscolar`, `nombre`, `inicioCiclo`, `finCiclo`, `diasHabiles`, `estatus`) VALUES
(1, 'Ciclo 2020-2021', '2020-08-24', '2021-07-09', 191, 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE IF NOT EXISTS `comentario` (
  `idComentario` int(11) NOT NULL AUTO_INCREMENT,
  `idActividadProgramada` int(11) NOT NULL,
  `idAlumno` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idDocente` int(11) DEFAULT NULL,
  `comentario` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idComentario`),
  KEY `comentario_ibfk_01` (`idActividadProgramada`),
  KEY `comentario_ibfk_02` (`idAlumno`),
  KEY `comentario_ibfk_03` (`idDocente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`idComentario`, `idActividadProgramada`, `idAlumno`, `idDocente`, `comentario`) VALUES
(1, 19, '0000000001', NULL, 'PRueba Nuermo 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadrohonor`
--

DROP TABLE IF EXISTS `cuadrohonor`;
CREATE TABLE IF NOT EXISTS `cuadrohonor` (
  `idCuadroHonor` int(11) NOT NULL AUTO_INCREMENT,
  `idAlumno` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idActividadProgramada` int(11) NOT NULL,
  PRIMARY KEY (`idCuadroHonor`,`idAlumno`,`idActividadProgramada`),
  KEY `idAlumno` (`idAlumno`),
  KEY `idActividadProgramada` (`idActividadProgramada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico`
--

DROP TABLE IF EXISTS `diagnostico`;
CREATE TABLE IF NOT EXISTS `diagnostico` (
  `idDiagnostico` tinyint(4) NOT NULL,
  `idAreaFormacion` tinyint(4) DEFAULT NULL,
  `descripcion` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idDiagnostico`),
  KEY `idAreaFormacion` (`idAreaFormacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `diagnostico`
--

INSERT INTO `diagnostico` (`idDiagnostico`, `idAreaFormacion`, `descripcion`, `estatus`) VALUES
(1, 1, 'Reconoce su nombre', 'a'),
(2, 1, 'Reproduce graficamento su nombre', 'a'),
(3, 1, 'Escribe su nombre con diversos propositos', 'a'),
(4, 1, 'Sabe como se llama y lo menciona', 'a'),
(5, 1, 'Utiliza infromacion de nombres que conoce, datos sobre si mismo, del lugar donde vive y de su familia', 'a'),
(6, 1, 'Narra sucesos reales o imaginarios', 'a'),
(7, 1, 'Utiliza el lenguaje para construir ideas mas completas, secuenciadas y precisas', 'a'),
(8, 1, 'Evoca y explica activadades que ha relizado haciendo referencias espaciales y temporales', 'a'),
(9, 1, 'Solicita y proporciona ayudada para llevar a cabo diferentes tareas', 'a'),
(10, 1, 'Solicita la palabra levantando la mano', 'a'),
(11, 1, 'Respeta el turno de los demas', 'a'),
(12, 1, 'Narra anecdotas, cuentos, leyendas y fabulas siguiendo la secuencia de sucesos', 'a'),
(13, 1, 'Identifica el contenido de un texto al mostrarle un libro con solo observar las imagenes', 'a'),
(14, 1, 'Pregunta palabras que no entiende al escuchar fracmentos de una lectura', 'a'),
(15, 1, 'Utiliza marcas graficas y explica que dice su texto', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

DROP TABLE IF EXISTS `docente`;
CREATE TABLE IF NOT EXISTS `docente` (
  `idDocente` int(11) NOT NULL,
  `idEscuela` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `ap1` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `ap2` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `curp` varchar(18) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `facebook` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `grupo` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `grado` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `turno` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `rutaPerfil` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idDocente`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `curp` (`curp`),
  UNIQUE KEY `rfc` (`rfc`),
  KEY `idEscuela` (`idEscuela`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`idDocente`, `idEscuela`, `nombre`, `ap1`, `ap2`, `curp`, `rfc`, `direccion`, `telefono`, `facebook`, `grupo`, `grado`, `turno`, `email`, `rutaPerfil`, `estatus`) VALUES
(1, 1, 'Alba Lorena', 'Montes', 'Barreras', 'MOBA900902MSLNRL05', 'MOBA9009021S1', 'Ahome, Sinaloa', '6686543210', 'Lerona Montes', 'A', '3', 'v', 'email@email.com', 'http://sistemaevaluacion/img/d1.png', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuela`
--

DROP TABLE IF EXISTS `escuela`;
CREATE TABLE IF NOT EXISTS `escuela` (
  `idEscuela` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `zonaEscolar` varchar(3) COLLATE utf8_spanish2_ci NOT NULL,
  `sector` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idEscuela`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `escuela`
--

INSERT INTO `escuela` (`idEscuela`, `nombre`, `clave`, `zonaEscolar`, `sector`, `direccion`, `telefono`) VALUES
(1, 'GUADALUPE VICTORIA', '25DJN0266W', '063', '1', 'Ahome, Cohuibampo', '6680123345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

DROP TABLE IF EXISTS `evaluacion`;
CREATE TABLE IF NOT EXISTS `evaluacion` (
  `idAlumno` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idAreaFormacion` tinyint(4) NOT NULL,
  `idPeriodoEvaluacion` tinyint(4) NOT NULL,
  `idNivelDesempeno` tinyint(4) NOT NULL,
  `idCicloEscolar` int(11) NOT NULL,
  `observacion` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idAlumno`,`idAreaFormacion`,`idPeriodoEvaluacion`),
  KEY `idAreaFormacion` (`idAreaFormacion`),
  KEY `idPeriodoEvaluacion` (`idPeriodoEvaluacion`),
  KEY `idNivelDesempeno` (`idNivelDesempeno`),
  KEY `idCicloEscolar` (`idCicloEscolar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias`
--

DROP TABLE IF EXISTS `evidencias`;
CREATE TABLE IF NOT EXISTS `evidencias` (
  `idEvidencia` int(11) NOT NULL,
  `idPlanTrabajo` int(11) NOT NULL,
  `nombreEvidencia` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `idFormato` tinyint(4) NOT NULL,
  PRIMARY KEY (`idEvidencia`,`idPlanTrabajo`),
  KEY `idPlanTrabajo` (`idPlanTrabajo`),
  KEY `idFormato` (`idFormato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `evidencias`
--

INSERT INTO `evidencias` (`idEvidencia`, `idPlanTrabajo`, `nombreEvidencia`, `descripcion`, `idFormato`) VALUES
(1, 1, 'nombre_1', 'decripcion_1', 1),
(1, 2, 'nombre_2', 'decripcion_2', 1),
(1, 3, 'nombre_3', 'decripcion_3', 1),
(1, 5, 'numero 1', 'evidencia numero 1', 2),
(1, 6, 'Evidencia 1', 'descripcion', 2),
(1, 7, 'evere', 'qweqweqwe', 2),
(1, 8, 'nombre', 'descripcion', 1),
(1, 9, 'Dibujo coloerado', 'Dibujo resultado de pintar con los dedos', 2),
(1, 10, 'sadfsadfs', 'asdfsadfsdfa', 2),
(1, 11, 'dsfgsdfgdsf', 'sdfgsdfgdsf', 3),
(2, 5, 'numero 2', 'evidencia numero 2', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato`
--

DROP TABLE IF EXISTS `formato`;
CREATE TABLE IF NOT EXISTS `formato` (
  `idFormato` tinyint(4) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idFormato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `formato`
--

INSERT INTO `formato` (`idFormato`, `descripcion`, `estatus`) VALUES
(1, 'PDF', 'a'),
(2, 'PNG', 'a'),
(3, '*.*', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveldesempeno`
--

DROP TABLE IF EXISTS `niveldesempeno`;
CREATE TABLE IF NOT EXISTS `niveldesempeno` (
  `idNivelDesempeno` tinyint(4) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `abreviacion` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `valorNumerico` tinyint(4) NOT NULL,
  PRIMARY KEY (`idNivelDesempeno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `niveldesempeno`
--

INSERT INTO `niveldesempeno` (`idNivelDesempeno`, `nombre`, `abreviacion`, `valorNumerico`) VALUES
(1, 'Require Apollo', 'RA', 1),
(2, 'En Proceso', 'EP', 2),
(3, 'Logrado', 'L', 3),
(4, 'Superado', 'S', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodoevaluacion`
--

DROP TABLE IF EXISTS `periodoevaluacion`;
CREATE TABLE IF NOT EXISTS `periodoevaluacion` (
  `idPeriodoEvaluacion` tinyint(4) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `numeroEvaluacion` tinyint(4) NOT NULL,
  `mesInicio` tinyint(4) NOT NULL,
  `mesFinal` tinyint(4) NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idPeriodoEvaluacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `periodoevaluacion`
--

INSERT INTO `periodoevaluacion` (`idPeriodoEvaluacion`, `nombre`, `numeroEvaluacion`, `mesInicio`, `mesFinal`, `estatus`) VALUES
(1, 'Diagnostico', 0, 1, 1, 'a'),
(2, 'Evaluacion #1', 1, 2, 4, 'a'),
(3, 'Evaluacion #2', 2, 5, 7, 'a'),
(4, 'Evaluacion #3', 3, 8, 10, 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantrabajo`
--

DROP TABLE IF EXISTS `plantrabajo`;
CREATE TABLE IF NOT EXISTS `plantrabajo` (
  `idPlanTrabajo` int(11) NOT NULL AUTO_INCREMENT,
  `idDocente` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `duracionMinutos` tinyint(4) NOT NULL,
  `tipoActividad` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `inicio` varchar(2000) COLLATE utf8_spanish2_ci NOT NULL,
  `desarrollo` varchar(2000) COLLATE utf8_spanish2_ci NOT NULL,
  `cierre` varchar(2000) COLLATE utf8_spanish2_ci NOT NULL,
  `recursos` varchar(2000) COLLATE utf8_spanish2_ci NOT NULL,
  `evaluacion` varchar(2000) COLLATE utf8_spanish2_ci NOT NULL,
  `fechaModificacion` date NOT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'a',
  PRIMARY KEY (`idPlanTrabajo`),
  UNIQUE KEY `idDocente` (`idDocente`,`nombre`),
  UNIQUE KEY `idDocente_2` (`idDocente`,`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `plantrabajo`
--

INSERT INTO `plantrabajo` (`idPlanTrabajo`, `idDocente`, `nombre`, `duracionMinutos`, `tipoActividad`, `inicio`, `desarrollo`, `cierre`, `recursos`, `evaluacion`, `fechaModificacion`, `estatus`) VALUES
(1, 1, 'Acuerdos para la convivencia y sigo el ritmo y hago música', 120, '0', 'Ubicar al alumno en su área de trabajo, para elaborar las actividades del día.;Preguntar al niño (a) si conoce el juego de las escondidas.;Pedirle que nos explique cómo es el juego. (solo comentar en casa).', 'Comentar que en este juego existen reglas, preguntar si conoce algunas y anotarlas con ayuda de mamá o papá, las reglas que vayan dictando el niño (a) en una hoja blanca. (Anotar nombre completo del alumno, fecha y tema);Realizar el juego con sus familiares respetando las reglas, y al finalizar conversar como se sintieron, si siguieron las reglas anteriormente establecidas. (Solo comentar en casa);Proponer al niño escuchar los diferentes sonidos que se hacen con distintos objetos como:1.	Pegando en la mesa con una cuchara o cacerola.2.	Con un vaso en el piso.3.	Con un cepillo en la puerta.;Escuchar su canción favorita y producir sonidos con algún objeto tratando de seguir el ritmo.', 'Presentar a su familia la melodía elaborada, y jugar a formar una orquesta.', 'Hojas blancas;Lapiz;Objetos:;Cuchara;Vaso;Cepillo;Aparato para reproducir música.', 'Propone acuerdos para la convivencia.;Sigue el ritmo de la música con objetos a su alcance.', '2021-01-11', 'a'),
(2, 1, 'Pequeñas grandes acciones y Cuento, organizo e interpreto', 90, '0', 'Recordar la clase del pasado viernes 16 de octubre “Y la basura, ¿Dónde?., y comentar donde va la basura.;Realizar una caminata por la calle donde viven, identificar algún lugar donde haya basura y tomar foto. Proponer a los integrantes de la familia realizar una limpieza.;Limpiar con cuidado, pueden utilizar guantes y lavarse bien las manos. (Tomar fotografía una vez limpio).;Platicar como se sintieron al cuidar su medio ambiente. (solo conversar en casa)', 'Abrir tu libro de mi álbum en la página 36 y 40 “Vamos a comprar”;Observar todas las frutas y verduras que se muestran ahí.;Registra en una tabla en hoja blanca, con apoyo de mamá o papá, la cantidad que hay de cada una de ellas.', 'Conversar sobre la tabla de las cantidades de frutas y respondan con ayuda de su pictograma:1)¿De qué fruta hay más piezas?2)¿De qué fruta hay menos piezas?3)¿Cuántas piñas hay?4)¿Cuántos aguacates hay?', 'Bolsas para recoger la basura.;Libro de mi albúm.;Crayolas.;Hojas blancas', 'Cuidado del medio ambiente.;Responde preguntas con información organizada en un pictograma.', '2021-01-11', 'a'),
(3, 1, '¿En que se parecen algunos animales?', 90, '0', 'Ubicar al alumno en su espacio de trabajo, decirle que se ponga cómodo para iniciar a trabajar.;Preguntar al alumno qué tipos de animales conoce y que mencione las características de estos. (solo comentar en casa);Dialogar sobre los animales que más predominan en su comunidad. (solo comentar en casa)', 'Pedir que observe detenidamente la lámina de mi álbum de preescolar “los sonidos del zoológico” en la página 18. 10;Solicitar que elija dos animales y que describa tres semejanzas, puede mencionarle el siguiente ejemplo: El león y la hiena se parecen porque los dos tienen cola, ¿Qué otras semejanzas encuentras?;Dibujar en una hoja blanca de trabajo titulada “¿En que se parecen algunos animales?” los dos animales que el niño (a) eligió, y con ayuda de mamá o papa anotar las 3 semejanzas que el alumno vaya mencionando.', 'Trabajar en tu libro de valores en las páginas 5 y 6, el valor de la honestidad.;Leer detenidamente el concepto de honestidad al niño (a) y preguntar ¿Cuándo has sido honesto? ¿Conoces a alguien que siempre sea honesto?', 'Libro de mi albúm de preescolar;Hojas blancas;Lápiz;Crayolas;Libro de valores', 'Identificar características comunes de algunos animales.', '2021-01-11', 'a'),
(5, 1, 'Nueva Actividad prueba definitiva', 120, '0', 'sadcnsdajknksnd', 'sadcnsdajknksnd', 'sadcnsdajknksnd', 'sadcnsdajknksnd', '', '2021-01-21', 'a'),
(6, 1, 'Nombre Actividad', 40, '0', 'inicio', 'desarrollo', 'cierrre', 'recursos', '', '2021-01-21', 'a'),
(7, 1, 'pruebareset', 30, '0', 'ngChange', 'ngChange', 'ngChange', 'ngChange', '', '2021-01-21', 'a'),
(8, 1, 'NombreActividad', 20, '0', 'inicio', 'desarorllo', 'cierre', 'recursos', '', '2021-01-21', 'a'),
(9, 1, 'Coloerar con los dedos', 30, '0', 'Inicio', 'Desarrollo', 'Cierre', 'Recursos', '', '2021-01-21', 'a'),
(10, 1, 'afasdfsadf', 12, '0', 'asdfsadfsadf', 'asdfasdfsadf', 'asdfsadfasdf', 'asdfsadf', '', '2021-01-21', 'a'),
(11, 1, 'csakjdncsdjaknclsakcnskadnclsadjck', 34, '0', 'dsfgsdfgdsfgdsfg', 'sdfgsdfgdsfdfsgdsfg', 'cvbxcbcvb', 'dfdsfgsdf', '', '2021-01-21', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantrabajo_aprendizajeesperado`
--

DROP TABLE IF EXISTS `plantrabajo_aprendizajeesperado`;
CREATE TABLE IF NOT EXISTS `plantrabajo_aprendizajeesperado` (
  `idAprendizajeEsperado` int(11) NOT NULL,
  `idPlanTrabajo` int(11) NOT NULL,
  PRIMARY KEY (`idAprendizajeEsperado`,`idPlanTrabajo`),
  KEY `idPlanTrabajo` (`idPlanTrabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `plantrabajo_aprendizajeesperado`
--

INSERT INTO `plantrabajo_aprendizajeesperado` (`idAprendizajeEsperado`, `idPlanTrabajo`) VALUES
(1, 1),
(2, 2),
(3, 3),
(1, 5),
(2, 5),
(2, 6),
(3, 6),
(2, 7),
(2, 8),
(4, 9),
(13, 10),
(8, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantrabajo_diagnostico`
--

DROP TABLE IF EXISTS `plantrabajo_diagnostico`;
CREATE TABLE IF NOT EXISTS `plantrabajo_diagnostico` (
  `idDiagnostico` tinyint(4) NOT NULL,
  `idPlanTrabajo` int(11) NOT NULL,
  PRIMARY KEY (`idDiagnostico`,`idPlanTrabajo`),
  KEY `idPlanTrabajo` (`idPlanTrabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL,
  `idDocente` int(11) DEFAULT NULL,
  `idAlumno` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rol` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `contraseña` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `token` varchar(300) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `rutaPerfil` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estatus` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `idDocente` (`idDocente`),
  KEY `idAlumno` (`idAlumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `idDocente`, `idAlumno`, `rol`, `email`, `contraseña`, `token`, `rutaPerfil`, `estatus`) VALUES
(1, 1, NULL, 'docente', 'email@email.com', 'Contraseña01!', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2MTE2NzUxNzMsImF1ZCI6IjE0YTc0ZmQzZDc1NmViMDBlZjA3Yjc4NzI0ODhkMjcyMDI0M2RiYzciLCJpZCI6IjAwMDAwMDAwMDEiLCJpZFVzdWFyaW8iOiIyIn0.26ead63kvydHAgeowdJgzwZphFanDd8wfqzTVuIT8Q0', 'http://sistemaevaluacion/img/d1.png', 'a'),
(2, NULL, '0000000001', 'alumno', 'alumno@alumno', 'Cambio01!', NULL, 'ruta', 'a');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividadalumno`
--
ALTER TABLE `actividadalumno`
  ADD CONSTRAINT `actividadalumno_ibfk_1` FOREIGN KEY (`idActividadProgramada`) REFERENCES `actividadprogramada` (`idActividadProgramada`),
  ADD CONSTRAINT `actividadalumno_ibfk_2` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`),
  ADD CONSTRAINT `actividadalumno_ibfk_3` FOREIGN KEY (`idNivelDesempeno`) REFERENCES `niveldesempeno` (`idNivelDesempeno`);

--
-- Filtros para la tabla `actividadprogramada`
--
ALTER TABLE `actividadprogramada`
  ADD CONSTRAINT `actividadprogramada_ibfk_1` FOREIGN KEY (`idPlanTrabajo`) REFERENCES `plantrabajo` (`idPlanTrabajo`),
  ADD CONSTRAINT `actividadprogramada_ibfk_2` FOREIGN KEY (`idNivelDesempeno`) REFERENCES `niveldesempeno` (`idNivelDesempeno`),
  ADD CONSTRAINT `actividadprogramada_ibfk_3` FOREIGN KEY (`idPeriodoEvaluacion`) REFERENCES `periodoevaluacion` (`idPeriodoEvaluacion`),
  ADD CONSTRAINT `actividadprogramada_ibfk_4` FOREIGN KEY (`idCicloEscolar`) REFERENCES `cicloescolar` (`idCicloEscolar`);

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`idEscuela`) REFERENCES `escuela` (`idEscuela`);

--
-- Filtros para la tabla `aprendizajeesperado`
--
ALTER TABLE `aprendizajeesperado`
  ADD CONSTRAINT `aprendizajeesperado_ibfk_1` FOREIGN KEY (`idAreaFormacion`) REFERENCES `areaformacion` (`idAreaFormacion`);

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_01` FOREIGN KEY (`idActividadProgramada`) REFERENCES `actividadprogramada` (`idActividadProgramada`),
  ADD CONSTRAINT `comentario_ibfk_02` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`),
  ADD CONSTRAINT `comentario_ibfk_03` FOREIGN KEY (`idDocente`) REFERENCES `docente` (`idDocente`);

--
-- Filtros para la tabla `cuadrohonor`
--
ALTER TABLE `cuadrohonor`
  ADD CONSTRAINT `cuadrohonor_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`),
  ADD CONSTRAINT `cuadrohonor_ibfk_2` FOREIGN KEY (`idActividadProgramada`) REFERENCES `actividadprogramada` (`idActividadProgramada`);

--
-- Filtros para la tabla `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD CONSTRAINT `diagnostico_ibfk_1` FOREIGN KEY (`idAreaFormacion`) REFERENCES `areaformacion` (`idAreaFormacion`);

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`idEscuela`) REFERENCES `escuela` (`idEscuela`);

--
-- Filtros para la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD CONSTRAINT `evaluacion_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`),
  ADD CONSTRAINT `evaluacion_ibfk_2` FOREIGN KEY (`idAreaFormacion`) REFERENCES `areaformacion` (`idAreaFormacion`),
  ADD CONSTRAINT `evaluacion_ibfk_3` FOREIGN KEY (`idPeriodoEvaluacion`) REFERENCES `periodoevaluacion` (`idPeriodoEvaluacion`),
  ADD CONSTRAINT `evaluacion_ibfk_4` FOREIGN KEY (`idNivelDesempeno`) REFERENCES `niveldesempeno` (`idNivelDesempeno`),
  ADD CONSTRAINT `evaluacion_ibfk_5` FOREIGN KEY (`idCicloEscolar`) REFERENCES `cicloescolar` (`idCicloEscolar`);

--
-- Filtros para la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD CONSTRAINT `evidencias_ibfk_1` FOREIGN KEY (`idPlanTrabajo`) REFERENCES `plantrabajo` (`idPlanTrabajo`),
  ADD CONSTRAINT `evidencias_ibfk_2` FOREIGN KEY (`idFormato`) REFERENCES `formato` (`idFormato`);

--
-- Filtros para la tabla `plantrabajo`
--
ALTER TABLE `plantrabajo`
  ADD CONSTRAINT `plantrabajo_ibfk_1` FOREIGN KEY (`idDocente`) REFERENCES `docente` (`idDocente`);

--
-- Filtros para la tabla `plantrabajo_aprendizajeesperado`
--
ALTER TABLE `plantrabajo_aprendizajeesperado`
  ADD CONSTRAINT `plantrabajo_aprendizajeesperado_ibfk_1` FOREIGN KEY (`idAprendizajeEsperado`) REFERENCES `aprendizajeesperado` (`idAprendizajeEsperado`),
  ADD CONSTRAINT `plantrabajo_aprendizajeesperado_ibfk_2` FOREIGN KEY (`idPlanTrabajo`) REFERENCES `plantrabajo` (`idPlanTrabajo`);

--
-- Filtros para la tabla `plantrabajo_diagnostico`
--
ALTER TABLE `plantrabajo_diagnostico`
  ADD CONSTRAINT `plantrabajo_diagnostico_ibfk_1` FOREIGN KEY (`idDiagnostico`) REFERENCES `diagnostico` (`idDiagnostico`),
  ADD CONSTRAINT `plantrabajo_diagnostico_ibfk_2` FOREIGN KEY (`idPlanTrabajo`) REFERENCES `plantrabajo` (`idPlanTrabajo`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idDocente`) REFERENCES `docente` (`idDocente`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
