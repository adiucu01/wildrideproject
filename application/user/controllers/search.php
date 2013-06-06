<?php
  //require_once("../models/search.php");

  $param = $_POST;
  
  $model = new UserModelSearch();
  
  
  if(isset($_GET['action'])){
      switch($_GET['action']){
          case "view":
                //if($model->SearchScooter($param)){                 
                    header('Location: ../views/search.php');
                //}  
          break;
          case "pagination":
                echo $model->SearchScooter($param);
          break;
          case "filter":
                switch($_GET['category']){
                      case "in_stock":
                            $param['f'] = true;
                            echo $model->ProductInStock($param,$count);
                      break;
                      case "all_products":
                            $param['f'] = true;
                            echo $model->AllProducts($param,$count);
                      break;
                      case "new_products":
                            $param['f'] = true;
                            echo $model->NewProducts($param,$count);
                      break;
                      
                      case "price_products":
                            $param['f'] = true;
                            echo $model->PriceProducts($param,$min,$max,$range,$count);
                      break;
                      
                      case "handles_products":
                            $param['f'] = true;
                            echo $model->HandlesProducts($param,$rubber,$plastic);
                      break;
                      
                      case "wheels_products":
                            $param['f'] = true;
                            echo $model->WheelsProducts($param,$aluminum,$iron);
                      break;
                      
                      case "horn_products":
                            $param['f'] = true;
                            echo $model->HornProducts($param,$yes,$no);
                      break;
                }
          break;
      }
  }
?>
