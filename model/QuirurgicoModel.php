<?php

class QuirurgicoModel
{


    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPaciente()
    {
        $query = "Select * from paciente";
        return $this->database->executeAndReturn($query);

    }

    public function buscarPaciente($dni)
    {

        $query = "SELECT * FROM paciente where dni = '$dni'";

        $result = $this->database->executeAndReturn($query);
        $resulte = $result->fetch_assoc();
        return $resulte;
    }

    public function verificarSiHayUnaSessionIniciada($session){
        return isset($session) ? $session : null;
    }

    public function verificarRolUsuario($idUsuario) {
        $query = "SELECT rol FROM persona WHERE matricula = $idUsuario";
        $result = $this->database->query($query);
        return !empty($result) ? $result[0]['rol'] : null;

    }


    public function obtenerPrimario()
    {

        $query = "SELECT * FROM diagnostico";

        return $this->database->executeAndReturn($query);
    }

    public function obtenerEspecialidadQuirurgica()
    {
        $query = "SELECT * FROM especialidadquirurgica";
        return $this->database->executeAndReturn($query);
    }

    public function obtenerDiagnosticoSecu($filtro)
    {
        $query = "SELECT * FROM diagnostico WHERE nombre LIKE '%$filtro%'";
        $resultados = $this->database->executeAndReturn($query);

        $diagnosticos = array();
        while ($row = $resultados->fetch_assoc()) {
            $diagnostico = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $diagnosticos[] = $diagnostico;
        }

        return $diagnosticos;
    }

    public function obtenerDiagnosticoPrimario($filtro)
    {
        $query = "SELECT * FROM diagnostico WHERE nombre LIKE '%$filtro%'";
        $resultados = $this->database->executeAndReturn($query);

        $diagnosticos = array();
        while ($row = $resultados->fetch_assoc()) {
            $diagnostico = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $diagnosticos[] = $diagnostico;
        }

        return $diagnosticos;
    }

    public function obtenerUnidadesFuncionales($idEspQuirurgica)
    {
        $query = "SELECT * FROM unidadFuncional where idEspQuirurgica = $idEspQuirurgica";
        $resultados = $this->database->executeAndReturn($query);

        $unidadesFuncionales = array();
        while ($row = $resultados->fetch_assoc()) {
            $unidadFuncional = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $unidadesFuncionales[] = $unidadFuncional;
        }
        return $unidadesFuncionales;

    }

    public function obtenerSitiosAnatomicos($idUnidadFuncional)
    {
        $query = "SELECT * from sitioanatomico where idUnidadFuncional = $idUnidadFuncional";
        $resultados = $this->database->executeAndReturn($query);

        $sitiosAnatomicos = array();
        while ($row = $resultados->fetch_assoc()) {
            $sitioAnatomico = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $sitiosAnatomicos[] = $sitioAnatomico;
        }
        return $sitiosAnatomicos;
    }

    public function obtenerActosQuirurgicos($idSitioAnatomico)
    {
        $query = "SELECT * FROM nombrecirugia where idSitioAnatomico = $idSitioAnatomico";
        $resultados = $this->database->executeAndReturn($query);

        $actosQuirurgicos = array();
        while ($row = $resultados->fetch_assoc()) {
            $actoQuirurgico = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $actosQuirurgicos[] = $actoQuirurgico;
        }
        return $actosQuirurgicos;
    }

    public function obtenerCirujanos($filtroCirujano)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtroCirujano%' or apellido LIKE '%$filtroCirujano%' or matricula LIKE '%$filtroCirujano%') and idEspecialidad = 2 ";
        $resultados = $this->database->executeAndReturn($query);

