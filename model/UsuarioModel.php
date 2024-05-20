<?php

class UsuarioModel{

    private $database;
    

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuario()
    {
        return $this->database->query("Select * from persona");

    }


}