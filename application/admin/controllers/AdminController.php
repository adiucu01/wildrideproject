<?php

class AdminController {
    
    private $view = 'application/admin/views/';
    
    public function indexAction() {
        require($this->view . 'default.php');
    }
    
}

