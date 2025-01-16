<?php
namespace Controllers;
use Models\Product;
use Lib\Pages;
use Services\ProductService;

session_start();

class ProductController
{
    const ROLE_ADMIN = 'admin';
    private Pages $pages;
    private ProductService $productService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productService = new ProductService();
    }

    public function index()
    {
        $data = $this->productService->getAll();

        // Verificar si el usuario está autenticado y es admin
        if (!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== 'admin') {
            $this->pages->render('Product/index', ['data' => $data]);
        } else {
            $this->pages->render('Product/management', ['data' => $data]);
        }

    }

    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $product = Product::fromArray($_POST['data']);

                if ($product->validation()) { // Validar los datos
                    try {
                        if ($this->productService->save($product)) {
                            $_SESSION['success'] = "Producto agregado con éxito.";
                            header("Location: " . BASE_URL . "products"); // Redirigir después de registro exitoso
                            exit();
                        } else {
                            $_SESSION['addproduct'] = 'fail';
                            $_SESSION['errors'] = 'Error al guardar el producto';
                        }
                    } catch (\Exception $e) {
                        $_SESSION['addproduct'] = 'fail';
                        $_SESSION['errors'] = $e->getMessage();
                    }
                } else {
                    $_SESSION['addproduct'] = 'fail';
                    $_SESSION['errors'] = Product::getErrors();
                }
            } else {
                $_SESSION['addproduct'] = 'fail';
                $_SESSION['errors'] = 'No se enviaron datos válidos';
                header("Location: " . BASE_URL . "products");
                exit();
            }
        } else {
            $this->pages->render('Product/index'); // Siempre renderizar el formulario al final
        }
    }

    public function editProduct($id)
    {
        if ($_SESSION['identity']['rol'] == self::ROLE_ADMIN) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $thisProduct = $this->productService->getById($id);
                if ($thisProduct) {
                    $this->pages->render('Product/managementSingleProduct', ['thisProduct' => $thisProduct]);
                } else {
                    $_SESSION['edit'] = 'fail';
                    $_SESSION['errors'] = 'Error al obtener el producto desde la BD';
                    $this->pages->render('Product/management');
                }
            } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['data'])) {
                    $product = Product::fromArray($_POST['data']);

                    if ($product->validation()) { // Validar los datos
                        try {
                            if ($this->productService->updateProduct($id, $_POST['data'])) {
                                $_SESSION['success'] = "Producto actualizado con éxito.";
                                $this->pages->render('Product/management');
                            } else {
                                $_SESSION['edit'] = 'fail';
                                $_SESSION['errors'] = 'Error al actualizar el producto';
                                $this->pages->render('Product/managementSingleProduct');
                            }
                        } catch (\Exception $e) {
                            $_SESSION['edit'] = 'fail';
                            $_SESSION['errors'] = $e->getMessage();
                            $this->pages->render('Product/managementSingleProduct');
                        }
                    } else {
                        $_SESSION['edit'] = 'fail';
                        $_SESSION['errors'] = Product::getErrors();
                        $this->pages->render('Product/managementSingleProduct');
                    }
                } else {
                    $_SESSION['edit'] = 'fail';
                    $_SESSION['errors'] = 'No se enviaron datos válidos';
                    header("Location: " . BASE_URL . "products");
                    exit();
                }
            }
        } else {
            $this->pages->render('Product/management'); // si no es admin
        }
    }

    public function deleteProduct(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Check if the user is logged in and has admin privileges
            if (!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== self::ROLE_ADMIN) {
                $_SESSION['errors'] = "No tienes permisos para realizar esta acción.";
                header("Location: " . BASE_URL . "products");
                exit();
            }

            try {
                if ($this->productService->deleteById($id)) {
                    $_SESSION['success'] = "Producto eliminado con éxito.";
                } else {
                    $_SESSION['errors'] = "Error al eliminar el producto. Es posible que no exista.";
                }
            } catch (\Exception $e) {
                // Handle any exceptions that occur during deletion
                $_SESSION['errors'] = "Error al intentar eliminar el producto: " . $e->getMessage();
            }

            // Redirect back to the product management page
            header("Location: " . BASE_URL . "products");
            exit();
        } else {
            echo 'get';
        }
    }
}



?>