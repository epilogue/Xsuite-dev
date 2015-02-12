<?php

class Xsuite_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

    /**
     *
     * @var Zend_Auth
     */
    private $_auth;

    /**
     *
     * @var Zend_Acl
     */
    private $_acl;

    /**
     * échec d'authentification
     */
    const FAIL_AUTH_CONTROLLER  = 'login';
//    const FAIL_AUTH_ACTION      = 'authfail';
    const FAIL_AUTH_ACTION      = 'index';

    /**
     * échec d'attribution de privilèges
     */
    const FAIL_ACL_CONTROLLER  = 'login';
    const FAIL_ACL_ACTION      = 'aclfail';

    /**
     * Constructeur
     *
     * @param Zend_Acl $acl
     */
    public function __construct(Zend_Acl $acl) {
        $this->_acl = $acl;
        $this->_auth = Zend_Auth::getInstance();
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        // est-ce que l'utilisateur est authentifié ?
        $debug = (APPLICATION_ENV == "development")?true:false;
        
        if($this->_auth->hasIdentity()) {
            $user = $this->_auth->getStorage()->read();
//            echo '<pre>',  var_export($user, true),'</pre>';
            $role = $user->niveau;
            $sAuth = new Zend_Session_Namespace('sAuth');
            $sAuth->setExpirationSeconds((int)3600);
        } else {
            $role = 'public';
        }

        $controller = $request->getControllerName();
        $action = $request->getActionName();

        // nommage de la ressource
        $ressource = $controller;
        

        // est-ce que la ressource existe ?
        if(!$this->_acl->has($ressource)) {
            $ressource = null;
        }

        // est-ce que l'utilisateur est authorisé ?
        if(!$this->_acl->isAllowed($role, $ressource, $action)) {
            // non on redirige
            if(!$this->_auth->hasIdentity()) {
                // pas identifié
                $controller = self::FAIL_AUTH_CONTROLLER;
                $action = self::FAIL_AUTH_ACTION;
            } else {
                // erreur de privilèges
                $controller = self::FAIL_ACL_CONTROLLER;
                $action = self::FAIL_ACL_ACTION;
            }
        }
        $request->setControllerName($controller);
        $request->setActionName($action);
    }

}