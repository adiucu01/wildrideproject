<?php
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
    
  class ModelDefault{
      private static $db;
      public function __construct(){
          self::$db = new DB();
      }
      public function getAdminList($limit){
          $output = null;
          $sql = "SELECT admin.*, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id {$limit}";
          
          $result = self::$db->query($sql); 
          $i = 1;   
          while($arr = mysqli_fetch_assoc($result)){
              $output .= '<tr>
                                <td><input type="checkbox" name="select[]" value="'.$arr['id'].'"/></td>
                                <td>'.$i.'</td>
                                <td>'.$arr['nume'].'</td>
                                <td>'.$arr['prenume'].'</td>
                                <td>'.$arr['email'].'</td>
                                <td>'.$arr['punct_de_lucru'].'</td>
                                <td>'.$arr['tip_utilizator'].'</td>
                                <td><a href="../controllers/admin.php?action=edit&id='.$arr['id'].'" title="Edit Admin">Edit</a>|<a href="../controllers/admin.php?action=delete&id='.$arr['id'].'" title="Delete Admin" onclick="return confirm(\'Do you really want to delete?\');">Delete</a></td>
                            </tr>';
              $i++;
          }
          
          return $output;
      }
      public function getWorkpointList($limit){
          $output = null;
          $sql = "SELECT * FROM puncte_de_lucru {$limit}";
          
          $result = self::$db->query($sql); 
          $i = 1;   
          while($arr = mysqli_fetch_assoc($result)){
              $output .= '<tr>
                                <td><input type="checkbox" name="select[]" value="'.$arr['id'].'"/></td>
                                <td>'.$i.'</td>
                                <td>'.$arr['nume'].'</td>
                                <td>'.$arr['adresa'].'</td>
                                <td><a href="../controllers/workpoint.php?action=edit&id='.$arr['id'].'" title="Edit Workpoint">Edit</a>|<a href="../controllers/workpoint.php?action=delete&id='.$arr['id'].'" title="Delete Workpoint" onclick="return confirm(\'Do you really want to delete?\');">Delete</a></td>
                            </tr>';
              $i++;
          }
          
          return $output;
      }
      public function getScooterList($limit){
          $output = null;
          $sql = "SELECT trotinete.*, puncte_de_lucru.nume as punct_de_lucru, tip_adaugare_trotinete.nume as mod_adaugare FROM trotinete LEFT JOIN puncte_de_lucru ON trotinete.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_adaugare_trotinete on trotinete.tip_adaugare = tip_adaugare_trotinete.id {$limit}";
          
          $result = self::$db->query($sql); 
          $i = 1;   
          while($arr = mysqli_fetch_assoc($result)){
              $output .= '<tr>
                                <td><input type="checkbox" name="select[]" value="'.$arr['id'].'"/></td>
                                <td>'.$i.'</td>
                                <td>'.$arr['denumire'].'</td>
                                <td>'.$arr['caracteristici'].'</td>
                                <td>'.$arr['pret_inchiriere'].'</td>
                                <td>'.$arr['mod_adaugare'].'</td>
                                <td>'.$arr['punct_de_lucru'].'</td>
                                <td>'.$arr['data_adaugare'].'</td>
                                <td><a href="../controllers/scooter.php?action=edit&id='.$arr['id'].'" title="Edit Scooter">Edit</a>|<a href="../controllers/scooter.php?action=delete&id='.$arr['id'].'" title="Delete Scooter" onclick="return confirm(\'Do you really want to delete?\');">Delete</a></td>
                            </tr>';
              $i++;
          }
          
          return $output;
      }
      public function getScooter($id){
          
          $sql = "SELECT * FROM trotinete WHERE id=".intval($id); 
              
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          return $arr;
      }
      public function getWorkpoint($id){
          
          $sql = "SELECT * FROM puncte_de_lucru WHERE id=".intval($id); 
              
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          return $arr;
      }
      public function getWorkpoints($id){
          $output = null;
          $sql = "SELECT * FROM puncte_de_lucru";
          
          $result = self::$db->query($sql);    
          while($arr = mysqli_fetch_assoc($result)){
              if(!empty($id) && ($id == $arr['id'])){
                  $selected = "selected";
              }else{
                  $selected = "";
              }
              $output .= '<option value="'.$arr['id'].'" '.$selected.'>'.$arr['nume'].'</option>';
          }
          
          return $output;
      }
      public function getAdminTypes($id){
          $output = null;
          $sql = "SELECT * FROM tip_utilizator";                          
          
          $result = self::$db->query($sql);    
          while($arr = mysqli_fetch_assoc($result)){
              if(!empty($id) && ($id == $arr['id'])){
                  $selected = "selected";
              }else{
                  $selected = "";
              }
              $output .= '<option value="'.$arr['id'].'" '.$selected.'>'.$arr['nume'].'</option>';
          }
          
          return $output;
      }
      public function isValidUser(){
          $sql = "SELECT * FROM admin WHERE id=".intval($_COOKIE['user_id'])." and id_sesiune='{$_COOKIE['user_session_id']}'";
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          if(is_array($arr)){
              return true;
          }else{
              return false;
          } 
      }
      public function createMenu($tip_utilizator){
          $output = null;
          
          switch($tip_utilizator){
              
              // superadmin
              case "1":
                   $output = '<a href="../views/admin.php" title="Admins">Admins</a> | 
                              <a href="../views/workpoint.php" title="Workpoints">Workpoints</a> |
                              <a href="../views/scooter.php" title="Scooters">Scooters</a>'; 
              break;
              
              // admin
              case "2":
              break;
              
              // utilizator
              case "3":
              break;
          }
          return $output;
      }
      public function getUser($id){
          if(empty($id)){
             $sql = "SELECT * FROM admin WHERE id=".intval($_COOKIE['user_id']);  
          }else{
             $sql = "SELECT * FROM admin WHERE id=".intval($id); 
          }     
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          return $arr;
      }
      public function is_logged(){ 
        $sql = "SELECT id_sesiune FROM admin WHERE id=".intval($_COOKIE['user_id']);
        
        $result = self::$db->query($sql);
        $arr = mysqli_fetch_assoc($result);
        
        if($arr['id_sesiune'] == $_COOKIE['user_session_id'] && $arr!=null){
            return true;
        }
        else{
            return false;
        }          
      } 
      public function getNumberOfAdmins(){
          $sql = "SELECT admin.*, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id";
          
          $result = self::$db->query($sql);   
          $rows = mysqli_num_rows($result);
          
          return $rows; 
      }
      public function getNumberOfWorkpoints(){
          $sql = "SELECT * FROM puncte_de_lucru";
          
          $result = self::$db->query($sql);   
          $rows = mysqli_num_rows($result);
          
          return $rows; 
      }
      public function getNumberOfScooters(){
          $sql = "SELECT trotinete.*, puncte_de_lucru.nume as punct_de_lucru, tip_adaugare_trotinete.nume as mod_adaugare FROM trotinete LEFT JOIN puncte_de_lucru ON trotinete.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_adaugare_trotinete on trotinete.tip_adaugare = tip_adaugare_trotinete.id";
          
          $result = self::$db->query($sql);   
          $rows = mysqli_num_rows($result);
          
          return $rows; 
      }
  }
?>
