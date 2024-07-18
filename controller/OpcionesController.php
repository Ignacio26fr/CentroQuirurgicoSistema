<?php


class OpcionesController
{

    private $presenter;

    public function __construct( $presenter)
    {
        $this->presenter = $presenter;
    }

    public function get(){

        $this->presenter->render("view/opciones.mustache");
    }

}