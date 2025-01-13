<div class="container">
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
    ?>

    <div class="product-form">
        <h2>Editar Producto</h2>
        <form action="<?= BASE_URL; ?>products/edit/<?php echo $thisProduct['id']; ?>" method="POST">
            <input type="number" name="data[categoria_id]" value="<?php echo htmlspecialchars($thisProduct['categoria_id']); ?>" placeholder="Categoría del producto (1, 2, ...)" >
            <input type="text" name="data[nombre]" value="<?php echo htmlspecialchars($thisProduct['nombre']); ?>" placeholder="Nombre del producto" >
            <input type="text" name="data[descripcion]" value="<?php echo htmlspecialchars($thisProduct['descripcion']); ?>" placeholder="Descripción del producto" >
            <input type="text" name="data[precio]" value="<?php echo htmlspecialchars($thisProduct['precio']); ?>" placeholder="Precio del producto (100€, 260€, ...)" >
            <input type="number" name="data[stock]" value="<?php echo htmlspecialchars($thisProduct['stock']); ?>" placeholder="Stock del producto (10, 20, 60, ...)"  >
            <input type="text" name="data[oferta]" value="<?php echo htmlspecialchars($thisProduct['oferta']); ?>" placeholder="Oferta del producto (0, 50%, 10%, ...)">
            <input type="text" name="data[imagen]" value="<?php echo htmlspecialchars($thisProduct['imagen']); ?>" placeholder="URL de la imagen del producto" >
            
            <?php if($thisProduct['imagen']): ?>
                <div>
                    <label>Imagen actual:</label>
                    <img src="<?php echo htmlspecialchars($thisProduct['imagen']); ?>" alt="Imagen del producto" style="width:100px;height:100px;">
                </div>
            <?php endif; ?>
            
            <input type="submit" value="Actualizar Producto">
        </form>
    </div>

    <a href="<?= BASE_URL; ?>products" class="btn btn-secondary">Volver a Gestión de Productos</a>
</div>
