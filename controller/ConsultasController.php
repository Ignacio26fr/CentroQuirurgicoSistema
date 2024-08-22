<?php

class ConsultasController
{


    private $presenter;
    private $database;

    public function __construct($presenter, $database)
    {

        $this->presenter = $presenter;
        $this->database = $database;
    }

    public function get()
    {
        session_start();
        $nombreUsuario = $this->database->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        if($nombreUsuario != null) {
            $this->presenter->render("view/consultas.mustache");
        } else {
            header("Location: /login");
        }
    }

    public function dejarComentario()
    {
        session_start();
        $nombreUsuario = $this->database->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        if($nombreUsuario != null) {
            $this->presenter->render("view/comentarios.mustache");
        }else {
            header("Location: /login");
        }
    }

    public function mandarComentario()
    {
        session_start();
        $nombreUsuario = $this->database->verificarSiHayUnaSessionIniciada($_SESSION["usuario"]);
        if($nombreUsuario != null) {
            if (isset($_POST['comentario']) && !empty($_POST['comentario'])) {
                $idUsuario = $this->database->obtenerUsuario($nombreUsuario);
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $this->database->mandarConsulta($_POST['comentario'], $idUsuario, date('Y-m-d H:i:s'));
                $this->presenter->render("view/comentarioExito.mustache");
            } else {
                header("Location: /homeUsuario");
            }
        } else {
            header("Location: /login");
        }
}






}