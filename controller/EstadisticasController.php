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


        if (isset($_GET['fechaDesde']) && $_GET['fechaHasta'] && $_GET['fechaDesde'] !== '' && $_GET['fechaHasta'] !== '') {
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
            list($codigoDePracticasDo, $codigoDePracticasDo2, $codigoDePracticasDo3) = $this->obtenerCodigoDePracticas($idsCirugias);
            list($materialProtesicoDo,$materialProtesicoDo2,  $materialProtesicoDo3) = $this->obtenerMaterialProtesico($idsCirugias);
            list($tecnologiaDo) = $this->obtenerTecnologia($idsCirugias);
            list($espQuirurgicaDo, $espQuirurgicaDo2, $espQuirurgicaDo3) = $this->obtenerEspQuirurgica($idsCirugias);
            list($actoQuirurgicoDo, $actoQuirurgicoDo2, $actoQuirurgicoDo3) = $this->obtenerNombreCirugia($idsCirugias);
            list($sitioAnatomicoDo, $sitioAnatomicoDo2, $sitioAnatomicoDo3) = $this->obtenerSitioAnatomico($idsCirugias);
            list($unidadFuncionalDo, $unidadFuncionalDo2, $unidadFuncionalDo3) = $this->obtenerUnidadFuncional($idsCirugias);
            list($cajaDo, $cajaDo2, $cajaDo3, $cajaDo4) = $this->obtenerCaja($idsCirugias);


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
                $codigoDePractica2 = isset($codigoDePracticasDo2[$idCirugia][0]['nombre']) ? $codigoDePracticasDo2[$idCirugia][0]['nombre'] : 'N/A';
                $codigoDePractica3 = isset($codigoDePracticasDo3[$idCirugia][0]['nombre']) ? $codigoDePracticasDo3[$idCirugia][0]['nombre'] : 'N/A';
                $materialProtesico = isset($materialProtesicoDo[$idCirugia][0]['nombre']) ? $materialProtesicoDo[$idCirugia][0]['nombre'] : 'N/A';
                $materialProtesico2 = isset($materialProtesicoDo2[$idCirugia][0]['nombre']) ? $materialProtesicoDo2[$idCirugia][0]['nombre'] : 'N/A';
                $materialProtesico3 = isset($materialProtesicoDo3[$idCirugia][0]['nombre']) ? $materialProtesicoDo3[$idCirugia][0]['nombre'] : 'N/A';
                $tecnologias = isset($tecnologiaDo[$idCirugia]) ? $tecnologiaDo[$idCirugia] : [];
                $tecnologiasNombres = '';
                $caja = isset($cajaDo[$idCirugia][0]['nombre']) ? $cajaDo[$idCirugia][0]['nombre'] : 'N/A';
                $caja2 = isset($cajaDo2[$idCirugia][0]['nombre']) ? $cajaDo2[$idCirugia][0]['nombre'] : 'N/A';
                $caja3 = isset($cajaDo3[$idCirugia][0]['nombre']) ? $cajaDo3[$idCirugia][0]['nombre'] : 'N/A';
                $caja4 = isset($cajaDo4[$idCirugia][0]['nombre']) ? $cajaDo4[$idCirugia][0]['nombre'] : 'N/A';
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
                    'codigo2' => $codigoDePractica2,
                    'codigo3' => $codigoDePractica3,
                    'material' => $materialProtesico,
                    'tecnologia' => $tecnologiasNombres,
                    'caja' => $caja,
                    'caja2' =>$caja2,
                    'caja3' =>$caja3,
                    'caja4' =>$caja4,
                    'materialProtesico' => $materialProtesico,
                    'materialProtesico2' => $materialProtesico2,
                    'materialProtesico3' => $materialProtesico3,

                ];

            }

            $this->presenter->render("view/estadisticas.mustache", [
                "data" => $data,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,


            ]);
        } else {
            header("Location: /estadisticas");
        }
    }

    public function verDetalle ()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idCirugia'])) {
            $idCirugia = $_GET['idCirugia'];
            $paciente = $this->model->obtenerCirugia($idCirugia);
            $nombreYApellidoPac = $this->model->obtenerNombreYApellidoDelPaciente($idCirugia);
            $primario = $this->model->obtenerDiagnosticoPrimario($idCirugia);
            $secundario = $this->model->obtenerDiagnosticoSecundario($idCirugia);
            $especialidad = $this->model->obtenerEspecialidadQuirurgica($idCirugia);
            $especialidadSecundaria = $this->model->obtenerEspecialidadQuirurgicaSecundario($idCirugia);
            $especialidadTerciaria = $this->model->obtenerEspecialidadQuirurgicaTerciario($idCirugia);
            $acto = $this->model->obtenerActoPrincipal($idCirugia);
            $actoSecundario = $this->model->obtenerActoSecundario($idCirugia);
            $actoTerciario = $this->model->obtenerActoTerciario($idCirugia);
            $cirujano =$this->model->obtenerProfesionalCirujano($idCirugia);
            $cirujano2 = $this->model->obtenerProfesionalCirujanoSecundario($idCirugia);
            $cirujano3 = $this->model->obtenerProfesionalCirujanoTerciario($idCirugia);
            $primerAyudante = $this->model->obtenerProfesionalPrimerAyudante($idCirugia);
            $segundoAyudante = $this->model->obtenerProfesionalSegundoAyudante($idCirugia);
            $primerAyudante2 = $this->model->obtenerProfesionalPrimerAyudanteSecundario($idCirugia);
            $primerAyudante3 = $this->model->obtenerProfesionalPrimerAyudanteTerciario($idCirugia);
            $segundoAyudante2 = $this->model->obtenerProfesionalSegundoAyudanteSecundario($idCirugia);
            $segundoAyudante3 = $this->model->obtenerProfesionalSegundoAyudanteTerciario($idCirugia);
            $anestesista = $this->model->obtenerProfesionalAnestesista($idCirugia);
            $instrumentador = $this->model->obtenerProfesionalInstrumentador($idCirugia);
            $tecnico = $this->model->obtenerProfesionalTecnico($idCirugia);
            $neonatologo = $this->model->obtenerProfesionalNeonatologo($idCirugia);
            $circulante = $this->model->obtenerProfesionalCirculante($idCirugia);
            $tipoAnestesia = $this->model->obtenerTipoDeAnestesia($paciente[0]['idTipoDeAnestesia']);
            $tipoCirugia = $this->model->obtenerTipoCirugia($paciente[0]['idTipoDeCirugia']);
            $sitioAnatomico = $this->model->obtenerSitioAnatomico($idCirugia);
            $sitioAnatomico2 = $this->model->obtenerSitioAnatomicoSecundario($idCirugia);
            $sitioAnatomico3 = $this->model->obtenerSitioAnatomicoTerciario($idCirugia);
            $unidadFuncional = $this->model->obtenerUnidadFuncional($idCirugia);
            $unidadFuncional2 = $this->model->obtenerUnidadFuncionalSecundario($idCirugia);
            $unidadFuncional3 = $this->model->obtenerUnidadFuncionalTerciario($idCirugia);
            $materialProtesico = $this->model->obtenerMaterialProtesico($idCirugia);
           $materialProtesico2 = $this->model->obtenerMaterialProtesicoSecundario($idCirugia);
           $materialProtesico3 = $this->model->obtenerMaterialProtesicoTerciario($idCirugia);
            $codigoDePracticas = $this->model->obtenerCodigoDePracticas($idCirugia);
            $codigoDePracticas2 = $this->model->obtenerCodigoDePracticasSecundario($idCirugia);
            $codigoDePracticas3= $this->model->obtenerCodigoDePracticasTerciario($idCirugia);
            $caja = $this->model->obtenerCajaQuirurgica($idCirugia);
            $caja2 = $this->model->obtenerCajaQuirurgicaSecundaria($idCirugia);
            $caja3 = $this->model->obtenerCajaQuirurgicaTerciaria($idCirugia);
            $caja4 = $this->model->obtenerCajaQuirurgicaCuarta($idCirugia);


            $tecnologia = $this->model->obtenerTecnologia($idCirugia);

            $nombreTecnologia = '';
            foreach ($tecnologia as $tec) {
                $nombreTecnologia .= $tec['nombre'] . ' -';
            }







            $this->presenter->render("view/detalleEstadisticas.mustache", [
                "id" => $idCirugia,
                "fecha" => $paciente[0]['fecha'],
                "paciente" => $nombreYApellidoPac[0]['nombre'] . ' ' . $nombreYApellidoPac[0]['apellido'],
                "dni" => $nombreYApellidoPac[0]['dni'],
                "horaInicio" => $paciente[0]['horaInicio'],
                "horaFin" => $paciente[0]['horaFin'],
                "asa" => $paciente[0]['asa'],
                "horaEgreso" => $paciente[0]['horaEgresoCentroQuirurgico'],
                "horaDeNacimiento" => $paciente[0]['horaDeNacimiento'],
                "anatomia" => $paciente[0]['anatomiaPatologica'] == 1 ? 'SI' : 'NO',
                "hemoterapia" => $paciente[0]['hemoterapia'] == 1 ? 'SI' : 'NO',
                "cultivo" => $paciente[0]['cultivo'] == 1 ? 'SI' : 'NO',
                "conteo" => $paciente[0]['conteo'] == 1 ? 'SI' : 'NO',
                "radiograma" => $paciente[0]['radiografiaControl'] == 1 ? 'SI' : 'NO',
                "nroQuirofano" => $paciente[0]['nroQuirofanoUsado'],
                "observacion" => $paciente[0]['observacion'],
                "primario" => $primario[0]['nombre'],
                "secundario" => !empty($secundario[0]['nombre']) ? $secundario[0]['nombre'] : 'N/A',
                "especialidad" => $especialidad[0]['nombre'],
                "especialidad2" => !empty($especialidadSecundaria[0]['nombre']) ? $especialidadSecundaria[0]['nombre'] : 'N/A',
                "especialidad3" => !empty($especialidadTerciaria[0]['nombre']) ? $especialidadTerciaria[0]['nombre'] : 'N/A',
                "acto" => $acto[0]['nombre'],
                "acto2" => !empty($actoSecundario[0]['nombre']) ? $actoSecundario[0]['nombre'] : 'N/A',
                "acto3" => !empty($actoTerciario[0]['nombre']) ? $actoTerciario[0]['nombre'] : 'N/A',
                "cirujano" => $cirujano[0]['nombre'] . $cirujano[0]['apellido'],
                "cirujano2" => !empty($cirujano2[0]['nombre']) ? $cirujano2[0]['nombre'] . $cirujano2[0]['apellido'] : 'N/A',
                "cirujano3" => !empty($cirujano3[0]['nombre']) ? $cirujano3[0]['nombre'] . $cirujano3[0]['apellido']: 'N/A',
                "primerAyudante" => !empty($primerAyudante[0]['nombre']) ? $primerAyudante[0]['nombre'] . $primerAyudante[0]['apellido'] : 'N/A',
                "primerAyudante2" => !empty($primerAyudante2[0]['nombre']) ? $primerAyudante2[0]['nombre'] . $primerAyudante2[0]['apellido'] : 'N/A',
                "primerAyudante3" => !empty($primerAyudante3[0]['nombre']) ? $primerAyudante3[0]['nombre'] . $primerAyudante3[0]['apellido'] : 'N/A',
                "segundoAyudante" => !empty($segundoAyudante[0]['nombre']) ? $segundoAyudante[0]['nombre'] . $segundoAyudante[0]['apellido'] : 'N/A',
                "segundoAyudante2" => !empty($segundoAyudante2[0]['nombre']) ? $segundoAyudante2[0]['nombre'] . $segundoAyudante2[0]['apellido'] : 'N/A',
                "segundoAyudante3" => !empty($segundoAyudante3[0]['nombre']) ? $segundoAyudante3[0]['nombre'] . $segundoAyudante3[0]['apellido'] : 'N/A',
                "anestesista" => $anestesista[0]['nombre'] . $anestesista[0]['apellido'],
                "instrumentador" => !empty($instrumentador[0]['nombre']) ? $instrumentador[0]['nombre'] . $instrumentador[0]['apellido']: 'N/A',
                "tecnico" => $tecnico[0]['nombre'] . $tecnico[0]['apellido'],
                "neonatologo" => !empty($neonatologo[0]['nombre']) ? $neonatologo[0]['nombre'] . $neonatologo[0]['apellido']: 'N/A',
                "circulante" => $circulante[0]['nombre'] . $circulante[0]['apellido'],
                "tipoAnestesia" =>$tipoAnestesia[0]['nombre'],
                "tipoCirugia" => $tipoCirugia[0]['nombre'],
                "sitioAnatomico" => $sitioAnatomico[0]['nombre'],
                "sitioAnatomico2" => !empty($sitioAnatomico2[0]['nombre']) ? $sitioAnatomico2[0]['nombre'] : 'N/A',
                "sitioAnatomico3" => !empty($sitioAnatomico3[0]['nombre']) ? $sitioAnatomico3[0]['nombre'] : 'N/A',
                "unidadFuncional" => $unidadFuncional[0]['nombre'],
                "unidadFuncional2" => !empty($unidadFuncional2[0]['nombre']) ? $unidadFuncional2[0]['nombre'] : 'N/A',
                "unidadFuncional3" => !empty($unidadFuncional3[0]['nombre']) ? $unidadFuncional3[0]['nombre'] : 'N/A',
                "materialProtesico" => !empty($materialProtesico[0]['nombre']) ? $materialProtesico[0]['nombre'] : 'N/A',
                "CantidadmaterialProtesico" => !empty($materialProtesico[0]['cantidad']) ? $materialProtesico[0]['cantidad'] : 'N/A',
                "materialProtesico2" => !empty($materialProtesico2[0]['nombre']) ? $materialProtesico2[0]['nombre'] : 'N/A',
                "CantidadmaterialProtesico2" => !empty($materialProtesico2[0]['cantidad']) ? $materialProtesico2[0]['cantidad'] : 'N/A',
               "materialProtesico3" => !empty($materialProtesico3[0]['nombre']) ? $materialProtesico3[0]['nombre'] : 'N/A',
               "CantidadmaterialProtesico3" => !empty($materialProtesico3[0]['cantidad']) ? $materialProtesico3[0]['cantidad'] : 'N/A',
                "tecnologia" => $nombreTecnologia,
                "codigoPractica" => !empty($codigoDePracticas[0]['nombre']) ? $codigoDePracticas[0]['nombre'] : 'N/A',
                "codigoPractica2" => !empty($codigoDePracticas2[0]['nombre']) ? $codigoDePracticas2[0]['nombre'] : 'N/A',
                "codigoPractica3" => !empty($codigoDePracticas3[0]['nombre']) ? $codigoDePracticas3[0]['nombre'] : 'N/A',
                "caja" => !empty($caja[0]['nombre']) ? $caja[0]['nombre'] : 'N/A',
                "caja2" => !empty($caja2[0]['nombre']) ? $caja2[0]['nombre'] : 'N/A',
                "caja3" => !empty($caja3[0]['nombre']) ? $caja3[0]['nombre'] : 'N/A',
                "caja4" => !empty($caja4[0]['nombre']) ? $caja4[0]['nombre'] : 'N/A',



            ]);
        } else {
            header("Location: /home");
        }
    }


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
    $codigoPracticasSec = [];
    $codigoPracticasTer = [];
    foreach($idCirugias as $idCirugia) {
        $codigo = $this->model->obtenerCodigoDePracticas($idCirugia);
        $codigo2 = $this->model->obtenerCodigoDePracticasSecundario($idCirugia);
        $codigo3 = $this->model->obtenerCodigoDePracticasTerciario($idCirugia);
        $codigoPracticas[$idCirugia] = $codigo;
        $codigoPracticasSec[$idCirugia] = $codigo2;
        $codigoPracticasTer[$idCirugia] = $codigo3;
}
    return array($codigoPracticas, $codigoPracticasSec, $codigoPracticasTer);
}
    private function obtenerMaterialProtesico(array $idCirugias): array
    {
        $materialProtesico = [];
        $materialProtesico2 = [];
        $materialProtesico3 = [];
        foreach($idCirugias as $idCirugia) {
            $material = $this->model->obtenerMaterialProtesico($idCirugia);
            $material2 = $this->model->obtenerMaterialProtesicoSecundario($idCirugia);
            $material3 = $this->model->obtenerMaterialProtesicoTerciario($idCirugia);
            $materialProtesico[$idCirugia] = $material;
            $materialProtesico2[$idCirugia] = $material2;
            $materialProtesico3[$idCirugia] = $material3;
        }
        return array($materialProtesico, $materialProtesico2, $materialProtesico3);
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
    private function obtenerCaja(array $idCirugias) : array
    {
        $cajas = [];
        $cajassec = [];
        $cajasTer = [];
        $cajasCuarta = [];
        foreach ($idCirugias as $idCirugia) {
            $caja = $this->model->obtenerCajaQuirurgica($idCirugia);
            $caja2 = $this->model->obtenerCajaQuirurgicaSecundaria($idCirugia);
            $caja3 = $this->model->obtenerCajaQuirurgicaTerciaria($idCirugia);
            $caja4 = $this->model->obtenerCajaQuirurgicaCuarta($idCirugia);
            $cajas[$idCirugia] = $caja;
            $cajassec[$idCirugia] = $caja2;
            $cajasTer[$idCirugia] = $caja3;
            $cajasCuarta[$idCirugia] = $caja4;
        }
        return array($cajas, $cajassec, $cajasTer, $cajasCuarta);
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
