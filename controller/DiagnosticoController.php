<?php

class DiagnosticoController
{

    private $model;
    private $presenter;


    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function get(){
        $this->presenter->render("view/diagnosticoOpcion.mustache");
    }

    public function nuevoDiagnostico()
    {
        $this->presenter->render("view/diagnosticoNuevo.mustache");
    }

    public function insertarDiagnostico()
    {
        session_start();
        $baseUrl = Configuration::getBaseUrl();
        $diagnostico = $_POST['diagnostico'];
        $resultado = $this->model->verificarSiExisteUnDiagnosticoConEseNombre($diagnostico);
        if($resultado){
            header("Location:" . $baseUrl . "homeUsuario");
            exit();
        } else {
            $this->model->nuevoDiagnostico($diagnostico);
            header("Location:" . $baseUrl . "diagnostico");

        }
        exit();

    }

    public function editarDiagnostico() {
        $this->presenter->render("view/diagnosticoEditar.mustache");
    }

    public function buscarDiagnostico()
    {
        $nombre = $_GET['nombre'];
        $diagnostico = $this->model->buscarDiagnosticoPorNombre($nombre);
        $this->presenter->render("view/diagnosticoEditar.mustache",["diagnosticos"=>$diagnostico]);

    }

    public function editarDiagnosticoSeleccionado(){
        $diagnostico = $this->model->obtenerDiagnosticoPorId($_GET["id"]);
        $this->presenter->render('view/diagnosticoEditar.mustache', ['diagnostico' => $diagnostico]);
    }

    public function obtenerElPostEditarDiagnostico(){
        session_start();
        $baseUrl = Configuration::getBaseUrl();
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];

        $this->model->updateDiagnostico($id, $nombre);
        header("Location:" . $baseUrl . "diagnostico");

    }

    public function eliminarDiagnosticoSeleccionado(){
        session_start();
        $baseUrl = Configuration::getBaseUrl();
        $diagnostico = $_GET["id"];

        if($diagnostico != null || $diagnostico != 0){
                $this->model->eliminarDiagnostico($diagnostico);
            header("Location:" . $baseUrl . "diagnostico");
        }else {
            header("Location:" . $baseUrl . "homeUsuario");
        }


    }

}