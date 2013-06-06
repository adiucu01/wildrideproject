<?php
//require_once("/../models/default.php");
$model = new AdminModelDefault();
if (!$model->isValidUser())
    WSystem::redirect("admin","signin");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian Mihaila & Saveluc Diana & Unknown</title>
        <link rel="stylesheet" type="text/css" href="/css/main.css" />

    </head>
    <body> 
        <div id="content">
            <header>
                <section id="header-left">
                    <h1>Bine ai venit, <?php
                        $result = $model->getUser(null);
                        echo $result['nume'] . " " . $result['prenume'];
                        ?>!</h1>
                </section>
                <nav>
<?php echo $nav = $model->createMenu($result['tip_admin']); ?>
                </nav>
                <section id="header-right">
                    <input type="button" value="Logout" onclick="Logout()" class="input-logout"/>
                </section>
            </header>
            <div id="container"><?php //$model->search();    ?></div>            
        </div>
        <script type="text/javascript">
                        function Logout() {
                            deleteCookie('user_id');
                            deleteCookie('user_session_id');
                            window.location.href = "login.php";
                        }
                        function deleteCookie(name) {
                            var date = new Date();
                            date.setTime(date.getTime() + (-1 * 24 * 60 * 60 * 1000));
                            var expires = " expires=" + date.toGMTString();
                            document.cookie = name + "=;" + expires + "; path=/";
                        }
        </script> 
    </body>
</html>
