<?php

class EstadisticasModel
{
    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }


    public function obtenerCirugias($fechaInicio, $fechaFin)
    {
        $query = "SELECT * FROM cirugia WHERE fecha BETWEEN ? AND ? ";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ss', $fechaInicio, $fechaFin);
        $stmt->execute();

        $result =  $stmt->get_result();

        $cirugias = $result->fetch_all(MYSQLI_ASSOC);

        foreach($cirugias as $cirugia) {
            $cirugia['paciente'] = $this->obtenerNombreYApellidoDelPaciente($cirugia['idPaciente']);
         //   $cirugia['cirujano'] = $this->obtenerNombreYApellidoDelProfesional($cirugia['idCirujano']);
        }

        return $cirugias;

    }
    public function obtenerCirugia($idCirugia)
    {
        $query = "SELECT * FROM cirugia WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result =  $stmt->get_result();

        $cirugias = $result->fetch_all(MYSQLI_ASSOC);
        foreach($cirugias as $cirugia) {
            $cirugia['paciente'] = $this->obtenerNombreYApellidoDelPaciente($cirugia['idPaciente']);
        }

        return $cirugias;
    }

    public function obtenerCirugiasPaginadas($fechaInicio, $fechaFin, $inicio, $paginas )
    {
        $query = "SELECT * FROM cirugia WHERE fecha BETWEEN ? AND ? LIMIT ?, ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssii', $fechaInicio, $fechaFin, $inicio, $paginas);
        $stmt->execute();

        $result =  $stmt->get_result();

        if ($result->num_rows > 0) {
            $cirugia = [];

            while ($row = $result->fetch_assoc()) {
                $cirugia[] = $row;
            }

            return $cirugia;
        } else {
            return [];
        }


    }


    public function obtenerProfesionalCirujano($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'CIRUJANO'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }
    public function obtenerProfesionalCirujanoSecundario($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'CIRUJANO' and rc.nombre = 'SECUNDARIO'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }

    public function obtenerProfesionalCirujanoTerciario($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'CIRUJANO' and rc.nombre = 'TERCIARIO'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }


    public function contarCirugias($fechaInicio, $fechaFin)
    {
        $query = "SELECT COUNT(*) FROM cirugia where fecha BETWEEN ? AND ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ss', $fechaInicio, $fechaFin);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all();
        $total = $result;
        return $total;
    }

    public function obtenerProfesionalAnestesista($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'ANESTESISTA'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }

    public function obtenerProfesionalInstrumentador($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'INSTRUMENTADOR QUIRURGICO'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }

    public function obtenerProfesionalTecnico($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'TECNICO ANESTESISTA'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }

    public function obtenerProfesionalPrimerAyudante($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'PRIMER AYUDANTE'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }
    public function obtenerProfesionalSegundoAyudante($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'SEGUNDO AYUDANTE'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }

    public function obtenerProfesionalNeonatologo($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'NEONATOLOGO'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }


    public function obtenerProfesionalCirculante($idCirugia)
    {
        $query = "SELECT p.nombre, p.apellido 
              FROM persona p 
              INNER JOIN cirugiapersona cp ON p.id = cp.idPersona
              INNER JOIN rolcirugia rc ON cp.idRolCirugia = rc.id                               
              WHERE cp.idCirugia = ? AND rc.nombre = 'CIRCULANTE'";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $profesionales = [];

            while ($row = $result->fetch_assoc()) {
                $profesionales[] = $row;
            }

            return $profesionales;
        } else {
            return [];
        }

        $stmt->close();
    }

    public function obtenerEspecialidadQuirurgica($idCirugia)
    {
        $query = "SELECT e.nombre from cirugiaespquirurgica ep 
                  INNER JOIN especialidadquirurgica e ON ep.idEspQuirurgica = e.id
                  WHERE ep.idCirugia = ? AND ep.idTipo = 1";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $espQuirurgica = [];

            while ($row = $result->fetch_assoc()) {
                $espQuirurgica[] = $row;
            }

            return $espQuirurgica;
        } else {
            return [];
        }

    }
    public function obtenerEspecialidadQuirurgicaSecundario($idCirugia)
    {
        $query = "SELECT e.nombre from cirugiaespquirurgica ep 
                  INNER JOIN especialidadquirurgica e ON ep.idEspQuirurgica = e.id
                  WHERE ep.idCirugia = ? AND ep.idTipo = 2";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $espQuirurgica = [];

            while ($row = $result->fetch_assoc()) {
                $espQuirurgica[] = $row;
            }

            return $espQuirurgica;
        } else {
            return [];
        }

    }
    public function obtenerEspecialidadQuirurgicaTerciario($idCirugia)
    {
        $query = "SELECT e.nombre from cirugiaespquirurgica ep 
                  INNER JOIN especialidadquirurgica e ON ep.idEspQuirurgica = e.id
                  WHERE ep.idCirugia = ? AND ep.idTipo = 3";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $espQuirurgica = [];

            while ($row = $result->fetch_assoc()) {
                $espQuirurgica[] = $row;
            }

            return $espQuirurgica;
        } else {
            return [];
        }

    }
    public function obtenerNombreYApellidoDelPaciente($idPaciente)
    {
        $query = "SELECT nombre, apellido, dni FROM paciente WHERE id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idPaciente);
        $stmt->execute();

      $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $pacientes = [];

            while ($row = $result->fetch_assoc()) {
                $pacientes[] = $row;
            }

            return $pacientes;
        } else {
            return [];
        }

    }

    public function obtenerDiagnosticoPrimario($idCirugia)
    {
        $query = "SELECT d.nombre FROM diagnostico d
                  INNER JOIN diagnosticocirugia dc ON d.id = dc.idDiagnostico
                  WHERE dc.idCirugia = ? and dc.idTipo = 1" ;

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $diagnostico = [];

            while ($row = $result->fetch_assoc()) {
                $diagnostico[] = $row;
            }

            return $diagnostico;
        } else {
            return [];
        }

    }
    public function obtenerDiagnosticoSecundario($idCirugia)
    {
        $query = "SELECT d.nombre FROM diagnostico d
                  INNER JOIN diagnosticocirugia dc ON d.id = dc.idDiagnostico
                  WHERE dc.idCirugia = ? and dc.idTipo = 2" ;

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $diagnostico = [];

            while ($row = $result->fetch_assoc()) {
                $diagnostico[] = $row;
            }

            return $diagnostico;
        } else {
            return [];
        }

    }
     public function obtenerActoPrincipal($idCirugia)
     {
         $query = "SELECT nc.nombre from cirugianombrecirugia c 
                    inner join nombrecirugia nc on c.idNombreCirugia = nc.id 
                 where c.idCirugia = ? and c.idTipo = 1";
         $stmt = $this->database->prepare($query);
         $stmt->bind_param('i', $idCirugia);
         $stmt->execute();

         $result = $stmt->get_result();
         if ($result->num_rows > 0) {
             $cirugias = [];
             while ($row = $result->fetch_assoc()) {
                 $cirugias[] = $row;

             }
             return $cirugias;
         } else {
             return [];
         }
     }
    public function obtenerActoSecundario($idCirugia)
    {
        $query = "SELECT nc.nombre from cirugianombrecirugia c 
                    inner join nombrecirugia nc on c.idNombreCirugia = nc.id 
                 where c.idCirugia = ? and c.idTipo = 2";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $cirugias = [];
            while ($row = $result->fetch_assoc()) {
                $cirugias[] = $row;

            }
            return $cirugias;
        } else {
            return [];
        }
    }
    public function obtenerActoTerciario($idCirugia)
    {
        $query = "SELECT nc.nombre from cirugianombrecirugia c 
                    inner join nombrecirugia nc on c.idNombreCirugia = nc.id 
                 where c.idCirugia = ? and c.idTipo = 3";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $cirugias = [];
            while ($row = $result->fetch_assoc()) {
                $cirugias[] = $row;

            }
            return $cirugias;
        } else {
            return [];
        }
    }



    public function obtenerTipoCirugia($idTipoCirugia)
    {
        $query = "SELECT t.nombre from tipodecirugia t inner join
                    cirugia c on c.idTipoDeCirugia = t.id where t.id = ? ";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idTipoCirugia);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $cirugias = [];
            while ($row = $result->fetch_assoc()) {
                $cirugias[] = $row;

            }
            return $cirugias;
        } else {
            return [];
        }
    }

    public function obtenerTipoDeAnestesia($idTipoDeAnestesia)
    {
        $query = "Select t.nombre from tipodeanestesia t inner join 
                  cirugia c on c.idTipoDeAnestesia = t.id where t.id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idTipoDeAnestesia);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $cirugias = [];
            while ($row = $result->fetch_assoc()) {
                $cirugias[] = $row;
            }
            return $cirugias;
        }
    }

    public function obtenerSitioAnatomico($idSitioAnatomico)
    {
        $query = "Select s.nombre from sitioAnatomico s inner join 
                  cirugiasitioanatomico c on c.idSitioAnatomico = s.id where c.idCirugia = ? AND c.idTipo = 1";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idSitioAnatomico);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $cirugias = [];
            while ($row = $result->fetch_assoc()) {
                $cirugias[] = $row;
            }
            return $cirugias;
        }
    }
    public function obtenerSitioAnatomicoSecundario($idSitioAnatomico)
    {
        $query = "Select s.nombre from sitioAnatomico s inner join 
                  cirugiasitioanatomico c on c.idSitioAnatomico = s.id where c.idCirugia = ? AND c.idTipo = 2";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idSitioAnatomico);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $cirugias = [];
            while ($row = $result->fetch_assoc()) {
                $cirugias[] = $row;
            }
            return $cirugias;
        }
    }
    public function obtenerSitioAnatomicoTerciario($idSitioAnatomico)
    {
        $query = "Select s.nombre from sitioAnatomico s inner join 
                  cirugiasitioanatomico c on c.idSitioAnatomico = s.id where c.idCirugia = ? AND c.idTipo = 3";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idSitioAnatomico);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $cirugias = [];
            while ($row = $result->fetch_assoc()) {
                $cirugias[] = $row;
            }
            return $cirugias;
        }
    }
    public function obtenerUnidadFuncional($idCirugia)
    {
        $query = "Select s.nombre from unidadFuncional s INNER JOIN
                    cirugiaunidadfuncional c on c.idUnidadFuncional = s.id where c.idCirugia = ? AND c.idTipo = 1";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $unidadesFuncionales = [];
            while ($row = $result->fetch_assoc()) {
                $unidadesFuncionales[] = $row;
            }
            return $unidadesFuncionales;
        }
    }
    public function obtenerUnidadFuncionalSecundario($idCirugia)
    {
        $query = "Select s.nombre from unidadFuncional s INNER JOIN
                    cirugiaunidadfuncional c on c.idUnidadFuncional = s.id where c.idCirugia = ? AND c.idTipo = 2";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $unidadesFuncionales = [];
            while ($row = $result->fetch_assoc()) {
                $unidadesFuncionales[] = $row;
            }
            return $unidadesFuncionales;
        }
    }
    public function obtenerUnidadFuncionalTerciario($idCirugia)
    {
        $query = "Select s.nombre from unidadFuncional s INNER JOIN
                    cirugiaunidadfuncional c on c.idUnidadFuncional = s.id where c.idCirugia = ? AND c.idTipo = 3";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $unidadesFuncionales = [];
            while ($row = $result->fetch_assoc()) {
                $unidadesFuncionales[] = $row;
            }
            return $unidadesFuncionales;
        }
    }

    public function obtenerLugarProviene($idCirugia)
    {
        $query = "SELECT l.nombre FROM lugar l
                  INNER JOIN cirugialugar lc ON l.id = lc.idLugar
                  inner join tipolugar tl on tl.id = lc.idTipolugar
                  WHERE lc.idCirugia = ? and tl.id = 1";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $diagnostico = [];

            while ($row = $result->fetch_assoc()) {
                $diagnostico[] = $row;
            }

            return $diagnostico;
        } else {
            return [];
        }
    }
    public function obtenerLugarEgresa($idCirugia)
    {
        $query = "SELECT l.nombre FROM lugar l
                  INNER JOIN cirugialugar lc ON l.id = lc.idLugar
                  inner join tipolugar tl on tl.id = lc.idTipolugar
                  WHERE lc.idCirugia = ? and tl.id = 2";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $egresa = [];

            while ($row = $result->fetch_assoc()) {
                $egresa[] = $row;
            }

            return $egresa;
        } else {
            return [];
        }
    }

    public function obtenerCodigoDePracticas($idCirugia)
    {
        $query = "SELECT c.nombre FROM codigopractica c
                  INNER JOIN codigopracticacirugia lc ON c.id = lc.idCodigoPractica
                  WHERE lc.idCirugia = ? AND lc.tipo = 1";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $codigo = [];

            while ($row = $result->fetch_assoc()) {
                $codigo[] = $row;
            }

            return $codigo;
        } else {
            return [];
        }
    }
    public function obtenerCodigoDePracticasSecundario($idCirugia)
    {
        $query = "SELECT c.nombre FROM codigopractica c
                  INNER JOIN codigopracticacirugia lc ON c.id = lc.idCodigoPractica
                  WHERE lc.idCirugia = ? AND lc.tipo = 2";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $codigo = [];

            while ($row = $result->fetch_assoc()) {
                $codigo[] = $row;
            }

            return $codigo;
        } else {
            return [];
        }
    }
    public function obtenerCodigoDePracticasTerciario($idCirugia)
    {
        $query = "SELECT c.nombre FROM codigopractica c
                  INNER JOIN codigopracticacirugia lc ON c.id = lc.idCodigoPractica
                  WHERE lc.idCirugia = ? AND lc.tipo = 3";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $codigo = [];

            while ($row = $result->fetch_assoc()) {
                $codigo[] = $row;
            }

            return $codigo;
        } else {
            return [];
        }
    }


    public function obtenerMaterialProtesico($idCirugia)
    {
        $query = "SELECT m.nombre FROM materialprotesico m
                  INNER JOIN materialprotesicocirugia lc ON m.id = lc.idMaterialProtesico
                  WHERE lc.idCirugia = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $material = [];

            while ($row = $result->fetch_assoc()) {
                $material[] = $row;
            }

            return $material;
        } else {
            return [];
        }
    }

    public function obtenerTecnologia($idCirugia)
    {
        $query = "SELECT m.nombre FROM tecnologia m
                  INNER JOIN tecnologiacirugia lc ON m.id = lc.idTecnologia
                  WHERE lc.idCirugia = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tecnologia = [];

            while ($row = $result->fetch_assoc()) {
                $tecnologia[] = $row;
            }

            return $tecnologia;
        } else {
            return [];
        }
    }

    public function obtenerCajaQuirurgica($idCirugia)
    {
        $query = "SELECT c.nombre from cajaquirurgica c 
                   INNER JOIN cirugiacajaquirurgica lc on c.id = lc.idCaja where 
                    lc.idCirugia = ? and lc.idTipo = 1";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $caja = [];

            while ($row = $result->fetch_assoc()) {
                $caja[] = $row;
            }

            return $caja;
        } else {
            return [];
        }
    }
    public function obtenerCajaQuirurgicaSecundaria($idCirugia)
    {
        $query = "SELECT c.nombre from cajaquirurgica c 
                   INNER JOIN cirugiacajaquirurgica lc on c.id = lc.idCaja where 
                    lc.idCirugia = ? and lc.idTipo = 2";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $caja = [];

            while ($row = $result->fetch_assoc()) {
                $caja[] = $row;
            }

            return $caja;
        } else {
            return [];
        }
    }
    public function obtenerCajaQuirurgicaTerciaria($idCirugia)
    {
        $query = "SELECT c.nombre from cajaquirurgica c 
                   INNER JOIN cirugiacajaquirurgica lc on c.id = lc.idCaja where 
                    lc.idCirugia = ? and lc.idTipo = 3";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $caja = [];

            while ($row = $result->fetch_assoc()) {
                $caja[] = $row;
            }

            return $caja;
        } else {
            return [];
        }
    }
    public function obtenerCajaQuirurgicaCuarta($idCirugia)
    {
        $query = "SELECT c.nombre from cajaquirurgica c 
                   INNER JOIN cirugiacajaquirurgica lc on c.id = lc.idCaja where 
                    lc.idCirugia = ? and lc.idTipo = 4";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idCirugia);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $caja = [];

            while ($row = $result->fetch_assoc()) {
                $caja[] = $row;
            }

            return $caja;
        } else {
            return [];
        }
    }
    private function obtenerNombreYApellidoDelProfesional($idProfesional)
    {
        $query = "SELECT nombre, apellido FROM persona WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idProfesional);
        $stmt->execute();


    }





}