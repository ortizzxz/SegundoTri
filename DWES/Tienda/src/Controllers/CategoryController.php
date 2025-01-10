<?php
    namespace Controllers;
    use Lib\Pages;
    use Services\CategoryService;
    
    session_start();
 
    class CategoryController{
        private Pages $pages; 
        private CategoryService $categoryService;

        public function __construct() {
            $this->pages = new Pages();
            $this->categoryService = new CategoryService();
        }

        public function index() {
            // Verificar si el usuario está autenticado y es admin
            if (!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== 'admin') {
                // Redirigir a la página de inicio o a una página de acceso denegado
                header("Location: " . BASE_URL . "login"); // O BASE_URL para la página principal
                exit(); // Detener la ejecución del script
            }
        
            // Si el usuario es admin, obtener las categorías
            $categories = $this->categoryService->getAll();
            $this->pages->render('Category/displayAll', ['categories' => $categories]);
        }
        
        

        public function addCategory() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
                $nombre = $_POST['nombre'];
        
                // Lógica para agregar la categoría
                $this->categoryService->addCategory($nombre);
        
                // Redirigir a la página de categorías después de agregar
                header("Location: " . BASE_URL . "categories"); // Cambia esto según tu ruta
                exit();
            }
        }
        
        public function deleteCategory() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $id = $_POST['id'];
        
                // Lógica para eliminar la categoría
                $this->categoryService->deleteCategory($id);
        
                // Redirigir a la página de categorías después de eliminar
                header("Location: " . BASE_URL . "categories");
                exit();
            }
        }
        
        
    }