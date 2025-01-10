<?php
function displayNoCategoriesMessage() {
    echo "<h2 id='categoryTitle'>No hay categorías disponibles.</h2>";
}

function displayCategoriesTable(array $categories) {
    echo "<h2 id='categoryTitle'>Lista de Categorías</h2>";
    
    echo "<table class='styled-table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nombre</th>";
    echo "<th>Acción</th>"; 
    echo "</tr>";
    echo "</thead>";
    
    echo "<tbody>";
    
    foreach ($categories as $category) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($category['id']) . "</td>";
        echo "<td>" . htmlspecialchars($category['nombre']) . "</td>";
        // Agregar botón de eliminar
        echo "<td>
                <form action='" . BASE_URL . "categories/delete' method='POST' style='display:inline;'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($category['id']) . "'>
                    <input type='submit' value='Eliminar'>
                </form>
              </td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
}

// Mostrar mensaje o tabla según disponibilidad de categorías
if (empty($categories)) {
    displayNoCategoriesMessage();
} else {
    displayCategoriesTable($categories);
}
?>

<div class="category-form">
   <h2>Agregar Nueva Categoría</h2>
   <form action="<?= BASE_URL; ?>categories" method="POST">
       <input type="text" name="nombre" placeholder="Nombre de la categoría" required>
       <input type="submit" value="Agregar Categoría">
   </form>
</div>

