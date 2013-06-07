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
            require($this->view . 'scooters.php');
        else
            require($this->view . 'login.php');
    }

    public function scooterCRUDAction() {
        $model = new AdminModelDefault();
        $request = new Request();
        $action = $request->getParam("do");

        if (!$model->isValidUser() || !$model->is_logged())
            require($this->view . 'login.php');
        else {
            try {
                switch ($action) {
                    case 'list' :
                        $recordCount = $model->getNumberOfScooters();
                        $sort = $request->getParam("jtSorting");
                        $startIndex = $request->getParam("jtStartIndex");
                        $pageSize = $request->getParam("jtPageSize");

                        if ($sort == null)
                            $sort = "nume ASC";
                        if ($startIndex == null)
                            $startIndex = 0;
                        if ($pageSize == null)
                            $pageSize = 10;

                        $rows = $model->getScootersList1($sort, $startIndex, $pageSize);
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['TotalRecordCount'] = $recordCount;
                        $jTableResult['Records'] = $rows;
                        print json_encode($jTableResult);
                        break;
                    case 'create' :
                        $result = $model->addScooter($_POST["denumire"], $_POST["caracteristici"], $_POST["pret_inchiriere"], $_POST["id_punct_de_lucru"], $_POST["nr_bucati"], $_POST["nr_bucati_inchiriate"]);
                        //Get last inserted record (to return to jTable)

                        $row = $model->getLastScooter();

                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['Records'] = $row;
                        print json_encode($jTableResult);
                        break;
                    case 'update' :

                        $result = $model->updateScooter($_POST["id"], $_POST["denumire"], $_POST["caracteristici"], $_POST["pret_inchiriere"], $_POST["id_punct_de_lucru"], $_POST["nr_bucati"], $_POST["nr_bucati_inchiriate"]);
                        //Return result to jTable
                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        print json_encode($jTableResult);
                        break;
                    case 'delete' :
                        $id = $request->getParam('id');
                        $result = $model->deleteScooter($id);
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

    public function reportsAction() {
        $model = new AdminModelDefault();
        if ($model->isValidUser() && $model->is_logged())
            require($this->view . 'reports.php');
        else
            require($this->view . 'login.php');
    }

    public function raportTrotineteAction() {
        // Handle special IE contype request
        if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'contype') {
            header('Content-Type: application/pdf');
        }
        $model = new AdminModelScooter();
        $trotineteList = $model->getScooterList();

        //echo "<h1>User Comments</h1>";
        $denumiri = array();
        $descrieri = array();


        $count = count($trotineteList);
        for ($i = 0; $i < $count; $i++) {
            $denumiri[$i] = $trotineteList[$i]['denumire'];
            $descrieri[$i] = $trotineteList[$i]['caracteristici'];
        }

        $pdf = new PDF_result();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetY(100);
        $pdf->Cell(100, 13, "Stocul de trotinete");
        $pdf->SetFont('Arial', '');
        //$pdf->Cell(250, 13, $_POST['nume']);
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(50, 13, "Date:");
        $pdf->SetFont('Arial', '');
        $pdf->Cell(100, 13, date('F j, Y'), 0, 1);
        $pdf->SetFont('Arial', 'I');
        $pdf->SetX(140);
        $pdf->Cell(200, 15, "Data:acum", 0, 2);
        $pdf->Cell(200, 15, "Oras:Toate", 0, 2);
        $pdf->Cell(200, 15, "Trotinete:inchiriate sau nu", 0, 2);
        $pdf->Ln(100);
        $headers = ["Denumire", "Descriere"];

        $pdf->Generate_Table($denumiri, $descrieri, $headers);

        $pdf->Ln(50);
        $message = "Stocul de trotinete ";
        $pdf->MultiCell(0, 15, $message);
        $pdf->SetFont('Arial', 'U', 12);
        $pdf->SetTextColor(1, 162, 232);
        $pdf->Write(13, "adi@timelife.ro", "mailto:adi@timelife.ro");
        $pdf->Output();
    }

    public function raportInchirieriZileAction() {
        if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'contype') {
            header('Content-Type: application/pdf');
        }
        $model = new AdminModelRent();

        $rentList = $model->getRentList($_POST['start-date'], $_POST['end-date']);

        //echo "<h1>User Comments</h1>";
        $denumiri = array();
        $descrieri = array();


        $count = count($rentList);
        for ($i = 0; $i < $count; $i++) {
            $denumiri[$i] = $rentList[$i]['id_utilizator'];
            $descrieri[$i] = $rentList[$i]['id_trotineta'];
        }

        $pdf = new PDF_result();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetY(100);
        $pdf->Cell(100, 13, "Situatia inchirierilor pe zile si ore");
        $pdf->SetFont('Arial', '');
        //$pdf->Cell(250, 13, $_POST['name']);
        $pdf->SetFont('Arial', 'B');
        $pdf->Cell(50, 13, "Date:");
        $pdf->SetFont('Arial', '');
        $pdf->Cell(100, 13, date('F j, Y'), 0, 1);
        $pdf->SetFont('Arial', 'I');
        $pdf->SetX(140);
        $pdf->Cell(200, 15, "Data:acum", 0, 2);
        $pdf->Cell(200, 15, "Oras:Toate", 0, 2);
        $pdf->Cell(200, 15, "Trotinete:inchiriate sau nu", 0, 2);
        $pdf->Ln(100);

        $headers = ["Utilizator", "Trotineta"];

        $pdf->Generate_Table($denumiri, $descrieri, $headers);
        $pdf->Ln(50);
        $message = "Stocul de trotinete ";
        $pdf->MultiCell(0, 15, $message);
        $pdf->SetFont('Arial', 'U', 12);
        $pdf->SetTextColor(1, 162, 232);
        $pdf->Write(13, "diana@timelife.ro", "mailto:diana@timelife.ro");
        $pdf->Output();
    }

}
