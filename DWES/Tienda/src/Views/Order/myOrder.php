<h1>Mis Pedidos</h1>

<?php if (isset($pedidos) && !empty($pedidos)): ?>
    <table class="orders-table">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <?php if ($_SESSION['identity']['rol'] == $_ENV['ADMIN']): ?>
                    <th>ID Cliente</th>
                <?php endif; ?>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= htmlspecialchars($pedido['id']) ?></td>
                    <?php if ($_SESSION['identity']['rol'] == $_ENV['ADMIN']): ?>
                        <td><?= htmlspecialchars($pedido['usuario_id']) ?></td>
                    <?php endif; ?>
                    <td><?= htmlspecialchars($pedido['fecha']) ?></td>
                    <td><?= htmlspecialchars($pedido['estado']) ?></td>
                    <td><?= htmlspecialchars($pedido['coste']) ?>€</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No tienes pedidos.</p>
<?php endif; ?>

<style>
    h1 {
        text-align: center;
        color: #333;
        font-size: 2em;
        margin-bottom: 20px;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .orders-table th,
    .orders-table td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .orders-table th {
        background-color: #f4f4f4;
        color: #333;
    }

    .orders-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .orders-table tr:hover {
        background-color: #e9ecef;
    }

    .orders-table td {
        font-size: 1.1em;
    }

    .orders-table td:nth-child(4) {
        font-weight: bold;
        color: #007bff;
    }

    p {
        text-align: center;
        font-size: 1.2em;
        color: #888;
    }
</style>