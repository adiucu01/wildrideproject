<?php
    class WSystem {
        public static $controller_name = "index";
        public static $action_name = "index";
        public static $controller;

        public static function redirect($controller = "index", $action = "index") {
            header("Location: index.php?c=".$controller."&a=".$action);
        }

        public static function execute() {

            $model = new UserModelDefault();

            $controller_class = ucfirst(WSystem::$controller_name)."Controller";
            self::$controller = new $controller_class;

            $controller_function = WSystem::$action_name."Action";
            if (isset(self::$controller->_secure ) && self::$controller->_secure && !($model->is_logged() && $model->isValidUser())) {
                self::$controller_name = "index";
                self::$action_name = "index";
                self::execute();
            }
            else {
                self::$controller->$controller_function();
            }	

        }

    }
