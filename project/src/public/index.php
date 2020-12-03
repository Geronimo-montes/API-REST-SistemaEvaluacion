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
    /**
     * $token = $request->getHeader('HTTP_AUTHORIZATION');
     * $mapper = new DocenteMapper($this->db);
     * $validacion = $mapper->validarToken($token[0]);
     */
    //Borrar no sirve, se reimplemeto validacion de sesion
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
    //Login **
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
    //Login **
    $app->put('/logout', function (Request $request, Response $response) {
      try{
          $token = $request->getHeader('HTTP_AUTHORIZATION');
          $mapper = new DocenteMapper($this->db);
          $id = Auth::GetId($token[0]);  
          if($mapper->insertToken([ "id" => $id, "token" => '' ]))           
            return $response->withJson(true, 200);
          else
            return $response->withJson(false, 200);
      }catch (Exception $e){
        return $response->withJson(array('error' => $e.getMessage()));
      }
    });
    //update **
    $app->put('/user/update', function (Request $request, Response $response, $args) {
        try{
            $token = $request->getHeader('HTTP_AUTHORIZATION');
            $data = $request->getParsedBody();
            $dataDocente = [
                'email'	    => filter_var($data['email'], FILTER_SANITIZE_STRING),
                'password'	=> filter_var($data['password'], FILTER_SANITIZE_STRING),
                'idDocente'	=> filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT),
            ];

            $mapper = new DocenteMapper($this->db);
            $validacion = $mapper->validarToken($token[0]);
            if($validacion['success'])
                if($mapper->updateUserById($dataDocente))
                    $res = ['success' => true, 'mensaje' => 'Usuario y/o contraseña actualizado.'];
                else
                    $res = ['success' => false, 'mensaje' => 'Error al actualizar usuario y contraseña.'];
            else
                $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

            return $response->withJson($res,200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });
    //Info Docente **
    $app->get('/docente', function (Request $request, Response $response, $args) {
        try{
            $token = $request->getHeader('HTTP_AUTHORIZATION');

            $mapper = new DocenteMapper($this->db);
            $validacion = $mapper->validarToken($token[0]);
            if($validacion['success']){
                $idDocente = Auth::GetId($token[0]);
                $res = $mapper->getDocenteById($idDocente);
                $mapper = new EscuelaMapper($this->db);
                $listaEscuela = $mapper->getEscuelaById($res[0]['idEscuela']);
                $mapper = new CicloEscolarMapper($this->db);
                $ciclo = $mapper->getCicloEscolarByEstatus();
    
                foreach ($listaEscuela as $valor) {
                    foreach ($valor as $key => $value) {
                        $res[0][$key . 'Escuela'] = $value;
                    }
                }
                foreach ($ciclo as $valor) {
                    foreach ($valor as $key => $value) {
                        $res[0][$key . 'Ciclo'] = $value;
                    }
                }               
            }else
                $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];
            
            return $response->withJson($res,200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });
    //Update Docente **
    $app->put('/docente/update', function (Request $request, Response $response, $args) {
        try{
            $token = $request->getHeader('HTTP_AUTHORIZATION');
            
            $data = $request->getParsedBody();
            $dataDocente = [
                    'idDocente'		=>  filter_var($data['idDocente_docente'], 	FILTER_SANITIZE_NUMBER_INT),
                    'nombre'		=>  filter_var($data['nombre_docente'], 	FILTER_SANITIZE_STRING),
                    'ap1'			=>  filter_var($data['ap1_docente'], 		FILTER_SANITIZE_STRING),
                    'ap2'			=>  filter_var($data['ap2_docente'], 		FILTER_SANITIZE_STRING),
                    'curp'			=>  filter_var($data['curp_docente'], 		FILTER_SANITIZE_STRING),
                    'rfc'			=>  filter_var($data['rfc_docente'], 		FILTER_SANITIZE_STRING),
                    'direccion'		=>  filter_var($data['direccion_docente'],	FILTER_SANITIZE_STRING),
                    'telefono'		=>  filter_var($data['telefono_docente'], 	FILTER_SANITIZE_STRING),
                    'facebook'		=>  filter_var($data['facebook_docente'], 	FILTER_SANITIZE_STRING),
                    'grupo'			=>  filter_var($data['grupo_docente'], 		FILTER_SANITIZE_STRING),
                    'grado'			=>  filter_var($data['grado_docente'], 		FILTER_SANITIZE_STRING),
                    'turno'			=>  filter_var($data['turno_docente'], 		FILTER_SANITIZE_STRING),
                    'rol'			=>  filter_var($data['rol_docente'], 		FILTER_SANITIZE_STRING),
                    'estatus'		=>  filter_var($data['estatus_docente'], 	FILTER_SANITIZE_STRING),
            ];

            $mapper = new DocenteMapper($this->db);
            $validacion = $mapper->validarToken($token[0]);
            if($validacion['success']){
                $docente = new DocenteEntity($dataDocente);
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

                $res = ['success' => true, 'mensaje' => 'Datos actualizados correctamente.','data' => $listaDocente];
            }else
                $res = ['success' => false, 'mensaje' => 'Datos no actualizados. Token de sesion no valido.'];

            return $response->withJson($res,200);
        }catch (Exception $e){
            return $response->withJson($e->getMessage(),200);
        }
    });
    //alumnos *
    $app->get('/alumno/{grupo}/{grado}/{turno}', function (Request $request, Response $response, $args) {
        try{
            $token = $request->getHeader('HTTP_AUTHORIZATION');

            $grupo = $args['grupo'];
            $grado = $args['grado'];
            $turno = $args['turno'];

            $mapper = new DocenteMapper($this->db);
            $validacion = $mapper->validarToken($token[0]);
            if($validacion['success']){
                $mapper = new AlumnoMapper($this->db);
                $listaAlumnos = $mapper->getAlumnos($grupo, $grado, $turno);
                $res = ['success' => true, 'mensaje' => 'Consulta realizada con exito', 'data' => $listaAlumnos];
            }else
                $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

            return $response->withJson($listaAlumnos, 200);
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