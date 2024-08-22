<?php

class ActoQuirurgicoController
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
        $this->presenter->render("view/actoQuirurgicoOpcion.mustache");
    }

    public function irANuevoActoQuirurgico()
    {
        $espQuirurgicas = $this->model->obtenerEspQuirurgicas();
        $this->presenter->render("view/actoQuirurgicoNuevo.mustache", ["espquirurgica" => $espQuirurgicas]);
    }

    public function ajaxObtenerUnidadesFuncionales()
    {
        header('Content-Type: application/json');
        if (isset($_GET['idEspQuirurgica'])) {
            $idEspQuirurgica = $_GET['idEspQuirurgica'];

            $resultados = $this->model->obtenerUnidadesFuncionales($idEspQuirurgica);
            echo json_encode($resultados);
        }
    }

    public function ajaxObtenerSitiosAnatomicos()
    {
        header('Content-Type: application/json');
        if (isset($_GET['idUnidadFuncional'])) {
            $idUnidadFuncional = $_GET['idUnidadFuncional'];
            $resultados = $this->model->obtenerSitiosAnatomicos($idUnidadFuncional);
            echo json_encode($resultados);
        }
    }
}