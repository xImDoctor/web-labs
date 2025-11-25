<?php
/**
 * UserController - Контроллер для работы с пользователями
 * 
 * Задания II.3-7: Контроллер с массивом пользователей и различными действиями
 * Демонстрирует работу с массивами данных, параметрами URL и условной логикой
 * 
 * @package Project\Controllers
 */

namespace Project\Controllers;

use Core\Controller;

class UserController extends Controller
{
    /**
     * Массив пользователей
     * Задается в конструкторе для использования во всех действиях
     * 
     * @var array
     */
    private $users;
    
    /**
     * Конструктор
     * Инициализирует массив пользователей по II.3
     */
    public function __construct()
    {
        // Массив пользователей из задания
        $this->users = [
            1 => ['name'=>'user1', 'age'=>'23', 'salary' => 1000],
            2 => ['name'=>'user2', 'age'=>'24', 'salary' => 2000],
            3 => ['name'=>'user3', 'age'=>'25', 'salary' => 3000],
            4 => ['name'=>'user4', 'age'=>'26', 'salary' => 4000],
            5 => ['name'=>'user5', 'age'=>'27', 'salary' => 5000],
        ];
    }
    
    /**
     * Действие show - показывает информацию о пользователе по ID
     * Задание II.4
     * Доступно по адресу: /user/:id/
     * 
     * Примеры:
     * - /user/1/ → Информация о user1
     * - /user/3/ → Информация о user3
     * 
     * @param array $params Параметры из URL
     */
    public function show($params)
    {
        $id = (int)$params['id'];
        
        // Проверяем существование пользователя
        if (!isset($this->users[$id])) {
            $this->title = 'Пользователь не найден';
            return $this->render('user/show', [
                'error' => 'Пользователь с ID=' . $id . ' не найден',
                'user' => null
            ]);
        }
        
        $user = $this->users[$id];
        $this->title = 'Информация о пользователе ' . $user['name'];
        
        return $this->render('user/show', [
            'id' => $id,
            'user' => $user,
            'error' => null
        ]);
    }
    
    /**
     * Действие info - показывает конкретное поле пользователя
     * Задание II.5
     * Доступно по адресу: /user/:id/:key/
     * 
     * Где key может быть: name, age, salary
     * 
     * Примеры:
     * - /user/1/name/ → user1
     * - /user/2/age/ → 24
     * - /user/3/salary/ → 3000
     * 
     * @param array $params Параметры из URL
     */
    public function info($params)
    {
        $id = (int)$params['id'];
        $key = $params['key'];
        
        // Проверяем существование пользователя
        if (!isset($this->users[$id])) {
            $this->title = 'Пользователь не найден';
            return $this->render('user/info', [
                'error' => 'Пользователь с ID=' . $id . ' не найден',
                'value' => null,
                'key' => $key
            ]);
        }
        
        // Проверяем существование ключа
        if (!isset($this->users[$id][$key])) {
            $this->title = 'Поле не найдено';
            return $this->render('user/info', [
                'error' => "Поле '$key' не существует. Доступные поля: name, age, salary",
                'value' => null,
                'key' => $key
            ]);
        }
        
        $value = $this->users[$id][$key];
        $this->title = ucfirst($key) . ' пользователя ' . $this->users[$id]['name'];
        
        return $this->render('user/info', [
            'id' => $id,
            'key' => $key,
            'value' => $value,
            'user' => $this->users[$id],
            'error' => null
        ]);
    }
    
    /**
     * Действие all - показывает список всех пользователей
     * Задание II.6
     * Доступно по адресу: /user/all/
     * 
     * Выводит всех пользователей в удобочитаемом формате
     */
    public function all()
    {
        $this->title = 'Список всех пользователей';
        
        return $this->render('user/all', [
            'users' => $this->users,
            'total' => count($this->users)
        ]);
    }
    
    /**
     * Действие first - показывает первых N пользователей
     * Задание II.7
     * Доступно по адресу: /user/first/:n/
     * 
     * Примеры:
     * - /user/first/2/ → Первые 2 пользователя
     * - /user/first/4/ → Первые 4 пользователя
     * 
     * @param array $params Параметры из URL
     */
    public function first($params)
    {
        $n = (int)$params['n'];
        
        // Ограничиваем значение n количеством пользователей
        if ($n > count($this->users)) {
            $n = count($this->users);
        }
        
        // Получаем первых n пользователей
        $firstUsers = array_slice($this->users, 0, $n, true);
        
        $this->title = "Первые $n пользователей";
        
        return $this->render('user/first', [
            'users' => $firstUsers,
            'n' => $n,
            'total' => count($this->users)
        ]);
    }
}
