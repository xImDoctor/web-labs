<?php
declare(strict_types=1);

/**
 * Класс NumbersSquared
 * Итератор для последовательности чисел, возводящий их в квадрат
 * Реализует интерфейс Iterator из SPL
 */
class NumbersSquared implements Iterator {
    /**
     * Первое число последовательности
     * @var int
     */
    private int $start;
    
    /**
     * Последнее число последовательности
     * @var int
     */
    private int $end;
    
    /**
     * Текущее число в итерации
     * @var int
     */
    private int $current;
    
    /**
     * Конструктор класса
     * 
     * @param int $start Начальное число последовательности
     * @param int $end Конечное число последовательности
     */
    public function __construct(int $start, int $end) {
        $this->start = $start;
        $this->end = $end;
        $this->current = $start;
    }
    
    /**
     * Перемотка итератора к первому элементу
     * Вызывается в начале foreach
     * 
     * @return void
     */
    public function rewind(): void {
        $this->current = $this->start;
    }
    
    /**
     * Проверка валидности текущей позиции
     * 
     * @return bool true если текущая позиция валидна, false если достигнут конец
     */
    public function valid(): bool {
        return $this->current <= $this->end;
    }
    
    /**
     * Переход к следующему элементу
     * 
     * @return void
     */
    public function next(): void {
        $this->current++;
    }
    
    /**
     * Возврат ключа текущего элемента
     * 
     * @return int Текущее число (не квадрат)
     */
    public function key(): int {
        return $this->current;
    }
    
    /**
     * Возврат значения текущего элемента
     *
     * @return int Квадрат текущего числа
     */
    public function current(): int {
        return $this->current * $this->current;
    }
}

// Демонстрация работы класса NumbersSquared
echo "<h2>Демонстрация работы класса NumbersSquared</h2>\n";
echo "<p>Создание объекта: \$obj = new NumbersSquared(3, 7);</p>\n";
echo "<pre>\n";

$obj = new NumbersSquared(3, 7);
foreach($obj as $num => $square) {
    echo "Квадрат числа $num = $square\n";
}

echo "</pre>\n";
