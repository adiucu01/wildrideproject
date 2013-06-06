<?php
    class ScooterController{
        private $request;
        private $view = 'application/user/views/';
        public $_secure = false;

        public function __construct() {
            $this->request = new Request();
        }
        public function viewAction() {
            $param['id'] = $this->request->getParam('id');

            require($this->view.'scooter.php');  
        }         
    }
?>
