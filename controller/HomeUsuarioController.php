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
        $baseUrl = Configuration::getBaseUrl();
        if (!isset($_SESSION["usuario"])) {
            header("Location:" .  $baseUrl . "login");
            exit();
        }
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        $rol = $this->model->verificarRolUsuario($nombreUsuario);
        if($rol == 'ADMIN' || $rol == 'INSTRUMENTADOR' || $rol == 'ANESTESISTA') {

            if ($nombreUsuario) {
                $this->presenter->render("view/home.mustache", ["nombreUsuario" => $nombreUsuario, "rol" => $rol]);
            } else {
                header("Location:" .  $baseUrl . "login");
                exit();
            }
        } else {
            header("Location:" .  $baseUrl . "login");
            exit();
        }


    }

    public function logout()
    {
        session_start();

        session_destroy();
        $baseUrl = Configuration::getBaseUrl();

        header("Location:" .  $baseUrl . "login");
    }



}