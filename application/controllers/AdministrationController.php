<?php

class AdministrationController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
         $this->view->messages = $this->_helper->flashMessenger->getMessages();
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
        $malisteUsers=new Application_Model_DbTable_Users;
        $malisteUser=$malisteUsers->rechercheUserCompletion(); 
        $this->view->malisteUser = $malisteUser;
    }
    public function indexhierarchieAction(){
        $hierarchie = new Application_Model_DbTable_HierarchieXprev();
        $listehierarchienord = $hierarchie->affichehierarchienord(); 
        $listehierarchieest = $hierarchie->affichehierarchieest();
        $listehierarchieouest = $hierarchie->affichehierarchieouest();
        $listehierarchieouestsud = $hierarchie->affichehierarchieouestsud(); 
        $this->view->listehierarchienord = $listehierarchienord;
        $this->view->listehierarchieest = $listehierarchieest;
        $this->view->listehierarchieouest = $listehierarchieouest;
        $this->view->listehierarchieouestsud = $listehierarchieouestsud;
    }
    public function updatehierarchieAction(){
        $id_holon = $this->getRequest()->getParam('holon', null);
        $id_fonction = $this->getRequest()->getParam('fonction', null);
        $holons = new Application_Model_DbTable_Holons();
        $fonctions = new Application_Model_DbTable_Fonctions();
        $Holon = $holons->getHolon($id_holon);
        $Fonction =$fonctions->getFonction($id_fonction);
        $malisteUsers=new Application_Model_DbTable_Users;
        $malisteUser=$malisteUsers->rechercheUserCompletion(); 
        $hierarchie = new Application_Model_DbTable_HierarchieXprev();
        
        $this->view->holon=$Holon;
        $this->view->fonction=$Fonction;
        $this->view->malisteUser = $malisteUser;
         if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
             echo '<pre>', var_export($formData),'</pre>';
              if($formData['fonction']==3){
                  $niveau = "niveau1bis";
                  $fonctionn1 = 2;
                   $fonctionn2 = 0;
                 $data=array(
                     "id_user"=>$formData['user'],
                     "id_fonction"=>$formData['fonction'],
                     "id_holon"=>$formData['holon'],
                     "niveau"=>$niveau,
                     "fonctionn1"=>$fonctionn1,
                     "fonctionn2"=>$fonctionn2
                 );
                 echo '<pre>', var_export($data),'</pre>';
                 $uphierarchie= $hierarchie->uphierarchie($data); 
                 $upuser = $malisteUsers->updatefonctionuser($data);
                 exit();
              }
              elseif($formData['fonction']==10){
                 $niveau = "niveau3";
                 $fonctionn1 = 3;
                 $fonctionn2 = 6;
                 $data=array(
                     "id_user"=>$formData['user'],
                     "id_fonction"=>$formData['fonction'],
                     "id_holon"=>$formData['holon'],
                     "niveau"=>$niveau,
                     "fonctionn1"=>$fonctionn1,
                     "fonctionn2"=>$fonctionn2
                         
                 );
                 echo '<pre>', var_export($data),'</pre>';
                 $uphierarchie= $hierarchie->uphierarchie($data); 
                 $upuser = $malisteUsers->updatefonctionuser($data);
                 exit();
              }
         }
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
               if($formData['fonction'] == 1 | $formData['fonction'] ==2 | $formData['fonction'] ==14 | $formData['fonction'] ==43 | $formData['fonction'] ==46 |$formData['fonction'] ==33){ $niveau ="niveau1";}
               elseif ($formData['fonction'] == 44) { $niveau="niveau1bis";}
               elseif ($formData['fonction'] == 10) { $niveau="niveau2";}
               elseif ($formData['fonction'] ==6 |$formData['fonction'] ==41 |$formData['fonction'] ==42 | $formData['fonction'] ==45 | $formData['fonction'] ==26 | $formData['fonction'] ==27 | $formData['fonction'] ==35 | $formData['fonction'] ==37 | $formData['fonction'] ==30 | $formData['fonction'] ==29 | $formData['fonction'] ==34) {$niveau="niveau3";}
               elseif($formData['fonction'] ==32 | $formData['fonction'] ==23){ $niveau="niveau4";}
               elseif($formData['fonction'] == 5 | $formData['fonction'] ==13 | $formData['fonction'] ==38){ $niveau="niveau5";}
               elseif ($formData['fonction'] == 39) { $niveau="niveau6";}
               $User = new Application_Model_DbTable_Users;
