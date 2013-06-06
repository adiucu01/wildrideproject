<?php

class UserController {

	private $request;
	private $view = 'application/user/views/';
	public $_secture = true;

	public function __construct() {
		$request = new Request();
	}

	public function indexAction() {
    $model = new UserModelDefault();
    
    if($model->is_logged()){
        //header( 'Location: application/user/views/default.php' ) ; 
				require($this->view.'default.php');
    }
    else
    {
        //header( 'Location: application/user/views/default.php' ) ;
				require($this->view.'default.php');
    }
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
	}

	public function signinAction() {
		$param = $_POST;
		$param['session_id'] = session_id();
		$model = new UserModelLogin();
    if($model->SignIn($param)){
      if(isset($_SESSION['HTTP_REFERER'])){
        header( 'Location: '. $_SESSION['HTTP_REFERER'] ) ;
      }else{
        //header('Location: ../views/login.php');
				require( $this->view.'login.php' ) ;
      }
    }
    else
      {
        //header('Location: ../views/login.php');
				require( $this->view.'login.php' ) ;
      }
	}

	public function signupAction() {
		$param = $_POST;
		$param['session_id'] = session_id();
		$model = new UserModelLogin();
    if($model->SignUp($param)){
      //header('Location: ../views/login.php');
			require( $this->view.'login.php' ) ;
    }
	}

	public function loginAction() {
		$param = $_POST;
		$param['session_id'] = session_id();
		$model = new UserModelLogin();
		require( $this->view.'login.php' ) ;
/*		
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
*/
	}

}
