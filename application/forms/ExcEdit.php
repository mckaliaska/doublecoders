<?php

class Application_Form_ExcEdit extends Zend_Form
{

    public function init()
    {        
        // указываем имя формы
        $this->setName('excEdit');
         
        // сообщение о незаполненном поле
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';
         
        // создаём текстовый элемент
        $name = new Zend_Form_Element_Text('name');
         
        // отмечаем как обязательное поле;
        // также добавляем фильтры и валидатор с переводом
        $name->setRequired(true)
            //->setAttrib('id','editText') 
            ->setAttrib('value',$name)    
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
        
        // добавляем элементы в форму
        $this->addElements(array($name));
         
        // указываем метод передачи данных
        $this->setMethod('post');
    }


}

