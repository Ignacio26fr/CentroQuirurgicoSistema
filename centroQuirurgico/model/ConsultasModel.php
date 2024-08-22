<?php

class ConsultasModel
{

    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }



    public function mandarConsulta($comment, $idUser, $fecha)
    {
        $query = "INSERT INTO comentarios (comment, idUser, fecha) VALUES ('$comment', $idUser, '$fecha')";

        $this->database->execute($query);

        return true;

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
        $result = $this->database->query($query);

        return $result[0]['id'];
    }

}