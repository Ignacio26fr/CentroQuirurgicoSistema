<?php

class QuirurgicoModel
{


    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPaciente()
    {
        return $this->database->query("Select * from paciente");

    }

    public function buscarPaciente($dni)
    {

        $query = "SELECT * FROM paciente where dni = '$dni'";

        return $this->database->executeAndReturn($query);

    }


    public function obtenerPrimario($nombre)
    {

        $query = "SELECT * FROM diagnostico where LOWER(nombre) LIKE LOWER('%$nombre%')";

        return $this->database->executeAndReturn($query);
    }


}




