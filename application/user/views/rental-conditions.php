<?php $model = new ModelUser(); ?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian-Nicolae Mihaila, Diana Alexandra Saveluc, Alin Paul Macovei</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="<?=WSystem::$url?>assets/css/main.css" />  
        <link rel="stylesheet" type="text/css" media="all" href="<?=WSystem::$url?>assets/css/jquery.hoverscroll.css" />

    </head>
    <body> 
        <?php $result = $model->getUser(); ?>         
        <header>
            <div class="content">
                <div id="logo">
                    <a href="<?=WSystem::$url?>" title="WildRide"><img src="<?=WSystem::$url?>img/logo.png" alt="WildRide"/></a>
                </div>
                <div id="navigator">
                    <nav>
                        <a href="<?=WSystem::$url?>about" title="About Us">about us</a>
                        <a href="<?=WSystem::$url?>search/filter/view_special_offers" title="Special Offers">special offers</a>
                        <a href="<?=WSystem::$url?>partners" title="Partners">partners</a>
                        <a href="<?=WSystem::$url?>contact" title="Contact">contact</a>
                    </nav>
                </div>
            </div>

        </header>
        <section id="container">
            <div class="content">
                <div id="rental-conditions">
                    <h2>Scooter Rental Terms & Conditions</h2>
                    <p>
                        <b>WildRide rents scooters to its clients on the following terms:</b>
                        <ul>
                            <li>Rental rates are based on an hourly pricing</li> 
                            <li>The payment is to be done ONLY in our stores (we do not accept online payments), after signing the rental conditions papers.</li>
                            <li>If your age is somewhere between 2 and 98 then then our scooter rental services are a superb option for you to get all the fun you could hope for! However all scooter rentals require a valid ID in order for the signing of papers to be done, so the client be 18 years old or accompanied by a parent or guardian in order to sign the rental papers.</li>
                            <li>Travel Insurance: It is the responsibility of clients to hold their own travel insurance policy to cover personnel medical care in case of accident, loss due to cancellation, and any third party liability that may arise from the use of the Rental Scooters by clients. No coverage is available from WildRide to insure Clients from loss in case of damage, theft or other liability incurred in the use of the Rental Scooters.</li>
                            <li>Status of Rental Bicycle: WildRide confirms that an experienced scooter mechanic, prior to renting, reviews each scooter. Each scooter is prepped for rental and supplied to clients in properly operating status, and is ready to ride.</li> 
                            <li>Theft of and Damage to Rental Scooters: Subject to this clause the client is responsible for any and all damage once scooters are received by clients. This includes but is not limited to any form of theft and damage to the Rental Scooter.</li>
                        </ul>
                    </p>
                    <br/>
                    <p> 
                        <b>Other Details</b><br/><br/>
                        We have several varieties of scooters in stock, ranging from kid scooters to scooters designed for stunts and competitions. We always provide outstanding customer services, meticulously planned and organized rides and tours (or you can just choose your own riding locations), top-of-the-line rental equipment, and we want our customers to have fun!  All of our scooters are eco-friendly and human powered.  They're all lightweight, compact, and easy to carry.  All rental scooters come with a shoulder strap for carrying, and a rear brake or even a front brake too on some models.  Our most durable scooters can support up to 300lbs. 
                    </p>
                </div> 
            </div>
        </section>
        <section id="aditional-tool"> 
            <div id="members-area">
                <div id="members-area-content">
                    <h3>Members Area</h3>
                    <h4><?php
                        if (is_array($result)) {
                            echo 'Bune ai venit, <a href="'.WSystem::$url.'user/view"> ' . $result['nume'] . " " . $result['prenume'] . "</a>!</h4>";
                            echo '<input type="button" value="Logout" onclick="Logout()" class="input-logout"/>';
                        } else {
                            echo 'Welcome guest!</br>Please</h4>
                            <input type="button" value="Sign In" onclick="go(\'index\',\'login\');"/>
                            <div id="members-area-login">or</div>
                            <input type="button" value="Sign Up" onclick="go(\'index\',\'login\');"/>'; 
                        }
                    ?>
                </div>                        
            </div>
            <div id="weather">
                <div id="weather-content">
                    <h3>Current Weather</h3>
                    <div id="weather-content"></div>
                </div>                        
            </div>
            <div id="currency"> 
                <div id="currency-content">
                    <?php $rates = $model->getExchangeRates();?>  
                    <h3>Currency Rates</h3>
                    <ul>
                        <li><img src="<?=WSystem::$url?>img/eur.png" alt="" width="25"/><?php echo '1 '.$rates[0]['from'].' - ' . number_format($rates[0]['to'], 2) . ' RON';?></li>
                        <li><img src="<?=WSystem::$url?>img/usd.png" alt="" width="25"/><?php echo '1 '.$rates[1]['from'].' - ' . number_format($rates[1]['to'], 2) . ' RON';?></li>
                        <li><img src="<?=WSystem::$url?>img/gbp.png" alt="" width="25"/><?php echo '1 '.$rates[2]['from'].' - ' . number_format($rates[2]['to'], 2) . ' RON';?></li>
                    </ul>
                    <input type="button" value="More" onclick="window.open('http://xe.com','_blank');"/>
                </div>                     
            </div>                                   
        </section>
        <footer>
            <div class="content">
                <section class="footer-content" style="margin-right: 67px;">
                    <h3>Quick Navigation</h3>
                    <ul>
                        <li><a href="<?=WSystem::$url?>" title="">Home</a></li>
                        <li><a href="<?=WSystem::$url?>about" title="">About Us</a></li>
                        <li><a href="<?=WSystem::$url?>search/filter/view_special_offers" title="">Special Offers</a></li>
                        <li><a href="<?=WSystem::$url?>partners" title="">Partners</a></li>
                        <li><a href="<?=WSystem::$url?>rentalConditions" title="">Rental Conditions</a></li>  
                        <li><a href="<?=WSystem::$url?>contact" title="">Contact</a></li>
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
                        <li><a href="https://www.facebook.com/WildrideBusiness" target="_blank" title="">Facebook</a></li>
                        <li><a href="https://twitter.com/WildRideProject" target="_blank" title="">Twitter</a></li>
                        <li><a href="https://plus.google.com/110979650659175550433" target="_blank" title="">Google+</a></li>
                        <li><a href="http://www.youtube.com/user/WildrideBusiness" target="_blank" title="">YouTube</a></li>
                        <li><a href="http://ro.linkedin.com/pub/wildride-business/73/791/5a9" target="_blank" title="">LinkedIn</a></li>
                        <li><a href="http://ro.wikipedia.org/wiki/Utilizator:WildrideBusiness" target="_blank" title="">Wikipedia</a></li>
                        <li><a href="http://wildrideproject/blog/" target="_blank" title="">Blog WildRide</a></li>
                    </ul>
                </section>
                <section class="footer-content">
                    <h3>Newsletter</h3>
                    <p>Keep up with new offers!</p>
                    <form action="<?=WSystem::$url?>newsletter" method="post">                            
                        <input type="email" name="email" id="email-newsletter" required="required">                             
                        <input type="submit" value="Subscribe"/>
                    </form>
                </section>
            </div>
        </footer>
        <div id="footer-copyright">
            Copyright © 2013 WildRide
        </div> 
        <script type="text/javascript" src="<?=WSystem::$url?>assets/js/jquery-1.9.1.min.js"></script> 
        <script type="text/javascript" src="<?=WSystem::$url?>assets/js/jquery.hoverscroll.js"></script>        
        <script src="<?=WSystem::$url?>assets/js/jquery.zweatherfeed.min.js" type="text/javascript"></script> 
        <script src="<?=WSystem::$url?>assets/js/functions.js" type="text/javascript"></script> 
        <script type="text/javascript">
            var urlLogin = '<?=WSystem::$url?>login'; 
            var urlRentView = '<?=WSystem::$url?>rent/view/';
        </script> 
        <script type="text/javascript">

            $(document).ready(function() {
                    $('#weather-content').weatherfeed(['873915'],{
                            woeid: true
                    });
                    $.fn.hoverscroll.params = $.extend($.fn.hoverscroll.params, {  
                            vertical: false,
                            width: 980,
                            height: 270,
                            arrows: false
                    });
                    $('#horizontal-scooters-history').hoverscroll();

                    $("#members-area").mouseover(function() {
                            $("#members-area-content").show();
                            $("#weather-content").hide();
                            $("#currency-content").hide();
                    }).mouseout(function() {
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
                    }).mouseout(function() {
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
                    }).mouseout(function() {
                            $("#currency-content").mouseenter(function() {
                                    $("#currency-content").show();
                            }).mouseleave(function() {
                                    $("#currency-content").hide();
                            });
                    });

            });
        </script>
    </body>
</html>
