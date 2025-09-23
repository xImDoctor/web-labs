<?php
declare(strict_types=1);
namespace MyProject\Classes;


abstract class AbstractUser {

    /**
     * Абстрактный метод для отображения информации о пользователе
     * 
     * @return string HTML-строка с информацией о пользователе
     */
    abstract public function showInfo(): string;

}