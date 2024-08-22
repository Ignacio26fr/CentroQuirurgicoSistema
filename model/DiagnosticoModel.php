<?php

class DiagnosticoModel
{
    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerDiagnosticos()
    {
        $query = "SELECT * FROM diagnostico";
        $resultado = $this->database->query($query);
        return $resultado;
    }

    public function nuevoDiagnostico($nombre)
    {
        $query = "INSERT INTO diagnostico (nombre) VALUES('$nombre')";
      $this->database->execute($query);

    }

    public function verificarSiExisteUnDiagnosticoConEseNombre($nombre)
    {

        $query = "SELECT * FROM diagnostico where nombre ='$nombre'";
        $resultado = $this->database->executeAndReturn($query);
        if ($resultado && $resultado->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        return false;
    }

    public function buscarDiagnosticoPorNombre($nombre)
    {
        $query = "SELECT * FROM diagnostico where nombre like '%$nombre%'";
        $resultado = $this->database->executeAndReturn($query);
        return $resultado;
    }

    public function obtenerDiagnosticoPorId($id)
    {
        $query = "SELECT * FROM diagnostico where id = $id";
        $resultado = $this->database->executeAndReturn($query);
        return $resultado;
    }
    public function updateDiagnostico($id, $nombre)
    {
        $query = "UPDATE diagnostico SET nombre = '$nombre' WHERE id = $id";
        $this->database->execute($query);

    }

    public function eliminarDiagnostico($id)
    {
        $query = "DELETE FROM diagnostico WHERE id = $id";
        $this->database->execute($query);
    }


}