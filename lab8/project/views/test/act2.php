<div class="card">
    <div class="card-header"><?= htmlspecialchars($message) ?></div>
    <div class="card-body">
        <p><?= htmlspecialchars($description) ?></p>
        <p><strong>Счётчик:</strong> <?= $counter ?></p>
        <h4>Список:</h4>
        <ul>
            <?php foreach ($items as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
