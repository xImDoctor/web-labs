<h1><?= htmlspecialchars($h1) ?></h1>
<p>Всего страниц: <strong><?= $total ?></strong></p>

<div id="content">
    <table class="table-products">
        <tr>
            <th>id</th>
            <th>title</th>
            <th>ссылка</th>
        </tr>
        <?php foreach ($pages as $page): ?>
            <tr>
                <td><?= $page['id'] ?></td>
                <td><?= htmlspecialchars($page['title']) ?></td>
                <td><a href="<?= BASE_PATH ?>/page/<?= $page['id'] ?>/" class="btn">Открыть</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
