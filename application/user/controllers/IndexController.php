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
                    require( $this->view . 'user.php' );
                }
            } else {     
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
        public function partnersAction(){
            require($this->view . 'partners.php');
        }
        public function rentalConditionsAction(){
            require($this->view . 'rental-conditions.php');
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
        public function newsletterAction(){
            $model = new UserModelDefault();
            $param = $_POST;
            $model->addNewsletter($param);

            require($this->view . 'default.php');
        }

}