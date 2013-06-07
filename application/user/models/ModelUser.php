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
    class ModelUser extends UserModelDefault{ 
        public function updateUser($param){  

            $sql = "UPDATE user SET nume='{$param['first_name']}', prenume='{$param['last_name']}', cnp='{$param['cnp']}', judet='{$param['judet']}', oras='{$param['oras']}', serie='{$param['serie']}', numar='{$param['numar']}' WHERE id = '{$param['id']}'";

            $result = self::$db->query($sql); 

            return true;
        }
        public function ChangeEmail($param){
            $sql = "UPDATE user SET email='{$param['new_email']}' WHERE id = '{$param['id']}'";

            $result = self::$db->query($sql); 

            return true;
        }
        public function ChangePassword($param){
            $password = $this->cryptp($param['new_password']);

            $sql = "UPDATE user SET parola='{$password}' WHERE id = '{$param['id']}'";

            $result = self::$db->query($sql); 

            return true;
        }
        private function cryptp($password){ 
            return  base64_encode(md5($password.PRIVATE_KEY.$password));
        }
    }  
?>
