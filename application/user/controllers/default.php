<?php 
    //require("../models/default.php");
    $model = new UserModelDefault();
    
    if($model->is_logged()){
        //header( 'Location: application/user/views/default.php' ) ; 
				require('application/user/views/default.php');
    }
    else
    {
        //header( 'Location: application/user/views/default.php' ) ;
				require('application/user/views/default.php');
    }
?>
