<?php

    class UserController {

        private $request;
        private $view = 'application/user/views/';
        public $_secure = true;

        public function __construct() {
            $request = new Request();
        }

        public function indexAction() {
            $model = new UserModelDefault();
            require($this->view.'default.php');
        }

        public function viewAction() {
            $param = $_POST;
            $model = new ModelUser();
            if($model->isValidUser()){
                //header( 'Location: ../views/user.php' ) ;
                require( $this->view.'user.php' ) ;
            }else
            {
                //header('Location: ../views/login.php');
                require( $this->view.'login.php' ) ;
            }
        }

        public function editAction() {
            $param = $_POST;
            $model = new ModelUser();
            $id = $this->request->getParam('id');
            $param['id'] = $id;
            if($model->updateUser($param)){
                //header( 'Location: ../views/user.php' ) ;
                require( $this->view.'user.php' ) ;
            }else
            {
                //header('Location: ../views/login.php');
                require( $this->view.'login.php' ) ;
            }
        }

        public function changeEmailAction()
        {
            $param = $_POST;
            $model = new ModelUser();
            $param['id'] = $this->request->getParam('id');
            if($model->ChangeEmail($param)){
                //header( 'Location: ../views/user.php' ) ;
                require( $this->view.'user.php' ) ;
            }else
            {
                //header('Location: ../views/login.php');
                require( $this->view.'login.php' ) ;
            }
        }

        public function changePasswordAction()
        {
            $param['id'] = $id;
            if($model->ChangePassword($param)){
                //header( 'Location: ../views/user.php' ) ;
                require( $this->view.'user.php' ) ;
            }else
            {
                //header('Location: ../views/login.php');
                require( $this->view.'login.php' ) ;
            }
        }

        /*public function userAction() {
            $param = $_POST;
            $model = new ModelUser();
            $action = $this->request->getParam('do');
            $id = $this->request->getParam('id');

            if($action!=null){
                switch($action){
                    case "view":
                        if($model->isValidUser()){
                            //header( 'Location: ../views/user.php' ) ;
                            require( $this->view.'user.php' ) ;
                        }else
                        {
                            //header('Location: ../views/login.php');
                            require( $this->view.'login.php' ) ;
                        }
                        break;
                    case "edit":
                        $param['id'] = $id;
                        if($model->updateUser($param)){
                            //header( 'Location: ../views/user.php' ) ;
                            require( $this->view.'user.php' ) ;
                        }else
                        {
                            //header('Location: ../views/login.php');
                            require( $this->view.'login.php' ) ;
                        }
                        break;
                    case "change-email":
                        $param['id'] = $id;
                        if($model->ChangeEmail($param)){
                            //header( 'Location: ../views/user.php' ) ;
                            require( $this->view.'user.php' ) ;
                        }else
                        {
                            //header('Location: ../views/login.php');
                            require( $this->view.'login.php' ) ;
                        }
                        break;
                    case "change-password":
                        $param['id'] = $id;
                        if($model->ChangePassword($param)){
                            //header( 'Location: ../views/user.php' ) ;
                            require( $this->view.'user.php' ) ;
                        }else
                        {
                            //header('Location: ../views/login.php');
                            require( $this->view.'login.php' ) ;
                        }
                        break;
                }
            }
        } */





    }
