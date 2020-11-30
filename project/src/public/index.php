<?php 
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    require '../vendor/autoload.php';
    
    $config['db']['host']   = 'localhost';
    $config['db']['user']   = 'root';
    $config['db']['pass']   = '';
    $config['db']['dbname'] = 'sistemaevaluacion';

    $app = new \Slim\App(['settings' => $config]);
    $app->options('/{routes:.+}', function ($request, $response, $args) { return $response; });
    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With,Content-Type,Accept,Origin,Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,PATCH,OPTIONS');
    });
    $container = $app->getContainer();   
    $container['db'] = function ($c) {    /**** Agregar conexion a BD ****/
        $db = $c['settings']['db'];
        $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'] . ";charset=utf8", $db['user'], $db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    };

    //Login terminado completamente
    $app->post('/login', function (Request $request, Response $response) {
        try{
            $data = $request->getParsedBody();
            $usuario = filter_var($data['email'], FILTER_SANITIZE_STRING);
            $password = filter_var($data['password'], FILTER_SANITIZE_STRING);
            $mapper = new DocenteMapper($this->db);
            $id = $mapper->logIn([ //Validamos las credenciales desde DocenteMapper
                'email'     => $usuario,
                'password'  => $password                 
            ]);
            $token = [];            
            if($id != NULL){
                $valor = Auth::SignIn($id);
                if( $mapper->insertToken( ['id' => $id, 'token' => $valor]))
                    array_push($token, array("token" => $valor));
                else
                    array_push($token, array( "error" => "Error al generar el token de acceso."));
            }else
                array_push($token, array( "error" => "Correo y/o contrasela incorrectos."));

            return $response->withJson($token, 200);
        }catch (Exception $e){
            return $response->withJson(array('error' => 'Error al auntenticar usuario.'));
        }
    });
    //validacion de las credecioanles terminado
    $app->post('/validarUser', function (Request $request, Response $response) {
        try{
            $data = $request->getParsedBody();
            $token = filter_var($data['token'], FILTER_SANITIZE_STRING);

            $mapper = new DocenteMapper($this->db);
            $validacion = $mapper->validarToken( $token );  
      
            if($validacion != NULL)
                $res = ['success' => true, 'id' => $validacion];
            else
                $res = ['success' => false, 'error' => 'Error al validar token.'];

            return $response->withJson( $res, 200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });
    //update credenciales terminado
    $app->post('/user/update', function (Request $request, Response $response, $args) {
        try{
            $data = $request->getParsedBody();
            $dataDocente = [];

            $dataDocente['email'] 	    = filter_var($data['email'], FILTER_SANITIZE_STRING);
            $dataDocente['password'] 	= filter_var($data['password'], FILTER_SANITIZE_STRING);
            $dataDocente['idDocente'] 	= filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
            

            $mapper = new DocenteMapper($this->db);
            if($mapper->updateUserById($dataDocente)){
                $res = ['success' => true, 'mensaje' => 'Usuario y/o contraseña actualizado.'];
            }else{
                $res = ['success' => false, 'mensaje' => 'Error al actualizar usuario y contraseña.'];
            }

            return $response->withJson($res,200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });
    //Informacion docente, escuela, ciclo escolar terminado
    $app->get('/docente/{id}', function (Request $request, Response $response, $args) {
        try{
            $idDocente = (int)$args['id'];
            $mapper = new DocenteMapper($this->db);
            $listaDocente = $mapper->getDocenteById($idDocente);
            $mapper = new EscuelaMapper($this->db);
            $listaEscuela = $mapper->getEscuelaById($listaDocente[0]['idEscuela']);
            $mapper = new CicloEscolarMapper($this->db);
            $ciclo = $mapper->getCicloEscolarByEstatus();

            foreach ($listaEscuela as $valor) {
                foreach ($valor as $key => $value) {
                    $listaDocente[0][$key . 'Escuela'] = $value;
                }
            }
            foreach ($ciclo as $valor) {
                foreach ($valor as $key => $value) {
                    $listaDocente[0][$key . 'Ciclo'] = $value;
                }
            }
            //$res = array_merge($listaDocente, $listaEscuela, $ciclo);
            
            return $response->withJson($listaDocente,200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });
    //actualizar datos del docente terminado
    $app->post('/docente/update', function (Request $request, Response $response, $args) {
        try{
            $data = $request->getParsedBody();
            $dataDocente = [];

            $dataDocente['idDocente'] 		= filter_var($data['idDocente_docente'], 		FILTER_SANITIZE_NUMBER_INT);
            $dataDocente['nombre'] 			= filter_var($data['nombre_docente'], 			FILTER_SANITIZE_STRING);
            $dataDocente['ap1'] 			= filter_var($data['ap1_docente'], 				FILTER_SANITIZE_STRING);
            $dataDocente['ap2'] 			= filter_var($data['ap2_docente'], 				FILTER_SANITIZE_STRING);
            $dataDocente['curp'] 			= filter_var($data['curp_docente'], 			FILTER_SANITIZE_STRING);
            $dataDocente['rfc'] 			= filter_var($data['rfc_docente'], 				FILTER_SANITIZE_STRING);
            $dataDocente['direccion'] 		= filter_var($data['direccion_docente'],		FILTER_SANITIZE_STRING);
            $dataDocente['telefono'] 		= filter_var($data['telefono_docente'], 		FILTER_SANITIZE_STRING);
            $dataDocente['facebook'] 		= filter_var($data['facebook_docente'], 		FILTER_SANITIZE_STRING);
            $dataDocente['grupo'] 			= filter_var($data['grupo_docente'], 			FILTER_SANITIZE_STRING);
            $dataDocente['grado'] 			= filter_var($data['grado_docente'], 			FILTER_SANITIZE_STRING);
            $dataDocente['turno'] 			= filter_var($data['turno_docente'], 			FILTER_SANITIZE_STRING);
            $dataDocente['rol'] 			= filter_var($data['rol_docente'], 				FILTER_SANITIZE_STRING);
            $dataDocente['estatus'] 		= filter_var($data['estatus_docente'], 			FILTER_SANITIZE_STRING);

            $docente = new DocenteEntity($dataDocente);
            $mapper = new DocenteMapper($this->db);
            $listaDocente = $mapper->updateDocenteById($docente);
            $mapper = new EscuelaMapper($this->db);
            $listaEscuela = $mapper->getEscuelaById($listaDocente[0]['idEscuela']);
            $mapper = new CicloEscolarMapper($this->db);
            $ciclo = $mapper->getCicloEscolarByEstatus();

            foreach ($listaEscuela as $valor) {
                foreach ($valor as $key => $value) {
                    $listaDocente[0][$key . 'Escuela'] = $value;
                }
            }
            foreach ($ciclo as $valor) {
                foreach ($valor as $key => $value) {
                    $listaDocente[0][$key . 'Ciclo'] = $value;
                }
            }
            return $response->withJson($listaDocente,200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });
    /*****************************************************************************************************************/
    //Actualizar el ciclo escolar
    $app->post('/cicloescolar/insert', function (Request $request, Response $response) {
        try{
            $data = $request->getParsedBody();
            $dataCiclo = [];

            $dataCiclo['idCicloEscolar'] = filter_var($data['idCicloEscolar_cicloEscolar'], FILTER_SANITIZE_NUMBER_INT);
            $dataCiclo['nombre'] = filter_var($data['nombre_cicloEscolar'], FILTER_SANITIZE_STRING);
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
    
    //alumnos
    $app->post('/alumno', function (Request $request, Response $response, $args) {
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

    $app->post('/alumno/insert', function (Request $request, Response $response) {
        try{
            $data = $request->getParsedBody();
            $dataAlumno = [];

            $dataAlumno['idAlumno'] 		    = filter_var($data['idAlumno_alumno'],              FILTER_SANITIZE_NUMBER_INT);
            $dataAlumno['idEscuela'] 	        = filter_var($data['idEscuela_alumno'],         FILTER_SANITIZE_STRING);
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
            $dataAlumno['rutaExpediente']       = filter_var($data['rutaExpediente_alumno'],        FILTER_SANITIZE_STRING);

            $alumno = new AlumnoEntity($dataAlumno);
            $mapper = new AlumnoMapper($this->db);
            $alumnoInsert = $mapper->InsertAlumno($alumno);
            
            return $response->withJson($alumnoInsert,200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });

    $app->post('/alumno/update', function (Request $request, Response $response) {
        try{
            $data = $request->getParsedBody();
            $dataAlumno = [];

            $dataAlumno['idAlumno'] 		    = filter_var($data['idAlumno_alumno'],              FILTER_SANITIZE_NUMBER_INT);
            $dataAlumno['idEscuela'] 	        = filter_var($data['idEscuela_alumno'],         FILTER_SANITIZE_STRING);
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

    $app->run();
?>