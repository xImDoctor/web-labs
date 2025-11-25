<?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php else: ?>
    <div class="user-card">
        <h3>Пользователь #<?= $id ?></h3>
        <p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Возраст:</strong> <?= htmlspecialchars($user['age']) ?></p>
        <p><strong>Зарплата:</strong> $<?= number_format($user['salary'], 0, '', ' ') ?></p>
    </div>
<?php endif; ?>

<div class="navigation">
    <h4>Навигация:</h4>
    <ul>
        <li><a href="/user/all/">Все пользователи</a></li>
        <li><a href="/user/<?= $id ?? 1 ?>/name/">Имя</a></li>
        <li><a href="/user/<?= $id ?? 1 ?>/age/">Возраст</a></li>
    </ul>
</div>
