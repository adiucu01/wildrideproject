<?php
class WSystem {
		public static $controller_name = "user";
    public static $action_name = "index";
    public static $controller;

		public static function redirect($controller = "user", $action = "index") {
			header("Location: index.php?c=".$controller."&a=".$action);
		}

		public static function execute() {

				$model = new UserModelDefault();

        $controller_class = ucfirst(WSystem::$controller_name)."Controller";
        self::$controller = new $controller_class;

        $controller_function = WSystem::$action_name."Action";
				if (self::$controller->_issecure == true && $model->is_logged() && $model->isValidUser())
        	self::$controller->$controller_function();
				else
					WSystem::redirect("index","login");

    }

}
