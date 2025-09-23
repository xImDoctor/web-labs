<?php
declare(strict_types=1);
namespace MyProject\Classes;

class User extends AbstractUser
{

    public $name;
    public $login;
    private $password;

    /**
     * Конструктор класса User.
     *
     * @param string $name Имя пользователя.
     * @param string $login Логин пользователя.
     * @param string $password Пароль пользователя.
     */
    public function __construct($name, $login, $password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Выводит информацию о пользователе.
     *
     * @return string - Возвращает строкой HTML-блок с информацией о пользователе
     */
    public function showInfo(): string   {
        return "<div class=\"user-info\">
                    <h3>User Info</h3>
                    <p><strong>Name:</strong> {$this->name}</p>
                    <p><strong>Login:</strong> {$this->login}</p>
                </div>";
    }   

    /**
     * Деструктор класса User.
     * Выводит сообщение об удалении пользователя.
     */
    public function __destruct()
    {
        echo "<p>Пользователь {$this->login} удален.</p>";
    }
}
