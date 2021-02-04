<?php
class ActividadAlumnoMapper extends Mapper
{
	private function generarArray($data)
	{
		$array = [];
		foreach ($data as $actividad) {
			array_push($array, array(
				"idActividadProgramada" => $actividad->getidActividadProgramada(),
				"idAlumno" => $actividad->getidAlumno(),
				"idNivelDesempeno" => $actividad->getidNivelDesempeno(),
				"observacion" => $actividad->getobservacion(),
				"rutaEvidencia" => $actividad->getrutaEvidencia()
			));
		}
		return $array;
	}

	public function getActividadAlumno()
	{
		$sql = "SELECT * FROM actividadalumno";
		$stmt = $this->db->query($sql);
		$results = [];

		while ($row = $stmt->fetch()) {
			$results[] = new ActividadAlumnoEntity($row);
		}

		return $this->generarArray($results);
	}

	public function getActividadAlumnoById($id)
	{
		$sql = "SELECT * FROM actividadalumno WHERE idActividadProgramada = :idActividadProgramada";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				$results[] = new ActividadAlumnoEntity($row);
			}
			return $this->generarArray($results);
		}
	}

	public function getActividadAlumnoByIdAlumno($idAlumno, $id)
	{
		$sql = "SELECT * FROM actividadalumno 
                    WHERE idActividadProgramada = :idActividadProgramada
                    AND idAlumno = :idAlumno";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
		$stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				$results[] = new ActividadAlumnoEntity($row);
			}
			return $this->generarArray($results);
		}
	}

	public function updateActividadAlumno($idAlumno, $id)
	{
		$sql = "UPDATE actividadalumno SET
                estatus = 'b'
                WHERE idActividadProgramada = :idActividadProgramada AND idAlumno = :idAlumno
						";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
		$stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return true;
		}
	}

	public function insertActividadAlumno($data)
	{
		$sql = "INSERT INTO actividadalumno VALUES (
                :idActividadProgramada,
                :idAlumno,
                :nulo,
                '',
                :rutaEvidencia,
								'a'
                )
            ";

		$stmt = $this->db->prepare($sql);

		$idActividadProgramada = $data['actividad'];
		$idAlumno = $data['id'];
		$rutaEvidencia = $data['ruta'];

		$stmt->bindParam(":idActividadProgramada", $idActividadProgramada, PDO::PARAM_INT);
		$stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
		$stmt->bindParam(":nulo", null, PDO::PARAM_NULL);
		$stmt->bindParam(":rutaEvidencia", $rutaEvidencia, PDO::PARAM_STR, 300);

		if ($stmt->execute())
			return "exito en la insercion";
	}

	public function deleteActividadAlumno($data)
	{
		$sql = "DELETE FROM actividadalumno 
			WHERE idActividadProgramada = :idActividadProgramada
			AND idAlumno = :idAlumno";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idActividadProgramada", $data['idActividadProgramada'], PDO::PARAM_INT);
		$stmt->bindParam(":idAlumno", $data['idAlumno'], PDO::PARAM_INT);
		$stmt->execute();
	}
}
