<?php

class XdistribController extends Zend_Controller_Action
{
    public $odbc_conn = null;
    public $odbc_conn2 = null;
    public $odbc_conn3 = null;
    public function init()
    {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        if (is_null($user)) {
            $this->_helper->redirector('index', 'login');
        } else {
            /* @todo commentaire franck
             * Et donc, ici, on peut faire de l'acl de manière plus fine
             */
        }
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
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
    }

    public function indexAction()
    {
        
    }

public function createAction()
    {
        $numwp = $this->getRequest()->getParam('numwp', null);
        $demandes_xdistrib = new Application_Model_DbTable_Xdistrib();
        $demande_xdistrib = $demandes_xdistrib->getNumwp($numwp);
        if (!is_null($demande_xdistrib)) {
            $redirector = $this->_helper->getHelper('Redirector');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "Cette offre a déjà été créée.";
            $flashMessenger->addMessage($message);
            $message = "Veuillez cliquer sur : <a href=\"/xprice/tracking\">'Xdistrib : Consulter'</a>.";
            $flashMessenger->addMessage($message);
            $redirector->gotoSimple('index', 'xdistrib');
        }
        $this->view->numwp = $numwp;
//si le numero workplace est valide alors on fait la requête pour movex
// requête d'informations de l'offre
        if (!is_null($numwp)) {

            $pirate = "select OOLINE.OBORNO, OOLINE.OBRGDT, OOLINE.OBORNO from EIT.CVXCDTA.OOLINE OOLINE where OOLINE.OBORNO='{$numwp}'";
            $infos_offre = odbc_exec($this->odbc_conn, $pirate);
            $infos_offres = odbc_fetch_object($infos_offre);
            $this->view->infos_offres = $infos_offres;
            $dateinit = $infos_offres->OBRGDT;
            $dateinit3 = substr($dateinit, 0, 4);
            $dateinit2 = substr($dateinit, 4, 2);
            $dateinit1 = substr($dateinit, 6, 2);
            $dateinitf = array($dateinit1, $dateinit2, $dateinit3);
            $datefinal = implode('/', $dateinitf);
            $this->view->datefinal = $datefinal;
            $user = $this->_auth->getStorage()->read();
            $zoneT = new Application_Model_DbTable_Zones();
            $zone = $zoneT->getZone($user->id_zone);
            $Xdistribs = new Application_Model_DbTable_Xdistrib();
            $trackingNumber = Application_Model_DbTable_Xdistrib::makeTrackingNumber($zone['nom_zone'], $Xdistrib->lastId(true));
            $this->view->trackingNumber = $trackingNumber;}
    }
    public function consultAction()
    {
        // action body
    }
    public function trackingAction(){
         $track = $this->getRequest()->getParam('tracking_number_demande_xdistrib', null);
        $form = new Application_Form_TrackingSearchDistrib();
        echo $track;
        if (!is_null($track)) {
            $form->populate(array("tracking_number_demande_xdistrib" => $track));
        }
        if ($this->getRequest()->isPost()) {
            $redirector = $this->_helper->getHelper('Redirector');

            if ($form->isValid($this->getRequest()->getPost())) {
                $tracksearch= new Application_Model_DbTable_Xdistrib();
                $r=$tracksearch->getTracking($track);
                echo '<pre>',  var_export($r),'<pre>'; 
                if ($r['tracking_number_demande_xdistrib'] == $_POST['tracking_number_demande_xdistrib']) {
                    $redirector->gotoSimple('consultlibre', 'xdistrib', null, array('tracking' => $_POST['tracking_number_demande_xdistrib']));
                } else {
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "ce numéro d'offre n'a pas de concordance dans la base Xsuite";
                    $flashMessenger->addMessage($message);
                    $redirector->gotoSimple('tracking', 'xdistrib', null, array('tracking' => $_POST['tracking_number_demande_xdistrib']));
                }
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }
        $this->view->form = $form;
    }
    public function consultlibreAction(){
        
    }
    public function numwpAction(){
        $numwp = $this->getRequest()->getParam('numwp', null);
        $form = new Application_Form_NumwpDistrib();
        $mmcono = "100";
        $division = "FR0";
        $facility = "I01";
        $type = "3";
        $warehouse = "I02";
        $supplier = "I990001";
        $agreement1 = "I000001";
        $agreement2 = "I000002";
        $agreement3 = "I000003";
        if (!is_null($numwp)) {
            $form->populate(array("num_offre_worplace" => $numwp));
        }
        if ($this->getRequest()->isPost()) {
            $redirector = $this->_helper->getHelper('Redirector');

            if ($form->isValid($this->getRequest()->getPost())) {

                $query = "select
	OOLINE.OBORNO as NBNUMWP,OOLINE.OBCUNO
	FROM EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO = '{$_POST['num_offre_worplace']}' AND OOLINE.OBDIVI='FR0' and OOLINE.OBCONO='100'";
                $results = odbc_exec($this->odbc_conn, $query);
                $r = odbc_fetch_object($results);
                if ($r->NBNUMWP === $_POST['num_offre_worplace']) {
                    $redirector->gotoSimple('create', 'xdistrib', null, array('numwp' => $_POST['num_offre_worplace']));
                } else {
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "ce numéro d'offre n'a pas de concordance dans la base MOVEX";
                    $flashMessenger->addMessage($message);
                    $redirector->gotoSimple('numwp', 'xdistrib', null, array('numwp' => $_POST['num_offre_worplace']));
                }
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }
        $this->view->form = $form;
    }
}

