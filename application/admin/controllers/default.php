<?php
    //require("/models/default.php");
    $model = new AdminModelDefault();
    
    if($model->is_logged()){
        header( 'Location: views/default.php' ) ; 
        
    }
    else
    {
        header( 'Location: views/login.php' ) ;
    }
?>