//              echo '<pre>', var_export($User),'</pre>';
               $Mailuser=$User->getPassword($formData['email']);
//              echo '<pre>', var_export($Mailuser),'</pre>'; exit();
               if(!is_null($Mailuser)){
                   $redirector = $this->_helper->getHelper('Redirector');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "Cet utilisateur a déjà été créé.";
            $flashMessenger->addMessage($message);
            $redirector->gotoSimple('indexuser', 'administration');
               }else{
                $users = new Application_Model_DbTable_Users();
        $user = $users->createUser($formData['nom'], $formData['prenom'], $formData['tel'], $formData['email'], $formData['matricule'], $formData['userworkplace'],$formData['fonction'],$formData['zone'],$formData['holon'], $niveau);
                $this->_helper->redirector('index');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "Le nouvel utilisateur a bien été créé.";
                    $flashMessenger->addMessage($message);
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->gotoSimple('index', 'administration');
                }  
        }
    }
    public function updateuserAction(){
            $id_user = $this->getRequest()->getParam('user', null);
            $utilisateurs = new Application_Model_DbTable_Users();
            $utilisateur = $utilisateurs->getUser($id_user);
            $this->view->utilisateur = $utilisateur;
            $listsHolons = new Application_Model_DbTable_Holons();
            $listHolon = $listsHolons->allHolon();
            $this->view->listHolon=$listHolon;
            $listsZones = new Application_Model_DbTable_Zones();
            $listZone = $listsZones->allZone();
            $this->view->listZone=$listZone;
            $listsFonctions = new Application_Model_DbTable_Fonctions();
            $listFonction = $listsFonctions->allFonction();
            $this->view->listFonction=$listFonction;
            $holons=new Application_Model_DbTable_Holons();
             $holon=$holons->getHolon($utilisateur['id_holon']);
             $this->view->holon = $holon;
             $fonctions=new Application_Model_DbTable_Fonctions();
             $fonction=$fonctions->getFonction($utilisateur['id_fonction']);
             $this->view->fonction = $fonction;
             $zones=new Application_Model_DbTable_Zones();
             $zone=$zones->getZone($utilisateur['id_zone']);
             $this->view->zone = $zone;
             if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
//                echo '<pre>',  var_export($formData),'</pre>';                exit();
                
                if($formData['fonction'] == 1 | $formData['fonction'] ==2 | $formData['fonction'] ==14 | $formData['fonction'] ==33){ $niveau ="niveau1";}
               elseif ($formData['fonction'] == 10) { $niveau="niveau2";}
               elseif ($formData['fonction'] ==6 | $formData['fonction'] ==26 | $formData['fonction'] ==27 | $formData['fonction'] ==35 | $formData['fonction'] ==37 | $formData['fonction'] ==30 | $formData['fonction'] ==29 | $formData['fonction'] ==34) {$niveau="niveau3";}
               elseif($formData['fonction'] ==32 | $formData['fonction'] ==23){ $niveau="niveau4";}
               elseif($formData['fonction'] == 5 | $formData['fonction'] ==13 | $formData['fonction'] ==38){ $niveau="niveau5";}
               elseif ($formData['fonction'] == 39) { $niveau="niveau6";}
               $users = new Application_Model_DbTable_Users();
                $user = $users->updateUser($formData['user'],$formData['nom_user'], $formData['prenom_user'], $formData['tel_user'], $formData['email_user'], $formData['password_user'], $formData['numwp_user'],$formData['fonction'],$formData['zone'],$formData['holon'], $niveau);
                    $this->_helper->redirector('index');
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                        $message = "L'utilisateur a bien été modifié.";
                        $flashMessenger->addMessage($message);
                        $redirector = $this->_helper->getHelper('Redirector');
                        $redirector->gotoSimple('index', 'administration');
             }
    }
    public function consultuserAction(){
         $id_user = $this->getRequest()->getParam('user', null);
         $utilisateurs = new Application_Model_DbTable_Users();
         $utilisateur = $utilisateurs->getUser($id_user);
         $this->view->utilisateur = $utilisateur;
         $holons=new Application_Model_DbTable_Holons();
         $holon=$holons->getHolon($utilisateur['id_holon']);
         $this->view->holon = $holon;
         $fonctions=new Application_Model_DbTable_Fonctions();
         $fonction=$fonctions->getFonction($utilisateur['id_fonction']);
         $this->view->fonction = $fonction;
         $zones=new Application_Model_DbTable_Zones();
         $zone=$zones->getZone($utilisateur['id_zone']);
         $this->view->zone = $zone;
    }
    public function indexfonctionAction(){
         $malisteFonctions=new Application_Model_DbTable_Fonctions();
         $malisteFonction=$malisteFonctions->allFonction(); 
         $this->view->malisteFonction = $malisteFonction;
    }
    public function createfonctionAction(){
    
         if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $fonctions= new Application_Model_DbTable_Fonctions();
            $fonction= $fonctions->createFonction($formData['nom_fonction'], $formData['description_fonction']);
            $this->_helper->redirector('index');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "Votre demande a bien été enregistrée.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'administration');
        }
    }
    public function updatefonctionAction(){
        $id_fonction = $this->getRequest()->getParam('fonction', null);
        $fonctions = new Application_Model_DbTable_Fonctions();
        $fonction = $fonctions->getFonction($id_fonction);
        $this->view->fonction = $fonction;
        $listsFonctions = new Application_Model_DbTable_Fonctions();
        $listFonction = $listsFonctions->allFonction();
        $this->view->listFonction=$listFonction;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $fonctions= new Application_Model_DbTable_Fonctions();
            $fonction= $fonctions->updateFonction($formData['fonction'],$formData['nom_fonction'],$formData['description_fonction']);
            $this->_helper->redirector('index');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "La fonction a bien été modifiée.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index','administration');
        
        }
    }
    public function consultfonctionAction(){
        $id_fonction = $this->getRequest()->getParam('fonction', null);
        $fonctions = new Application_Model_DbTable_Fonctions();
        $fonction = $fonctions->getFonction($id_fonction);
        $this->view->fonction = $fonction;
    }
    public function indexzoneAction(){
         $zones = new Application_Model_DbTable_Zones();
         $zone = $zones->allZone();
         $this->view->malisteZone = $zone;
    }
    public function createzoneAction(){
        if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                $zones= new Application_Model_DbTable_Zones();
                $zone= $zones->createZone($formData['nom_zone'], $formData['description_zone']);
                $this->_helper->redirector('index');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "Votre demande a bien été enregistrée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'administration');
        }
    }
    public function updatezoneAction(){
        $id_zone = $this->getRequest()->getParam('zone', null);
        $zones = new Application_Model_DbTable_Zones();
        $zone = $zones->getZone($id_zone);
        $this->view->zone = $zone;
        $listsZones = new Application_Model_DbTable_Zones();
        $listZone = $listsZones->allZone();
        $this->view->listZone=$listZone;
        if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                $zones= new Application_Model_DbTable_Zones();
                $zone= $zones->updateZone($formData['zone'],$formData['nom_zone'], $formData['description_zone']);
                $this->_helper->redirector('index');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "Vla zone  a bien été modifiée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'administration');
        }
    }
    public function consultzoneAction(){
    $id_zone = $this->getRequest()->getParam('zone', null);
     $zones = new Application_Model_DbTable_Zones();
     $zone = $zones->getZone($id_zone);
     $this->view->zone = $zone;
    }
    public function indexindustrieAction(){
    
     $industrys = new Application_Model_DbTable_Industry();
     $industry = $industrys->allIndustry();
     $this->view->malisteIndustry = $industry;
    }
    public function createindustrieAction(){
    if ($this->getRequest()->isPost()) {
             $formData = $this->getRequest()->getPost();
             $industrys= new Application_Model_DbTable_Industry();
             $industry= $industrys->createIndustry($formData['nom_industry'],$formData['code_smc_industry'],$formData['code_movex_industry'], $formData['description_industry']);
             $this->_helper->redirector('index');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "La nouvelle Industrie a bien été enregistrée.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'administration');
        }
    }
    public function updateindustrieAction(){
     $id_industry = $this->getRequest()->getParam('industry', null);
     $industrys = new Application_Model_DbTable_Industry();
     $industry = $industrys->getIndustry($id_industry);
     $this->view->industry = $industry;
     $Codes= new Application_Model_DbTable_Industry();
     $code= $Codes->allCodeSmcIndustry();
     $this->view->codesmc=$code;
     $listsIndustrys = new Application_Model_DbTable_Industry();
     $listIndustry = $listsIndustrys->allIndustry();
     $this->view->listIndustry=$listIndustry;
//     echo '<pre>',  var_export($listIndustry),'</pre>';                exit();
     if ($this->getRequest()->isPost()) {
             $formData = $this->getRequest()->getPost();
//             echo '<pre>',  var_export($formData),'</pre>';                exit();
             $industrys= new Application_Model_DbTable_Industry();
             $industry= $industrys->updateIndustry($formData['industry'],$formData['nom_industry'],$formData['code_smc_industry'],$formData['code_movex_industry'], $formData['description_industry']);
             $this->_helper->redirector('index');
             $flashMessenger = $this->_helper->getHelper('FlashMessenger');
             $message = "L' Industrie a bien été modifiée.";
             $flashMessenger->addMessage($message);
             $redirector = $this->_helper->getHelper('Redirector');
             $redirector->gotoSimple('index', 'administration');
           
        }
    }
    public function consultindustrieAction(){
     $id_industry = $this->getRequest()->getParam('industry', null);
     $industrys = new Application_Model_DbTable_Industry();
     $industry = $industrys->getIndustry($id_industry);
     $this->view->industry = $industry;
    }
    public function indexholonAction(){
     $holons = new Application_Model_DbTable_Holons();
     $holon = $holons->allHolon();
     $this->view->malisteHolon = $holon;
    }
    public function createholonAction(){
    if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $holons= new Application_Model_DbTable_Holons();
            $holon= $holons->createHolon($formData['nom_holon'], $formData['description_holon']);
            $this->_helper->redirector('indexholon');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "Le nouvel Holon a bien été enregistré.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'administration');
        }
    }
    public function updateholonAction(){
        $id_holon = $this->getRequest()->getParam('holon', null);
        $holons = new Application_Model_DbTable_Holons();
        $holon = $holons->getHolon($id_holon);
        $this->view->holon = $holon;
        $listsHolons = new Application_Model_DbTable_Holons();
        $listHolon = $listsHolons->allHolon();
        $this->view->listHolon=$listHolon;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $holons= new Application_Model_DbTable_Holons();
            $holon= $holons->updateHolon($formData['holon'],$formData['nom_holon'], $formData['description_holon']);
            $this->_helper->redirector('indexholon');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "L' Holon a bien été modifié.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'administration');
        }
    }
    
    public function consultholonAction(){
     $id_holon = $this->getRequest()->getParam('holon', null);
     $holons = new Application_Model_DbTable_Holons();
     $holon = $holons->getHolon($id_holon);
     $this->view->holon = $holon;
    }
    public function indexrequeteAction(){
       $xprices=new Application_Model_DbTable_Xprices;
       $xprice = $xprices->totalXprice();
       
    }
    public function rechercheNomCompletion(){
        
        
    }
}

