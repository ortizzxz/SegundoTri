<div class="container">
    <?php
    function displayNoProductsMessage() {
        echo "<h2 id='productTitle'>No hay productos disponibles.</h2>";
    }

    function displayProductsGrid(array $products) {
        echo "<h2 id='productTitle'>Lista de Productos</h2>";
        echo "<div class='products-grid'>";
        
        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<img src='" . htmlspecialchars($product['imagen']) . "' alt='Imagen de " . htmlspecialchars($product['nombre']) . "' class='product-image'>";
            echo "<h3 class='product-name'>" . htmlspecialchars($product['nombre']) . "</h3>";
            echo "<p class='product-description'>" . htmlspecialchars($product['descripcion']) . "</p>";
            echo "<p class='product-price'>Precio: €" . htmlspecialchars($product['precio']) . "</p>";
            echo "<p class='product-offer'>" . (empty($product['oferta']) ? 'No hay oferta' : 'Oferta: ' . htmlspecialchars($product['oferta'])) . "</p>";
            echo "</div>";
        }
        
        echo "</div>";
    }

    if (empty($data)) {
        displayNoProductsMessage();
    } else {
        displayProductsGrid($data);
    }
    ?>
</div>
