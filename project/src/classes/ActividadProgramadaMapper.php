<?php
class ActividadProgramadaMapper extends Mapper
{
	private function generarArray($data)
	{
		$array = [];
		foreach ($data as $actividad) {
			array_push($array, array(
				"idActividadProgramada" => $actividad->getidActividadProgramada(),
				"idPlanTrabajo" => $actividad->getidPlanTrabajo(),
				"idNivelDesempeno" => $actividad->getidNivelDesempeno(),
				"idPeriodoEvaluacion" => $actividad->getidPeriodoEvaluacion(),
				"idCicloEscolar" => $actividad->getidCicloEscolar(),
				"nivelDesempenoPonderado" => $actividad->getnivelDesempenoPonderado(),
				"observacion" => $actividad->getobservacion(),
				"fecha" => $actividad->getfecha(),
				"estatus" => $actividad->getestatus()
			));
		}
		return $array;
	}
	//***Terminada */
	public function getActividadProgramada()
	{
		$sql = "SELECT 
		ap.idActividadProgramada,
		ap.idPlanTrabajo,
		pt.nombre AS nombrePlanTrabajo,
		pt.duracionMinutos,
		ap.idNivelDesempeno,
		nd.nombre AS nombreNivelDesempeno,
		ap.idPeriodoEvaluacion,
		pe.nombre AS nombrePeriodoEvaluacion,
		ap.idCicloEscolar,
		ce.nombre AS nombreCicloEscolar,
		ap.nivelDesempenoPonderado,
		ap.observacion,
		ap.fecha,
		ap.hora,
		ap.estatus
		
		FROM actividadprogramada AS ap
		JOIN plantrabajo AS pt ON pt.idPlanTrabajo = ap.idPlanTrabajo
		JOIN niveldesempeno AS nd ON nd.idNivelDesempeno = ap.idNivelDesempeno
		JOIN periodoevaluacion AS pe ON pe.idPeriodoEvaluacion = ap.idPeriodoEvaluacion
		JOIN cicloescolar AS ce ON ce.idCicloEscolar = ap.idCicloEscolar
		
		WHERE  ADDTIME(fecha, hora) > NOW()
		ORDER BY ap.fecha, ap.hora";

		$stmt = $this->db->query($sql);
		$results = [];
		while ($row = $stmt->fetch()) {
			array_push($results, array(
				"idActividadProgramada" => $row["idActividadProgramada"],
				"idPlanTrabajo" => $row["idPlanTrabajo"],
				"nombrePlanTrabajo" => $row["nombrePlanTrabajo"],
				"duracionMinutos" => $row["duracionMinutos"],
				"idNivelDesempeno" => $row["idNivelDesempeno"],
				"nombreNivelDesempeno" => $row["nombreNivelDesempeno"],
				"idPeriodoEvaluacion" => $row["idPeriodoEvaluacion"],
				"nombrePeriodoEvaluacion" => $row["nombrePeriodoEvaluacion"],
				"idCicloEscolar" => $row["idCicloEscolar"],
				"nombreCicloEscolar" => $row["nombreCicloEscolar"],
				"nivelDesempenoPonderado" => $row["nivelDesempenoPonderado"],
				"observacion" => $row["observacion"],
				"fecha" => $row["fecha"],
				"hora" => $row["hora"],
				"estatus" => $row["estatus"],
			));
		}
		return $results;
	}
	/**Terminada */
	public function updateActividadProgramada(ActividadProgramadaEntity $actividad)
	{
		try {
			$sql = "UPDATE actividadprogramada SET
                fecha = :fecha,
                hora = :hora
                WHERE idActividadProgramada = :idActividadProgramada;
            ";

			$stmt = $this->db->prepare($sql);
			$idActividadProgramada = $actividad->getidActividadProgramada();
			$fecha = $actividad->getfecha();
			$hora = $actividad->gethora();

			$stmt->bindParam(":idActividadProgramada", $idActividadProgramada, PDO::PARAM_INT);
			$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR, 10);
			$stmt->bindParam(":hora", $hora, PDO::PARAM_STR, 8);
			if ($stmt->execute())
				return 't';
			throw new Exception('f');
			//code...
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	/***Terminada */
	public function insertActividadProgramada(ActividadProgramadaEntity $actividad)
	{
		$sql = "INSERT INTO actividadprogramada (
			idPlanTrabajo, idNivelDesempeno, idPeriodoEvaluacion, idCicloEscolar, fecha, hora, estatus) 
			VALUES (
					:idPlanTrabajo,
					1,
					1,
					(SELECT idCicloEscolar from cicloescolar WHERE estatus = 'a'),
					:fecha,
					:hora,
					'a'
			)";

		$stmt = $this->db->prepare($sql);

		$idPlanTrabajo = $actividad->getidPlanTrabajo();
		$fecha = $actividad->getfecha();
		$hora = $actividad->gethora();

		$stmt->bindParam(":idPlanTrabajo", $idPlanTrabajo, PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR, 10);
		$stmt->bindParam(":hora", $hora, PDO::PARAM_STR, 8);
		$stmt->execute();

		$sql = 'SELECT LAST_INSERT_ID() as id';
		$stmt = $this->db->query($sql);
		$id = $stmt->fetch();
		return $id['id'];
	}
	/***Terminada */
	public function deleteActividadProgramada($id)
	{
		$sql = "DELETE FROM actividadprogramada 
			WHERE idActividadProgramada = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		if ($stmt->execute())
			return 't';
		else
			return 'f';
	}

