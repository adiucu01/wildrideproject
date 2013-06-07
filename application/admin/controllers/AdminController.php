<?php

class AdminController {

    private $view = 'application/admin/views/';
    public $_secure = false;

    public function indexAction() {
        $model = new AdminModelDefault();
        if ($model->isValidUser() && $model->is_logged())
            require($this->view . 'default.php');
        else
            require($this->view . 'login.php');
    }

    public function signinAction() {
        $param = $_POST;
        $param['session_id'] = session_id();

        $model = new AdminModelSignIn();
        $res = $model->SignIn($param);

        if ($model->SignIn($param)) {
            WSystem::redirect("admin");
        } else {
            require($this->view . 'login.php');
        }
    }

}
