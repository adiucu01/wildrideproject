<?php
    class RentController{
        private $request;
        private $view = 'application/user/views/';
        public $_secure = false;

        public function __construct() {
            $this->request = new Request();
        }
        public function viewAction() {    
            $param['id'] = $this->request->getParam('id');

            require($this->view.'rent.php');  
        }         
        public function rentAction()
        {
            $param = $_POST;
            $model = new UserModelRent();

            $param['id'] = $this->request->getParam('id');
            if($model->makeRent($param)){
                require($this->view.'default.php');        
            }
        }
    }

