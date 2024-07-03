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


        if (isset($_GET['fechaDesde']) && isset($_GET['fechaHasta'])) {
            $fechaInicio = $_GET['fechaDesde'];
            $fechaFin = $_GET['fechaHasta'];

            $resultados = $this->model->obtenerCirugias($fechaInicio, $fechaFin);

            $idsCirugias = [];
            $idsPaciente = [];
            $idsUnidadFuncional = [];
            $idsCirugiaNombre = [];
            $idsTipoCirugia = [];
            $idsTipoDeAnestesias = [];
            foreach ($resultados as $cirugia) {
                $idsCirugias[] = $cirugia['id'];
                $idsPaciente[] = $cirugia['idPaciente'];
                $idsUnidadFuncional[] = $cirugia['idUnidadFuncional'];
                $idsCirugiaNombre[] = $cirugia['idNombreCirugia'];
                $idsTipoCirugia[] = $cirugia['idTipoDeCirugia'];
                $idsTipoDeAnestesias[] = $cirugia['idTipoDeAnestesia'];
            }

            $idsDiagnosticos = [];
            $idsSecundario = [];
            foreach ($idsCirugias as $idCirugia) {
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
            list($idsCirugiasNombres, $cirugiaNombre) = $this->obtenerNombreCirugia($idsCirugiaNombre);
            list($idsTipoCirugias, $tipoCirugia) = $this->obtenerTipoCirugia($idsTipoCirugia);
            list($idsTiposDeAnestesias, $idTipoAnestesia) = $this->obtenerTipoDeAnestesia($idsTipoDeAnestesias);


            $data = [];
            foreach ($resultados as $cirugia) {

                $idCirugia = $cirugia['id'];

                $paciente = isset($pacientes[$cirugia['idPaciente']]) ? $pacientes[$cirugia['idPaciente']] : 'N/A';
                $pacienteName = $paciente['0']['nombre'] . ' ' . $paciente['0']['apellido'];

                $diagnosticoPrimario = isset($idsDiagnosticos[$idCirugia][0]['nombre']) ? $idsDiagnosticos[$idCirugia][0]['nombre'] : 'N/A';
                $diagnosticoSecundario = isset($idsSecundario[$idCirugia][0]['nombre']) ? $idsSecundario[$idCirugia][0]['nombre'] : 'N/A';

                $especialidad = isset($especialidades[$cirugia['idUnidadFuncional']]) ? $especialidades[$cirugia['idUnidadFuncional']] : 'N/A';
                $especialidadName = $especialidad['0']['nombre'];

                $cirugiaNombre = isset($idsCirugiasNombres[$cirugia['idNombreCirugia']]) ? $idsCirugiasNombres[$cirugia['idNombreCirugia']] : 'N/A';
                $cirugiaName = $cirugiaNombre['0']['nombre'];
                $cirujano = isset($cirujanosDo[$idCirugia][0]['nombre']) ? $cirujanosDo[$idCirugia][0]['nombre'] . $cirujanosDo[$idCirugia][0]['apellido'] : 'N/A';

                $anestesista = isset($anestesistasDo[$idCirugia][0]['nombre']) ? $anestesistasDo[$idCirugia][0]['nombre'] . $anestesistasDo[$idCirugia][0]['apellido'] : 'N/A';
                $instrumentador = isset($instrumentadoresDo[$idCirugia][0]['nombre']) ? $instrumentadoresDo[$idCirugia][0]['nombre'] . $instrumentadoresDo[$idCirugia][0]['apellido'] : 'N/A';
                $tecnico = isset($tecnicoDo[$idCirugia][0]['nombre']) ? $tecnicoDo[$idCirugia][0]['nombre'] . $tecnicoDo[$idCirugia][0]['apellido'] : 'N/A';

                //tipo cirugia
                $tipoCirugia = isset($idsTipoCirugias[$cirugia['idTipoDeCirugia']]) ? $idsTipoCirugias[$cirugia['idTipoDeCirugia']] : 'N/A';
                $tipoCirugiaName = $tipoCirugia['0']['nombre'];

                $tipoDeAnestesia = isset($idsTiposDeAnestesias[$cirugia['idTipoDeAnestesia']]) ? $idsTiposDeAnestesias[$cirugia['idTipoDeAnestesia']] : 'N/A';
                $tipoDeAnestesiasName = $tipoDeAnestesia['0']['nombre'];
                

                $data[] = [
                    'id' => $cirugia['id'],
                    'fecha' => $cirugia['fecha'],
                    'paciente' => $pacienteName,
                    'primario' => $diagnosticoPrimario,
                    'secundario' => $diagnosticoSecundario,
                    'especialidad' => $especialidadName,
                    'nombreCirugia' => $cirugiaName,
                    'nombreCirujano' => $cirujano,
                    'anestesista' => $anestesista,
                    'instrumentador' => $instrumentador,
                    'tecnico' => $tecnico,
                    'horaInicio' => $cirugia['horaInicio'],
                    'horaFin' => $cirugia['horaFin'],
                    'observacion' => $cirugia['observacion'],
                    'tipoDeAnestesia' => $tipoDeAnestesia,
                    'tipoDeCirugia' => $tipoCirugiaName
                    // caja quirurgica
                    // sitio anatomico
                    // unidad funcional
                    //asa
                    // primer ayudante
                    // segundo ayudante
                    // neonatologo
                    // circulante
                    // lugar proviene
                    // lugar egresa
                    // conteo
                    // radiografia
                    // hemoterapia
                    // cultivo
                    // anatomia
                    // codigo de practicas
                    // material protesico
                    // cantidad mp
                    // tecnologias usadas

                ];

            }

            $this->presenter->render("view/estadisticas.mustache", [
                "data" => $data,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,


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


    private function obtenerPaciente(array $idsPaciente): array
    {
        $pacientes = [];
        foreach ($idsPaciente as $idPaciente) {

            $paciente = $this->model->obtenerNombreYApellidoDelPaciente($idPaciente);
            $pacientes[$idPaciente] = $paciente;

        }
        return array($pacientes, $paciente);
    }
    private function obtenerNombreCirugia(array $idsCirugiaNombre): array
    {
        $cirugiaNombres = [];
        foreach ($idsCirugiaNombre as $idCirugiaNombre) {
            $cirugiaNombre = $this->model->obtenerActoPrincipal($idCirugiaNombre);
            $cirugiaNombres[$idCirugiaNombre] = $cirugiaNombre;

        }
        return [$cirugiaNombres, $cirugiaNombre];
    }

    private function obtenerEspQuirurgica(array $idsUnidadFuncional): array
    {
        foreach ($idsUnidadFuncional as $idUnidadFuncional) {

            $especialidad = $this->model->obtenerEspecialidadQuirurgica($idUnidadFuncional);
            $especialidades[$idUnidadFuncional] = $especialidad;
        }
        return array($especialidad, $especialidades);

    }
    private function obtenerTipoCirugia(array $idsCirugiasTipoCirugia): array
    {
        $tipoCirugias = [];
        foreach ($idsCirugiasTipoCirugia as $idTipoCirugia) {
            $tipoCirugia = $this->model->obtenerTipoCirugia($idTipoCirugia);
            $tipoCirugias[$idTipoCirugia] = $tipoCirugia;
        }
        return array($tipoCirugias, $tipoCirugia);
    }
    private function obtenerTipoDeAnestesia(array $idsTipoDeAnestesia): array
    {
        $tipoDeAnestesias = [];
        foreach ($idsTipoDeAnestesia as $idTipoDeAnestesia) {
            $tipoDeAnestesia = $this->model->obtenerTipoDeAnestesia($idTipoDeAnestesia);
            $tipoDeAnestesias[$idTipoDeAnestesia] = $tipoDeAnestesia;

        }
        return array($tipoDeAnestesias, $tipoDeAnestesia);
    }



}


// verDetalle
