<?php
    require("../models/workpoint.php");
    $model = new AdminModelWorkpoint();
    
    $param = $_POST;
    
    switch($_GET['action']){
        case "edit":
            if(isset($_GET['type'])){
                if($model->updateWorkpoint($param)){
                   header( 'Location: ../views/workpoint.php' ); 
                } 
            }else{
                header( 'Location: ../views/workpoint.edit.php?id='.$_GET['id'] );
            }
        break;
        
        case "add":
            if(isset($_GET['type'])){
                if($model->addWorkpoint($param)){
                   header( 'Location: ../views/workpoint.php' ); 
                } 
            }else{
             header( 'Location: ../views/workpoint.add.php' ); 
            }
        break;
        
        case "delete":
            if(isset($_GET['type'])){
                if($model->deleteWorkpoints($param)){
                   header( 'Location: ../views/workpoint.php' ); 
                }  
            }else{
                if($model->deleteWorkpoint($_GET['id'])){
                   header( 'Location: ../views/workpoint.php' ); 
                }  
            }
        break;
        
        default:
            echo 'tralala';
        break;
    }
?>               
