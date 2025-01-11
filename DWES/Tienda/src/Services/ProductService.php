<?php
    namespace Services;
    use Repositories\ProductRepository;
    use Models\Product;

    class ProductService{
        private ProductRepository $productRepository;

        public function __construct() {
            $this->productRepository = new ProductRepository();
        }

        public function getAll(){
            return $this->productRepository->getAll();
        }

        public function save(Product $product) : bool{
            $isSave = $this->productRepository->save($product);
            return $isSave;
        }
    }