<?php
	namespace Core;
	
	class Page
	{
		private $layout;
		private $title;
		private $view;
		private $data;
		
		public function __construct($layout, $title = '', $view = null, $data = [])
		{
			$this->layout = $layout;
			$this->title  = $title;
			$this->view   = $view;
			$this->data   = $data;
		}
		
		public function __get($property)
		{
			return $this->$property;
		}
	}
