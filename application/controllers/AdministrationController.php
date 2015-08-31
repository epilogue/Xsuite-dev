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
    

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
               if($formData['fonction'] == 1 | $formData['fonction'] ==2 | $formData['fonction'] ==14 | $formData['fonction'] ==33){ $niveau ="niveau1";}
               elseif ($formData['fonction'] == 10) { $niveau="niveau2";}
               elseif ($formData['fonction'] ==6 | $formData['fonction'] ==26 | $formData['fonction'] ==27 | $formData['fonction'] ==35 | $formData['fonction'] ==37 | $formData['fonction'] ==30 | $formData['fonction'] ==29 | $formData['fonction'] ==34) {$niveau="niveau3";}
               elseif($formData['fonction'] ==32 | $formData['fonction'] ==23){ $niveau="niveau4";}
               elseif($formData['fonction'] == 5 | $formData['fonction'] ==13 | $formData['fonction'] ==38){ $niveau="niveau5";}
               elseif ($formData['fonction'] == 39) { $niveau="niveau6";}
               
                $users = new Application_Model_DbTable_Users();
        $user = $users->createUser($formData['nom'], $formData['prenom'], $formData['tel'], $formData['email'], $formData['matricule'], $formData['userworkplace'],$formData['fonction'],$formData['zone'],$formData['holon'], $niveau);
                $this->_helper->redirector('index');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "Votre demande a bien été enregistrée.";
                    $flashMessenger->addMessage($message);
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->gotoSimple('index', 'xprice');
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
    public function rechercheNomCompletion(){
        
        $malisteUsers=new Application_Model_DbTable_Users;
        $malisteUser=$malisteUsers->rechercheUserCompletion();
        
    }
}

