<?php

class XprevController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
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
        $user = $this->_auth->getStorage()->read();
        /*fonction niveau0*/
        $fn0 = array(4,18,38);
        /* fonction niveau1*/
        $fn1 =array(1,2,6,43,44,46,26,27,28,29,30,34,35,36,37,40);
        /*fonction niveau2*/
        $fn2 = array(3,10,41,45,42);
        /*fonction niveau3*/
        $fn3 = array(32,23,50,39);
        $this->view->fonction = $user->id_fonction;
        $this->view->fn0 = $fn0;
        $this->view->fn1 = $fn1;
        $this->view->fn2 = $fn2;
        $this->view->fn3 = $fn3;
    }

    public function creationAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        echo '<pre>',  var_export($infoUser),'</pre>';
        $this->view->infoUser=$infoUser;
    }
}

