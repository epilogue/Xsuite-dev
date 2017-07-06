<?php

class XprevController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        if (is_null($user)) {
            $this->_helper->redirector('index', 'login');
        } else {
            /* @todo commentaire franck
             * Et donc, ici, on peut faire de l'acl de manière plus fine
             */
        }
        /*connexions à Movex*/
        $this->dsn = Zend_Registry::get("dsnString");
        $this->odbc_conn = odbc_connect('Movex', "EU65535", "CCS65535");
        if (!$this->odbc_conn) {
            echo "pas d'accès à la base de données CVXDTA";
        }
        $this->dsn2 = Zend_Registry::get("dsn2String");
        $this->odbc_conn2 = odbc_connect('Movex2', "EU65535", "CCS65535");
        if (!$this->odbc_conn2) {
            echo "pas d'accès à la base de données MVXCDTA";
        }
        $this->odbc_conn3 = odbc_connect('Movex3', "EU65535", "CCS65535");
        if (!$this->odbc_conn3) {
            echo "pas d'accès à la base de données SMCCDTA";
        }
         $this->odbc_conn4 = odbc_connect('Movex4', "EU65535", "CCS65535");
        if (!$this->odbc_conn4) {
            echo "pas d'accès à la base de données ZEUCDTA";
        }
    }
    /*
     * fonction qui permet d'afficher la liste des codes user en fonction du code client choisi dans le select code_client
     */
    public function liaisoncodeuserAction(){
        $this->_helper->layout->disableLayout();
        $num_client = substr($this->getRequest()->getParam('num_client',null),0,6);
        $codeuser = new Application_Model_DbTable_Baseclient();
        $listecodeuser = $codeuser->getAllcodeuser($num_client);
        $this->view->listecodeuser = $listecodeuser;
    }
    public function liaisonmoisAction(){
        $this->_helper->layout->disableLayout();
        $num_mois = $this->getRequest()->getParam('date_debut',null);
        var_dump($num_mois);
        $month= intval(substr($num_mois,0,2)) ;
        $year = intval(substr($num_mois,-2));
        var_dump($year);
        var_dump($month);
        $tab = array();
    //Boucle sur 12 mois
        for($i = 1, $month, $year; $i < 13; $i++, $month++)
        {
            //Arrivé en Décembre, on remet le mois à Janvier pour parcourir les 12 mois et on incrémente l'année
            if($month > 12)
            {
                $month = 1;
                $year++;
            }
//            var_dump($month);

//                var_dump($year) ;
            $tab[]= array('month'=>$month, 'year'=>$year);
        }
        var_dump($tab);
         $this->view->tab = $tab;
    }
    
    /*
     * action qui va permettre d'aller verifier si la reference existe dans movex et remplir en ajax le champ code article
     */
    public function verifreferenceAction(){
        $this->_helper->layout->disableLayout();
        $reference_article= $this->getRequest()->getParam('reference');
        $requete1 ="select MITMAS.MMITNO from EIT.MVXCDTA.MITMAS MITMAS where  MITMAS.MMITDS ='{$reference_article}' and  MITMAS.MMCONO='100'";
        //var_dump($requete1);
        $results1 = odbc_exec($this->odbc_conn2, $requete1);
        $res =  odbc_fetch_array($results1);
       // echo '<pre>',  var_export($res),'</pre>';

        $this->view->code_article = trim($res['MMITNO']);

    }
    public function indexAction()
    {
        $user = $this->_auth->getStorage()->read();
        /*fonction niveau0*/
        $fn0 = array(4,18,38);
        /* fonction niveau1*/
        $fn1 =array(1,2,6,43,44,46,26,27,28,29,30,34,35,36,37,40);
        /*fonction niveau2*/
        $fn2 = array(3,10,41,45,42);
        /*fonction niveau3*/
        $fn3 = array(32,23,50,39);
        $this->view->fonction = $user->id_fonction;
        $this->view->fn0 = $fn0;
        $this->view->fn1 = $fn1;
        $this->view->fn2 = $fn2;
        $this->view->fn3 = $fn3;
    }

    public function creationAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $etatcreat=4;
       // echo '<pre>',  var_export($infoUser),'</pre>';
        
        /*info base de donnees*/
        $basecodeclient = new Application_Model_DbTable_Baseclient();
        $listecodeclient = $basecodeclient->getAllcodeclient();
        $typedemande = new Application_Model_DbTable_TypeDemandeXprev();
        $listetypedemande = $typedemande->alltypedemande();
        $niveaurisque = new Application_Model_DbTable_NiveauRisqueXprev();
        $listeniveaurisque = $niveaurisque->allniveaurisque();
        $etatvalidation = new Application_Model_DbTable_EtatValidationXprev();
        $newetatvalidation = $etatvalidation->getEtat($etatcreat);
        $datejour = date('d-m-Y');
        $moiscreate = date('m-Y');
        /*passage a la vue*/
        $this->view->newetatvalidation=$newetatvalidation;
        $this->view->listetypedemande=$listetypedemande;
        $this->view->datecreate=$datejour;
        $this->view->moiscreate=$moiscreate;
        $this->view->listeniveaurisque=$listeniveaurisque;
        $this->view->infoCodeClient=$listecodeclient;
        $this->view->infoUser=$infoUser;
    }
}

