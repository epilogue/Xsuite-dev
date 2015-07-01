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
    
     /* on va chercher les infos  pour les dropdownlist*/
        $listsHolons = new Application_Model_DbTable_Holons();
        $listHolon = $listsHolons->allHolon();
        $this->view->listHolon=$listHolon;
        $listsZones = new Application_Model_DbTable_Zones();
        $listZone = $listsZones->allZone();
        $this->view->listZone=$listZone;
        $listsFonctions = new Application_Model_DbTable_Fonctions();
        $listFonction = $listsFonctions->allFonction();
        $this->view->listFonction=$listFonction;
     echo '<pre>',  var_export($listFonction),'</pre>';
      echo '<pre>',  var_export($listZone),'</pre>';
       echo '<pre>',  var_export($listHolon),'</pre>';

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $users = new Application_Model_DbTable_Users();
                $user = $users->createFromForm($form);
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
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

