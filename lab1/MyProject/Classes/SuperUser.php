<?php
declare(strict_types=1);
namespace MyProject\Classes;

require_once 'User.php';

class SuperUser extends User
{
    public $role;

    /**
     * Конструктор класса SuperUser.
     * 
     * @param string $name Имя пользователя.
     * @param string $login Логин пользователя.
     * @param string $password Пароль пользователя.
     * @param string $role Роль суперпользователя.
     */
    public function __construct($name, $login, $password, $role)
    {
        parent::__construct($name, $login, $password);
        $this->role = $role;
    }

    /**
     * Возвращает HTML с информацией о суперпользователе.
     *
     * @return string
     */
    public function showInfo(): string  
    {
        return "<div class=\"super-user-info\">
                    <h3>Super User Info</h3>
                    <p><strong>Name:</strong> {$this->name}</p>
                    <p><strong>Login:</strong> {$this->login}</p>
                    <p><strong>Role:</strong> {$this->role}</p>
                </div>";
    }
}
