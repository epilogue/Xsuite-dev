<?php

class Xsuite_Mail extends Zend_Mail {
    
    public function __construct($charset = 'UTF-8') {
        parent::__construct($charset);
        $emailFrom = Zend_Registry::get('emailFrom');
        $this->setFrom($emailFrom->address, $emailFrom->text);
    }
    
    public function send($transport = null) {
        if(is_null($transport)) {
            $transport = Zend_Registry::get('emailSender');
        }
        parent::send($transport);
    }
    
}
