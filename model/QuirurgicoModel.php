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


}




