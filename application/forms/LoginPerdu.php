<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_LoginPerdu extends Zend_Form {

    public function init() {
        $this->setName("loginperdu");
        $this->setMethod('post');
        $this->addElement('text', 'email_user', array(
            'label' => "entrez votre adresse mail:",
            'required' => false));
        $this->addElement('submit', 'submit' ,array(
            'ignore' => true,
            'class'=>'submit',
            'label' => 'récupérer'));
    }
}