<?php

class OpcionesModel
{


    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function verificarSiHayUnaSessionIniciada($session){
        return isset($session) ? $session : null;
    }

    public function verificarRolUsuario($idUsuario) {
        $query = "SELECT rol FROM persona WHERE matricula = $idUsuario";
        $result = $this->database->query($query);
        return !empty($result) ? $result[0]['rol'] : null;

    }

}