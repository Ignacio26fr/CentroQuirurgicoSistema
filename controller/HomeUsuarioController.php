<?php

class HomeUsuarioController
{
    private $model;
    private $presenter;


    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $model;
    }

    public function get()
    {
        $usuarios = $this->model->getUsuarios();
        

    }
}