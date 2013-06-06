<?php
    class SearchController{
        private $request;
        private $view = 'application/user/views/';
        public $_secure = false;

        public function __construct() {
            $this->request = new Request();
        }
        public function viewAction(){
            require($this->view.'search.php'); 
        }
        public function paginationAction(){
            $param = $_POST;

            $model = new UserModelSearch();
            echo $model->SearchScooter($param);
        }
        public function filterAction(){
            $param = $_POST;
            $model = new UserModelSearch();     

            $param['category'] = $this->request->getParam('category');
            switch($param['category']){
                case "in_stock":
                    $param['f'] = true;
                    echo $model->ProductInStock($param,$count);
                    break;
                case "all_products":
                    $param['f'] = true;
                    echo $model->AllProducts($param,$count);
                    break;
                case "new_products":
                    $param['f'] = true;
                    echo $model->NewProducts($param,$count);
                    break;

                case "price_products":
                    $param['f'] = true;
                    echo $model->PriceProducts($param,$min,$max,$range,$count);
                    break;

                case "handles_products":
                    $param['f'] = true;
                    echo $model->HandlesProducts($param,$rubber,$plastic);
                    break;

                case "wheels_products":
                    $param['f'] = true;
                    echo $model->WheelsProducts($param,$aluminum,$iron);
                    break;

                case "horn_products":
                    $param['f'] = true;
                    echo $model->HornProducts($param,$yes,$no);
                    break;
                case "view_special_offers":
                    require($this->view.'search.php'); 
                    break;
                case "special_offers":
                    $param['f'] = true;
                    echo $model->ProductInSpecialOffers($param,$count);
                    break;
            }
        }
    }
