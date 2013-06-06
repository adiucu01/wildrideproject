<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
  
  include("../models/default.php");
*/    
  class ModelUser extends UserModelDefault{ 
      public function updateUser($param){  
          
          $sql = "UPDATE user SET nume='{$param['first_name']}', prenume='{$param['last_name']}', cnp='{$param['cnp']}', judet='{$param['judet']}', oras='{$param['oras']}', serie='{$param['serie']}', numar='{$param['numar']}' WHERE id = '{$param['id']}'";
          
          $result = self::$db->query($sql); 
          
          return true;
      }
      public function ChangeEmail($param){
          $sql = "UPDATE user SET email='{$param['new_email']}' WHERE id = '{$param['id']}'";
          
          $result = self::$db->query($sql); 
          
          return true;
      }
      public function ChangePassword($param){
          $password = $this->cryptp($param['new_password']);
          
          $sql = "UPDATE user SET parola='{$password}' WHERE id = '{$param['id']}'";
          
          $result = self::$db->query($sql); 
          
          return true;
      }
      private function cryptp($password){ 
          return  base64_encode(md5($password.PRIVATE_KEY.$password));
      }
  }  
?>
