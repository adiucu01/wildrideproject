<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
*/    
  class AdminModelWorkpoint{
      private static $db;
      public function __construct(){
          self::$db = new DB(); 
      }
      public function addWorkpoint($param){ 
           $sql = "INSERT INTO puncte_de_lucru(nume, adresa)
                    VALUES('{$param['nume']}','{$param['adresa']}')";   
           
           $result = self::$db->query($sql);  
           
           return $result;  
      }
      public function updateWorkpoint($param){
           $sql = "UPDATE puncte_de_lucru
                    SET nume='{$param['nume']}', adresa='{$param['adresa']}'
                    WHERE id={$param['id']}";   
           
           $result = self::$db->query($sql);  
           
           return $result;
      }
      public function deleteWorkpoint($id){
          $sql = "DELETE FROM puncte_de_lucru
                    WHERE id = {$id}";   
           
           $result = self::$db->query($sql);  
           
           return $result;
      }
      public function deleteWorkpoints($param){
          foreach($param['select'] as $item){
              $sql = "DELETE FROM puncte_de_lucru
                    WHERE id = {$item}";   
           
              $result = self::$db->query($sql); 
          }           
           
           return $result;
      }
  }
?>
