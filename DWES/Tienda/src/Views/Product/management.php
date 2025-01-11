<div class="container">
    <h1>Gestión de Productos</h1>
    
    <?php
    function displayMessage() {
        if (isset($_SESSION['errors'])) {
            echo "<div class='error-message'>" . htmlspecialchars($_SESSION['errors']) . "</div>";
            unset($_SESSION['errors']);
        } elseif (isset($_SESSION['success'])) {
            echo "<div class='success-message'>" . htmlspecialchars($_SESSION['success']) . "</div>";
            unset($_SESSION['success']);
        }
    }

    displayMessage();

    function displayNoProductsMessage() {
        echo "<h2 id='productTitle'>No hay productos disponibles.</h2>";
    }

    function displayProductsTable(array $products) {
        echo "<h2 id='productTitle'>Lista de Productos</h2>";
        
        echo "<table class='styled-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Categoría</th>";
        echo "<th>Nombre</th>";
        echo "<th>Descripción</th>";
        echo "<th>Precio</th>";
        echo "<th>Stock</th>";
        echo "<th>Oferta</th>";
        echo "<th>Imagen</th>";
        echo "<th>Acción</th>"; 
        echo "</tr>";
        echo "</thead>";
        
        echo "<tbody>";
        
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['id']) . "</td>";
            echo "<td>" . htmlspecialchars($product['categoria_id']) . "</td>";
            echo "<td>" . htmlspecialchars($product['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($product['descripcion']) . "</td>";
            echo "<td>" . htmlspecialchars($product['precio']) . "</td>";
            echo "<td>" . htmlspecialchars($product['stock']) . "</td>";
            echo "<td>" . htmlspecialchars($product['oferta']) . "</td>";
            echo "<td><img src='" . htmlspecialchars($product['imagen']) . "' alt='Imagen del producto' style='width:50px;height:50px;'></td>";
            echo "<td>
                    <form action='" . BASE_URL . "products/delete' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($product['id']) . "'>
                        <input type='submit' value='Eliminar'>
                    </form>
                    <a href='" . BASE_URL . "products/edit/" . htmlspecialchars($product['id']) . "'>Editar</a>
                </td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    }

    if (empty($data)) {
        displayNoProductsMessage();
    } else {
        displayProductsTable($data);
    }
    ?>

    <div class="product-form">
       <h2>Agregar Nuevo Producto</h2>
       <form action="<?= BASE_URL; ?>products" method="POST">
           <input type="number" name="data[categoria_id]" placeholder="Categoría del producto (1, 2, ...)" required>
           <input type="text" name="data[nombre]" placeholder="Nombre del producto (Abrigo de Lana, Zapatillas Nike Fussion, ...)" required>
           <input type="text" name="data[descripcion]" placeholder="Descripcion del producto (Abrigo hecho de 100% lana de camello dorado...)"  required>
           <input type="text" name="data[precio]" placeholder="Precio del producto (100€, 260€, ...)"  required>
           <input type="number" name="data[stock]" placeholder="Stock del producto (10, 20, 60, ...)"  required>
           <input type="text" name="data[oferta]" placeholder="Oferta del producto (0, 50%, 10%, ...)"  >
           <input type="text" name="data[imagen]" placeholder="URL de la imagen del producto (https://imagenes.com/abrigoDeLana)"  required>
           <input type="submit" value="Agregar Producto">
       </form>
    </div>
</div>
