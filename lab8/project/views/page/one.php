<?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php else: ?>
    <h1><?= htmlspecialchars($h1) ?></h1>
    <div id="content"><?= $text ?></div>
<?php endif; ?>

<div class="navigation">
    <p><a href="<?= BASE_PATH ?>/pages/">Вернуться к списку страниц</a></p>
</div>
