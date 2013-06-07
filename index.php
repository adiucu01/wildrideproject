<?php

    session_start();
    require_once("./config/config.php");
    $paths = dirname(__FILE__) . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/admin/controllers/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/admin/models/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/admin/views/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/user/controllers/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/user/models/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/user/views/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/classes/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/config/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/libraries' . PATH_SEPARATOR .
    dirname(__FILE__) . '/libraries/PHPOffice/Classes/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/libraries/PHPOffice/Classes/PHPExcel/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/plugins/';

    //set_include_path(get_include_path() . PATH_SEPARATOR . $paths); 
    set_include_path($paths);

    if (isset($_REQUEST["c"]) && $_REQUEST["c"]) {
        WSystem::$controller_name = $_REQUEST["c"];
    }
    if (isset($_REQUEST["a"]) && $_REQUEST["a"]) {
        WSystem::$action_name = $_REQUEST["a"];
    }

    function __autoload($class_name) {
        require_once $class_name . '.php';
    }

    WSystem::execute();   
