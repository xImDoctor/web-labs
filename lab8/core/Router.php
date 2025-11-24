<?php
	namespace Core;
	
	class Router
	{
		public function getTrack($routes, $uri)
		{
			foreach ($routes as $route) {
				$pattern = $this->createPattern($route->path); // см. описание метода
				
				/*
					Проверяем адрес URI на соответствие регулярке
					Если URI подойдет под регулярку, в $params будут параметры
				*/
				if (preg_match($pattern, $uri, $params)) {
					$params = $this->clearParams($params);  // очищаем параметры от элементов с числовыми ключами
					return new Track($route->controller, $route->action, $params);
				}
			}
			
			return new Track('error', 'notFound');
		}
		
		/*
			Метод преобразует путь из роута в регуляку,
			подставляя вместо параметров роута именованные карманы
			см. тут про такие карманы http://code.mu/ru/php/video/named-pockets-in-php-regulars/
		
			к примеру, из адреса '/test/:var1/:var2/' метод
			сделает регулярку '#^/test/(?<var1>[^/]+)/(?<var2>[^/]+)/?$#'
		*/
		private function createPattern($path)
		{
			return '#^' . preg_replace('#/:([^/]+)#', '/(?<$1>[^/]+)', $path) . '/?$#';
		}
		
		private function clearParams($params)
		{
			$result = [];
			
			foreach ($params as $key => $param) {
				if (!is_int($key)) {
					$result[$key] = $param;
				}
			}
			
			return $result;
		}
	}
	
	
