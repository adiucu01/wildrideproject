<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
*/    
  class UserModelDefault{
      public static $db;
      public function __construct(){
          self::$db = WDB::get_instance();
      }
      public function getAdressScooter($id){
          $sql = "SELECT p.adresa FROM trotinete t, puncte_de_lucru p WHERE t.id=".intval($id)." AND t.id_punct_de_lucru = p.id";
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          return $arr;
      }
      public function getUser(){
          $_COOKIE['user_id'] = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;                      
          
          $sql = "SELECT * FROM user WHERE id=".intval($_COOKIE['user_id']);
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          return $arr;
      }
      public function is_logged(){
				if (isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != "")
	        $sql = "SELECT id_sesiune FROM user WHERE id=".intval($_COOKIE['user_id']);
				else return false;
        
        $result = self::$db->query($sql);
        $arr = mysqli_fetch_assoc($result);
        
        if($arr['id_sesiune'] == $_COOKIE['user_session_id'] && $arr!=null){
            return true;
        }
        else{
            return false;
        }          
      } 
      public function isValidUser(){
          $sql = "SELECT * FROM user WHERE id=".intval($_COOKIE['user_id'])." and id_sesiune='{$_COOKIE['user_session_id']}'";
          
          $result = self::$db->query($sql);    
          $arr = mysqli_fetch_assoc($result);
          
          if(is_array($arr)){
              return true;
          }else{
              return false;
          } 
      }
      public function getScootersRecomandation(){
              $location = $this->getGeoLocation('86.124.171.143');
              
              $sql = "SELECT t.* FROM trotinete t, puncte_de_lucru p WHERE  p.oras like '%".$location['town']."%' and p.judet like '%".$location['state']."%' and t.id_punct_de_lucru = p.id";
          
              $result = self::$db->query($sql);  
              $output = null;
              $nr = mysqli_num_rows($result); 
              $i = 1; 
              while($arr = mysqli_fetch_assoc($result)){
                    if($i==$nr){
                        $class = ' last-item';
                    }else{
                        $class = null;
                    }
                    $output .= '<li class="scooter-detailed'.$class.'">
                                    <a href="../views/scooter.php?id='.$arr['id'].'" title="">
                                        <div class="scooter-detailed-img">
                                            <img src="'.$arr['imagine'].'" alt="" width="150"/>
                                        </div>
                                        <div class="scooter-detailed-title">
                                            '.$arr['denumire'].'
                                        </div>
                                        <div class="scooter-detailed-characteristic">
                                            '.str_replace(';',',',$arr['caracteristici']).'
                                        </div>
                                        <div class="scooter-detailed-price">
                                            '.$arr['pret_inchiriere'].' EUR/day
                                        </div>
                                    </a>
                                    <input type="button" value="Reserve" class="scooter-detailed-button" onclick="RentScooter(\''.$arr['id'].'\');"/>
                                </li>';
                      $i++;  
              }
              
              return $output;
      }
      public function getScootersFeed(){
              $location = $this->getGeoLocation('86.124.171.143');
              
              $sql = "SELECT * FROM trotinete ORDER BY data_adaugare DESC";
          
              $result = self::$db->query($sql);  
              $output = null;
              $nr = mysqli_num_rows($result); 
              $i = 1; 
              while($arr = mysqli_fetch_assoc($result)){
                    if($i==$nr){
                        $class = ' last-item';
                    }else{
                        $class = null;
                    }
                    $output .= '<li class="scooter-detailed'.$class.'">
                                    <a href="../views/scooter.php?id='.$arr['id'].'" title="">
                                        <div class="scooter-detailed-img">
                                            <img src="'.$arr['imagine'].'" alt="" width="150"/>
                                        </div>
                                        <div class="scooter-detailed-title">
                                            '.$arr['denumire'].'
                                        </div>
                                        <div class="scooter-detailed-characteristic">
                                            '.str_replace(';',',',$arr['caracteristici']).'
                                        </div>
                                        <div class="scooter-detailed-price">
                                            '.$arr['pret_inchiriere'].' EUR/day
                                        </div>
                                    </a>
                                    <input type="button" value="Reserve" class="scooter-detailed-button" onclick="RentScooter(\''.$arr['id'].'\');"/>
                                </li>';
                      $i++;  
              }
              
              return $output;
      }
      public function getPositionStart(&$region,&$city,&$adress){
              $location = $this->getGeoLocation('86.124.171.143');
              $region = $location['state'];
              $city = $location['town'];
              
              $sql = "SELECT t.*, p.adresa FROM trotinete t, puncte_de_lucru p WHERE  p.oras like '%".$location['town']."%' and p.judet like '%".$location['state']."%' and t.id_punct_de_lucru = p.id GROUP BY p.adresa";
              $result = self::$db->query($sql);  
              $adress = null;  
              while($arr = mysqli_fetch_assoc($result)){ 
                    $adress .= '<option value="'.$arr['adresa'].'">'.$arr['adresa'].'</option>';  
              }
              //return;
              
      }
      public function getPositionEnd(&$region,&$city,&$adress){ 
              $region = null;
              $sql_region = "SELECT * from puncte_de_lucru GROUP BY judet";
              $result_region = self::$db->query($sql_region);
              while($arr_region = mysqli_fetch_assoc($result_region)){
                    $region .= '<option>'.$arr_region['judet'].'</option>';
              } 
                
              $city = null;  
              $sql_city = "SELECT * from puncte_de_lucru GROUP BY oras";
              $result_city = self::$db->query($sql_city);
              while($arr_city = mysqli_fetch_assoc($result_city)){
                    $city .= '<option>'.$arr_city['oras'].'</option>';  
              }  
              
              $adress = null;
              $sql = "SELECT * from puncte_de_lucru";
              $result = self::$db->query($sql);
              while($arr = mysqli_fetch_assoc($result)){ 
                    $adress .= '<option value="'.$arr['adresa'].'">'.$arr['adresa'].'</option>';      
              }
      }
      public function getExchangeRates(){
          
            $rates = array( 0 => array(
                                            'from' => 'EUR',
                                            'to' => 'RON'),
                               1 => array(
                                            'from' => 'USD',
                                            'to' => 'RON'),
                               2 => array(
                                            'from' => 'GBP',
                                            'to' => 'RON'));
             $i = 0;                                
            foreach($rates as $rate){
                $url = 'http://finance.yahoo.com/d/quotes.csv?f=l1d1t1&s='.$rate['from'].$rate['to'].'=X';
                $handle = fopen($url, 'r');
             
                if ($handle) {
                    $result = fgetcsv($handle);
                    fclose($handle);
                }
                $r[$i]['from'] = $rate['from'];
                $r[$i]['to'] = $result[0]; 
                $i++; 
            }  
            return $r;
      }
      public function getWeather(&$temp_c, &$img_url, &$loc){
            $location = $this->getGeoLocation('86.124.171.143');
            $url = 'http://api.worldweatheronline.com/free/v1/weather.ashx?q='.$location['town'].'&format=json&num_of_days=5&key='.WHEATER_API;
          
            // initializam cURL
            $c = curl_init();

            // stabilim URL-ul serviciului Web invocat
            curl_setopt($c, CURLOPT_URL, $url);

            // rezultatul cererii va fi disponibil ca sir de caractere
            // intors de apelul curl_exec()
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

            // preluam resursa oferita de server (aici, un document XML)
            $res = curl_exec($c);

            // inchidem conexiunea cURL
            curl_close($c);
            
            $weather = json_decode($res);
            
            $temp_c = $weather->data->current_condition[0]->temp_C;
            $img_url = $weather->data->current_condition[0]->weatherIconUrl[0]->value;
            $loc = $location['town']; 
          
      }
      private function getGeoLocation($ip){
               //check, if the provided ip is valid
               if(!filter_var($ip, FILTER_VALIDATE_IP))
               {
                       throw new InvalidArgumentException("IP is not valid");
               }

               //contact ip-server
               $response=@file_get_contents('http://www.netip.de/search?query='.$ip);
               if (empty($response))
               {
                       throw new InvalidArgumentException("Error contacting Geo-IP-Server");
               }

               //Array containing all regex-patterns necessary to extract ip-geoinfo from page
               $patterns=array();
               $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
               $patterns["country"] = '#Country: (.*?)&nbsp;#i';
               $patterns["state"] = '#State/Region: (.*?)<br#i';
               $patterns["town"] = '#City: (.*?)<br#i';

               //Array where results will be stored
               $ipInfo=array();

               //check response from ipserver for above patterns
               foreach ($patterns as $key => $pattern)
               {
                       //store the result in array
                       $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
               }

               return $ipInfo;

      }
      public function SendMail($param){
            require('../../../libraries/Smarty/Smarty.class.php');

            $smarty = new Smarty;

            $smarty->setTemplateDir('../../../templates');
            $smarty->setCompileDir('../../../templates_c');
            $smarty->setCacheDir('../../../cache');
            $smarty->setConfigDir('../../../config');

            //$smarty->force_compile = true;
            //$smarty->debugging = true;
            $smarty->caching = true;
            $smarty->cache_lifetime = 120;
            
            
            $sender['name'] = 'King Regards,';
            $sender['signature'] = 'Adrian Mihaila - IT Programmer';
            
            $smarty->assign("customer", $param['customer']);
            $smarty->assign("sender", $sender);

            $smarty->display('index.tpl');
            
            ob_start();
            
            $message = ob_get_contents();
            
            ob_end_flush();
            //die();
            
            $to = $param['email'];
            $subject = $param['subject'];

            $headers = "From: " . strip_tags(ADMIN_EMAIL) . "\r\n"; 
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            
            $a = mail($to, $subject, $message, $headers);
      }
      public function getCustomer($email){
            $sql = "SELECT * FROM user WHERE email='".$email."'";
          
              $result = self::$db->query($sql);    
              $arr = mysqli_fetch_assoc($result);
              
              return $arr;
      }
      public function getScootersHistory(){
              $scooters = isset($_COOKIE['history_views']) ? $_COOKIE['history_views'] : '';
              $scooters_arr = explode(';',$scooters);
              $scooters_arr_unique = array_unique($scooters_arr);
              $i = 1;
              $output = null;  
              for($j=0; $j<count($scooters_arr_unique)-1; $j++){
                    $sql = "SELECT * FROM trotinete WHERE id=".intval($scooters_arr_unique[$j]);
          
                      $result = self::$db->query($sql);  
                       
                      while($arr = mysqli_fetch_assoc($result)){
                            if($i==count($scooters_arr_unique)-1){
                                $class = ' last-item';
                            }else{
                                $class = null;
                            }
                            $output .= '<li class="scooter-detailed'.$class.'">
                                            <a href="../views/scooter.php?id='.$arr['id'].'" title="">
                                                <div class="scooter-detailed-img">
                                                    <img src="'.$arr['imagine'].'" alt="" width="150"/>
                                                </div>
                                                <div class="scooter-detailed-title">
                                                    '.$arr['denumire'].'
                                                </div>
                                                <div class="scooter-detailed-characteristic">
                                                    '.str_replace(';',',',$arr['caracteristici']).'
                                                </div>
                                                <div class="scooter-detailed-price">
                                                    '.$arr['pret_inchiriere'].' EUR/day
                                                </div>
                                            </a>
                                            <input type="button" value="Reserve" class="scooter-detailed-button" onclick="RentScooter(\''.$arr['id'].'\');"/>
                                        </li>';
                              $i++;  
                      }    
              }
              
              return $output;
      }
      public function setHistoryViews($id){
          $history = isset($_COOKIE['history_views']) ? $_COOKIE['history_views'] : '';
          $history .= $id . ';';
          
          setcookie('history_views', $history, time()+3600*24, "/"); 
      }
  }
?>
