<p>Продуктов в каталоге: <strong><?= $total ?></strong></p>

<table class="table-products">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Стоимость</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['quantity'] ?></td>
                <td><strong>$<?= number_format($product['cost'], 2) ?></strong></td>
                <td><a href="/product/db/<?= $product['id'] ?>/" class="btn">Подробнее</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"><strong>Итого:</strong></td>
            <td colspan="2"><strong>$<?= number_format($totalCost, 2) ?></strong></td>
        </tr>
    </tfoot>
</table>