        $cirujanos = array();
        while ($row = $resultados->fetch_assoc()) {
            $cirujano = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $cirujanos[] = $cirujano;
        }
        return $cirujanos;
    }

    public function obtenerAnestesista($filtro)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtro%' or apellido LIKE '%$filtro%' or matricula LIKE '%$filtro%') and idEspecialidad = 5 or idEspecialidad = 7";
        $resultados = $this->database->executeAndReturn($query);

        $anestesistas = array();
        while ($row = $resultados->fetch_assoc()) {
            $anestesista = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $anestesistas[] = $anestesista;
        }
        return $anestesistas;
    }
    public function obtenerInstrumentador($filtro)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtro%' or apellido LIKE '%$filtro%' or matricula LIKE '%$filtro%') and idEspecialidad = 6 or idEspecialidad = 7 ";
        $resultados = $this->database->executeAndReturn($query);

        $anestesistas = array();
        while ($row = $resultados->fetch_assoc()) {
            $anestesista = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $anestesistas[] = $anestesista;
        }
        return $anestesistas;
    }

    public function obtenerNeo($filtro)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtro%' or apellido LIKE '%$filtro%' or matricula LIKE '%$filtro%') and idEspecialidad = 3 ";
        $resultados = $this->database->executeAndReturn($query);

        $neonatologos = array();
        while ($row = $resultados->fetch_assoc()) {
            $neonatologo = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $neonatologos[] = $neonatologo;
        }
        return $neonatologos;
    }

    public function obtenerTecnico($filtro)
    {
        $query = "SELECT * FROM persona WHERE (nombre LIKE '%$filtro%' or apellido LIKE '%$filtro%' or matricula LIKE '%$filtro%') and idEspecialidad = 1 or idEspecialidad = 7";
        $resultados = $this->database->executeAndReturn($query);

        $tecnicos = array();
        while ($row = $resultados->fetch_assoc()) {
            $tecnico = array(
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'matricula' => $row['matricula']
            );
            $tecnicos[] = $tecnico;
        }
        return $tecnicos;
    }

    public function obtenerTipoAnestesia()
    {
        $query = "SELECT * FROM tipodeanestesia";
        $result = $this->database->executeAndReturn($query);
        $tipoAnestesia = array();
        while ($row = $result->fetch_assoc()) {
            $tipo = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $tipoAnestesia[] = $tipo;
        }

        return $tipoAnestesia;
    }

    public function obtenerLugar()
    {
        $query = "SELECT * FROM lugar";
        $result = $this->database->executeAndReturn($query);
        $lugares = array();
        while ($row = $result->fetch_assoc()) {
            $lugar = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $lugares[] = $lugar;
        }
        return $lugares;
    }

    public function obtnerCajaQuirurgica($filtro)
    {
        $query = "Select * from cajaquirurgica where nombre like '%$filtro%'";
        $resultado = $this->database->executeAndReturn($query);

        $cajas = array();
        while ($row = $resultado->fetch_assoc()) {
            $caja = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $cajas[] = $caja;
        }

        return $cajas;
    }

    public function obtenerCodigos($filtro)
    {
        $query = "Select * from codigopractica where nombre like '%$filtro%'";
        $resultado = $this->database->executeAndReturn($query);

        $codigos = array();
        while ($row = $resultado->fetch_assoc()) {
            $codigo = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $codigos[] = $codigo;
        }
        return $codigos;

    }

    public function obtenerTipoDeCirugia()
    {
        $query = "SELECT * FROM tipodecirugia";
        $result = $this->database->executeAndReturn($query);
        $tiposCirugia = array();
        while ($row = $result->fetch_assoc()) {
            $tipo = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $tiposCirugia[] = $tipo;
        }
        return $tiposCirugia;
    }

    public function obtenerMaterial($filtro)
    {
        $query = "Select * from materialprotesico where nombre like '%$filtro%'";
        $resultado = $this->database->executeAndReturn($query);

        $materiales = array();
        while ($row = $resultado->fetch_assoc()) {
            $material = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $materiales[] = $material;
        }
        return $materiales;

    }



    public function obtenerTecnologiaUsada()
    {
        $query = "SELECT * FROM tecnologia";
        $result = $this->database->executeAndReturn($query);
        $tecnologias = array();
        while ($row = $result->fetch_assoc()) {
            $tecnologia = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $tecnologias[] = $tecnologia;
        }
        return $tecnologias;
    }


    public function insertCirugia($observacion, $horaInicio, $horaFin, $fecha, $idTipoDeAnestesia,
                                  $idTipoDeCirugia, $idPaciente,
                                  $asa, $nroQuirofanoUsado, $horaIngresoCentroQuirurgico,
                                  $horaEgresoCentroQuirurgico, $horaDeNacimiento, $conteo, $radiografia, $hemoterapia,
                                  $cultivo, $anatomiaPatologica, $moduloAnestesia)
    {

        // Verifica el número de columnas y valores
        $query = "INSERT INTO cirugia (
        observacion,
        horaInicio,
        horaFin,
        fecha,
        idTipoDeAnestesia,
        idTipoDeCirugia,
        idPaciente,
        asa,
        nroQuirofanoUsado,
        horaIngresoCentroQuirurgico,
        horaEgresoCentroQuirurgico,
        horaDeNacimiento,
        conteo,
        radiografiaControl,
        hemoterapia,
        cultivo,
        anatomiaPatologica,
        idModuloAnestesia
    ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->database->prepare($query);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->database->getError());
        }

        // Realiza el bind de los parámetros
        $stmt->bind_param(
            "sssssssiisssiiiiis",
            $observacion,
            $horaInicio,
            $horaFin,
            $fecha,
            $idTipoDeAnestesia,
            $idTipoDeCirugia,
            $idPaciente,
            $asa,
            $nroQuirofanoUsado,
            $horaIngresoCentroQuirurgico,
            $horaEgresoCentroQuirurgico,
            $horaDeNacimiento,
            $conteo,
            $radiografia,
            $hemoterapia,
            $cultivo,
            $anatomiaPatologica,
            $moduloAnestesia
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        $idCirugia = $stmt->insert_id;
        $stmt->close();

        return $idCirugia;
    }


    public function insertCirugiaPersona($idCirugia, $idPersona, $idRolCirugia)
    {
        $query = "INSERT INTO cirugiapersona (idCirugia, idPersona, idRolCirugia) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idPersona, $idRolCirugia);

        $stmt->execute();
        $stmt->close();
    }
