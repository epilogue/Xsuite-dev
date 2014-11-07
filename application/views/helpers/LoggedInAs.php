<?php
class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract 
{
    public function loggedInAs ()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $nom_user = $auth->getIdentity()->nom_user;
            $prenom_user =$auth->getIdentity()->prenom_user;
            $logoutUrl = $this->view->url(array('controller'=>'login', 'action'=>'logout'), null, true);
            return 'Bienvenue ' . $prenom_user .' '.$nom_user.  '. <a href="'.$logoutUrl.'">Déconnexion</a>';
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