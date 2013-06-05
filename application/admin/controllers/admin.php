<?php
    require("../models/admin.php");
    $model = new ModelAdmin();
    
    $param = $_POST;
    
    switch($_GET['action']){
        case "edit":
            if(isset($_GET['type'])){
                if($model->updateUser($param)){
                   header( 'Location: ../views/admin.php' ); 
                } 
            }else{
                header( 'Location: ../views/admin.edit.php?id='.$_GET['id'] );
            }
        break;
        
        case "add":
            if(isset($_GET['type'])){
                if($model->addAdmin($param)){
                   header( 'Location: ../views/admin.php' ); 
                } 
            }else{
             header( 'Location: ../views/admin.add.php' ); 
            }
        break;
        
        case "delete":
            if(isset($_GET['type'])){
                if($model->deleteUsers($param)){
                   header( 'Location: ../views/admin.php' ); 
                }  
            }else{
                if($model->deleteUser($_GET['id'])){
                   header( 'Location: ../views/admin.php' ); 
                }  
            }
        break;
        
        default:
            echo 'tralala';
        break;
    }
?>               
