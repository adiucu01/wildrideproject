<?php 
//require_once("/../models/rent.php"); 
$model = new UserModelRent(); if(!$model->isValidUser()) header('Location: login.php'); $model->setHistoryViews($_GET['id']);?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Womics | Adrian Mihaila & Saveluc Diana</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="../../../assets/css/main.css" />  
        <link rel="stylesheet" type="text/css" media="all" href="../../../assets/css/jquery.hoverscroll.css" />        
        <link rel="stylesheet" href="../../../assets/css/datepicker_bootstrap.css" >
        
        <script type="text/javascript" src="../../../assets/js/jquery-1.9.1.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script> 
        <script src="../../../assets/js/mootools-core.js" type="text/javascript"></script>
        <script src="../../../assets/js/mootools-more.js" type="text/javascript"></script>
        <script src="../../../assets/js/Locale.en-US.DatePicker.js" type="text/javascript"></script>
        <script src="../../../assets/js/Picker.js" type="text/javascript"></script>
        <script src="../../../assets/js/Picker.Attach.js" type="text/javascript"></script>
        <script src="../../../assets/js/Picker.Date.js" type="text/javascript"></script>
        <script type="text/javascript" src="../../../assets/js/jquery.hoverscroll.js"></script>
        <script type="text/javascript" src='../../../assets/js/jquery.zoom-min.js'></script>            
        
        <?php $scooter = $model->getScooter($_GET['id']); $model->getPositionEnd($region_end,$city_end,$adress_end);?>
        
        <script type="text/javascript">
            var map;
            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService(); 
            var geocoder; 
            var init = 1; 
            
            $(document).ready(function(){                
                                                                      
                $.fn.hoverscroll.params = $.extend($.fn.hoverscroll.params, {
                    vertical : false,
                    width: 980,
                    height: 270,
                    arrows: false
                });
                $('#horizontal-scooters-history').hoverscroll();  
                                                                     
                window.addEvent('domready', function(){
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
            function selectOras(judet){
                var judete = <?php echo JUDET; ?>;
                
                var orasSelect = document.getElementById("oras");
                var form = document.getElementById("form-signup");
                var judetLabel = document.getElementById("judet");
                var divSelect = document.getElementById('search-judet');
                
                if(orasSelect != null){
                    form.removeChild(document.getElementById("login-label-oras")); 
                    form.removeChild(document.getElementById("search-oras"));     
                }
                
                var select = document.createElement("select");
                select.setAttribute("name", "oras");
                select.id="oras";
                
                for(var oras in judete[judet.value]){
                    var option = document.createElement("option");
                    option.setAttribute("value", oras);
                    option.innerHTML = oras;
                    select.appendChild(option);
                }
                var div = document.createElement("div");
                div.className = "search-select";
                div.id = "search-oras";
                
                var label = document.createElement("label");
                label.className = "login-label";
                label.id = "login-label-oras";
                label.innerHTML = "Oras";
                
                div.appendChild(label); 
                div.appendChild(select);
                divSelect.parentNode.insertBefore(label, divSelect.nextSibling);  
                label.parentNode.insertBefore(div, label.nextSibling); 
            }
            function RentNavigatorDescription(div,a){
                switch(div){
                    case 1:
                        $('#scooter-desc').show();
                        $(a.parentNode.children).each(function( index ) {
                          this.removeClass('current-item');
                        });
                        a.className = "current-item"; 
                        $('#view-map').hide();  
                        $('#rental-cond').hide();
                    break;
                    case 2:
                        $('#view-map').show();
                        $(a.parentNode.children).each(function( index ) {
                          this.removeClass('current-item');
                        });
                           
                        if(init==1){
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
                         $(a.parentNode.children).each(function( index ) {
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
                if (status == google.maps.DirectionsStatus.OK) {
                  directionsDisplay.setDirections(response);
                }
              });
            } 
            function codeAddress(address) {
              geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
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
            function SubmitRent(){
                var agree = document.getElementById("agree-cond-input");
                if(agree.checked){
                    document.forms["form-rent"].submit();
                    return true;
                }else{
                    alert('Please read the Rental Conditions!');
                    return false;
                }
            }
            function showPieces(input){
                document.getElementById("pieces").value = input.value;
            }
            
            google.maps.event.addDomListener(window, 'load', initialize); 
            google.maps.event.trigger("#view-map", 'resize');  
        </script> 
    </head>
    <body onload="initialize();"> 
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
                        <h2><?php echo $scooter['denumire'];?></h2>
                        <div id="rent-picture">
                            <img src="../../../<?php echo $scooter['imagine'];?>" alt="<?php echo $scooter['denumire']; ?>" height="330"/>
                        </div>
                        <div id="rent-details">
                            <form action="../controllers/rent.php?action=rent&id=<?php echo $_GET['id'];?>" method="post" id="form-rent" name="form-rent">
                                <h4>Pick-up</h4>
                                <label class="search-label">Location</label> 
                                <input type="text" name="location_start" readonly="readonly" value="<?php echo $scooter['adresa']; ?>" class="input-login"/>
                                <label class="search-label">Date</label>    
                                <input type="text" name="start-date" class="input-login" readonly="readonly" value="<?php echo date("m/d/Y H:iA");?>"/>
                                
                                <h4>Return</h4> 
                                <label class="search-label">Region</label>
                                <div class="search-select">
                                    <select name="region_end">
                                        <?php echo $region_end;?>
                                    </select>
                                </div>
                                
                                <label class="search-label">City</label>
                                <div class="search-select">
                                    <select name="city_end">
                                        <?php echo $city_end;?>
                                    </select>
                                </div>
                                
                                <label class="search-label">Location</label>
                                <div class="search-select">
                                    <select name="adress_end">
                                        <?php echo $adress_end;?>
                                    </select>
                                </div>
                                <label class="search-label">Date</label>    
                                <input type="text" name="end-date" id="end-date" class="input-login" value="<?php echo date("m/d/Y H:iA");?>"/>
                                
                                <label class="search-label">No. Pieces</label>
                                <input type="range" name="nr_bucati" class="input-login" value="1" min="1" max="<?php echo $scooter['nr_bucati'] - $scooter['nr_bucati_inchiriate'];?>" step="1" onchange="showPieces(this);" style="width: 140px;"/><input type="text" id="pieces" size="2" value="1" readonly="readonly"/>
                                <input type="hidden" name="pret_inchiriere" value="<?php echo $scooter['pret_inchiriere']; ?>"/>
                                <input type="hidden" name="nr_bucati_inchiriate" value="<?php echo $scooter['nr_bucati_inchiriate']; ?>"/>
                            </form>
                        </div>
                        <div id="rent-description">
                            <nav>
                                <a onclick="RentNavigatorDescription(1,this)" class="current-item">Scooter Description</a>
                                <a onclick="RentNavigatorDescription(2,this)">View Map</a>
                                <a onclick="RentNavigatorDescription(3,this)">Rental Conditions</a> 
                            </nav>
                            <div id="scooter-desc">                                    
                                  <p id="container-description">
                                     <?php echo $scooter['descriere']; ?>   
                                  </p> 
                                  <h2>Specification</h2>
                                  <p id="container-description">
                                    <?php echo $scooter['caracteristici']; ?>   
                                  </p> 
                            </div>
                            <div id="view-map">
                                <div id="control">
                                  <strong>Start:</strong>
                                  <input type="text" id="start" name="start" value="" readonly="readonly"/>
                                  <strong>End:</strong>
                                  <select id="end" onchange="calcRoute();">
                                        <?php echo $adress_end;?>
                                  </select>
                                </div>
                                <div id="directions-panel"></div>
                                <div id="map-canvas" style="height: 500px;"></div>
                            </div>
                            <div id="rental-cond">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.
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
