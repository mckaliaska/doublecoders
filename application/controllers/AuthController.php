<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         
    }

    public function logoutAction()
    {
    // уничтожаем информацию об авторизации пользователя
    Zend_Auth::getInstance()->clearIdentity();
     
    // и отправляем его на главную
    $this->_helper->redirector('index', 'index');
    }

    public function loginAction()
    {
        // проверяем, авторизирован ли пользователь
    if (Zend_Auth::getInstance()->hasIdentity()) {
        // если да, то делаем редирект, чтобы исключить многократную авторизацию
        $this->_helper->redirector('index', 'index');
        
    }
     
    // создаём форму и передаём её во view
    $form = new Application_Form_Login();
    $this->view->form = $form;
     
    // Если к нам идёт Post запрос
    if ($this->getRequest()->isPost()) {
        // Принимаем его
        $formData = $this->getRequest()->getPost();
         
        // Если форма заполнена верно
        if ($form->isValid($formData)) {
            // Получаем адаптер подключения к базе данных
            $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
             
            // указываем таблицу, где необходимо искать данные о пользователях
            // колонку, где искать имена пользователей,
            // а также колонку, где хранятся пароли
            $authAdapter->setTableName('users')
                ->setIdentityColumn('name')
                ->setCredentialColumn('password');
             
            // получаем введённые данные
            $username = $this->getRequest()->getPost('username');
            $password = $this->getRequest()->getPost('password');
             
            // подставляем полученные данные из формы
            $authAdapter->setIdentity($username)
                ->setCredential($password);
             
            // получаем экземпляр Zend_Auth
            $auth = Zend_Auth::getInstance();
             
            // делаем попытку авторизировать пользователя
            $result = $auth->authenticate($authAdapter);
             
            // если авторизация прошла успешно
            if ($result->isValid()) {
                // используем адаптер для извлечения оставшихся данных о пользователе
                $identity = $authAdapter->getResultRowObject();
                
                // получаем доступ к хранилищу данных Zend
                $authStorage = $auth->getStorage();
                 
                // помещаем туда информацию о пользователе,
                // чтобы иметь к ним доступ при конфигурировании Acl
                $authStorage->write($identity);
                $identity->role;
                //Zend_Debug::dump($identity);
                
                // Используем библиотечный helper для редиректа
                // на controller = admin, action = redact
                if($identity->role == "guide"){
                   $this->_helper->redirector('most', 'guid');
                }
                
            } 
            else {
                    //$this->_helper->redirector('sign', 'help');
                    $this->view->errMessage = 
                    '<div class="alert">
                        <button type="button" class="close" 
                        data-dismiss="alert">&times;</button>
                        <strong>Предупреждение! </strong> 
                    Вы ввели неверное имя пользователя или неверный пароль
                    </div>';
                            
                }
        }
    }
    }


}





