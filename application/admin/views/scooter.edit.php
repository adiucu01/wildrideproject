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
                <?php $scooter = $model->getScooter($_GET['id']);?>
                <div id="content-log">
                    <form action="../controllers/scooter.php?action=edit&type=submit" method="POST">
                        <label class="row-head">
                           Denumire:
                        </label>
                        
                        <input type="text" name="denumire" id="denumire" class="input-login" value="<?php echo $scooter['denumire'];?>"/>
                        
                        <label class="row-head">
                            Caracteristici:
                        </label>
                        
                        <textarea name="caracteristici" id="caracteristici" cols="15" rows="4" class="input-login"><?php echo $scooter['caracteristici'];?></textarea>
                        
                        <label class="row-head">
                            Pret inchiriere:
                        </label>
                        
                        <input type="text" name="pret_inchiriere" id="pret_inchiriere" class="input-login" value="<?php echo $scooter['pret_inchiriere'];?>"/>
                        
                        <label class="row-head">
                            Punct lucru:
                        </label>
                        
                        <select name="punct_de_lucru" class="input-login">
                             <?php echo $workpoints = $model->getWorkpoints($scooter['id_punct_de_lucru']); ?>
                        </select>
                        
                         <input type="hidden" name="id" id="id" class="input-login" value="<?php echo $scooter['id']; ?>"/>
                        
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
