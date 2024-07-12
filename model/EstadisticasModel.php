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
    public function obtenerCirugiasPaginadas($fechaInicio, $fechaFin, $inicio, $paginas )
    {
        $query = "SELECT * FROM cirugia WHERE fecha BETWEEN ? AND ? LIMIT ?, ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('ssii', $fechaInicio, $fechaFin, $inicio, $paginas);
        $stmt->execute();

        $result =  $stmt->get_result();

        $cirugias = $result->fetch_all(MYSQLI_ASSOC);
        foreach($cirugias as $cirugia) {
            $cirugia['paciente'] = $this->obtenerNombreYApellidoDelPaciente($cirugia['idPaciente']);
        }

        return $cirugias;

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

    public function obtenerEspecialidadQuirurgica($idUnidadFuncional)
    {
        $query = "SELECT e.nombre from unidadFuncional up 
                  INNER JOIN especialidadquirurgica e ON up.idEspQuirurgica = e.id
                  WHERE up.id = ?";

        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idUnidadFuncional);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $unidadFuncional = [];

            while ($row = $result->fetch_assoc()) {
                $unidadFuncional[] = $row;
            }

            return $unidadFuncional;
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
                  WHERE dc.idCirugia = ? and dc.tipo = 'PRIMARIO'" ;

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
                  WHERE dc.idCirugia = ? and dc.tipo = 'SECUNDARIO'" ;

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
     public function obtenerActoPrincipal($idCirugiaNombre)
     {
         $query = "SELECT nc.nombre from cirugia c 
                    inner join nombrecirugia nc on c.idNombreCirugia = nc.id where nc.id = ?";
         $stmt = $this->database->prepare($query);
         $stmt->bind_param('i', $idCirugiaNombre);
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
                  cirugia c on c.idSitioAnatomico = s.id where s.id = ?";
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
    public function obtenerUnidadFuncional($idUnidadFuncional)
    {
        $query = "Select s.nombre from unidadFuncional s where s.id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idUnidadFuncional);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $unidadesFuncionales = [];
            while ($row = $result->fetch_assoc()) {
                $unidadesFuncionales = $row;
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
    private function obtenerNombreYApellidoDelProfesional($idProfesional)
    {
        $query = "SELECT nombre, apellido FROM persona WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param('i', $idProfesional);
        $stmt->execute();


    }





}