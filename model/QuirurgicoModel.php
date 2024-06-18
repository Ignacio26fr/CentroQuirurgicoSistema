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

    public function obtenerActosQuirurgicos($idSitioAnatomico)
    {
        $query = "SELECT * FROM cirugianombre where idSitioAnatomico = $idSitioAnatomico";
        $resultados = $this->database->executeAndReturn($query);

        $actosQuirurgicos = array();
        while ($row = $resultados->fetch_assoc()) {
            $actoQuirurgico = array(
                'id' => $row['idCirugiaNombre'],
                'nombre' => $row['nombre']
            );
            $actosQuirurgicos[] = $actoQuirurgico;
        }
        return $actosQuirurgicos;
    }

    public function obtenerCirujanos($filtroCirujano)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtroCirujano%' or apellido LIKE '%$filtroCirujano%' or matricula LIKE '%$filtroCirujano%') and idEspecialidad = 2 ";
        $resultados =  $this->database->executeAndReturn($query);

        $cirujanos = array();
        while ($row = $resultados->fetch_assoc()) {
            $cirujano = array(
                'id' => $row['idPersona'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $cirujanos[] = $cirujano;
        }
        return $cirujanos;
    }

    public function obtenerAnestesista($filtro)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtro%' or apellido LIKE '%$filtro%' or matricula LIKE '%$filtro%') and idEspecialidad = 5 ";
        $resultados =  $this->database->executeAndReturn($query);

        $anestesistas = array();
        while ($row = $resultados->fetch_assoc()) {
            $anestesista = array(
                'id' => $row['idPersona'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $anestesistas[] = $anestesista;
        }
        return $anestesistas;
    }

    public function obtenerNeo($filtro)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtro%' or apellido LIKE '%$filtro%' or matricula LIKE '%$filtro%') and idEspecialidad = 3 ";
        $resultados =  $this->database->executeAndReturn($query);

        $neonatologos = array();
        while ($row = $resultados->fetch_assoc()) {
            $neonatologo = array(
                'id' => $row['idPersona'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $neonatologos[] = $neonatologo;
        }
        return $neonatologos;
    }

    public function obtenerTecnico($filtro)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtro%' or apellido LIKE '%$filtro%' or matricula LIKE '%$filtro%') and idEspecialidad = 1 ";
        $resultados =  $this->database->executeAndReturn($query);

        $tecnicos = array();
        while ($row = $resultados->fetch_assoc()) {
            $tecnico = array(
                'id' => $row['idPersona'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $tecnicos[] = $tecnico;
        }
        return $tecnicos;
    }

    public function obtenerTipoAnestesia()
    {
        $query = "SELECT * FROM tipodeanestesia";
        return $this->database->executeAndReturn($query);
    }

    public function obtenerLugar()
    {
        $query = "SELECT * FROM lugar";
        return $this->database->executeAndReturn($query);
    }

    public function obtnerCajaQuirurgica($filtro)
    {
        $query = "Select * from cajaquirurgica where nombre like '%$filtro%'";
        $resultado = $this->database->executeAndReturn($query);

        $cajas = array();
        while ($row = $resultado->fetch_assoc()) {
            $caja = array(
                'id' => $row['idCajaQuirurgica'],
                'nombre' => $row['nombre']
            );
            $cajas[] = $caja;
        }

        return $cajas;
    }

    public function obtenerCodigos($filtro)
    {
        $query = "Select * from codigopractica where nombre like '%$filtro%'";
        $resultado = $this->database->executeAndReturn($query);

        $codigos = array();
        while($row = $resultado->fetch_assoc()) {
            $codigo = array(
                'id' => $row['idCodigoPractica'],
                'nombre' => $row['nombre']
            );
            $codigos[] = $codigo;
        }
        return $codigos;

    }

    public function obtenerTipoDeCirugia()
    {
        $query = "SELECT * FROM tipocirugia";
        return $this->database->executeAndReturn($query);
    }

    public function obtenerMaterial($filtro)
    {
        $query = "Select * from materialprotesico where nombre like '%$filtro%'";
        $resultado = $this->database->executeAndReturn($query);

        $materiales = array();
        while($row = $resultado->fetch_assoc()) {
            $material = array(
                'id' => $row['idMaterialProtesico'],
                'nombre' => $row['nombre']
            );
            $materiales[] = $material;
        }
        return $materiales;

    }

    public function obtenerTecnologiaUsada()
    {
        $query = "SELECT * FROM tecnologiausada";
        return $this->database->executeAndReturn($query);
    }
}




