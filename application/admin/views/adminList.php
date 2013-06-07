<?php

//require '../models/AdminModelDefault.php';
$model = new AdminModelDefault();
if (!$model->isValidUser())
    die();
try {
    //Open database connection
    //Getting records (listAction)
    if ($_GET["action"] == "list") {
        //Get record count

        $recordCount = $model->getNumberOfAdmins();
        // $result = mysql_query("SELECT admin.id, admin.nume , admin.prenume, admin.email, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id;");
        $sort = $_GET["jtSorting"];
        $startIndex = $_GET["jtStartIndex"];
        $pageSize = $_GET["jtPageSize"];
        if ($sort == null)
            $sort = "nume ASC";
        if ($startIndex == null)
            $startIndex = 1;
        if ($pageSize == null)
            $pageSize = 10;
        $rows = $model->getAdminList1($sort, $startIndex, $pageSize);

        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['TotalRecordCount'] = $recordCount;
        $jTableResult['Records'] = $rows;
        print json_encode($jTableResult);
    }
    //Creating a new record (createAction)
    else if ($_GET["action"] == "create") {
        //Insert record into database
        //  $result = mysql_query("INSERT INTO admin(nume, prenume) VALUES('" . $_POST["nume"] . "', " . $_POST["prenume"] .");");
        $result = $model->addAdmin($_POST["nume"], $_POST["prenume"], $_POST["email"], $_POST["punct_de_lucru"], $_POST["tip_utilizator"], $_POST["parola"]);
        $recordCount = $model->getNumberOfAdmins();
        // $result = mysql_query("SELECT admin.id, admin.nume , admin.prenume, admin.email, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id;");
        $sort = $_GET["jtSorting"];
        $startIndex = $_GET["jtStartIndex"];
        $pageSize = $_GET["jtPageSize"];
        if ($sort == null)
            $sort = "nume ASC";
        if ($startIndex == null)
            $startIndex = 1;
        if ($pageSize == null)
            $pageSize = 10;
        $rows = $model->getAdminList1($sort, $startIndex, $pageSize);

        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['TotalRecordCount'] = $recordCount;
        $jTableResult['Records'] = $rows;
        print json_encode($jTableResult);
    }

    //Updating a record (updateAction)
    else if ($_GET["action"] == "update") {

        $nume = $_POST["nume"];
        $prenume = $_POST["prenume"];
        $email = $_POST["email"];
        $punctlucru = $_POST["punct_de_lucru"];
        $tiputilizator = $_POST["tip_utilizator"];
        $id = $_POST["id"];
        //Update record in database
        // $result = mysql_query("UPDATE people SET Name = '" . $_POST["Name"] . "', Age = " . $_POST["Age"] . " WHERE PersonId = " . $_POST["PersonId"] . ";");
        $result = $model->updateUser($nume, $prenume, $email, $punctlucru, $tiputilizator, $id);
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode($jTableResult);
    }
    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete") {

        $result = $model->deleteUser($_POST["id"]);
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode($jTableResult);
    }

    //Close database connection
    mysql_close($con);
} catch (Exception $ex) {
    //Return error message
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}
?>
