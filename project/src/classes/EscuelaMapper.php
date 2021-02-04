<?php
class EscuelaMapper extends Mapper
{
	private function generarArray($data)
	{
		$array = [];
		foreach ($data as $escuela) {
			array_push($array, array(
				"idEscuela" => $escuela->getidEscuela(),
				"nombre" => $escuela->getnombre(),
				"clave" => $escuela->getclave(),
				"zonaEscolar" => $escuela->getzonaEscolar(),
				"sector" => $escuela->getsector(),
				"direccion" => $escuela->getdireccion(),
				"telefono" => $escuela->gettelefono()
			));
		}
		return $array;
	}

	public function getEscuelaById($id)
	{
		$sql = "SELECT * FROM escuela WHERE idEscuela = :idEscuela";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idEscuela", $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				$results[] = new EscuelaEntity($row);
			}

			return $this->generarArray($results);
		}
	}
}
