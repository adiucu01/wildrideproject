<?php
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
    
  class ModelSignIn{
      private static $db;
      public function __construct(){
          self::$db = new DB(); 
      }
      public function SignIn($param){ 
          $password = $this->cryptp($param['password']);
          
          $sql = "SELECT * FROM admin WHERE email = '{$param['email']}'";
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          if($password == $arr['parola']){
              setcookie('user_id',$arr['id'],time()+3600*24,"/");
              setcookie('user_session_id',$param['session_id'],time()+3600*24,"/");
              $sql = "UPDATE admin SET id_sesiune='{$param['session_id']}' WHERE email = '{$param['email']}'";
          
              $result = self::$db->query($sql);
               
              return true;
          }
          else{
              return false;
          }          
      }
      private function cryptp($password){ 
        return  base64_encode(md5($password.PRIVATE_KEY.$password));
      }
  }
?>
