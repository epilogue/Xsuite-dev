<?php

class Application_Form_Login extends Zend_Form {

    public function init() {
        $this->setName("login");
        $this->setMethod('post');
        $this->addElement(
                'text', 'email_user', array(
            'label' => "nom d'utilisateur :",
            'required' => true));

        $this->addElement('password', 'password_user', array(
            'label' => 'mot de passe :',
            'required' => true));
        $this->addElement('submit', 'submit' ,array(
            'ignore' => true,
            'class'=>'submit',
            'label' => 'connexion'));
    }

}

