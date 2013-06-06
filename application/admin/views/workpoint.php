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
            var ch = 0;              
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
            function checkAll(checktoggle)
            {
              var checkboxes = new Array(); 
              checkboxes = document.getElementsByName('select[]');
              if(ch==1){
                 checktoggle = false;
                 ch = 0;  
              }
              for (var i=0; i<checkboxes.length; i++)  {
                if (checkboxes[i].type == 'checkbox')   {
                  checkboxes[i].checked = checktoggle;
                }
              }
              ch++;
              if(!checktoggle) ch = 0;
            }
            function submitDeleteAll(){
                if(confirm('Do you really want to delete?')){
                       document.getElementById('delete_all').submit();
                }
            }
            function goToPage(){
                var pagenum = document.getElementById("pagenum").value;
                window.location = document.URL + "?pagenum=" + pagenum;
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
                <nav>
                    <a href="../controllers/workpoint.php?action=add" title="Add New Workpoin">Add New Workpoint</a>
                    <a href="" title="Delete All" onclick="submitDeleteAll();">Delete All</a>
                </nav>
                <?php
                    if(isset($_GET['pagenum'])) $pagenum = $_GET['pagenum']; else $pagenum = null;
                     
                    if (!(isset($pagenum))){ $pagenum = 1; }
                     
                    $rows = $model->getNumberOfWorkpoints();
                    
                    $page_rows = 4;
                    $last = ceil($rows/$page_rows); 
                    
                    if ($pagenum < 1){ 
                        $pagenum = 1;
                    }elseif ($pagenum > $last){ 
                        $pagenum = $last; 
                    }      

                    $max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows; 
            
                ?>
                <form id="delete_all" action="../controllers/workpoint.php?action=delete&type=all" method="POST">
                <table border="1" >
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" onchange="checkAll(true);"/></th>
                            <th>ID</th>
                            <th>Nume</th>
                            <th>Adresa</th>
                            <th>Optiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $workpoints = $model->getWorkpointList($max);?>
                    </tbody>
                </table>
                </form>
            </section>
            <section>
             <?php  
                 echo "<p>--Page $pagenum of $last-- Go to "; 
                 echo '<input type="text" name="pagenum" id="pagenum" size="3"/> of '.$last.'<a href="javascript:goToPage();" > go </a></p>';

                 if($pagenum == 1){ 
                     
                 }else{
                    echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=1'> <<-First </a> ";

                    $previous = $pagenum-1;

                    echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'> <-Previous </a> ";
                  } 

                  echo " ---- ";
 
                  if ($pagenum == $last) {
                  }else{

                     $next = $pagenum+1;

                     echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next -></a> ";

                     echo " ";

                     echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Last ->></a> ";

                  } 

               ?>    
            </section>
            <div id="container"><?php //$model->search(); ?></div>            
        </div>           
    </body>
</html>
