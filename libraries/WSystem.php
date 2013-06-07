<?php

class WSystem {

    public static $controller_name = "index";
    public static $action_name = "index";
    public static $controller;
    public static $url = null;

    public static function redirect($controller = "index", $action = "index") {
        if ($controller != "index") {
            if ($action != "index")
                header("Location: " . self::$url . $controller . "/" . $action);
            else
                header("Location: " . self::$url . $controller);
        }
        else {
            header("Location: " . self::$url . $action);
        }
    }

    public static function execute() {

        if (self::$url === null) {
            self::$url = "http://" . $_SERVER['HTTP_HOST'];
            self::$url .= str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
        }
        
        $model = new UserModelDefault();

        $controller_class = ucfirst(WSystem::$controller_name) . "Controller";
        self::$controller = new $controller_class;

        $controller_function = WSystem::$action_name . "Action";
        if (isset(self::$controller->_secure) && self::$controller->_secure && !($model->is_logged() && $model->isValidUser())) {
            self::$controller_name = "index";
            self::$action_name = "index";
            self::execute();
        } else {
            self::$controller->$controller_function();
        }
    }

}
