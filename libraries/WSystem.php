<?php
class WSystem {
		public static $controller_name = "user";
    public static $action_name = "index";
    public static $controller;

		public static function redirect($controller = "user", $action = "index") {
			header("Location: index.php?c=".$controller."&a=".$action);
		}

		public static function execute() {
        $controller_class = ucfirst(WSystem::$controller_name)."Controller";
        self::$controller = new $controller_class;

        $controller_function = WSystem::$action_name."Action";
        self::$controller->$controller_function();
    }

}
