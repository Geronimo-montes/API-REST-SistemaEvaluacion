<?php 
    class CicloEscolarMapper extends Mapper {
        private function generarArray ($data){
            $array = [];
            foreach ($data as $row) {
                array_push($array, array(
                    "idCicloEscolar" => $row->getidCicloEscolar(),
                    "inicioCiclo" => $row->getinicioCiclo(),
                    "finCiclo" => $row->getfinCiclo(),
                    "diasHabiles" => $row->getdiasHabiles(),
                    "estatus" => $row->getestatus()
                ));
            }
            return $array;
        }

        public function getCicloEscolarByEstatus (){
            $sql = "SELECT * FROM cicloEscolar WHERE estatus = 'a'";
            $stmt = $this->db->query($sql);
            $results = [];
            while ($row = $stmt->fetch()){
                $results[] = new CicloEscolarEntity($row);
            }

            return $this->generarArray( $results );
        }

        public function insertCicloEscolar (CicloEscolarEntity $ciclo) {
            $sql = "INSERT INTO cicloEscolar (inicioCiclo, finCiclo, diasHabiles, estatus) VALUES (
                :inicioCiclo,
                :finCiclo,
                :diasHabiles,
                'a'
            )";

            $stmt = $this->db->prepare($sql);

            $inicioCiclo = $ciclo->getinicioCiclo();
            $finCiclo = $ciclo->getfinCiclo();
            $diasHabiles = $ciclo->getdiasHabiles();   
            
            $stmt->bindParam(":inicioCiclo", $inicioCiclo, PDO::PARAM_STR, 10);
            $stmt->bindParam(":finCiclo", $finCiclo, PDO::PARAM_STR, 10);
            $stmt->bindParam(":diasHabiles", $diasHabiles, PDO::PARAM_INT);
            
            if($stmt->execute()){
                $sql = "SELECT MAX(idCicloEscolar) AS id FROM cicloEscolar";
                $stmt = $this->db->query($sql);
                while ($row = $stmt->fetch()){
                    $id = $row['id'];
                }

                $sql = "UPDATE cicloEscolar SET estatus = 'b' WHERE idCicloEscolar != :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);

                if($stmt->execute()){
                    return "exito en la insercion";
                }
            }
        }

    }
?>