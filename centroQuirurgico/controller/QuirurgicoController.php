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
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location:/login");
            exit(); // Asegura que el script se detiene después de la redirección
        }
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        $rol = $this->model->verificarRolUsuario($nombreUsuario);
        if($rol == 'ADMIN' || $rol == 'INSTRUMENTADOR') {
            $this->presenter->render("view/obtenerPaciente.mustache" ,["rol" => $rol]);
        } else {
            header("Location: /homeUsuario");
        }
    }

    public function getPaciente()
    {
        $quirurgico = $this->model->getPaciente();

    }

    public function buscarPorDni()
    {
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location:/login");
            exit(); 
        }
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        $rol = $this->model->verificarRolUsuario($nombreUsuario);
        if($rol == 'ADMIN' || $rol == 'INSTRUMENTADOR') {
            if (isset($_POST['dni'])) {
                $dni = $_POST['dni'];
                $resultados = [];
                $resultados = $this->model->buscarPaciente($dni);

                $this->presenter->render("view/obtenerPaciente.mustache", ["resultados" => $resultados, "rol" => $rol]);

            } else {
                echo "No se ingreso un dni";
            }
        } else {
            header("Location: /homeUsuario");
        }

    }

    public function obtenerPacienteSeleccionado()
    {
        session_start();
        if (isset($_POST['paciente'])) {
            $paciente = $_POST['paciente'];

            $_SESSION['paciente'] = $paciente;
            header('Location: /formulario');


        }
    }



}