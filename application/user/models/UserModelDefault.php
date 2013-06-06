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
            if (isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != "" 
                && isset($_COOKIE['user_session_id']) && $_COOKIE['user_session_id'] != "" )
                $sql = "SELECT * FROM user WHERE id=".intval($_COOKIE['user_id'])." and id_sesiune='{$_COOKIE['user_session_id']}'";
            else return false;

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
                $c_string = 'with ';
                $c_arr = explode(';',$arr['caracteristici']);
                for($key00 = 0; $key00<count($c_arr)-1;$key00++){
                    $c_strings = explode('=',$c_arr[$key00]); 
                    $c_string .= $c_strings[1].' '.$c_strings[0];
                    if($key00==count($c_arr)-2){
                        $c_string .= '';
                    }else{
                        $c_string .= ' and ';
                    }                                             
                }
                $output .= '<li class="scooter-detailed'.$class.'">
                <a href="../views/scooter.php?id='.$arr['id'].'" title="">
                <div class="scooter-detailed-img">
                <img src="'.$arr['imagine'].'" alt="" width="150"/>
                </div>
                <div class="scooter-detailed-title">
                '.$arr['denumire'].'
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
                $c_string = 'with ';
                $c_arr = explode(';',$arr['caracteristici']);
                for($key00 = 0; $key00<count($c_arr)-1;$key00++){
                    $c_strings = explode('=',$c_arr[$key00]); 
                    $c_string .= $c_strings[1].' '.$c_strings[0];
                    if($key00==count($c_arr)-2){
                        $c_string .= '';
                    }else{
                        $c_string .= ' and ';
                    }                                             
                }
                $output .= '<li class="scooter-detailed'.$class.'">
                <a href="../views/scooter.php?id='.$arr['id'].'" title="">
                <div class="scooter-detailed-img">
                <img src="'.$arr['imagine'].'" alt="" width="150"/>
                </div>
                <div class="scooter-detailed-title">
                '.$arr['denumire'].'
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
                $url = 'http://www.google.com/ig/calculator?hl=en&q=1'.$rate['from'].'=?'.$rate['to'];
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
                preg_match('/.*rhs: "([0-9]+.[0-9]*).*/', $res, $matches);

                $r[$i]['from'] = $rate['from'];
                $r[$i]['to'] = floatval($matches[1]); 
                $i++; 
            }  
            return $r;
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
            require('libraries/Smarty/Smarty.class.php');

            $smarty = new Smarty;

            $smarty->setTemplateDir('templates');
            $smarty->setCompileDir('templates_c');
            $smarty->setCacheDir('cache');
            $smarty->setConfigDir('config');

            //$smarty->force_compile = true;
            //$smarty->debugging = true;
            $smarty->caching = true;
            $smarty->cache_lifetime = 120;


            $sender['name'] = 'King Regards,';
            $sender['signature'] = 'Adrian Mihaila - IT Programmer';

            $smarty->assign("customer", $param['customer']);
            $smarty->assign("sender", $sender);
            
            ob_start();
            
            $smarty->display('index.tpl');   

            $message = ob_get_contents();

            ob_end_clean(); 

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
