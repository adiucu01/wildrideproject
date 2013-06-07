<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
  */  
  class ModelAdmin extends AdminModelDefault{
      
      public function addAdmin($param){ 
           $password = $this->cryptp($param['password']);
           $sql = "INSERT INTO admin(nume, prenume, email, parola, id_punct_de_lucru, tip_admin)
                    VALUES('{$param['first_name']}','{$param['last_name']}','{$param['email']}','{$password}',{$param['punct_lucru']},2)";   
           
           $result = self::$db->query($sql);  
           
           return $result;  
      }
      public function updateUser($param){
           $sql = "UPDATE admin
                    SET nume='{$param['first_name']}', prenume='{$param['last_name']}', email='{$param['email']}', id_punct_de_lucru={$param['punct_lucru']}, tip_admin={$param['tip_utilizator']}
                    WHERE id={$param['id']}";   
           
           $result = self::$db->query($sql);  
           
           return $result;
      }
      public function deleteUser($id){
          $sql = "DELETE FROM admin
                    WHERE id = {$id}";   
           
           $result = self::$db->query($sql);  
           
           return $result;
      }
      public function deleteUsers($param){
          foreach($param['select'] as $item){
              $sql = "DELETE FROM admin
      b              WHERE id = {$item}";   
           
              $result = self::$db->query($sql); 
          }           
           
           return $result;
      }
      private function cryptp($password){ 
        return  base64_encode(md5($password.PRIVATE_KEY.$password));
      }
  }
?>
