<style>
    * {
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
        font-family: 'Roboto', Arial;
    }

    .container {
        max-width: 1000px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1,
    h2 {
        color: #333;
    }

    .styled-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .styled-table thead {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
        border: 1px solid #dddddd;
    }

    .styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .styled-table td form {
        display: inline-block;
        margin-right: 10px;
    }

    .styled-table td input[type="submit"] {
        background-color: #ff4d4d;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 3px;
    }

    .styled-table td a {
        text-decoration: none;
        color: #007bff;
        margin-left: 10px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: box-shadow 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .product-name {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .product-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }

    .product-price {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .product-offer {
        color: #28a745;
    }

    .add-to-cart-btn {
        display: inline-block;
        width: 100%;
        padding: 10px 15px;
        background-color: #4caf50;
        /* Verde */
        color: white;
        border: none;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        margin-top: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-to-cart-btn:hover {
        background-color: #45a049;
    }

    .add-to-cart-btn:active {
        background-color: #3e8e41;
        transform: scale(0.98);
    }

    form select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 20px;
        background-color: #f8f8f8;
        transition: border-color 0.2s ease-in-out;
    }

    form select:focus {
        border-color: #007bff;
        outline: none;
        background-color: #ffffff;
    }


    input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        border: 1px solid #009879;
    }

    /* HEADER */
    nav ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        background-color: #2c3e50;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
    }

    nav li {
        float: none;
    }

    nav li:first-child {
        margin-right: auto;
    }

    nav li:not(:first-child) {
        float: right;
    }

    p {
        color: white;
        text-align: center;
        font-size: x-large;
    }

    nav li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s;
        height: 100%;
    }

    nav li a:hover {
        background-color: #ddd;
        color: black;

    }

    nav li a.active {
        font-size: x-large;
    }

    /** FOOTER **/

    footer {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 10px 0;
        text-align: center;
    }

    footer h1 {
        font-size: 24px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #3498db;
    }

    .footer-content {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-section {
        flex: 1;
        margin: 10px;
        min-width: 200px;
    }

    .footer-section h3 {
        color: #e74c3c;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section ul li a {
        color: #bdc3c7;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section ul li a:hover {
        color: #ffffff;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .social-icons a {
        color: #ffffff;
        margin: 0 10px;
        font-size: 24px;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #3498db;
    }

    .copyright {
        margin-top: 20px;
        font-size: 14px;
        color: #95a5a6;
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
            echo "<img src='" . BASE_URL . "uploads/productos/" . htmlspecialchars($product['imagen']) . "' alt='Imagen de " . htmlspecialchars($product['nombre']) . "' class='product-image'>";
            echo "<h3 class='product-name'>" . htmlspecialchars($product['nombre']) . "</h3>";
            echo "<p class='product-description'>" . htmlspecialchars($product['descripcion']) . "</p>";
            echo "<p class='product-price'>Precio: €" . htmlspecialchars($product['precio']) . "</p>";
            echo "<p class='product-offer'>" .
                (empty($product['oferta']) ? 'No hay oferta' : 'Oferta: ' . htmlspecialchars($product['oferta']) . '%') .
                "</p>";
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