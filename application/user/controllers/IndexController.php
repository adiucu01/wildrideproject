<?php
  class IndexController{
      private $view = 'application/user/views/';  
      public $_secure = false;

      public function indexAction(){
            $model = new UserModelDefault();

            require($this->view.'default.php');
          
      }
      public function loginAction() {
        $param = $_POST;
        $param['session_id'] = session_id();
        $model = new UserModelLogin();
        require( $this->view.'login.php' ) ;
    }
  }