<?php
namespace Models;

class LineaPedido {
    private static array $errors = [];

    public function __construct(
        private int | null $id,
        private int $pedido_id,
        private int $producto_id,
        private int $unidades
    ) {
    }

    public static function getErrors(): array {
        return self::$errors;
    }

    public static function setErrors(array $errors): void {
        self::$errors = $errors;
    }

    public function validation(): bool {
        self::$errors = [];

        if ($this->pedido_id <= 0) {
            self::$errors[] = "El ID del pedido debe ser un número positivo";
        }

        if ($this->producto_id <= 0) {
            self::$errors[] = "El ID del producto debe ser un número positivo";
        }

        if ($this->unidades <= 0 || $this->unidades > 9999) {
            self::$errors[] = "Las unidades deben ser un número entre 1 y 9999";
        }

        if (empty(self::$errors)) {
            $this->sanitize();
        }

        return empty(self::$errors);
    }

    public function sanitize() {
        $this->pedido_id = filter_var($this->pedido_id, FILTER_VALIDATE_INT) ? $this->pedido_id : 0;
        $this->producto_id = filter_var($this->producto_id, FILTER_VALIDATE_INT) ? $this->producto_id : 0;
        $this->unidades = filter_var($this->unidades, FILTER_VALIDATE_INT) ? $this->unidades : 0;
    }

    public static function fromArray(array $data): LineaPedido {
        return new LineaPedido(
            $data['id'] ?? null,
            (int)($data['pedido_id'] ?? 0),
            (int)($data['producto_id'] ?? 0),
            (int)($data['unidades'] ?? 0)
        );
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getPedidoId(): int { return $this->pedido_id; }
    public function getProductoId(): int { return $this->producto_id; }
    public function getUnidades(): int { return $this->unidades; }

    // Setters
    public function setPedidoId(int $pedido_id): void { $this->pedido_id = $pedido_id; }
    public function setProductoId(int $producto_id): void { $this->producto_id = $producto_id; }
    public function setUnidades(int $unidades): void { $this->unidades = $unidades; }
}