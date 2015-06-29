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
    public function indexUserAction(){
        
    }
    public function createUserAction(){
    
    }
    public function updateUserAction(){
    
    }
    public function deleteUserAction(){
    
    }
    public function indexFonctionAction(){
        
    }
    public function createFonctionAction(){
    
    }
    public function updateFonctionAction(){
    
    }
    public function deleteFonctionAction(){
    
    }
    public function indexZoneAction(){
        
    }
    public function createZoneAction(){
    
    }
    public function updateZoneAction(){
    
    }
    public function deleteZoneAction(){
    
    }
    public function indexIndustrieAction(){
        
    }
    public function createIndustrieAction(){
    
    }
    public function updateIndustrieAction(){
    
    }
    public function deleteIndustrieAction(){
    
    }
    public function indexHolonAction(){
        
    }
    public function createHolonAction(){
    
    }
    public function updateHolonAction(){
    
    }
    public function deleteHolonAction(){
    
    }
    public function indexRequeteAction(){
        
    }
}

