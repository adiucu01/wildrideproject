<?php
    $model = new AdminModelDefault();
    if (!$model->isValidUser())
        die();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="<?= WSystem::$url ?>assets/css/main.css" />
        <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAPDUET0Qt7p2VcSk6JNU1sBSM5jMcmVqUpI7aqV44cW1cEECiThQYkcZUPRJn9vy_TWxWvuLoOfSFBw" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/epoly.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/elabel.js" type="text/javascript"></script>
    </head>
    <body onunload="GUnload()">

        <div class="content">
            <header>
                <section id="admin-header-left">
                    <h1>Bine ai venit, <?php
                            $result = $model->getUser(null);
                            echo $result['nume'] . " " . $result['prenume'];
                        ?>!</h1>
                    <input type="button" value="Logout" onclick="Logout()" class="input-logout"/>
                </section>
                <nav id="admin-header-navigation">
                    <?php echo $nav = $model->createMenu($result['tip_admin']); ?>
                </nav>

            </header>

            <div id="container" style="width: 980px;margin:0 auto;">
                <div id="controls">
                    <form onsubmit="start();return false;" action="#">
                        Enter start and end addresses.<br />
                        <input type="text" size="80" maxlength="200" id="startpoint" value="Copou, Iasi, Romania, RO" /><br />
                        <input type="text" size="80" maxlength="200" id="endpoint" value="Pacurari, Iasi, Romania, RO" /><br />
                        <input type="submit" value="Start"  />
                    </form>
                </div>

                <div id="map" style="width: 700px; height: 500px"></div>
                <div id="step">&nbsp;</div>
                <div id="distance">Miles: 0.00</div>

                <canvas id="testcanvas" width="1" height="1"></canvas>
            </div>            

        </div>

        <script type="text/javascript">
            //<![CDATA[
            if (GBrowserIsCompatible()) {

                var map = new GMap2(document.getElementById("map"));
                map.addControl(new GMapTypeControl());
                map.setCenter(new GLatLng(0, 0), 2);
                var dirn = new GDirections();
                var step = 5; // metres
                var tick = 100; // milliseconds
                var poly;
                var eol;
                var car = new GIcon();
                car.image = "<?= WSystem::$url ?>img/scootericon.png";
                car.iconSize = new GSize(32, 18);
                car.iconAnchor = new GPoint(16, 9);
                var marker;
                var k = 0;
                var stepnum = 0;
                var speed = "";
                var img = new Image();
                img.src = "<?= WSystem::$url ?>img/scootericonl.png";
                var angle;
                var canvas;
                var lastVertex = 0;


                // ===== Check to see if this browser claims to support <canvas> ===
                if (document.getElementById('testcanvas').getContext) {
                    var supportsCanvas = true;
                } else {
                    var supportsCanvas = false;
                }

                // Returns the bearing in radians between two points.
                function bearing(from, to) {
                    // See T. Vincenty, Survey Review, 23, No 176, p 88-93,1975.
                    // Convert to radians.
                    var lat1 = from.latRadians();
                    var lon1 = from.lngRadians();
                    var lat2 = to.latRadians();
                    var lon2 = to.lngRadians();

                    // Compute the angle.
                    var angle = -Math.atan2(Math.sin(lon1 - lon2) * Math.cos(lat2), Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(lon1 - lon2));
                    if (angle < 0.0)
                        angle += Math.PI * 2.0;


                    if (angle === 0) {
                        crash;
                    }


                    return angle;
                }





                function plotcar() {
                    var cosa = Math.cos(angle);
                    var sina = Math.sin(angle);
                    canvas.clearRect(0, 0, 32, 32);
                    canvas.save();
                    canvas.rotate(angle);
                    canvas.translate(16 * sina + 16 * cosa, 16 * cosa - 16 * sina);
                    canvas.drawImage(img, -16, -16);
                    canvas.restore();
                }


                function animate(d) {
                    if (d > eol) {
                        document.getElementById("step").innerHTML = "<b>Trip completed<\/b>";
                        document.getElementById("distance").innerHTML = "Miles: " + (d / 1609.344).toFixed(2);
                        return;
                    }
                    var p = poly.GetPointAtDistance(d);
                    if (k++ >= 180 / step) {
                        map.panTo(p);
                        k = 0;
                    }
                    marker.setPoint(p);
                    document.getElementById("distance").innerHTML = "Miles: " + (d / 1609.344).toFixed(2) + speed;
                    if (stepnum + 1 < dirn.getRoute(0).getNumSteps()) {
                        if (dirn.getRoute(0).getStep(stepnum).getPolylineIndex() < poly.GetIndexAtDistance(d)) {
                            stepnum++;
                            var steptext = dirn.getRoute(0).getStep(stepnum).getDescriptionHtml();
                            document.getElementById("step").innerHTML = "<b>Next:<\/b> " + steptext;
                            var stepdist = dirn.getRoute(0).getStep(stepnum - 1).getDistance().meters;
                            var steptime = dirn.getRoute(0).getStep(stepnum - 1).getDuration().seconds;
                            var stepspeed = ((stepdist / steptime) * 2.24).toFixed(0);
                            step = stepspeed / 2.5;
                            speed = "<br />Current speed: " + stepspeed + " mph";
                        }
                    } else {
                        if (dirn.getRoute(0).getStep(stepnum).getPolylineIndex() < poly.GetIndexAtDistance(d)) {
                            document.getElementById("step").innerHTML = "<b>Next: Arrive at your destination<\/b>";
                        }
                    }
                    if (supportsCanvas) {
                        if (poly.GetIndexAtDistance(d) > lastVertex) {
                            lastVertex = poly.GetIndexAtDistance(d);
                            if (lastVertex === poly.getVertexCount()) {
                                lastVertex -= 1;
                            }
                            while (poly.getVertex(lastVertex - 1).equals(poly.getVertex(lastVertex))) {
                                lastVertex -= 1;
                            }

                            angle = bearing(poly.getVertex(lastVertex - 1), poly.getVertex(lastVertex));
                            plotcar();
                        }
                    }

                    setTimeout("animate(" + (d + step) + ")", tick);
                }

                GEvent.addListener(dirn, "load", function() {
                        document.getElementById("controls").style.display = "none";
                        poly = dirn.getPolyline();
                        eol = poly.Distance();
                        map.setCenter(poly.getVertex(0), 17);
                        map.addOverlay(new GMarker(poly.getVertex(0), G_START_ICON));
                        map.addOverlay(new GMarker(poly.getVertex(poly.getVertexCount() - 1), G_END_ICON));
                        if (supportsCanvas) {
                            marker = new ELabel(poly.getVertex(0), '<canvas id="carcanvas" width="32" height="32"><\/canvas>', null, new GSize(-16, 16));
                            map.addOverlay(marker);
                            canvas = document.getElementById("carcanvas").getContext('2d');
                            var p0 = poly.getVertex(0);
                            var p1 = poly.getVertex(1);
                            angle = bearing(p0, p1);
                            plotcar();
                        } else {
                            marker = new GMarker(poly.getVertex(0), {icon: car});
                            map.addOverlay(marker);
                        }
                        var steptext = dirn.getRoute(0).getStep(stepnum).getDescriptionHtml();
                        document.getElementById("step").innerHTML = steptext;
                        setTimeout("animate(0)", 2000);  // Allow time for the initial map display
                });

                GEvent.addListener(dirn, "error", function() {
                        alert("Location(s) not recognised. Code: " + dirn.getStatus().code);
                });

                function start() {
                    var startpoint = document.getElementById("startpoint").value;
                    var endpoint = document.getElementById("endpoint").value;
                    dirn.loadFromWaypoints([startpoint, endpoint], {getPolyline: true, getSteps: true});
                }

            }

            // This Javascript is based on code provided by the
            // Community Church Javascript Team
            // http://www.bisphamchurch.org.uk/   
            // http://econym.org.uk/gmap/

            //]]>
        </script>

    </body>

</html>