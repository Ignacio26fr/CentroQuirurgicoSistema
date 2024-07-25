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
            $idsTipoCirugia = [];
            $idsTipoDeAnestesias = [];
            foreach ($resultados as $cirugia) {
                $idsCirugias[] = $cirugia['id'];
                $idsPaciente[] = $cirugia['idPaciente'];
                $idsTipoCirugia[] = $cirugia['idTipoDeCirugia'];
                $idsTipoDeAnestesias[] = $cirugia['idTipoDeAnestesia'];
            }


            list($idsDiagnosticos, $idsSecundario, $idCirugia) = $this->obtenerDiagnosticos($idsCirugias);
            list($pacientes) = $this->obtenerPaciente($idsPaciente);
            list($cirujanosDo) = $this->obtenerCirujanos($idsCirugias);
            list($anestesistasDo) = $this->obtenerAnestesista($idsCirugias);
            list($instrumentadoresDo) = $this->obtenerInstrumentadores($idsCirugias);
            list($tecnicoDo) = $this->obtenerTecnicos($idsCirugias);
           list($primerAyudanteDo) = $this->obtenerPrimerAyudante($idsCirugias);
           list($segundoAyudanteDo) = $this->obtenerSegundoAyudante($idsCirugias);
            list($neonatologoDo) = $this->obtenerNeonatologo($idsCirugias);
            list($circulanteDo) = $this->obtenerCirculante($idsCirugias);
            list($idsTipoCirugias) = $this->obtenerTipoCirugia($idsTipoCirugia);
            list($idsTiposDeAnestesias) = $this->obtenerTipoDeAnestesia($idsTipoDeAnestesias);
            list($lugaresProvieneDo) = $this->obtenerLugarProviene($idsCirugias);
            list($lugarEgresaDo) = $this->obtenerLugarEgresa($idsCirugias);
            list($codigoDePracticasDo) = $this->obtenerCodigoDePracticas($idsCirugias);
            list($materialProtesicoDo) = $this->obtenerMaterialProtesico($idsCirugias);
            list($tecnologiaDo) = $this->obtenerTecnologia($idsCirugias);
            list($espQuirurgicaDo, $espQuirurgicaDo2, $espQuirurgicaDo3) = $this->obtenerEspQuirurgica($idsCirugias);
            list($actoQuirurgicoDo, $actoQuirurgicoDo2, $actoQuirurgicoDo3) = $this->obtenerNombreCirugia($idsCirugias);
            list($sitioAnatomicoDo, $sitioAnatomicoDo2, $sitioAnatomicoDo3) = $this->obtenerSitioAnatomico($idsCirugias);
            list($unidadFuncionalDo, $unidadFuncionalDo2, $unidadFuncionalDo3) = $this->obtenerUnidadFuncional($idsCirugias);


            $data = [];
            foreach ($resultados as $cirugia) {

                $idCirugia = $cirugia['id'];

                $paciente = isset($pacientes[$cirugia['idPaciente']]) ? $pacientes[$cirugia['idPaciente']] : 'N/A';
                $pacienteName = $paciente['0']['nombre'] . ' ' . $paciente['0']['apellido'];

                $diagnosticoPrimario = isset($idsDiagnosticos[$idCirugia][0]['nombre']) ? $idsDiagnosticos[$idCirugia][0]['nombre'] : 'N/A';
                $diagnosticoSecundario = isset($idsSecundario[$idCirugia][0]['nombre']) ? $idsSecundario[$idCirugia][0]['nombre'] : 'N/A';

               $especialidad = isset($espQuirurgicaDo[$idCirugia][0]['nombre']) ? $espQuirurgicaDo[$idCirugia][0]['nombre'] : 'N/A';
               $especialidad2 = isset($espQuirurgicaDo2[$idCirugia][0]['nombre']) ? $espQuirurgicaDo2[$idCirugia][0]['nombre'] : 'N/A';
                $especialidad3 = isset($espQuirurgicaDo3[$idCirugia][0]['nombre']) ? $espQuirurgicaDo3[$idCirugia][0]['nombre'] : 'N/A';

              $cirugiaNombre = isset($actoQuirurgicoDo[$idCirugia][0]['nombre']) ? $actoQuirurgicoDo[$idCirugia][0]['nombre'] : 'N/A';
                $cirugiaNombre2 = isset($actoQuirurgicoDo2[$idCirugia][0]['nombre']) ? $actoQuirurgicoDo2[$idCirugia][0]['nombre'] : 'N/A';
                $cirugiaNombre3 = isset($actoQuirurgicoDo3[$idCirugia][0]['nombre']) ? $actoQuirurgicoDo3[$idCirugia][0]['nombre'] : 'N/A';


                $cirujano = isset($cirujanosDo[$idCirugia][0]['nombre']) ? $cirujanosDo[$idCirugia][0]['nombre'] . $cirujanosDo[$idCirugia][0]['apellido'] : 'N/A';

                $anestesista = isset($anestesistasDo[$idCirugia][0]['nombre']) ? $anestesistasDo[$idCirugia][0]['nombre'] . $anestesistasDo[$idCirugia][0]['apellido'] : 'N/A';
                $instrumentador = isset($instrumentadoresDo[$idCirugia][0]['nombre']) ? $instrumentadoresDo[$idCirugia][0]['nombre'] . $instrumentadoresDo[$idCirugia][0]['apellido'] : 'N/A';
                $tecnico = isset($tecnicoDo[$idCirugia][0]['nombre']) ? $tecnicoDo[$idCirugia][0]['nombre'] . $tecnicoDo[$idCirugia][0]['apellido'] : 'N/A';

              $primerAyudante  = isset($primerAyudanteDo[$idCirugia][0]['nombre']) ? $primerAyudanteDo[$idCirugia][0]['nombre'] . $primerAyudanteDo[$idCirugia][0]['apellido'] : 'N/A';
                $segundoAyudante  = isset($segundoAyudanteDo[$idCirugia][0]['nombre']) ? $segundoAyudanteDo[$idCirugia][0]['nombre'] . $segundoAyudanteDo[$idCirugia][0]['apellido'] : 'N/A';

                $neonatologo = isset($neonatologoDo[$idCirugia][0]['nombre']) ? $neonatologoDo[$idCirugia][0]['nombre'] . $neonatologoDo[$idCirugia][0]['apellido'] : 'N/A';
                $circulante = isset($circulanteDo[$idCirugia][0]['nombre']) ? $circulanteDo[$idCirugia][0]['nombre'] . $circulanteDo[$idCirugia][0]['apellido'] : 'N/A';

                //Lugar proviene

                $lugaresProviene = isset($lugaresProvieneDo[$idCirugia][0]['nombre']) ? $lugaresProvieneDo[$idCirugia][0]['nombre'] : 'N/A';
                $lugaresEgresan = isset($lugarEgresaDo[$idCirugia][0]['nombre']) ? $lugarEgresaDo[$idCirugia][0]['nombre'] : 'N/A';

                //tipo cirugia

                $tipoCirugia = isset($idsTipoCirugias[$cirugia['idTipoDeCirugia']]) ? $idsTipoCirugias[$cirugia['idTipoDeCirugia']] : 'N/A';
                $tipoCirugiaName = $tipoCirugia['0']['nombre'];

                $tipoDeAnestesia = isset($idsTiposDeAnestesias[$cirugia['idTipoDeAnestesia']]) ? $idsTiposDeAnestesias[$cirugia['idTipoDeAnestesia']] : 'N/A';
                $tipoDeAnestesiasName = $tipoDeAnestesia['0']['nombre'];

               $sitioAnatomico = isset($sitioAnatomicoDo[$idCirugia][0]['nombre']) ? $sitioAnatomicoDo[$idCirugia][0]['nombre'] : 'N/A';
                $sitioAnatomico2 = isset($sitioAnatomicoDo2[$idCirugia][0]['nombre']) ? $sitioAnatomicoDo2[$idCirugia][0]['nombre'] : 'N/A';
                $sitioAnatomico3 = isset($sitioAnatomicoDo3[$idCirugia][0]['nombre']) ? $sitioAnatomicoDo3[$idCirugia][0]['nombre'] : 'N/A';


                $unidadFuncional = isset($unidadFuncionalDo[$idCirugia][0]['nombre']) ? $unidadFuncionalDo[$idCirugia][0]['nombre'] : 'N/A';
               $unidadFuncional2 = isset($unidadFuncionalDo2[$idCirugia][0]['nombre']) ? $unidadFuncionalDo2[$idCirugia][0]['nombre'] : 'N/A';
              $unidadFuncional3 = isset($unidadFuncionalDo3[$idCirugia][0]['nombre']) ? $unidadFuncionalDo3[$idCirugia][0]['nombre'] : 'N/A';


                $codigoDePractica = isset($codigoDePracticasDo[$idCirugia][0]['nombre']) ? $codigoDePracticasDo[$idCirugia][0]['nombre'] : 'N/A';
                $materialProtesico = isset($materialProtesicoDo[$idCirugia][0]['nombre']) ? $materialProtesicoDo[$idCirugia][0]['nombre'] : 'N/A';
                $tecnologias = isset($tecnologiaDo[$idCirugia]) ? $tecnologiaDo[$idCirugia] : [];
                $tecnologiasNombres = '';

                if (!empty($tecnologias)) {
                    foreach ($tecnologias as $tecnologia) {
                        $tecnologiasNombres .= $tecnologia['nombre'] . " -/- ";
                    }
                } else {
                    $tecnologiasNombres = 'N/A';
                }
                
                $data[] = [
                    'id' => $cirugia['id'],
                    'fecha' => $cirugia['fecha'],
                    'paciente' => $pacienteName,
                    'primario' => $diagnosticoPrimario,
                    'secundario' => $diagnosticoSecundario,
                    'especialidad' => $especialidad,
                    'especialidad2' => $especialidad2,
                    'especialidad3' => $especialidad3,
                  'nombreCirugia' => $cirugiaNombre,
                    'nombreCirugia2' => $cirugiaNombre2,
                    'nombreCirugia3' => $cirugiaNombre3,
                    'nombreCirujano' => $cirujano,
                    'anestesista' => $anestesista,
                    'instrumentador' => $instrumentador,
                    'tecnico' => $tecnico,
                    'horaInicio' => $cirugia['horaInicio'],
                    'horaFin' => $cirugia['horaFin'],
                    'observacion' => $cirugia['observacion'],
                    'tipoDeAnestesia' => $tipoDeAnestesiasName,
                    'tipoDeCirugia' => $tipoCirugiaName,
                    // caja quirurgica
                'sitioAnatomico' => $sitioAnatomico,
                    'sitioAnatomico2' => $sitioAnatomico2,
                    'sitioAnatomico3' => $sitioAnatomico3,
                  'unidadFuncional' => $unidadFuncional,
                    'unidadFuncional2' => $unidadFuncional2,
                    'unidadFuncional3' => $unidadFuncional3,
                      'asa' => $cirugia['asa'],
                    'primerAyudante' => $primerAyudante,
                   'segundoAyudante' => $segundoAyudante,
                    'neonatologo' => $neonatologo,
                    'circulante' => $circulante,
                    'proviene' => $lugaresProviene,
                    'egresa' => $lugaresEgresan,
                      'conteo' => $cirugia['conteo'] == 1 ? 'SI' : 'NO',
                   'radiograma' => $cirugia['radiografiaControl'] == 1 ? 'SI' : 'NO',
                    'hemoterapia' => $cirugia['hemoterapia'] == 1 ? 'SI' : 'NO',
                    'cultivo' => $cirugia['cultivo'] == 1 ? 'SI' : 'NO',
                    'anatomia' => $cirugia['anatomiaPatologica'] == 1 ? 'SI' : 'NO',
                    'codigo' => $codigoDePractica,
                    'material' => $materialProtesico,
                    'tecnologia' => $tecnologiasNombres

                ];

            }

            $this->presenter->render("view/estadisticas.mustache", [
                "data" => $data,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,


            ]);
        }
    }
    // FALTA AGREGAR EN EL EXCEL LOS CASOS NUEVOS QUE TOQUE
    //Ademas falta Cirujano x3 + primerx3 y seg x3



    private function obtenerCirujanos(array $idsCirugias): array
    {
        $cirujanosDo = [];
        foreach ($idsCirugias as $idCirugia) {
            $cirujano = $this->model->obtenerProfesionalCirujano($idCirugia);
            $cirujanosDo[$idCirugia] = $cirujano;
        }
        return array($cirujanosDo);
    }

    private function obtenerPrimerAyudante(array $idsCirugias): array
    {
        $primerAyudanteDo = [];
        foreach ($idsCirugias as $idCirugia) {
            $primerAyudante = $this->model->obtenerProfesionalPrimerAyudante($idCirugia);
            $primerAyudanteDo[$idCirugia] = $primerAyudante;
        }
        return array($primerAyudanteDo);
    }

    private function obtenerSegundoAyudante(array $idsCirugias): array
    {
        $segundoAyudanteDo = [];
        foreach ($idsCirugias as $idCirugia) {
            $segundoAyudante = $this->model->obtenerProfesionalSegundoAyudante($idCirugia);
            $segundoAyudanteDo[$idCirugia] = $segundoAyudante;
        }
        return array($segundoAyudanteDo);
    }
    private function obtenerAnestesista(array $idsCirugias): array
    {
        $anestesistas = [];
        foreach ($idsCirugias as $idCirugia) {
            $anestesista = $this->model->obtenerProfesionalAnestesista($idCirugia);
            $anestesistas[$idCirugia] = $anestesista;
        }
        return array($anestesistas);

    }
    private function obtenerInstrumentadores(array $idsCirugias): array
    {
        $instrumentadores = [];
        foreach ($idsCirugias as $idCirugia) {
            $instrumentador = $this->model->obtenerProfesionalInstrumentador($idCirugia);
            $instrumentadores[$idCirugia] = $instrumentador;
        }
        return array($instrumentadores);

    }
    private function obtenerNeonatologo(array $idsCirugias): array
    {
        $neonatologos = [];
        foreach ($idsCirugias as $idCirugia) {
            $neonatologo = $this->model->obtenerProfesionalNeonatologo($idCirugia);
            $neonatologos[$idCirugia] = $neonatologo;
        }
        return array($neonatologos);

    }
    private function obtenerCirculante(array $idsCirugias): array
    {
        $circulantes = [];
        foreach ($idsCirugias as $idCirugia) {
            $circulante = $this->model->obtenerProfesionalCirculante($idCirugia);
            $circulantes[$idCirugia] = $circulante;
        }
        return array($circulantes);

    }



    private function obtenerTecnicos(array $idsCirugias): array
    {
        $tecnicos = [];
        foreach ($idsCirugias as $idCirugia) {
            $tecnico = $this->model->obtenerProfesionalTecnico($idCirugia);
            $tecnicos[$idCirugia] = $tecnico;
        }
        return array($tecnicos);

    }


    private function obtenerPaciente(array $idsPaciente): array
    {
        $pacientes = [];
        foreach ($idsPaciente as $idPaciente) {

            $paciente = $this->model->obtenerNombreYApellidoDelPaciente($idPaciente);
            $pacientes[$idPaciente] = $paciente;

        }
        return array($pacientes);
    }
    private function obtenerNombreCirugia(array $idsCirugia): array
    {
        $cirugiaNombres = [];
        $cirugiaNombres2 = [];
        $cirugiaNombres3 = [];
        foreach ($idsCirugia as $idCirugia) {
            $cirugiaNombre = $this->model->obtenerActoPrincipal($idCirugia);
            $cirugiaNombre2 = $this->model->obtenerActoSecundario($idCirugia);
            $cirugiaNombre3 = $this->model->obtenerActoTerciario($idCirugia);
            $cirugiaNombres[$idCirugia] = $cirugiaNombre;
            $cirugiaNombres2[$idCirugia] = $cirugiaNombre2;
            $cirugiaNombres3[$idCirugia] = $cirugiaNombre3;

        }
        return array($cirugiaNombres, $cirugiaNombres2, $cirugiaNombres3);
    }

    private function obtenerEspQuirurgica(array $idsCirugia): array
    {
        $espQuirurgicas = [];
        $espQuirurgicoSec = [];
        $espQuirurgicoTer = [];
        foreach ($idsCirugia as $idCirugia) {

            $espQuirurgica = $this->model->obtenerEspecialidadQuirurgica($idCirugia);
            $espQuir2 = $this->model->obtenerEspecialidadQuirurgicaSecundario($idCirugia);
            $espQuir3 = $this->model->obtenerEspecialidadQuirurgicaTerciario($idCirugia);
            $espQuirurgicas[$idCirugia] = $espQuirurgica;
            $espQuirurgicoSec[$idCirugia] = $espQuir2;
            $espQuirurgicoTer[$idCirugia] = $espQuir3;
        }
        return array($espQuirurgicas, $espQuirurgicoSec, $espQuirurgicoTer);

    }
    private function obtenerTipoCirugia(array $idsCirugiasTipoCirugia): array
    {
        $tipoCirugias = [];
        foreach ($idsCirugiasTipoCirugia as $idTipoCirugia) {
            $tipoCirugia = $this->model->obtenerTipoCirugia($idTipoCirugia);
            $tipoCirugias[$idTipoCirugia] = $tipoCirugia;
        }
        return array($tipoCirugias);
    }
    private function obtenerTipoDeAnestesia(array $idsTipoDeAnestesia): array
    {
        $tipoDeAnestesias = [];
        foreach ($idsTipoDeAnestesia as $idTipoDeAnestesia) {
            $tipoDeAnestesia = $this->model->obtenerTipoDeAnestesia($idTipoDeAnestesia);
            $tipoDeAnestesias[$idTipoDeAnestesia] = $tipoDeAnestesia;

        }
        return array($tipoDeAnestesias);
    }

    private function obtenerSitioAnatomico(array $idsCirugias): array
    {
        $sitioAnatomicos = [];
        $sitioAnatomicos2 = [];
        $sitioAnatomicos3 = [];
         foreach ($idsCirugias as $idCirugia) {
            $sitioAnatomico = $this->model->obtenerSitioAnatomico($idCirugia);
             $sitioAnatomico2 = $this->model->obtenerSitioAnatomicoSecundario($idCirugia);
             $sitioAnatomico3= $this->model->obtenerSitioAnatomicoTerciario($idCirugia);
            $sitioAnatomicos[$idCirugia] = $sitioAnatomico;
             $sitioAnatomicos2[$idCirugia] = $sitioAnatomico2;
             $sitioAnatomicos3[$idCirugia] = $sitioAnatomico3;
        }
        return array($sitioAnatomicos, $sitioAnatomicos2, $sitioAnatomico3);
    }

    private function obtenerUnidadFuncional(array $idsCirugias): array
    {
        $unidadesFuncionales = [];
        $unidadesFuncionales2 = [];
        $unidadesFuncionales3 = [];
        foreach ($idsCirugias as $idCirugia) {
            $unidadFuncional = $this->model->obtenerUnidadFuncional($idCirugia);
            $unidadFuncional2 = $this->model->obtenerUnidadFuncionalSecundario($idCirugia);
            $unidadFuncional3 = $this->model->obtenerUnidadFuncionalTerciario($idCirugia);
            $unidadesFuncionales[$idCirugia] = $unidadFuncional;
            $unidadesFuncionales2[$idCirugia] = $unidadFuncional2;
            $unidadesFuncionales3[$idCirugia] = $unidadFuncional3;
        }
        return array($unidadesFuncionales, $unidadesFuncionales2, $unidadesFuncionales3);
    }

    private function obtenerLugarProviene(array $idCirugias): array
    {
        $lugarProvienen = [];
        foreach ($idCirugias as $idCirugia) {
            $lugarProviene = $this->model->obtenerLugarProviene($idCirugia);
            $lugarProvienen[$idCirugia] = $lugarProviene;
        }
        return array($lugarProvienen);
    }
    private function obtenerLugarEgresa(array $idCirugias): array
    {
        $lugarEgresan = [];
        foreach ($idCirugias as $idCirugia) {
            $lugarEgresa = $this->model->obtenerLugarEgresa($idCirugia);
            $lugarEgresan[$idCirugia] = $lugarEgresa;
        }
        return array($lugarEgresan);
    }

    private function obtenerCodigoDePracticas(array $idCirugias): array
{
    $codigoPracticas = [];
    foreach($idCirugias as $idCirugia) {
        $codigo = $this->model->obtenerCodigoDePracticas($idCirugia);
        $codigoPracticas[$idCirugia] = $codigo;
}
    return array($codigoPracticas);
}
    private function obtenerMaterialProtesico(array $idCirugias): array
    {
        $materialProtesico = [];
        foreach($idCirugias as $idCirugia) {
            $material = $this->model->obtenerMaterialProtesico($idCirugia);
            $materialProtesico[$idCirugia] = $material;
        }
        return array($materialProtesico);
    }

    private function obtenerTecnologia(array $idCirugias): array
    {
        $tecnologias = [];
        foreach($idCirugias as $idCirugia) {
            $tecnologia = $this->model->obtenerTecnologia($idCirugia);
            $tecnologias[$idCirugia] = $tecnologia;

        }
        return array($tecnologias);
    }


    public function obtenerDiagnosticos(array $idsCirugias): array
    {
        $idsDiagnosticos = [];
        $idsSecundario = [];
        foreach ($idsCirugias as $idCirugia) {
            $diagPrimario = $this->model->obtenerDiagnosticoPrimario($idCirugia);
            $diagSecundario = $this->model->obtenerDiagnosticoSecundario($idCirugia);
            $idsDiagnosticos[$idCirugia] = $diagPrimario;
            $idsSecundario[$idCirugia] = $diagSecundario;

        }
        return array($idsDiagnosticos, $idsSecundario, $idCirugia);
    }
}


// verDetalle
