<?php
    namespace Controllers;
    use Lib\Pages;
    use Models\Product;
    // use Services\ProductService;

    class ProductController{
        private Pages $pages; 
        // private ProductService $productService;

        public function __construct() {
            $this->pages = new Pages();
            // $this->productService = new ProductService();
        }

        public function index(){
            $this->pages->render('Product/landPage');
        }

    }        
?>