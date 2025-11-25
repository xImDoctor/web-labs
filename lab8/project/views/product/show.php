<?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php else: ?>
    <h1>Продукт "<?= htmlspecialchars($product['name']) ?>" из категории "<?= htmlspecialchars($product['category']) ?>"</h1>
    <p>Цена: <?= $product['price'] ?>$, количество: <?= $product['quantity'] ?></p>
    <p>Стоимость (цена × количество): <strong><?= $cost ?>$</strong></p>
<?php endif; ?>
