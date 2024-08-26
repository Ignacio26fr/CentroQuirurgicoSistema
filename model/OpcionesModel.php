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
    public function getConsultas()
    {
        $query = "SELECT c.id as idComentario, c.comment, u.nombre AS nombreUsuario, u.apellido, u.matricula, c.fecha
              FROM comentarios c
              INNER JOIN persona u ON c.idUser = u.id
              ORDER BY c.fecha DESC";

        $resultado = $this->database->query($query);
        return $resultado;

    }
    public function eliminarComentario($idComentario)
    {
        $query = "DELETE FROM comentarios WHERE id = $idComentario";
        $this->database->executeAndReturn($query);

    }

}