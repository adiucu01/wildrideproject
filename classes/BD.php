<?php
  require_once("/../config/config.php");
  
  class DB{
      private static $con = null;
      public function __construct(){
          self::$con = mysqli_connect(HOST,USER,PASSWORD,DB_NAME);
          
          // Check connection
          if (mysqli_connect_errno( self::$con )){
            die("Failed to connect to MySQL: " . mysqli_connect_error());
          }
      } 
      public function query($sql){  
          $result = mysqli_query(self::$con, $sql);
          
          if (mysqli_connect_errno( self::$con )){
            die("Failed to execute MySQL query: " . $sql);
          }
          
          return $result;
      }
      public function __destruct(){   
          mysqli_close(self::$con);
      }
  }
?>
