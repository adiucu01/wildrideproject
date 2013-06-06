<?php

class IndexController {

    private $view = 'application/user/views/';
    public $_secure = false;

    public function indexAction() {
        $model = new UserModelDefault();

        require($this->view . 'default.php');
    }

    public function loginAction() {
        $param = $_POST;
        $param['session_id'] = session_id();
        $model = new UserModelLogin();
        require( $this->view . 'login.php' );
    }

    public function signinAction() {
        $param = $_POST;
        $param['session_id'] = session_id();
        $model = new UserModelLogin();
        if ($model->SignIn($param)) {
            if (isset($_SESSION['HTTP_REFERER'])) {
                header('Location: ' . $_SESSION['HTTP_REFERER']);
            } else {
                //header('Location: ../views/login.php');
                require( $this->view . 'login.php' );
            }
        } else {
            //header('Location: ../views/login.php');
            require( $this->view . 'login.php' );
        }
    }

    public function signupAction() {
        $param = $_POST;
        $param['session_id'] = session_id();
        $model = new UserModelLogin();
        if ($model->SignUp($param)) {
            //header('Location: ../views/login.php');
            require( $this->view . 'login.php' );
        }
    }

    public function forgotPasswordAction() {
        if ($model->ForgotPassword($param)) {
            //header('Location: ../views/login.php');
            require($this->view . 'login.php');
        }
    }

}