<p>Показано первых <strong><?= $n ?></strong> из <strong><?= $total ?></strong> пользователей</p>

<?php foreach ($users as $id => $user): ?>
    <div class="user-card">
        <h3>#<?= $id ?>: <?= htmlspecialchars($user['name']) ?></h3>
        <p>Возраст: <?= $user['age'] ?>, Зарплата: $<?= number_format($user['salary'], 0, '', ' ') ?></p>
    </div>
<?php endforeach; ?>
