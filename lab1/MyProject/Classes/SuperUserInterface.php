<?php
declare(strict_types=1);
namespace MyProject\Classes;

interface SuperUserInterface
{
    /**
     * Выводит информацию о пользователе в виде ассоциативного массива
     * 
     * @return array Ассоциативный массив с данными пользователя
     */
    public function getInfo(): array;
}