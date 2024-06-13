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

        $this->presenter->render("view/obtenerPaciente.mustache");
    }

    public function getPaciente()
    {
        $quirurgico = $this->model->getPaciente();

    }

    public function buscarPorDni()
    {
        if (isset($_POST['dni'])) {
            $dni = $_POST['dni'];
            $resultados = [];
            $resultados = $this->model->buscarPaciente($dni);

            $this->presenter->render("view/obtenerPaciente.mustache", ["resultados" => $resultados]);

        } else {
            echo "No se ingreso un dni";
        }

    }

    public function obtenerPacienteSeleccionado()
    {

        if (isset($_POST['paciente'])) {
            $paciente = $_POST['paciente'];

            //Aca le tengo que pasar el id del paciente a la vista
            header('Location:/formulario');

        }
    }



}