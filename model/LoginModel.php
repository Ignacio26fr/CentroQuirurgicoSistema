<?php

class LoginModel {


    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function buscarUsuario($usuario, $password)
    {
        return $this->database->excuteAndReturn("Select * from persona where usuario = '$usuario' and password = '$password'");

    }

    public function iniciarSesion($usuario, $password)
    {
        $seInicioSession = $this->obtenerResultadoDeLogin($usuario, $password);
        return $seInicioSession;

    }



    private function seEncontroResultado($resultado){
        return mysqli_num_rows($resultado) == 1;
    }



    private function obtenerResultadoDeLogin($usuario, $password): int
    {
        $seInicioSession = 0;
        if (isset($usuario) && isset($password)) {
            $resultado = $this->buscarUsuario($usuario, $password);

            $seInicioSession = $this->verificarSiSeEncuentra($resultado, $usuario);


        } else {
            $seInicioSession = 3;
        }
        return $seInicioSession;
    }


    private function verificarSiSeEncuentra($resultado, $usuario): int
    {
        if ($this->seEncontroResultado($resultado)) {
            $_SESSION['name'] = $usuario;
            $seInicioSession = 1;
        } else {
            $seInicioSession = 2;
        }
        return $seInicioSession;
    }
}