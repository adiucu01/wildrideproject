<?php

class AdminController {

    private $view = 'application/admin/views/';
    public $_secure = false;

    public function indexAction() {
        $model = new AdminModelDefault();
        if ($model->isValidUser() && $model->is_logged())
            require($this->view . 'default.php');
        else
            require($this->view . 'login.php');
    }

    public function signinAction() {
        $param = $_POST;
        $param['session_id'] = session_id();

        $model = new AdminModelSignIn();
        $res = $model->SignIn($param);

        if ($model->SignIn($param)) {
            WSystem::redirect("admin");
        } else {
            require($this->view . 'login.php');
        }
    }

    public function adminTableAction() {
        $model = new AdminModelDefault();
        if ($model->isValidUser() && $model->is_logged())
            require($this->view . 'admin.php');
        else
            require($this->view . 'login.php');
    }

    public function adminTableCRUDAction() {
        $model = new AdminModelDefault();
        $request = new Request();
        $action = $request->getParam("do");

        if (!$model->isValidUser() || !$model->is_logged())
            require($this->view . 'login.php');
        else {
            try {
                switch ($action) {
                    case 'list' :
                        $recordCount = $model->getNumberOfAdmins();
                        // $result = mysql_query("SELECT admin.id, admin.nume , admin.prenume, admin.email, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id;");

                        $sort = $request->getParam("jtSorting");
                        $startIndex = $request->getParam("jtStartIndex");
                        $pageSize = $request->getParam("jtPageSize");

                        if ($sort == null)
                            $sort = "nume ASC";
                        if ($startIndex == null)
                            $startIndex = 0;
                        if ($pageSize == null)
                            $pageSize = 10;

                        $rows = $model->getAdminList1($sort, $startIndex, $pageSize);

                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['TotalRecordCount'] = $recordCount;
                        $jTableResult['Records'] = $rows;
                        print json_encode($jTableResult);
                        break;
                    case 'create' :
                        $result = $model->addAdmin($_POST["nume"], $_POST["prenume"], $_POST["email"], $_POST["punct_de_lucru"], $_POST["tip_utilizator"], $_POST["parola"]);
                        $recordCount = $model->getNumberOfAdmins();
                        // $result = mysql_query("SELECT admin.id, admin.nume , admin.prenume, admin.email, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id;");
                        $sort = $request->getParam("jtSorting");
                        $startIndex = $request->getParam("jtStartIndex");
                        $pageSize = $request->getParam("jtPageSize");
                        if ($sort == null)
                            $sort = "nume ASC";
                        if ($startIndex == null)
                            $startIndex = 0;
                        if ($pageSize == null)
                            $pageSize = 10;
                        //$rows = $model->getAdminList1($sort, $startIndex, $pageSize);

                        $row = $model->getLastAdmin();

                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['Record'] = $row;
                        //$jTableResult['Records'] = $rows;
                        print json_encode($jTableResult);
                        break;
                    case 'update' :
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
                        break;
                    case 'delete' :
                        $id = $request->getParam('id');
                        $result = $model->deleteUser($id);
                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        print json_encode($jTableResult);
                        break;
                }
            } catch (Exception $ex) {
                //Return error message
                $jTableResult = array();
                $jTableResult['Result'] = "ERROR";
                $jTableResult['Message'] = $ex->getMessage();
                print json_encode($jTableResult);
            }
        }
    }

    public function workpointAction() {
        $model = new AdminModelDefault();
        if ($model->isValidUser() && $model->is_logged())
            require($this->view . 'workpoint.php');
        else
            require($this->view . 'login.php');
    }

    public function workpointCRUDAction() {
        $model = new AdminModelDefault();
        $request = new Request();
        $action = $request->getParam("do");

        if (!$model->isValidUser() || !$model->is_logged())
            require($this->view . 'login.php');
        else {
            try {
                switch ($action) {
                    case 'list' :
                        $recordCount = $model->getNumberOfWorkpoints();
                        $sort = $request->getParam("jtSorting");
                        $startIndex = $request->getParam("jtStartIndex");
                        $pageSize = $request->getParam("jtPageSize");

                        if ($sort == null)
                            $sort = "nume ASC";
                        if ($startIndex == null)
                            $startIndex = 0;
                        if ($pageSize == null)
                            $pageSize = 10;


                        $rows = $model->getWorkingpointsList1($sort, $startIndex, $pageSize);
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['TotalRecordCount'] = $recordCount;
                        $jTableResult['Records'] = $rows;
                        print json_encode($jTableResult);
                        break;
                    case 'create' :
                        $nume = $request->getParam('nume');
                        $adresa = $request->getParam('adresa');
                        $oras = $request->getParam('oras');
                        $judet = $request->getParam('judet');
                        $model->addWorkpoint($nume, $adresa, $oras, $judet);
                        
                        $row = $model->getLastWorkpoint();

                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['Record'] = $row;
                        print json_encode($jTableResult);

                        break;
                    case 'update' :

                        $nume = $request->getParam('nume');
                        $adresa = $request->getParam('adresa');
                        $oras = $request->getParam('oras');
                        $judet = $request->getParam('judet');
                        $id = $request->getParam('id');

                        //Update record in database
                        // $result = mysql_query("UPDATE people SET Name = '" . $_POST["Name"] . "', Age = " . $_POST["Age"] . " WHERE PersonId = " . $_POST["PersonId"] . ";");
                        $result = $model->updateWorkpoint($id, $nume, $oras, $judet, $adresa);
                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        print json_encode($jTableResult);
                        break;
                    case 'delete' :
                        $id = $request->getParam('id');
                        $result = $model->deleteWorkpoint($id);
                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        print json_encode($jTableResult);
                        break;
                }
            } catch (Exception $ex) {
                //Return error message
                $jTableResult = array();
                $jTableResult['Result'] = "ERROR";
                $jTableResult['Message'] = $ex->getMessage();
                print json_encode($jTableResult);
            }
        }
    }

    public function scooterAction() {
        $model = new AdminModelDefault();
        if ($model->isValidUser() && $model->is_logged())
            require($this->view . 'scooter.php');
        else
            require($this->view . 'login.php');
    }

    public function reportsAction() {
        $model = new AdminModelDefault();
        if ($model->isValidUser() && $model->is_logged())
            require($this->view . 'reports.php');
        else
            require($this->view . 'login.php');
    }

}
