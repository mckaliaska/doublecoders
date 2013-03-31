<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAcl()
    {
        // Создаём объект Zend_Acl
        $acl = new Zend_Acl();
         
        // Добавляем ресурсы нашего сайта,
        // другими словами указываем контроллеры и действия
         
        // указываем, что у нас есть ресурс index
        $acl->addResource('index');

        // указываем, что у нас есть ресурс error
        $acl->addResource('error');
         
        // указываем, что у нас есть ресурс auth
        $acl->addResource('auth');
        
       // ресурс error является потомком ресурса error
       // $acl->addResource('error', 'error');
         
        // ресурс login является потомком ресурса auth
        $acl->addResource('login', 'auth');
         
        // ресурс logout является потомком ресурса auth
        $acl->addResource('logout', 'auth');
        
        $acl->addResource('help');
        $acl->addResource('sign', 'help');
        $acl->addResource('guid');
        $acl->addResource('most', 'guid');
        $acl->addResource('excursion');
        $acl->addResource('edit', 'excursion');
        // гость (неавторизированный пользователь)
        $acl->addRole('guest');
         
        // администратор, который наследует доступ от гостя
        $acl->addRole('guide','guest');       

        // разрешаем гостю просматривать ресурс index
        $acl->allow('guest', 'index', array('index'));
         $acl->allow('guest', 'error');
        // разрешаем гостю просматривать ресурс auth и его подресурсы
        $acl->allow('guest', 'auth', array('login', 'logout'));
        $acl->allow('guest', 'help', array('sign'));
        $acl->allow('guide', 'guid', array('most', 'get'));
        $acl->allow('guide', 'excursion', array('edit'));
        $fc = Zend_Controller_Front::getInstance();
         
        // регистрируем плагин с названием AccessCheck, в который передаём
        // на ACL и экземпляр Zend_Auth
        $fc->registerPlugin(new Application_Plugin_AccessCheck($acl, Zend_Auth::getInstance()));
    }
}

