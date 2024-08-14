<?php

class ActoQuirurgicoModel {

    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function obtenerActosQuirurgicos()
    {
        $query = "select * from nombreCirugia";

    }

    public function obtenerEspQuirurgicas()
    {
        $query = "select * from especialidadquirurgica";
       $result = $this->database->query($query);
       return $result;
    }

    public function obtenerUnidadesFuncionales($idEspQuirurgica)
    {
        $query = "SELECT * FROM unidadFuncional where idEspQuirurgica = $idEspQuirurgica";
        $resultados = $this->database->executeAndReturn($query);

        $unidadesFuncionales = array();
        while ($row = $resultados->fetch_assoc()) {
            $unidadFuncional = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $unidadesFuncionales[] = $unidadFuncional;
        }
        return $unidadesFuncionales;

    }

    public function obtenerSitiosAnatomicos($idUnidadFuncional)
    {
        $query = "SELECT * from sitioanatomico where idUnidadFuncional = $idUnidadFuncional";
        $resultados = $this->database->executeAndReturn($query);

        $sitiosAnatomicos = array();
        while ($row = $resultados->fetch_assoc()) {
            $sitioAnatomico = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $sitiosAnatomicos[] = $sitioAnatomico;
        }
        return $sitiosAnatomicos;
    }

}