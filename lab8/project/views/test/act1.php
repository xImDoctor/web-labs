<!-- 
    Представление для TestController::act1()
-->

<div class="card">
    <div class="card-header">
        <?= htmlspecialchars($message) ?>
    </div>
    <div class="card-body">
        <p><?= htmlspecialchars($description) ?></p>
        <p><strong>Временная метка:</strong> <?= htmlspecialchars($timestamp) ?></p>
    </div>
</div>

<div class="info-block">
    <h3>Информация о действии</h3>
    <ul>
        <li><strong>Контроллер:</strong> TestController</li>
        <li><strong>Действие:</strong> act1</li>
        <li><strong>URL:</strong> <code>/test/act1/</code></li>
        <li><strong>Файл представления:</strong> <code>/project/views/test/act1.php</code></li>
    </ul>
</div>

<div class="navigation">
    <h4>Другие действия TestController:</h4>
    <ul>
        <li><a href="/test/act2/">Действие act2</a></li>
        <li><a href="/test/act3/">Действие act3</a></li>
    </ul>
</div>
