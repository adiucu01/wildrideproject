<?php require_once("/../models/default.php"); $model = new ModelDefault(); if(!$model->isValidUser()) die();?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian Mihaila & Saveluc Diana & Unknown</title>
        <link rel="stylesheet" type="text/css" href="../../../css/main.css" />     
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        
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
                    <form action="../controllers/workpoint.php?action=add&type=submit" method="POST">
                        <label class="row-head">
                           Punct de lucru:
                        </label>
                        
                        <input type="text" name="nume" id="nume" class="input-login" />
                        
                        <label class="row-head">
                            Adresa:
                        </label>
                        
                        <input type="text" name="adresa" id="adresa" class="input-login" />
                        
                        <label class="row-head"> 
                        </label>
                        
                        <input type="submit" value="Submit"/>                    
                    </form>
                </div>
            </section>
            <div id="container"><?php //$model->search(); ?></div>            
        </div>           
    </body>
</html>
