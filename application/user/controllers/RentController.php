<?php
    class RentController{
        private $request;
        private $view = 'application/user/views/';
        public $_secure = true;

        public function __construct() {
            $request = new Request();
        }
        public function viewAction() {
            $param = $_POST;
            $model = new UserModelRent();
            $param['id'] = $this->request->getParam('id');
            
            require($this->view.'rent.php?id='.$param['id']); 
            //header('Location: ../views/rent.php?id='.$_GET['id']); 
        }         
        public function rentAction()
        {
            $param = $_POST;
            $model = new UserModelRent(); 
            $param['id'] = $this->request->getParam('id');
            if($model->makeRent($param)){
                require($this->view.'default.php');
                    //header('Location: ../views/default.php');    
            }
        }
    }

