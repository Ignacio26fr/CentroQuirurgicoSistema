<?php


class LoginController
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

        $this->presenter->render("view/login.mustache");

        }


    public function login()
    {
        session_start();

        $usuario = $_POST["usuario"];
        $password = $_POST["password"];


        $resultado = $this->model->iniciarSesion($usuario, $password);
        $this->guardarEnSession($resultado, $usuario);
        $this->redirigirResultadoLogin($resultado);

    }


    private function redirigirResultadoLogin($resultado)
    {
        if($resultado == 1) {

            header("Location:/homeUsuario");
        } else {
            header("Location:/login");
        }
        exit();
    }


    private function guardarEnSession($resultado, $usuario)
    {
        if ($resultado) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id'] = $resultado;
        }
    }


}