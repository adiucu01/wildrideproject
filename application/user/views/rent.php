<?php $model = new UserModelRent(); 
if (isset($_SERVER['HTTP_REFERER']) && !$_SERVER['HTTP_REFERER'])
        $_SESSION['HTTP_REFERER'] = $_SERVER['HTTP_REFERER']; 
if (!$model->isValidUser()) WSystem::redirect("index", "login"); $model->setHistoryViews($param['id']);?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian-Nicolae Mihaila, Diana Alexandra Saveluc, Alin Paul Macovei</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="<?=WSystem::$url?>assets/css/main.css" />  
        <link rel="stylesheet" type="text/css" media="all" href="<?=WSystem::$url?>assets/css/jquery.hoverscroll.css" />        
        <link rel="stylesheet" href="<?=WSystem::$url?>assets/css/datepicker_bootstrap.css" >          

        <?php
            $scooter = $model->getScooter($param['id']);
            $region_end = $city_end = $adress_end = null;
            $model->getPositionEnd($region_end, $city_end, $adress_end);
        ?> 

    </head>
    <body onload="initialize();"> 
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
                <h2><?php echo $scooter['denumire']; ?></h2>
                <div id="rent-picture">
                    <img src="<?php echo WSystem::$url.$scooter['imagine']; ?>" alt="<?php echo $scooter['denumire']; ?>" height="330"/>
                </div>
                <div id="rent-details">
                    <form action="<?=WSystem::$url?>rent/rent/<?php echo $param['id']; ?>" method="post" id="form-rent" name="form-rent">
                        <h4>Pick-up</h4>
                        <label class="search-label">Location</label> 
                        <input type="text" name="location_start" readonly="readonly" value="<?php echo $scooter['adresa']; ?>" class="input-login"/>
                        <label class="search-label">Date</label>    
                        <input type="text" name="start-date" id="start-date" class="input-login" value="<?php echo date("m/d/Y H:iA"); ?>"/>

                        <h4>Return</h4> 
                        <label class="search-label">Region</label>
                        <div class="search-select">
                            <select name="region_end">
                                <?php echo $region_end; ?>
                            </select>
                        </div>

                        <label class="search-label">City</label>
                        <div class="search-select">
                            <select name="city_end">
                                <?php echo $city_end; ?>
                            </select>
                        </div>

                        <label class="search-label">Location</label>
                        <div class="search-select">
                            <select name="adress_end">
                                <?php echo $adress_end; ?>
                            </select>
                        </div>
                        <label class="search-label">Date</label>    
                        <input type="text" name="end-date" id="end-date" class="input-login" value="<?php echo date("m/d/Y H:iA"); ?>"/>

                        <label class="search-label">No. Pieces</label>
                        <input type="range" name="nr_bucati" class="input-login" value="1" min="1" max="<?php echo $scooter['nr_bucati'] - $scooter['nr_bucati_inchiriate']; ?>" step="1" onchange="showPieces(this);" style="width: 140px;"/><input type="text" id="pieces" size="2" value="1" readonly="readonly"/>
                        <input type="hidden" name="pret_inchiriere" value="<?php echo $scooter['pret_inchiriere']; ?>"/>
                        <input type="hidden" name="nr_bucati_inchiriate" value="<?php echo $scooter['nr_bucati_inchiriate']; ?>"/>
                    </form>
                </div>
                <div id="rent-description">
                    <nav>
                        <a onclick="RentNavigatorDescription(1, this)" class="current-item">Scooter Description</a>
                        <a onclick="RentNavigatorDescription(2, this)">View Map</a>
                        <a onclick="RentNavigatorDescription(3, this)">Rental Conditions</a> 
                    </nav>
                    <div id="scooter-desc">                                    
                        <p id="container-description">
                            <?php echo $scooter['descriere']; ?>   
                        </p> 
                        <h2>Specification</h2>
                        <p id="container-description">
                            <?php 
                                $c_arr = explode(';',$scooter['caracteristici']);
                                for($key00 = 0; $key00<count($c_arr)-1;$key00++){
                                    $c_strings = explode('=',$c_arr[$key00]); 
                                    echo ucfirst($c_strings[0]).': '.ucfirst($c_strings[1])."</br></br>";
                                    if($key00==count($c_arr)-2){
                                        $c_string .= '';
                                    }else{
                                        $c_string .= ' and ';
                                    }                                             
                            } ?>   
                        </p> 
                    </div>
                    <div id="view-map">
                        <div id="control">
                            <strong>Start:</strong>
                            <input type="text" id="start" name="start" value="" readonly="readonly"/>
                            <strong>End:</strong>
                            <select id="end" onchange="calcRoute();">
                                <?php echo $adress_end; ?>
                            </select>
                        </div>
                        <div id="directions-panel"></div>
                        <div id="map-canvas" style="height: 500px;"></div>
                    </div>
                    <div id="rental-cond">
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
                        <div id="agree-cond">
                            Agree <input type="checkbox" id="agree-cond-input" />
                        </div>
                    </div>
                    <input type="button" value="Rent" onclick="return SubmitRent();"/>
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
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script> 
        <script src="<?=WSystem::$url?>assets/js/mootools-core.js" type="text/javascript"></script>
        <script src="<?=WSystem::$url?>assets/js/mootools-more.js" type="text/javascript"></script>
        <script src="<?=WSystem::$url?>assets/js/Locale.en-US.DatePicker.js" type="text/javascript"></script>
        <script src="<?=WSystem::$url?>assets/js/Picker.js" type="text/javascript"></script>
        <script src="<?=WSystem::$url?>assets/js/Picker.Attach.js" type="text/javascript"></script>
        <script src="<?=WSystem::$url?>assets/js/Picker.Date.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?=WSystem::$url?>assets/js/jquery.hoverscroll.js"></script>
        <script type="text/javascript" src='<?=WSystem::$url?>assets/js/jquery.zoom-min.js'></script>
        <script type="text/javascript" src='<?=WSystem::$url?>assets/js/functions.js'></script>
        <script src="<?=WSystem::$url?>assets/js/jquery.zweatherfeed.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var urlLogin = '<?=WSystem::$url?>login'; 
            var urlRentView = '<?=WSystem::$url?>rent/view/';
        </script> 
        <script type="text/javascript">
            var map;
            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService();
            var geocoder;
            var init = 1;

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

                    window.addEvent('domready', function() {
                            new Picker.Date($$('#start-date'), {
                                    timePicker: true,
                                    positionOffset: {x: 5, y: 0},
                                    pickerClass: 'datepicker_bootstrap',
                                    useFadeInOut: !Browser.ie
                            });
                    });

                    window.addEvent('domready', function() {
                            new Picker.Date($$('#end-date'), {
                                    timePicker: true,
                                    positionOffset: {x: 5, y: 0},
                                    pickerClass: 'datepicker_bootstrap',
                                    useFadeInOut: !Browser.ie
                            });
                    });

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
            function RentNavigatorDescription(div, a) {
                switch (div) {
                    case 1:
                        $('#scooter-desc').show();
                        $(a.parentNode.children).each(function(index) {
                                this.removeClass('current-item');
                        });
                        a.className = "current-item";
                        $('#view-map').hide();
                        $('#rental-cond').hide();
                        break;
                    case 2:
                    $('#view-map').show();
                    $(a.parentNode.children).each(function(index) {
                            this.removeClass('current-item');
                    });
                    if (init === 1) {
                        initialize();
                        var control = document.getElementById('control');
                        control.style.display = 'block';
                        map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);
                        $("#start").val('<?php echo $scooter['adresa']; ?>');
                        codeAddress('<?php echo $scooter['adresa']; ?>');
                        init++;
                    }
                    a.className = "current-item";
                    $('#scooter-desc').hide();
                    $('#rental-cond').hide();
                    break;
                    case 3:
                        $('#rental-cond').show();
                        $(a.parentNode.children).each(function(index) {
                                this.removeClass('current-item');
                        });
                        a.className = "current-item";
                        $('#scooter-desc').hide();
                        $('#view-map').hide();
                        break;
                }
            }
            function initialize() {
                geocoder = new google.maps.Geocoder();
                directionsDisplay = new google.maps.DirectionsRenderer();
                var mapOptions = {
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById('directions-panel'));
            }

            function calcRoute() {
                var start = document.getElementById('start').value;
                var end = document.getElementById('end').value;
                codeAddress(end);
                var request = {
                    origin: start,
                    destination: end,
                    travelMode: google.maps.TravelMode.DRIVING
                };
                directionsService.route(request, function(response, status) {
                        if (status === google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                        }
                });
            }
            function codeAddress(address) {
                geocoder.geocode({'address': address}, function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            /*var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                            });*/
                            return results[0].geometry.location;
                        } else {
                            alert('Geocode was not successful for the following reason: ' + status);
                        }
                });
            }
            function SubmitRent() {
                var agree = document.getElementById("agree-cond-input");
                if (agree.checked) {
                    document.forms["form-rent"].submit();
                    return true;
                } else {
                    alert('Please read the Rental Conditions!');
                    return false;
                }
            }
            function showPieces(input) {
                document.getElementById("pieces").value = input.value;
            }
            google.maps.event.addDomListener(window, 'load', initialize);
            google.maps.event.trigger("#view-map", 'resize');
        </script>
    </body>
</html>
