<?php

class XsdbController extends Zend_Controller_Action
{

    public function init()
    {
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
        // action body
    }


}

