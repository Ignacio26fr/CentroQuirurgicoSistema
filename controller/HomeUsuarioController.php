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
        if (!isset($_SESSION["usuario"])) {
            header("Location:/login");
            exit();
        }
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        $rol = $this->model->verificarRolUsuario($nombreUsuario);
        if($rol == 'ADMIN' || $rol == 'INSTRUMENTADOR' || $rol == 'ANESTESISTA') {

            if ($nombreUsuario) {

                $this->presenter->render("view/home.mustache", ["nombreUsuario" => $nombreUsuario, "rol" => $rol]);
            } else {
                header("Location:/login");
            }
        } else {
            header("Location:/login");
        }


    }

    public function logout()
    {
        session_start();

        session_destroy();

        header("Location:/login");
    }



}