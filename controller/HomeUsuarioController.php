<?php

class HomeUsuarioController
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


        if (!isset($_SESSION['usuario'])) {

            header("Location: /login");
            exit();
        }
    }

    public function login()
    {
        session_start();
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        $resultado = $this->model->iniciarSession($usuario, $password);

        $this->redirigirResultadoLogin($resultado);

    }


    private function redirigirResultadoLogin($resultado)
    {
        if ($resultado == 1) {
            header("Location:/home");
            exit();
        } else {
            header("Location:/login");
            exit();
        }
    }


}