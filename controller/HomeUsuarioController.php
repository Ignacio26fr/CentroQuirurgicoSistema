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
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["name"]);
        if($nombreUsuario) {
            $this->presenter->render("view/home.mustache");
        }else{
            header("Location:/login");
        }


    }



}