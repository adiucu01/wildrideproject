<?php
    /*
    *   WildRide - Scooter renting Copyright (C) 2013 Mihaila Adrian Nicolae
    *   WildRide is free software: you can redistribute it and/or modify
    *   it under the terms of the GNU General Public License as published by
    *   the Free Software Foundation, either version 3 of the License, or
    *   (at your option) any later version.

    *   WildRide is distributed in the hope that it will be useful,
    *   but WITHOUT ANY WARRANTY; without even the implied warranty of
    *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    *   GNU General Public License for more details.
    *
    *   You should have received a copy of the GNU General Public License
    *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */   
    class UserModelRent extends UserModelDefault{ 
        public function getScooter($id){                     

            $sql = "SELECT a.*, b.judet, b.oras, b.adresa FROM trotinete a, puncte_de_lucru b WHERE a.id_punct_de_lucru=b.id and a.id=".intval($id);

            $result = self::$db->query($sql);    
            $arr = mysqli_fetch_assoc($result);

            return $arr;
        }
        public function makeRent($param){
            $sql01 = "INSERT INTO contracte (id_utilizator, nr_bucati, pret_inchiriere, data_incheiere)
            VALUES('{$_COOKIE['user_id']}','{$param['nr_bucati']}','{$param['pret_inchiriere']}', NOW())";   

            $result01 = self::$db->query($sql01);

            $sql02 = "SELECT MAX(id) as id FROM contracte";

            $result02 = self::$db->query($sql02);    
            $arr = mysqli_fetch_assoc($result02);

            $total = $param['nr_bucati_inchiriate'] + $param['nr_bucati'];          
            $sql03 = "UPDATE trotinete SET nr_bucati_inchiriate='{$total}' WHERE id = '{$param['id']}'";

            $result03 = self::$db->query($sql03); 

            $sql04 = "INSERT INTO inchirieri(id_utilizator, id_trotineta, id_contract, locatie_start, locatie_finala, data_inchiriere, data_restituire)
            VALUES('{$_COOKIE['user_id']}','{$param['id']}','{$arr['id']}','{$param['location_start']}','{$param['adress_end']}','{$param['start-date']}','{$param['end-date']}')";   

            $result04 = self::$db->query($sql04);

            $sql05 = "SELECT denumire, caracteristici, descriere FROM trotinete WHERE id=".$param['id'];

            $result05 = self::$db->query($sql05);    
            $arr_scooter = mysqli_fetch_assoc($result05);
            $new_param = array_merge($param, $arr_scooter);

            $sql06 = "SELECT nume, prenume, email, cnp, judet, oras, serie, numar FROM user WHERE id=".$_COOKIE['user_id'];

            $result06 = self::$db->query($sql06);    
            $arr_user = mysqli_fetch_assoc($result06);
            $new_param01 = array_merge($new_param, $arr_user);

            $new_param01['customer']['nume'] = $new_param01['nume'];
            $new_param01['customer']['prenume'] = $new_param01['prenume'];
            $new_param01['customer']['message'] = '<p>
            <table>
            <thead>
            <tr>
            <th>Nr. crt.</th>
            <th>Denumire Produs</th>
            <th>U.M.</TH>
            <th>Pret unitar fara TVA</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>1</td>
            <td>'.$new_param01['denumire'].' - '.$new_param01['caracteristici'].'</td>
            <td>'.$new_param01['nr_bucati'].'</td>
            <td>'.$new_param01['pret_inchiriere'].'</td>
            </tr>
            </tbody>
            </table>
            </p>';
            $new_param01['subject'] = 'WildRide Order Invoice';

            $this->SendMail($new_param01);

            return $result04; 
        }
    }  
?>