	public function getActividadesByAlumno($id)
	{
		$sql = "SELECT
		ap.idActividadProgramada id,
		pt.nombre nombre, 
		ADDTIME(ap.fecha, ap.hora) fechainicio, 
		DATE_ADD(ADDTIME(ap.fecha, ap.hora), INTERVAL pt.duracionMinutos MINUTE) fechatermino , 
		pt.duracionMinutos duracion
		FROM actividadalumno AS aa
		JOIN actividadprogramada AS ap ON ap.idActividadProgramada = aa.idActividadProgramada
		JOIN plantrabajo AS pt ON pt.idPlanTrabajo = ap.idPlanTrabajo
		WHERE aa.idAlumno = :idAlumno AND ADDTIME(ap.fecha, ap.hora) >= now() AND aa.estatus = 'a'";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idAlumno", $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				array_push($results, array(
					"idActividadProgramada"    => $row['id'],
					"nombre"    => $row['nombre'],
					"fechainicio"     => $row['fechainicio'],
					"fechatermino"     => $row['fechatermino'],
					"duracion"  => $row['duracion'],
				));
			}
			return $results;
		}
	}


	public function getActividadAlumnoById($id)
	{
		try {
			$actividad = "SELECT
			DISTINCT ap.idActividadProgramada id,
			aa.idAlumno idAlumno,
			pt.nombre nombre, 
			ADDTIME(ap.fecha, ap.hora) fechainicio, 
			DATE_ADD(ADDTIME(ap.fecha, ap.hora), INTERVAL pt.duracionMinutos MINUTE) fechatermino , 
			pt.duracionMinutos duracion,
			pt.recursos recursos
			FROM actividadalumno AS aa
			JOIN actividadprogramada AS ap ON ap.idActividadProgramada = aa.idActividadProgramada
			JOIN plantrabajo AS pt ON pt.idPlanTrabajo = ap.idPlanTrabajo
			WHERE aa.idActividadProgramada = :idActividadProgramada AND ADDTIME(ap.fecha, ap.hora) >= now() AND aa.estatus = 'a'";

			$aprendizajes = "SELECT 
			DISTINCT ae.idAprendizajeEsperado idAprendizajeEsperado,
			ae.idAreaFormacion idAreaFormacion,
			ae.descripcion descripcion,
			ae.estatus estatus
			
			FROM actividadalumno AS aa
			JOIN actividadprogramada AS ap ON ap.idActividadProgramada = aa.idActividadProgramada
			JOIN plantrabajo_aprendizajeesperado AS ptae ON ptae.idPlanTrabajo = ap.idPlanTrabajo
			JOIN aprendizajeesperado AS ae ON ae.idAprendizajeEsperado = ptae.idAprendizajeEsperado
			WHERE aa.idActividadProgramada = :idActividadProgramada AND ADDTIME(ap.fecha, ap.hora) >= now() AND aa.estatus = 'a'";

			$evidencia = "SELECT 
			DISTINCT e.idEvidencia idEvidencia,
			e.nombreEvidencia nombreEvidencia,
			e.descripcion descripcion,
			e.idFormato idFormato
			
			FROM actividadalumno AS aa
			JOIN actividadprogramada AS ap ON ap.idActividadProgramada = aa.idActividadProgramada
			JOIN plantrabajo_aprendizajeesperado AS ptae ON ptae.idPlanTrabajo = ap.idPlanTrabajo
			JOIN evidencias AS e ON e.idPlanTrabajo = ptae.idPlanTrabajo
			WHERE aa.idActividadProgramada = :idActividadProgramada AND ADDTIME(ap.fecha, ap.hora) >= now() AND aa.estatus = 'a'";

			$this->db->beginTransaction();

			$stmt = $this->db->prepare($aprendizajes);
			$stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
			$arrayAprendizaje = [];
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				array_push($arrayAprendizaje, array(
					"idAprendizajeEsperado"		=> $row['idAprendizajeEsperado'],
					"idAreaFormacion"					=> $row['idAreaFormacion'],
					"descripcion"							=> $row['descripcion'],
					"estatus"									=> $row['estatus'],
				));
			}

			$stmt = $this->db->prepare($evidencia);
			$stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
			$arrayEvidencia = [];
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				array_push($arrayEvidencia, array(
					"idEvidencia"			=> $row['idEvidencia'],
					"nombreEvidencia"	=> $row['nombreEvidencia'],
					"descripcion"			=> $row['descripcion'],
					"idFormato"				=> $row['idFormato'],
				));
			}

			$stmt = $this->db->prepare($actividad);
			$stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);
			$results = [];
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				array_push($results, array(
					"idActividadProgramada" => $row['id'],
					"idAlumno"							=> $row['idAlumno'],
					"nombre"								=> $row['nombre'],
					"fechainicio"						=> $row['fechainicio'],
					"fechatermino"					=> $row['fechatermino'],
					"duracion"							=> $row['duracion'],
					"recursos"							=> $row['recursos'],
					"evidencia"							=> $arrayEvidencia,
					"aprendizaje"						=> $arrayAprendizaje,
				));
			}
			$this->db->commit();
			return $results[0];
		} catch (PDOException $e) {
			if (stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
				$this->db->commit();
				usleep(250000);
			} else {
				$this->db->rollBack();
				throw new Exception($e->getMessage(), 1);
			}
		}
	}



	public function getActividadProgramadaById($id)
	{
		$sql = "SELECT * FROM actividadprogramada WHERE idActividadProgramada = :idActividadProgramada";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				$results[] = new ActividadProgramadaEntity($row);
			}

			return $this->generarArray($results);
		}
	}

	public function getActividadProgramadaByPeriodo($periodo)
	{
		$sql = "SELECT * FROM actividadprogramada WHERE idPeriodoEvaluacion = :idPeriodoEvaluacion";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idPeriodoEvaluacion", $periodo, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				$results[] = new ActividadProgramadaEntity($row);
			}

			return $this->generarArray($results);
		}
	}

	public function getActividadProgramadaByEstatus($estatus)
	{
		$sql = "SELECT * FROM actividadprogramada WHERE estatus = :estatus";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 1);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				$results[] = new ActividadProgramadaEntity($row);
			}

			return $this->generarArray($results);
		}
	}

	public function getActividadProgramadaByPeriodoEstatus($periodo, $estatus)
	{
		$sql = "SELECT * FROM actividadprogramada WHERE estatus = :estatus AND idPeriodoEvaluacion = :idPeriodoEvaluacion";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":estatus", $estatus, PDO::PARAM_STR, 1);
		$stmt->bindParam(":idPeriodoEvaluacion", $periodo, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			while ($row = $stmt->fetch()) {
				$results[] = new ActividadProgramadaEntity($row);
			}

			return $this->generarArray($results);
		}
	}
}
