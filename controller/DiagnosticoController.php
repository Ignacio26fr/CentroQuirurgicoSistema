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
        $diagnostico = $_POST['diagnostico'];
        var_dump($diagnostico);
        $resultado = $this->model->verificarSiExisteUnDiagnosticoConEseNombre($diagnostico);
        var_dump($resultado);
        if($resultado){
            header("Location: /homeUsuario");
            exit();
        } else {
            $this->model->nuevoDiagnostico($diagnostico);
            header("Location: /diagnostico");

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
        $nombre = $_POST['nombre'];
        $id = $_POST['id'];

        $this->model->updateDiagnostico($id, $nombre);
        header("Location: /diagnostico");

    }

    public function eliminarDiagnosticoSeleccionado(){
        $diagnostico = $_GET["id"];

        if($diagnostico != null || $diagnostico != 0){
                $this->model->eliminarDiagnostico($diagnostico);
                header("Location: /diagnostico");
        }else {
            header("Location: /homeUsuario");
        }


    }

}