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
    class RentController{
        private $request;
        private $view = 'application/user/views/';
        public $_secure = false;

        public function __construct() {
            $this->request = new Request();
        }
        public function viewAction() {    
            $param['id'] = $this->request->getParam('id');

            require($this->view.'rent.php');  
        }         
        public function rentAction()
        {
            $param = $_POST;
            $model = new UserModelRent();

            $param['id'] = $this->request->getParam('id');
            if($model->makeRent($param)){
                require($this->view.'default.php');        
            }
        }
    }

