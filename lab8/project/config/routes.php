<?php
	use \Core\Route;
	
	return [
		new Route('/', 'hello', 'index'),
		new Route('/hello/', 'hello', 'index'), // роут для приветственной страницы, можно удалить
		new Route('/my-page1/', 'page', 'show1'),
		new Route('/my-page2/', 'page', 'show2'),
	];
	
