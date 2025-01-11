<?php
    namespace Repositories;
    use Lib\Database;
    use DTOException;

    class ProductRepository{
        private Database $database;

        public function __construct() {
            $this->database = new Database();
        }

        public function getAll(): array {
            $sql = "SELECT * FROM productos";
            $result = $this->database->query($sql);
            if ($result) {
                return $result->fetchAll(); 
            } else {
                return [];
            }
        }
        
        public function save($product) {
            $sql = "INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) 
                    VALUES (null, :categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)";
            
            $oferta = $product->getOferta() ?: null; 
            
            $data = [
                'categoria_id' => $product->getCategoriaId(),
                'nombre' => $product->getNombre(),
                'descripcion' => $product->getDescripcion(),
                'precio' => $product->getPrecio(),
                'stock' => $product->getStock(),
                'oferta' => $oferta,
                'fecha' => date('Y-m-d H:i:s'),
                'imagen' => $product->getImagen()
            ];
        
            try {
                if (!$this->database->execute($sql, $data)) {
                    return false;
                }
                return true;
            } catch (PDOException $e) {
                error_log("Error al guardar el producto: " . $e->getMessage());
                return false;
            }
        }
        
    }

