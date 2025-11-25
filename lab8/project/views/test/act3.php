<div class="card">
    <div class="card-header"><?= htmlspecialchars($message) ?></div>
    <div class="card-body">
        <p><?= htmlspecialchars($description) ?></p>
        <h4>Данные:</h4>
        <ul>
            <?php foreach ($data['features'] as $feature): ?>
                <li><?= htmlspecialchars($feature) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
