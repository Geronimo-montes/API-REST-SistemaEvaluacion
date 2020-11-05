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
    
    /*********/
        $app->get('/escuela/{id}', function (Request $request, Response $response, $args) {
            try{
                $escuela = (int)$args['id'];
                $mapper = new EscuelaMapper($this->db);
                $listaDocente = $mapper->getEscuelaById($escuela);
                return $response->withJson($listaDocente,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /***** */

    /****** */
        $app->post('/cicloEscolarInsert', function (Request $request, Response $response) {
            try{
                $data = $request->getParsedBody();
                $dataCiclo = [];

                $dataCiclo['idCicloEscolar'] = filter_var($data['idCicloEscolar_cicloEscolar'], FILTER_SANITIZE_NUMBER_INT);
                $dataCiclo['inicioCiclo'] = filter_var($data['inicioCiclo_cicloEscolar'], FILTER_SANITIZE_STRING);
                $dataCiclo['finCiclo'] = filter_var($data['finCiclo_cicloEscolar'], FILTER_SANITIZE_STRING);
                $dataCiclo['diasHabiles'] = filter_var($data['diasHabiles_cicloEscolar'], FILTER_SANITIZE_STRING);
                $dataCiclo['estatus'] = filter_var($data['estatus_cicloEscolar'], FILTER_SANITIZE_STRING);                

                $ciclo = new CicloEscolarEntity($dataCiclo);
                $mapper = new CicloEscolarMapper($this->db);
                $insert = $mapper->insertCicloEscolar($ciclo);
                
                return $response->withJson($insert,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        }); 
        
        $app->get('/cicloEscolar', function (Request $request, Response $response, $args) {
            try{
                $mapper = new CicloEscolarMapper($this->db);
                $ciclo = $mapper->getCicloEscolarByEstatus();
                return $response->withJson($ciclo,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /****** */

    /**Rutas Docentes */
        $app->get('/docentes', function (Request $request, Response $response) {
            try{
                $mapper = new DocenteMapper($this->db);
                $listaDocente = $mapper->getDocentes();
                return $response->withJson($listaDocente,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
        
        $app->get('/docente/{id}', function (Request $request, Response $response, $args) {
            try{
                $idDocente = (int)$args['id'];
                $mapper = new DocenteMapper($this->db);
                $listaDocente = $mapper->getDocenteById($idDocente);
                return $response->withJson($listaDocente,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/docenteUpdate', function (Request $request, Response $response, $args) {
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
                $listaDocente = $mapper->updateDocenteById($docente);
                return $response->withJson($listaDocente,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /**************** */

    /*********/
    /**Rutas Alumnos */
        $app->post('/alumnos', function (Request $request, Response $response, $args) {
            try{
                $data = $request->getParsedBody();

                $grupo = filter_var($data['grupo_alumno'], FILTER_SANITIZE_STRING);
                $grado = filter_var($data['grado_alumno'], FILTER_SANITIZE_STRING);
                $turno = filter_var($data['turno_alumno'], FILTER_SANITIZE_STRING);

                $mapper = new AlumnoMapper($this->db);
                $listaAlumnos = $mapper->getAlumnos($grupo, $grado, $turno);
                return $response->withJson($listaAlumnos,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/alumno/{id}', function (Request $request, Response $response, $args) {
            try{
                $idAlumno = (int)$args['id'];
                $mapper = new AlumnoMapper($this->db);
                $listaAlumnos = $mapper->getAlumnoById($idAlumno);
                return $response->withJson($listaAlumnos,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/alumnoUpdate', function (Request $request, Response $response) {
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
                $listaAlumnos = $mapper->UpdateAlumnoById($alumno);
                return $response->withJson($listaAlumnos,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/alumnoInsert', function (Request $request, Response $response) {
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
            try{
                $mapper = new ActividadMapper($this->db);
                $listaActividades = $mapper->getActividades();
                return $response->withJson($listaActividades, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividad/{id}', function (Request $request, Response $response, $args) {
            try{
                $idPlanTrabajo = (int)$args['id'];
                $mapper = new ActividadMapper($this->db);
                $listaActividades = $mapper->getActividadById($idPlanTrabajo);
                return $response->withJson($listaActividades, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/actividadUpdate', function (Request $request, Response $response) {
            try{
                $data = $request->getParsedBody();
                $dataActividad = [];

                $dataActividad['idPlanTrabajo'] =          filter_var($data['idPlanTrabajo_actividad'], FILTER_SANITIZE_NUMBER_INT);
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
                $listaActividades = $mapper->UpdateActividadById($actividadEntidad);
                return $response->withJson($listaActividades, 200);
            }catch (Exception $e){
                return $response->withJson($e,200);
            }
        });
    /**************** */

    /*********/
    /**Rutas ActividadesProgramadas */
        $app->post('/actividadProgramadaInsert', function (Request $request, Response $response) {
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
        /** Listado de actividades programadas */
            try{
                $mapper = new ActividadProgramadaMapper($this->db);
                $listaActividad = $mapper->getActividadProgramada();
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadProgramada/{id}', function (Request $request, Response $response, $args) {
        /** Listado de actividades Programadas por ID */
            try{
                $id = (int)$args['id'];
                $mapper = new ActividadProgramadaMapper($this->db);
                $listaActividad = $mapper->getActividadProgramadaById($id);
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadProgramada/periodo/{periodo}', function (Request $request, Response $response, $args) {
        /** Actividad programada por periodo de evaluacion */
            try{
                $periodo = (int)$args['periodo'];
                $mapper = new ActividadProgramadaMapper($this->db);
                $listaActividad = $mapper->getActividadProgramadaByPeriodo($periodo);       
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    
        $app->get('/actividadProgramada/estatus/{estatus}', function (Request $request, Response $response, $args) {
        /** Actvidad programada por estatus */
            try{
                $estatus = $args['estatus'];
                $mapper = new ActividadProgramadaMapper($this->db);
                $listaActividad = $mapper->getActividadProgramadaByEstatus($estatus);
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadProgramada/periodoestatus/{periodo}/{estatus}', function (Request $request, Response $response, $args) {
        /** Actividad programada por periodo de evaluacion y estatus */
            try{
                $periodo = (int)$args['periodo'];
                $estatus = $args['estatus'];

                $mapper = new ActividadProgramadaMapper($this->db);
                $listaActividad = $mapper->getActividadProgramadaByPeriodoEstatus($periodo, $estatus);
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/actividadProgramadaUpdate', function (Request $request, Response $response) {
        /**Update de actividad programada */
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
                $listaActividad = $mapper->updateActividadProgramada($actividadEntidad);
                return $response->withJson($listaActividad, 200);
            }catch (Exception $e){
                return $response->withJson($e,200);
            }
        });
    /**************** */
    
    /*********/
    /**Rutas ActividadesAlumno */
        $app->post('/actividadAlumnoInsert', function (Request $request, Response $response) {        
            try{
                $data = $request->getParsedBody();
                $dataAlumno = [];

                $dataAlumno['idActividadProgramada'] = filter_var($data['idActividadProgramada_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataAlumno['idAlumno'] =              filter_var($data['idAlumno_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['idNivelDesempeno'] =      filter_var($data['idNivelDesempeno_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['observacion'] =           filter_var($data['observacion_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['rutaEvidencia'] =         filter_var($data['rutaEvidencia_actividad'], FILTER_SANITIZE_STRING);

                $alumno = new ActividadAlumnoEntity($dataAlumno);
                $mapper = new ActividadAlumnoMapper($this->db);
                $alumnoInsert = $mapper->insertActividadProgramada($alumno);
                
                return $response->withJson($alumnoInsert,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadAlumno', function (Request $request, Response $response) {
        /**  */
            try{
                $mapper = new ActividadAlumnoMapper($this->db);
                $listaActividad = $mapper->getActividadAlumno();
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadAlumno/{id}', function (Request $request, Response $response, $args) {
        /**  */
            try{
                $id = (int)$args['id'];
                $mapper = new ActividadAlumnoMapper($this->db);
                $listaActividad = $mapper->getActividadAlumnoById($id);
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/actividadAlumno/idalumnoidactividad/{alumno}/{actividad}', function (Request $request, Response $response, $args) {
        /**  */
            try{
                $alumno = (int)$args['alumno'];
                $actividad = (int)$args['actividad'];
                $mapper = new ActividadAlumnoMapper($this->db);
                $listaActividad = $mapper->getActividadAlumnoByIdAlumno($alumno, $actividad);
                return $response->withJson($listaActividad, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/actividadAlumnoUpdate', function (Request $request, Response $response) {        
        /** */            
            try{
                $data = $request->getParsedBody();
                $dataAlumno = [];

                $dataAlumno['idActividadProgramada'] = filter_var($data['idActividadProgramada_actividad'], FILTER_SANITIZE_NUMBER_INT);
                $dataAlumno['idAlumno'] =              filter_var($data['idAlumno_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['idNivelDesempeno'] =      filter_var($data['idNivelDesempeno_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['observacion'] =           filter_var($data['observacion_actividad'], FILTER_SANITIZE_STRING);
                $dataAlumno['rutaEvidencia'] =         filter_var($data['rutaEvidencia_actividad'], FILTER_SANITIZE_STRING);

                $alumno = new ActividadAlumnoEntity($dataAlumno);
                $mapper = new ActividadAlumnoMapper($this->db);
                $listaActividad = $mapper->updateActividadAlumno($alumno);
                return $response->withJson($listaActividad, 200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /**************** */

    /*********/
    /** Evidencias */
        $app->post('/evidenciaInsert', function (Request $request, Response $response) {        
            try{
                $data = $request->getParsedBody();
                $dataEvidencia = [];

                $dataEvidencia['idPlanTrabajo'] = filter_var($data['idPlanTrabajo_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['nombreEvidencia'] = filter_var($data['nombreEvidencia_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['descripcion'] = filter_var($data['descripcion_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['formatoEsperado'] = filter_var($data['formatoEsperado_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['evidenciaOpcional'] = filter_var($data['evidenciaOpcional_evidencia'], FILTER_SANITIZE_STRING);

                $evidencia = new EvidenciaEntity($dataEvidencia);
                $mapper = new EvidenciaMapper($this->db);
                $insert = $mapper->insertEvidencia($evidencia);
                return $response->withJson($insert,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/evidencia/{id}', function (Request $request, Response $response, $args) {
            try{
                $id = (int)$args['id'];
                $mapper = new EvidenciaMapper($this->db);
                $listaevidencia = $mapper->getEvidenciaByIdPlanTrabajo($id);
                return $response->withJson($listaevidencia, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/evidenciaUpdate', function (Request $request, Response $response) {        
            try{
                $data = $request->getParsedBody();
                $dataEvidencia = [];

                $dataEvidencia['idEvidencia'] = filter_var($data['idEvidencia_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['idPlanTrabajo'] = filter_var($data['idPlanTrabajo_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['nombreEvidencia'] = filter_var($data['nombreEvidencia_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['descripcion'] = filter_var($data['descripcion_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['formatoEsperado'] = filter_var($data['formatoEsperado_evidencia'], FILTER_SANITIZE_STRING);
                $dataEvidencia['evidenciaOpcional'] = filter_var($data['evidenciaOpcional_evidencia'], FILTER_SANITIZE_STRING);

                $evidencia = new EvidenciaEntity($dataEvidencia);
                $mapper = new EvidenciaMapper($this->db);
                $insert = $mapper->updateEvidencia($evidencia);
                return $response->withJson($insert,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /*************** */

    /*********/
    /** evaluacion */
        $app->post('/evaluacionInsert', function (Request $request, Response $response) {        
            try{
                $data = $request->getParsedBody();
                $dataEvaluacion = [];

                $dataEvaluacion['idAlumno'] = filter_var($data['idAlumno_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idAreaFormacion'] = filter_var($data['idAreaFormacion_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idPeriodoEvaluacion'] = filter_var($data['idPeriodoEvaluacion_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idNivelDesempeno'] = filter_var($data['idNivelDesempeno_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idCicloEscolar'] = filter_var($data['idCicloEscolar_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['observacion'] = filter_var($data['observacion_evaluacion'], FILTER_SANITIZE_STRING);
                $dataEvaluacion['estatus'] = filter_var($data['estatus_evaluacion'], FILTER_SANITIZE_STRING);

                $evaluacion = new EvaluacionEntity($dataEvaluacion);
                $mapper = new EvaluacionMapper($this->db);
                $insert = $mapper->insertEvaluacion($evaluacion);
                return $response->withJson($insert,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->post('/evaluacionUpdate', function (Request $request, Response $response) {        
            try{
                $data = $request->getParsedBody();
                $dataEvaluacion = [];

                $dataEvaluacion['idAlumno'] = filter_var($data['idAlumno_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idAreaFormacion'] = filter_var($data['idAreaFormacion_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idPeriodoEvaluacion'] = filter_var($data['idPeriodoEvaluacion_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idNivelDesempeno'] = filter_var($data['idNivelDesempeno_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['idCicloEscolar'] = filter_var($data['idCicloEscolar_evaluacion'], FILTER_SANITIZE_NUMBER_INT);
                $dataEvaluacion['observacion'] = filter_var($data['observacion_evaluacion'], FILTER_SANITIZE_STRING);
                $dataEvaluacion['estatus'] = filter_var($data['estatus_evaluacion'], FILTER_SANITIZE_STRING);

                $evaluacion = new EvaluacionEntity($dataEvaluacion);
                $mapper = new EvaluacionMapper($this->db);
                $update = $mapper->updateEvaluacion($evaluacion);
                return $response->withJson($update,200);
            }catch (Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });

        $app->get('/evaluacion', function (Request $request, Response $response, $args) {
            try{
                $mapper = new EvaluacionMapper($this->db);
                $evaluacion = $mapper->getEvaluaciones();
                return $response->withJson($evaluacion, 200);
            }catch(Exception $e){
                return $response->withJson($e->getMessage(),200);
            }
        });
    /*************** */


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

        $app->get('/prueba/id={id}/nombre={nombre}', function (Request $request, Response $response, array $args) {
            $id = (int)$args['id'];
            $nombre = $args['nombre'];
            
            $response->getBody()->write("id :  $id || nombre: $nombre");
        });
    /*** */
    $app->run();
?>