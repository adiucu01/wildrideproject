<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
  
  include("../models/default.php");
*/    
  class UserModelScooter extends UserModelDefault{
      public function getScooter($id){                     
          
          $sql = "SELECT * FROM trotinete WHERE id=".intval($id);
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          return $arr;
      }
  }
?>
