<?php
class ComentarioMapper extends Mapper
{
  public function getComentarios($id, $alumno)
  {
    try {
      $sql = "SELECT 
          comentario.idComentario idComentario,
          comentario.idActividadProgramada idActividadProgramada,
          IF(ISNULL(comentario.idDocente), alumno.nombre, '') nombre,
          comentario.comentario comentario,
          comentario.fecha fecha
          FROM comentario
          JOIN alumno ON alumno.idAlumno = comentario.idAlumno
          WHERE comentario.idActividadProgramada = :idActividadProgramada 
          AND comentario.idAlumno = :idAlumno
        UNION
        SELECT 
          comentario.idComentario idComentario,
          comentario.idActividadProgramada idActividadProgramada,
          IF(ISNULL(comentario.idDocente), '', docente.nombre) nombre,
          comentario.comentario comentario,
          comentario.fecha fecha
          FROM comentario 
          JOIN docente ON docente.idDocente = comentario.idDocente
          WHERE comentario.idActividadProgramada = :idActividadProgramada 
          AND comentario.idDocente = :idAlumno";

      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
      $stmt->bindParam(":idAlumno", $alumno, PDO::PARAM_STR, 50);

      $stmt->execute();
      $results = [];
      while ($row = $stmt->fetch()) {
        array_push($results, array(
          "idComentario" => $row['idComentario'],
          "idActividadProgramada" => $row['idActividadProgramada'],
          "nombre" => $row['nombre'],
          "comentario" => $row['comentario'],
          "fecha" => $row['fecha'],
        ));
      }
      return $results;
    } catch (PDOException $e) {
      throw new Exception($e->getMessage(), 1);
    }
  }

  public function insertComentario($data)
  {
    $sql = "INSERT INTO comentario (idActividadProgramada, idAlumno, idDocente, comentario)
    VALUES (:idActividadProgramada, :idAlumno, :idDocente, :comentario)";
    $stmt = $this->db->prepare($sql);

    $stmt->bindParam(":idActividadProgramada", $data['idActividadProgramada'], PDO::PARAM_INT);
    $stmt->bindParam(":idAlumno", $data['idAlumno'], PDO::PARAM_STR, 50);
    $stmt->bindParam(":idDocente", $data['idDocente'], PDO::PARAM_INT);
    $stmt->bindParam(":comentario", $data['comentario'], PDO::PARAM_STR, 300);

    if ($stmt->execute()) {
      return $this->getComentarios($data['idActividadProgramada'], $data['idAlumno']);
    }
  }
}
