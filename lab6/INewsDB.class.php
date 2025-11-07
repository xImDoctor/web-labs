<?php
/**
 *	inerface INewsDB
 *	содержит основные методы для работы с новостной лентой
*/
interface INewsDB{
	/**
	 *	Добавление новой записи в новостную ленту
	 *
	 *	@param string $title - заголовок новости
	 *	@param string $category - категория новости
	 *	@param string $description - текст новости
	 *	@param string $source - источник новости
	 *
	 *	@return boolean - результат успех/ошибка
	*/
	function saveNews($title, $category, $description, $source);

    /**
	 *	Выборка всех записей из новостной ленты
	 *
	 *	@return array - результат выборки в виде массива
	*/
	function getNews();

    /**
	 *	Удаление записи из новостной ленты
	 *
	 *	@param integer $id - идентификатор удаляемой записи
	 *
	 *	@return boolean - результат успех/ошибка
	*/
	function deleteNews($id);
}
?>
