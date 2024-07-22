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


CREATE TABLE if not exists Persona (
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
        id INT PRIMARY KEY AUTO_INCREMENT,
        `idCodigoPractica` INT,
        `idCirugia` INT,

        FOREIGN KEY (`idCodigoPractica`) REFERENCES codigoPractica(`id`),
        FOREIGN KEY (`idCirugia`) REFERENCES cirugia(`id`) ON DELETE CASCADE

    );

CREATE TABLE IF NOT EXISTS `materialProtesico`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT,
    `nombre` VARCHAR(100)

);
create table if not exists `tipo`
(
    `id` int primary key AUTO_INCREMENT,
    `nombre` VARCHAR(50)
);


create table if not exists `materialProtesicoCirugia`
    (
        id INT PRIMARY KEY AUTO_INCREMENT,
        `idMaterialProtesico` INT,
        `idCirugia` INT,
        idTipo INT,
        `cantidad` int,

        FOREIGN KEY (`idMaterialProtesico`) REFERENCES materialProtesico(`id`),
        FOREIGN KEY (`idCirugia`) REFERENCES cirugia(`id`),
        FOREIGN KEY (idTipo) references tipo(id)

    );

create table if not exists `lugar`
(
    `id` INT PRIMARY KEY  AUTO_INCREMENT,
    `nombre` VARCHAR(100)

);
create table if not exists `moduloAnestesia`
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
        id INT PRIMARY KEY AUTO_INCREMENT,
        `idLugar` INT,
        `idCirugia` INT,
        `idTipoLugar` INT,

        FOREIGN KEY (`idLugar`) REFERENCES lugar(`id`),
        FOREIGN KEY (`idCirugia`) REFERENCES cirugia(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`idTipoLugar`) REFERENCES tipoLugar(`id`)

    );

create table if not exists `cirugiaEspQuirurgica`
(
    id int primary key AUTO_INCREMENT,
    idCirugia INT,
    idEspQuirurgica INT,
    idTipo INT,

    FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE,
    FOREIGN KEY (idEspQuirurgica) REFERENCES especialidadQuirurgica(id),
    FOREIGN KEY (idTipo)REFERENCES tipo(id)
);

create table if not exists `cirugiaUnidadFuncional`
(
    id int primary key AUTO_INCREMENT,
    idCirugia INT,
    idUnidadFuncional INT,
    idTipo INT,

    FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE,
    FOREIGN KEY (idUnidadFuncional) REFERENCES unidadFuncional(id),
    FOREIGN KEY (idTipo)REFERENCES tipo(id)
);

create table if not exists `cirugiasitioAnatomico`
(
    id int primary key AUTO_INCREMENT,
    idCirugia INT,
    idSitioAnatomico INT,
    idTipo INT,

    FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE,
    FOREIGN KEY (idSitioAnatomico) REFERENCES sitioAnatomico(id),
    FOREIGN KEY (idTipo)REFERENCES tipo(id)
);

create table if not exists `cirugianombreCirugia`
(
    id int primary key AUTO_INCREMENT,
    idCirugia INT,
    idNombreCirugia INT,
    idTipo INT,

    FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE,
    FOREIGN KEY (idNombreCirugia) REFERENCES nombrecirugia(id),
    FOREIGN KEY (idTipo)REFERENCES tipo(id)
);

create table if not exists `rolCirugia`
(
    id int primary key AUTO_INCREMENT,
    nombre VARCHAR(100)
);

create table if not exists `cirugiaPersona`
(
    id int not null primary key AUTO_INCREMENT,
    idCirugia INT,
    idPersona INT,
    idRolCirugia INT,
    idTipo INT Null,
    FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE,
    FOREIGN KEY (idPersona) REFERENCES persona(id),
    FOREIGN KEY (idRolCirugia) REFERENCES rolCirugia(id),
    FOREIGN KEY (idTipo) REFERENCES tipo(id)
);

CREATE TABLE if not exists `tecnologia`
(
    id INT PRIMARY KEY  AUTO_INCREMENT,
    nombre VARCHAR(100)
);



create table if not exists `tecnologiaCirugia`
    (
        id int not null primary key AUTO_INCREMENT,
        idTecnologia INT,
        idCirugia INT,
        FOREIGN KEY (idTecnologia) REFERENCES tecnologia(id),
        FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE

    );

create table if not exists `cirugiaLugar`
(
    id int not null primary key AUTO_INCREMENT,
    idCirugia INT,
    idLugar INT,
    idTipoLugar INT,
    FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE,
    FOREIGN KEY (idLugar) REFERENCES lugar(id),
    FOREIGN KEY (idTipoLugar) REFERENCES tipoLugar(id)
);

create table if not exists `diagnosticoCirugia`
(
    id int not null primary key AUTO_INCREMENT,
    idDiagnostico INT,
    idCirugia INT,
    idTipo int,
    FOREIGN KEY (idDiagnostico) REFERENCES diagnostico(id),
    FOREIGN KEY (idCirugia) REFERENCES cirugia(id) ON DELETE CASCADE ,
    foreign key (idTipo) REFERENCES tipo(id)
);


create table if not exists `cirugia`
(

    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    observacion VARCHAR(100),
    horaIngresoCentroQuirurgico TIME,
    horaInicio TIME,
    horaFin TIME,
    horaEgresoCentroQuirurgico TIME,
    horaDeNacimiento TIME,
    fecha DATE,
    idTipoDeAnestesia INT NOT NULL,
    idTipoDeCirugia INT NOT NULL,
    idCajaQuirurgica INT NOT NULL,
    idPaciente INT NOT NULL,
    asa INT,
    conteo BOOLEAN,
    nroQuirofanoUsado INT,
    radiografiaControl BOOLEAN,
    hemoterapia BOOLEAN,
    cultivo BOOLEAN,
    anatomiaPatologica BOOLEAN,


    FOREIGN KEY (idTipoDeAnestesia) REFERENCES tipoDeAnestesia(id),
    FOREIGN KEY (idTipoDeCirugia) REFERENCES tipoDeCirugia(id),
    FOREIGN KEY (idCajaQuirurgica) REFERENCES cajaQuirurgica(id),
    FOREIGN KEY (idPaciente) REFERENCES paciente(id)


);


