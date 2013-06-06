<?php require_once("/../models/default.php"); $model = new AdminModelDefault(); if(!$model->isValidUser()) die();?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>WildRide | Adrian Mihaila & Saveluc Diana & Unknown</title>
        <link rel="stylesheet" type="text/css" href="../../../css/main.css" />     
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script type="text/javascript"> 
            $(document).ready(function() {
                $("#selection_type").hide();
                $("#preselection_type").hide();
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
            function sendForm(){
                var oOutput = document.getElementById("columns_list_p");
                var oOutputMessage = document.getElementById("outputMessage");
                
                var oData = new FormData(document.forms.namedItem("fileinfo"));
                
                var importType = document.getElementById("import_type").value;
                
                oData.append("CustomField", "This is some extra data");
                
                var oReq = new XMLHttpRequest();
                oReq.open("POST", "../controllers/scooter.php?action=import&type=processing", true);
                oReq.onload = function(oEvent) {
                    if (oReq.status == 200) {
                         oOutput.innerHTML = oReq.responseText;
                         oOutputMessage.innerHTML = "Uploaded!!";
                         if(importType==1){
                            $("#selection_type").hide();
                            $("#preselection_type").show();
                         }else if(importType==2){
                            $("#preselection_type").hide();
                            $("#selection_type").show();
                         }else if(importType==-1){
                            document.getElementsByClassName("error").innerHTML = "Please specify an Import Type";
                         }
                    } else {
                        oOutputMessage.innerHTML = "Error " + oReq.status + " occurred uploading your file.<br \/>";
                    }
               };
               oReq.send(oData);
            } 
            function selImportType(importType){
                if(importType==1){
                    $("#selection_type").hide();
                    $("#preselection_type").show();
                }else{
                    $("#preselection_type").hide();
                    $("#selection_type").show();
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
                    <form action="../controllers/scooter.php?action=import&type=submit" method="POST" enctype="multipart/form-data" name="fileinfo">
                        <label class="row-head">
                        File Type
                        </label>
                        
                        <select name="file_type">
                            <option value="csv">csv</option>
                            <option value="xls">xls</option>
                            <option value="xlsx">xlsx</option>
                        </select>
                        
                        <label class="row-head">
                        Import Type
                        </label>
                        
                        <select name="import_type" id="import_type" onchange="if(document.getElementById('file').value!='') selImportType(this.value);">
                            <option value="1">Custom Pre-Selection</option>
                            <option value="2">Custom Selection</option> 
                        </select>
                        
                        <label class="row-head">
                            Import File:
                        </label>
                        
                        <input type="file" name="file" id="file" onchange="sendForm();">
                        <div id="outputMessage"></div>
                        
                        <label class="row-head">
                            Punct lucru:
                        </label>
                        
                        <select name="punct_de_lucru" class="input-login">
                             <?php echo $workpoints = $model->getWorkpoints(null); ?>
                        </select>
                        <div id="selection_type">
                            <label class="row-head">
                            Select Column
                            </label>
                            <input type="text" name="columns_list_s"/>
                        </div>
                        
                        <div id="preselection_type">
                            <label class="row-head">
                            Select Columns
                            </label>
                            
                            <select name="columns_list_p[]" id="columns_list_p" multiple="multiple">
                                
                            </select>
                        </div>                        
                        
                        <input type="submit" value="Import" class="input-login"/> 
                    </div>
                </form>
            </section>
            <div id="container"><?php //$model->search(); ?></div>            
        </div>           
    </body>
</html>
