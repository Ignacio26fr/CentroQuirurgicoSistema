<?php

class LoginModel {


    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUsuario()
    {
        return $this->database->query("Select * from persona");

    }

    public function buscarUsuario($usuario, $password)
    {
        $query = "SELECT * FROM persona where matricula = '$usuario' and contrasenia = '$password'";
        echo "Consulta SQL: $query<br>";
        return $this->database->executeAndReturn($query);

    }

    public function iniciarSesion($usuario, $password)
    {
        $seInicioSession = $this->obtenerResultadoDeLogin($usuario, $password);

        return $seInicioSession;

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
        if ($this->seEncontroUnResultado($resultado)) {
            $_SESSION['name'] = $usuario;
            $seInicioSession = 1;
        } else {
            $seInicioSession = 2;
        }
        return $seInicioSession;
    }

    private function seEncontroUnResultado($resultado){
        return mysqli_num_rows($resultado) == 1;
    }
}