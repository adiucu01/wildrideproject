<?php
    require("../models/scooter.php");
    require('/../../../libraries/PHPOffice/Classes/PHPExcel.php'); 
    require('/../../../libraries/PHPOffice/Classes/PHPExcel/IOFactory.php');
    $model = new AdminModelScooter();
    
    $param = $_POST;
    
    switch($_GET['action']){
        case "edit":
            if(isset($_GET['type'])){
                if($model->updateScooter($param)){
                   header( 'Location: ../views/scooter.php' ); 
                } 
            }else{
                header( 'Location: ../views/scooter.edit.php?id='.$_GET['id'] );
            }
        break;
        
        case "add":
            if(isset($_GET['type'])){
                if($model->addScooter($param)){
                   header( 'Location: ../views/scooter.php' ); 
                } 
            }else{
             header( 'Location: ../views/scooter.add.php' ); 
            }
        break;
        
        case "delete":
            if(isset($_GET['type'])){
                if($model->deleteScooters($param)){
                   header( 'Location: ../views/scooter.php' ); 
                }  
            }else{
                if($model->deleteScooter($_GET['id'])){
                   header( 'Location: ../views/scooter.php' ); 
                }  
            }
        break;
        
        case "import":
            if(isset($_GET['type'])){
                switch($_GET['type']){
                    case "submit":
                        $param = array();
                        $excel = array();
                        $param['fileName']  = mysql_escape_string(trim($_FILES['file']['name']));
                        $param['fileType']  = mysql_escape_string(trim($_FILES['file']['type']));
                        $param['fileTmp']   = $_FILES['file']['tmp_name'];
                        $param['fileError'] = $_FILES['file']['error'];
                        $param['fileSize']  = $_FILES['file']['size']; 
                        
                        $fileExtension      = strtoupper(array_pop(explode(".", $param['fileName'])));
                        $param['file_type'] =  mysql_escape_string(trim($_POST['file_type']));
                        $param['import_type'] = mysql_escape_string(trim($_POST['import_type']));
                        $param['punct_de_lucru'] =  mysql_escape_string(trim($_POST['punct_de_lucru']));
                        
                        if($param['import_type']==1){
                            $param['import_data'] = $_POST['columns_list_p'];
                        }else if($param['import_type']==2){
                            $arr = explode(';',mysql_escape_string(trim($_POST['columns_list_s'])));
                            foreach($arr as $item){
                                $param['import_data'][] = chr(64+$item);
                            }
                        }
                        $param['fileExtension']   = $fileExtension;
                        
                        $target_path = "../../../tmp/" . basename($param['fileName']); 
                        $err = move_uploaded_file($param['fileTmp'], $target_path); 
                        
                        switch($param['file_type']){
                            case "csv":
                                    $objReader = PHPExcel_IOFactory::createReader($fileExtension); 
                                    $objPHPExcel = $objReader->load($target_path);
                                    
                                    $worksheet = $objPHPExcel->getActiveSheet();

                                    $i=1; 
                                    $model->addScooterImport($param);
                                    foreach ($worksheet->getRowIterator() as $row) {
                                            $cellIterator = $row->getCellIterator();
                                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                                            foreach ($cellIterator as $cell) {
                                                if($row->getRowIndex()!=1){
                                                    foreach($param['import_data'] as $item){
                                                        if (!is_null($cell) && substr($cell->getCoordinate(),0,1)==$item) {
                                                            //$param['cell_coordinate'] = $cell->getCoordinate();
                                                            if($cell->getValue()==NULL){
                                                                 break;
                                                            }
                                                            $param['data'][$item][$i] = $cell->getValue(); 
                                                        }
                                                    }
                                                }
                                            }
                                            $i++;
                                        
                                    }
                            break;
                                    
                            case "xls":
                                    $objPHPExcel = PHPExcel_IOFactory::load($target_path);
                                    $worksheet = $objPHPExcel->getActiveSheet();

                                    $i=1;
                                    $model->addScooterImport($param); 
                                    foreach ($worksheet->getRowIterator() as $row) {
                                            $cellIterator = $row->getCellIterator();
                                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                                            foreach ($cellIterator as $cell) {
                                                if($row->getRowIndex()!=1){
                                                   foreach($param['import_data'] as $item){
                                                        if (!is_null($cell) && substr($cell->getCoordinate(),0,1)==$item) {
                                                            //$param['cell_coordinate'] = $cell->getCoordinate();
                                                            if($cell->getValue()==NULL){
                                                                 break;
                                                            }
                                                            $param['data'][$item][$i] = $cell->getValue();
                                                        }
                                                    }
                                                }
                                            }
                                            $i++;
                                        
                                    }
                            break;
                            
                            case "xlsx":
                                    $objPHPExcel = PHPExcel_IOFactory::load($target_path);
                                    $worksheet = $objPHPExcel->getActiveSheet();

                                    $i=1;
                                    $model->addScooterImport($param);
                                    foreach ($worksheet->getRowIterator() as $row) {
                                            $cellIterator = $row->getCellIterator();
                                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                                            foreach ($cellIterator as $cell) {
                                                if($row->getRowIndex()!=1){
                                                    foreach($param['import_data'] as $item){
                                                        if (!is_null($cell) && substr($cell->getCoordinate(),0,1)==$item) {
                                                            //$param['cell_coordinate'] = $cell->getCoordinate();
                                                            if($cell->getValue()==NULL){
                                                                 break;
                                                            }
                                                            $param['data'][$item][$i] = $cell->getValue();
                                                        }
                                                    }
                                                }
                                            }
                                            $i++;
                                        
                                    }
                            break;
                        }
                                    
                        if($model->importScooterList($param)){
                           header( 'Location: ../views/scooter.php' ); 
                        } 
                    break;
                    case "processing":
                        $param = array();
                        $param['fileName']  = mysql_escape_string(trim($_FILES['file']['name']));
                        $param['fileType']  = mysql_escape_string(trim($_FILES['file']['type']));
                        $param['fileTmp']   = $_FILES['file']['tmp_name'];
                        $param['fileError'] = $_FILES['file']['error'];
                        $param['fileSize']  = $_FILES['file']['size']; 
                        $fileExtension      = strtoupper(array_pop(explode(".", $param['fileName'])));
                        
                        $param['file_type'] = mysql_escape_string(trim($_POST['file_type']));
                        $param['fileExtension']   = $fileExtension;
                        
                        $target_path = "../../../tmp/" . basename($param['fileName']); 
                        $err = move_uploaded_file($param['fileTmp'], $target_path); 
                        switch($param['file_type']){
                            case "csv":
                                $objReader = PHPExcel_IOFactory::createReader($fileExtension); 
                                $objPHPExcel = $objReader->load($target_path);
                                
                                $worksheet = $objPHPExcel->getActiveSheet();

                                $i=65;
                                foreach ($worksheet->getRowIterator() as $row) {
                                        $cellIterator = $row->getCellIterator();
                                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                                        foreach ($cellIterator as $cell) {
                                            if (!is_null($cell) && $row->getRowIndex()==1) {
                                                echo '<option value="'.chr($i).'">'.$cell->getValue().'</option>';
                                                $i++;
                                            }else{
                                                 break;
                                            }
                                        }
                                        break;   
                                }
                              break;
                              
                              case "xls":
                                    $objPHPExcel = PHPExcel_IOFactory::load($target_path);
                                    $worksheet = $objPHPExcel->getActiveSheet();

                                    $i=65;
                                    foreach ($worksheet->getRowIterator() as $row) {
                                            $cellIterator = $row->getCellIterator();
                                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                                            foreach ($cellIterator as $cell) {
                                                if (!is_null($cell) && $row->getRowIndex()==1) {
                                                    echo '<option value="'.chr($i).'">'.$cell->getValue().'</option>';
                                                    $i++;
                                                }else{
                                                     break;
                                                }
                                            }
                                            break;   
                                    }
                              break;
                              
                              case "xlsx":
                                    $objPHPExcel = PHPExcel_IOFactory::load($target_path);
                                    $worksheet = $objPHPExcel->getActiveSheet();

                                    $i=65;
                                    foreach ($worksheet->getRowIterator() as $row) {
                                            $cellIterator = $row->getCellIterator();
                                            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                                            foreach ($cellIterator as $cell) {
                                                if (!is_null($cell) && $row->getRowIndex()==1) {
                                                    echo '<option value="'.chr($i).'">'.$cell->getValue().'</option>';
                                                    $i++;
                                                }else{
                                                     break;
                                                }
                                            }
                                            break;   
                                    }
                              break;
                        }  
                    break;
                }
                
            }else{
             header( 'Location: ../views/scooter.import.php' ); 
            }
        break;
        
        default:
            echo 'tralala';
        break;
    }
?>               
