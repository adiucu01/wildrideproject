<?php 
//require_once("/../models/default.php"); 
$model = new AdminModelDefault(); if(!$model->isValidUser()) die();?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian Mihaila & Saveluc Diana & Unknown</title>
        <link rel="stylesheet" type="text/css" href="../../../css/main.css" />     
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script type="text/javascript">              
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
            function ConfirmPassword(){
                var pass = document.getElementById("password").value;
                var c_pass = document.getElementById("c_password").value;
                
                if(pass != c_pass){
                   alert('Please check the password!');
                   return false; 
                }
                else
                {
                    return true;
                }
            }
        </script> 
    </head>
    <body> 
        <div id="content">
            <header>
                <section id="header-left">
                    <h1>Bine ai venit, <?php $result = $model->getUser(null); echo $result['nume']." ".$result['prenume'];?>!</h1>
                </section>
                <nav>
                    <?php echo $nav = $model->createMenu($result['tip_admin']); ?>
                </nav>
                <section id="header-right">
                      <input type="button" value="Logout" onclick="Logout()" class="input-logout"/>
                </section>
            </header>
            <section>
                <div id="content-log">
                    <form action="../controllers/admin.php?action=add&type=submit" method="POST" onsubmit="return ConfirmPassword();">
                        <label class="row-head">
                        First Name:
                        </label>
                        
                        <input type="text" name="first_name" id="first_name" class="input-login" />
                        
                        <label class="row-head">
                            Last Name:
                        </label>
                        
                        <input type="text" name="last_name" id="last_name" class="input-login" />
                        
                        <label class="row-head">
                            Email:
                        </label>
                        
                        <input type="email" name="email" id="email" class="input-login"/>
                        
                        <label class="row-head">
                            Punct lucru:
                        </label>
                        
                        <select name="punct_lucru" class="input-login">
                             <?php echo $workpoints = $model->getWorkpoints(null); ?>
                        </select>
                        
                        <label class="row-head">
                            Password:
                        </label>
                        
                        <input type="password" name="password" id="password" class="input-login"/>
                        
                        <label class="row-head">
                            Confirm password:
                        </label>
                        
                        <input type="password" name="c_password" id="c_password" class="input-login"/>
                        
                        <input type="submit" value="Register" class="input-login"/> 
                    </div>
                </form>
            </section>
            <div id="container"><?php //$model->search(); ?></div>            
        </div>           
    </body>
</html>
