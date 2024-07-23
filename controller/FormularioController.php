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

            echo json_encode($resultados);
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
        if (isset($_GET['filtroCodigo'])) {
            $filtroCodigo = $_GET['filtroCodigo'];
            $resultados = $this->model->obtenerCodigos($filtroCodigo);

            echo json_encode($resultados);
        }

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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = $this->obtenerDatosDelPost();


            if($data['cajaQuirurgica'] == '0' || $data['cajaQuirurgica'] == null){
                $data['cajaQuirurgica'] = null;
            }


            $result = $this->model->insertCirugia(
                $data['observacion'],
                $data['horaInicio'],
                $data['horaFin'],
                $data['fecha'],
                $data['tipoAnestesia'],
                $data['tipoCirugia'],
                $data['cajaQuirurgica'],
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
                 $data['anatomiaPatologica']
            );



            $this->model->insertDiagnosticoCirugia($result, $data['primario'], 1);
            if($data['secundario'] != null) {
                $this->model->insertDiagnosticoCirugia($result, $data['secundario'], 2);
            }

            $this->insertarCirujanoPrimerYSegPrimario($result, $data);
            $this->insertarCirujanoPrimerYSegSecundario($result, $data);




            $this->model->insertCirugiaPersona($result, $data['anestesista'], 4);
            if($data['neonatologo'] != null) {
                $this->model->insertCirugiaPersona($result, $data['neonatologo'], 5);
            }

                foreach($data['tecnologiaUsada'] as $tecnologia){

                    $this->model->insertarTecnologiaCirugia($tecnologia, $result);

            }

            $this->insertEspQuirurgica($result, $data);
            $this->insertUnidadFuncional($result, $data);
            $this->insertSitioAnatomico($result, $data);

            $this->insertActoQuirurgico($result, $data);

            $this->model->insertCodigoCirugia($result, $data['codigo']);
            $this->model->insertLugarCirugia($result, $data['lugarProviene'], 1);
            $this->model->insertLugarCirugia($result, $data['lugarProviene'], 2);
            if($data['materialProtesico' != null]){
                $this->model->insertMaterialProtesico($data['materialProtesico'], $result, 1, $data['cantidadDeMaterialPrimario']);
            }




            header('Location: /quirurgico');
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
            'neonatologo' => $_POST['neoSeleccionado'],
            'tecnico' => $_POST['tecnicoSeleccionado'],
            'tipoAnestesia' => $_POST['idTipoDeAnestesia'],
            'horaInicio' => $_POST['horaInicio'],
            'horaFin' => $_POST['horaFin'],
            'lugarProviene' => $_POST['lugarProviene'],
            'lugarEgreso' => $_POST['lugarEgreso'],
            'cajaQuirurgica' => $_POST['idCajaQuirurgica'],
            'tipoCirugia' => $_POST['tipoCirugia'],
            'tecnologiaUsada' => $_POST['tecnologiasUsadas'],
            'codigo' => $_POST['codigosSeleccionado'],
            'materialProtesico' => $_POST['materialProtesicoPrimario'],
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
            'cantidadDeMaterialPrimario' => $_POST['cantidadDeMaterialPrimario']
        ];
        return $data;
    }


    private function insertarCirujanoPrimerYSegPrimario($result, array $data)
    {
        $this->model->insertCirugiaPersonaCirujano($result, $data['cirujano'], 1, 1);
        if ($data['primerAyudante'] != null) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['primerAyudante'], 2, 1);
        }
        if ($data['segundoAyudante'] != null) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['segundoAyudante'], 3, 1);
        }
    }
    private function insertarCirujanoPrimerYSegSecundario($result, array $data)
    {

        if($data['cirujano1'] != null) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['cirujano1'], 1, 2);
        }

        if ($data['primerAyudante1'] != null) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['primerAyudante1'], 2, 2);
        }
        if ($data['segundoAyudante1'] != null) {
            $this->model->insertCirugiaPersonaCirujano($result, $data['segundoAyudante1'], 3, 2);
        }
    }


    private function insertEspQuirurgica($result, array $data)
    {
        $this->model->insertEspQuirurgica($result, $data['espquirurgica'], 1);
        if ($data['espquirurgica1'] != null) {
            $this->model->insertEspQuirurgica($result, $data['espquirurgica1'], 2);
        }
        if ($data['espquirurgica2'] != null) {
            $this->model->insertEspQuirurgica($result, $data['espquirurgica2'], 3);
        }
    }


    private function insertUnidadFuncional($result, array $data)
    {
        $this->model->insertCirugiaUnidadFuncional($result, $data['unidadFuncional'], 1);
        if ($data['unidadFuncional1'] != null) {
            $this->model->insertCirugiaUnidadFuncional($result, $data['unidadFuncional1'], 2);
        }
        if ($data['unidadFuncional2'] != null) {
            $this->model->insertCirugiaUnidadFuncional($result, $data['unidadFuncional2'], 3);
        }
    }


    private function insertSitioAnatomico($result, array $data)
    {
        $this->model->insertCirugiaSitioAnatomico($result, $data['sitioAnatomico'], 1);
        if ($data['sitioAnatomico1'] != null) {
            $this->model->insertCirugiaSitioAnatomico($result, $data['sitioAnatomico1'], 2);
        }
        if ($data['sitioAnatomico2'] != null) {
            $this->model->insertCirugiaSitioAnatomico($result, $data['sitioAnatomico2'], 3);
        }
    }

    /**
     * @param $result
     * @param array $data
     * @return void
     */
    public function insertActoQuirurgico($result, array $data)
    {
        $this->model->insertActoQuirurgico($result, $data['actoQuirurgico'], 1);
        if ($data['actoQuirurgico1'] != null) {
            $this->model->insertActoQuirurgico($result, $data['actoQuirurgico1'], 2);
        }
        if ($data['actoQuirurgico2'] != null) {
            $this->model->insertActoQuirurgico($result, $data['actoQuirurgico2'], 3);
        }
    }
}