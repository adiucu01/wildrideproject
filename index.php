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
    *   
    *   This work is licenced under a Creative Commons Licence 
    *   http://creativecommons.org/licences/by/3.0/ 
    *   http://creativecommons.org/licences/by/3.0/legalcode
    */

    session_start();
    require_once("./config/config.php");
    $paths = dirname(__FILE__) . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/admin/controllers/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/admin/models/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/admin/views/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/user/controllers/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/user/models/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/application/user/views/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/classes/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/config/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/libraries' . PATH_SEPARATOR .
    dirname(__FILE__) . '/libraries/PHPOffice/Classes/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/libraries/PHPOffice/Classes/PHPExcel/' . PATH_SEPARATOR .
    dirname(__FILE__) . '/plugins/';

    //set_include_path(get_include_path() . PATH_SEPARATOR . $paths); 
    set_include_path($paths);

    if (isset($_REQUEST["c"]) && $_REQUEST["c"]) {
        WSystem::$controller_name = $_REQUEST["c"];
    }
    if (isset($_REQUEST["a"]) && $_REQUEST["a"]) {
        WSystem::$action_name = $_REQUEST["a"];
    }

    function __autoload($class_name) {
        require_once $class_name . '.php';
    }

    WSystem::execute();   
