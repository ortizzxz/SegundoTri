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
    
</style>