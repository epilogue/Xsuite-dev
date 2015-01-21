<?php

class XdistribController extends Zend_Controller_Action
{
    public $odbc_conn = null;
    public $odbc_conn2 = null;
    public $odbc_conn3 = null;
    public function init()
    {
       // $auth = Zend_Auth::getInstance();
        $this->_auth = Zend_Auth::getInstance();
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
//        $user = $auth->getIdentity();
//        if (is_null($user)) {
//            $this->_helper->redirector('index', 'login');
//        } else {
//            /* @todo commentaire franck
//             * Et donc, ici, on peut faire de l'acl de manière plus fine
//             */
//        }
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
            $message = "Veuillez cliquer sur : <a href=\"/xdistrib/tracking\">'Xdistrib : Consulter'</a>.";
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
            $trackingNumber = Application_Model_DbTable_Xdistrib::makeTrackingNumber($zone['nom_zone'], $Xdistribs->lastId(true));
            $this->view->trackingNumber = $trackingNumber;
            $query1 = "SELECT OOLINE.OBSMCD  as userwp FROM EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}'";
            $numwp_user = odbc_fetch_array(odbc_exec($this->odbc_conn, $query1));
            $usertest = new Application_Model_DbTable_Users();
            $user_info = $usertest->getMovexUser($numwp_user['USERWP']);
            $this->view->user_info = $user_info;
            echo '<pre>', var_export($user_info),'</pre>';
            $id_holon = $user_info['id_holon'];
            $holonuser = new Application_Model_DbTable_Holons();
            $holonuser1 = $holonuser->getHolon($id_holon);
            $nom_holon = $holonuser1['nom_holon'];
            $this->view->holon = $nom_holon;
            $fonctioncreateur = $user_info['id_fonction'];
            $zonetracking = substr($trackingNumber, 6, 2);
            $query2 = "select OOLINE.OBORNO,OOLINE.OBCUNO,OOLINE.OBITNO,OOLINE.OBITDS,OOLINE.OBORQT,OOLINE.OBLNA2,OOLINE.OBNEPR,OOLINE.OBSAPR,OOLINE.OBELNO,OOLINE.OBRGDT,
                    OOLINE.OBLMDT,
                    OOLINE.OBSMCD
                    from EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}' AND OOLINE.OBDIVI LIKE 'FR0' AND OOLINE.OBCONO=100";
            $resultats = odbc_exec($this->odbc_conn, $query2);

