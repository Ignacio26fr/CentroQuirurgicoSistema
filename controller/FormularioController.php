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

$primario = $this->model->obtenerPrimario();
$espquirurgica = $this->model->obtenerEspecialidadQuirurgica();


$data = [
"primario" => $primario,
    "espquirurgica" => $espquirurgica


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
        if(isset($_GET['idEspQuirurgica'])){
            $idEspQuirurgica = $_GET['idEspQuirurgica'];
            $resultados = $this->model->obtenerUnidadesFuncionales($idEspQuirurgica);
            echo json_encode($resultados);
        }
    }

    public function obtenerSitiosAnatomicos()
    {
     header('Content-Type: application/json');
     if(isset($_GET['idUnidadFuncional'])){
         $idUnidadFuncional = $_GET['idUnidadFuncional'];
         $resultados = $this->model->obtenerSitiosAnatomicos($idUnidadFuncional);
         echo json_encode($resultados);
     }
    }
}
