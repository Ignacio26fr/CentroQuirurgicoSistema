<?php


use http\Client\Request;

class QuirurgicoController
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

        $this->presenter->render("view/formulario.mustache");
    }

    public function getPaciente()
    {
        $quirurgico = $this->model->getPaciente();

    }

    public function buscarPorDni($dni)
    {

        $resultados = $this->model->buscarPaciente($dni);




    }







}