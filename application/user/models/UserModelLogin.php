<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
  
  include("../models/default.php");
*/    
  class UserModelLogin extends UserModelDefault{ 
      public function SignIn($param){
          $password = $this->cryptp($param['password']);
          
          $sql = "SELECT * FROM user WHERE email = '{$param['email']}'";
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          if($password == $arr['parola']){
              setcookie('user_id',$arr['id'],time()+3600*24,"/");
              setcookie('user_session_id',$param['session_id'],time()+3600*24,"/");
              
              $sql = "UPDATE user SET id_sesiune='{$param['session_id']}' WHERE email = '{$param['email']}'";
          
              $result = self::$db->query($sql);
              return true;
          }
          else{
              return false;
          }          
      }
      public function SignUp($param){
           $password = $this->cryptp($param['password']);
           
           $sql = "INSERT INTO user(nume, prenume, email, cnp, judet, oras, serie, numar, parola, tip_utilizator, data_inregistrare, id_sesiune)
                    VALUES('{$param['first_name']}','{$param['last_name']}','{$param['email']}','{$param['cnp']}','{$param['judet']}','{$param['oras']}','{$param['serie']}','{$param['numar']}','{$password}',3,NOW(),'{$param['session_id']}')";   
           
           $result = self::$db->query($sql); 
           
           $sql01 = "SELECT * FROM user WHERE email = '{$param['email']}'";
          
           $result01 = self::$db->query($sql01);    
           $arr = mysqli_fetch_assoc($result01);
          
           setcookie('user_id',$arr['id'],time()+3600*24,"/");
           setcookie('user_session_id', $param['session_id'] ,time()+3600*24,"/"); 
           
           return $result;  
      }
      public function ForgotPassword($param){
          $password = $this->cryptp($param['password']);
          
          $sql = "UPDATE user SET parola='{$password}' WHERE email = '{$param['email']}'";
          
          $result = self::$db->query($sql);
          
          $customer = $this->getCustomer($param['email']);
          $param['customer']['nume'] = $customer['nume'];
          $param['customer']['prenume']= $customer['prenume'];
          $param['customer']['message'] = $customer['message'] = 'Your password was renew. The current password is: <b>'.$param['password'].'</b>';
          $param['subject'] ='WildRide Change Password';
          
          $this->SendMail($param);
          return true;
          
      }
      private function cryptp($password){ 
        return  base64_encode(md5($password.PRIVATE_KEY.$password));
      }
  }
?>
