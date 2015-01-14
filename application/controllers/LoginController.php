<?php

class LoginController extends Zend_Controller_Action {

    public function aclfailAction() {
        
    }
    
    public function indexAction() {
       
        $loginForm = new Application_Form_Login();
        $request = $this->getRequest();
        $url=$this->getRequest()->getRequestUri();
 //echo '<pre>',var_export($url),'</pre>';exit();
        if ($request->isPost()) {
            if ($loginForm->isValid($request->getPost())) {
                if ($this->_process($loginForm->getValues())) {
                    if(isset($url)and $url!="/login"){
                    $this->_redirect( $url);
                    }
                    else{
                        $this->_helper->redirector('index', 'index');
                       
       }
                } // else message d'erreur de login mot de passe
            }
        }

        $this->view->form = $loginForm;
    }
     

    protected function _process($values) {
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['email_user']);
        $adapter->setCredential($values['password_user']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }

    protected function _getAuthAdapter() {

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                ->setIdentityColumn('email_user')
                ->setCredentialColumn('password_user');

        return $authAdapter;
    }

   
public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index'); // back to login page
    }
}

