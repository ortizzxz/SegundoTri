<style>
    img{
        width: 150px;
        height: 150px;
    }
</style>

<div class="container">
    <?php
    function displayMessage()
    {
        if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
            unset($_SESSION['error']);
        } elseif (isset($_SESSION['success'])) {
            echo "<div class='success-message'>" . htmlspecialchars($_SESSION['success']) . "</div>";
            unset($_SESSION['success']);
        }
    }

    function displayNoProductsMessage()
    {
        echo "<h2 id='productTitle'>No hay productos disponibles.</h2>";
    }

    function displayProductsGrid(array $products)
    {
        echo "<h2 id='productTitle'>Lista de Productos</h2>";
        echo "<div class='products-grid'>";

        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<img src='" . htmlspecialchars($product['imagen']) . "' alt='Imagen de " . htmlspecialchars($product['nombre']) . "' class='product-image'>";
            echo "<h3 class='product-name'>" . htmlspecialchars($product['nombre']) . "</h3>";
            echo "<p class='product-description'>" . htmlspecialchars($product['descripcion']) . "</p>";
            echo "<p class='product-price'>Precio: €" . htmlspecialchars($product['precio']) . "</p>";
            echo "<p class='product-offer'>" . (empty($product['oferta']) ? 'No hay oferta' : 'Oferta: ' . htmlspecialchars($product['oferta'])) . "</p>";

            echo "<form action='" . BASE_URL . "cart/add/" . htmlspecialchars($product['id']) . "' method='POST'>";
            echo "<input type='hidden' name='id' value='" . htmlspecialchars($product['id']) . "'>";
            echo "<input type='submit' value='Añadir al carrito' class='add-to-cart-btn'>";
            echo "</form>";
            echo "</div>";
        }

        echo "</div>";
    }

    // Display any error or success messages
    displayMessage();

    if (empty($data)) {
        displayNoProductsMessage();
    } else {
        displayProductsGrid($data);
    }
    ?>
</div>