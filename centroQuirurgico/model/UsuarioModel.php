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

    public function verificarSiHayUnaSessionIniciada($session){
        return isset($session) ? $session : null;
    }

    public function verificarRolUsuario($idUsuario) {
        $query = "SELECT rol FROM persona WHERE matricula = $idUsuario";
        $result = $this->database->query($query);
        return !empty($result) ? $result[0]['rol'] : null;

    }

    public function obtenerUsuario($matricula){
        $query = "SELECT id FROM persona WHERE matricula = $matricula";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
    }


}