<?php
    namespace Services;
    use Repositories\CategoryRepository;
    use Models\Category;

    class CategoryService{
        private CategoryRepository $categoryRepository;

        public function __construct() {
            $this->categoryRepository = new CategoryRepository();
        }
    
        public function getAll(){
            return $this->categoryRepository->getAll();
        }

        public function addCategory($name){
            $this->categoryRepository->addCategory($name);
        }

        public function deleteCategory($id) {
            return $this->categoryRepository->delete($id);
        }
        
    }

