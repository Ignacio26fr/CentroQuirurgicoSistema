<?php

include_once("controller/HomeUsuarioController.php");
include_once("controller/LoginController.php");
include_once ("controller/QuirurgicoController.php");
include_once("controller/FormularioController.php");
include_once ("controller/EstadisticasController.php");
include_once ("controller/OpcionesController.php");
include_once("controller/DiagnosticoController.php");
include_once("controller/ActoQuirurgicoController.php");
include_once("controller/ConsultasController.php");

include_once("model/LoginModel.php");
include_once("model/UsuarioModel.php");
include_once ("model/QuirurgicoModel.php");
include_once("model/EstadisticasModel.php");
include_once("model/OpcionesModel.php");
include_once("model/DiagnosticoModel.php");
include_once("model/ActoQuirurgicoModel.php");
include_once("model/ConsultasModel.php");

include_once("helper/Database.php");
include_once("helper/Router.php");
include_once("helper/Presenter.php");
include_once("helper/MustachePresenter.php");


include_once("vendor/mustache/src/Mustache/Autoloader.php");








class Configuration
{


 //Controller
public static function getLoginController()
{
    return new LoginController(self::getLoginModel(), self::getPresenter());
}

public static function getHomeUsuarioController()
{
    return new HomeUsuarioController(self::getHomeUsuarioModel(), self::getPresenter());
}

public static function getQuirurgicoController()
{
    return new QuirurgicoController(self::getQuirurgicoModel(), self::getPresenter());
}

public static function getFormularioController()
{
    return new FormularioController(self::getQuirurgicoModel(), self::getPresenter());
}

public static function getEstadisticasController()
{
    return new EstadisticasController(self::getEstadisticasModel(), self::getPresenter());
}

public static function getOpcionesController()
{
    return new OpcionesController(self::getOpcionesModel(), self::getPresenter());
}

public static function getDiagnosticoController()
{
    return new DiagnosticoController(self::getDiagnosticoModel(), self::getPresenter());
}

public static function getActoQuirurgicoController()
{
    return new ActoQuirurgicoController(self::getActoQuirurgicoModel(), self::getPresenter());
}

public static function getConsultasController()
{
    return new ConsultasController(self::getPresenter(), self::getConsultasModel());
}

//Models

private static function getLoginModel()
{
    return new LoginModel(self::getDatabase());
}

private static function getHomeUsuarioModel()
{
    return new UsuarioModel(self::getDatabase());
}

private static function getQuirurgicoModel()
{
    return new QuirurgicoModel(self::getDatabase());
}

private static function getEstadisticasModel()
{
    return new EstadisticasModel(self::getDatabase());
}
    private static function getOpcionesModel()
    {
        return new OpcionesModel(self::getDatabase());
    }
    private static function getDiagnosticoModel()
    {
        return new DiagnosticoModel(self::getDatabase());
    }

 private static function getActoQuirurgicoModel()
 {
     return new ActoQuirurgicoModel(self::getDatabase());
 }
 private static function getConsultasModel()
 {
     return new ConsultasModel(self::getDatabase());
 }

//helper
public static function getDatabase()
{
    $config = self::getConfig();
    return new Database($config['servername'], $config["username"], $config["password"], $config["dbname"]);

}

private static function getConfig()
{
    return parse_ini_file("config/config.ini");
}

private static function getPresenter()
{
    return new MustachePresenter("view/template");
}

public static function getRouter()
{
    return new Router("getHomeUsuarioController", "get");
}

    public static function getBaseUrl()
    {
        $config = self::getConfig();
        return $config['base_url'];
    }

}