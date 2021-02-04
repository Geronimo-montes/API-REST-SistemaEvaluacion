<?php
class UsuarioMapper extends Mapper
{
  private function generarArray($data)
  {
    $array = [];
    foreach ($data as $usuario) {
      array_push($array, array(
        "idUsuario" => $usuario->getidUsuario(),
        "idDocente" => $usuario->getidDocente(),
        "idAlumno"  => $usuario->getidAlumno(),
        "rol" => $usuario->getrol(),
        "email" => $usuario->getemail(),
        "contraseña"  => $usuario->getcontraseña(),
        "token" => $usuario->gettoken(),
        "rutaPerfil"  => $usuario->getrutaPerfil(),
        "estatus" => $usuario->getestatus(),
      ));
    }
    return $array;
  }
  /**Funciones referetes a los usuarios*/
  public function logIn($data)
  {
    /** */
    $sql = "SELECT * FROM usuario WHERE email = :email AND contraseña = :password";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR, 80);
    $stmt->bindParam(":password", $data['password'], PDO::PARAM_STR, 20);
    $results = NULL;
    if ($stmt->execute())
      while ($row = $stmt->fetch())
        $results[] =  new UsuarioEntity($row);

    return $this->generarArray($results)[0];
  }

  public function getUsuario($id)
  {
    /** */
    $sql = "SELECT * FROM usuario WHERE idUsuario = :idUsuario";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':idUsuario', $id, PDO::PARAM_INT);
    $results = NULL;
    if ($stmt->execute())
      while ($row = $stmt->fetch())
        $results[] =  new UsuarioEntity($row);

    return $this->generarArray($results)[0];
  }

  public  function updateUserById($data)
  {
    $sql = "UPDATE usuario SET 
      email = :email,
      contraseña = :password 
      WHERE :idUsuario = idUsuario";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR, 80);
    $stmt->bindParam(":password", $data['password'], PDO::PARAM_STR, 20);
    $stmt->bindParam(":idUsuario",  $data['idUsuario'], PDO::PARAM_INT);
    $res = false;

    if ($stmt->execute())
      if ($stmt->rowCount() > 0)
        $res = !$res;

    return $res;
  }

  public function logOut($data)
  {
    $sql = "UPDATE usuario SET 
      token = :token
      WHERE (SELECT idUsuario WHERE  idDocente = :idDocente or idAlumno = :idAlumno) = idUsuario";


    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":token", NULL, PDO::PARAM_STR, 215);
    $stmt->bindParam(":idDocente",  $data['idDocente'], PDO::PARAM_INT);
    $stmt->bindParam(":idAlumno",  $data['idAlumno'], PDO::PARAM_STR, 50);
    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function insertToken($data)
  {
    /** */
    $sql = "UPDATE usuario SET 
      token = :token
      WHERE (SELECT idUsuario WHERE  idDocente = :idDocente or idAlumno = :idAlumno) = idUsuario";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":token",      $data['token'], PDO::PARAM_STR, 215);
    $stmt->bindParam(":idDocente",  $data['id'],    PDO::PARAM_INT);
    $stmt->bindParam(":idAlumno",  $data['idAlumno'], PDO::PARAM_STR, 50);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function validarToken($data)
  {
    $sql = "SELECT (
      (SELECT idAlumno FROM usuario WHERE idAlumno is not null AND token = :token) OR
      (SELECT idDocente FROM usuario WHERE idDocente is not null AND token = :token)
    ) AS id
     FROM usuario";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":token", $data, PDO::PARAM_STR, 215);
    if ($stmt->execute())
      if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch())
          $id = $row['id'];

        return ['success' => true, 'id' => $id];
      } else
        return ['success' => false, 'mensaje' => 'Token no valido'];


    return $res;
  }

  public function getRol($id)
  {
    /** */
    $sql = "SELECT rol FROM usuario 
          WHERE (SELECT idUsuario WHERE  idDocente = :idDocente or idAlumno = :idAlumno) = idUsuario";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":idDocente",  $id, PDO::PARAM_INT);
    $stmt->bindParam(":idAlumno",  $id, PDO::PARAM_STR, 50);

    $results = NULL;
    if ($stmt->execute())
      while ($row = $stmt->fetch())
        $results = $row['rol'];

    return $results;
  }
}
