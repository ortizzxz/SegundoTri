<?php
namespace Repositories;
use Lib\Database;
use PDO;

class ProductRepository
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM productos";
        $result = $this->database->query($sql);
        if ($result) {
            return $result->fetchAll();
        } else {
            return [];
        }
    }

    public function getById(int $id): array
    {
        $stmt = $this->database->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getStockById(int $id): int
    {
        $stmt = $this->database->prepare("SELECT stock FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int) $result['stock'] : 0;
    }

    public function updateStock(int $productId, int $quantity): bool
    {
        $currentStock = $this->getStockById($productId);

        if ($currentStock < $quantity) {
            // No se puede actualizar si no hay suficiente stock
            return false; 
        }

        $newStock = $currentStock - $quantity; //calculamos el nuevo stock

        $stmt = $this->database->prepare("UPDATE productos SET stock = :stock WHERE id = :id");
        $stmt->bindParam(':stock', $newStock, PDO::PARAM_INT);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function save($product)
    {
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
        } catch (\PDOException $e) {
            error_log("Error al guardar el producto: " . $e->getMessage());
            return false;
        }
    }

}

