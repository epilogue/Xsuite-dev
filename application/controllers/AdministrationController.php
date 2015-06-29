<?php

class AdministrationController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        //$layout->setLayoutPath(APPLICATION_PATH . 'layouts/scripts');
        $this->_helper->_layout->setLayout('admin_layout');
        if (is_null($user)) {
            $this->_helper->redirector('index', 'login');
        } else {
            /* @todo commentaire franck
             * Et donc, ici, on peut faire de l'acl de manière plus fine
             */
        }
    }

    public function indexAction()
    {
        // action body
    }
    public function indexuserAction(){
        
    }
    public function createuserAction(){
    
    }
    public function updateuserAction(){
    
    }
    public function deleteuserAction(){
    
    }
    public function indexfonctionAction(){
        
    }
    public function createfonctionAction(){
    
    }
    public function updatefonctionAction(){
    
    }
    public function deletefonctionAction(){
    
    }
    public function indexzoneAction(){
        
    }
    public function createzoneAction(){
    
    }
    public function updatezoneAction(){
    
    }
    public function deletezoneAction(){
    
    }
    public function indexindustrieAction(){
        
    }
    public function createindustrieAction(){
    
    }
    public function updateindustrieAction(){
    
    }
    public function deleteindustrieAction(){
    
    }
    public function indexholonAction(){
        
    }
    public function createholonAction(){
    
    }
    public function updateholonAction(){
    
    }
    public function deleteholonAction(){
    
    }
    public function indexrequeteAction(){
        
    }
}

