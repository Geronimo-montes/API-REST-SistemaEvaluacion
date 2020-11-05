<?php 
    class CuadorHonorMapper extends Mapper{
        private function generarArray ($data){
            $array = [];
            foreach ($data as $cuadroHonor) {
                array_push($array, array(
                    "idCuadroHonor" => $cuadroHonor->getidCuadroHonor(),
                    "idAlumno" => $cuadroHonor->getidAlumno(),
                    "idActividadProgramada" => $cuadroHonor->getidActividadProgramada()
                ));
            }
            return $array;
        }

        public function getCuadroHonorByActividad($id){
            $sql = "SELECT * FROM cuadroHonor WHERE idActividadProgramada = :idActividadProgramada";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idActividadProgramada", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){ $results[] = new CuadroHonorEntity($row); }
                return $this->generarArray( $results );
            }
        }

        public function getCuadroHonorByAlumno($id){
            $sql = "SELECT * FROM cuadroHonor WHERE idAlumno = :idAlumno";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idAlumno", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $results = [];
                while ($row = $stmt->fetch()){ $results[] = new CuadroHonorEntity($row); }
                return $this->generarArray( $results );
            }
        }

        public function insertEvidencia(EvidenciaEntity $evidencia){
            $sql = "INSERT INTO cuadroHonor (idAlumno, idActividadProgramada) VALUES (:idAlumno, :idActividadProgramada)";

            $idAlumno = $evidencia->getidAlumno();
            $idActividadProgramada = $evidencia->getidActividadProgramada();
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":idActividadProgramada", $idActividadProgramada, PDO::PARAM_INT);

            if($stmt->execute()){
                return "exito en la insercion";
            }
        }
    }
?>