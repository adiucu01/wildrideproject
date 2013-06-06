<?php
  //require_once("../models/login.php");
  
  session_start();
  $param = $_POST;
  $param['session_id'] = session_id();
  
  $model = new UserModelLogin();
  
  
  if(isset($_GET['action'])){
      switch($_GET['action']){
          case "signin":
                if($model->SignIn($param)){
                    if(isset($_SESSION['HTTP_REFERER'])){
                      header( 'Location: '. $_SESSION['HTTP_REFERER'] ) ;
                    }else{
                      header('Location: ../views/login.php');
                    }
                  }
                  else
                  {
                      header('Location: ../views/login.php');
                  }
          break;
          case "signup":
                if($model->SignUp($param)){
                      header( 'Location: ../views/login.php' ) ;
                  }
          break;
          case "f_password":
                if($model->ForgotPassword($param)){
                      header( 'Location: ../views/login.php' ) ;
                  }
          break;
      }
  }
?>
