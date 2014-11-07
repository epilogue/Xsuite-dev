<?php

class UserController extends Zend_Controller_Action {

    public function indexAction() {
        $users = new Application_Model_DbTable_Users();
        $this->view->users = $users->fetchAll();
    }

    public function createAction() {

        $form = new Application_Form_User();
//        $form->submit->setLabel('Creer');
        $this->view->form = $form;

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

    public function updateAction() {
        $form = new Application_Form_User();
        $form->submit->setLabel('modifier');
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $users = new Application_Model_DbTable_Users();
                $users->updateFromForm($form);
                /* @todo commentaire franck
                 * Même concept que précédemment.
                 */
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
        /*
         * Si la requête n'est pas un post
         *  alors on récupère l'id est on rempli
         * le formulaire avec les éléments présents
         * dans la base de données'
         */ else {
            $id_user = $this->_getParam('id_user', 0);
            if ($id_user > 0) {
                $users = new Application_Model_DbTable_Users();
                $form->populate($users->getUser($id_user));
            }
        }

        /* après la validation du formulaire
         * on sauvegarde les données dans la bonne ligne de la bdd
         * cela est fait par la méthode updateUser() */
    }

    public function deleteAction() {

    }

}

