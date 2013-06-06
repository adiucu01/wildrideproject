<?php
    session_start();
    require_once("./config/config.php");
    $paths = 	'.' . PATH_SEPARATOR .
    'application/user/controllers/'. PATH_SEPARATOR	.
    'application/user/models/'. PATH_SEPARATOR	.
    'application/user/views/'. PATH_SEPARATOR	.
    'application/admin/controllers/'. PATH_SEPARATOR	.
    'application/admin/models/'. PATH_SEPARATOR	.
    'application/admin/views/'. PATH_SEPARATOR	.
    'classes/'. PATH_SEPARATOR	.
    'config/'. PATH_SEPARATOR	.
    'libraries'. PATH_SEPARATOR	.
    'libraries/PHPOffice/Classes/'. PATH_SEPARATOR	.
    'libraries/PHPOffice/Classes/PHPExcel/'. PATH_SEPARATOR	.
    'plugins/';

    set_include_path(get_include_path() . PATH_SEPARATOR . $paths);

    if(isset($_REQUEST["c"]) && $_REQUEST["c"]) {
        WSystem::$controller_name = $_REQUEST["c"];
    }
    if(isset($_REQUEST["a"]) && $_REQUEST["a"]) {
        WSystem::$action_name = $_REQUEST["a"];
    }

    function __autoload($class_name) {
        require_once $class_name . '.php';
    }


    WSystem::execute();
    //require('application/user/controllers/default.php');
