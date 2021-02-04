<?php
class DiagnosticoMapper extends Mapper
{
	public function getDiagnostico()
	{
		$sql = "SELECT *
            FROM diagnostico WHERE estatus = 'a'";

		$stmt = $this->db->query($sql);

		$results = [];
		while ($row = $stmt->fetch()) {
			$results[] = new DiagnosticoEntity($row);
		}

		return $results;
	}

	public function getDiagnosticoById($id)
	{
		$sql = "SELECT *
            FROM diagnostico WHERE idDiagnostico = :idDiagnostico";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(":idDiagnostico", $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$results = [];
			$results = $stmt->fetch();

			if (!empty($results))
				return new DiagnosticoEntity($results);
		}
	}
}
