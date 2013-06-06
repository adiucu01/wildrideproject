<?php
    class RentController{
        private $request;
        private $view = 'application/user/views/';
        public $_secure = false;

        public function __construct() {
            $request = new Request();
        }
        public function viewAction() {
            $request = new Request();
            $param['id'] = $request->getParam('id');
            
            require($this->view.'rent.php');  
        }         
        public function rentAction()
        {
            $param = $_POST;
            $model = new UserModelRent();
            $request = new Request(); 
            $param['id'] = $request->getParam('id');
            if($model->makeRent($param)){
                require($this->view.'default.php');        
            }
        }
    }

