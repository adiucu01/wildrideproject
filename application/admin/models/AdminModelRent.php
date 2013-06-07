<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
  */  
  class AdminModelRent extends AdminModelDefault{
      
     public function getRentList($startDate,$endDate){
          $output = null;
       //   $sql = "SELECT trotinete.*, puncte_de_lucru.nume as punct_de_lucru, tip_adaugare_trotinete.nume as mod_adaugare FROM trotinete LEFT JOIN puncte_de_lucru ON trotinete.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_adaugare_trotinete on trotinete.tip_adaugare = tip_adaugare_trotinete.id ";
          $sql=  "select id_utilizator,id_trotineta from inchirieri where data_inchiriere > '". $startDate ."' and data_restituire < '"  .$endDate ."';";
           $result = self::$db->query($sql);
          
         $rows = array();
        while($row = mysqli_fetch_array($result))
        {
            $rows[] = $row;
        }        
          
          return $rows;
          
        
      }
     
      
  }
?>
