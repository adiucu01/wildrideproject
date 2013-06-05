<?php 
    require("/../models/default.php");
    $model = new ModelDefault();
    
    if($model->is_logged()){
        header( 'Location: application/user/views/default.php' ) ; 
    }
    else
    {
        header( 'Location: application/user/views/default.php' ) ;
    }
?>
