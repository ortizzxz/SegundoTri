<div class="container">
    <h1>Tu Carrito de Compras</h1>

    <?php
    function displayMessage() {
        if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
            unset($_SESSION['error']);
        } elseif (isset($_SESSION['success'])) {
            echo "<div class='success-message'>" . htmlspecialchars($_SESSION['success']) . "</div>";
            unset($_SESSION['success']);
        }
    }

    displayMessage();

    if (empty($cartItems)) {
        echo "<p>Tu carrito está vacío.</p>";
    } else {
        echo "<table class='cart-table'>";
        echo "<thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acciones</th></tr></thead>";
        echo "<tbody>";

        $total = 0;
        foreach ($cartItems as $item) {
            $subtotal = $item['precio'] * $item['quantity'];
            $total += $subtotal;

            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['nombre']) . "</td>";
            echo "<td>€" . number_format($item['precio'], 2) . "</td>";
            echo "<td>" . $item['quantity'] . "</td>";
            echo "<td>€" . number_format($subtotal, 2) . "</td>";
            echo "<td>
                    <form action='" . BASE_URL . "cart/remove/" . $item['id'] . "' method='POST' style='display:inline;'>
                        <input type='submit' value='Eliminar' class='remove-btn'>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "<tfoot><tr><td colspan='3'><strong>Total</strong></td><td colspan='2'><strong>€" . number_format($total, 2) . "</strong></td></tr></tfoot>";
        echo "</table>";

        echo "<div class='cart-actions'>";
        echo "<a href='" . BASE_URL . "products' class='continue-shopping-btn'>Continuar Comprando</a>";
        echo "<form action='" . BASE_URL . "order/create' method='POST' style='display:inline;'>";
        echo "<input type='submit' value='Realizar Pedido' class='checkout-btn'>";
        echo "</form>";
        echo "</div>";
    }
    ?>
</div>

