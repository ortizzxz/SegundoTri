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

        public function getById(int $id){
                return $this->productRepository->getById($id);
        }

        public function updateProduct(){
            return true;
        }

        public function save(Product $product) : bool{
            $isSave = $this->productRepository->save($product);
            return $isSave;
        }
    }