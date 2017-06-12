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
        $fn1 =array(1,2,4,6,43,44,46,26,27,28,229,30);
        $this->view->fonction = $user->id_fonction;
        $this->view->fn1 = $fn1;
    }


}

