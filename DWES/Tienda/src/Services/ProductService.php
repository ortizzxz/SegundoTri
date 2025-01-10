<?php
    namespace Services;
    use Repositories\ProductRepository;
    use Models\Product;

    class UserService{
        private ProductRepository $productRepository;

        public function __construct() {
            $this->productRepository = new ProductRepository();
        }

        
    }