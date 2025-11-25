<?php
/**
 * NumController - Контроллер для работы с числами
 * 
 * Задание II.2: Контроллер с действием sum для сложения трех чисел
 * Принимает параметры из URL и выполняет вычисления
 * 
 * @package Project\Controllers
 */

namespace Project\Controllers;

use Core\Controller;

class NumController extends Controller
{
    /**
     * Действие sum - вычисляет сумму трех чисел из URL
     * Доступно по адресу: /nums/:n1/:n2/:n3/
     * 
     * Примеры использования:
     * - /nums/5/10/15/ -> Сумма: 30
     * 
     * @param array $params Массив параметров из URL
     *                      $params['n1'] - первое число
     *                      $params['n2'] - второе число
     *                      $params['n3'] - третье число
     */
    public function sum($params)
    {
        // Получаем числа из параметров URL и приводим к целому типу
        $n1 = (int)$params['n1'];
        $n2 = (int)$params['n2'];
        $n3 = (int)$params['n3'];
        
        // Вычисляем сумму
        $sum = $n1 + $n2 + $n3;
        
        // Устанавливаем заголовок с результатом
        $this->title = "Сумма чисел $n1, $n2 и $n3";
        
        // Рендерим представление с данными
        return $this->render('num/sum', [
            'n1' => $n1,
            'n2' => $n2,
            'n3' => $n3,
            'sum' => $sum,
            'formula' => "$n1 + $n2 + $n3 = $sum"
        ]);
    }
}
