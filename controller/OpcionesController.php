<?php


class OpcionesController
{

    private $presenter;
    private $model;

    public function __construct($model, $presenter)
    {
        $this->presenter = $presenter;
        $this->model = $model;
    }

    public function get(){
        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("Location:/login");
            exit(); // Asegura que el script se detiene después de la redirección
        }
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        $rol = $this->model->verificarRolUsuario($nombreUsuario);
        if ($rol == 'ADMIN') {
            $this->presenter->render("view/opciones.mustache", ["rol" => $rol]);

        } else {
            header("Location: /homeUsuario");
        }
    }

}