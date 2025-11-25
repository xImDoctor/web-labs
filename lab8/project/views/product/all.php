<p>Всего продуктов: <strong><?= $total ?></strong></p>
<p>Общая стоимость: <strong>$<?= number_format($totalCost, 2) ?></strong></p>

<table class="table-products">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Категория</th>
            <th>Стоимость</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $id => $product): ?>
            <tr>
                <td><?= $id ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>$<?= $product['price'] ?></td>
                <td><?= $product['quantity'] ?></td>
                <td><?= htmlspecialchars($product['category']) ?></td>
                <td><strong>$<?= $product['cost'] ?></strong></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
