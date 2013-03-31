<?php

class ExcursionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function editAction()
    {   $excursId = $this->_getParam('id', 0);
        $excursion = new Application_Model_DbTable_Excursion();
        $excursion = $excursion->getExcursion($excursId);
        $this->view->excursion = $excursion;
        //echo;
        //$form = new Application_Form_ExcEdit($excursion['name']);
        //$this->view->form = $form;
    }


}



