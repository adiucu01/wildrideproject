<?php require_once("/../models/scooter.php"); $model = new ModelScooter(); $model->setHistoryViews($_GET['id']); ?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Womics | Adrian Mihaila & Saveluc Diana</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="../../../assets/css/main.css" /> 
        <link rel="stylesheet" type="text/css" media="all" href="../../../assets/css/jquery.hoverscroll.css" />
        
        <script type="text/javascript" src="../../../assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="../../../assets/js/jquery.hoverscroll.js"></script>
        <script type="text/javascript" src='../../../assets/js/jquery.zoom-min.js'></script>
        

        <script type="text/javascript">
            
            $(document).ready(function(){
                
                $.fn.hoverscroll.params = $.extend($.fn.hoverscroll.params, {
                    vertical : true,
                    width: 90,
                    height: 330,
                    arrows: false
                });
                $('#small-picture-list').hoverscroll();
                $('#large-picture-zoom').zoom({ on:'click' });          
                
                $("#members-area").mouseover(function() {
                        $("#members-area-content").show();
                        $("#weather-content").hide();
                        $("#currency-content").hide();
                  }).mouseout(function(){
                        $("#members-area-content").mouseenter(function() {
                                $("#members-area-content").show(); 
                        }).mouseleave(function() {
                                $("#members-area-content").hide();
                        });        
                });
                
                $("#weather").mouseover(function() {
                        $("#members-area-content").hide();
                        $("#weather-content").show();
                        $("#currency-content").hide();
                  }).mouseout(function(){
                        $("#weather-content").mouseenter(function() {
                                $("#weather-content").show(); 
                        }).mouseleave(function() {
                                $("#weather-content").hide();
                        });        
                });  
                
                $("#currency").mouseover(function() {
                        $("#members-area-content").hide();
                        $("#currency-content").show();
                        $("#weather-content").hide();
                  }).mouseout(function(){
                        $("#currency-content").mouseenter(function() {
                                $("#currency-content").show(); 
                        }).mouseleave(function() {
                                $("#currency-content").hide();
                        });        
                });  

                                     
            });
                           
            function Logout(){
                deleteCookie('user_id');
                deleteCookie('user_session_id');
                window.location.href = "login.php";
            }
            function deleteCookie(name) {
                var date = new Date();
                date.setTime(date.getTime()+(-1*24*60*60*1000));
                var expires = " expires="+date.toGMTString();
                document.cookie = name+"=;"+expires+"; path=/";
            }
            function RentScooter(id){
                window.location = 'rent.php?id=' + id; 
            }
        </script> 
    </head>
    <body> 
        <?php $result = $model->getUser(); ?>         
            <header>
                <div class="content">
                    <div id="logo">
                        <a href="default.php" title="WildRide"><img src="../../../img/logo.png" alt="WildRide"/></a>
                    </div>
                    <div id="navigator">
                    <nav>
                        <a href="about-us.php" title="About Us">about us</a>
                        <a href="special-offers.php" title="Special Offers">special offers</a>
                        <a href="reservation.php" title="Rezervation">rezervation</a>
                        <a href="contact.php" title="Contact">contact</a>
                    </nav>
                </div>
                </div>
                        
            </header>
                <section id="container">
                    <div class="content">
                          <?php $scooter = $model->getScooter($_GET['id']);?>
                          <h2><?php echo $scooter['denumire'] . ' - ' . str_replace(';',' ',$scooter['caracteristici']); ?></h2>
                          <div id="container-left-side">
                            <div id="small-picture">
                                <ul id="small-picture-list">
                                    <li>pic1</li>
                                    <li>pic2</li>
                                    <li>pic3</li>
                                    <li>pic4</li>
                                    <li>pic5</li>
                                    <li>pic6</li>
                                </ul>
                            </div>
                            <div id="large-picture">
                                <span class='zoom' id='large-picture-zoom'>
                                    <img src='../../../<?php echo $scooter['imagine']; ?>' alt='<?php echo $scooter['denumire']; ?>'/>
                                    <p>Click to activate</p>
                                </span>
                            </div>
                          </div>
                          <div id="container-right-side">
                            <div class="scooter-detailed-price" style="margin-top:90px;">
                                <?php echo $scooter['pret_inchiriere'] . ' EUR/day'; ?>
                            </div>
                            <div class="scooter-detailed-reserved">
                                <?php
                                     if($scooter['nr_bucati_inchiriate']>=$scooter['nr_bucati']){
                                         echo '<font style="color: #E60520;">Rented</font>';
                                         $disabled = 'disabled';
                                     }else{
                                         echo '<font style="color: #80BD55;">In Stock</font>';
                                         $disabled = '';
                                     }
                                 ?>
                            </div>
                            <div id="container-right-rent">
                                <input type="button" value="Rent" class="scooter-detailed-rent" onclick="RentScooter('<?php echo $_GET['id']; ?>')" <?php echo $disabled;?>/>
                            </div>
                          </div>
                          <div id="container-description">
                                <h2>Description</h2>
                                <p>
                                    <?php echo $scooter['descriere']; ?>   
                                </p>
                          </div>
                          <div id="container-specification">
                                <h2>Specification</h2>
                                <p id="container-description">
                                    <?php echo $scooter['caracteristici']; ?>   
                                </p>
                          </div>
                    </div>
                </section>
                <section id="aditional-tool"> 
                    <div id="members-area">
                        <div id="members-area-content">
                            <h3>Members Area</h3>
                            <h4><?php 
                                if(is_array($result)){
                                    echo 'Bune ai venit, <a href="../controllers/user.php?action=view&id='.$result['id'].'"> ' . $result['nume'] ." ". $result['prenume'] ."</a>!</h4>";
                                    echo '<input type="button" value="Logout" onclick="Logout()" class="input-logout"/>';
                                }else{
                                    echo 'Welcome guest!</br>Please</h4>
                                            <input type="button" value="Sign In"/>
                                            <div id="members-area-login">or</div>
                                            <input type="button" value="Sign Up"/>'; 
                                }                            
                            ?>
                        </div>                        
                    </div>
                    <div id="weather">
                        <div id="weather-content">
                            <h3>Current Weather</h3>
                            <?php $model->getWeather($temp_c,$img_url,$loc);?>
                            <div id="weather-content-img"><img src="<?php echo $img_url;?>" alt="" /></div>
                            <div id="weather-location"><?php echo $loc; ?></div>
                            <div id="weather-temp"><?php echo $temp_c . '°C'; ?></div>
                            <input type="button" value="More"/> 
                        </div>                        
                    </div>
                    <div id="currency"> 
                        <div id="currency-content">
                            <?php $rates = $model->getExchangeRates();?>
                            <h3>Currency Rates</h3>
                            <ul>
                                <li><img src="../../../img/eur.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(1, 2, '.', ' ') . ' EUR';?></li>
                                <li><img src="../../../img/usd.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(floatval($rates['EURUSD']), 2) . ' USD';?></li>
                                <li><img src="../../../img/gbp.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(floatval('0'.$rates['EURGBP']), 2) . ' GBP';?></li>
                            </ul>
                            <input type="button" value="More"/>
                        </div>                     
                    </div>                                   
                </section>
            <footer>
                <div class="content">
                    <section class="footer-content" style="margin-right: 67px;">
                        <h3>Quick Navigation</h3>
                        <ul>
                            <li><a href="" title="">Home</a></li>
                            <li><a href="" title="">About Us</a></li>
                            <li><a href="" title="">Special Offers</a></li>
                            <li><a href="" title="">Rezervation</a></li>
                            <li><a href="" title="">Rental Conditions</a></li>
                            <li><a href="" title="">Partners</a></li>
                            <li><a href="" title="">Contact</a></li>
                        </ul>
                    </section>
                    <section class="footer-content" style="margin-right: 66px;">
                        <h3>Contact</h3>
                        <p> Luni-Vineri: 8-20<br/>
                            Sambata-Duminica: 10-18</br>
                            Contact: 0756 318 976</br>
                            <font style="color : #dbdada;">...........</font>: 0760 489 168</br>
                                   E-mail: office@wildride.ro
                        </p>
                    </section>
                    <section class="footer-content" style="margin-right: 67px;">
                        <h3>Keep in Touch</h3>
                        <ul>
                            <li><a href="" title="">Facebook</a></li>
                            <li><a href="" title="">Twitter</a></li>
                            <li><a href="" title="">Google+</a></li>
                            <li><a href="" title="">YouTube</a></li>
                            <li><a href="" title="">LinkedIn</a></li>
                            <li><a href="" title="">Wikipedia</a></li>
                            <li><a href="" title="">Blog WildRide</a></li>
                        </ul>
                    </section>
                    <section class="footer-content">
                        <h3>Newsletter</h3>
                        <p>Keep up with new offers!</p>
                        <form action="../controllers/newsletter.php" method="post">                            
                            <input type="email" name="email-newsletter" id="email-newsletter" required="required">                             
                            <input type="submit" value="Subscribe"/>
                        </form>
                    </section>
                </div>
            </footer>
            <div id="footer-copyright">
                    Copyright © 2013 WildRide
            </div>             
    </body>
</html>
