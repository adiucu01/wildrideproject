<?php
//require_once("/../models/default.php");
$model = new AdminModelDefault();
if (!$model->isValidUser())
    die();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian Mihaila & Saveluc Diana & Unknown</title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <link rel="stylesheet" type="text/css" href="<?= WSystem::$url ?>assets/css/main.css" /> 
        <link rel="stylesheet" href="<?= WSystem::$url ?>assets/css/datepicker_bootstrap.css" > 
        <link rel="stylesheet" type="text/css" media="all" href="<?= WSystem::$url ?>assets/css/jquery.hoverscroll.css" />

        <script type="text/javascript" src="<?= WSystem::$url ?>assets/js/jquery-1.9.1.min.js"></script> 
        <script src="<?= WSystem::$url ?>assets/js/mootools-core.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/mootools-more.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/Locale.en-US.DatePicker.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/Picker.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/Picker.Attach.js" type="text/javascript"></script>
        <script src="<?= WSystem::$url ?>assets/js/Picker.Date.js" type="text/javascript"></script>  
        <script type="text/javascript" src="<?= WSystem::$url ?>assets/js/jquery.hoverscroll.js"></script> 




        <script type="text/javascript">
            var ch = 0;
            function Logout() {
                deleteCookie('user_id');
                deleteCookie('user_session_id');
                window.location.href = "<?= WSystem::$url ?>/admin";
            }
            function deleteCookie(name) {
                var date = new Date();
                date.setTime(date.getTime() + (-1 * 24 * 60 * 60 * 1000));
                var expires = " expires=" + date.toGMTString();
                document.cookie = name + "=;" + expires + "; path=/";
            }
            function checkAll(checktoggle)
            {
                var checkboxes = new Array();
                checkboxes = document.getElementsByName('select[]');
                if (ch === 1) {
                    checktoggle = false;
                    ch = 0;
                }
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type === 'checkbox') {
                        checkboxes[i].checked = checktoggle;
                    }
                }
                ch++;
                if (!checktoggle)
                    ch = 0;
            }
            function submitDeleteAll() {
                if (confirm('Do you really want to delete?')) {
                    document.getElementById('delete_all').submit();
                }
            }
            function goToPage() {
                var pagenum = document.getElementById("pagenum").value;
                window.location = document.URL + "?pagenum=" + pagenum;
            }



            $(document).ready(function() {


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
            });

        </script> 
    </head>

    <body> 


        <header>
            <div class="content">
                <div id="logo">
                    <a href="default.php" title="WildRide"><img src="<?= WSystem::$url ?>img/logo.png" alt="WildRide"/></a>
                </div>

                <div id="navigator">
                    <p>Bine ai venit, <?php
                        $result = $model->getUser(null);
                        echo $result['nume'] . " " . $result['prenume'];
                        ?>!<input type="button" value="Logout" onclick="Logout()" class="input-logout"/></p>

                    <nav>
                        <?php echo $nav = $model->createMenu($result['tip_admin']); ?>
                    </nav>
                </div>

            </div>
        </header>
        <div>
            <form action="<?= WSystem::$url ?>admin/raportTrotinete" method="get">
                <input type="submit" value="Genereaza rapoarte trotinete!">
            </form>
            <form action="<?= WSystem::$url ?>admin/raportInchirieriZile" method="POST">
                <p>Genereaza raport starea inchirierilor pe zile si ore</p>
                <label class="search-label">Start Date</label>  
                <input type="text" name="start-date" id="start-date" value="<?php echo date("m/d/Y H:iA"); ?>"/>
                </br>                             
                <label class="search-label">End Date</label>
                <input type="text" name="end-date" id="end-date" value="<?php echo date("m/d/Y H:iA"); ?>"/>
                </br>         
                <label class="search-label"></label>
                <input type="submit" value="Generate report"/>

            </form>
        </div>



    </body>

</html>
