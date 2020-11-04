<?php 
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require '../vendor/autoload.php';
    /*******************************/
    /******** Configuraciones ******/
    /*******************************/
    $config['displayErrorDetails'] = true;//Muestra mensajes de eror mediante la consola; fase desarollo
    $config['addContentLengthHeader'] = false;

    $config['db']['host']   = 'localhost';
    $config['db']['user']   = 'root';
    $config['db']['pass']   = '';
    $config['db']['dbname'] = 'sistemaevaluacion';

    $app = new \Slim\App(['settings' => $config]);
    /*******************************/
    /**** Agregar dependencias  ****/
    /*******************************/
    $container = $app->getContainer(); //obtenemos el contenedor

    $container['view'] = new \Slim\Views\PhpRenderer('../templates/');

    $container['logger'] = function($c) {
        $logger = new \Monolog\Logger('my_logger');
        $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
        $logger->pushHandler($file_handler);
        
        return $logger;
    };

    /*******************************/
    /**** Agregar conexion a BD ****/
    /*******************************/
    $container['db'] = function ($c) {
        $db = $c['settings']['db'];
        $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
    
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $pdo;
    };

    /*******************************/
    /**** Metodos de la API rest ***/
    /*******************************/

    /**Rutas Docentes */
        $app->get('/docentes', function (Request $request, Response $response) {
        /** Listado de los dotos de los docentes dados de alta con estatus activo */
            try{
                $mapper = new DocenteMapper($this->db);
                $docentes = $mapper->getDocentes();
                
                $listaDocentes = [];
                foreach ($docentes as $docente){
                    array_push($listaDocentes, array(
                        "idDocente"     => $docente->getidDocente(),
                        "nombreEscuela" => $docente->getnombreEscuela(),
                        "nombre"        => $docente->getnombre(),
                        "ap1"           => $docente->getap1(),
                        "ap2"           => $docente->getap2(),
                        "curp"          => $docente->getcurp(),
                        "rfc"           => $docente->getrfc(),
                        "direccion"     => $docente->getdireccion(),
                        "telefono"      => $docente->gettelefono(),
                        "email"         => $docente->getemail(),
                        "facebook"      => $docente->getfacebook(),
                        "grupo"         => $docente->getgrupo(),
                        "grado"         => $docente->getgrado(),
                        "turno"         => $docente->getturno(),
                        "rol"           => $docente->getrol(),
                        "estatus"       => $docente->getestatus()
                    ));
                }

                return $response->withJson($listaDocentes,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
        
        $app->get('/docente/{id}', function (Request $request, Response $response, $args) {
        /**Lista los datos de un maestro en especifico, atravez de su id */
            try{
                $idDocente = (int)$args['id'];
                $mapper = new DocenteMapper($this->db);
                $docente = $mapper->getDocenteById($idDocente);
                
                $listaDocente = [];
                
                if(!empty($docente)){
                    array_push($listaDocente, array(
                        "idDocente"     => $docente->getidDocente(),
                        "nombreEscuela" => $docente->getnombreEscuela(),
                        "nombre"        => $docente->getnombre(),
                        "ap1"           => $docente->getap1(),
                        "ap2"           => $docente->getap2(),
                        "curp"          => $docente->getcurp(),
                        "rfc"           => $docente->getrfc(),
                        "direccion"     => $docente->getdireccion(),
                        "telefono"      => $docente->gettelefono(),
                        "email"         => $docente->getemail(),
                        "facebook"      => $docente->getfacebook(),
                        "grupo"         => $docente->getgrupo(),
                        "grado"         => $docente->getgrado(),
                        "turno"         => $docente->getturno(),
                        "rol"           => $docente->getrol(),
                        "estatus"       => $docente->getestatus()
                    ));
                }
                
                return $response->withJson($listaDocente,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/docenteUpdate', function (Request $request, Response $response, $args) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataDocente = [];

                $dataDocente['idDocente'] 		= filter_var($data['idDocente_docente'], 		FILTER_SANITIZE_NUMBER_INT);
                $dataDocente['nombreEscuela'] 	= filter_var($data['nombreEscuela_docente'], 	FILTER_SANITIZE_STRING);
                $dataDocente['nombre'] 			= filter_var($data['nombre_docente'], 			FILTER_SANITIZE_STRING);
                $dataDocente['ap1'] 			= filter_var($data['ap1_docente'], 				FILTER_SANITIZE_STRING);
                $dataDocente['ap2'] 			= filter_var($data['ap2_docente'], 				FILTER_SANITIZE_STRING);
                $dataDocente['curp'] 			= filter_var($data['curp_docente'], 			FILTER_SANITIZE_STRING);
                $dataDocente['rfc'] 			= filter_var($data['rfc_docente'], 				FILTER_SANITIZE_STRING);
                $dataDocente['direccion'] 		= filter_var($data['direccion_docente'],		FILTER_SANITIZE_STRING);
                $dataDocente['telefono'] 		= filter_var($data['telefono_docente'], 		FILTER_SANITIZE_STRING);
                $dataDocente['email'] 			= filter_var($data['email_docente'], 			FILTER_SANITIZE_EMAIL);
                $dataDocente['facebook'] 		= filter_var($data['facebook_docente'], 		FILTER_SANITIZE_STRING);
                $dataDocente['grupo'] 			= filter_var($data['grupo_docente'], 			FILTER_SANITIZE_STRING);
                $dataDocente['grado'] 			= filter_var($data['grado_docente'], 			FILTER_SANITIZE_STRING);
                $dataDocente['turno'] 			= filter_var($data['turno_docente'], 			FILTER_SANITIZE_STRING);
                $dataDocente['rol'] 			= filter_var($data['rol_docente'], 				FILTER_SANITIZE_STRING);
                $dataDocente['estatus'] 		= filter_var($data['estatus_docente'], 			FILTER_SANITIZE_STRING);

                $docente = new DocenteEntity($dataDocente);
                $mapper = new DocenteMapper($this->db);
                $docenteUpdadte = $mapper->updateDocenteById($docente);
                
                $listaDocente = [];
                
                if(!empty($docenteUpdadte)){
                    array_push($listaDocente, array(
                        "idDocente"     => $docenteUpdadte->getidDocente(),
                        "nombreEscuela" => $docenteUpdadte->getnombreEscuela(),
                        "nombre"        => $docenteUpdadte->getnombre(),
                        "ap1"           => $docenteUpdadte->getap1(),
                        "ap2"           => $docenteUpdadte->getap2(),
                        "curp"          => $docenteUpdadte->getcurp(),
                        "rfc"           => $docenteUpdadte->getrfc(),
                        "direccion"     => $docenteUpdadte->getdireccion(),
                        "telefono"      => $docenteUpdadte->gettelefono(),
                        "email"         => $docenteUpdadte->getemail(),
                        "facebook"      => $docenteUpdadte->getfacebook(),
                        "grupo"         => $docenteUpdadte->getgrupo(),
                        "grado"         => $docenteUpdadte->getgrado(),
                        "turno"         => $docenteUpdadte->getturno(),
                        "rol"           => $docenteUpdadte->getrol(),
                        "estatus"       => $docenteUpdadte->getestatus()
                    ));
                }
                
                return $response->withJson($listaDocente,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /**************** */


    /**Rutas Alumnos */
        $app->post('/alumnos', function (Request $request, Response $response, $args) {
        /** */
            try{
                $data = $request->getParsedBody();

                $grupo = filter_var($data['grupo_alumno'], FILTER_SANITIZE_STRING);
                $grado = filter_var($data['grado_alumno'], FILTER_SANITIZE_STRING);
                $turno = filter_var($data['turno_alumno'], FILTER_SANITIZE_STRING);

                $mapper = new AlumnoMapper($this->db);
                $alumnos = $mapper->getAlumnos($grupo, $grado, $turno);
                
                $lstaAlumnos = [];
                foreach ($alumnos as $alumno){
                    array_push($lstaAlumnos, array(
                        "idAlumno"              => $alumno->getidAlumno(),
                        "nombreEscuela"         => $alumno->getnombreEscuela(),
                        "nombre"                => $alumno->getnombre(),
                        "ap1"                   => $alumno->getap1(),
                        "ap2"                   => $alumno->getap2(),
                        "curp"                  => $alumno->getcurp(),
                        "grupo"                 => $alumno->getgrupo(),
                        "grado"                 => $alumno->getgrado(),
                        "turno"                 => $alumno->getturno(),
                        "nombreTutor"           => $alumno->getnombreTutor(),
                        "direccion"             => $alumno->getdireccion(),
                        "telefono"              => $alumno->gettelefono(),
                        "email"                 => $alumno->getemail(),
                        "facebook"              => $alumno->getfacebook(),
                        "preferennciaContacto"  => $alumno->getpreferennciaContacto(),
                        "estatus"               => $alumno->getestatus()
                    ));
                }

                return $response->withJson($lstaAlumnos,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/alumno/{id}', function (Request $request, Response $response, $args) {
        /** */
            try{
                $idAlumno = (int)$args['id'];
                $mapper = new AlumnoMapper($this->db);
                $alumno = $mapper->getAlumnoById($idAlumno);
                
                $lstaAlumnos = [];

                if(!empty($alumno)){
                    array_push($lstaAlumnos, array(
                        "idAlumno"              => $alumno->getidAlumno(),
                        "nombreEscuela"         => $alumno->getnombreEscuela(),
                        "nombre"                => $alumno->getnombre(),
                        "ap1"                   => $alumno->getap1(),
                        "ap2"                   => $alumno->getap2(),
                        "curp"                  => $alumno->getcurp(),
                        "grupo"                 => $alumno->getgrupo(),
                        "grado"                 => $alumno->getgrado(),
                        "turno"                 => $alumno->getturno(),
                        "nombreTutor"           => $alumno->getnombreTutor(),
                        "direccion"             => $alumno->getdireccion(),
                        "telefono"              => $alumno->gettelefono(),
                        "email"                 => $alumno->getemail(),
                        "facebook"              => $alumno->getfacebook(),
                        "preferennciaContacto"  => $alumno->getpreferennciaContacto(),
                        "estatus"               => $alumno->getestatus()
                    ));
                }

                return $response->withJson($lstaAlumnos,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/alumnoUpdate', function (Request $request, Response $response) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataAlumno = [];

                $dataAlumno['idAlumno'] 		    = filter_var($data['idAlumno_alumno'],              FILTER_SANITIZE_NUMBER_INT);
                $dataAlumno['nombreEscuela'] 	    = filter_var($data['nombreEscuela_alumno'],         FILTER_SANITIZE_STRING);
                $dataAlumno['nombre'] 			    = filter_var($data['nombre_alumno'],                FILTER_SANITIZE_STRING);
                $dataAlumno['ap1'] 			        = filter_var($data['ap1_alumno'],                   FILTER_SANITIZE_STRING);
                $dataAlumno['ap2'] 			        = filter_var($data['ap2_alumno'],                   FILTER_SANITIZE_STRING);
                $dataAlumno['curp'] 			    = filter_var($data['curp_alumno'],                  FILTER_SANITIZE_STRING);
                $dataAlumno['grupo'] 			    = filter_var($data['grupo_alumno'],                 FILTER_SANITIZE_STRING);
                $dataAlumno['grado'] 		        = filter_var($data['grado_alumno'],                 FILTER_SANITIZE_STRING);
                $dataAlumno['turno'] 		        = filter_var($data['turno_alumno'],                 FILTER_SANITIZE_STRING);
                $dataAlumno['nombreTutor']          = filter_var($data['nombreTutor_alumno'],           FILTER_SANITIZE_STRING);
                $dataAlumno['direccion'] 		    = filter_var($data['direccion_alumno'],             FILTER_SANITIZE_STRING);
                $dataAlumno['telefono'] 		    = filter_var($data['telefono_alumno'],              FILTER_SANITIZE_STRING);
                $dataAlumno['email'] 			    = filter_var($data['email_alumno'],                 FILTER_SANITIZE_EMAIL);
                $dataAlumno['facebook'] 		    = filter_var($data['facebook_alumno'],              FILTER_SANITIZE_STRING);
                $dataAlumno['preferennciaContacto'] = Filter_var($data['preferennciaContacto_alumno'],  FILTER_SANITIZE_STRING);
                $dataAlumno['estatus'] 		        = filter_var($data['estatus_alumno'],               FILTER_SANITIZE_STRING);

                $alumno = new AlumnoEntity($dataAlumno);
                $mapper = new AlumnoMapper($this->db);
                $alumnoUpdadte = $mapper->UpdateAlumnoById($alumno);
                
                $listaAlumno = [];
                
                if(!empty($alumnoUpdadte)){
                    array_push($listaAlumno, array(
                        "idAlumno"              => $alumnoUpdadte->getidAlumno(),
                        "nombreEscuela"         => $alumnoUpdadte->getnombreEscuela(),
                        "nombre"                => $alumnoUpdadte->getnombre(),
                        "ap1"                   => $alumnoUpdadte->getap1(),
                        "ap2"                   => $alumnoUpdadte->getap2(),
                        "curp"                  => $alumnoUpdadte->getcurp(),
                        "grupo"                 => $alumnoUpdadte->getgrupo(),
                        "grado"                 => $alumnoUpdadte->getgrado(),
                        "turno"                 => $alumnoUpdadte->getturno(),
                        "nombreTutor"           => $alumnoUpdadte->getnombreTutor(),
                        "direccion"             => $alumnoUpdadte->getdireccion(),
                        "telefono"              => $alumnoUpdadte->gettelefono(),
                        "email"                 => $alumnoUpdadte->getemail(),
                        "facebook"              => $alumnoUpdadte->getfacebook(),
                        "preferennciaContacto"  => $alumnoUpdadte->getpreferennciaContacto(),
                        "estatus"               => $alumnoUpdadte->getestatus()
                    ));
                }
                
                return $response->withJson($listaAlumno,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/alumnoInsert', function (Request $request, Response $response) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataAlumno = [];

                $dataAlumno['idAlumno'] 		    = filter_var($data['idAlumno_alumno'],              FILTER_SANITIZE_NUMBER_INT);
                $dataAlumno['nombreEscuela'] 	    = filter_var($data['nombreEscuela_alumno'],         FILTER_SANITIZE_STRING);
                $dataAlumno['nombre'] 			    = filter_var($data['nombre_alumno'],                FILTER_SANITIZE_STRING);
                $dataAlumno['ap1'] 			        = filter_var($data['ap1_alumno'],                   FILTER_SANITIZE_STRING);
                $dataAlumno['ap2'] 			        = filter_var($data['ap2_alumno'],                   FILTER_SANITIZE_STRING);
                $dataAlumno['curp'] 			    = filter_var($data['curp_alumno'],                  FILTER_SANITIZE_STRING);
                $dataAlumno['grupo'] 			    = filter_var($data['grupo_alumno'],                 FILTER_SANITIZE_STRING);
                $dataAlumno['grado'] 		        = filter_var($data['grado_alumno'],                 FILTER_SANITIZE_STRING);
                $dataAlumno['turno'] 		        = filter_var($data['turno_alumno'],                 FILTER_SANITIZE_STRING);
                $dataAlumno['nombreTutor']          = filter_var($data['nombreTutor_alumno'],           FILTER_SANITIZE_STRING);
                $dataAlumno['direccion'] 		    = filter_var($data['direccion_alumno'],             FILTER_SANITIZE_STRING);
                $dataAlumno['telefono'] 		    = filter_var($data['telefono_alumno'],              FILTER_SANITIZE_STRING);
                $dataAlumno['email'] 			    = filter_var($data['email_alumno'],                 FILTER_SANITIZE_EMAIL);
                $dataAlumno['facebook'] 		    = filter_var($data['facebook_alumno'],              FILTER_SANITIZE_STRING);
                $dataAlumno['preferennciaContacto'] = Filter_var($data['preferennciaContacto_alumno'],  FILTER_SANITIZE_STRING);
                $dataAlumno['estatus'] 		        = filter_var($data['estatus_alumno'],               FILTER_SANITIZE_STRING);

                $alumno = new AlumnoEntity($dataAlumno);
                $mapper = new AlumnoMapper($this->db);
                $alumnoInsert = $mapper->InsertAlumno($alumno);
                
                return $response->withJson($alumnoInsert,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /**************** */


    /**Rutas Actividades */
        $app->post('/actividadInsert', function (Request $request, Response $response) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataActividad = [];

                $dataActividad['idAprendizajeEsperado'] =  filter_var($data['idAprendizajeEsperado_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idAreaFormacion'] =        filter_var($data['idAreaFormacion_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idDocente'] =              filter_var($data['idDocente_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idDiagnostico'] =          filter_var($data['idDiagnostico_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['nombre'] =                 filter_var($data['nombre_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['duracionMinutos'] =        filter_var($data['duracionMinutos_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['tipoActividad'] =          filter_var($data['tipoActividad_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['inicio'] =                 filter_var($data['inicio_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['desarrollo'] =             filter_var($data['desarrollo_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['cierre'] =                 filter_var($data['cierre_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['recursos'] =               filter_var($data['recursos_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['evaluacion'] =             filter_var($data['evaluacion_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['fechaModificacion'] =      filter_var($data['fechaModificacion_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['estatus'] =                filter_var($data['estatus_actividad'], FILTER_SANITIZE_STRING);

                $actividad = new ActividadEntity($dataActividad);
                $mapper = new ActividadMapper($this->db);
                $insertActividad = $mapper->InsertActividad($actividad);
                            
                return $response->withJson($insertActividad,200);
            }catch (Exception $e){
                return $response->withJson($e,200);
            }
        });

        $app->get('/actividades', function (Request $request, Response $response) {
        /** sdListado de los dotos de los alumnos dados de alta con estatus activo */
            try{
                $mapper = new ActividadMapper($this->db);
                $actividades = $mapper->getActividades();
        
                $listaActividades = [];
                foreach ($actividades as $actividad) {
                    array_push($listaActividades, array(
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idAprendizajeEsperado" => $actividad->getidAprendizajeEsperado(),
                        "idAreaFormacion"   => $actividad->getidAreaFormacion(),
                        "idDocente" => $actividad->getidDocente(),
                        "idDiagnostico" => $actividad->getidDiagnostico(),
                        "nombre"    => $actividad->getnombre(),
                        "duracionMinutos"   => $actividad->getduracionMinutos(),
                        "tipoActividad" => $actividad->gettipoActividad(),
                        "inicio"    => $actividad->getinicio(),
                        "desarrollo"    => $actividad->getdesarrollo(),
                        "cierre"    => $actividad->getcierre(),
                        "recursos"  => $actividad->getrecursos(),
                        "evaluacion"    => $actividad->getevaluacion(),
                        "fechaModificacion" => $actividad->getfechaModificacion(),
                        "estatus"   => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividades, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividad/{id}', function (Request $request, Response $response, $args) {
        /** sdListado de los dotos de los alumnos dados de alta con estatus activo */
            try{
                $idPlanTrabajo = (int)$args['id'];
                $mapper = new ActividadMapper($this->db);
                $actividad = $mapper->getActividadById($idPlanTrabajo);
        
                $listaActividad = [];
                if(!empty($actividad)){
                    array_push($listaActividad, array(
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idAprendizajeEsperado" => $actividad->getidAprendizajeEsperado(),
                        "idAreaFormacion"   => $actividad->getidAreaFormacion(),
                        "idDocente" => $actividad->getidDocente(),
                        "idDiagnostico" => $actividad->getidDiagnostico(),
                        "nombre"    => $actividad->getnombre(),
                        "duracionMinutos"   => $actividad->getduracionMinutos(),
                        "tipoActividad" => $actividad->gettipoActividad(),
                        "inicio"    => $actividad->getinicio(),
                        "desarrollo"    => $actividad->getdesarrollo(),
                        "cierre"    => $actividad->getcierre(),
                        "recursos"  => $actividad->getrecursos(),
                        "evaluacion"    => $actividad->getevaluacion(),
                        "fechaModificacion" => $actividad->getfechaModificacion(),
                        "estatus"   => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/actividadUpdate', function (Request $request, Response $response) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataActividad = [];

                $dataActividad['idPlanTrabajo'] =  filter_var($data['idPlanTrabajo_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idAprendizajeEsperado'] =  filter_var($data['idAprendizajeEsperado_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idAreaFormacion'] =        filter_var($data['idAreaFormacion_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idDocente'] =              filter_var($data['idDocente_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idDiagnostico'] =          filter_var($data['idDiagnostico_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['nombre'] =                 filter_var($data['nombre_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['duracionMinutos'] =        filter_var($data['duracionMinutos_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['tipoActividad'] =          filter_var($data['tipoActividad_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['inicio'] =                 filter_var($data['inicio_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['desarrollo'] =             filter_var($data['desarrollo_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['cierre'] =                 filter_var($data['cierre_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['recursos'] =               filter_var($data['recursos_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['evaluacion'] =             filter_var($data['evaluacion_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['fechaModificacion'] =      filter_var($data['fechaModificacion_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['estatus'] =                filter_var($data['estatus_actividad'], FILTER_SANITIZE_STRING);

                $actividadEntidad = new ActividadEntity($dataActividad);
                $mapper = new ActividadMapper($this->db);
                $actividad = $mapper->UpdateActividadById($actividadEntidad);
                            
                $listaActividad = [];
                if(!empty($actividad)){
                    array_push($listaActividad, array(
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idAprendizajeEsperado" => $actividad->getidAprendizajeEsperado(),
                        "idAreaFormacion"   => $actividad->getidAreaFormacion(),
                        "idDocente" => $actividad->getidDocente(),
                        "idDiagnostico" => $actividad->getidDiagnostico(),
                        "nombre"    => $actividad->getnombre(),
                        "duracionMinutos"   => $actividad->getduracionMinutos(),
                        "tipoActividad" => $actividad->gettipoActividad(),
                        "inicio"    => $actividad->getinicio(),
                        "desarrollo"    => $actividad->getdesarrollo(),
                        "cierre"    => $actividad->getcierre(),
                        "recursos"  => $actividad->getrecursos(),
                        "evaluacion"    => $actividad->getevaluacion(),
                        "fechaModificacion" => $actividad->getfechaModificacion(),
                        "estatus"   => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividad, 200);
            }catch (Exception $e){
                return $response->withJson($e,200);
            }
        });
    /**************** */


    /**Rutas ActividadesProgramadas */
        $app->post('/actividadAlumnoInsert', function (Request $request, Response $response) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataAlumno = [];

                $dataAlumno['idActividadProgramada'] = filter_var($data['idActividadProgramada_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataAlumno['idAlumno'] = filter_var($data['idAlumno_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['idNivelDesempeno'] = filter_var($data['idNivelDesempeno_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['observacion'] = filter_var($data['observacion_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['rutaEvidencia'] = filter_var($data['rutaEvidencia_actividad'], FILTER_SANITIZE_STRING);

                $alumno = new ActividadAlumnoEntity($dataAlumno);
                $mapper = new ActividadAlumnoMapper($this->db);
                $alumnoInsert = $mapper->insertActividadProgramada($alumno);
                
                return $response->withJson($alumnoInsert,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /**************** */


    /**Rutas ActividadesProgramadas */
        $app->post('/actividadProgramadaInsert', function (Request $request, Response $response) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataActividad = [];

                $dataActividad['idActividadProgramada'] =   filter_var($data['idActividadProgramada_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idPlanTrabajo'] =           filter_var($data['idPlanTrabajo_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idNivelDesempeno'] =        filter_var($data['idNivelDesempeno_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idPeriodoEvaluacion'] =     filter_var($data['idPeriodoEvaluacion_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['nivelDesempenoPonderado'] = filter_var($data['nivelDesempenoPonderado_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['observacion'] =             filter_var($data['observacion_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['fecha'] =                   filter_var($data['fecha_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['estatus'] =                 filter_var($data['estatus_actividad'], FILTER_SANITIZE_STRING);

                $actividad = new ActividadProgramadaEntity($dataActividad);
                $mapper = new ActividadProgramadaMapper($this->db);
                $insertActividad = $mapper->insertActividadProgramada($actividad);
                            
                return $response->withJson($insertActividad,200);
            }catch (Exception $e){
                return $response->withJson($e,200);
            }
        });

        $app->get('/actividadProgramada', function (Request $request, Response $response) {
        /** sdListado de los dotos de los alumnos dados de alta con estatus activo */
            try{
                $mapper = new ActividadProgramadaMapper($this->db);
                $actividades = $mapper->getActividadProgramada();
        
                $listaActividades = [];
                foreach ($actividades as $actividad) {
                    array_push($listaActividades, array(
                        "idActividadProgramada" => $actividad->getidActividadProgramada(),
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                        "idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
                        "nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
                        "observacion" => $actividad->getobservacion(),
                        "fecha" => $actividad->getfecha(),
                        "estatus" => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividades, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadProgramada/{id}', function (Request $request, Response $response, $args) {
        /** sdListado de los dotos de los alumnos dados de alta con estatus activo */
            try{
                $id = (int)$args['id'];
                $mapper = new ActividadProgramadaMapper($this->db);
                $actividad = $mapper->getActividadProgramadaById($id);
        
                $listaActividad = [];
                if(!empty($actividad)){
                    array_push($listaActividad, array(
                        "idActividadProgramada" => $actividad->getidActividadProgramada(),
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                        "idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
                        "nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
                        "observacion" => $actividad->getobservacion(),
                        "fecha" => $actividad->getfecha(),
                        "estatus" => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadProgramada/periodo/{periodo}', function (Request $request, Response $response, $args) {
        /** sdListado de los dotos de los alumnos dados de alta con estatus activo */
            try{
                $periodo = (int)$args['periodo'];
                $mapper = new ActividadProgramadaMapper($this->db);
                $actividad = $mapper->getActividadProgramadaByPeriodo($periodo);
        
                $listaActividad = [];
                if(!empty($actividad)){
                    array_push($listaActividad, array(
                        "idActividadProgramada" => $actividad->getidActividadProgramada(),
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                        "idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
                        "nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
                        "observacion" => $actividad->getobservacion(),
                        "fecha" => $actividad->getfecha(),
                        "estatus" => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    
        $app->get('/actividadProgramada/estatus/{estatus}', function (Request $request, Response $response, $args) {
        /** sdListado de los dotos de los alumnos dados de alta con estatus activo */
            try{
                $estatus = $args['estatus'];
                $mapper = new ActividadProgramadaMapper($this->db);
                $actividad = $mapper->getActividadProgramadaByEstatus($estatus);
        
                $listaActividad = [];
                if(!empty($actividad)){
                    array_push($listaActividad, array(
                        "idActividadProgramada" => $actividad->getidActividadProgramada(),
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                        "idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
                        "nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
                        "observacion" => $actividad->getobservacion(),
                        "fecha" => $actividad->getfecha(),
                        "estatus" => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadProgramada/periodoestatus/{periodo}/{estatus}', function (Request $request, Response $response, $args) {
        /** sdListado de los dotos de los alumnos dados de alta con estatus activo */
            try{
                $periodo = (int)$args['periodo'];
                $estatus = $args['estatus'];

                $mapper = new ActividadProgramadaMapper($this->db);
                $actividad = $mapper->getActividadProgramadaByPeriodoEstatus($periodo, $estatus);
        
                $listaActividad = [];
                if(!empty($actividad)){
                    array_push($listaActividad, array(
                        "idActividadProgramada" => $actividad->getidActividadProgramada(),
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                        "idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
                        "nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
                        "observacion" => $actividad->getobservacion(),
                        "fecha" => $actividad->getfecha(),
                        "estatus" => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/actividadProgramadaUpdate', function (Request $request, Response $response) {
        /**Update los datos de un maestro en especifico, atravez de su id */
        
            try{
                $data = $request->getParsedBody();
                $dataActividad = [];

                $dataActividad['idActividadProgramada'] =   filter_var($data['idActividadProgramada_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idPlanTrabajo'] =           filter_var($data['idPlanTrabajo_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idNivelDesempeno'] =        filter_var($data['idNivelDesempeno_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['idPeriodoEvaluacion'] =     filter_var($data['idPeriodoEvaluacion_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['nivelDesempenoPonderado'] = filter_var($data['nivelDesempenoPonderado_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataActividad['observacion'] =             filter_var($data['observacion_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['fecha'] =                   filter_var($data['fecha_actividad'], FILTER_SANITIZE_STRING);
                $dataActividad['estatus'] =                 filter_var($data['estatus_actividad'], FILTER_SANITIZE_STRING);

                $actividadEntidad = new ActividadProgramadaEntity($dataActividad);
                $mapper = new ActividadProgramadaMapper($this->db);
                $actividad = $mapper->updateActividadProgramada($actividadEntidad);
                            
                $listaActividad = [];
                if(!empty($actividad)){
                    array_push($listaActividad, array(
                        "idActividadProgramada" => $actividad->getidActividadProgramada(),
                        "idPlanTrabajo" => $actividad->getidPlanTrabajo(),
                        "idNivelDesempeno" => $actividad->getidNivelDesempeno(),
                        "idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
                        "nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
                        "observacion" => $actividad->getobservacion(),
                        "fecha" => $actividad->getfecha(),
                        "estatus" => $actividad->getestatus()
                    ));
                }

                return $response->withJson($listaActividad, 200);
            }catch (Exception $e){
                return $response->withJson($e,200);
            }
        });
    /**************** */


    /**Rutas para datos de solo consulta */
        $app->get('/periodoEvaluacion', function (Request $request, Response $response) {
        /** */
            try{
                $mapper = new PeriodoEvaluacionMapper($this->db);
                $periodosEvaluacion = $mapper->getPeriodosEvaluacion();
        
                $listaPeriodoEvaluacion = [];
                foreach ($periodosEvaluacion as $periodoEvaluacion) {
                    array_push($listaPeriodoEvaluacion, array(
                        "idPeriodoEvaluacion" => $periodoEvaluacion->getidPeriodoEvaluacion(),
                        "nombre" => $periodoEvaluacion->getnombre(),
                        "numeroEvaluacion" => $periodoEvaluacion->getnumeroEvaluacion(),
                        "mesInicio" => $periodoEvaluacion->getmesInicio(),
                        "mesFinal" => $periodoEvaluacion->getmesFinal(),
                        "estatus" => $periodoEvaluacion->getestatus()
                    ));
                }

                return $response->withJson($listaPeriodoEvaluacion, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/periodoEvaluacion/{id}', function (Request $request, Response $response, $args) {
        /** */
            try{
                $idPeriodoEvaluacion = (int)$args['id'];
                $mapper = new PeriodoEvaluacionMapper($this->db);
                $periodoEvaluacion = $mapper->getPeriodoEvaluacionById($idPeriodoEvaluacion);
        
                $listaPeriodoEvaluacion = [];
                if(!empty($periodoEvaluacion)) {
                    array_push($listaPeriodoEvaluacion, array(
                        "idPeriodoEvaluacion" => $periodoEvaluacion->getidPeriodoEvaluacion(),
                        "nombre" => $periodoEvaluacion->getnombre(),
                        "numeroEvaluacion" => $periodoEvaluacion->getnumeroEvaluacion(),
                        "mesInicio" => $periodoEvaluacion->getmesInicio(),
                        "mesFinal" => $periodoEvaluacion->getmesFinal(),
                        "estatus" => $periodoEvaluacion->getestatus()
                    ));
                }

                return $response->withJson($listaPeriodoEvaluacion, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    
        $app->get('/nivelDesempeno', function (Request $request, Response $response) {
        /** */
            try{
                $mapper = new NivelDesempenoMapper($this->db);
                $nivelDesempeno = $mapper->getNivelDesempeno();
        
                $listaNivelDesempeno = [];
                foreach ($nivelDesempeno as $valor) {
                    array_push($listaNivelDesempeno, array(
                        "idNivelDesempeno" => $valor->getidNivelDesempeno(),
                        "nombre" => $valor->getnombre(),
                        "abreviacion" => $valor->getabreviacion(),
                        "valorNumerico" => $valor->getvalorNumerico()
                    ));
                }

                return $response->withJson($listaNivelDesempeno, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/nivelDesempeno/{id}', function (Request $request, Response $response, $args) {
        /** */
            try{
                $idnivelDesempeno = (int)$args['id'];
                $mapper = new NivelDesempenoMapper($this->db);
                $nivelDesempeno = $mapper->getNivelDesempenoById($idnivelDesempeno);
        
                $listaNivelDesempeno = [];
                if (!empty($nivelDesempeno)){
                    array_push($listaNivelDesempeno, array(
                        "idNivelDesempeno" => $nivelDesempeno->getidNivelDesempeno(),
                        "nombre" => $nivelDesempeno->getnombre(),
                        "abreviacion" => $nivelDesempeno->getabreviacion(),
                        "valorNumerico" => $nivelDesempeno->getvalorNumerico()
                    ));
                }

                return $response->withJson($listaNivelDesempeno, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });   
        
        $app->get('/areaFormacion', function (Request $request, Response $response) {
        /** */
            try{
                $mapper = new AreaFormacionMapper($this->db);
                $areaFormacion = $mapper->getAreaFormacion();
        
                $listaAreaFormacion = [];
                foreach ($areaFormacion as $valor) {
                    array_push($listaAreaFormacion, array(
                        "idAreaFormacion" => $valor->getidAreaFormacion(),
                        "descripcion" => $valor->getdescripcion(),
                        "estatus" => $valor->getestatus()
                    ));
                }

                return $response->withJson($listaAreaFormacion, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/areaFormacion/{id}', function (Request $request, Response $response, $args) {
        /** */
            try{
                $idareaFormacion = (int)$args['id'];
                $mapper = new AreaFormacionMapper($this->db);
                $areaFormacion = $mapper->getAreaFormacionById($idareaFormacion);
        
                $listaAreaFormacion = [];
                if(!empty($areaFormacion)) {
                    array_push($listaAreaFormacion, array(
                        "idAreaFormacion" => $areaFormacion->getidAreaFormacion(),
                        "descripcion" => $areaFormacion->getdescripcion(),
                        "estatus" => $areaFormacion->getestatus()
                    ));
                }

                return $response->withJson($listaAreaFormacion, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });  

        $app->get('/aprendizajeEsperado', function (Request $request, Response $response) {
        /** */
            try{
                $mapper = new AprendizajeEsperadoMapper($this->db);
                $aprendizajeEsperado = $mapper->getAprendizajeEsperado();
        
                $listaAprendizajeEsperado = [];
                foreach ($aprendizajeEsperado as $valor) {
                    array_push($listaAprendizajeEsperado, array(
                        "idAprendizajeEsperado" => $valor->getidAprendizajeEsperado(),
                        "idAreaFormacion" => $valor->getidAreaFormacion(),
                        "descripcion" => $valor->getdescripcion(),
                        "estatus" => $valor->getestatus()
                    ));
                }

                return $response->withJson($listaAprendizajeEsperado, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/aprendizajeEsperado/{id}', function (Request $request, Response $response, $args) {
        /**  */
            try{
                $idaprendizajeEsperado = (int)$args['id'];
                $mapper = new AprendizajeEsperadoMapper($this->db);
                $aprendizajeEsperado = $mapper->getAprendizajeEsperadoById($idaprendizajeEsperado);
        
                $listaAprendizajeEsperado = [];
                if (!empty($aprendizajeEsperado)) {
                    array_push($listaAprendizajeEsperado, array(
                        "idAprendizajeEsperado" => $aprendizajeEsperado->getidAprendizajeEsperado(),
                        "idAreaFormacion" => $aprendizajeEsperado->getidAreaFormacion(),
                        "descripcion" => $aprendizajeEsperado->getdescripcion(),
                        "estatus" => $aprendizajeEsperado->getestatus()
                    ));
                }

                return $response->withJson($listaAprendizajeEsperado, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });  

        $app->get('/diagnostico', function (Request $request, Response $response) {
        /**  */
            try{
                $mapper = new DiagnosticoMapper($this->db);
                $Diagnostico = $mapper->getDiagnostico();
        
                $listaDiagnostico = [];
                foreach ($Diagnostico as $valor) {
                    array_push($listaDiagnostico, array(
                        "idDiagnostico" => $valor->getidDiagnostico(),
                        "idAreaFormacion" => $valor->getidAreaFormacion(),
                        "descripcion" => $valor->getdescripcion(),
                        "estatus" => $valor->getestatus()
                    ));
                }
    
                return $response->withJson($listaDiagnostico, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    
        $app->get('/diagnostico/{id}', function (Request $request, Response $response, $args) {
        /**  */
            try{
                $idDiagnostico = (int)$args['id'];
                $mapper = new DiagnosticoMapper($this->db);
                $Diagnostico = $mapper->getDiagnosticoById($idDiagnostico);
        
                $listaDiagnostico = [];
                if (!empty($Diagnostico)) {
                    array_push($listaDiagnostico, array(
                        "idDiagnostico" => $Diagnostico->getidDiagnostico(),
                        "idAreaFormacion" => $Diagnostico->getidAreaFormacion(),
                        "descripcion" => $Diagnostico->getdescripcion(),
                        "estatus" => $Diagnostico->getestatus()
                    ));
                }
    
                return $response->withJson($listaDiagnostico, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });  
    /**************** */
        
    /** Metodo get de prueba **/
    $app->post('/hello', function (Request $request, Response $response, array $args) {

        $data = $request->getParsedBody();

        $directory =   filter_var($data['nombre'], FILTER_SANITIZE_STRING);
        $nombre =   filter_var($data['nomArchivo'], FILTER_SANITIZE_STRING);
        $uploadedFiles = $request->getUploadedFiles();

        if(mkdir($directory)){   
            // handle single input with single file upload
            $uploadedFile = $uploadedFiles['archivo'];

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                //$basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
                $filename = sprintf('%s.%0.8s', $nombre, $extension);
        
                $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

                $response->write('uploaded ' . $nombre . '<br/>');
            }
        }else{
            $response->getBody()->write("Fallo Critico, $directory");
        }
    });

    $app->run();
?>