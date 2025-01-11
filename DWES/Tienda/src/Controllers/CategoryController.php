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
                header("Location: " . BASE_URL . "login"); 
                exit(); // Detener la ejecución del script
            }
        
            // Si el usuario es admin, obtener las categorías
            $categories = $this->categoryService->getAll();
            $this->pages->render('Category/index', ['categories' => $categories]);
        }
        
        

        public function addCategory() {
            // Verificar si el usuario está autenticado y es admin
            if (!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== 'admin') {
                // Redirigir a la página de inicio o a una página de acceso denegado
                header("Location: " . BASE_URL . "login"); 
                exit(); // Detener la ejecución del script
            }
        
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
                //sanitizar entrada
                $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
                $nombre = trim($nombre);
        
                //validar entrada
                if (empty($nombre)) {
                    $_SESSION['error'] = "El nombre de la categoría no puede estar vacío.";
                    header("Location: " . BASE_URL . "categories");
                    exit();
                }
        
                if (strlen($nombre) > 15) {
                    $_SESSION['error'] = "El nombre de la categoría es demasiado largo.";
                    header("Location: " . BASE_URL . "categories");
                    exit();
                }else if(strlen($nombre) < 3){
                    $_SESSION['error'] = "El nombre de la categoría es demasiado corto.";
                    header("Location: " . BASE_URL . "categories");
                    exit();
                }
        
                $result = $this->categoryService->addCategory($nombre);
        
                if ($result) {
                    $_SESSION['success'] = "Categoría agregada con éxito.";
                } else {
                    $_SESSION['error'] = "No se pudo agregar la categoría.";
                }
        
                header("Location: " . BASE_URL . "categories"); // aqui el render no funciona?
                exit();
            } else {
                header("Location: " . BASE_URL);
                exit();
            }
        }
        
        
        public function deleteCategory() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $id = $_POST['id'];
        
                $this->categoryService->deleteCategory($id);
        
                header("Location: " . BASE_URL . "categories");
                exit();
            }
        }
        
        
    }