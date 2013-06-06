<?php
  require_once("../models/signin.php");
  
  session_start();
  $param = $_POST;
  $param['session_id'] = session_id();
  
  $model = new AdminModelSignIn();
  if($model->SignIn($param)){
      header( 'Location: ../views/default.php' ) ;
  }
  else
  {
      header('Location: ../views/signin.php');
  }
?>
