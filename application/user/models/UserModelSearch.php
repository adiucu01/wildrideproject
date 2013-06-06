<?php
/*
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
  
  include("../models/default.php"); 
*/    
  class UserModelSearch extends UserModelDefault{
      private $_PAGE_PER_NO = 4;
      public function SearchScooter($param){
          if(isset($param['pageId']) && !empty($param['pageId'])){
                 $id=$param['pageId'];
            }else{
                 $id='0';
            }

            $pageLimit = $this->_PAGE_PER_NO * $id;
            $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire) limit $pageLimit, ".$this->_PAGE_PER_NO;
          
            $result = self::$db->query($sql);
            $count=mysqli_num_rows($result);
            $HTML='';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $c_string = 'with ';
                                        $c_arr = explode(';',$row['caracteristici']);
                                        for($key00 = 0; $key00<count($c_arr)-1;$key00++){
                                            $c_strings = explode('=',$c_arr[$key00]); 
                                            $c_string .= $c_strings[1].' '.$c_strings[0];
                                            if($key00==count($c_arr)-2){
                                                $c_string .= '';
                                            }else{
                                                $c_string .= ' and ';
                                            }                                             
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    
                                                    <h4>'.$row['denumire'].' - '.$c_string.'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;
      }
      public function getPagination($param, &$count){ 
              $sql = "SELECT a.id FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
              $result = self::$db->query($sql);
              $count=mysqli_num_rows($result);
              
              $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }

              return $paginationCount;
        }  
      public function ProductInStock($param, &$count){
            if($param['f']){
                 if(isset($param['pageId']) && !empty($param['pageId'])){
                     $id=$param['pageId'];
                }else{
                     $id='0';
                }

                $pageLimit = $this->_PAGE_PER_NO * $id;
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire) limit $pageLimit, ".$this->_PAGE_PER_NO;
                $result = self::$db->query($sql);
                
                $count=$param['pag_no'];
            
            }else{
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire)"; 
                $result = self::$db->query($sql);
                
                $count=mysqli_num_rows($result);
         
            }
            
            $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }
            
            $HTML=$paginationCount.'##';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    <h4>'.$row['denumire'].' - '.str_replace(';', ',', $row['caracteristici']).'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;   
      } 
      public function AllProducts($param, &$count){ 
            if($param['f']){
                 if(isset($param['pageId']) && !empty($param['pageId'])){
                     $id=$param['pageId'];
                }else{
                     $id='0';
                }

                $pageLimit = $this->_PAGE_PER_NO * $id;
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' limit $pageLimit, ".$this->_PAGE_PER_NO;
                $result = self::$db->query($sql);
                
                $count=$param['pag_no'];                 
            }else{
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' ";
                $result = self::$db->query($sql);
                $count=mysqli_num_rows($result);
            }
              
            $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }
            
            $HTML=$paginationCount.'##';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    <h4>'.$row['denumire'].' - '.str_replace(';', ',', $row['caracteristici']).'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;   
      }
      public function NewProducts($param, &$count){
            if($param['f']){
                if(isset($param['pageId']) && !empty($param['pageId'])){
                     $id=$param['pageId'];
                }else{
                     $id='0';
                }

                $pageLimit = $this->_PAGE_PER_NO * $id;
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' AND a.data_adaugare BETWEEN (CURDATE() - INTERVAL 30 DAY) AND CURDATE() ORDER BY a.data_adaugare DESC limit $pageLimit, ".$this->_PAGE_PER_NO;
                $result = self::$db->query($sql);
                
                $count=$param['pag_no']; 
            }else{
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' AND a.data_adaugare BETWEEN (CURDATE() - INTERVAL 30 DAY) AND CURDATE() ORDER BY a.data_adaugare DESC";
                $result = self::$db->query($sql);
                
                $count=mysqli_num_rows($result);
            }  
            $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }
            
            $HTML=$paginationCount.'##';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    <h4>'.$row['denumire'].' - '.str_replace(';', ',', $row['caracteristici']).'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;    
      }  
      public function PriceProducts($param, &$min, &$max, &$range, &$count){       
          if($param['f']){
          if(isset($param['pageId']) && !empty($param['pageId'])){
                     $id=$param['pageId'];
                }else{
                     $id='0';
                }

                $pageLimit = $this->_PAGE_PER_NO * $id;
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND b.adresa='{$param['adress_start']}' AND a.pret_inchiriere>'".$param['price_products']."' limit $pageLimit, ".$this->_PAGE_PER_NO;
                $result = self::$db->query($sql);
                
                $count=$param['pag_no']; 
          }else{
                $sql = "SELECT MIN(a.pret_inchiriere) as min, MAX(a.pret_inchiriere) as max FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND  b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
                $result = self::$db->query($sql);
                
                $count=mysqli_num_rows($result);
                $row=mysqli_fetch_array($result);
              
                $min = $row['min'];
                $max = $row['max'] ;
                $range = ($min + max)/2;
            }  
            $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }
            
            $HTML=$paginationCount.'##';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    <h4>'.$row['denumire'].' - '.str_replace(';', ',', $row['caracteristici']).'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;    
      }
      public function HandlesProducts($param, &$rubber, &$plastic){
          if($param['f']){
          if(isset($param['pageId']) && !empty($param['pageId'])){
                     $id=$param['pageId'];
                }else{
                     $id='0';
                }

                $pageLimit = $this->_PAGE_PER_NO * $id;
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%".$param['handles']."%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire) limit $pageLimit, ".$this->_PAGE_PER_NO;
                $result = self::$db->query($sql);
                
                $count=$param['pag_no']; 
          }else{
                $sql01 = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%rubber%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
                $result = self::$db->query($sql01);
                
                $sql02 = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%plastic%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
                $result01 = self::$db->query($sql02);
                
                $rubber=mysqli_num_rows($result);
                
                $plastic=mysqli_num_rows($result01);
                $count = null; 
                                                 
            }  
            $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }
            
            $HTML=$paginationCount.'##';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    <h4>'.$row['denumire'].' - '.str_replace(';', ',', $row['caracteristici']).'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;    
      }
      public function WheelsProducts($param, &$aluminum, &$iron){
          if($param['f']){
          if(isset($param['pageId']) && !empty($param['pageId'])){
                     $id=$param['pageId'];
                }else{
                     $id='0';
                }

                $pageLimit = $this->_PAGE_PER_NO * $id;
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%".$param['wheels']."%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire) limit $pageLimit, ".$this->_PAGE_PER_NO;
                $result = self::$db->query($sql);
                
                $count=$param['pag_no']; 
          }else{
                $sql01 = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%aluminum%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
                $result = self::$db->query($sql01);
                
                $sql02 = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%iron%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
                $result01 = self::$db->query($sql02);
                
                $aluminum=mysqli_num_rows($result);
                
                $iron=mysqli_num_rows($result01);
                $count = null; 
                                                 
            }  
            $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }
            
            $HTML=$paginationCount.'##';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    <h4>'.$row['denumire'].' - '.str_replace(';', ',', $row['caracteristici']).'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;    
      }
      public function HornProducts($param, &$yes, &$no){
          if($param['f']){
          if(isset($param['pageId']) && !empty($param['pageId'])){
                     $id=$param['pageId'];
                }else{
                     $id='0';
                }

                $pageLimit = $this->_PAGE_PER_NO * $id;
                $sql = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                            WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%".$param['horn']."%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire) limit $pageLimit, ".$this->_PAGE_PER_NO;
                $result = self::$db->query($sql);
                
                $count=$param['pag_no']; 
          }else{
                $sql01 = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%aluminum%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
                $result = self::$db->query($sql01);
                
                $sql02 = "SELECT a.* FROM trotinete a, puncte_de_lucru b 
                        WHERE a.id_punct_de_lucru=b.id AND a.caracteristici like '%iron%' AND b.adresa='{$param['adress_start']}' AND a.nr_bucati>a.nr_bucati_inchiriate AND a.id NOT IN (SELECT id_trotineta FROM inchirieri WHERE '{$param['start-date']}' BETWEEN data_inchiriere AND data_restituire);";
          
                $result01 = self::$db->query($sql02);
                
                $yes = mysqli_num_rows($result);
                
                $no = mysqli_num_rows($result01);
                $count = null; 
                                                 
            }  
            $paginationCount= floor($count / $this->_PAGE_PER_NO);

              $paginationModCount= $count % $this->_PAGE_PER_NO;
              if(!empty($paginationModCount)){
                 $paginationCount++;
              }
            
            $HTML=$paginationCount.'##';
            $i=0;
            if($count > 0){
              while($row=mysqli_fetch_array($result)){
                    if($row['nr_bucati_inchiriate']>=$row['nr_bucati']){
                                            $dis = '<font style="color: #E60520;">Rented</font>';
                                            $disabled = 'disabled';
                                        }else{
                                            $dis = '<font style="color: #80BD55;">In Stock</font>';
                                            $disabled = '';
                                        }
                                        if($i == $count){
                                            $class = 'class="results-row last-li"';
                                        }else{
                                            $class = 'class="results-row"';
                                        }
                                        $HTML.='<li '.$class.'>
                                                <div id="scooter-list-img">
                                                    <img src="'.$row['imagine'].'" width="180"/>
                                                </div>
                                                <div id="scooter-list-desc">
                                                    <h4>'.$row['denumire'].' - '.str_replace(';', ',', $row['caracteristici']).'</h4>
                                                    <p>'.$row['descriere'].'</p>
                                                </div>
                                                <div id="scooter-list-option">
                                                    <div class="scooter-detailed-price">
                                                        '.$row['pret_inchiriere'] . ' EUR/day
                                                    </div>
                                                    <div class="scooter-detailed-reserved">
                                                        '.$dis.'
                                                    </div>
                                                    <div id="container-right-rent" style="width: 150px; margin: 0 auto;">
                                                        <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter(\''.$scooter['id'].'\')" '.$disabled.' style="width: 150px;"/>
                                                    </div>
                                                </div>
                                            </li>'; 
                                        $i++;     
              }
            }else{
              $HTML='No Data Found';
            }
            return $HTML;    
      }
  }
?>
