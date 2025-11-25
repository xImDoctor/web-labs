<div class="card">
    <div class="card-header">Вычисление суммы трех чисел</div>
    <div class="card-body">
        <div class="formula">
            <?= $n1 ?> + <?= $n2 ?> + <?= $n3 ?> = <strong><?= $sum ?></strong>
        </div>
        <p><strong>Формула:</strong> <?= htmlspecialchars($formula) ?></p>
    </div>
</div>

<div class="info-block">
    <h3>Примеры:</h3>
    <ul>
        <li><a href="<?= BASE_PATH ?>/nums/1/2/3/">/nums/1/2/3/</a> → Сумма: 6</li>
        <li><a href="<?= BASE_PATH ?>/nums/10/20/30/">/nums/10/20/30/</a> → Сумма: 60</li>
    </ul>
</div>
