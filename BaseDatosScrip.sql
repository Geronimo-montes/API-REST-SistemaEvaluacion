CREATE TABLE escuela (
    idEscuela int PRIMARY KEY,
    nombre varchar(50) NOT NULL,
    clave varchar(10) NOT NULL,
    zonaEscolar varchar(3) NOT NULL,
    sector varchar(1) NOT NULL,
    direccion varchar(80) NOT NULL,
    telefono varchar(10) NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

INSERT INTO escuela VALUES (1, "GUADALUPE VICTORIA", "25DJN0266W", "063", "1", "Ahome, Cohuibampo", "6680123345");

CREATE TABLE docente (
    idDocente int PRIMARY KEY,
    idEscuela int NOT NULL,/*fk*/
    nombre varchar(50) NOT NULL,
    ap1 varchar(50) NOT NULL,
    ap2 varchar(50),
    curp varchar(18) UNIQUE,
    rfc varchar(13) UNIQUE,
    direccion varchar(100) NOT NULL,
    telefono varchar(10) NOT NULL,
    facebook varchar(50) NOT NULL,
    grupo varchar(1) NOT NULL,
    grado varchar(1) NOT NULL,
    turno varchar(1) NOT NULL,
    rol varchar(50) NOT NULL,
    email varchar(80) NOT NULL UNIQUE,
    contraseña varchar(20) NOT NULL,
    token varchar(215) DEFAULT NULL,
    rutaPerfil varchar(200),
    estatus varchar(1) NOT NULL,

    FOREIGN KEY (idEscuela) REFERENCES escuela (idEscuela)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;

INSERT INTO docente VALUES (1, 1, "Alba Lorena", "Montes", "Barreras", "MOBA900902MSLNRL05", "MOBA9009021S1", 
"Ahome, Sinaloa", "6686543210", "Lerona Montes", "A", "3", "v", "maestra", "email@email.com", "Contra01!", "", "http://sistemaevaluacion/img/d1.png", "a");

CREATE TABLE alumno (
    idAlumno varchar(50) PRIMARY KEY,
    idEscuela int NOT NULL, /*fk*/
    nombre varchar(50) NOT NULL,
    ap1 varchar(50) NOT NULL,
    ap2 varchar(50),
    curp varchar(18) UNIQUE,
    grupo varchar(1) NOT NULL, 
    grado varchar(1) NOT NULL,
    turno varchar(1) NOT NULL,
    nombreTutor varchar(200) NOT NULL,
    direccion varchar(100),
    telefono varchar(10),
    email varchar(80),
    facebook varchar(50),
    preferennciaContacto varchar(50),
    estatus varchar(1) NOT NULL DEFAULT 'a',
    rutaExpediente varchar(200),
    rutaPerfil varchar(200),

    FOREIGN KEY (idEscuela) REFERENCES escuela (idEscuela)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;  

INSERT INTO alumno VALUES ('0000000001', 1, "SEBASTIAN ALEXANDER",     "ALAMEA",   "INDA",       "AAIS150220HSLLNBA1", "A", "3", "v", "Mama de Alexander",     "Ahome, Cohuibampo", "6689874563", "email_1@email.com", "Mama de Alexander",    "Whatsapp", "a" , "Ciclo 2021-2022/1", "http://sistemaevaluacion/img/a0000000001.png");
INSERT INTO alumno VALUES ('0000000002', 1, "JOSE MANUEL",             "CASTRO",   "VALENZUELA", "CAVM150807HSLSLNA9", "A", "3", "v", "Mama de Manule",        "Ahome, Cohuibampo", "6688979854", "email_2@email.com", "Mama de Manule",       "Whatsapp", "a" , "Ciclo 2021-2022/2", "http://sistemaevaluacion/img/a0000000002.png");
INSERT INTO alumno VALUES ('0000000003', 1, "AZIS DONALDO",            "CHAVEZ",   "DIAZ",       "CADA150208HSLHZZA1", "A", "3", "v", "Mama de Donaldo",       "Ahome, Cohuibampo", "6687961616", "email_3@email.com", "Mama de Donaldo",      "Whatsapp", "a" , "Ciclo 2021-2022/3", "http://sistemaevaluacion/img/a0000000003.png");
INSERT INTO alumno VALUES ('0000000004', 1, "YEIMI ANGELIQUE",         "COTA",     "VALENZUELA", "COVY150124MSLTLMA1", "A", "3", "v", "Mama de ANGELIQUE",     "Ahome, Cohuibampo", "6688799798", "email_4@email.com", "Mama de ANGELIQUE",    "Whatsapp", "a" , "Ciclo 2021-2022/4", "http://sistemaevaluacion/img/a0000000004.png");
INSERT INTO alumno VALUES ('0000000006', 1, "JESUS",                   "VAZQUEZ",  "VALENZUELA", "COVY150124MSLTLMA2", "A", "3", "v", "Mama de JESUS",         "Ahome, Cohuibampo", "6688799791", "email_4@email.com", "Mama de JESUS",        "Whatsapp", "a" , "Ciclo 2021-2022/6", "http://sistemaevaluacion/img/a0000000006.png");
INSERT INTO alumno VALUES ('0000000007', 1, "MARIO",                   "BARRERAS", "VALENZUELA", "COVY150124MSLTLMA3", "A", "3", "v", "Mama de MARIO",         "Ahome, Cohuibampo", "6688799792", "email_4@email.com", "Mama de MARIO",        "Whatsapp", "a" , "Ciclo 2021-2022/7", "http://sistemaevaluacion/img/a0000000007.png");
INSERT INTO alumno VALUES ('0000000008', 1, "JUAN",                    "INDA",     "VALENZUELA", "COVY150124MSLTLMA4", "A", "3", "v", "Mama de JUAN",          "Ahome, Cohuibampo", "6688799793", "email_4@email.com", "Mama de JUAN",         "Whatsapp", "a" , "Ciclo 2021-2022/8", "http://sistemaevaluacion/img/a0000000008.png");
INSERT INTO alumno VALUES ('0000000009', 1, "PEPITO",                  "DIAZ",     "VALENZUELA", "COVY150124MSLTLMA5", "A", "3", "v", "Mama de PEPITO",        "Ahome, Cohuibampo", "6688799794", "email_4@email.com", "Mama de PEPITO",       "Whatsapp", "a" , "Ciclo 2021-2022/9", "http://sistemaevaluacion/img/a0000000009.png");
INSERT INTO alumno VALUES ('0000000010', 1, "ALEJANDRA",               "LOPEZ",    "VALENZUELA", "COVY150124MSLTLMA6", "A", "3", "v", "Mama de ALEJANDRA",     "Ahome, Cohuibampo", "6688799795", "email_4@email.com", "Mama de ALEJANDRA",    "Whatsapp", "a", "Ciclo 2021-2022/10", "http://sistemaevaluacion/img/a0000000010.png");
INSERT INTO alumno VALUES ('0000000011', 1, "MARIOA",                  "QUINTANA", "VALENZUELA", "COVY150124MSLTLMA7", "A", "3", "v", "Mama de MARIOA",        "Ahome, Cohuibampo", "6688799796", "email_4@email.com", "Mama de MARIOA",       "Whatsapp", "a", "Ciclo 2021-2022/11", "http://sistemaevaluacion/img/a0000000011.png");

CREATE TABLE periodoEvaluacion (
    idPeriodoEvaluacion tinyint PRIMARY KEY,
    nombre varchar(20) NOT NULL,
    numeroEvaluacion tinyint NOT NULL,
    mesInicio tinyint NOT NULL,
    mesFinal tinyint NOT NULL,
    estatus varchar(1) NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

INSERT INTO periodoEvaluacion VALUES (1, "Diagnostico",   0, 1, 1, "a");
INSERT INTO periodoEvaluacion VALUES (2, "Evaluacion #1", 1, 2, 4, "a");
INSERT INTO periodoEvaluacion VALUES (3, "Evaluacion #2", 2, 5, 7, "a");
INSERT INTO periodoEvaluacion VALUES (4, "Evaluacion #3", 3, 8, 10, "a");

CREATE TABLE nivelDesempeno (
    idNivelDesempeno tinyint PRIMARY KEY,
    nombre varchar(20) NOT NULL,
    abreviacion varchar(2) NOT NULL,
    valorNumerico tinyint NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

INSERT INTO nivelDesempeno VALUES (1, "Require Apollo", "RA", 1);
INSERT INTO nivelDesempeno VALUES (2, "En Proceso", "EP", 2);
INSERT INTO nivelDesempeno VALUES (3, "Logrado", "L", 3);
INSERT INTO nivelDesempeno VALUES (4, "Superado", "S", 4);

CREATE TABLE areaFormacion (
    idAreaFormacion tinyint PRIMARY KEY,
    descripcion varchar(54) NOT NULL,
    estatus varchar(1) NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

INSERT INTO areaFormacion VALUES (1, "Lenguaje y Comunicacion", "a");
INSERT INTO areaFormacion VALUES (2, "Pensamiento Matematico", "a");
INSERT INTO areaFormacion VALUES (3, "Exploracion y compresension del mundo natural y social", "a");
INSERT INTO areaFormacion VALUES (4, "Lengua Extranjera", "a");
INSERT INTO areaFormacion VALUES (5, "Artes", "a");
INSERT INTO areaFormacion VALUES (6, "Educacion Fisica", "a");

CREATE TABLE aprendizajeEsperado (
    idAprendizajeEsperado int PRIMARY KEY AUTO_INCREMENT,
    idAreaFormacion tinyint,
    descripcion varchar(300) NOT NULL,
    estatus varchar(1) NOT NULL,

    FOREIGN KEY (idAreaFormacion) REFERENCES areaFormacion (idAreaFormacion)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

INSERT INTO aprendizajeEsperado VALUES (1, 1, "Solicita la palabra para participar y escucha las ideas de sus companeros.", "a");
INSERT INTO aprendizajeEsperado VALUES (2, 1, "Expresa con eficacia sus ideas acerca de diversos temas y atiende lo que se dice en interacciones con otras personas.", "a");
INSERT INTO aprendizajeEsperado VALUES (3, 1, "Narra anecdotas, siguiendo la secuencia y el orden de las ideas, con entonacion y volumen apropiado para hacerse escuchar y entender.", "a");
INSERT INTO aprendizajeEsperado VALUES (4, 1, "Menciona caracteristicas de objetos y personas que conoce y observa.", "a");
INSERT INTO aprendizajeEsperado VALUES (5, 1, "Explica como es, como ocurrio o como funciona algo, ordenando las ideas para que los demas comprendan.", "a");
INSERT INTO aprendizajeEsperado VALUES (6, 1, "Responde a por que o como sucedio algo en relacion con experiencias y hechos que comenta.", "a");
INSERT INTO aprendizajeEsperado VALUES (7, 1, "Argumenta por que estade acuerdo o endesacuerdo con ideas yafirmaciones de otraspersonas.", "a");
INSERT INTO aprendizajeEsperado VALUES (8, 1, "Da instrucciones paraorganizar y realizardiversas actividades enjuegos y para armarobjetos.", "a");
INSERT INTO aprendizajeEsperado VALUES (9, 1, "Conoce palabras yexpresiones que seutilizan en su mediofamiliar y localidad, yreconoce su significado.", "a");
INSERT INTO aprendizajeEsperado VALUES (10, 1, "Identifica algunasdiferencias en lasformas de hablar de lagente.", "a");
INSERT INTO aprendizajeEsperado VALUES (11, 1, "Explica las razones porlas que elige un materialde su interes, cuandoexplora los acervos.", "a");
INSERT INTO aprendizajeEsperado VALUES (12, 1, "Expresa su opinionsobre textosinformativos leidos envoz alta por otrapersona.", "a");
INSERT INTO aprendizajeEsperado VALUES (13, 1, "Expresa ideas paraconstruir textosinformativos.", "a");
INSERT INTO aprendizajeEsperado VALUES (14, 1, "Comenta e identificaalgunas caracteristicasde textos informativos.", "a");
INSERT INTO aprendizajeEsperado VALUES (15, 1, "Narra historias que leson familiares, hablaacerca de lospersonajes y suscaracteristicas, de lasacciones y los lugaresdonde se desarrollan.", "a");
INSERT INTO aprendizajeEsperado VALUES (16, 1, "Comenta, a partir de lalectura que escucha detextos literarios, ideasque relaciona conexperiencias propias oalgo que no conocia.", "a");
INSERT INTO aprendizajeEsperado VALUES (17, 1, "Describe personajes ylugares que imagina alescuchar cuentos,fabulas, leyendas yotros relatos literarios.", "a");
INSERT INTO aprendizajeEsperado VALUES (18, 1, "Cuenta historias deinvencion propia yexpresa opinionessobre las de otroscompaneros.", "a");
INSERT INTO aprendizajeEsperado VALUES (19, 1, "Construyecolectivamentenarraciones con laexpresion de las ideasque quiere comunicarpor escrito y que dicta ala educadora.", "a");
INSERT INTO aprendizajeEsperado VALUES (20, 1, "Expresa graficamentenarraciones conrecursos personales.", "a");
INSERT INTO aprendizajeEsperado VALUES (21, 1, "Aprende poemas y losdice frente a otraspersonas.", "a");
INSERT INTO aprendizajeEsperado VALUES (22, 1, "Identifica la rima enpoemas leidos en vozalta.", "a");
INSERT INTO aprendizajeEsperado VALUES (23, 1, "Dice rimas, canciones,trabalenguas,adivinanzas y otrosjuegos del lenguaje.", "a");
INSERT INTO aprendizajeEsperado VALUES (24, 1, "Construyecolectivamente rimassencillas.", "a");
INSERT INTO aprendizajeEsperado VALUES (25, 1, "Dice relatos de latradicion oral que le sonfamiliares.", "a");
INSERT INTO aprendizajeEsperado VALUES (26, 1, "Escribe su nombre condiversos propositos eidentifica el de algunoscompaneros.", "a");
INSERT INTO aprendizajeEsperado VALUES (27, 1, "Identifica su nombre yotros datos personalesen diversosdocumentos.", "a");
INSERT INTO aprendizajeEsperado VALUES (28, 1, "Comenta noticias que sedifunden en periodicos,radio, television y otrosmedios.", "a");
INSERT INTO aprendizajeEsperado VALUES (29, 1, "Interpreta instructivos,cartas, recados ysenalamientos.", "a");
INSERT INTO aprendizajeEsperado VALUES (30, 1, "Escribe instructivos,cartas, recados ysenalamientosutilizando recursospropios.", "a");
INSERT INTO aprendizajeEsperado VALUES (31, 1, "Produce textos parainformar algo de interesa la comunidad escolaro a los padres defamilia.", "a");

CREATE TABLE diagnostico (
    idDiagnostico tinyint PRIMARY KEY,
    idAreaFormacion tinyint,
    descripcion varchar(300) NOT NULL,
    estatus varchar(1) NOT NULL,

    FOREIGN KEY (idAreaFormacion) REFERENCES areaFormacion (idAreaFormacion)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;

INSERT INTO diagnostico VALUES (1,  1, "Reconoce su nombre", "a");
INSERT INTO diagnostico VALUES (2,  1, "Reproduce graficamento su nombre", "a");
INSERT INTO diagnostico VALUES (3,  1, "Escribe su nombre con diversos propositos", "a");
INSERT INTO diagnostico VALUES (4,  1, "Sabe como se llama y lo menciona", "a");
INSERT INTO diagnostico VALUES (5,  1, "Utiliza infromacion de nombres que conoce, datos sobre si mismo, del lugar donde vive y de su familia", "a");
INSERT INTO diagnostico VALUES (6,  1, "Narra sucesos reales o imaginarios", "a");
INSERT INTO diagnostico VALUES (7,  1, "Utiliza el lenguaje para construir ideas mas completas, secuenciadas y precisas", "a");
INSERT INTO diagnostico VALUES (8,  1, "Evoca y explica activadades que ha relizado haciendo referencias espaciales y temporales", "a");
INSERT INTO diagnostico VALUES (9,  1, "Solicita y proporciona ayudada para llevar a cabo diferentes tareas", "a");
INSERT INTO diagnostico VALUES (10, 1, "Solicita la palabra levantando la mano", "a");
INSERT INTO diagnostico VALUES (11, 1, "Respeta el turno de los demas", "a");
INSERT INTO diagnostico VALUES (12, 1, "Narra anecdotas, cuentos, leyendas y fabulas siguiendo la secuencia de sucesos", "a");
INSERT INTO diagnostico VALUES (13, 1, "Identifica el contenido de un texto al mostrarle un libro con solo observar las imagenes", "a");
INSERT INTO diagnostico VALUES (14, 1, "Pregunta palabras que no entiende al escuchar fracmentos de una lectura", "a");
INSERT INTO diagnostico VALUES (15, 1, "Utiliza marcas graficas y explica que dice su texto", "a");

CREATE TABLE planTrabajo (
    idPlanTrabajo int PRIMARY KEY AUTO_INCREMENT,
    idDocente int NOT NULL,/*fk*/
    nombre varchar(200) NOT NULL,
    duracionMinutos tinyint NOT NULL,
    tipoActividad varchar(1) NOT NULL,
    inicio varchar(2000) NOT NULL,
    desarrollo varchar(2000) NOT NULL,
    cierre varchar(2000) NOT NULL,  
    recursos varchar(2000) NOT NULL,
    evaluacion varchar(2000) NOT NULL,
    fechaModificacion date NOT NULL,
    estatus varchar(1) NOT NULL DEFAULT 'a',

    FOREIGN KEY (idDocente) REFERENCES docente (idDocente),
    CONSTRAINT (UQ_docenteNombre) UNIQUE (idDocente, nombre)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

INSERT INTO planTrabajo ( idDocente, nombre, duracionMinutos, tipoActividad, inicio, desarrollo, cierre, recursos, evaluacion, fechaModificacion, estatus ) 
VALUES(1, 'Acuerdos para la convivencia y sigo el ritmo y hago música', 120, 0, 
'Ubicar al alumno en su área de trabajo, para elaborar las actividades del día.;Preguntar al niño (a) si conoce el juego de las escondidas.;Pedirle que nos explique cómo es el juego. (solo comentar en casa).', 
'Comentar que en este juego existen reglas, preguntar si conoce algunas y anotarlas con ayuda de mamá o papá, las reglas que vayan dictando el niño (a) en una hoja blanca. (Anotar nombre completo del alumno, fecha y tema);Realizar el juego con sus familiares respetando las reglas, y al finalizar conversar como se sintieron, si siguieron las reglas anteriormente establecidas. (Solo comentar en casa);Proponer al niño escuchar los diferentes sonidos que se hacen con distintos objetos como:1.	Pegando en la mesa con una cuchara o cacerola.2.	Con un vaso en el piso.3.	Con un cepillo en la puerta.;Escuchar su canción favorita y producir sonidos con algún objeto tratando de seguir el ritmo.', 
'Presentar a su familia la melodía elaborada, y jugar a formar una orquesta.', 
'Hojas blancas;Lapiz;Objetos:;Cuchara;Vaso;Cepillo;Aparato para reproducir música.', 
'Propone acuerdos para la convivencia.;Sigue el ritmo de la música con objetos a su alcance.',
now(), 'a');
INSERT INTO planTrabajo ( idDocente, nombre, duracionMinutos, tipoActividad, inicio, desarrollo, cierre, recursos, evaluacion, fechaModificacion, estatus ) 
VALUES(1, 'Pequeñas grandes acciones y Cuento, organizo e interpreto', 90, 0,
'Recordar la clase del pasado viernes 16 de octubre “Y la basura, ¿Dónde?., y comentar donde va la basura.;Realizar una caminata por la calle donde viven, identificar algún lugar donde haya basura y tomar foto. Proponer a los integrantes de la familia realizar una limpieza.;Limpiar con cuidado, pueden utilizar guantes y lavarse bien las manos. (Tomar fotografía una vez limpio).;Platicar como se sintieron al cuidar su medio ambiente. (solo conversar en casa)',
'Abrir tu libro de mi álbum en la página 36 y 40 “Vamos a comprar”;Observar todas las frutas y verduras que se muestran ahí.;Registra en una tabla en hoja blanca, con apoyo de mamá o papá, la cantidad que hay de cada una de ellas.', 
'Conversar sobre la tabla de las cantidades de frutas y respondan con ayuda de su pictograma:1)¿De qué fruta hay más piezas?2)¿De qué fruta hay menos piezas?3)¿Cuántas piñas hay?4)¿Cuántos aguacates hay?', 
'Bolsas para recoger la basura.;Libro de mi albúm.;Crayolas.;Hojas blancas', 
'Cuidado del medio ambiente.;Responde preguntas con información organizada en un pictograma.',
now(), 'a');
INSERT INTO planTrabajo ( idDocente, nombre, duracionMinutos, tipoActividad, inicio, desarrollo, cierre, recursos, evaluacion, fechaModificacion, estatus ) 
VALUES(1, '¿En que se parecen algunos animales?', 90, 0,
'Ubicar al alumno en su espacio de trabajo, decirle que se ponga cómodo para iniciar a trabajar.;Preguntar al alumno qué tipos de animales conoce y que mencione las características de estos. (solo comentar en casa);Dialogar sobre los animales que más predominan en su comunidad. (solo comentar en casa)',
'Pedir que observe detenidamente la lámina de mi álbum de preescolar “los sonidos del zoológico” en la página 18. 10;Solicitar que elija dos animales y que describa tres semejanzas, puede mencionarle el siguiente ejemplo: El león y la hiena se parecen porque los dos tienen cola, ¿Qué otras semejanzas encuentras?;Dibujar en una hoja blanca de trabajo titulada “¿En que se parecen algunos animales?” los dos animales que el niño (a) eligió, y con ayuda de mamá o papa anotar las 3 semejanzas que el alumno vaya mencionando.', 
'Trabajar en tu libro de valores en las páginas 5 y 6, el valor de la honestidad.;Leer detenidamente el concepto de honestidad al niño (a) y preguntar ¿Cuándo has sido honesto? ¿Conoces a alguien que siempre sea honesto?', 
'Libro de mi albúm de preescolar;Hojas blancas;Lápiz;Crayolas;Libro de valores', 
'Identificar características comunes de algunos animales.',
now(), 'a');


CREATE TABLE planTrabajo_diagnostico (
    idDiagnostico tinyint,
    idPlanTrabajo int,

    PRIMARY KEY (idDiagnostico, idPlanTrabajo),
    FOREIGN KEY (idDiagnostico) REFERENCES diagnostico (idDiagnostico),
    FOREIGN KEY (idPlanTrabajo) REFERENCES planTrabajo (idPlanTrabajo)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE planTrabajo_aprendizajeEsperado (
    idAprendizajeEsperado int,
    idPlanTrabajo int,

    PRIMARY KEY (idAprendizajeEsperado, idPlanTrabajo),
    FOREIGN KEY (idAprendizajeEsperado) REFERENCES aprendizajeEsperado (idAprendizajeEsperado),
    FOREIGN KEY (idPlanTrabajo) REFERENCES planTrabajo (idPlanTrabajo)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

INSERT INTO planTrabajo_aprendizajeEsperado VALUES (1 , 1);
INSERT INTO planTrabajo_aprendizajeEsperado VALUES (2 , 2);
INSERT INTO planTrabajo_aprendizajeEsperado VALUES (3 , 3);

CREATE TABLE formato (
    idFormato tinyint NOT NULL,
    descripcion varchar(100) NOT NULL,
    estatus varchar(1) NOT NULL,

    PRIMARY KEY (idFormato)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;

INSERT INTO formato VALUES (1, "PDF", "a");
INSERT INTO formato VALUES (2, "PNG", "a");
INSERT INTO formato VALUES (3, "*.*", "a");


CREATE TABLE evidencias (
    idEvidencia int NOT NULL,
    idPlanTrabajo int NOT NULL,
    nombreEvidencia varchar(100) NOT NULL,
    descripcion varchar(200) NOT NULL,
    idFormato tinyint NOT NULL,

    PRIMARY KEY (idEvidencia, idPlanTrabajo),
    FOREIGN KEY (idPlanTrabajo) REFERENCES planTrabajo (idPlanTrabajo),
    FOREIGN KEY (idFormato) REFERENCES formato (idFormato)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;

INSERT INTO evidencias VALUES (1, 1 , "nombre_1", "decripcion_1", 1);
INSERT INTO evidencias VALUES (1, 2 , "nombre_2", "decripcion_2", 1);
INSERT INTO evidencias VALUES (1, 3 , "nombre_3", "decripcion_3", 1);

CREATE TABLE cicloEscolar (
  idCicloEscolar int PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(50) UNIQUE,
  inicioCiclo date,
  finCiclo date,
  diasHabiles smallint,
  estatus varchar(1)
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;

INSERT INTO cicloEscolar (nombre, inicioCiclo, finCiclo, diasHabiles, estatus) VALUES ("Ciclo 2020-2021", "20-08-24", "21-07-09", 191, "a");


CREATE TABLE actividadProgramada (
    idActividadProgramada int PRIMARY KEY AUTO_INCREMENT,
    idPlanTrabajo int NOT NULL, /*FK*/
    idNivelDesempeno tinyint NULL,/*fk*/
    idPeriodoEvaluacion tinyint NULL,/*fk*/
    idCicloEscolar int NOT NULL,
    nivelDesempenoPonderado tinyint NULL,
    observacion varchar(300) NULL,
    fecha date NOT NULL,
    hora time NOT NULL,
    estatus varchar(1) NOT NULL DEFAULT 'a',

    FOREIGN KEY (idPlanTrabajo) REFERENCES planTrabajo (idPlanTrabajo),
    FOREIGN KEY (idNivelDesempeno) REFERENCES nivelDesempeno (idNivelDesempeno),
    FOREIGN KEY (idPeriodoEvaluacion) REFERENCES periodoEvaluacion (idPeriodoEvaluacion),
    FOREIGN KEY (idCicloEscolar) REFERENCES cicloEscolar (idCicloEscolar),
    CONSTRAINT (UQ_idPlanTrabajo) UNIQUE (idPlanTrabajo, fecha, hora),
    CONSTRAINT (UQ_idPlanTrabajo_2) UNIQUE (idPlanTrabajo, fecha),
    CONSTRAINT (UQ_hora_fecha) UNIQUE (fecha, hora),

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE actividadAlumno (
    idActividadProgramada int NOT NULL,/*fk*/
    idAlumno varchar(50) NOT NULL,/*fk*/
    idNivelDesempeno tinyint,/*fk*/
    observacion varchar(300) NULL,
    rutaEvidencia varchar(300) NOT NULL,

    PRIMARY KEY (idActividadProgramada, idAlumno),

    FOREIGN KEY (idActividadProgramada) REFERENCES actividadProgramada (idActividadProgramada),
    FOREIGN KEY (idAlumno) REFERENCES alumno (idAlumno),
    FOREIGN KEY (idNivelDesempeno) REFERENCES nivelDesempeno (idNivelDesempeno)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE evaluacion (
    idAlumno varchar(50) NOT NULL, /*fk*/
    idAreaFormacion tinyint NOT NULL,/*fk*/
    idPeriodoEvaluacion tinyint NOT NULL,/*fk*/
    idNivelDesempeno tinyint NOT NULL,/*fk*/
    idCicloEscolar int NOT NULL,
    observacion varchar(500) NOT NULL,
    estatus varchar(1) NOT NULL,

    PRIMARY KEY (idAlumno, idAreaFormacion, idPeriodoEvaluacion),

    FOREIGN KEY (idAlumno) REFERENCES alumno (idAlumno),
    FOREIGN KEY (idAreaFormacion) REFERENCES areaFormacion (idAreaFormacion),
    FOREIGN KEY (idPeriodoEvaluacion) REFERENCES periodoEvaluacion (idPeriodoEvaluacion),
    FOREIGN KEY (idNivelDesempeno) REFERENCES nivelDesempeno (idNivelDesempeno),
    FOREIGN KEY (idCicloEscolar) REFERENCES cicloEscolar (idCicloEscolar)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE cuadroHonor (
    idCuadroHonor int NOT NULL AUTO_INCREMENT,
    idAlumno varchar(50) NOT NULL,
    idActividadProgramada int NOT NULL,
    PRIMARY KEY (idCuadroHonor, idAlumno, idActividadProgramada),

    FOREIGN KEY (idAlumno) REFERENCES alumno (idAlumno),
    FOREIGN KEY (idActividadProgramada) REFERENCES actividadProgramada (idActividadProgramada)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;