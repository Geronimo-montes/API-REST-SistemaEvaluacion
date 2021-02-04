<?php
class UsuarioEntity
{
  protected $idUsuario;
  protected $idDocente;
  protected $idAlumno;
  protected $rol;
  protected $email;
  protected $contraseña;
  protected $token;
  protected $rutaPerfil;
  protected $estatus;

  public function __construct(array $data)
  {
    (isset($data['idUsuario'])) ? $this->idUsuario = $data['idUsuario'] : $this->idUsuario = NULL;
    (isset($data['idDocente'])) ? $this->idDocente = $data['idDocente'] : $this->idDocente = NULL;
    (isset($data['idAlumno'])) ? $this->idAlumno = $data['idAlumno'] : $this->idAlumno = NULL;
    (isset($data['rol'])) ? $this->rol = $data['rol'] : $this->rol = NULL;
    (isset($data['email'])) ? $this->email = $data['email'] : $this->email = NULL;
    (isset($data['contraseña'])) ? $this->contraseña = $data['contraseña'] : $this->contraseña = NULL;
    (isset($data['token'])) ? $this->token = $data['token'] : $this->token = NULL;
    (isset($data['rutaPerfil'])) ? $this->rutaPerfil = $data['rutaPerfil'] : $this->rutaPerfil = NULL;
    (isset($data['estatus'])) ? $this->estatus = $data['estatus'] : $this->estatus = NULL;
  }

  public function getidUsuario()
  {
    return $this->idUsuario;
  }
  public function getidDocente()
  {
    return $this->idDocente;
  }
  public function getidAlumno()
  {
    return $this->idAlumno;
  }
  public function getrol()
  {
    return $this->rol;
  }
  public function getemail()
  {
    return $this->email;
  }
  public function getcontraseña()
  {
    return $this->contraseña;
  }
  public function gettoken()
  {
    return $this->token;
  }
  public function getrutaPerfil()
  {
    return $this->rutaPerfil;
  }
  public function getestatus()
  {
    return $this->estatus;
  }
}
