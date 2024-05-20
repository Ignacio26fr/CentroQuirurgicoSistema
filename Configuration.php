<?php

include_once("helper/Database.php");
include_once("helper/Router.php");
include_once("helper/Presenter.php");
include_once("helper/MustachePresenter.php");

include_once("vendor/mustache/src/Mustache/Autoloader.php");








class Configuration
{


 //Controller   
public static function getQuirurgicoController()
{
    return null;
}

public static function getHomeUsuarioController()
{
    return null;
}

//Models




//helper
public static function getDatabase()
{
    $config = self::getConfig();
    return new Database($config["servername"] . ":" . $config["port"], $config["username"], $config["password"], $config["dbname"]);

}

private static function getConfig()
{
    return parse_ini_file("config/config.ini");
}

private static function getPresenter()
{
    return new MustachePresenter("view/template");
}

private static function getRouter()
{
    return new Router("getQuirurgicoController", "get");
}
}