<?php
  //require_once("/../config/config.php");
  
  class WDB{
      private static $con = null;
			private static $instance = null;
      private function __construct(){
          self::$con = mysqli_connect(HOST,USER,PASSWORD,DB_NAME);
          
          // Check connection
          if (mysqli_connect_errno( self::$con )){
            die("Failed to connect to MySQL: " . mysqli_connect_error());
          }
      }
			public static function get_instance() {
				if (self::$instance == null)
					self::$instance = new WDB();
				return self::$instance;
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
