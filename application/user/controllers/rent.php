<?php
  require_once("../models/rent.php");

  $param = $_POST;
  
  $model = new ModelRent();
  
  
  if(isset($_GET['action'])){
      switch($_GET['action']){
          case "view":
                $param['id'] = $_GET['id'];
                
                header('Location: ../views/rent.php?id='.$_GET['id']);  
          break;
          case "rent":
                $param['id'] = $_GET['id'];
                if($model->makeRent($param)){
                    header('Location: ../views/default.php');    
                }
          break;
      }
  }
?>
