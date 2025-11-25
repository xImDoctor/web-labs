<?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php else: ?>
    <div class="card">
        <div class="card-header">
            <?= ucfirst($key) ?> пользователя <?= htmlspecialchars($user['name']) ?>
        </div>
        <div class="card-body">
            <p class="formula"><strong><?= htmlspecialchars($value) ?></strong></p>
        </div>
    </div>
<?php endif; ?>
