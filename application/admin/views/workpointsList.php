<?php
 require_once("/../models/default.php"); $model = new AdminModelDefault(); if(!$model->isValidUser()) die();
try
{
    //Open database connection
     $con = mysql_connect("localhost","root","");
    mysql_select_db("db_womics", $con);

   //Getting records (listAction)
    if($_GET["action"] == "list")
    {
        //Get record count
      /*  $result = mysql_query("SELECT COUNT(*) AS RecordCount FROM admin;");
        $row = mysql_fetch_array($result);
        $recordCount = $row['RecordCount'];    */
       $recordCount= $model->getNumberOfWorkpoints();
        //Get records from database
       // $result = mysql_query("SELECT admin.id, admin.nume , admin.prenume, admin.email, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id;");
      $sort= $_GET["jtSorting"];
      $startIndex= $_GET["jtStartIndex"];
      $pageSize = $_GET["jtPageSize"];
       
       $rows=$model->getWorkingpointsList1($sort,$startIndex,$pageSize) ;
        //Add all records to an array
       /* $rows = array();
        while($row = mysql_fetch_array($result))
        {
            $rows[] = $row;
        }                    
        /*  $rows = array();
          $rows=model->getAdminList1();      */
        /*  $result = mysql_query("SELECT id,nume,adresa FROM puncte_de_lucru ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
        
        //Add all records to an array
        $rows = array();
        while($row = mysql_fetch_array($result))
        {
            $rows[] = $row;
        }         */
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['TotalRecordCount'] = $recordCount;
        $jTableResult['Records'] = $rows;
        print json_encode($jTableResult);
    }
    //Creating a new record (createAction)
     
    else if($_GET["action"] == "create")
    {
        //Insert record into database
       $result = mysql_query("INSERT INTO puncte_de_lucru(nume, oras,judet,adresa) VALUES('" . $_POST["nume"] . "', " . $_POST["oras"] .",'" . $_POST["judet"] . "','" . $_POST["adresa"] . "');");
        //  $result=$model->addWorkpoint($_POST["nume"],$_POST["adresa"],$_POST["oras"],$_POST["judet"]);
        //Get last inserted record (to return to jTable)
        $result = mysql_query("SELECT * FROM puncte_de_lucru WHERE id = LAST_INSERT_ID();");
        $row = mysql_fetch_array($result);

        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $row;
        print json_encode($jTableResult);
    }
    
    //Updating a record (updateAction)
    
    else if($_GET["action"] == "update")
    {     
        
        $nume=$_POST["nume"];
        $oras=$_POST["oras"];
        $judet=$_POST["judet"];
         $adresa=$_POST["adresa"];
        $id= $_POST["id"];
        //Update record in database
       // $result = mysql_query("UPDATE people SET Name = '" . $_POST["Name"] . "', Age = " . $_POST["Age"] . " WHERE PersonId = " . $_POST["PersonId"] . ";");
       $result=$model->updateWorkpoint($id,$nume,$oras,$judet,$adresa);
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode($jTableResult);
    }
    
    //Deleting a record (deleteAction)
    
    else if($_GET["action"] == "delete")
    {
      
         $result=$model->deleteWorkpoint($_POST["id"]) ;
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode($jTableResult);
    }
     
    //Close database connection
    mysql_close($con);  

}
catch(Exception $ex)
{
    //Return error message
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}
    
?>
