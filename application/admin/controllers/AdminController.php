<?php

class AdminController {

    private $view = 'application/admin/views/';
    public $_secure = false;

    public function indexAction() {
        require($this->view . 'default.php');
    }

    public function signinAction() {
        $param = $_POST;
        $param['session_id'] = session_id();

        $model = new AdminModelSignIn();
        if ($model->SignIn($param)) {
            //header('Location: ../views/default.php');
            require($this->view. 'default.php');
        } else {
            //header('Location: ../views/signin.php');
            require($this->view. 'signin.php');
        }
    }

}
