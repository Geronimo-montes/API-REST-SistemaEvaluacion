<?php

use Firebase\JWT\ExpiredException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'root';
$config['db']['pass']   = '';
$config['db']['dbname'] = 'sistemaevaluacion';

$app = new \Slim\App(['settings' => $config]);
$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});
$app->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With,Content-Type,Accept,Origin,Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET,POST,post,DELETE,PATCH,OPTIONS');
});
$container = $app->getContainer();
$container['db'] = function ($c) {
  /**** Agregar conexion a BD ****/
  $db = $c['settings']['db'];
  $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'] . ";charset=utf8", $db['user'], $db['pass']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
};
//Login **
$app->post('/login', function (Request $request, Response $response) {
  try {
    $data = $request->getParsedBody();
    $usuario = filter_var($data['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($data['password'], FILTER_SANITIZE_STRING);

    $mapper = new UsuarioMapper($this->db);
    $usuario = $mapper->logIn([ //Validamos las credenciales desde DocenteMapper
      'email'     => $usuario,
      'password'  => $password
    ]);
    $token = [];

    if ($usuario['idDocente'] != NULL xor $usuario['idAlumno'] != NULL) {
      $id = ($usuario['idDocente'] != Null) ? $usuario['idDocente'] : $usuario['idAlumno'];
      $valor = Auth::SignIn($id, $usuario['idUsuario']);
      if ($mapper->insertToken(['id' => $id, 'token' => $valor]))
        $token = [
          "token" => $valor,
          "rol" => $usuario['rol'],
          "user" => $usuario,
        ];
      else
        array_push($token, array("error" => "Error al generar el token de acceso."));
    } else
      array_push($token, array("error" => "Correo y/o contrasela incorrectos."));

    return $response->withJson($token, 200);
  } catch (Exception $e) {
    return $response->withJson(array('error' => 'Error al auntenticar usuario.' . $e->getMessage()));
  }
});
//alumnos por id**
$app->get('/usuario', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $id = Auth::GetIdUsario($token[0]);
      $res = $mapper->getUsuario($id);
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//Validar provilegios **
$app->get('/docentevalidacion', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    $rol = '';
    if ($validacion['success']) {
      $id = Auth::GetId($token[0]);
      $rol = $mapper->getRol($id);
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($rol, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//LogOut **
$app->post('/logout', function (Request $request, Response $response) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $id = Auth::GetId($token[0]);
    if ($mapper->insertToken(["id" => $id, "token" => '']))
      return $response->withJson(true, 200);
    else
      return $response->withJson(false, 200);
  } catch (Exception $e) {
    return $response->withJson(array('error' => $e->getMessage()));
  }
});
//update Credenciales **
$app->post('/user/update', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $data = $request->getParsedBody();
    $dataDocente = [
      'email'      => filter_var($data['email'], FILTER_SANITIZE_STRING),
      'password'  => filter_var($data['password'], FILTER_SANITIZE_STRING),
      'idUsuario'  => filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT),
    ];

    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success'])
      if ($mapper->updateUserById($dataDocente))
        $res = [
          'success' => true,
          'mensaje' => 'Usuario y/o contraseña actualizado.',
          'destino' => 'u'
        ];
      else
        $res = [
          'success' => false,
          'mensaje' => 'Error al actualizar usuario y contraseña.',
          'destino' => 'u'
        ];

    else
      $res = [
        'success' => false,
        'mensaje' => 'Token de sesion no valido.',
        'destino' => 'u'
      ];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//perfil(foto) update **
$app->post('/updateperfil', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $data = $request->getUploadedFiles();
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $mapper = new DocenteMapper($this->db);
      if (empty($data['file'])) {
        throw new Exception('Sin archivos');
      }
      $file = $data['file'];
      if ($file->getError() === UPLOAD_ERR_OK) {
        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $filename = sprintf('d%s.%0.8s', Auth::GetId($token[0]), $extension);
        $file->moveTo('img' . DIRECTORY_SEPARATOR . $filename);
        $mapper->updatePerfilDocenteById('http://sistemaevaluacion/img/' . $filename, Auth::GetId($token[0]));
        //$mapper->updatePerfilDocenteById('https://sistemaevaluacionkinder.000webhostapp.com/back/img/' . $filename, Auth::GetId($token[0]));
        $res = [
          'success' => true,
          'mensaje' => 'Perfil actualizado.',
          'destino' => 'p'
        ];
      }
    } else
      $res = [
        'success' => false,
        'mensaje' => 'Token de sesion no valido.',
        'destino' => 'p'
      ];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//Info Docente **
$app->get('/docente', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $mapper = new DocenteMapper($this->db);
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
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//Update Docente **
$app->post('/docente/update', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');

    $data = $request->getParsedBody();
    $dataDocente = [
      'idDocente'  =>  filter_var($data['idDocente'],  FILTER_SANITIZE_NUMBER_INT),
      'nombre'    =>  filter_var($data['nombre'],     FILTER_SANITIZE_STRING),
      'ap1'        =>  filter_var($data['ap1'],         FILTER_SANITIZE_STRING),
      'ap2'        =>  filter_var($data['ap2'],         FILTER_SANITIZE_STRING),
      'curp'      =>  filter_var($data['curp'],       FILTER_SANITIZE_STRING),
      'rfc'        =>  filter_var($data['rfc'],         FILTER_SANITIZE_STRING),
      'direccion'  =>  filter_var($data['direccion'],  FILTER_SANITIZE_STRING),
      'telefono'  =>  filter_var($data['telefono'],   FILTER_SANITIZE_STRING),
      'facebook'  =>  filter_var($data['facebook'],   FILTER_SANITIZE_STRING),
      'grupo'      =>  filter_var($data['grupo'],       FILTER_SANITIZE_STRING),
      'grado'      =>  filter_var($data['grado'],       FILTER_SANITIZE_STRING),
      'turno'      =>  filter_var($data['turno'],       FILTER_SANITIZE_STRING),
      'estatus'    =>  filter_var($data['estatus'],     FILTER_SANITIZE_STRING),
    ];

    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $mapper = new DocenteMapper($this->db);
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

      $res = [
        'success' => true,
        'mensaje' => 'Datos actualizados correctamente.',
        'data' => $listaDocente,
        'destino' => 'd'
      ];
    } else
      $res = [
        'success' => false,
        'mensaje' => 'Datos no actualizados. Token de sesion no valido.',
        'destino' => 'd'
      ];
  } catch (Exception $e) {
    $res = [
      'success' => false,
      'mensaje' => $e->getMessage(),
      'destino' => 'd'
    ];
  }
  return $response->withJson($res, 200);
});
//alumnos por id**
$app->get('/alumnouser', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $mapper = new AlumnoMapper($this->db);
      $id = Auth::GetId($token[0]);
      $res = $mapper->getAlumnoById($id);

      if (sizeof($res) > 1) {
        $mapper = new EscuelaMapper($this->db);
        $listaEscuela = $mapper->getEscuelaById($res['idEscuela']);

        foreach ($listaEscuela as $valor) {
          foreach ($valor as $key => $value) {
            $res[$key . 'Escuela'] = $value;
          }
        }
      } else {
        $res = ['success' => false, 'mensaje' => 'No se encontraron datos'];
      }
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//alumnos **
$app->get('/alumno/{grupo}/{grado}/{turno}', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');

    $grupo = $args['grupo'];
    $grado = $args['grado'];
    $turno = $args['turno'];

    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $mapper = new AlumnoMapper($this->db);
      $res = $mapper->getAlumnos($grupo, $grado, $turno);
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//insert Alumno
$app->post('/alumno/insert', function (Request $request, Response $response) {
  try {
    $data = $request->getParsedBody();
    $dataAlumno = [];

    $dataAlumno['idAlumno']         = filter_var($data['idAlumno_alumno'],              FILTER_SANITIZE_NUMBER_INT);
    $dataAlumno['idEscuela']           = filter_var($data['idEscuela_alumno'],         FILTER_SANITIZE_STRING);
    $dataAlumno['nombre']           = filter_var($data['nombre_alumno'],                FILTER_SANITIZE_STRING);
    $dataAlumno['ap1']               = filter_var($data['ap1_alumno'],                   FILTER_SANITIZE_STRING);
    $dataAlumno['ap2']               = filter_var($data['ap2_alumno'],                   FILTER_SANITIZE_STRING);
    $dataAlumno['curp']           = filter_var($data['curp_alumno'],                  FILTER_SANITIZE_STRING);
    $dataAlumno['grupo']           = filter_var($data['grupo_alumno'],                 FILTER_SANITIZE_STRING);
    $dataAlumno['grado']             = filter_var($data['grado_alumno'],                 FILTER_SANITIZE_STRING);
    $dataAlumno['turno']             = filter_var($data['turno_alumno'],                 FILTER_SANITIZE_STRING);
    $dataAlumno['nombreTutor']          = filter_var($data['nombreTutor_alumno'],           FILTER_SANITIZE_STRING);
    $dataAlumno['direccion']         = filter_var($data['direccion_alumno'],             FILTER_SANITIZE_STRING);
    $dataAlumno['telefono']         = filter_var($data['telefono_alumno'],              FILTER_SANITIZE_STRING);
    $dataAlumno['email']           = filter_var($data['email_alumno'],                 FILTER_SANITIZE_EMAIL);
    $dataAlumno['facebook']         = filter_var($data['facebook_alumno'],              FILTER_SANITIZE_STRING);
    $dataAlumno['preferennciaContacto'] = Filter_var($data['preferennciaContacto_alumno'],  FILTER_SANITIZE_STRING);
    $dataAlumno['estatus']             = filter_var($data['estatus_alumno'],               FILTER_SANITIZE_STRING);
    $dataAlumno['rutaExpediente']       = filter_var($data['rutaExpediente_alumno'],        FILTER_SANITIZE_STRING);

    $alumno = new AlumnoEntity($dataAlumno);
    $mapper = new AlumnoMapper($this->db);
    $alumnoInsert = $mapper->InsertAlumno($alumno);

    return $response->withJson($alumnoInsert, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//update Alumno **
$app->post('/alumno/update', function (Request $request, Response $response) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $data = $request->getParsedBody();
    $files = $request->getUploadedFiles();

    $dataAlumno = [
      'idAlumno'    => filter_var($data['idAlumno'],    FILTER_SANITIZE_NUMBER_INT),
      'nombre'      => filter_var($data['nombre'],      FILTER_SANITIZE_STRING),
      'ap1'         => filter_var($data['ap1'],         FILTER_SANITIZE_STRING),
      'ap2'         => filter_var($data['ap2'],         FILTER_SANITIZE_STRING),
      'curp'        => filter_var($data['curp'],        FILTER_SANITIZE_STRING),
      'grupo'       => filter_var($data['grupo'],       FILTER_SANITIZE_STRING),
      'grado'       => filter_var($data['grado'],       FILTER_SANITIZE_STRING),
      'turno'       => filter_var($data['turno'],       FILTER_SANITIZE_STRING),
      'nombreTutor' => filter_var($data['nombreTutor'], FILTER_SANITIZE_STRING),
      'direccion'   => filter_var($data['direccion'],   FILTER_SANITIZE_STRING),
      'telefono'    => filter_var($data['telefono'],    FILTER_SANITIZE_STRING),
      'email'       => filter_var($data['email'],       FILTER_SANITIZE_EMAIL),
      'facebook'    => filter_var($data['facebook'],    FILTER_SANITIZE_STRING),
    ];

    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      if (empty($data['file'])) {
        $file = $files['file'];
        if ($file->getError() === UPLOAD_ERR_OK) {
          $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
          $filename = sprintf('a%s.%0.8s', $dataAlumno['idAlumno'], $extension);
          $file->moveTo('img' . DIRECTORY_SEPARATOR . $filename);
        }
      }
      $alumno = new AlumnoEntity($dataAlumno);
      $mapper = new AlumnoMapper($this->db);
      $listaAlumnos = $mapper->UpdateAlumnoById($alumno);
      $res = [
        'success' => true,
        'mensaje' => 'Datos actualizados correctamente.',
        'data' => $listaAlumnos,
        'destino' => 'a'
      ];
    } else
      $res = [
        'success' => false,
        'mensaje' => 'Datos no actualizados. Token de sesion no valido.',
        'destino' => 'a'
      ];
    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//area Formacion **
$app->get('/areaFormacion', function (Request $request, Response $response) {
  try {
    $mapper = new AreaFormacionMapper($this->db);
    $areaFormacion = $mapper->getAreaFormacion();
    return $response->withJson($areaFormacion, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//aprendizaje Esperado **
$app->get('/aprendizajeEsperado/{id}', function (Request $request, Response $response, $args) {
  try {
    $id = $args['id'];
    $mapper = new AprendizajeEsperadoMapper($this->db);
    $aprendizajeEsperado = $mapper->getAprendizajeEsperadoByAreaFormacion($id);
    $mapper = new AreaFormacionMapper($this->db);
    $areaFormacion = $mapper->getAreaFormacionById($id);

    foreach ($aprendizajeEsperado as $i => $value) {
      $aprendizajeEsperado[$i]['idAreaFormacion'] = $areaFormacion;
    }

    return $response->withJson($aprendizajeEsperado, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//insert a ctividad **
$app->post('/actividadInsert', function (Request $request, Response $response) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $data = $request->getUploadedFiles();
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $data = $request->getBody();
      $actividad = json_decode($data, true);
      $actividad['idDocente'] = Auth::GetId($token[0]);
      $mapper = new ActividadMapper($this->db);
      $mensaje = $mapper->InsertActividad($actividad);
      $res = ['success' => true, 'mensaje' => $mensaje];
    } else {
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];
    }
  } catch (Exception $e) {
    $res = ['success' => false, 'mensaje' => $e->getMessage()];
  }
  return $response->withJson($res, 200);
});
//actividades **
$app->get('/actividades', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $mapper = new ActividadMapper($this->db);
      $res = $mapper->getActividades();
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//actividades por ID
$app->get('/actividad/{id}', function (Request $request, Response $response, $args) {
  try {
    $id = $args['id'];
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $mapper = new ActividadMapper($this->db);
      $res = $mapper->getActividadById($id);
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
/** ACTIVIDADES PROGRAMADAS QUE SE VISUALIZARAN EN EL CALENDARIO */
//Plan trabajo
$app->get('/planTrabajo', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $mapper = new ActividadProgramadaMapper($this->db);
      $res = $mapper->getActividadProgramada();
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//plan trabajo insert
$app->post('/planTrabajo/insert', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $data = $request->getParsedBody();
      $data = [
        'idPlanTrabajo' => filter_var($data['idPlanTrabajo'], FILTER_SANITIZE_NUMBER_INT),
        'fecha' => filter_var($data['fecha'], FILTER_SANITIZE_STRING),
        'hora' => filter_var($data['hora'], FILTER_SANITIZE_STRING),
      ];

      $actividad = new ActividadProgramadaEntity($data);
      $mapper = new ActividadProgramadaMapper($this->db);
      $resultado = $mapper->insertActividadProgramada($actividad);

      if (isset($resultado)) {
        //insertar actividad por cada alumno del profesor
        $mapper = new DocenteMapper($this->db);
        $idDocente = Auth::GetId($token[0]);
        $datos = $mapper->getDocenteById($idDocente);

        $mapper = new AlumnoMapper($this->db);
        $listaAlumnos = $mapper->getAlumnos($datos[0]['grupo'], $datos[0]['grado'], $datos[0]['turno']);
        $mapper = new ActividadAlumnoMapper($this->db);
        $ruta = $data['idPlanTrabajo'] . str_replace('-', '', $data['fecha']);

        foreach ($listaAlumnos as $value) {
          $data = ['id' => $value['idAlumno'], 'actividad' => $resultado, 'ruta' => $ruta];
          $mapper->insertActividadAlumno($data);
          //carpeta de evidencia
          $_ruta = $value['rutaExpediente'] . DIRECTORY_SEPARATOR . $ruta;
          mkdir($_ruta);
        }

        $res = ['success' => true, 'mensaje' => 'Exito al programar la actividad'];
      } else
        $res = ['success' => false, 'mensaje' => 'Actividad duplicada.'];
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    if ($e->getCode() == 23000)
      $res = [
        'success' => false, 'mensaje' => '¡Error!. Actividad Duplicada.'
      ];
    else
      $res = [
        'success' => false, 'mensaje' => $e->getMessage()
      ];
  }
  return $response->withJson($res, 200);
});
//plan trabajo update
$app->post('/planTrabajo/update', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $data = $request->getParsedBody();
      $data = [
        'idActividadProgramada' => filter_var($data['idActividadProgramada'], FILTER_SANITIZE_NUMBER_INT),
        'fecha' => filter_var($data['fecha'], FILTER_SANITIZE_STRING),
        'hora' => filter_var($data['hora'], FILTER_SANITIZE_STRING),
      ];
      $actividad = new ActividadProgramadaEntity($data);
      $mapper = new ActividadProgramadaMapper($this->db);
      $mensaje = $mapper->updateActividadProgramada($actividad);

      if ($mensaje == 't')
        $res = ['success' => true, 'mensaje' => 'Actualizacion Exitosa.'];
      else
        $res = ['success' => false, 'mensaje' => 'Actividad duplicada.'];
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];
    return $response->withJson($res, 200);
  } catch (Exception $e) {
    $res = [
      'success' => false,
      'mensaje' => $e->getMessage(),
    ];
  }
  return $response->withJson($res, 200);
});
//plan trabajo delete
$app->delete('/planTrabajo/delete/{id}', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $id = $args['id'];
      $mapper = new DocenteMapper($this->db);
      $idDocente = Auth::GetId($token[0]);
      $datos = $mapper->getDocenteById($idDocente);

      $mapper = new AlumnoMapper($this->db);
      $listaAlumnos = $mapper->getAlumnos($datos[0]['grupo'], $datos[0]['grado'], $datos[0]['turno']);
      $mapper = new ActividadAlumnoMapper($this->db);

      foreach ($listaAlumnos as $value) {
        $data = [
          'idAlumno' => $value['idAlumno'],
          'idActividadProgramada' => $id
        ];
        $mapper->deleteActividadAlumno($data);
      }

      $mapper = new ActividadProgramadaMapper($this->db);
      $mensaje = $mapper->deleteActividadProgramada($id);

      if ($mensaje == 't')
        $res = ['success' => true, 'mensaje' => 'Actividad eliminada del calendario.'];
      else
        $res = ['success' => false, 'mensaje' => 'Error inesperdo.'];
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];
    return $response->withJson($res, 200);
  } catch (Exception $e) {
    $res = [
      'success' => false,
      'mensaje' => $e->getMessage(),
    ];
  }
  return $response->withJson($res, 200);
});
//plan de trabajo por alumno
$app->get('/actividadesalumno', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $id = Auth::GetId($token[0]);
      $mapper = new ActividadProgramadaMapper($this->db);
      $res = $mapper->getActividadesByAlumno($id);
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//plan de trabajo por alumno Y id
$app->get('/actividadalumno/{id}', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $id = $args['id'];
      $mapper = new ActividadProgramadaMapper($this->db);
      $actividad = $mapper->getActividadAlumnoById($id);
      $mapper = new ComentarioMapper($this->db);
      $comentarios = $mapper->getComentarios($actividad['idActividadProgramada'], $actividad['idAlumno']);
      $res = [
        'actividad' => $actividad,
        'comentarios' => $comentarios
      ];
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//plan de trabajo por alumno Y id
$app->post('/comentarioinsert', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);
    if ($validacion['success']) {
      $data = $request->getParsedBody();
      $data = [
        'idActividadProgramada' => filter_var($data['idActividadProgramada'], FILTER_SANITIZE_NUMBER_INT),
        'idAlumno' => filter_var($data['idAlumno'], FILTER_SANITIZE_STRING),
        'idDocente' => null,
        'comentario' => filter_var($data['comentario'], FILTER_SANITIZE_STRING),
      ];

      $mapper = new ComentarioMapper($this->db);
      $res = $mapper->insertComentario($data);
    } else
      $res = ['success' => false, 'mensaje' => 'Token de sesion no valido.'];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
//evidencia
$app->post('/subirevidencia/{length}/{id}', function (Request $request, Response $response, $args) {
  try {
    $token = $request->getHeader('HTTP_AUTHORIZATION');
    $data = $request->getUploadedFiles();
    $length = intval($args['length']);
    $idActividadProgramada = intval($args['id']);

    $mapper = new UsuarioMapper($this->db);
    $validacion = $mapper->validarToken($token[0]);

    if ($validacion['success']) {
      $mapper = new AlumnoMapper($this->db);
      $idAlumno = Auth::GetId($token[0]);
      $ruta = $mapper->getAlumnoById($idAlumno)['rutaExpediente'];
      $mapper = new ActividadAlumnoMapper($this->db);
      $ruta = $ruta . '/' .  $mapper->getActividadAlumnoByIdAlumno($idAlumno, $idActividadProgramada)[0]['rutaEvidencia'];

      for ($i = 0; $i < $length; $i++) {
        $file = $data[$i];
        if ($file->getError() === UPLOAD_ERR_OK) {
          $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
          $filename = sprintf('d%s.%0.8s', pathinfo($file->getClientFilename(), PATHINFO_FILENAME), $extension);
          $file->moveTo($ruta . DIRECTORY_SEPARATOR . $filename);
          $mapper->updateActividadAlumno($idAlumno, $idActividadProgramada);
        }
      }

      $mapper = new ActividadProgramadaMapper($this->db);
      $actividades = $mapper->getActividadesByAlumno($idAlumno);

      $res = [
        'success' => true,
        'mensaje' => $ruta, //'Arvhicos Subidos',
        'destino' => 'p',
        'actividades' => $actividades
      ];
    } else
      $res = [
        'success' => false,
        'mensaje' => 'Token de sesion no valido.',
        'destino' => 'p'
      ];

    return $response->withJson($res, 200);
  } catch (Exception $e) {
    return $response->withJson($e->getMessage(), 200);
  }
});
$app->run();
