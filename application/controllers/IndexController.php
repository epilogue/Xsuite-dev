<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        /* @todo commentaire
         * Exemple d'authentification forcée pour toutes les actions de ce controlleur
         */
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        if (is_null($user)) {
            $this->_helper->redirector('index', 'login');
        } else {
            /* @todo commentaire 
             * Et donc, ici, on peut faire de l'acl de manière plus fine
             */
        }
    }

    public function indexAction() {
        // action body
    }

}

