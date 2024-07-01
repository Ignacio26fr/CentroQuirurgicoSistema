<?php

class EstadisticasController
{

    private $model;
    private $presenter;


    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function get()
    {
        $this->presenter->render("view/estadisticas.mustache");
    }

    public function obtenerDatos()
    {
        if (isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])) {
            $fechaInicio = $_POST['fechaDesde'];
            $fechaFin = $_POST['fechaHasta'];

            $resultados = $this->model->obtenerCirugias($fechaInicio, $fechaFin);



            $idsCirugias = [];
            $idsPaciente = [];
            $idsUnidadFuncional = [];
            foreach ($resultados as $cirugia) {
                $idsCirugias[] = $cirugia['id'];
                $idsPaciente[] = $cirugia['idPaciente'];
                $idsUnidadFuncional[] = $cirugia['idUnidadFuncional'];
            }


            $idsDiagnosticos = [];
            $idsSecundario = [];
            foreach ($idsCirugias as $idCirugia){
                $diagPrimario = $this->model->obtenerDiagnosticoPrimario($idCirugia);
                $diagSecundario = $this->model->obtenerDiagnosticoSecundario($idCirugia);
                $idsDiagnosticos[$idCirugia] = $diagPrimario;
                $idsSecundario[$idCirugia] = $diagSecundario;
            }


            list($especialidad, $especialidades) = $this->obtenerEspQuirurgica($idsUnidadFuncional);
            list($pacientes, $paciente) = $this->obtenerPaciente($idsPaciente);
            list($cirujanosDo, $idCirugia, $cirujano) = $this->obtenerCirujanos($idsCirugias);
            list($anestesistasDo, $idCirugia, $anestesista) = $this->obtenerAnestesista($idsCirugias);
            list($instrumentadoresDo, $idCirugia, $instrumentador) = $this->obtenerInstrumentadores($idsCirugias);
            list($tecnicoDo, $idCirugia, $tecnico) = $this->obtenerTecnicos($idsCirugias);


            $data = [];
            foreach ($resultados as $cirugia) {

                $idCirugia = $cirugia['id'];
                $paciente = isset($pacientes[$cirugia['idPaciente']]) ? $pacientes[$cirugia['idPaciente']] : 'N/A';
                $pacienteName = $paciente['0']['nombre'] . ' ' .$paciente['0']['apellido'];
                $diagnosticoPrimario = isset($idsDiagnosticos[$idCirugia][0]['nombre']) ? $idsDiagnosticos[$idCirugia][0]['nombre'] : 'N/A';
                $diagnosticoSecundario = isset($idsSecundario[$idCirugia][0]['nombre']) ? $idsSecundario[$idCirugia][0]['nombre'] : 'N/A';
                $especialidad = isset($especialidades[$cirugia['idUnidadFuncional']]) ? $especialidades[$cirugia['idUnidadFuncional']] : 'N/A';
                $especialidadName = $especialidad['0']['nombre'];
                $cirujano = isset($cirujanosDo[$idCirugia][0]['nombre']) ? $cirujanosDo[$idCirugia][0]['nombre'] .  $cirujanosDo[$idCirugia][0]['apellido'] : 'N/A';
                $anestesista = isset($anestesistasDo[$idCirugia][0]['nombre'])  ? $anestesistasDo[$idCirugia][0]['nombre'] . $anestesistasDo[$idCirugia][0]['apellido'] : 'N/A';
                $instrumentador = isset($instrumentadoresDo[$idCirugia][0]['nombre'])  ? $instrumentadoresDo[$idCirugia][0]['nombre'] . $instrumentadoresDo[$idCirugia][0]['apellido'] : 'N/A';
                $tecnico = isset($tecnicoDo[$idCirugia][0]['nombre'])  ? $tecnicoDo[$idCirugia][0]['nombre'] . $tecnicoDo[$idCirugia][0]['apellido'] : 'N/A';


                $data[] = [
                    'id' => $cirugia['id'],
                    'fecha' => $cirugia['fecha'],
                     'paciente' => $pacienteName,
                //    'paciente' => $paciente,
                  'primario' => $diagnosticoPrimario,
                    'secundario' => $diagnosticoSecundario,
                    'especialidad' => $especialidadName,
                //    'idNombreCirugia' => $cirugia['idNombreCirugia'],
                    'nombreCirujano' => $cirujano,
                    'anestesista' => $anestesista,
                    'instrumentador' => $instrumentador,
                   'tecnico' => $tecnico,
                    'horaInicio' => $cirugia['horaInicio'],
                    'horaFin' => $cirugia['horaFin'],
                ];
            }


            $this->presenter->render("view/estadisticas.mustache", [
                "data" => $data,
            ]);
        }

    }


    private function obtenerCirujanos(array $idsCirugias): array
    {
        $cirujanosDo = [];
        foreach ($idsCirugias as $idCirugia) {
            $cirujano = $this->model->obtenerProfesionalCirujano($idCirugia);
            $cirujanosDo[$idCirugia] = $cirujano;
        }
        return array($cirujanosDo, $idCirugia, $cirujano);
    }

    private function obtenerAnestesista(array $idsCirugias): array
    {
        $anestesistas = [];
        foreach ($idsCirugias as $idCirugia) {
            $anestesista = $this->model->obtenerProfesionalAnestesista($idCirugia);
            $anestesistas[$idCirugia] = $anestesista;
        }
        return array($anestesistas, $idCirugia, $anestesista);

    }
    private function obtenerInstrumentadores(array $idsCirugias): array
    {
        $instrumentadores = [];
        foreach ($idsCirugias as $idCirugia) {
            $instrumentador = $this->model->obtenerProfesionalInstrumentador($idCirugia);
            $instrumentadores[$idCirugia] = $instrumentador;
        }
        return array($instrumentadores, $idCirugia, $instrumentador);

    }



    private function obtenerTecnicos(array $idsCirugias): array
    {
        $tecnicos = [];
        foreach ($idsCirugias as $idCirugia) {
            $tecnico = $this->model->obtenerProfesionalTecnico($idCirugia);
            $tecnicos[$idCirugia] = $tecnico;
        }
        return array($tecnicos, $idCirugia, $tecnico);

    }


    public function obtenerPaciente(array $idsPaciente): array
    {
        $pacientes = [];
        foreach ($idsPaciente as $idPaciente) {

            $paciente = $this->model->obtenerNombreYApellidoDelPaciente($idPaciente);
            $pacientes[$idPaciente] = $paciente;

        }
        return array($pacientes, $paciente);
    }


    public function obtenerEspQuirurgica(array $idsUnidadFuncional): array
    {
        foreach ($idsUnidadFuncional as $idUnidadFuncional) {

            $especialidad = $this->model->obtenerEspecialidadQuirurgica($idUnidadFuncional);
            $especialidades[$idUnidadFuncional] = $especialidad;
        }
        return array($especialidad, $especialidades);
    }

}

//  nombre / hisClinica /  /
// / espQui / actoPrinc /  / anestesista /
// instrumentador / tecnico /  /  / verDetalle
