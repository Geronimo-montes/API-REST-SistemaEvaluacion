<?php
class AreaFormacionMapper extends Mapper
{
  private function generarArray($data)
  {
    $array = [];
    foreach ($data as $row) {
      array_push($array, array(
        "idAreaFormacion" => $row->getidAreaFormacion(),
        "descripcion" => $row->getdescripcion(),
        "estatus" => $row->getestatus(),
      ));
    }
    return $array;
  }

  public function getAreaFormacion()
  {
    $sql = "SELECT *
    FROM areaformacion WHERE estatus = 'a'";
    $stmt = $this->db->query($sql);
    $results = [];
    while ($row = $stmt->fetch()) {
      $results[] = new AreaFormacionEntity($row);
    }

    return $this->generarArray($results);
  }

  public function getAreaFormacionById($id)
  {
    $sql = "SELECT *
    FROM areaformacion 
    WHERE estatus = 'a' 
    AND idAreaFormacion = :idAreaFormacion";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":idAreaFormacion", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      $results = [];
      while ($row = $stmt->fetch()) {
        $results[] = new AreaFormacionEntity($row);
      }
    }

    return $this->generarArray($results);
  }
}
