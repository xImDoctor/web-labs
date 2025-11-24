<?php
	namespace Core;
	
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/connection.php';
	
	spl_autoload_register(function($class) {
		preg_match('#(.+)\\\\(.+?)$#', $class, $match);
		
		$nameSpace = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($match[1]));
		$className = $match[2];
		
		$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $nameSpace . DIRECTORY_SEPARATOR . $className . '.php';
		
		if (file_exists($path)) {
			require_once $path;
			
			if (class_exists($class, false)) {
				return true;
			} else {
				throw new \Exception("Класс $class не найден в файле $path. Проверьте правильность написания имени класса внутри указанного файла.");
			}
		} else {
			throw new \Exception("Для класса $class не найден файл $path. Проверьте наличие файла по указанному пути. Убедитесь, что пространство имен вашего класса совпадает с тем, которое пытается найти фреймворк для данного класса. Например, вы создаете класса модели, но забыли заюзать ее через use. В этом случае вы пытаетесь вызвать класс модели в пространстве имен контроллера, а такого файла нет.");
		}
	});
	
	$routes = require $_SERVER['DOCUMENT_ROOT'] . '/project/config/routes.php';
	
	$track = ( new Router )      -> getTrack($routes, $_SERVER['REQUEST_URI']);
	$page  = ( new Dispatcher )  -> getPage($track);
	
	echo (new View) -> render($page);
