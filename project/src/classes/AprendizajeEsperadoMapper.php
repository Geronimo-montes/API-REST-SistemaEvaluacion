<?php
class AprendizajeEsperadoMapper extends Mapper
{
  private function generarArray($data)
  {
    $array = [];
    foreach ($data as $row) {
      array_push($array, array(
        "idAprendizajeEsperado" => $row->getidAprendizajeEsperado(),
        "idAreaFormacion" => $row->getidAreaFormacion(),
        "descripcion" => $row->getdescripcion(),
        "estatus" => $row->getestatus(),
      ));
    }
    return $array;
  }

  public function getAprendizajeEsperado()
  {
    $sql = "SELECT *
    FROM aprendizajeesperado WHERE estatus = 'a'";

    $stmt = $this->db->query($sql);

    $results = [];
    while ($row = $stmt->fetch()) {
      $results[] = new AprendizajeEsperadoEntity($row);
    }

    return $this->generarArray($results);
  }

  public function getAprendizajeEsperadoByAreaFormacion($idAreaFormacion)
  {
    $sql = "SELECT *
    FROM aprendizajeesperado WHERE estatus = 'a' AND idAreaFormacion = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":id",  $idAreaFormacion, PDO::PARAM_INT);
    $results = [];
    if ($stmt->execute())
      while ($row = $stmt->fetch()) {
        $results[] = new aprendizajeesperadoEntity($row);
      }
    return $this->generarArray($results);
  }
}
