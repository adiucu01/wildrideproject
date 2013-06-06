<?php

class UserController {

	private $request = new Request();

	public function indexAction() {
    $model = new UserModelDefault();
    
    if($model->is_logged()){
        //header( 'Location: application/user/views/default.php' ) ; 
				require('application/user/views/default.php');
    }
    else
    {
        //header( 'Location: application/user/views/default.php' ) ;
				require('application/user/views/default.php');
    }
	}

	public function viewAction() {
		$param = $_POST;
		$model = new ModelUser();
		$action = $this->request->getParam('do');
		$id = $this->request->getParam('id');
		
	}

	public function userAction() {
		$param = $_POST;
		$model = new ModelUser();
		$action = $this->request->getParam('do');
		$id = $this->request->getParam('id');
		
		if($action!=null){
			switch($action){
		    case "view":
		      if($model->isValidUser()){
		        //header( 'Location: ../views/user.php' ) ;
						require( '../views/user.php' ) ;
		      }else
		      {
		        //header('Location: ../views/login.php');
						require( '../views/loign.php' ) ;
		      }
			    break;
		    case "edit":
		      $param['id'] = $id;
		      if($model->updateUser($param)){
		        //header( 'Location: ../views/user.php' ) ;
						require('../views/user.php' );
		      }else
		      {
		        //header('Location: ../views/login.php');
						require('../views/login.php' );
		      }
		      break;
		    case "change-email":
		      $param['id'] = $id;
		      if($model->ChangeEmail($param)){
		        //header( 'Location: ../views/user.php' ) ;
						require('../views/user.php' );
		      }else
		      {
		        //header('Location: ../views/login.php');
						require('../views/login.php' );
		      }
		    break;
		    case "change-password":
		      $param['id'] = $id;
		      if($model->ChangePassword($param)){
		        //header( 'Location: ../views/user.php' ) ;
						require('../views/user.php' );
		      }else
		      {
		        //header('Location: ../views/login.php');
						require('../views/login.php' );
		      }
		    break;
	    }
		}
	}

	public function loginAction() {
		$param = $_POST;
		$param['session_id'] = session_id();
		$model = new UserModelLogin();
		
		if(isset($_GET['do'])){
	    switch($_GET['do']){
        case "signin":
          if($model->SignIn($param)){
            if(isset($_SESSION['HTTP_REFERER'])){
              header( 'Location: '. $_SESSION['HTTP_REFERER'] ) ;
            }else{
              //header('Location: ../views/login.php');
							require('../views/login.php');
            }
          }
          else
            {
              //header('Location: ../views/login.php');
							require('../views/login.php');
            }
	        break;
        case "signup":
          if($model->SignUp($param)){
              //header('Location: ../views/login.php');
							require('../views/login.php');
          }
      	  break;
        case "f_password":
          if($model->ForgotPassword($param)){
              //header('Location: ../views/login.php');
							require('../views/login.php');
          }
	        break;
	    }
		}
	}

}
