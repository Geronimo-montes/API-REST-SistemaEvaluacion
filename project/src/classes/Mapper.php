<?php 
    abstract class Mapper{
        protected $db; //Contiene la conexion con la base de datos

        public function __construct ( $db ) 
        {
            $this->db = $db;
        }
    }
?>