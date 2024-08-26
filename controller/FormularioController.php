<?php
class FormularioController
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

        session_start();
        $baseUrl = Configuration::getBaseUrl();
        if (!isset($_SESSION["usuario"])) {

            header("Location" . $baseUrl . "login");
            exit();
        }
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        $rol = $this->model->verificarRolUsuario($nombreUsuario);
        if ($rol == 'ADMIN' || $rol == 'INSTRUMENTADOR') {


            $paciente = $_SESSION['paciente'];

            $primario = $this->model->obtenerPrimario();
            $espquirurgica = $this->model->obtenerEspecialidadQuirurgica();
            $tipoAnestesia = $this->model->obtenerTipoAnestesia();
            $lugar = $this->model->obtenerLugar();
            $tipoCirugia = $this->model->obtenerTipoDeCirugia();
            $tecnologiaUsada = $this->model->obtenerTecnologiaUsada();
            $moduloAnestesia = $this->model->obtenerModuloAnestesia();

            $data = [
                "primario" => $primario,
                "espquirurgica" => $espquirurgica,
                "tipoAnestesia" => $tipoAnestesia,
                "lugar" => $lugar,
                "tipoCirugia" => $tipoCirugia,
                "tecnologiaUsada" => $tecnologiaUsada,
                "paciente" => $paciente,
                "moduloAnestesia" => $moduloAnestesia

            ];

            $this->presenter->render("view/formularioQuirurgico.mustache", ["data" => $data]);
        } else {
            header("Location" . $baseUrl . "homeUsuario");
    }

}


    public function obtenerOpcionesSecundario()
    {
        header('Content-Type: application/json');

        if (isset($_GET['filtroSecundario'])) {
            $filtro = $_GET['filtroSecundario'];
            $resultados = $this->model->obtenerDiagnosticoSecu($filtro);

            echo json_encode($resultados);
        }
    }

    public function obtenerOpcionesPrimario()
    {
        header('Content-Type: application/json');

        if (isset($_GET['filtroPrimario'])) {
            $filtro = $_GET['filtroPrimario'];
            $resultados = $this->model->obtenerDiagnosticoPrimario($filtro);
            $json = json_encode($resultados);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo 'Error en JSON: ' . json_last_error_msg();
            } else {
                echo $json;
            }
            exit();
        }
    }

    public function obtenerUnidadesFuncionales()
    {
        header('Content-Type: application/json');
        if (isset($_GET['idEspQuirurgica'])) {
            $idEspQuirurgica = $_GET['idEspQuirurgica'];

            $resultados = $this->model->obtenerUnidadesFuncionales($idEspQuirurgica);
            echo json_encode($resultados);
        }
    }

    public function obtenerSitiosAnatomicos()
    {
        header('Content-Type: application/json');
        if (isset($_GET['idUnidadFuncional'])) {
            $idUnidadFuncional = $_GET['idUnidadFuncional'];
            $resultados = $this->model->obtenerSitiosAnatomicos($idUnidadFuncional);
            echo json_encode($resultados);
        }
    }

    public function obtenerActosQuirurgico()
    {
        header('Content-Type: application/json');
        if (isset($_GET['idSitioAnatomico'])) {
            $idSitioAnatomico = $_GET['idSitioAnatomico'];
            $resultados = $this->model->obtenerActosQuirurgicos($idSitioAnatomico);
            echo json_encode($resultados);

        }
    }

    public function obtenerCirujano()
    {
        header('Content-Type: application/json');

        if (isset($_GET['filtroCirujano'])) {
            $filtroCirujano = $_GET['filtroCirujano'];
            $resultados = $this->model->obtenerCirujanos($filtroCirujano);

            echo json_encode($resultados);
        }
    }

    public function obtenerPrimerAyudante()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroPrimer'])) {
            $filtroPrimer = $_GET['filtroPrimer'];
            $resultados = $this->model->obtenerCirujanos($filtroPrimer);

            echo json_encode($resultados);
        }
    }

    public function obtenerSegundoAyudante()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroSegundo'])) {
            $filtroSegundo = $_GET['filtroSegundo'];
            $resultados = $this->model->obtenerCirujanos($filtroSegundo);

            echo json_encode($resultados);
        }
    }

    public function obtenerAnestesistas()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroAnestesista'])) {
            $filtroAnestesista = $_GET['filtroAnestesista'];
            $resultados = $this->model->obtenerAnestesista($filtroAnestesista);

            echo json_encode($resultados);
        }

    }
    public function obtenerInstrumentador()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroInstrumentador'])) {
            $filtroInstrumentador = $_GET['filtroInstrumentador'];
            $resultados = $this->model->obtenerInstrumentador($filtroInstrumentador);

            echo json_encode($resultados);
        }

    }
    public function obtenerCirculante()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroCirculante'])) {
            $filtroCirculante = $_GET['filtroCirculante'];
            $resultados = $this->model->obtenerInstrumentador($filtroCirculante);

            echo json_encode($resultados);
        }

    }
    public function obtenerNeonatologo()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroNeo'])) {
            $filtroNeo = $_GET['filtroNeo'];
            $resultados = $this->model->obtenerNeo($filtroNeo);

            echo json_encode($resultados);
        }

    }

    public function obtenerTecnico()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroTecnico'])) {
            $filtroTecnico = $_GET['filtroTecnico'];
            $resultados = $this->model->obtenerTecnico($filtroTecnico);

            echo json_encode($resultados);
        }

    }
    public function obtenerCajas()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroCaja'])) {
            $filtroCaja = $_GET['filtroCaja'];
            $resultados = $this->model->obtnerCajaQuirurgica($filtroCaja);

            echo json_encode($resultados);
        }

    }

    public function obtenerCodigos()
    {
        header('Content-Type: application/json');
        $resultados = array();
        if (isset($_GET['filtroCodigo'])) {
            $filtroCodigo = $_GET['filtroCodigo'];
            $resultados = $this->model->obtenerCodigos($filtroCodigo);
        }
            echo json_encode($resultados);


    }

    public function obtenerMaterialProtesico()
    {
        header('Content-Type: application/json');
        if (isset($_GET['filtroMaterial'])) {
            $filtroMaterial = $_GET['filtroMaterial'];
            $resultados = $this->model->obtenerMaterial($filtroMaterial);

            echo json_encode($resultados);
        }
    }

    public function insertarDatos(){
        session_start();
        $baseUrl = Configuration::getBaseUrl();
        $idUsuario = $this->model->obtenerUsuario($_SESSION['usuario']);


        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = $this->obtenerDatosDelPost();




            $result = $this->model->insertCirugia(
                $data['observacion'],
                $data['horaInicio'],
                $data['horaFin'],
                $data['fecha'],
                $data['tipoAnestesia'],
                $data['tipoCirugia'],
                $data['paciente'],
                $data['asa'],
                $data['numeroQuirofano'],
                $data['horaIngresoAlCentroQuirurgico'],
                $data['horaEgreso'],
                $data['horaNac'],
                  $data['conteo'],
                  $data['radiograma'],
                 $data['hemoterapia'],
               $data['cultivo'],
                 $data['anatomiaPatologica'],
                $data['moduloAnestesia']
            );




            $this->model->insertDiagnosticoCirugia($result, $data['primario'], 1);
            if($data['secundario'] != null) {
                $this->model->insertDiagnosticoCirugia($result, $data['secundario'], 2);
            }

            $this->insertarCirujanoPrimerYSegPrimario($result, $data);
            $this->insertarCirujanoPrimerYSegSecundario($result, $data);
            $this->insertarCirujanoPrimerYSegTerciario($result, $data);

            $this->insertCajaQuirurgica($result, $data);

            $this->model->insertCirugiaPersona($result, $data['anestesista'], 4);
            $this->insertNeonatologo($data['neonatologo'], $result);
            $this->model->insertCirugiaPersona($result, $data['circulante'], 7);

            $this->insertInstrumentador($data['instrumentador'], $result);
            $this->model->insertCirugiaPersona($result, $data['tecnico'], 8);
            $this->model->insertCirugiaPersona($result, $idUsuario, 9);

                foreach($data['tecnologiaUsada'] as $tecnologia){

                    $this->model->insertarTecnologiaCirugia($tecnologia, $result);

            }

            $this->model->insertEspQuirurgica($result, $data['espquirurgica'], 1);
            if ($data['espquirurgica1'] != null && $data['espquirurgica1'] != 0) {
                $this->model->insertEspQuirurgica($result, $data['espquirurgica1'], 2);
            }
            if ($data['espquirurgica2'] != null && $data['espquirurgica2'] != 0) {
                $this->model->insertEspQuirurgica($result, $data['espquirurgica2'], 3);
            }

            $this->insertUnidadFuncional($result, $data);
            $this->insertSitioAnatomico($result, $data);
            $this->insertActoQuirurgico($result, $data);
            $this->insertCodigo($result, $data);
            $this->insertMaterialProtesico($result, $data);

            $this->model->insertLugarCirugia($result, $data['lugarProviene'], 1);
            $this->model->insertLugarCirugia($result, $data['lugarEgreso'], 2);





            header('Location:' . $baseUrl . "quirurgico");
        }
    }

    private function obtenerDatosDelPost(): array
    {
        $data = [
            'paciente' => $_POST['paciente'],
            'fecha' => $_POST['fechaCirugia'],
            'primario' => $_POST['primario'],
            'secundario' => $_POST['secundario'],
            'asa' => $_POST['asa'],
            'espquirurgica' => $_POST['espQuirurgica_0'],
            'espquirurgica1' => $_POST['espQuirurgica_1'] ?? null,
            'espquirurgica2' => $_POST['espQuirurgica_2'] ?? null,
            'unidadFuncional' => $_POST['idUnidadFuncionalSeleccionada_0'] ,
            'unidadFuncional1' => $_POST['idUnidadFuncionalSeleccionada_1'] ?? null,
            'unidadFuncional2' => $_POST['idUnidadFuncionalSeleccionada_2'] ?? null,
            'sitioAnatomico' => $_POST['idSitioAnatomicoSeleccionada_0'],
            'sitioAnatomico1' => $_POST['idSitioAnatomicoSeleccionada_1'] ?? null,
            'sitioAnatomico2' => $_POST['idSitioAnatomicoSeleccionada_2'] ?? null,
            'actoQuirurgico' => $_POST['idActoQuirurgicoSeleccionado_0'],
            'actoQuirurgico1' => $_POST['idActoQuirurgicoSeleccionado_1'] ?? null,
            'actoQuirurgico2' => $_POST['idActoQuirurgicoSeleccionado_2'] ?? null,
            'cirujano' => $_POST['cirujanoSeleccionado_0'],
            'cirujano1' => $_POST['cirujanoSeleccionado_1'] ?? null,
            'cirujano2' => $_POST['cirujanoSeleccionado_2'] ?? null,
            'primerAyudante' => $_POST['primerSeleccionado_0'] ?? null,
            'primerAyudante1' => $_POST['primerSeleccionado_1'] ?? null,
            'primerAyudante2' => $_POST['primerSeleccionado_2'] ?? null,
            'segundoAyudante' => $_POST['segundoSeleccionado_0'] ?? null,
            'segundoAyudante1' => $_POST['segundoSeleccionado_1'] ?? null,
            'segundoAyudante2' => $_POST['segundoSeleccionado_2'] ?? null,
            'anestesista' => $_POST['anestesistaSeleccionado'],
            'circulante' => $_POST['circulanteSeleccionado'],
            'neonatologo' => $_POST['neoSeleccionado'],
            'tecnico' => $_POST['tecnicoSeleccionado'],
            'instrumentador' => $_POST['instrumentadorSeleccionado'],
            'tipoAnestesia' => $_POST['idTipoDeAnestesia'],
            'horaInicio' => $_POST['horaInicio'],
            'horaFin' => $_POST['horaFin'],
            'lugarProviene' => $_POST['lugarProviene'],
            'lugarEgreso' => $_POST['lugarEgreso'],
            'cajaQuirurgica' => $_POST['idCajaQuirurgica_0'] ?? null,
            'cajaQuirurgica2' => $_POST['idCajaQuirurgica_1'] ?? null,
            'cajaQuirurgica3' => $_POST['idCajaQuirurgica_2'] ?? null,
            'cajaQuirurgica4' => $_POST['idCajaQuirurgica_3'] ?? null,
            'tipoCirugia' => $_POST['tipoCirugia'],
            'moduloAnestesia' => $_POST['moduloAnestesia'],
            'tecnologiaUsada' => $_POST['tecnologiasUsadas'],
            'codigo' => $_POST['idCodigoSeleccionado_0'] ?? null,
            'codigo1' => $_POST['idCodigoSeleccionado_1'] ?? null,
            'codigo2' => $_POST['idCodigoSeleccionado_2'] ?? null,
            'materialProtesico' => $_POST['materialProtesico_0'] ?? null,
            'materialProtesico2' => $_POST['materialProtesico_1'] ?? null,
            'materialProtesico3' => $_POST['materialProtesico_2'] ?? null,
            'observacion' => $_POST['detalle'],
            'conteo' => $_POST['conteo'],
            'numeroQuirofano' => $_POST['numeroQuirofano'],
           'radiograma' => $_POST['radiograma'],
            'hemoterapia' => $_POST['hemoterapia'],
           'cultivo' => $_POST['cultivo'],
            'anatomiaPatologica' => $_POST['anatomiaPatologica'],
            'horaIngresoAlCentroQuirurgico' => $_POST['horaIngresoAlCentroQuirurgico'],
            'horaEgreso' => $_POST['horaEgreso'],
            'horaNac' => $_POST['horaNac'],
            'cantidadDeMaterial' => $_POST['cantidadMaterial_0'] ?? null,
            'cantidadDeMaterial2' => $_POST['cantidadMaterial_1'] ?? null,
            'cantidadDeMaterial3' => $_POST['cantidadMaterial_2'] ?? null

        ];
        return $data;
    }


    private function insertarCirujanoPrimerYSegPrimario($result, array $data)
    {
        $this->model->insertCirugiaPersonaCirujano($result, $data['cirujano'], 1, 1);
        if ($data['primerAyudante'] != null && $data['primerAyudante'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['primerAyudante'], 2, 1);
        }
        if ($data['segundoAyudante'] != null && $data['segundoAyudante'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['segundoAyudante'], 3, 1);
        }
    }

    private function insertarCirujanoPrimerYSegSecundario($result, array $data)
    {

        if($data['cirujano1'] != null && $data['cirujano1'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['cirujano1'], 1, 2);
        }

        if ($data['primerAyudante1'] != null && $data['primerAyudante1'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['primerAyudante1'], 2, 2);
        }
        if ($data['segundoAyudante1'] != null && $data['segundoAyudante1'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['segundoAyudante1'], 3, 2);
        }
    }
    private function insertarCirujanoPrimerYSegTerciario($result, array $data)
    {
        if($data['cirujano2'] != null && $data['cirujano2'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['cirujano2'], 1, 3);
        }

        if ($data['primerAyudante2'] != null && $data['primerAyudante2'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['primerAyudante2'], 2, 3);
        }
        if ($data['segundoAyudante2'] != null && $data['segundoAyudante2'] != 0) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['segundoAyudante2'], 3, 3);
        }
    }


    private function insertEspQuirurgica($result, array $data)
    {
        var_dump($data['espquirurgica']);
        $this->model->insertEspQuirurgica($result, $data['espquirurgica'], 1);
        if ($data['espquirurgica1'] != null && $data['espquirurgica1'] != 0) {
            $this->model->insertEspQuirurgica($result, $data['espquirurgica1'], 2);
        }
        if ($data['espquirurgica2'] != null && $data['espquirurgica2'] != 0) {
            $this->model->insertEspQuirurgica($result, $data['espquirurgica2'], 3);
        }
    }


    private function insertUnidadFuncional($result, array $data)
    {
        $this->model->insertCirugiaUnidadFuncional($result, $data['unidadFuncional'], 1);
        if ($data['unidadFuncional1'] != null && $data['unidadFuncional1'] != 0) {
            $this->model->insertCirugiaUnidadFuncional($result, $data['unidadFuncional1'], 2);
        }
        if ($data['unidadFuncional2'] != null && $data['unidadFuncional2'] != 0) {
            $this->model->insertCirugiaUnidadFuncional($result, $data['unidadFuncional2'], 3);
        }
    }


    private function insertSitioAnatomico($result, array $data)
    {
        $this->model->insertCirugiaSitioAnatomico($result, $data['sitioAnatomico'], 1);
        if ($data['sitioAnatomico1'] != null && $data['sitioAnatomico1'] != 0) {
            $this->model->insertCirugiaSitioAnatomico($result, $data['sitioAnatomico1'], 2);
        }
        if ($data['sitioAnatomico2'] != null  && $data['primerAyudante'] != 0) {
            $this->model->insertCirugiaSitioAnatomico($result, $data['sitioAnatomico2'], 3);
        }
    }


    private function insertActoQuirurgico($result, array $data)
    {
        $this->model->insertActoQuirurgico($result, $data['actoQuirurgico'], 1);
        if ($data['actoQuirurgico1'] != null && $data['actoQuirurgico1'] != 0) {
            $this->model->insertActoQuirurgico($result, $data['actoQuirurgico1'], 2);
        }
        if ($data['actoQuirurgico2'] != null && $data['actoQuirurgico2'] != 0) {
            $this->model->insertActoQuirurgico($result, $data['actoQuirurgico2'], 3);
        }
    }


    private function insertMaterialProtesico($result, array $data)
    {
        if ($data['materialProtesico'] != null && $data['materialProtesico'] != 0 && $data['cantidadDeMaterial'] != 0) {

            $this->model->insertMaterialProtesico($data['materialProtesico'], $result, 1, $data['cantidadDeMaterial']);
        }
        if ($data['materialProtesico2'] != null && $data['primerAyudante'] != 0 && $data['cantidadDeMaterial2'] != 0) {
            $this->model->insertMaterialProtesico($data['materialProtesico2'], $result, 2, $data['cantidadDeMaterial2']);
        }
        if ($data['materialProtesico3'] != null && $data['primerAyudante'] != 0 && $data['cantidadDeMaterial3'] != 0) {
            $this->model->insertMaterialProtesico($data['materialProtesico3'], $result, 3, $data['cantidadDeMaterial3']);
        }
    }


    private function insertCodigo($result, array $data)
    {
        if ($data['codigo'] != null && $data['codigo'] != 0) {
            $this->model->insertCodigoCirugia($result, $data['codigo'], 1);
        }

        if ($data['codigo1'] != 0 && $data['codigo1'] != null) {
            $this->model->insertCodigoCirugia($result, $data['codigo1'], 2);
        }
        if ($data['codigo2'] != 0 && $data['codigo2'] != null) {
            $this->model->insertCodigoCirugia($result, $data['codigo2'], 3);
        }
    }


    private function insertInstrumentador($instrumentador, $result)
    {
        if ($instrumentador != null && $instrumentador != 0) {
            $this->model->insertCirugiaPersona($result, $instrumentador, 6);
        }
    }


    private function insertNeonatologo($neonatologo, $result)
    {
        if ($neonatologo != null && $neonatologo != 0) {
            $this->model->insertCirugiaPersona($result, $neonatologo, 5);
        }
    }


    private function insertCajaQuirurgica($result, array $data)
    {
        if($data['cajaQuirurgica'] != null && $data['cajaQuirurgica'] != 0) {
            $this->model->insertCajaQuirurgica($result, $data['cajaQuirurgica'], 1);
        }

        if ($data['cajaQuirurgica2'] != null && $data['cajaQuirurgica2'] != 0) {
            $this->model->insertCajaQuirurgica($result, $data['cajaQuirurgica2'], 2);
        }
        if ($data['cajaQuirurgica3'] != null && $data['cajaQuirurgica3'] != 0) {
            $this->model->insertCajaQuirurgica($result, $data['cajaQuirurgica3'], 3);
        }
        if ($data['cajaQuirurgica4'] != null && $data['cajaQuirurgica4'] != 0) {
            $this->model->insertCajaQuirurgica($result, $data['cajaQuirurgica4'], 4);
        }
    }
}