<?php

    /*
    require_once("../../../classes/WDB.php");
    require_once("../../../config/config.php");
    */

    class AdminModelDefault {

        protected static $db;

        public function __construct() {
            self::$db = WDB::get_instance();
        }

        public function addAdmin($nume, $prenume, $email, $punct_lucru, $parola, $admin) {
            $sqlid = "SELECT id FROM puncte_de_lucru WHERE nume = '{$punct_lucru}' ";
            $res = self::$db->query($sqlid);
            $idpunct = mysqli_fetch_assoc($res);
            $sqlidtip = "SELECT id FROM tip_utilizator WHERE nume = '{$admin}'";
            $res1 = self::$db->query($sqlidtip);
            $idtip = mysqli_fetch_assoc($res1);
            $password = $this->cryptp($parola);
            $sql = "INSERT INTO admin(nume, prenume, email, parola, id_punct_de_lucru, tip_admin)
            VALUES('{$nume}','{$prenume}','{$email}','{$password}','{$idpunct['id']}','{$idtip['id']}')";

            $result = self::$db->query($sql);

            return $result;
        }

        public function addWorkpoint($nume, $adresa, $oras, $judet) {

            $sql = "INSERT INTO puncte_de_lucru(nume, adresa,oras,judet)
            VALUES('{$nume}','{$adresa}','{$oras}','{$judet}')";

            $result = self::$db->query($sql);

            return $result;
        }

        public function addScooter($id, $denumire, $caracteristici, $pretinchiriere, $punctlucru, $nrbucati, $nrbucatiInchiriate) {

            $sql = "INSERT INTO trotinete(denumire, caracteristici,pret_inchiriere,tip_adaugare,id_punct_de_lucru,nr_bucati,nr_bucati_inchiriate)
            VALUES('{$denumire}','{$caracteristici}','{$pretinchiriere}','1','{$punctlucru}','{$nrbucati}','{$nrbucatiInchiriate}')";

            $result = self::$db->query($sql);

            return $result;
        }

        private function cryptp($password) {
            return base64_encode(md5($password . PRIVATE_KEY . $password));
        }

        public function getAdminList($limit) {
            $output = null;
            $sql = "SELECT admin.*, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id {$limit}";

            $result = self::$db->query($sql);



            $i = 1;
            while ($arr = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                <td><input type="checkbox" name="select[]" value="' . $arr['id'] . '"/></td>
                <td>' . $i . '</td>
                <td>' . $arr['nume'] . '</td>
                <td>' . $arr['prenume'] . '</td>
                <td>' . $arr['email'] . '</td>
                <td>' . $arr['punct_de_lucru'] . '</td>
                <td>' . $arr['tip_utilizator'] . '</td>
                <td><a href="../controllers/admin.php?action=edit&id=' . $arr['id'] . '" title="Edit Admin">Edit</a>|<a href="../controllers/admin.php?action=delete&id=' . $arr['id'] . '" title="Delete Admin" onclick="return confirm(\'Do you really want to delete?\');">Delete</a></td>
                </tr>';
                $i++;
            }

            return $output;
        }

        public function getAdminList1($sorting, $startIndex, $pageSize) {
            $output = null;
            $sql = "SELECT admin.id, admin.nume , admin.prenume, admin.email, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id ORDER BY " . $sorting . " LIMIT " . $startIndex . "," . $pageSize . ";";
            //$sql = "SELECT admin.id, admin.nume , admin.prenume, admin.email, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id ORDER BY " . $sorting . " LIMIT " . $startIndex . "," . $pageSize . ";";

            $result = self::$db->query($sql);

            $rows = array();
            while ($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }

            return $rows;
        }

        public function getLastAdmin() {
            $output = null;
            $sql = "SELECT * FROM admin WHERE admin.id = LAST_INSERT_ID();";

            $result = self::$db->query($sql);
            $row = mysqli_fetch_array($result);

            return $row;
        }

        public function getLastWorkpoint() {
            $output = null;
            $sql = "SELECT * FROM puncte_de_lucru p WHERE p.id = LAST_INSERT_ID();";

            $result = self::$db->query($sql);
            $row = mysqli_fetch_array($result);

            return $row;
        }

        public function getLastScooter() {
            $output = null;
            $sql = "SELECT * FROM trotinete p WHERE p.id = LAST_INSERT_ID();";

            $result = self::$db->query($sql);
            $row = mysqli_fetch_array($result);

            return $row;
        }

        public function getScootersList1($sorting, $startIndex, $pageSize) {
            $output = null;
            $sql = "SELECT id, denumire , caracteristici, pret_inchiriere, tip_adaugare,data_adaugare,nr_bucati,nr_bucati_inchiriate,id_punct_de_lucru  from trotinete ORDER BY " . $sorting . " LIMIT " . $startIndex . "," . $pageSize . ";";

            $result = self::$db->query($sql);

            $rows = array();
            while ($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }

            return $rows;
        }

        public function getWorkingpointsList1($sorting, $startIndex, $pageSize) {
            $output = null;
            $sql = "SELECT id,nume,oras,judet,adresa from puncte_de_lucru ORDER BY " . $sorting . " LIMIT " . $startIndex . "," . $pageSize . ";";

            $result = self::$db->query($sql);

            $rows = array();
            while ($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }

            return $rows;
        }

        public function getWorkpointList($limit) {
            $output = null;
            $sql = "SELECT * FROM puncte_de_lucru {$limit}";

            $result = self::$db->query($sql);
            $i = 1;
            while ($arr = mysqli_fetch_assoc($result)) {
                $output .= '<tr>
                <td><input type="checkbox" name="select[]" value="' . $arr['id'] . '"/></td>
                <td>' . $i . '</td>
                <td>' . $arr['nume'] . '</td>
                <td>' . $arr['adresa'] . '</td>
                <td><a href="../controllers/workpoint.php?action=edit&id=' . $arr['id'] . '" title="Edit Workpoint">Edit</a>|<a href="../controllers/workpoint.php?action=delete&id=' . $arr['id'] . '" title="Delete Workpoint" onclick="return confirm(\'Do you really want to delete?\');">Delete</a></td>
                </tr>';
                $i++;
            }

            return $output;
        }

        public function getWorkpointsJSON() {
            $sql = "SELECT nume FROM puncte_de_lucru ";
            $result = self::$db->query($sql);
            $rows = array();
            while ($arr = mysqli_fetch_assoc($result)) {
                $rows[] = $arr['nume'];
            }

            return json_encode($rows);
        }
        public function getTipUtilizatorJSON() {
            $sql = "SELECT nume FROM tip_utilizator ";
            $result = self::$db->query($sql);
            $rows = array();
            while ($arr = mysqli_fetch_assoc($result)) {
                $rows[] = $arr['nume'];
            }

            return json_encode($rows);
        }

        public function updateUser($nume, $prenume, $email, $punctlucru, $tiputilizator, $id) {
            $sqlid = "SELECT id FROM puncte_de_lucru WHERE nume = '{$punctlucru}' ";
            $res = self::$db->query($sqlid);
            $idpunct = mysqli_fetch_assoc($res);
            $sqlidtip = "SELECT id FROM tip_utilizator WHERE nume = '{$tiputilizator}'";
            $res1 = self::$db->query($sqlidtip);
            $idtip = mysqli_fetch_assoc($res1);
            $sql = "UPDATE admin
            SET nume='{$nume}', prenume='{$prenume}', email='{$email}', id_punct_de_lucru= '{$idpunct['id']}', tip_admin= '{$idtip['id']}'
            WHERE id={$id};";

            $result = self::$db->query($sql);

            return $result;
        }

        public function updateWorkpoint($id, $nume, $oras, $judet, $adresa) {

            $sql = "UPDATE puncte_de_lucru
            SET nume='{$nume}', oras='{$oras}', judet='{$judet}', adresa= '{$adresa}'
            WHERE id={$id};";

            $result = self::$db->query($sql);

            return $result;
        }

        public function updateScooter($id, $denumire, $caracteristici, $pretinchiriere, $punctlucru, $nrbucati, $nrbucatiInchiriate) {

            $sql = "UPDATE trotinete
            SET denumire='{$denumire}', caracteristici='{$caracteristici}', pret_inchiriere='{$pretinchiriere}', tip_adaugare='1', id_punct_de_lucru= '{$punctlucru}', nr_bucati='{$nrbucati}', nr_bucati_inchiriate= '{$nrbucatiInchiriate}'
            WHERE id={$id};";

            $result = self::$db->query($sql);

            return $result;
        }

        public function deleteUser($id) {
            $sql = "DELETE FROM admin
            WHERE id = {$id}";

            $result = self::$db->query($sql);

            return $result;
        }

        public function deleteScooter($id) {
            $sql = "DELETE FROM trotinete
            WHERE id = {$id}";

            $result = self::$db->query($sql);

            return $result;
        }

        public function deleteWorkpoint($id) {
            $sql = "DELETE FROM puncte_de_lucru
            WHERE id = {$id}";

            $result = self::$db->query($sql);

            return $result;
        }

        /*
        public function getScooterList($limit) {
        $output = null;
        $sql = "SELECT trotinete.*, puncte_de_lucru.nume as punct_de_lucru, tip_adaugare_trotinete.nume as mod_adaugare FROM trotinete LEFT JOIN puncte_de_lucru ON trotinete.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_adaugare_trotinete on trotinete.tip_adaugare = tip_adaugare_trotinete.id {$limit}";

        $result = self::$db->query($sql);
        $i = 1;
        while ($arr = mysqli_fetch_assoc($result)) {
        $output .= '<tr>
        <td><input type="checkbox" name="select[]" value="' . $arr['id'] . '"/></td>
        <td>' . $i . '</td>
        <td>' . $arr['denumire'] . '</td>
        <td>' . $arr['caracteristici'] . '</td>
        <td>' . $arr['pret_inchiriere'] . '</td>
        <td>' . $arr['mod_adaugare'] . '</td>
        <td>' . $arr['punct_de_lucru'] . '</td>
        <td>' . $arr['data_adaugare'] . '</td>
        <td><a href="../controllers/scooter.php?action=edit&id=' . $arr['id'] . '" title="Edit Scooter">Edit</a>|<a href="../controllers/scooter.php?action=delete&id=' . $arr['id'] . '" title="Delete Scooter" onclick="return confirm(\'Do you really want to delete?\');">Delete</a></td>
        </tr>';
        $i++;
        }

        return $output;
        }
        */
        public function getScooter($id) {

            $sql = "SELECT * FROM trotinete WHERE id=" . intval($id);


            $result = self::$db->query($sql);
            $arr = mysqli_fetch_assoc($result);

            return $arr;
        }

        public function getWorkpoint($id) {

            $sql = "SELECT * FROM puncte_de_lucru WHERE id=" . intval($id);


            $result = self::$db->query($sql);
            $arr = mysqli_fetch_assoc($result);

            return $arr;
        }

        public function getWorkpoints($id) {
            $output = null;
            $sql = "SELECT * FROM puncte_de_lucru";

            $result = self::$db->query($sql);
            while ($arr = mysqli_fetch_assoc($result)) {
                if (!empty($id) && ($id == $arr['id'])) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $output .= '<option value="' . $arr['id'] . '" ' . $selected . '>' . $arr['nume'] . '</option>';
            }

            return $output;
        }

        public function getAdminTypes($id) {
            $output = null;
            $sql = "SELECT * FROM tip_utilizator";

            $result = self::$db->query($sql);
            while ($arr = mysqli_fetch_assoc($result)) {
                if (!empty($id) && ($id == $arr['id'])) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $output .= '<option value="' . $arr['id'] . '" ' . $selected . '>' . $arr['nume'] . '</option>';
            }

            return $output;
        }

        public function isValidUser() {
            if (!isset($_COOKIE['user_id']) || $_COOKIE['user_id'] == "" ||
                !isset($_COOKIE['user_session_id']) || $_COOKIE['user_session_id'] == "")
                return false;
            $sql = "SELECT * FROM admin WHERE id=" . intval($_COOKIE['user_id']) . " and id_sesiune='{$_COOKIE['user_session_id']}'";

            $result = self::$db->query($sql);
            $arr = mysqli_fetch_assoc($result);

            if (is_array($arr)) {
                return true;
            } else {
                return false;
            }
        }

        public function createMenu($tip_utilizator) {
            $output = null;

            switch ($tip_utilizator) {

                // superadmin
                case "1":
                    $output = '<a href="' . WSystem::$url . 'admin/adminTable" title="Admins">Admins</a> 
                    <a href="' . WSystem::$url . 'admin/workpoint" title="Workpoints">Workpoints</a>
                    <a href="' . WSystem::$url . 'admin/reports" title="Reports">Reports</a>
                    <a href="' . WSystem::$url . 'admin/liveScooter" title="Live Scooter">Live Scooter</a>';
                    break;

                    // admin
                case "2":
                    $output = '<a href="' . WSystem::$url . 'admin/scooter" title="Scooters">Scooters</a> ';
                    break;

                    // utilizator
                case "3":
                    break;
            }
            return $output;
        }

        public function getUser($id) {
            if (empty($id)) {
                $sql = "SELECT * FROM admin WHERE id=" . intval($_COOKIE['user_id']);
            } else {
                $sql = "SELECT * FROM admin WHERE id=" . intval($id);
            }

            $result = self::$db->query($sql);
            $arr = mysqli_fetch_assoc($result);

            return $arr;
        }

        public function is_logged() {
            $sql = "SELECT id_sesiune FROM admin WHERE id=" . intval($_COOKIE['user_id']);

            $result = self::$db->query($sql);
            $arr = mysqli_fetch_assoc($result);

            if ($arr['id_sesiune'] == $_COOKIE['user_session_id'] && $arr != null) {
                return true;
            } else {
                return false;
            }
        }

        public function getNumberOfAdmins() {
            $sql = "SELECT admin.*, puncte_de_lucru.nume as punct_de_lucru, tip_utilizator.nume as tip_utilizator FROM admin LEFT JOIN puncte_de_lucru ON admin.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_utilizator on admin.tip_admin = tip_utilizator.id";

            $result = self::$db->query($sql);
            $rows = mysqli_num_rows($result);

            return $rows;
        }

        public function getNumberOfWorkpoints() {
            $sql = "SELECT * FROM puncte_de_lucru";

            $result = self::$db->query($sql);
            $rows = mysqli_num_rows($result);

            return $rows;
        }

        public function getNumberOfScooters() {
            $sql = "SELECT trotinete.*, puncte_de_lucru.nume as punct_de_lucru, tip_adaugare_trotinete.nume as mod_adaugare FROM trotinete LEFT JOIN puncte_de_lucru ON trotinete.id_punct_de_lucru = puncte_de_lucru.id LEFT JOIN tip_adaugare_trotinete on trotinete.tip_adaugare = tip_adaugare_trotinete.id";

            $result = self::$db->query($sql);
            $rows = mysqli_num_rows($result);

            return $rows;
        }

    }

?>
