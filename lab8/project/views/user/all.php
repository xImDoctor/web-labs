<p>Всего пользователей: <strong><?= $total ?></strong></p>

<div class="grid">
    <?php foreach ($users as $id => $user): ?>
        <div class="user-card">
            <h3><?= htmlspecialchars($user['name']) ?></h3>
            <p><strong>ID:</strong> <?= $id ?></p>
            <p><strong>Возраст:</strong> <?= $user['age'] ?></p>
            <p><strong>Зарплата:</strong> $<?= number_format($user['salary'], 0, '', ' ') ?></p>
            <p><a href="<?= BASE_PATH ?>/user/<?= $id ?>/" class="btn">Подробнее</a></p>
        </div>
    <?php endforeach; ?>
</div>
