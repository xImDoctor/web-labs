<?php
	namespace Project\Controllers;
	use \Core\Controller;
	use \Project\Models\Hello;
	
	class HelloController extends Controller
	{
		public function index() {
			$this->title = 'Фреймворк работает!';
			
			$hello = new Hello; // тестовая модель для проверки базы
			
			return $this->render('hello/index');
		}
	}
