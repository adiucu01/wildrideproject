<?php
  //require_once("../models/user.php");

  $param = $_POST;
  
  $model = new ModelUser();
  
  
  if(isset($_GET['action'])){
      switch($_GET['action']){
          case "view":
                if($model->isValidUser()){
                      header( 'Location: ../views/user.php' ) ;
                }else
                {
                      header('Location: ../views/login.php');
                }
          break;
          case "edit":
                $param['id'] = $_GET['id'];
                if($model->updateUser($param)){
                      header( 'Location: ../views/user.php' ) ;
                }else
                {
                      header('Location: ../views/login.php');
                }
          break;
          case "change-email":
                $param['id'] = $_GET['id'];
                if($model->ChangeEmail($param)){
                      header( 'Location: ../views/user.php' ) ;
                }else
                {
                      header('Location: ../views/login.php');
                }
          break;
          case "change-password":
                $param['id'] = $_GET['id'];
                if($model->ChangePassword($param)){
                      header( 'Location: ../views/user.php' ) ;
                }else
                {
                      header('Location: ../views/login.php');
                }
          break;
      }
  }
?>
