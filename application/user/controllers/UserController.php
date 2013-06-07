<?php
    /*
    *   WildRide - Scooter renting Copyright (C) 2013 Mihaila Adrian Nicolae
    *   WildRide is free software: you can redistribute it and/or modify
    *   it under the terms of the GNU General Public License as published by
    *   the Free Software Foundation, either version 3 of the License, or
    *   (at your option) any later version.

    *   WildRide is distributed in the hope that it will be useful,
    *   but WITHOUT ANY WARRANTY; without even the implied warranty of
    *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    *   GNU General Public License for more details.
    *
    *   You should have received a copy of the GNU General Public License
    *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
    class UserController {

        private $request;
        private $view = 'application/user/views/';
        public $_secure = true;

        public function __construct() {
            $this->request = new Request();
        }

        public function indexAction() {
            $model = new UserModelDefault();
            require($this->view.'default.php');
        }

        public function viewAction() {
            $param = $_POST;
            $model = new ModelUser();
            if($model->isValidUser()){   
                require( $this->view.'user.php' ) ;
            }else
            {             
                require( $this->view.'login.php' ) ;
            }
        }

        public function editAction() {
            $param = $_POST;
            $model = new ModelUser();

            $param['id'] = $_COOKIE['user_id'];
            if($model->updateUser($param)){
                require( $this->view.'user.php' ) ;
            }else
            {
                require( $this->view.'login.php' ) ;
            }
        }

        public function changeEmailAction()
        {
            $param = $_POST;
            $model = new ModelUser();  
            $param['id'] = $_COOKIE['user_id'];
            if(!empty($_POST)){  
                if($model->ChangeEmail($param)){                
                    require( $this->view.'user.php' ) ;
                }else
                {                                               
                    require( $this->view.'login.php' ) ;
                }
            }else{
                require( $this->view.'change-email.php' ) ;
            }
        }

        public function changePasswordAction()
        {  
            $param = $_POST;
            $model = new ModelUser(); 

            $param['id'] = $_COOKIE['user_id'];
            if(!empty($_POST)){
                if($model->ChangePassword($param)){             
                    require( $this->view.'user.php' ) ;
                }else
                {                                              
                    require( $this->view.'login.php' ) ;
                }
            }else{
                require( $this->view.'change-password.php' ) ;
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
