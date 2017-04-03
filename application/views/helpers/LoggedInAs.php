<?php
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract 
{
    public function loggedInAs ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $nom_user = $auth->getIdentity()->nom_user;        
            $prenom_user =$auth->getIdentity()->prenom_user;
            if($auth->getIdentity()->id_fonction==39){
            $logoutUrl = $this->view->url(array('controller'=>'login', 'action'=>'logout'), null, true);
            $adminis = $this->view->url(array('controller'=>'administration','action'=>'index'),null, true);
            return 'Bienvenue ' . $prenom_user .' . <a href="'.$logoutUrl.'">Déconnexion</a>. <br/><br/> <a href="'.$adminis.'">Administration</a>';
            } 
            else{
               $logoutUrl = $this->view->url(array('controller'=>'login', 'action'=>'logout'), null, true); 
               return 'Bienvenue ' . $prenom_user .' . <a href="'.$logoutUrl.'">Déconnexion</a>';
            }

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        if($controller == 'login' && $action == 'index') {
            return '';
        }
        $loginUrl = $this->view->url(array('controller'=>'login', 'action'=>'index'));
        return '<a href="'.$loginUrl.'">Connexion</a>';
    }
}
}