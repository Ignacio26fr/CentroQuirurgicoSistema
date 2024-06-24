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

        $data = [
            "primario" => $primario,
            "espquirurgica" => $espquirurgica,
            "tipoAnestesia" => $tipoAnestesia,
            "lugar" => $lugar,
            "tipoCirugia" => $tipoCirugia,
            "tecnologiaUsada" => $tecnologiaUsada,
            "paciente" => $paciente

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

    public function obtenerActosQuirurgicoPrincipales()
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
            $data =[
                'paciente' => $_POST['paciente'],
                'primario' => $_POST['primario'],
                'secundario' => $_POST['secundario'],
                'asa' => $_POST['asa'],
                'espquirurgica' => $_POST['espQuirurgica'],
                'unidadFuncional' => $_POST['idUnidadFuncionalSeleccionada'],
                'sitioAnatomico' => $_POST['idSitioAnatomicoSeleccionada'],
                'actoQuirurgico' => $_POST['idActoQuirurgicoPrincipalSeleccionado'],
                'cirujano'=> $_POST['cirujanoSeleccionado'],
                'primerAyudante' => $_POST['primerSeleccionado'],
                'segundoAyudante' => $_POST['segundoSeleccionado'],
                'anestesista' => $_POST['anestesistaSeleccionado'],
                'neonatolo' => $_POST['neoSeleccionado'],
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
                'observacion' => $_POST['detalle']

            ];

             $result = $this->model->insertCirugia($data['observacion'], $data['horaInicio'], $data['horaFin'], null, $data['actoQuirurgico'], $data['tipoAnestesia'], $data['tipoCirugia'], $data['espquirurgica'], $data['cajaQuirurgica'], $data['paciente'], $data['sitioAnatomico'], $data['unidadFuncional']);



             $this->model->insertCirugiaPersona($result, $data['cirujano'], 1);
                $this->model->insertCirugiaPersona($result, $data['primerAyudante'], 2);
                $this->model->insertCirugiaPersona($result, $data['segundoAyudante'], 3);
                $this->model->insertCirugiaPersona($result, $data['anestesista'], 4);



        }
    }


}