public function insertCirugiaPersonaCirujano($idCirugia, $idPersona, $idRolCirugia, $idTipo)
{
    $query = "INSERT INTO cirugiapersona (idCirugia, idPersona, idRolCirugia, idTipo) VALUES (?, ?, ?, ?)";
    $stmt = $this->database->prepare($query);
    $stmt->bind_param("ssss", $idCirugia, $idPersona, $idRolCirugia, $idTipo);

    $stmt->execute();
    $stmt->close();
}


public function insertTecnologiaCirugia($idCirugia, $idTecnologia)
    {
        $query = "INSERT INTO tecnologiacirugia (idCirugia, idTecnologia) VALUES (?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ss", $idCirugia, $idTecnologia);

        $stmt->execute();
        $stmt->close();
    }

    public function insertCodigoCirugia($idCirugia, $idCodigo, $idTipo)
    {
        $query = "INSERT INTO codigopracticacirugia (idCirugia, idCodigoPractica, tipo) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idCodigo, $idTipo);

        $stmt->execute();
        $stmt->close();
    }

    public function insertLugarCirugia($idCirugia, $idLugar, $idTipoLugar)
    {
        $query = "INSERT INTO cirugialugar (idCirugia, idLugar, idTipoLugar) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idLugar, $idTipoLugar);

        $stmt->execute();
        $stmt->close();
    }

    public function insertDiagnosticoCirugia($idCirugia, $idDiagnostico, $idTipo)
    {
        $query = "INSERT INTO diagnosticoCirugia (idCirugia, idDiagnostico, idTipo) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idDiagnostico, $idTipo);

        $stmt->execute();
        $stmt->close();
    }

    public function insertMaterialProtesico($idMaterial, $idCirugia, $idTipo, $cantidad)
    {
        $query = "INSERT INTO materialprotesicocirugia(idMaterialProtesico, idCirugia, idTipo, cantidad) VALUES (?, ?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ssss", $idMaterial, $idCirugia, $idTipo, $cantidad);
        $stmt->execute();
        $stmt->close();
    }

    public function insertarTecnologiaCirugia($idCirugia, $idTecnologia)
    {
        $query = "INSERT INTO tecnologiacirugia(idTecnologia, idCirugia) VALUES (?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ss", $idCirugia, $idTecnologia);
        $stmt->execute();
        $stmt->close();

     }

    public function insertEspQuirurgica($idCirugia, $idEspQuirurgica, $idTipo)
    {
        $query = "INSERT INTO cirugiaEspQuirurgica(idCirugia, idEspQuirurgica, idTipo) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idEspQuirurgica, $idTipo);
        $stmt->execute();
        $stmt->close();
    }
     public function insertCirugiaUnidadFuncional($idCirugia, $idUnidadFuncional, $idTipo)
     {
         $query = "INSERT INTO cirugiaunidadfuncional(idCirugia, idUnidadFuncional, idTipo) VALUES (?, ?, ?)";
         $stmt = $this->database->prepare($query);
         $stmt->bind_param("sss", $idCirugia, $idUnidadFuncional, $idTipo);
         $stmt->execute();
         $stmt->close();
     }

    public function insertCirugiaSitioAnatomico($idCirugia, $idSitioAnatomico, $idTipo)
    {
        $query = "INSERT INTO cirugiasitioanatomico(idCirugia, idSitioAnatomico, idTipo) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idSitioAnatomico, $idTipo);
        $stmt->execute();
        $stmt->close();
    }

    public function insertActoQuirurgico($idCirugia, $idActoQuirurgico, $idTipo)
    {
        $query = "INSERT INTO cirugianombreCirugia(idCirugia, idNombreCirugia, idTipo) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idActoQuirurgico, $idTipo);
        $stmt->execute();
        $stmt->close();
    }
    public function insertCajaQuirurgica($idCirugia, $idCajaQuirurgica, $idTipo)
    {
        $query = "INSERT INTO cirugiacajaquirurgica(idCirugia, idCaja, idTipo) VALUES (?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sss", $idCirugia, $idCajaQuirurgica, $idTipo);
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerModuloAnestesia()
    {
        $query = "SELECT * FROM moduloAnestesia";
        $result = $this->database->executeAndReturn($query);
        $modulos = array();
        while($row = $result->fetch_assoc()) {
            $modulo = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $modulos[] = $modulo;
        }
        return $modulos;
    }

}




