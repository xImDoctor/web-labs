<?php
spl_autoload_register();

use MVC\Controllers\Controller;

//$obj = new Controller('users.rss');
$obj = new Controller('users/0.html');
echo $obj->render();

// под markdown
$mdController = new Controller('users.md');
$mdUserController = new Controller('users/0.md');

echo "<pre>";
echo $mdController->render();
echo "</pre><hr><pre>";
echo $mdUserController->render();
echo "</pre>";