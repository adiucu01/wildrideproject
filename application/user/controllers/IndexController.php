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
                require( $this->view . 'user.php' );
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
                require( $this->view . 'user.php' );
            }
        }

        public function forgotPasswordAction() {
            $param = $_POST;
            $model = new UserModelLogin();
            if ($model->ForgotPassword($param)) {  
                require($this->view . 'login.php');
            }
        }
        
        public function aboutAction(){
            require($this->view . 'about-us.php');
        }
        public function contactAction(){
            if(!empty($_POST)){
                 $model = new ModelUser();
                 $param = $_POST;
                 $param['customer']['nume'] = $_POST['name'];   
                 $param['customer']['message'] = $_POST['message'];
                 $param['subject'] ='WildRide Contact Section';
                 $model->SendMail($param);
                 
                 require($this->view . 'contact.php');
            }else{
                require($this->view . 'contact.php');
            }
        }

}