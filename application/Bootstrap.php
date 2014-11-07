<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDoctype() {
        $this->_executeResource('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        
    }
    
    protected function _initAcl() {
//        $front =  $this->getResource('FrontController');
        $front = Zend_Controller_Front::getInstance();
        $acl = new Xsuite_Controller_Plugin_AuthAcl(APPLICATION_PATH.'/configs/autorisation.ini');
        Zend_Registry::set('AuthAcl', $acl);
        $plugin = new Xsuite_Controller_Plugin_Auth($acl);
        $front->registerPlugin($plugin);
        $sAuth = new Zend_Session_Namespace('sAuth');
        $sAuth->setExpirationSeconds(3600);
    }
    
    protected function _initMailsender() {
        date_default_timezone_set('Europe/Paris');
        $mailConfig = new Zend_Config_Ini(APPLICATION_PATH.'/configs/mail.ini');
        $email = $mailConfig->get('email');
        if(!is_null($email->authentification)) {
            $transport = new Zend_Mail_Transport_Smtp($email->smtp->server, $email->authentification->toArray());
        } else {
            $transport = new Zend_Mail_Transport_Smtp($email->smtp->server);
        }
        Zend_Registry::set("emailVars", $email->vars);
        Zend_Registry::set("emailSender", $transport);
        Zend_Registry::set("emailFrom", $email->sender);
    }
    
    protected function _initMovexConnect() {
        $movexConfig = new Zend_Config_Ini(APPLICATION_PATH.'/configs/movexConnect.ini');
        $movexC = $movexConfig->get('movex');
        $connexionConfig = $movexC->get('connection')->toArray();
        foreach ($connexionConfig as $key => $value) {
            Zend_Registry::set("{$key}", null);
            $connexionString = "";
            foreach ($value as $subKey => $subValue) {
                $connexionString .= "{$subKey}={$subValue};";
            }
            Zend_Registry::set("{$key}String", $connexionString);
            
        }
        
    }
    
}

