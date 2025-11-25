<?php
	namespace Core;

	require_once __DIR__ . '/../project/config/SECRETS.php';

	class Model
	{
		private static $link;
		
		public function __construct()
		{
			if (!self::$link) {
				self::$link = mysqli_connect(\BD_HOST, \BD_USER, \BD_PASS, \BD_NAME);
				mysqli_query(self::$link, "SET NAMES 'utf8'");
			}
		}
		
		protected function findOne($query)
		{
			$result = mysqli_query(self::$link, $query) or die(mysqli_error(self::$link));
			return mysqli_fetch_assoc($result);
		}
		
		protected function findMany($query)
		{
			$result = mysqli_query(self::$link, $query) or die(mysqli_error(self::$link));
			for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
			
			return $data;
		}
	}
