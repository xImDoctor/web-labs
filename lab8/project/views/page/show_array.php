<?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php else: ?>
    <h1><?= htmlspecialchars($page['title']) ?></h1>
    <p><?= htmlspecialchars($page['text']) ?></p>
<?php endif; ?>
