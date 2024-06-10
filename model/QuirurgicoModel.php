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


    public function obtenerPrimario()
    {

        $query = "SELECT * FROM diagnostico";

        return $this->database->executeAndReturn($query);
    }

    public function obtenerEspecialidadQuirurgica()
    {
        $query = "SELECT * FROM espquirurgica";
        return $this->database->executeAndReturn($query);
    }

    public function obtenerDiagnosticoSecu($filtro) {
        $query = "SELECT * FROM diagnostico WHERE nombre LIKE '%$filtro%'";
        $resultados = $this->database->executeAndReturn($query);

        $diagnosticos = array();
        while ($row = $resultados->fetch_assoc()) {
            $diagnostico = array(
                'id' => $row['IdDiagnostico'],
                'nombre' => $row['nombre']
            );
            $diagnosticos[] = $diagnostico;
        }

        return $diagnosticos;
    }

    public function obtenerDiagnosticoPrimario($filtro) {
        $query = "SELECT * FROM diagnostico WHERE nombre LIKE '%$filtro%'";
        $resultados = $this->database->executeAndReturn($query);

        $diagnosticos = array();
        while ($row = $resultados->fetch_assoc()) {
            $diagnostico = array(
                'id' => $row['IdDiagnostico'],
                'nombre' => $row['nombre']
            );
            $diagnosticos[] = $diagnostico;
        }

        return $diagnosticos;
    }

    public function obtenerUnidadesFuncionales($idEspQuirurgica)
    {
        $query = "SELECT * FROM unidadFuncional where idEspQuirurgico = $idEspQuirurgica";
        $resultados = $this->database->executeAndReturn($query);

        $unidadesFuncionales = array();
        while ($row = $resultados->fetch_assoc()) {
            $unidadFuncional = array(
                'id' => $row['idUnidadFuncional'],
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
                'id' => $row['idSitioAnatomico'],
                'nombre' => $row['nombre']
            );
            $sitiosAnatomicos[] = $sitioAnatomico;
        }
        return $sitiosAnatomicos;
    }

}




