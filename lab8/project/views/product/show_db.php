<?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php else: ?>
    <div class="card">
        <div class="card-header">
            <?= htmlspecialchars($product['name']) ?>
        </div>
        <div class="card-body">
            <p><strong>Цена:</strong> $<?= number_format($product['price'], 2) ?></p>
            <p><strong>Количество:</strong> <?= $product['quantity'] ?></p>
            <p><strong>Стоимость:</strong> $<?= number_format($cost, 2) ?></p>
            <hr>
            <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        </div>
    </div>
<?php endif; ?>