            while ($resultat[] = odbc_fetch_array($resultats)) {
                    $this->view->resultat = $resultat;
                }
            foreach ($this->view->resultat as $itnoarticle) {
                    $mmcono = "100";
                    $division = "FR0";
                    $facility = "I01";
                    $type = "3";
                    $warehouse = "I02";
                    $supplier = "I990001";
                    $agreement1 = "I000001";
                    $agreement2 = "I000002";
                    $agreement3 = "I000003";
                    $query3 = "select * from EIT.MVXCDTA.MPAGRP MPAGRP where MPAGRP.AJCONO = '$mmcono' AND MPAGRP.AJSUNO = '$supplier' AND (MPAGRP.AJAGNB = '$agreement3'  OR MPAGRP.AJAGNB = '$agreement2' OR MPAGRP.AJAGNB = '$agreement1') AND MPAGRP.AJOBV2 = '{$itnoarticle['OBITNO']}' AND MPAGRP.AJOBV1 = '$division'  ORDER BY MPAGRP.AJAGNB";
                    $resultats3 = odbc_Exec($this->odbc_conn2, $query3);
                    $prixciffob[] = odbc_fetch_object($resultats3);
                }
            $this->view->prixciffob = $prixciffob;
             /*
             * à partir du code distributeur de la table ooline on va chercher dans la table ocusma
             * les informations concernant le distributeur pour pouvoir les afficher dans la vue phtml
             */
            $query1bis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '{$resultat[0]['OBCUNO']}'";
            $infos_distributeur = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1bis));
            $this->view->infos_distributeur = $infos_distributeur;
            echo '<pre>',  var_export($infos_distributeur),'</pre>';
            $query1ter = "select OOHEAD.OACHL1 from EIT.MVXCDTA.OOHEAD OOHEAD where OOHEAD.OACUNO = '{$resultat[0]['OBCUNO']}'";
            $numdistributeurwp = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1ter));
            $this->view->numdistributeurwp = $numdistributeurwp['OACHL1'];
            $query1quart = "select ZMCPJO.Z2MCL1  from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '{$resultat[0]['OBCUNO']}' ";
            $industriewp = odbc_fetch_array(odbc_exec($this->odbc_conn3, $query1quart));
            $this->view->industriewp = $industriewp;
            $industriewp['Z2MCL1'] = trim($industriewp['Z2MCL1']);
            if ($industriewp['Z2MCL1'] == "" || $industriewp['Z2MCL1'] == " ") {
                    $industriewp['Z2MCL1'] = "SCI";
                }
            /*
             * information concernant  le projet industry auquel appartient le distributeur
             *    donc à partir du code movex industry on va chercher dans la base xsuite
             *  le nom de l'industrie auquel le distributeur appartient pour ensuite l'afficher dans la vue
             */

            if (isset($industriewp['Z2MCL1']) && $industriewp['Z2MCL1'] != '' && $industriewp['Z2MCL1'] != ' ' && $industriewp['Z2MCL1'] != '  ') {
                    $industry = new Application_Model_DbTable_Industry();
                    $info_industry = $industry->getMovexIndustry($industriewp['Z2MCL1']);
                    $this->view->info_industry = $info_industry;
                } else {
                    $plop10 = "SCI";
                    $industry = new Application_Model_DbTable_Industry();
                    $info_industry = $industry->getMovexIndustry($plop10);
                    $this->view->info_industry = $info_industry;
                }
             $form = new Application_Form_CreationDemande();
            if ($this->getRequest()->isPost()) {
                    $formData = $this->getRequest()->getPost();
                    if ($form->isValid($formData)) {
                        $emailVars = Zend_Registry::get('emailVars');
                        //alors si le distributeur n'existe pas ' on insert d'abord dans la table distributeur
                        $distributeurs = new Application_Model_DbTable_Distributeurs();
                        $distributeur = $distributeurs->getDistributeurnumwp($numdistributeurwp['OACHL1']);

                        $adresse_distributeur = $infos_distributeur['OKCUA1'] . $infos_distributeur['OKCUA2'] . $infos_distributeur['OKCUA3'] . $infos_distributeur['OKCUA4'];

                        if (is_null($distributeur)) {
                            $newdistributeur = $distributeurs->createDistributeur($infos_distributeur['OKCUNM'], $numdistributeurwp['OACHL1'], $adresse_distributeur, $info_industry['id_industry'], $infos_distributeur['OKCFC7']);
                        }
                        // et ensuite  on insert dans la table demande_xdistribs
                        //si le distributeur existe  alors on insert immédiatement dans la table demande_xdistribs

                        $numwpexist = $demandes_xdistrib->getNumwp($numwp);
                        $firstComment = null;
                        if (is_null($numwpexist)) {
                            $demande_xdistrib = $demandes_xdistrib->createXdistrib(
                            $numwp, $trackingNumber, $formData['commentaire_demande_article'], $infos_offres->OBRGDT, $formData['mini_demande_article'],$formData['concurrent_demande_article'],$formData['part_demande_article'],$formData['faible'], $user_info['id_user'], null, $numdistributeurwp['OACHL1']);
                            $dbtValidationDemande = new Application_Model_DbTable_Validationsdemandexdistribs();
                            if (!is_null($formData['commentaire_demande_article']) && trim($formData['commentaire_demande_article']) != "") {
                                $now = new DateTime();
                                $validationDemande = $dbtValidationDemande->createValidation(
                                        "creation", $now->format('Y-m-d H:i:s'), "creation", $user_info['id_user'], $demande_xdistrib->lastId(), trim($formData['commentaire_demande_article']));
                                $firstComment = $dbtValidationDemande->lastId();
                            }
                        }
                    }
                }
            }
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

