CREATE DATABASE IF NOT EXISTS centroQuirurgico;
USE centroQuirurgico;

CREATE TABLE IF NOT EXISTS `paciente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `dni` varchar(45) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `sexo` varchar(45) NOT NULL,
    `idTipo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`idTipo`) REFERENCES `tipoPaciente`(`id`)
);

CREATE TABLE IF NOT EXISTS `tipoPaciente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE Persona (
      id INT PRIMARY KEY,
         apellido VARCHAR(100),
        habilitado BOOLEAN,
                         matricula VARCHAR(20),
                         nombre VARCHAR(100),
                         idEspecialidad INT,
                         idEspQuirurgica INT,
                         contrasenia VARCHAR(255),
                         usuario VARCHAR(100),
                         rol VARCHAR(50),
                         logged BOOLEAN,
    FOREIGN KEY (`idEspecialidad`) REFERENCES `especialidad`(`id`),
    FOREIGN KEY (`idEspQuirurgica`) REFERENCES `especialidadQuirurgica`(`id`)

);

CREATE TABLE IF NOT EXISTS `especialidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `especialidadQuirurgica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


cREATE TABLE `NombreCirugia` (
                                 `id` INT PRIMARY KEY,
                                 `nombre` VARCHAR(100),
                                 `idEspQuirurgica` INT,
                                 `idSitioAnatomico` INT,
                                 `idUnidadFuncional` INT,
                                 FOREIGN KEY (`idEspQuirurgica`) REFERENCES EspecialidadQuirurgica(`id`),
                                 FOREIGN KEY (`idSitioAnatomico`) REFERENCES SitioAnatomico(`id`),
                                 FOREIGN KEY (`idUnidadFuncional`) REFERENCES UnidadFuncional(`id`)
                             );

                             CREATE TABLE IF NOT EXISTS `sitioAnatomico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
    idEspQuirurgica int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `unidadFuncional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
    idEspQuirurgica int(11) NOT NULL,

  PRIMARY KEY (`id`),
    FOREIGN KEY (idEspQuirurgica) references especialidadQuirurgica(id)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tipoDeAnestesia` (
    `id` INT PRIMARY KEY AUTO_INCREMENT ,
    `nombre` varchar(100)
);

CREATE TABLE IF NOT EXISTS `tipoDeCirugia`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT,
    `nombre` VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS `diagnostico`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT ,
    `nombre` VARCHAR(100)
);

create table if not exists `cajaQuirurgica`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT,
    ` nombre` VARCHAR(100)

);

create table if not exists `codigoPractica`
(
    `id` int primary key AUTO_INCREMENT,
    `nombre` VARCHAR(100)

);



create table if not exists `codigoPracticaCirugia`
    (
        `idCodigoPractica` INT,
        `idCirugia` INT,
        PRIMARY KEY (`idCodigoPractica`),
        FOREIGN KEY (`idCodigoPractica`) REFERENCES codigoPractica(`id`),
        FOREIGN KEY (`idCirugia`) REFERENCES cirugia(`id`)

    );

CREATE TABLE IF NOT EXISTS `materialProtesico`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT,
    `nombre` VARCHAR(100)

);


create table if not exists `materialProtesicoCirugia`
    (
        `idMaterialProtesico` INT,
        `idCirugia` INT,
        PRIMARY KEY (`idMaterialProtesico`),
        FOREIGN KEY (`idMaterialProtesico`) REFERENCES materialProtesico(`id`),
        FOREIGN KEY (`idCirugia`) REFERENCES cirugia(`id`)

    );

create table if not exists `lugar`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT,
    `nombre` VARCHAR(100)

);

create table if not exists `tipoLugar`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT,
    `nombre` VARCHAR(100)

);


create table if not exists `lugarCirugia`
    (
        `idLugar` INT,
        `idCirugia` INT,
        `idTipoLugar` INT,
        PRIMARY KEY (`idLugar`),
        FOREIGN KEY (`idLugar`) REFERENCES lugar(`id`),
        FOREIGN KEY (`idCirugia`) REFERENCES cirugia(`id`),
        FOREIGN KEY (`idTipoLugar`) REFERENCES tipoLugar(`id`)

    );


create table if not exists `cirugia`
(

    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    observacion VARCHAR(100),
    horaInicio TIME,
    horaFin TIME,
    fecha DATE,
    idNombreCirugia INT NOT NULL,
    idTipoDeAnestesia INT NOT NULL,
    idTipoDeCirugia INT NOT NULL,
    idDiagnostico INT NOT NULL,
    idCajaQuirurgica INT NOT NULL,
    idPaciente INT NOT NULL,
    idSitioAnatomico INT NOT NULL,
    idUnidadFuncional INT NOT NULL,
    FOREIGN KEY (idNombreCirugia) REFERENCES NombreCirugia(id),
    FOREIGN KEY (idTipoDeAnestesia) REFERENCES tipoDeAnestesia(id),
    FOREIGN KEY (idTipoDeCirugia) REFERENCES tipoDeCirugia(id),
    FOREIGN KEY (idDiagnostico) REFERENCES diagnostico(id),
    FOREIGN KEY (idCajaQuirurgica) REFERENCES cajaQuirurgica(id),
    FOREIGN KEY (idPaciente) REFERENCES paciente(id),
    FOREIGN KEY (idSitioAnatomico) REFERENCES sitioAnatomico(id),
    FOREIGN KEY (idUnidadFuncional) REFERENCES unidadFuncional(id)


);

create table if not exists `rolCirugia`
(
    id int primary key AUTO_INCREMENT,
    nombre VARCHAR(100)
);

create table if not exists `cirugiaPersona`
(
    idCirugia INT,
    idPersona INT,
    idRolCirugia INT,
    PRIMARY KEY (idCirugia),
    FOREIGN KEY (idCirugia) REFERENCES cirugia(id),
    FOREIGN KEY (idPersona) REFERENCES persona(id),
    FOREIGN KEY (idRolCirugia) REFERENCES rolCirugia(id)
);

CREATE TABLE if not exists `tecnologia`
(
    id INT PRIMARY KEY  AUTO_INCREMENT,
    nombre VARCHAR(100)
);



create table if not exists `tecnologiaCirugia`
    (
        idTecnologia INT,
        idCirugia INT,
        PRIMARY KEY (idTecnologia),
        FOREIGN KEY (idTecnologia) REFERENCES tecnologia(id),
        FOREIGN KEY (idCirugia) REFERENCES cirugia(id)

    );



