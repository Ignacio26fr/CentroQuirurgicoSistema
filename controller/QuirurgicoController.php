<?php

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
        $quirurgico = $this->model->getQuirurgico();
        $this->presenter->render("");
    }

}