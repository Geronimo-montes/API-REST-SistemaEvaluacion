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
    email varchar(80) NOT NULL,
    facebook varchar(50) NOT NULL,
    grupo varchar(1) NOT NULL,
    grado varchar(1) NOT NULL,
    turno varchar(1) NOT NULL,
    rol varchar(50) NOT NULL,
    estatus varchar(1) NOT NULL,

    FOREIGN KEY (idEscuela) REFERENCES escuela (idEscuela)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;

INSERT INTO docente VALUES (1, 1, "Alba Lorena", "Montes", "Barreras", "MOBA900902MSLNRL05", "MOBA9009021S1", "Ahome, Sinaloa", "6686543210", "email@email.com", "Lerona Montes", "A", "3", "v", "maestra", "a");

CREATE TABLE alumno (
    idAlumno int PRIMARY KEY,
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

    FOREIGN KEY (idEscuela) REFERENCES escuela (idEscuela)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;  

INSERT INTO alumno VALUES (1, 1, "SEBASTIAN ALEXANDER",    "ALAMEA", "INDA",       "AAIS150220HSLLNBA1", "A", "3", "v", "Mama de Alexander",   "Ahome, Cohuibampo", "6689874563", "email_1@email.com", "Mama de Alexander",    "Whatsapp", "a");
INSERT INTO alumno VALUES (2, 1, "JOSE MANUEL",            "CASTRO", "VALENZUELA", "CAVM150807HSLSLNA9", "A", "3", "v", "Mama de Manule",      "Ahome, Cohuibampo", "6688979854", "email_2@email.com", "Mama de Manule",       "Whatsapp", "a");
INSERT INTO alumno VALUES (3, 1, "AZIS DONALDO",           "CHAVEZ", "DIAZ",       "CADA150208HSLHZZA1", "A", "3", "v", "Mama de Donaldo",     "Ahome, Cohuibampo", "6687961616", "email_3@email.com", "Mama de Donaldo",      "Whatsapp", "a");
INSERT INTO alumno VALUES (4, 1, "YEIMI ANGELIQUE",        "COTA",   "VALENZUELA", "COVY150124MSLTLMA1", "A", "3", "v", "Mama de ANGELIQUE",   "Ahome, Cohuibampo", "6688799798", "email_4@email.com", "Mama de ANGELIQUE",    "Whatsapp", "a");

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

CREATE TABLE aprendizajeEsperado (
    idAprendizajeEsperado tinyint PRIMARY KEY AUTO_INCREMENT,
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

CREATE TABLE planTrabajo (
    idPlanTrabajo int PRIMARY KEY AUTO_INCREMENT,
    idAprendizajeEsperado tinyint NOT NULL, /*fk*/
    idAreaFormacion tinyint NOT NULL,/*fk*/
    idDocente int NOT NULL,/*fk*/
    idDiagnostico tinyint, /*fk*/
    nombre varchar(50) NOT NULL,
    duracionMinutos tinyint NOT NULL,
    tipoActividad varchar(1) NOT NULL,
    inicio varchar(2000) NOT NULL,
    desarrollo varchar(2000) NOT NULL,
    cierre varchar(2000) NOT NULL,
    recursos varchar(2000) NOT NULL,
    evaluacion varchar(2000) NOT NULL,
    fechaModificacion date NOT NULL,
    estatus varchar(1) NOT NULL DEFAULT 'a',

    FOREIGN KEY (idAprendizajeEsperado) REFERENCES aprendizajeEsperado (idAprendizajeEsperado),
    FOREIGN KEY (idAreaFormacion) REFERENCES areaFormacion (idAreaFormacion),
    FOREIGN KEY (idDocente) REFERENCES docente (idDocente),
    FOREIGN KEY (idDiagnostico) REFERENCES diagnostico (idDiagnostico)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE evidencias (
    idEvidencia int NOT NULL AUTO_INCREMENT,
    idPlanTrabajo int NOT NULL,
    nombreEvidencia varchar(100) NOT NULL,
    descripcion varchar(200) NOT NULL,
    formatoEsperado varchar(8) NOT NULL,
    evidenciaOpcional varchar(1) NOT NULL,
    PRIMARY KEY (idEvidencia, idPlanTrabajo),

    FOREIGN KEY (idPlanTrabajo) REFERENCES planTrabajo (idPlanTrabajo)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE cicloEscolar (
  idCicloEscolar int PRIMARY KEY AUTO_INCREMENT,
  inicioCiclo date,
  finCiclo date,
  diasHabiles smallint,
  estatus varchar(1)
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;

INSERT INTO cicloEscolar (inicioCiclo, finCiclo, diasHabiles, estatus) VALUES ("24-08-20", "09-07-21", 191, "a");


CREATE TABLE actividadProgramada (
    idActividadProgramada int PRIMARY KEY AUTO_INCREMENT,
    idPlanTrabajo int NOT NULL, /*FK*/
    idNivelDesempeno tinyint NOT NULL,/*fk*/
    idPeriodoEvaluacion tinyint NOT NULL,/*fk*/
    idCicloEscolar int NOT NULL,
    nivelDesempenoPonderado tinyint NOT NULL,
    observacion varchar(300) NOT NULL,
    fecha date NOT NULL,
    estatus varchar(1) NOT NULL DEFAULT 'a',

    FOREIGN KEY (idPlanTrabajo) REFERENCES planTrabajo (idPlanTrabajo),
    FOREIGN KEY (idNivelDesempeno) REFERENCES nivelDesempeno (idNivelDesempeno),
    FOREIGN KEY (idPeriodoEvaluacion) REFERENCES periodoEvaluacion (idPeriodoEvaluacion),
    FOREIGN KEY (idCicloEscolar) REFERENCES cicloEscolar (idCicloEscolar)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE actividadAlumno (
    idActividadProgramada int NOT NULL,/*fk*/
    idAlumno int NOT NULL,/*fk*/
    idNivelDesempeno tinyint,/*fk*/
    observacion varchar(300) NOT NULL,
    rutaEvidencia varchar(300) NOT NULL,

    PRIMARY KEY (idActividadProgramada, idAlumno),

    FOREIGN KEY (idActividadProgramada) REFERENCES actividadProgramada (idActividadProgramada),
    FOREIGN KEY (idAlumno) REFERENCES alumno (idAlumno),
    FOREIGN KEY (idNivelDesempeno) REFERENCES nivelDesempeno (idNivelDesempeno)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE evaluacion (
    idAlumno int NOT NULL, /*fk*/
    idAreaFormacion tinyint NOT NULL,/*fk*/
    idPeriodoEvaluacion tinyint NOT NULL,/*fk*/
    idNivelDesempeno tinyint NOT NULL,/*fk*/
    idCicloEscolar int NOT NULL,
    observacion varchar(500) NOT NULL,
    estatus varchar(1) NOT NULL,

    PRIMARY KEY (idEvaluacion, idAlumno, idAreaFormacion, idPeriodoEvaluacion),

    FOREIGN KEY (idAlumno) REFERENCES alumno (idAlumno),
    FOREIGN KEY (idAreaFormacion) REFERENCES areaFormacion (idAreaFormacion),
    FOREIGN KEY (idPeriodoEvaluacion) REFERENCES periodoEvaluacion (idPeriodoEvaluacion),
    FOREIGN KEY (idNivelDesempeno) REFERENCES nivelDesempeno (idNivelDesempeno),
    FOREIGN KEY (idCicloEscolar) REFERENCES cicloEscolar (idCicloEscolar)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci; 

CREATE TABLE cuadroHonor (
    idCuadroHonor int NOT NULL AUTO_INCREMENT,
    idAlumno int NOT NULL,
    idActividadProgramada int NOT NULL,
    PRIMARY KEY (idCuadroHonor, idAlumno, idActividadProgramada),

    FOREIGN KEY (idAlumno) REFERENCES alumno (idAlumno),
    FOREIGN KEY (idActividadProgramada) REFERENCES actividadProgramada (idActividadProgramada)

) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish2_ci;