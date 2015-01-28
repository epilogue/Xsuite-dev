<?php

class LoginController extends Zend_Controller_Action {

    public function aclfailAction() {
    }
    
    public function indexAction() {
       
        $loginForm = new Application_Form_Login();
        $request = $this->getRequest();
        $url=$this->getRequest()->getRequestUri();
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
    
    public function perduAction(){
         $this->view->messages = $this->_helper->flashMessenger->getMessages();
         $formperdu = new Application_Form_LoginPerdu();
          $email_user = $this->getRequest()->getParam('email_user', null);
         if ($this->getRequest()->isPost()) {
          if ($formperdu->isValid($this->getRequest()->getPost())){
             $mails= new Application_Model_DbTable_Users();
                $mail=$mails->getPassword($email_user);
//                echo '<pre>',var_export($mail),'</pre>';                exit();
                if(!is_null($mail) and $mail !== false){
                    $destmail=$mail->email_user;
                    
                    $corpsMails = "Bonjour,\n"
                                . "\n"
                                . "Voici votre identifiant :$mail->email_user.\n"
                                . "et votre mot de passe : $mail->password_user\n"
                                
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $mailpass = new Xsuite_Mail();
                        $mailpass->setSubject("vos informations d'identification")
                                ->setBodyText(sprintf($corpsMails))
                                ->addTo($destmail)
                                ->send();
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "vos identifiants ont été envoyés  à cette adresse mail : $mail->email_user";
                    $flashMessenger->addMessage($message);
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->gotoSimple('index', 'login',null,$message);
                    //$flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    
                    
                }elseif($mail === FALSE){
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "cette adresse mail n'a pas de concordance dans la base Xsuite";
                    $flashMessenger->addMessage($message);
                    $this->_helper->redirector('perdu', 'login');
//                    $redirector = $this->_helper->getHelper('Redirector');
//                    $redirector->gotoSimple('perdu', 'login');
                }
                
         }
         }
         $this->view->form = $formperdu;
    }
}

