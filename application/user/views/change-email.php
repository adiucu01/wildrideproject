<?php
//require_once("/../models/user.php"); 
$model = new ModelUser();
if (!$model->isValidUser())
//header('Location: login.php');
    WSystem::redirect("index", "login");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Womics | Adrian Mihaila & Saveluc Diana</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="assets/css/main.css" />  
        <link rel="stylesheet" type="text/css" media="all" href="assets/css/jquery.hoverscroll.css" />

    </head>
    <body> 
        <?php $result = $model->getUser(); ?>         
        <header>
            <div class="content">
                <div id="logo">
                    <a href="default.php" title="WildRide"><img src="img/logo.png" alt="WildRide"/></a>
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
                <div id="user-navigator">
                    <ul>
                        <li><a href="orders.php" title="View Orders History">Orders History</a></li>
                        <li><a href="change-email.php" title="Change Email Login">Change Email Login</a></li>
                        <li><a href="change-password.php" title="Change Password Login">Change Password Login</a></li>
                    </ul>
                </div>    
                <div id="user-information">
                    <form action="index.php?c=user&a=changeEmail&id=<?php echo $result['id']; ?>" method="POST" id="form-signup">               
                        <label class="login-label">
                            Email
                        </label>

                        <input type="text" name="email" class="login-input" value="<?php echo $result['email']; ?>" />

                        <label class="login-label">
                            New Email
                        </label>

                        <input type="text" name="new_email" class="login-input" />

                        <input type="submit" value="Update" name="update"/>  
                    </form>
                </div>
            </div>
        </section>
        <section id="scooter-history">
            <div class="content">
                <h2>History Views</h2>
                <ul id="horizontal-scooters-history">
                    <?php echo $model->getScootersHistory(); ?>   
                </ul>
            </div>
        </section>
        <section id="aditional-tool"> 
            <div id="members-area">
                <div id="members-area-content">
                    <h3>Members Area</h3>
                    <h4><?php
                        if (is_array($result)) {
                            echo 'Bune ai venit, <a href="index.php?c=user&a=view&id=' . $result['id'] . '"> ' . $result['nume'] . " " . $result['prenume'] . "</a>!</h4>";
                            echo '<input type="button" value="Logout" onclick="Logout()" class="input-logout"/>';
                        } else {
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
                    <?php $model->getWeather($temp_c, $img_url, $loc); ?>
                    <div id="weather-content-img"><img src="<?php echo $img_url; ?>" alt="" /></div>
                    <div id="weather-location"><?php echo $loc; ?></div>
                    <div id="weather-temp"><?php echo $temp_c . '°C'; ?></div>
                    <input type="button" value="More"/> 
                </div>                        
            </div>
            <div id="currency"> 
                <div id="currency-content">
                    <?php $rates = $model->getExchangeRates(); ?>
                    <h3>Currency Rates</h3>
                    <ul>
                        <li><img src="img/eur.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(1, 2, '.', ' ') . ' EUR'; ?></li>
                        <li><img src="img/usd.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(floatval($rates['EURUSD']), 2) . ' USD'; ?></li>
                        <li><img src="img/gbp.png" alt="" width="25"/><?php echo '1 EUR - ' . number_format(floatval('0' . $rates['EURGBP']), 2) . ' GBP'; ?></li>
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
        
        <script type="text/javascript" src="assets/js/jquery-1.9.1.min.js"></script> 
        <script type="text/javascript" src="assets/js/jquery.hoverscroll.js"></script>
        <script type="text/javascript" src="assets/js/functions.js"></script>

        <script type="text/javascript">

            $(document).ready(function() {
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
