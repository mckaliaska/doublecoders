<?php

class Application_Model_DbTable_Excursion extends Zend_Db_Table_Abstract
{
    // Имя таблицы, с которой будем работать
    protected $_name = 'excursions';
    
        // Метод для получения записи по id
    public function getExcursion($id)
    {
        // Получаем id как параметр
        $id = (int)$id;
 
        // Используем метод fetchRow для получения записи из базы.
        // В скобках указываем условие выборки (привычное для вас where)
        $row = $this->fetchRow('id = ' . $id);
 
        // Если результат пустой, выкидываем исключение
        if(!$row) {
            throw new Exception("Нет записи с id - $id");
        }
        // Возвращаем результат, упакованный в массив
        return $row->toArray();
    }

}

