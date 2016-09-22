<?php

class XpriceController extends Zend_Controller_Action {

// public $dsn="DRIVER=Client Access ODBC Driver(32-bit);UID=EU65535;PWD=CCS65535;SYSTEM=10.105.80.32;DBQ=CVXCDTA";
// public $dsn = "Database=CVXCDTA;UID=EU65535;PWD=CCS65535;";
// public $dsn = "Movex";
//public $dsn2 = "DRIVER={MySQL};Server=127.0.0.1;Database=MVXCDTA;UID=root;PWD=geek;";
//public $dsn2 = "";
    public $odbc_conn = null;
    public $odbc_conn2 = null;
    public $odbc_conn3 = null;

//  public $odbc_conn3= null;

    public function init() {
        $this->_auth = Zend_Auth::getInstance();
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        $this->dsn = Zend_Registry::get("dsnString");
//        $this->odbc_conn = odbc_connect($this->dsn, "", "");
        $this->odbc_conn = odbc_connect('Movex', "EU65535", "CCS65535");
        if (!$this->odbc_conn) {
            echo "pas d'accès à la base de données CVXDTA";
        }
       
        

// id de commentaire pour tracking des questions/réponses
        $comId = $this->getRequest()->getParam('com', null);
        if (!is_null($comId)) {
            $comId = intval($comId);
            $dbtValidation = new Application_Model_DbTable_Validationsdemandexprices();
            if ($dbtValidation->checkId($comId) == true) {
                $this->view->commentId = $comId;
            } else {
                $this->view->commentId = null;
            }
        } else {
            $this->view->commentId = null;
        }

 $this->dsn2 = Zend_Registry::get("dsn2String");
        $this->odbc_conn2 = odbc_connect('Movex2', "EU65535", "CCS65535");
        if (!$this->odbc_conn2) {
            echo "pas d'accès à la base de données MVXCDTA";
    }
        // $this->dsn3,"","");
        $this->odbc_conn3 = odbc_connect('Movex3', "EU65535", "CCS65535");
        if (!$this->odbc_conn3) {
            echo "pas d'accès à la base de données SMCCDTA";
        }
        $this->odbc_conn4 = odbc_connect('Movex4', "EU65535", "CCS65535");
        if (!$this->odbc_conn4) {
            echo "pas d'accès à la base de données ZEUCDTA";
        }
    }
     protected function sendEmail($params) {
        $mail = new Xsuite_Mail();
        $mail->setSubject($params['sujet'])
                ->setBodyText(sprintf($params['corpsMail'], $params['url']))
                ->addTo($params['destinataireMail'])
                ->send();
    }

    public function indexAction() {
 $user = $this->_auth->getStorage()->read();
  $holon =$user->id_holon; 
  $fonction = $user->id_fonction;
  $this->view->fonction=$fonction;
 if ($user->id_fonction == 2 || $user->id_fonction == 46 || $user->id_fonction == 6 ){
     $recapitulatif1 = new Application_Model_DbTable_Xprices();
     $recapitulatif2 = $recapitulatif1->searchByUser($user->id_user);
     $r = array();
     for ($index = 0; $index < count($recapitulatif2); $index++) {
         if(($index +1) > count($recapitulatif2)-1) {
             $r[] = $recapitulatif2[$index];
         } else {
             if($recapitulatif2[$index]['num_workplace_demande_xprice'] != $recapitulatif2[$index+1]['num_workplace_demande_xprice']) {
                 $r[] = $recapitulatif2[$index];
             }
         }
     }
     unset($recapitulatif2);
     $recapitulatif2 = $r;
//       echo '<pre>', var_export($recapitulatif2),'</pre>'; 
}
if($user->id_fonction == 3){
    $recapitulatif1=new Application_Model_DbTable_Xprices();
    $recapitulatif2 = $recapitulatif1->searchForLeader($holon);
}

 if($user->id_fonction == 10){
    
     switch ($holon){
         case 2:
             $searchholon=array(18, 19, 20, 21, 22, 23, 32);
//             $tracking1='/SP-FR-QC/';
//             $tracking2='/SP-FR-QF/';
             break;
         case 3:
             $searchholon=array(5,6,7,11,12,13,30);
//             $tracking1='/SP-FR-QE/';
//             $tracking2='/SP-FR-QH/';            
             break;
         case 4:
             $searchholon=array(8,9,10,14,15,16,17,31);
//            $tracking1='/SP-FR-QI/';
//            $tracking2='/SP-FR-QK/';            
             break;
         case 28:
             $searchholon=array(29);
             break;
         }
         $recapitulatif1 = new Application_Model_DbTable_Xprices();
         $recapitulatif2=$recapitulatif1->searchForCDR($searchholon);
         $r = array();
         for ($index = 0; $index < count($recapitulatif2); $index++) {
             if(($index +1) > count($recapitulatif2)-1) {
                 $r[] = $recapitulatif2[$index];
             } else {
                 if($recapitulatif2[$index]['num_workplace_demande_xprice'] != $recapitulatif2[$index+1]['num_workplace_demande_xprice']) {
                     $r[] = $recapitulatif2[$index];
                 }
             }
         }
         unset($recapitulatif2);
         $recapitulatif2 = $r;
        // echo '<pre>', var_export($plopr),'</pre>'; 
     }
     if($user->id_fonction ==45){
         $recapitulatif1 = new Application_Model_DbTable_Xprices;
         $recapitulatif2=$recapitulatif1->searchForDGCN();
         $r = array();
         for ($index = 0; $index < count($recapitulatif2); $index++) {
             if(($index +1) > count($recapitulatif2)-1) {
                 $r[] = $recapitulatif2[$index];
             } else {
                 if($recapitulatif2[$index]['num_workplace_demande_xprice'] != $recapitulatif2[$index+1]['num_workplace_demande_xprice']) {
                     $r[] = $recapitulatif2[$index];
                 }
             }
         }
         unset($recapitulatif2);
         $recapitulatif2 = $r;
     }
     
     if($user->id_fonction == 5 || $user->id_fonction == 13 || $user->id_fonction == 41 || $user->id_fonction == 23 || $user->id_fonction == 32 || $user->id_fonction==47){
         $recapitulatif1 = new Application_Model_DbTable_Xprices;
         $recapitulatif2=$recapitulatif1->searchforDBD();
         $r = array();
         for ($index = 0; $index < count($recapitulatif2); $index++) {
             if(($index +1) > count($recapitulatif2)-1) {
                 $r[] = $recapitulatif2[$index];
             } else {
                 if($recapitulatif2[$index]['num_workplace_demande_xprice'] != $recapitulatif2[$index+1]['num_workplace_demande_xprice']) {
                     $r[] = $recapitulatif2[$index];
                 }
             }
         }
         unset($recapitulatif2);
         $recapitulatif2 = $r;
     }
    $this->view->recapitulatif = $recapitulatif2;

}

    public function numwpAction() {
        $numwp = $this->getRequest()->getParam('numwp', null);
        $form = new Application_Form_Numwp();
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
                    $redirector->gotoSimple('create', 'xprice', null, array('numwp' => $_POST['num_offre_worplace']));
                } else {
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "ce numéro d'offre n'a pas de concordance dans la base MOVEX";
                    $flashMessenger->addMessage($message);
                    $redirector->gotoSimple('numwp', 'xprice', null, array('numwp' => $_POST['num_offre_worplace']));
                }
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }
        $this->view->form = $form;
    }

    public function createAction() {
        $numwp = $this->getRequest()->getParam('numwp', null);
        $demandes_xprice = new Application_Model_DbTable_Xprices();
        $demandeXprice = $demandes_xprice->getNumwp($numwp);
        if (!is_null($demandeXprice)) {
            $redirector = $this->_helper->getHelper('Redirector');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "Cette offre a déjà été créée.";
            $flashMessenger->addMessage($message);
            $redirector->gotoSimple('index', 'xprice');
        }
        $this->view->numwp = $numwp;

        if (!is_null($numwp)) {
//si le numero workplace est valide alors on fait la requête pour movex
// requête d'informations de l'offre
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
            $Xprices = new Application_Model_DbTable_Xprices();
            $trackingNumber = Application_Model_DbTable_Xprices::makeTrackingNumber($zone['nom_zone'], $Xprices->lastId(true));
            $this->view->trackingNumber = $trackingNumber;
// requetes pour remplir le phtml :
//requete 1 pour remplir  les données du commercial à partir du numwp
            $query1 = "SELECT OOLINE.OBSMCD  as userwp FROM EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}'";
            $numwp_user = odbc_fetch_array(odbc_exec($this->odbc_conn, $query1));
//            echo '<pre>',  var_export($numwp_user),'</pre>'; exit();
            $usertest = new Application_Model_DbTable_Users();
            $user_info = $usertest->getMovexUser($numwp_user['USERWP']);
            $this->view->user_info = $user_info;
            $id_holon = $user_info['id_holon'];
            $holonuser = new Application_Model_DbTable_Holons();
            $holonuser1 = $holonuser->getHolon($id_holon);
            $nom_holon = $holonuser1['nom_holon'];
            
            $this->view->holon = $nom_holon;
            $fonctioncreateur = $user_info['id_fonction'];
            $zonetracking = substr($trackingNumber, 6, 2);
            /*
             * on va chercher les informations concernant les articles dans la table ooline à partir du numwp
             * pour pouvoir ensuite les afficher dans la vue à l'aide d'un foreach
             */
            $query2 = "select OOLINE.OBDLSP,OOLINE.OBORNO,OOLINE.OBCUNO,OOLINE.OBITNO,OOLINE.OBITDS,OOLINE.OBORQT,OOLINE.OBLNA2,OOLINE.OBNEPR,OOLINE.OBSAPR,OOLINE.OBELNO,OOLINE.OBRGDT,
                    OOLINE.OBLMDT,
                    OOLINE.OBSMCD
                    from EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}' AND OOLINE.OBDIVI LIKE 'FR0' AND OOLINE.OBCONO=100";
            $resultats = odbc_exec($this->odbc_conn, $query2);

            while ($resultat[] = odbc_fetch_array($resultats)) {
                $this->view->resultat = $resultat;
            }
//            echo '<pre>',  var_export($resultat),'</pre>';
            /* aller chercher prix fob prix cif sur la base MVCDXTA en utilisant les tables KOPCDT(date) KOITNO ( code article) et KO ( prix cif)
             *
             */foreach ($this->view->resultat as $itnoarticle) {
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
//                echo '<pre>',(var_export($prixciffob)),'</pre>';
                $acquis= "select MITBAL.MBITNO, MITBAL.MBPUIT from EIT.MVXCDTA.MITBAL MITBAL where MITBAL.MBITNO ='{$itnoarticle['OBITNO']}'";
                    $resultatsacquis=odbc_Exec($this->odbc_conn2, $acquis);
                    $resultatacquis[] = odbc_fetch_object($resultatsacquis);
            }           
            /*
             * à partir du code client de la table ooline on va chercher dans la table ocusma
             * les informations concernant le client pour pouvoir les afficher dans la vue phtml
             */
             $query1ter = "select * from EIT.MVXCDTA.OOHEAD OOHEAD where OOHEAD.OACUNO = '{$resultat[0]['OBDLSP']}'";
            $numclientwp = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1ter));
            $numwpclient2 = $resultat[0]['OBDLSP'];
            $this->view->numclientwp =  $numwpclient2 ;/*-$numclientwp['OACHL1'];*/
            $query1bis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '{$numwpclient2}'";
            $infos_client = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1bis));
//            echo 'pre',var_export($infos_client),'</pre>';
            $this->view->infos_client = $infos_client;
            $query1quart = "select ZMCPJO.Z2MCL1  from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '{$resultat[0]['OBCUNO']}' ";
            $industriewp = odbc_fetch_array(odbc_exec($this->odbc_conn3, $query1quart));
            $this->view->industriewp = $industriewp;
           // echo '<pre>',var_export($numclientwp),'</pre>';
            //echo '<pre>',var_export($infos_client),'</pre>';
            $industriewp['Z2MCL1'] = trim($industriewp['Z2MCL1']);
            if ($industriewp['Z2MCL1'] == "" || $industriewp['Z2MCL1'] == " ") {
                $industriewp['Z2MCL1'] = "SCI";
            }
            /*
             * information concernant  le projet industry auquel appartient le client
             *    donc à partir du code movex industry on va chercher dans la base xsuite
             *  le nom de l'industrie auquel le client appartient pour ensuite l'afficher dans la vue
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
//alors si le client n'existe pas ' on insert d'abord dans la table client
                    $clients = new Application_Model_DbTable_Clients();
                    $client = $clients->getClientnumwp($numwpclient2);
                    $potentiel=$infos_client['OKCFC7'];
                    $adresse_client = $infos_client['OKCUA1'] . $infos_client['OKCUA2'] . $infos_client['OKCUA3'] . $infos_client['OKCUA4'];

                    if (is_null($client)) {
                        $newclient = $clients->createClient($infos_client['OKCUNM'], $numwpclient2, $adresse_client, $info_industry['id_industry'], $potentiel);
                    }
                    
// et ensuite  on insert dans la table demande_xprices
//si le client existe  alors on insert immédiatement dans la table demande_xprices

                    $numwpexist = $demandes_xprice->getNumwp($numwp);
                    $firstComment = null;
                    if (is_null($numwpexist)) {
                        $demande_xprice = $demandes_xprice->createXprice(
                                $numwp, $trackingNumber, $formData['commentaire_demande_article'], $infos_offres->OBRGDT, $formData['mini_demande_article'],$formData['concurrent_demande_article'],$formData['part_demande_article'],$formData['faible'], $user_info['id_user'], null, $numwpclient2,$formData['listedifusion']);
                        $dbtValidationDemande = new Application_Model_DbTable_Validationsdemandexprices();
                        if (!is_null($formData['commentaire_demande_article']) && trim($formData['commentaire_demande_article']) != "") {
                            $now = new DateTime();
                            $validationDemande = $dbtValidationDemande->createValidation(
                                    "creation", $now->format('Y-m-d H:i:s'), "creation", $user_info['id_user'], $demande_xprice->lastId(), trim($formData['commentaire_demande_article']));
                            $firstComment = $dbtValidationDemande->lastId();
                        }
                    }
                    /*
                     * ici insertion dans les tables articles et demande_article_xprices
                     * à partir d'un foreach sur $resultat
                     *
                     * donc pour chaque ligne du tableau $resultat  on insert d'abord dans la table articles
                     *  puis dans la table demande_article_xprices
                     */
                    $articles_xprice = new Application_Model_DbTable_Articles();
                    $demandes_xprice = new Application_Model_DbTable_DemandeArticlexprices();
                    foreach ($this->view->resultat as $resultarticle) {
                        $articleexist = $articles_xprice->getArticle($resultarticle['OBITNO']);
                        if (is_null($articleexist)) {
                            $articles_xprice = $articles_xprice->createArticle($resultarticle['OBITDS'], $resultarticle['OBITNO'], null);
                        }
                        $demande_xprice = $demandes_xprice->createDemandeArticlexprice($resultarticle['OBSAPR'], $resultarticle['OBNEPR'], $resultarticle['OBORQT'], round(100 - ($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR']), 2), $infos_offres->OBRGDT,$resultarticle['OBNEPR'], round(100 - ($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR']), 2), null, null, null, $trackingNumber, $resultarticle['OBITNO'], $resultarticle['OBITDS'], $numwp,null);
                    }

                    foreach ($prixciffob as $key => $value) {
                        /* a ajouter
                         *  requete suivante : select MITBAL.MBPUIT as acquisition from eit.MVXCDTA.MITBAL MITBAL where MITBAL.MBITNO='$value->AJOBV2' ;
                            if $acquisition ==1 ou 3 prix fob = prix cif 
                         * if $acquisition == 2 cif =1.07*fob
                         * 
                         *                          */
                        $insertprix = new Application_Model_DbTable_DemandeArticlexprices();
                        $inserprix = $insertprix->InserPrixFob($value->AJPUPR, $value->AJOBV2, $numwp);
                    }
                    foreach($resultatacquis as $key=>$value){
                        $insertacquis= new Application_Model_DbTable_DemandeArticlexprices();
                        $inseracquis = $insertacquis->InserCodeAcquis($value->MBPUIT, $value->MBITNO, $numwp);
                    }
                    
                    $updatecif1 = new Application_Model_DbTable_DemandeArticlexprices();
                    $updatecif2 = $updatecif1->getDemandeArticlexprice($numwp);                   
                        foreach($updatecif2 as $result){
                            if($result['code_acquisition']=='2'){
                                $cifs= ($result['prix_fob_demande_article'])*1.07;
                                $cif=round($cifs,2);
                                $updatecif3 = $updatecif1->updatecif($cif, $result['code_article'], $result['tracking_number_demande_xprice']);
                            }     
                        }
                        $margeupdate1=new Application_Model_DbTable_DemandeArticlexprices();
                        $margeupdate2=$margeupdate1->getDemandeArticlexprice($numwp);
                        foreach($margeupdate2 as $res){
                            $marges = 1-($res['prix_cif_demande_article']/$res['prix_accorde_demande_article']);
                            $marge=$marges*100;
                            $margeupdate3=$margeupdate1->updateMarge($marge, $res['code_article'],$result['tracking_number_demande_xprice']);
                        }
                        /*
                         * 
                         * pour chaque ligne de la demande  on vérifie  si  la marge :
                         * si il y a une ligne supérieur à 65  chemin classique ( drv, fobfr,supply,dbd,dirco)
                         * si il y a une ligne  entre 55 et 65 validations par les drv uniquement  
                         * si il y a une ligne entre 45 et 55 validation par les  leaders uniquement  
                         * 
                         * 
                         */                     
                    /*
                     * ici, envoi des mails
                     * NE PAS TOUCHER SOUS PEINE D'EFFONDREMENT DE L'APPLI
                     *  à partir de la ligne 350 à la ligne 393
                     */

                    /* Dans un premier lieu on vérifie la fonction du créateur de la demande  :
                     * en fonction de sa fonction envoie de mail à un ou des destinataires :
                     * si ITC ou KAM alors envoie mail pour consultation au leader et au chef de région
                     * si leader  et dd envoie mail au chef de région.
                     */
                    $destIndustry =intval($info_industry['id_industry']) ;
                  
                    $emailVars = Zend_Registry::get('emailVars');
                    //$fonctioncreateur = $user_info['id_fonction'];
                    $holoncreateur = $user_info['id_holon'];
                    $clientsnom=trim($infos_client['OKCUNM']);
                    $params=array();
                    /*envoi mail au chef de marché correspondant*/
                    $params4=array();
                    /*dispatch code industry movex -> code industry smc-france*/
                    $car1=array(1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,18,19,59,73,74,75,76);
                    $car2=array(14,17,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,
                        37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,
                        60,61,62,63,64,65,66,67,68,69,70,71,72);
                    $LS=array(77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,
                        97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,
                        114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,
                        130,131,132,133,134,135,136,137);
                    $Elec=array(138,139,140,141,142,143,144,145,146,147,148,149,150,151,
                        152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167
                        ,168,169,170,170,172,173,174,175,176,177,178,179,180,181,182,183,
                        184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,
                        201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,
                        218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,
                        236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253
                        ,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271);
                    $food=array(273,274,275,276,277,278,279,280,291,292,293,294,304,305,306,307,308);
                    $food1=array(272,281,282,283,284,285,286,287,288,289,290,295,296,297,298,299,300,301,302,303,309,310,311,312,313);
                    $EE=array(314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,
                        330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,
                        348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,
                        366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,
                        384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,
                        402,403,404,405,406,407,408,409,410,411,412,413,414,415,416);
                    if(in_array($destIndustry, $car1)){
                        $destinataireMail4 = $emailVars->listes->carIndustries1;
                    }elseif(in_array($destIndustry, $car2)){
                        $destinataireMail4 = $emailVars->listes->carIndustries;
                    }elseif(in_array($destIndustry, $Elec)){
                       $destinataireMail4 = $emailVars->listes->Electronique;
                    }
                 
                $params4['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consultchefmarche/numwp/{$numwp}";
                $params4['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XPrice {$trackingNumber}/{$numwp} à consulter de {$user_info['nom_user']} pour $clientsnom.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice";
                $params4['destinataireMail'] = $destinataireMail4;
                $params4['sujet'] = " XPrice : Nouvelle demande Xprice {$trackingNumber}/{$numwp} à consulter de {$user_info['nom_user']} pour $clientsnom.";
               
                $this->sendEmail($params4);
                    /*
                     * ici si itc envoie mail au leader en fonction du holon pour consultation
                     */
                    if ($fonctioncreateur == 2) {
                        switch ($holoncreateur) {
                            case "5":
                                $destinataireMail2 = $emailVars->listes->leaderis01;
                                break;
                            case "6":
                                $destinataireMail2 = $emailVars->listes->leaderis03;
                                break;
                            case "7":
                                $destinataireMail2 = $info_user['email_user'];
                                break;
                            case "8":
                                $destinataireMail2 = $emailVars->listes->leaderiw01;
                                break;
                            case "9":
                                $destinataireMail2 = $emailVars->listes->leaderiw02;
                                break;
                            case "10":
                                $destinataireMail2 = $emailVars->listes->leaderiw03;
                                break;
                            case "11":
                                $destinataireMail2 = $emailVars->listes->leaderis02;
                                break;
                            case "14":
                                $destinataireMail2 = $emailVars->listes->leaderiw04;
                                break;
                            case "18":
                                $destinataireMail2 = $emailVars->listes->leaderin01;
                                break;
                            case "19":
                                $destinataireMail2 = $emailVars->listes->leaderin02;
                                break;
                            case "20":
                                $destinataireMail2 = $emailVars->listes->leaderin03;
                                break;
                             case "31":
                                $destinataireMail2 = $emailVars->listes->leaderiw08;
                                break;
                        }
                        $url2 = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                        $corpsMail2 = "Bonjour,\n"
                                . "\n"
                                . "Vous avez une nouvelle demande XPrice({$trackingNumber}/{$numwp}) à consulter.\n"
                                . "Veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $mail2 = new Xsuite_Mail();
                        $mail2->setSubject(" XPrice : Nouvelle Offre  Xprice {$trackingNumber}/{$numwp} à consulter de {$user_info['nom_user']} pour $clientsnom")
                                ->setBodyText(sprintf($corpsMail2, $url2))
                                ->addTo($destinataireMail2)
                                ->send();
                    }
                    /*envoi mail si fonction RGCU*/
                    
                    if($info_user['id_user']==34 || $info_user['id_user']==97 || $info_user['id_user']==184 || $info_user['id_user']==217 ){
                      $urlRGCU = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                        $corpsMailRGCU = "Bonjour,\n"
                                . "\n"
                                . "Vous avez une nouvelle demande XPrice({$trackingNumber}/{$numwp}) à consulter.\n"
                                . "Veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $mailRGCU = new Xsuite_Mail();
                        $destinataireMailRGCU="nberingue@smc-france.fr";
                        $mailRGCU->setSubject(" XPrice : Nouvelle Offre  Xprice {$trackingNumber}/{$numwp} à consulter de {$user_info['nom_user']} pour $clientsnom")
                                ->setBodyText(sprintf($corpsMailRGCU, $urlRGCU))
                                ->addTo($destinataireMailRGCU)
                                ->send();  
                    }
                    if($info_user['id_user']==124 || $info_user['id_user']==42 || $info_user['id_user']==98 || $info_user['id_user']==199){
                         $urlRGCU2 = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                        $corpsMailRGCU2 = "Bonjour,\n"
                                . "\n"
                                . "Vous avez une nouvelle demande XPrice({$trackingNumber}/{$numwp}) à consulter.\n"
                                . "Veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $mailRGCU2 = new Xsuite_Mail();
                        $destinataireMailRGCU2="clemoine@smc-france.fr";
                        $mailRGCU2->setSubject(" XPrice : Nouvelle Offre  Xprice {$trackingNumber}/{$numwp} à consulter de {$user_info['nom_user']} pour $clientsnom")
                                ->setBodyText(sprintf($corpsMailRGCU2, $urlRGCU2))
                                ->addTo($destinataireMailRGCU2)
                                ->send();  
                    }
                    /*
                     * ici si fonction itc kam ou leader  envoie de mail au chef de region pour validation
                     */
                    $idSearch1=array(42,98,122);
                    $idSearch2=array(217,184,97);
                    $idSearch3=array(20,34,199);
                    $zonetracking = substr($trackingNumber, 6, 2);
                    /*changement à comter du 22/04/2016 le dispatch mail ce fait maintenant en fonction du holon  et non plus de la region
                       if($holoncreateur =="33" || $user_info['id_user']=="145"){
                            $destinataireMail1=$emailVars->listes->IO;
                        }
                     *                      */
                    //echo '<pre>',  var_export($zonetracking),'</pre>';
                    
                    if ( $fonctioncreateur == "2" || $fonctioncreateur == "3" || $fonctioncreateur =="6")  {
                        if($info_user['id_user']==62 || $info_user['id_user'] ==78){
                             $paramsexport= array();
                $paramsexport['destinataireMail'] = $emailVars->listes->fobfr;
                        $paramsexport['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/prixfobfr/numwp/{$numwp}";
                
                $paramsexport['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XPrice $tracking/$numwp à valider {$info_user['nom_user']} pour le client $nomclients.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice";
                $paramsexport['sujet'] = " XPrice : Nouvelle demande Xprice $tracking/$numwp à valider de {$info_user['nom_user']} pour le client $nomclients.";
                $this->sendEmail($paramsexport);
                        }else{
                        switch ($holoncreateur) {
                            case "18":
                                $destinataireMail1 = $emailVars->listes->CDRNORD;
                                break;
                            case "19":
                                $destinataireMail1 = $emailVars->listes->CDRNORD;
                                break;
                            case "20":
                                $destinataireMail1 = $emailVars->listes->CDRNORD;
                                break;
                            case "5":
                                $destinataireMail1 = $emailVars->listes->CDREST;
                                break;
                            case"6":
                                $destinataireMail1 = $emailVars->listes->CDREST;
                                break;
                            case "11":
                                $destinataireMail1 = $emailVars->listes->CDREST;
                                break;
                            case "13":
                                $destinataireMail1 = $emailVars->listes->CDREST;
                                break;
                            case "8":
                                $destinataireMail1 = $emailVars->listes->CDROUEST;
                                break;
                            case "9":
                                $destinataireMail1 = $emailVars->listes->CDROUEST;
                                break;
                            case "10":
                                $destinataireMail1 = $emailVars->listes->CDROUEST;
                                break;
                            case "14":
                                $destinataireMail1 = $emailVars->listes->CDROUEST;
                                break;
                            case "31":
                                $destinataireMail1 = $emailVars->listes->CDROUEST;
                                break;
                        }
                        if (!is_null($firstComment)) {
                            $url1 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}/com/{$firstComment}";
                        } else {
                            $url1 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}";
                        }
                        $corpsMail1 = "Bonjour,\n"
                                . "\n"
                                . "Vous avez une nouvelle demande XPrice ( {$trackingNumber}/{$numwp}) à valider.\n"
                                . "Veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $mail1 = new Xsuite_Mail();
                        $mail1->setSubject("XPrice : Nouvelle Offre Xprice {$trackingNumber}/{$numwp} à valider de {$user_info['nom_user']} pour $clientsnom")
                                ->setBodyText(sprintf($corpsMail1, $url1))
                                ->addTo($destinataireMail1)
                                ->send();
                    }
                        
                    }
                    /*
                     * ici si le createur de la demande est un RGCN(ancien kam)ou luc montaclair alors envoie de mail DGCN(IO)
                     */ elseif ($fonctioncreateur == "46" || $user_info['id_user']==145) {
                       
                            $destinataireMail3 = $emailVars->listes->IO;
                            if (!is_null($firstComment)) {
                                $url3 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}/com/{$firstComment}";
                            } else {
                                $url3 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}";
                            }
                            $corpsMail3 = "Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande XPrice  {$trackingNumber}/{$numwp} à valider.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                            $mail3 = new Xsuite_Mail();
                            $mail3->setSubject(" XPrice : Nouvelle Offre Xprice {$trackingNumber}/{$numwp} à valider de {$user_info['nom_user']} pour $clientsnom")
                                    ->setBodyText(sprintf($corpsMail3, $url3))
                                    ->addTo($destinataireMail3)
                                    ->send();
                        
                    }
                    /*ici envoi au MGCI ou DGCI si fonction createur ==43/42/44*/
                    elseif ( $user_info['id_user']==42 ||$user_info['id_user']==98 || $user_info['id_user']==122) {
                        $destinataireMailRGCI1 = $emailVars->listes->RGCI1;
                         if (!is_null($firstComment)) {
                                $urlRGCI1 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}/com/{$firstComment}";
                            } else {
                                $urlRGCI1 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}";
                            }
                            $corpsMailRGCI1 = "Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande XPrice  {$trackingNumber}/{$numwp} à valider.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                            $mailRGCI1 = new Xsuite_Mail();
                            $mailRGCI1->setSubject(" XPrice : Nouvelle Offre Xprice {$trackingNumber}/{$numwp} à valider de {$user_info['nom_user']} pour $clientsnom")
                                    ->setBodyText(sprintf($corpsMailRGCI1, $urlRGCI1))
                                    ->addTo($destinataireMailRGCI1)
                                    ->send();
                    } elseif ( $user_info['id_user']==97 ||$user_info['id_user']==184 || $user_info['id_user']==217) {
                        $destinataireMailRGCI2 = $emailVars->listes->RGCI2;
                         if (!is_null($firstComment)) {
                                $urlRGCI2 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}/com/{$firstComment}";
                            } else {
                                $urlRGCI2 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}";
                            }
                            $corpsMailRGCI2 = "Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande XPrice  {$trackingNumber}/{$numwp} à valider.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                            $mailRGCI2 = new Xsuite_Mail();
                            $mailRGCI2->setSubject(" XPrice : Nouvelle Offre Xprice {$trackingNumber}/{$numwp} à valider de {$user_info['nom_user']} pour $clientsnom")
                                    ->setBodyText(sprintf($corpsMailRGCI2, $urlRGCI2))
                                    ->addTo($destinataireMailRGCI2)
                                    ->send();
                    } 
                    elseif ( $user_info['id_user']==20 ||$user_info['id_user']==34 || $user_info['id_user']==199) {
                        $destinataireMailRGCI3 = $emailVars->listes->RGCI3;
                         if (!is_null($firstComment)) {
                                $urlRGCI3 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}/com/{$firstComment}";
                            } else {
                                $urlRGCI3 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}";
                            }
                            $corpsMailRGCI3 = "Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande XPrice  {$trackingNumber}/{$numwp} à valider.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                            $mailRGCI3 = new Xsuite_Mail();
                            $mailRGCI3->setSubject(" XPrice : Nouvelle Offre Xprice {$trackingNumber}/{$numwp} à valider de {$user_info['nom_user']} pour $clientsnom")
                                    ->setBodyText(sprintf($corpsMailRGCI3, $urlRGCI3))
                                    ->addTo($destinataireMailRGCI3)
                                    ->send();
                    } 
                    else {
                        $corpsMail = "tagada";
                        $mailto = $info_user['email_user'];
                        $mail = new Xsuite_Mail;
                        $mail->setSubject("plop")
                                ->setBodyText(sprintf($corpsMail))
                                ->addTo($mailto)
                                ->send();
                    }
                    /*
                     * FIN DE PAS TOUCHER
                     * Fin du traitement
                     */
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "Votre demande a bien été enregistrée.";
                    $flashMessenger->addMessage($message);
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->gotoSimple('index', 'xprice');
                } else {
                    $form->populate($formData);
                }
            }
            $this->view->form = $form;
        }
    }

    protected function genererValidation($datas) {
        $dbtValidation = new Application_Model_DbTable_Validationsdemandexprices();
        $now = new Datetime();
        $commentaire = (!is_null($datas['commentaire']) && trim($datas['commentaire']) != "") ? trim($datas['commentaire']) : null;
        $validations_demande_xprices_id = (array_key_exists('reponse', $datas) && trim($datas['reponse']) != "") ? $datas['reponse'] : null;
        $dbtValidation->createValidation(
                $datas['nom_validation'], $now->format('Y-m-d H:i:s'), $datas['validation'], $datas['id_user'], $datas['id_demande_xprice'], $commentaire, $validations_demande_xprices_id);
        if (!is_null($commentaire)) {
            return $dbtValidation->lastId();
        } else {
            return null;
        }
    }

   

    public function validatechefregionAction() {
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->cdr = $tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
        $user_id = $info_demande_xprice['id_user'];
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        $numwp_client=$info_demande_xprice['numwp_client'];
        $id_holon=$info_user['id_holon'];
        $holonuser = new Application_Model_DbTable_Holons();
        $holonuser1 = $holonuser->getHolon($id_holon);
        $nom_holon = $holonuser1['nom_holon'];
        $this->view->holon = $nom_holon;
        $this->view->info_demande_xprice = $info_demande_xprice;
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice['date_demande_xprice']);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        /*
         * on recherche si la validation existe déjà ou si elle est en attente;
         */
        $nomvalidationrecherche = "cdr";
        $tracking = $info_demande_xprice['tracking_number_demande_xprice'];
        $recherchevalidation = new Application_Model_DbTable_Validationsxprice();
        $recherchesvalidation = $recherchevalidation->getValidation($nomvalidationrecherche, $tracking);
        $infos_user = new Application_Model_DbTable_Users();
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice['id_demande_xprice']);

        $this->view->validations = $validationsDemandesXprices;
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['description_fonction'];
        }
        $this->view->usersValidations = $usersValidations;
        /*
         * Fin du chargement des validations
         */

        $info_user = $infos_user->getUserDemande($user_id);

        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($numwp_client);
       // echo '<pre>',var_export($info_client),'</pre>';
        $this->view->info_client = $info_client[0];
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client[0]['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        $nomclients = trim($info_client[0]['nom_client']);
        $blocages=new Application_Model_DbTable_Validationsdemandexprices();
        $validationdbd="dbd";
        $blocage = $blocages->getValidation( $validationdbd, $info_demande_xprice['id_demande_xprice']);
        //var_dump($blocage);
        foreach ($blocage as $blocs){
        $bloc = $blocs['etat_validation'];
        
        if($bloc == "validee" || $bloc =="nonValide" || $bloc=="fermee"){
            if($bloc=="validee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "vous avez déjà validée cette offre.";
                $flashMessenger->addMessage($message1);}    
                elseif($bloc=="nonValide"){
                 $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre a déjà été refusée.";
                $flashMessenger->addMessage($message1);
                }
                elseif($bloc=="fermee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre est fermée.";
                $flashMessenger->addMessage($message1);
                }
             $redirector = $this->_helper->getHelper('Redirector');
        $redirector->gotoSimple('index', 'xprice');}
        else {
            $this->view->messages = array_merge(
                $this->_helper->flashMessenger->getMessages(),
                $this->_helper->flashMessenger->getCurrentMessages()
            );
            $this->_helper->flashMessenger->clearCurrentMessages();
        }
        }
        if ($this->getRequest()->isPost()) {
            $date_validation = date("Y-m-d H:i:s");
            $this->view->date_validation = $date_validation;
            $nom_validation = "cdr";
            $formData = $this->getRequest()->getPost();

            $nouvelle_validation = new Application_Model_DbTable_Validationsxprice();
            $nouv_validation = $nouvelle_validation->createValidation($formData['nom_validation'], $formData['date_validation'], $formData['validation'], $formData['commentaire_chefregion'], $formData['cdr'], $formData['tracking']);
            $valid_id_valid = new Application_Model_DbTable_Validationsxprice();
            $valid_id_valids = $valid_id_valid->getValidation($formData['nom_validation'], $formData['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $formData['validation'],
                'commentaire' => $formData['commentaire_chefregion'],
                'id_user' => $formData['cdr'], 'id_demande_xprice' => $info_demande_xprice['id_demande_xprice']
            );
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
            /*
             * si la variable $validation existe et qu'elle est égale à "validee"
             *  alors on insert dans la table validation:  la date de validation ,
             *  le nom de la validation , le numwp,l'id_user du cdr,
             * on envoi un email au tc qui a créer la demande , et on envoi un mail au cm pour qu'il la valide également
             */
            $emailVars = Zend_Registry::get('emailVars');
            if (isset($formData['validation']) && $formData['validation'] == "validee") {
//                $params1 = array();
//                $params1['destinataireMail'] = $info_user['email_user'] ;
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
//                $params1['corpsMail'] = "Bonjour,\n"
//                        . "\n"
//                        . "Votre demande XPrice $tracking/$numwp a été validée par .\n"
//                        . "Vous pouvez la consulter à cette adresse url : \n"
//                        . "%s"
//                        . "\n\n"
//                        . "Cordialement,\n"
//                        . "\n"
//                        . "--\n"
//                        . "Prix fobfr.";
//                $params1['sujet'] = "TEST XPrice :la demande Xprice $numwp/$tracking pour le client $nomclients validée par votre chef de région.";
//                $this->sendEmail($params1);
                /*
                 * on recherche le chef de marche correspondant auquel la demande s'adresse
                 */

                $destIndustry = $info_client['id_industry'];
                $params2 = array();
                $params2['destinataireMail'] = $emailVars->listes->fobfr;
//                $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/prixfobfr/numwp/{$numwp}";
                if (!is_null($commentId)) {
                    $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/prixfobfr/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/prixfobfr/numwp/{$numwp}";
                }
                $params2['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XPrice $tracking/$numwp à valider {$info_user['nom_user']} pour le client $nomclients.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice";
                $params2['sujet'] = " XPrice : Nouvelle demande Xprice $tracking/$numwp à valider de {$info_user['nom_user']} pour le client $nomclients.";
                $this->sendEmail($params2);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande a été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
            /*
             * si la variable $validation existe et qu'elle est égale à "nonValide"
             * alors envoi mail tc et insertion dans la table validation
             */ elseif (isset($formData['validation']) && $formData['validation'] == "nonValide") {
                $params1 = array();
                $params1['destinataireMail'] = $info_user['email_user'] ;
                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                $params1['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $tracking/$numwp a été refusée pour le client $nomclients par .\n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice.";
                $params1['sujet'] = " XPrice :demande $tracking/$numwp refusée par votre chef de région.";
                $this->sendEmail($params1);

                $message = "la demande a été refusée.";
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
            /*
             * si la variable $validation existe et est égale à enAttente,
             * envoi de mail au tc pour qu'il réponde à la question posé dans le commentaire,
             * et enregistrement dans la table validation
             */ elseif (isset($formData['validation']) && $formData['validation'] == "enAttente") {
                $idvalidhisto = new Application_Model_DbTable_Validationsxprice();
                $lastidvalid = $idvalidhisto->getValidation($formData['nom_validation'], $formData['tracking']);
                $newhistocomm = new Application_Model_DbTable_HistoriqueCommentaire();
                $newhisto = $newhistocomm->createHistorique($formData['tracking'], $lastidvalid[0]['id_validation'], $info_user['id_user']);
                $lastidhisto = new Application_Model_DbTable_HistoriqueCommentaire();
                $lasthisto = $lastidhisto->getHistorique($formData['tracking'], $lastidvalid[0]['id_validation']);

                $params1 = array();
                $params1['destinataireMail'] = $info_user['email_user'];
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}/histo/{$lasthisto[0]['id_histo_commentaire']}";
                if (!is_null($commentId)) {
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}";
                }

                $params1['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $tracking/$numwp pour le client $nomclients est en attente d'une réponse de votre part.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice.";
                $params1['sujet'] = " XPrice :demande Xprice $tracking/$numwp pour le client $nomclients en attente de réponse.";
                $this->sendEmail($params1);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande est en attente de réponse du commercial.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
        }
    }

    public function validatedbdAction() {
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->dbd = $tiltop;
        $nom_validation = 'dbd';
        $this->nom_validation = $nom_validation;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
        $this->view->info_demande_xprice = $info_demande_xprice;
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice['date_demande_xprice']);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        //echo '<pre>',var_export($info_user),'</pre>';
        $id_holon=$info_user['id_holon'];
        $holonuser = new Application_Model_DbTable_Holons();
        $holonuser1 = $holonuser->getHolon($id_holon);
        $nom_holon = $holonuser1['nom_holon'];
        $this->view->holon = $nom_holon;
        $trackingNumber=$info_demande_xprice['tracking_number_demande_xprice'];
        $zonetracking = substr($trackingNumber, 6, 2);
        $fonctioncreateur = $info_user['id_fonction'];
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice['id_demande_xprice']);

        $this->view->validations = $validationsDemandesXprices;
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        /*essai valid en cours*/
        $encours = new Application_Model_DbTable_Validationsdemandexprices();
        $encours1 = $encours->getValidForEncours($numwp);
       $i = (count($encours1)-1);
       $plop2=$encours1[$i]['etat_validation'] ;
       $plop3=$encours1[$i]['nom_validation'] ;
       if($plop2 =="validee" || $plop2=="validée"){
        switch ($plop3) {
            case "cdr":
                $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";

                break;
            case "fobfr":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="François Delauge";
                $encoursNom="encours";
                break;
            default:
                break;
        }
    }
    elseif($plop2=="creation"){
           $encoursFonction="chef de région";
           $encoursNom="encours";
       }
       elseif($plop2=="enAttente"){
           switch ($plop3) {
               case "reponse":
                  $encoursFonction=$info_user['nom_user'].' '. $info_user['prenom_user'];
                $encoursNom="encours"; 
                break;
            case "cdr":
                $encoursFonction="chef de région";
                $encoursNom="encours";
                break;
            case "fobfr":
                 $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            default:
                break;
        }
       }
        $this->view->encoursFonction = $encoursFonction;
        $this->view->encoursNom=$encoursNom;
        /*fin essai valid en cours*/
        /*
         * Fin du chargement des validations
         */

        $this->view->info_user = $info_user;

        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
        $this->view->info_client = $info_client[0];
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client[0]['id_industry']);
        $destIndustry = $info_client[0]['id_industry'];
        $this->view->nom_industrie = $nom_industrie;
        $infos_validation = new Application_Model_DbTable_Validationsxprice();
        $info_validation = $infos_validation->getAllValidation($info_demande_xprice['tracking_number_demande_xprice']);
        $this->view->info_validation = $info_validation;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        
        /*bloquage de la demande déjà validée */
        
        $blocages=new Application_Model_DbTable_Validationsdemandexprices();
        $blocage = $blocages->getValidation($nom_validation, $info_demande_xprice['id_demande_xprice']);
        //var_dump($blocage);
        foreach ($blocage as $blocs){
        $bloc = $blocs['etat_validation'];
        
        if($bloc == "validee" || $bloc =="nonValide" || $bloc=="fermee"){
            if($bloc=="validee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "vous avez déjà validée cette offre.";
                $flashMessenger->addMessage($message1);}    
                elseif($bloc=="nonValide"){
                 $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre a déjà été refusée.";
                $flashMessenger->addMessage($message1);
                }
                elseif($bloc=="fermee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre est fermée.";
                $flashMessenger->addMessage($message1);
                }
             $redirector = $this->_helper->getHelper('Redirector');
        $redirector->gotoSimple('index', 'xprice');}
        else {
            $this->view->messages = array_merge(
                $this->_helper->flashMessenger->getMessages(),
                $this->_helper->flashMessenger->getCurrentMessages()
            );
            $this->_helper->flashMessenger->clearCurrentMessages();
        }
        }
        $nomclients= trim($info_client[0]['nom_client']);
        if ($this->getRequest()->isPost()) {
            $date_validation = date("Y-m-d H:i:s");
            $this->view->date_validation = $date_validation;
            $nom_validation = 'dbd';
            $this->nom_validation = $nom_validation;
            $datas = $this->getRequest()->getPost();
//            echo '<pre>',var_export($datas),'</pre>';exit();
           $etatValide= $datas['validation'];
            $prix_accordes = array_combine($datas['code_article'], $datas['prix_accorde_article']);
            $remise_accordes = array_combine($datas['code_article'], $datas['remise_accorde_article']);
            $marge = array_combine($datas['code_article'],$datas['marge_demande_article']); 
            foreach ($remise_accordes as $key => $value) {
                $remisesDirco = new Application_Model_DbTable_DemandeArticlexprices();
                $remiseDirco = $remisesDirco->insertRemiseAccorde($value, $key, $datas['tracking']);
            }
            foreach ($prix_accordes as $key => $value) {
                $prixDirco = new Application_Model_DbTable_DemandeArticlexprices();
                $priDirco = $prixDirco->insertPrixAccorde($value, $key, $datas['tracking']);
            }
            foreach($marge as $key=>$value){
                $margeinit=new Application_Model_DbTable_DemandeArticlexprices();
                $marges = $margeinit->updateMarge($value,$key,$datas['tracking']); 
               
            }
//            }
 $margemin = false;
          
            foreach ($marge as $key => $value2) {
                $margesmc = substr($value2,0,-1);
                if ($margesmc < 0) {
                    $margemin = true;   
                } 
            }
            $mamo=  substr($datas['mamo'], 0,-1);
            //echo  '<pre>',var_export($datas['validation']),'</pre>';
            //echo '<pre>',var_export($margemin),'</pre>';
          
            //echo '<pre>', var_export($mamo),'</pre>';
            if($margemin==false && $mamo >=10 && $datas['validation']=="validee"){
                $datas['validation']="fermee";
            }elseif($margemin==false && $mamo >=10 && $datas['validation']=="nonValide"){
                 $datas['validation']="nonValide";
            }
           //echo  '<pre>',var_export($datas['validation']),'</pre>';
          //exit();
            $nouvelle_validation = new Application_Model_DbTable_Validationsxprice();
            $nouv_validation = $nouvelle_validation->createValidation(
                    $nom_validation, $date_validation, $datas['validation'], $datas['commentaire_dbd'], $user->id_user, $datas['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $datas['validation'], 'commentaire' => $datas['commentaire_dbd'],
                'id_user' => $user->id_user, 'id_demande_xprice' => $info_demande_xprice['id_demande_xprice']
            );
            if (array_key_exists('reponse', $datas)) {
                $datasValidation['reponse'] = $datas['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
$mailServiceClient = new Application_Model_DbTable_Xprices();
$mailServiceClients = $mailServiceClient->getServiceClient($numwp);
if($mailServiceClients[0]['mail_service_client']=='regionNord'){
    $mailSC="regionnord@smc-france.fr";
} elseif($mailServiceClients[0]['mail_service_client']== 'regionSud'){
    $mailSC="regionsud@smc-france.fr";
}elseif($mailServiceClients[0]['mail_service_client']== 'regionEst'){
    $mailSC="regionest@smc-france.fr";
}elseif($mailServiceClients[0]['mail_service_client']== 'regionOuest'){
    $mailSC="regionouest@smc-france.fr";
}elseif ($mailServiceClients[0]['mail_service_client']== 'grandcompte'){
    $mailSC="SCommande@smc-france.fr";
}elseif($mailServiceClients[0]['mail_service_client']=='' || $mailServiceClients[0]['mail_service_client']== NULL){
    $mailSC=$emailVars->listes->serviceClient;
}
elseif($mailServiceClients[0]['mail_service_client']== 'export'){
    $mailSC="export@smc-france.fr";
}
            $emailVars = Zend_Registry::get('emailVars');
            if (isset($datas['validation']) && $datas['validation'] == "validee") {
                $params1 = array();
                
                
                 if ($margemin == true or $datas['mamo']<=10){
                 // $params['destinataireMail'] = $info_user['email_user'] ;
                  $params1['destinataireMail'] = $emailVars->listes->Dirco;
                if (!is_null($commentId)) {
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/validatedirco/numwp/{$numwp}";
                } else {
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/validatedirco/numwp/{$numwp}";
                }

                $params1['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider .\n"
                        . "Vous pouvez la valider à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params1['sujet'] = "  XPrice :nouvelle demande Xprice $trackingNumber/$numwp à valider $numwp de {$info_user['nom_user']} pour le client $nomclients .";
                
                $this->sendEmail($params1);
            }
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp  pour le client $nomclients a bien été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
                
                 
                 elseif(isset($datas['validation']) && $datas['validation'] == "fermee"){
                     /*envoi de mail au tc, au cdr, au leader, au cm et au service client.*/
                $params2 = array();
                $params3 = array();
                $params4 = array();
                $params5 = array();
                $params6 = array();
                    $params2['destinataireMail'] = $info_user['email_user'];
                    
                    $params3['destinataireMail'] =$mailSC;/* "mhuby@smc-france.fr";*/
                     if (!is_null($commentId)) {
                    $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}/com/{$commentId}";
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                    } else {
                    $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                    }
                    $params2['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $trackingNumber/$numwp a été validée par le Directeur Business Developpement .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                    $params2['sujet'] = " XPrice :demande Xprice $trackingNumber/$numwp pour $nomclients validée par Directeur Business Developpement.";
                    $params3['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params3['sujet'] = "  XPrice : la demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée .";
                
                $this->sendEmail($params2);
                $this->sendEmail($params3);
                //envoi au leader 
                if ($fonctioncreateur == "1") {
                        switch ($id_holon) {
                            case "5":
                                $params4['destinataireMail'] = $emailVars->listes->leaderis01;
                                break;
                            case "6":
                                $params4['destinataireMail'] = $emailVars->listes->leaderis03;
                                break;
                            case "8":
                                $params4['destinataireMail'] = $emailVars->listes->leaderiw01;
                                break;
                            case "9":
                                $params4['destinataireMail'] = $emailVars->listes->leaderiw02;
                                break;
                            case "10":
                                $params4['destinataireMail'] = $emailVars->listes->leaderiw03;
                                break;
                            case "11":
                                $params4['destinataireMail'] = $emailVars->listes->leaderis02;
                                break;
                            case "14":
                                $params4['destinataireMail'] = $emailVars->listes->leaderiw04;
                                break;
                            case "18":
                                $params4['destinataireMail'] = $emailVars->listes->leaderin01;
                                break;
                            case "19":
                                $params4['destinataireMail'] = $emailVars->listes->leaderin02;
                                break;
                            case "20":
                                $params4['destinataireMail'] = $emailVars->listes->leaderin03;
                                break;
                             case "31":
                                $params4['destinataireMail'] = $emailVars->listes->leaderiw08;
                                break;
                        }
                         $params4['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";

                         $params4['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le DBD.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params4['sujet']=" XPrice :  Offre Xprice $trackingNumber/$numwp  de {$info_user['nom_user']} pour $nomclients validée par le DBD";
                      $this->sendEmail($params4);           
                    }
                //envoi au cdr
                if ($fonctioncreateur == "1" or $fonctioncreateur == "2" or $fonctioncreateur == "3") {
                        switch ($zonetracking) {
                            case "QA":
                               $params5['destinataireMail'] = $emailVars->listes->QA;
                                break;
                            case "QC":
                                $params5['destinataireMail'] = $emailVars->listes->CDRNORD;
                                break;
                            case "QF":
                                $params5['destinataireMail'] = $emailVars->listes->CDRNORD;
                                break;
                            case "QE":
                                $params5['destinataireMail'] = $emailVars->listes->CDREST;
                                break;
                            case "QH":
                                $params5['destinataireMail'] = $emailVars->listes->CDREST;
                                break;
                            case "QI":
                                $params5['destinataireMail'] = $emailVars->listes->CDROUEST;
                                break;
                            case "QK":
                                $params5['destinataireMail'] = $emailVars->listes->CDROUEST;
                                break;
                        }
                        $params5['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";

                         $params5['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le DBD.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params5['sujet']=" XPrice :Offre Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour $nomclients validée par le DBD";
                      $this->sendEmail($params5); 
                    }
                    $car1=array(1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,18,19,59,73,74,75,76);
                    $car2=array(14,17,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,
                        37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,
                        60,61,62,63,64,65,66,67,68,69,70,71,72);
                    $LS=array(77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,
                        97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,
                        114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,
                        130,131,132,133,134,135,136,137);
                    $Elec=array(138,139,140,141,142,143,144,145,146,147,148,149,150,151,
                        152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167
                        ,168,169,170,170,172,173,174,175,176,177,178,179,180,181,182,183,
                        184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,
                        201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,
                        218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,
                        236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253
                        ,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271);
                    $food=array(273,274,275,276,277,278,279,280,291,292,293,294,304,305,306,307,308);
                    $food1=array(272,281,282,283,284,285,286,287,288,289,290,295,296,297,298,299,300,301,302,303,309,310,311,312,313);
                    $EE=array(314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,
                        330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,
                        348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,
                        366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,
                        384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,
                        402,403,404,405,406,407,408,409,410,411,412,413,414,415);
                            
                if(in_array($destIndustry, $car1)){
                        $destinataireMail2 = $emailVars->listes->carIndustries1;
                    }elseif(in_array($destIndustry, $car2)){
                        $destinataireMail2 = $emailVars->listes->carIndustries;
                    }elseif(in_array($destIndustry, $Elec)){
                       $destinataireMail2 = $emailVars->listes->Electronique;
                    }
                $params6['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                $params6['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande XPrice $numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le DBD.\n"
                        . "Pour consulter la demande Xprice $trackingNumber/$numwp veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice";
                $params6['destinataireMail'] = $destinataireMail2;
                $params6['sujet'] = " XPrice : La demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le DBD.";
                $this->sendEmail($params6);
                   $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp  pour le client $nomclients a bien été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice'); 
                
                 }
                
            elseif (isset($datas['validation']) && $datas['validation'] == 'enAttente') {
                $params = array();
                $params['destinataireMail'] = $info_user['email_user'];
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $trackingNumber/$numwp pour le client $nomclients est en attente de réponse à la question posée par dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params['sujet'] = " XPrice :demande Xprice $trackingNumber/$numwp mise en attente par Directeur Business Developpement.";
                $this->sendEmail($params);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp est en attente de réponse du commercial.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            } elseif (isset($datas['validation']) && $datas['validation'] == 'nonValide') {
                $params = array();
                $params['destinataireMail'] = $info_user['email_user'];
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $trackingNumber/$numwp pour le client $nomclients est non validée par dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params['sujet'] = "  XPrice :demande Xprice $trackingNumber/$numwp pour le client $nomclients non validée par dbd.";
                $this->sendEmail($params);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp n'a pas été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
        }
    }

    public function validatedircoAction() {
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->dirco = $tiltop;
        $nom_validation = 'dirco';
        $this->nom_validation = $nom_validation;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
        $this->view->info_demande_xprice = $info_demande_xprice;
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice['date_demande_xprice']);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        $id_holon=$info_user['id_holon'];
        $holonuser = new Application_Model_DbTable_Holons();
        $holonuser1 = $holonuser->getHolon($id_holon);
        $nom_holon = $holonuser1['nom_holon'];
        $this->view->holon = $nom_holon;
        $trackingNumber=$info_demande_xprice['tracking_number_demande_xprice'];
        $zonetracking = substr($trackingNumber, 6, 2);
        $fonctioncreateur = $info_user['id_fonction'];
        

        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice['id_demande_xprice']);

        $this->view->validations = $validationsDemandesXprices;
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] =$userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
         /*essai valid en cours*/
        $encours = new Application_Model_DbTable_Validationsdemandexprices();
        $encours1 = $encours->getValidForEncours($numwp);
       $i = (count($encours1)-1);
       $plop2=$encours1[$i]['etat_validation'] ;
       $plop3=$encours1[$i]['nom_validation'] ;
       if($plop2 =="validee" || $plop2=="validée"){
        switch ($plop3) {
            case "cdr":
                $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";

                break;
            case "fobfr":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="François Delauge";
                $encoursNom="encours";
                break;
            default:
                break;
        }
    }
    elseif($plop2=="creation"){
           $encoursFonction="chef de région";
           $encoursNom="encours";
       }
       elseif($plop2=="enAttente"){
           switch ($plop3) {
               case "reponse":
                  $encoursFonction=$info_user['nom_user'].' '. $info_user['prenom_user'];
                $encoursNom="encours"; 
                break;
            case "cdr":
                $encoursFonction="chef de région";
                $encoursNom="encours";
                break;
            case "fobfr":
                 $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            default:
                break;
        }
       }
        $this->view->encoursFonction = $encoursFonction;
        $this->view->encoursNom=$encoursNom;
        /*fin essai valid en cours*/
        /*
         * Fin du chargement des validations
         */
        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
//        echo '<pre>',var_export($info_client),'</pre>';
        $this->view->info_client = $info_client[0];
         $nomclients= trim($info_client[0]['nom_client']);
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client[0]['id_industry']);
        $destIndustry = $info_client[0]['id_industry'];
        $this->view->nom_industrie = $nom_industrie;
        $infos_validation = new Application_Model_DbTable_Validationsxprice();
        $info_validation = $infos_validation->getAllValidation($info_demande_xprice['tracking_number_demande_xprice']);
        $this->view->info_validation = $info_validation;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        /*bloquage de la demande déjà validée */
        
        $blocages=new Application_Model_DbTable_Validationsdemandexprices();
        $blocage = $blocages->getValidation($nom_validation, $info_demande_xprice['id_demande_xprice']);
       // var_dump($blocage);
        $bloc = $blocage[0]['etat_validation'];
        if($bloc == "fermee"){
             $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "vous avez déjà validée cette offre.";
                $flashMessenger->addMessage($message1);
             $redirector = $this->_helper->getHelper('Redirector');
             $redirector->gotoSimple('index', 'xprice');
        }
        if ($this->getRequest()->isPost()) {
            $date_validation = date("Y-m-d H:i:s");
            $this->view->date_validation = $date_validation;
            $nom_validation = 'dirco';
            $this->nom_validation = $nom_validation;
            $formData = $this->getRequest()->getPost();
            $datas = $this->getRequest()->getPost();
            $nomclients=trim($info_client[0]['nom_client']);
            $prix_accordes = array_combine($datas['code_article'], $datas['prix_accorde_article']);
            $remise_accordes = array_combine($datas['code_article'], $datas['remise_accorde_article']);

            foreach ($remise_accordes as $key => $value) {
                $remisesDirco = new Application_Model_DbTable_DemandeArticlexprices();
                $remiseDirco = $remisesDirco->insertRemiseAccorde($value, $key, $datas['tracking']);
                $marge = array_combine($datas['code_article'],$datas['marge_demande_article']);
            }
            foreach ($prix_accordes as $key => $value) {
                $prixDirco = new Application_Model_DbTable_DemandeArticlexprices();
                $priDirco = $prixDirco->insertPrixAccorde($value, $key, $datas['tracking']);
            }
            foreach($marge as $key=>$value){
                $margeinit=new Application_Model_DbTable_DemandeArticlexprices();
                $marges = $margeinit->updateMarge($value,$key,$datas['tracking']);
            }
            $nouvelle_validation = new Application_Model_DbTable_Validationsxprice();
            $nouv_validation = $nouvelle_validation->createValidation($nom_validation, $date_validation, $datas['validation'], $datas['commentaire_dirco'], $user->id_user, $datas['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $formData['validation'],
                'commentaire' => $formData['commentaire_dirco'],
                'id_user' => $user->id_user, 'id_demande_xprice' => $info_demande_xprice['id_demande_xprice']
            );
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
$mailServiceClient = new Application_Model_DbTable_Xprices();
$mailServiceClients = $mailServiceClient->getServiceClient($numwp);
if($mailServiceClients[0]['mail_service_client']=='regionNord'){
    $mailSC="regionnord@smc-france.fr";
} elseif($mailServiceClients[0]['mail_service_client']== 'regionSud'){
    $mailSC="regionsud@smc-france.fr";
}elseif($mailServiceClients[0]['mail_service_client']== 'regionEst'){
    $mailSC="regionest@smc-france.fr";
}elseif($mailServiceClients[0]['mail_service_client']== 'regionOuest'){
    $mailSC="regionouest@smc-france.fr";
}elseif ($mailServiceClients[0]['mail_service_client']== 'grandcompte'){
    $mailSC="SCommande@smc-france.fr";
}elseif ($mailServiceClients[0]['mail_service_client']== 'export'){
    $mailSC="export@smc-france.fr";
}
elseif($mailServiceClients[0]['mail_service_client']=='' || $mailServiceClients[0]['mail_service_client']== NULL){
    $mailSC=$emailVars->listes->serviceClient;
}
            $emailVars = Zend_Registry::get('emailVars');
            $params = array();
            $params1 =array();
            $params2 = array();
            $params3=  array();
            $params4=  array();
            $params5 = array();
            if (isset($formData['validation']) && $formData['validation'] == "fermee") {
                $params['destinataireMail'] = $info_user['email_user'];
                $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $trackingNumber/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params['sujet'] = " XPrice :demande Xprice  $trackingNumber/$numwp pour le client $nomclients validée par Directeur Commercial.";
                $this->sendEmail($params);
                $params1['destinataireMail'] =$mailSC;
                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                $params1['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande XPrice $trackingNumber/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params1['sujet'] = "  XPrice :demande Xprice $trackingNumber/$numwp pour le client $nomclients validée par Directeur Commercial.";
                $this->sendEmail($params1);
//envoi mail leader
                if ($fonctioncreateur == "1") {
                        switch ($id_holon) {
                            case "5":
                                $params2['destinataireMail'] = $emailVars->listes->leaderis01;
                                break;
                            case "6":
                                $params2['destinataireMail'] = $emailVars->listes->leaderis03;
                                break;
                            case "8":
                                $params2['destinataireMail'] = $emailVars->listes->leaderiw01;
                                break;
                            case "9":
                                $params2['destinataireMail'] = $emailVars->listes->leaderiw02;
                                break;
                            case "10":
                                $params2['destinataireMail'] = $emailVars->listes->leaderiw03;
                                break;
                            case "11":
                                $params2['destinataireMail'] = $emailVars->listes->leaderis02;
                                break;
                            case "14":
                                $params2['destinataireMail'] = $emailVars->listes->leaderiw04;
                                break;
                            case "18":
                                $params2['destinataireMail'] = $emailVars->listes->leaderin01;
                                break;
                            case "19":
                                $params2['destinataireMail'] = $emailVars->listes->leaderin02;
                                break;
                            case "20":
                                $params2['destinataireMail'] = $emailVars->listes->leaderin03;
                                break;
                        }
                         $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";

                         $params2['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params2['sujet']=" XPrice :  Offre Xprice  $trackingNumber/$numwp  de {$user_info['nom_user']} pour $nomclients validée par le Dirco";
                      $this->sendEmail($params2);           
                    }
                    //envoi au cdr
                if ($fonctioncreateur == "1" or $fonctioncreateur == "2" or $fonctioncreateur == "3") {
                        switch ($zonetracking) {
                            case "QA":
                               $params3['destinataireMail'] = $emailVars->listes->QA;
                                break;
                            case "QC":
                                $params3['destinataireMail'] = $emailVars->listes->CDRNORD;
                                break;
                            case "QF":
                                $params3['destinataireMail'] = $emailVars->listes->CDRNORD;
                                break;
                            case "QE":
                                $params3['destinataireMail'] = $emailVars->listes->CDREST;
                                break;
                            case "QH":
                                $params3['destinataireMail'] = $emailVars->listes->CDREST;
                                break;
                            case "QI":
                                $params3['destinataireMail'] = $emailVars->listes->CDROUEST;
                                break;
                            case "QK":
                                $params3['destinataireMail'] = $emailVars->listes->CDROUEST;
                                break;
                        }
                        $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";

                        $params3['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params3['sujet']=" XPrice :Offre Xprice  $trackingNumber/$numwp de {$user_info['nom_user']} pour $nomclients validée par le Dirco";
                      $this->sendEmail($params3); 
                    }
                    $car1=array(1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,18,19,59,73,74,75,76);
                    $car2=array(14,17,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,
                        37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,
                        60,61,62,63,64,65,66,67,68,69,70,71,72);
                    $LS=array(77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,
                        97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,
                        114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,
                        130,131,132,133,134,135,136,137);
                    $Elec=array(138,139,140,141,142,143,144,145,146,147,148,149,150,151,
                        152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167
                        ,168,169,170,170,172,173,174,175,176,177,178,179,180,181,182,183,
                        184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,
                        201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,
                        218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,
                        236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253
                        ,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271);
                    $food=array(273,274,275,276,277,278,279,280,291,292,293,294,304,305,306,307,308);
                    $food1=array(272,281,282,283,284,285,286,287,288,289,290,295,296,297,298,299,300,301,302,303,309,310,311,312,313);
                    $EE=array(314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,
                        330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,
                        348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,
                        366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,
                        384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,
                        402,403,404,405,406,407,408,409,410,411,412,413,414,415);
                    if(in_array($destIndustry, $car1)){
                        $destinataireMail2 = $emailVars->listes->carIndustries1;
                    }elseif(in_array($destIndustry, $car2)){
                        $destinataireMail2 = $emailVars->listes->carIndustries;
                    }elseif(in_array($destIndustry, $Elec)){
                       $destinataireMail2 = $emailVars->listes->Electronique;
                    }
                $params4['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                $params4['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande XPrice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                        . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice";
                $params4['destinataireMail'] = $destinataireMail2;
                $params4['sujet'] = " XPrice : La demande Xprice  $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le Dirco.";
                $this->sendEmail($params4);
                 $params5['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                $params5['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande XPrice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                        . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice";
                $params5['destinataireMail'] = $emailVars->listes->DBD;
                $params5['sujet'] = " XPrice : La demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été validée par le Dirco.";
                $this->sendEmail($params5);
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp pour le client$nomclients a bien été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
                
            } elseif (isset($formData['validation']) && $formData['validation'] == 'enAttente') {
                $emailVars = Zend_Registry::get('emailVars');
                $params['destinataireMail'] =$info_user['email_user'] ;
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $trackingNumber/$numwp est en attente de réponse à la question posée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params['sujet'] = " XPrice :demande $numwp pour le client $nomclients est mise en attente par le Directeur Commercial.";
                $this->sendEmail($params);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre Xprice $trackingNumber/$numwp pour le client $nomclients est en attente de réponse du commercial.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            } elseif (isset($formData['validation']) && $formData['validation'] == 'nonValide') {
                $emailVars = Zend_Registry::get('emailVars');
                $params['destinataireMail'] = $info_user['email_user'];
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XPrice $trackingNumber/$numwp pour le client $nomclients n'est pas validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params['sujet'] = " XPrice :demande Xprice $trackingNumber/$numwp pour le client$nomclients non validée par Le Directeur Commercial.";
                $this->sendEmail($params);
                $params5['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/consult/numwp/{$numwp}";
                $params5['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande XPrice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été refusée par le Dirco.\n"
                        . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xprice";
                $params5['destinataireMail'] = $emailVars->listes->DBD;
                $params5['sujet'] = " XPrice : La demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients a été refusée par le Dirco.";
                $this->sendEmail($params5);
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp pour le client $nomclients n'a pas été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
        }
    }

    public function prixfobfrAction() {
        $user = $this->_auth->getStorage()->read();
// var_dump($user);
       
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
        $user_id = $info_demande_xprice['id_user'];
        $this->view->info_demande_xprice = $info_demande_xprice;
        $trackingNumber=$info_demande_xprice['tracking_number_demande_xprice'];
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice['date_demande_xprice']);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);

        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice['id_demande_xprice']);

        $this->view->validations = $validationsDemandesXprices;
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['description_fonction'];
        }
        $this->view->usersValidations = $usersValidations;
        /*
         * Fin du chargement des validations
         */
        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
        $this->view->info_client = $info_client[0];
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client[0]['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
//echo '<pre>',  var_export($info_demande_article_xprice,true),'</pre>';
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        $anneecourante = date('Y');
//$anneecourante=2018;
        foreach ($info_demande_article_xprice as $value) {
            $mmcono = "100";
            $division = "FR0";
            $facility = "I01";
            $type = "3";
            $warehouse = "I02";
            $supplier = "I990001";
            $agreement1 = "I000001";
            $agreement2 = "I000002";
            $agreement3 = "I000003";
//var_dump($value->code_article);
            $query = " select * from EIT.MVXCDTA.MPAGRP MPAGRP where MPAGRP.AJCONO = '$mmcono' AND MPAGRP.AJSUNO = '$supplier' AND (MPAGRP.AJAGNB = '$agreement3'  OR MPAGRP.AJAGNB = '$agreement2' OR MPAGRP.AJAGNB = '$agreement1') AND MPAGRP.AJOBV2 = '{$value['code_article']}' AND MPAGRP.AJOBV1 = '$division'  ORDER BY MPAGRP.AJAGNB";

            $infos_prixfobfr = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query));
//            if($infos_prixfobfr =""){
//                $anneecourante=date('Y')-1;
//                $query = "select *  from
//                    EIT.MVXCDTA.MCHEAD MCHEAD WHERE MCHEAD.KOITNO = '{$value['code_article']}'and substring(MCHEAD.KOPCDT,1,4) like '$anneecourante%'";
//                    $infos_prixfobfr = odbc_exec($this->odbc_conn2, $query);
//                    }

            $this->view->infos_prixfobfr = $infos_prixfobfr;
// echo '<pre>',  var_export($infos_prixfobfr),'<pre>';                exit();
        }
        $blocages=new Application_Model_DbTable_Validationsdemandexprices();
        $validationdbd="dbd";
        $blocage = $blocages->getValidation( $validationdbd, $info_demande_xprice['id_demande_xprice']);
        //var_dump($blocage);
        foreach ($blocage as $blocs){
        $bloc = $blocs['etat_validation'];
        
        if($bloc == "validee" || $bloc =="nonValide" || $bloc=="fermee"){
            if($bloc=="validee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "vous avez déjà validée cette offre.";
                $flashMessenger->addMessage($message1);}    
                elseif($bloc=="nonValide"){
                 $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre a déjà été refusée.";
                $flashMessenger->addMessage($message1);
                }
                elseif($bloc=="fermee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre est fermée.";
                $flashMessenger->addMessage($message1);
                }
             $redirector = $this->_helper->getHelper('Redirector');
        $redirector->gotoSimple('index', 'xprice');}
        else {
            $this->view->messages = array_merge(
                $this->_helper->flashMessenger->getMessages(),
                $this->_helper->flashMessenger->getCurrentMessages()
            );
            $this->_helper->flashMessenger->clearCurrentMessages();
        }
        }
        if ($this->getRequest()->isPost()) {
            $date_validationfobfr = date("Y-m-d H:i:s");
            $this->view->date_validationfobfr = $date_validationfobfr;
            $etat = "validée";
            $nom_validationfobfr = "fobfr";
            $formData = $this->getRequest()->getPost();
            $datas = $this->getRequest()->getPost();
            $nomclients=trim($info_client['nom_client']);
//            foreach ($formData as $datas) {
            $fobs = array_combine($datas['code_article'], $datas['prix_fob']);
            $cifs = array_combine($datas['code_article'], $datas['prix_cif']);
            $marges = array_combine($datas['code_article'],$datas['marge']);

            foreach ($cifs as $key => $value) {
                $prixcifs = new Application_Model_DbTable_DemandeArticlexprices();
                $prixcif = $prixcifs->updatecif($value, $key, $datas['tracking_number']);
            }
            foreach ($fobs as $key => $value) {
                $prixfobs = new Application_Model_DbTable_DemandeArticlexprices();
                $prixfob = $prixcifs->updatefob($value, $key, $datas['tracking_number']);
            }
            foreach ($marges as $key => $value){
                $margeinit = new Application_Model_DbTable_DemandeArticlexprices();
                $marge= $margeinit->insertMarge($value, $key, $datas['tracking_number']);
            }
            $validations = new Application_Model_DbTable_Validationsxprice();
            $validation = $validations->createValidation($nom_validationfobfr, $date_validationfobfr, $etat, $datas['commentaire_fobfr'], $user->id_user, $datas['tracking_number']);

            $datasValidation = array(
                'nom_validation' => $nom_validationfobfr, 'validation' => $etat,
                'commentaire' => $formData['commentaire_fobfr'],
                'id_user' => $user->id_user, 'id_demande_xprice' => $info_demande_xprice['id_demande_xprice']
            );
//            echo "<pre>", var_export($datasValidation, true), "</pre>";
//            exit();
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
//            }
            $emailVars = Zend_Registry::get('emailVars');
            $Mailsupply = $emailVars->listes->supplychain;
            $Mailfobfr = $emailVars->listes->fobfr;
            if (!is_null($commentId)) {
                $url = "http://{$_SERVER['SERVER_NAME']}/xprice/validatesupply/numwp/{$numwp}/com/{$commentId}";
            } else {
                $url = "http://{$_SERVER['SERVER_NAME']}/xprice/validatesupply/numwp/{$numwp}";
            }
            $corpsMail = "Bonjour,\n"
                    . "\n"
                    . "Vous avez une nouvelle demande XPrice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Prix fobfr.";
            $mail = new Xsuite_Mail();
            $mail->setSubject(" XPrice : Nouvelle demand Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider .")
                    ->setBodyText(sprintf($corpsMail, $url))
                    ->addTo($Mailsupply)
                    ->send();
            $corpsMail2 = "Bonjour,\n"
                    . "\n"
                    . "Vous avez une nouvelle demande XPrice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Prix fobfr.";
            $mail2 = new Xsuite_Mail();
            $mail2->setSubject(" XPrice : Nouvelle demand Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider .")
                    ->setBodyText(sprintf($corpsMail2, $url))
                    ->addTo($Mailfobfr)
                    ->send();
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "les prix fob et cif  ont bien été enregistrés.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xprice');
        } else {

        }
    }

    public function validatesupplyAction() {
        $user = $this->_auth->getStorage()->read();
// var_dump($user);
        $nom_validation = "supply";
        $numwp = $this->getRequest()->getParam('numwp', null);
// var_dump($numwp);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
//echo '<pre>', var_export($info_demande_xprice), '</pre>'; exit();
// var_dump( $info_demande_xprice['id_user']);
        $this->view->info_demande_xprice = $info_demande_xprice;
        $trackingNumber=$info_demande_xprice['tracking_number_demande_xprice'];
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice['date_demande_xprice']);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);

        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice['id_demande_xprice']);

        $this->view->validations = $validationsDemandesXprices;
//        echo "<pre>", var_export($validationsDemandesXprices, true), "</pre>";
//        exit();
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['description_fonction'];
        }
        $this->view->usersValidations = $usersValidations;
        /*
         * Fin du chargement des validations
         */

        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
        $this->view->info_client = $info_client[0];
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client[0]['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_validation = new Application_Model_DbTable_Validationsxprice();
        $info_validation = $infos_validation->getValidation($nom_validation, $info_demande_xprice['tracking_number_demande_xprice']);
        $this->view->info_validation = $info_validation;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
//        foreach ($info_demande_article_xprice as $value) {
//
//
//            $query = "select * from EIT.MVXCDTA.MCHEAD MCHEAD WHERE MCHEAD.KOITNO = '{$value['code_article']}' order by KOPCDT desc";
//            //echo $query ;
//            $infos_prixfobfr = odbc_exec($this->odbc_conn2, $query);
//            while ($info_prixfobfr = odbc_fetch_array($infos_prixfobfr)) {
//                $date1 = substr($info_prixfobfr['KOPCDT'], 0, -4);
//                $date2 = substr($info_prixfobfr['KOPCDT'], 4, -2);
//                $date3 = substr($info_prixfobfr['KOPCDT'], 6, 2);
//                $date = implode('-', array($date1, $date2, $date3));
//                $this->view->info_prixfobfr = $info_prixfobfr;
//            }
//        }
        /*bloquage de la demande déjà validée */
        
        $blocages=new Application_Model_DbTable_Validationsdemandexprices();
        $validationdbd="dbd";
        $blocage = $blocages->getValidation( $validationdbd, $info_demande_xprice['id_demande_xprice']);
        //var_dump($blocage);
        foreach ($blocage as $blocs){
        $bloc = $blocs['etat_validation'];
        
        if($bloc == "validee" || $bloc =="nonValide" || $bloc=="fermee"){
            if($bloc=="validee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "vous avez déjà validée cette offre.";
                $flashMessenger->addMessage($message1);}    
                elseif($bloc=="nonValide"){
                 $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre a déjà été refusée.";
                $flashMessenger->addMessage($message1);
                }
                elseif($bloc=="fermee"){
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message1 = "cette offre est fermée.";
                $flashMessenger->addMessage($message1);
                }
             $redirector = $this->_helper->getHelper('Redirector');
        $redirector->gotoSimple('index', 'xprice');}
        else {
            $this->view->messages = array_merge(
                $this->_helper->flashMessenger->getMessages(),
                $this->_helper->flashMessenger->getCurrentMessages()
            );
            $this->_helper->flashMessenger->clearCurrentMessages();
        }
        }
        if ($this->getRequest()->isPost()) {
            $date_validation_supply = date("Y-m-d H:i:s");
            //echo $date_validation_supply;
            $this->view->date_validation_supply = $date_validation_supply;
            $etat = "validée";
            $nom_validationsupply = "supply";
            $formData = $this->getRequest()->getPost();
            $datas = $this->getRequest()->getPost();
            $nomclients=trim($info_client['nom_client']);
//echo '<pre>',var_export($formData),'<pre>';
//            foreach ($formData as $datas) {
            $fobs = array_combine($datas['code_article'], $datas['prix_fob']);
            $cifs = array_combine($datas['code_article'], $datas['prix_cif']);

            foreach ($cifs as $key => $value) {
                $prixcifs = new Application_Model_DbTable_DemandeArticlexprices();
                $prixcif = $prixcifs->updatecif($value, $key, $datas['tracking_number']);
            }
            foreach ($fobs as $key => $value) {
                $prixfobs = new Application_Model_DbTable_DemandeArticlexprices();
                $prixfob = $prixcifs->updatefob($value, $key, $datas['tracking_number']);
            }
            $validations = new Application_Model_DbTable_Validationsxprice();
            $validation = $validations->createValidation($nom_validationsupply, $date_validation_supply, $etat, $datas['commentaire_supply'], $user->id_user, $datas['tracking_number']);

            $datasValidation = array(
                'nom_validation' => $nom_validationsupply, 'validation' => $etat,
                'commentaire' => $formData['commentaire_supply'],
                'id_user' => $user->id_user, 'id_demande_xprice' => $info_demande_xprice['id_demande_xprice']
            );
//            echo "<pre>", var_export($datasValidation, true), "</pre>";
//            exit();
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
//            }
            $emailVars = Zend_Registry::get('emailVars');
// var_dump($datas); exit();
          /* else {*/
                $destinatairemail =$emailVars->listes->DBD;
                if (!is_null($commentId)) {
                    $url = "http://{$_SERVER['SERVER_NAME']}/xprice/validatedbd/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $url = "http://{$_SERVER['SERVER_NAME']}/xprice/validatedbd/numwp/{$numwp}";
                }
                $corpsMail = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XPrice $trackingNumber/$numwp de  {$info_user['nom_user']} pour le client $nomclients à valider.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Supply Chain Manager.";
          /*}*/
            $emailVars = Zend_Registry::get('emailVars');
            $mail = new Xsuite_Mail();
            $mail->setSubject(" XPrice : Nouvelle demande Xprice $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider.")
                    ->setBodyText(sprintf($corpsMail, $url))
                    ->addTo($destinatairemail)
                    ->send();
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "les prix fob et cif  sont bien validés.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xprice');
        }
    }

    public function updateAction() {
        $user = $this->_auth->getStorage()->read();
       // echo '<pre>',  var_export($user),'</pre>';
        $this->view->utilisateur=$user->id_fonction;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $comId = $this->getRequest()->getParam('com', null);
        $this->view->commentId = $comId;
        $histo_rep = $this->getRequest()->getParam('histo', null);
        $this->view->histo_rep = $histo_rep;
        $param = $this->getRequest();
//        echo '<pre>',var_export($param),'<pre>'; exit();
        $infos = new Application_Model_DbTable_Xprices();
        $info = $infos->getNumwp($numwp);
        $id_demande_xprice = $info['id_demande_xprice'];
        $tracking_number = $info['tracking_number_demande_xprice'];
        $this->view->tracking_number = $tracking_number;
        $date_offre = $info['date_demande_xprice'];
        $date = DateTime::createFromFormat('Y-m-d', $date_offre);
        $dateplop = $date->format('d/m/Y');
        $this->view->date_offre = $dateplop;
        $id_commercial = $info['id_user'];
        $numwp_client = $info['numwp_client'];
        $info_client = new Application_Model_DbTable_Clients;
        $infos_client = $info_client->getClientnumwp($numwp_client);
        $info_commercial = new Application_Model_DbTable_Users();
        $infos_commercial = $info_commercial->getUser($id_commercial);
        $tests = new Application_Model_DbTable_DemandeArticlexprices();
        $test = $tests->sommePrixDemandeArticle($numwp);
        $this->view->montant_total = $test->total;
        $this->view->infos_client = $infos_client;
        $nomclients=trim($infos_client['nom_client']);
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($infos_client['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        /* recupération des commentaires concernant la demande */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);

        $commentairesoffre = new Application_Model_DbTable_Validationsdemandexprices();
        $commentaireoffre = $commentairesoffre->getAllValidation($id_demande_xprice);
        $this->view->commentaire = $commentaireoffre;
        $usersCommentaires = array();

        foreach (@$commentaireoffre as $key => $commoffre) {
            $userCommInfos = $info_commercial->getFonctionLabel($commoffre['id_user']);
            $usersCommentaires[$key]['fonction'] = $userCommInfos['description_fonction'];
        }
        $this->view->usersCommentaires = $usersCommentaires;

        if ($this->getRequest()->isPost()) {
            $nom_validation = "reponse";
            $formData = $this->getRequest()->getPost();

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => "enAttente",
                'commentaire' => $formData['reponse_comm'],
                'id_user' => $user->id_user, 'id_demande_xprice' => $info_demande_xprice['id_demande_xprice']
            );
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);

            $question = $commentairesoffre->getValidationById($comId);
            $users = new Application_Model_DbTable_Users();

            $destReponse = $users->getUser($question['id_user']);
            //echo '<pre>',  var_export($destReponse),'</pre>'; 
            $fonctions = array(
                13 => "dirco",
                10 => "chefregion",
                5 => "dbd",
                20=> "chefmarche"
            );
            $idF = $destReponse['id_fonction'];
            $params1 = array();
            $params1['destinataireMail'] =$destReponse['email_user'];
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}/histo/{$lasthisto[0]['id_histo_commentaire']}";
            if (!is_null($commentId)) {
                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/validate{$fonctions[$idF]}/numwp/{$numwp}/com/{$commentId}";
            } else {
                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/validate{$fonctions[$idF]}/numwp/{$numwp}";
            }

            $params1['corpsMail'] = "Bonjour,\n"
                    . "\n"
                    . "Une réponse a été apportée à la question que vous avez posé sur demande XPrice $tracking_number/$numwp.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Xprice.";
            $params1['sujet'] = " XPrice : réponse sur la demande Xprice  $tracking_number/$numwp pour le client $nomclients.";
            //echo '<pre>',  var_export($params1),'</pre>'; exit();
            $this->sendEmail($params1);

            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "la demande est en attente de réponse du {$fonctions[$idF]}.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xprice');
        }
    }

    public function consultAction() {
        $user = $this->_auth->getStorage()->read();
        $this->view->utilisateur=$user->id_fonction;
        $tiltop = $user->id_user;
        $this->view->cdr = $tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp;
        $ferme = new Application_Model_DbTable_Validationsdemandexprices();
        $fermeture = $ferme->searchFermeture($numwp);
        foreach($fermeture as $ferm){
        $plop1 = $ferm
                ;}
       // echo '<pre>',var_export($plop1),'</pre>';
      $this->view->fermeturevalide=$plop1['etat_validation'];
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
//echo '<pre>',  var_export($info_demande_xprice),'<pre>';
        $user_id = $info_demande_xprice['id_user'];
        /*info client*/
        $this->view->info_demande_xprice = $info_demande_xprice;
//         $anneeencours_1 = date('Y')-2;
//        $querycaencours_1="select 
//        Sum(ZMCCSS.ZCSN01+ZMCCSS.ZCSN02+ZMCCSS.ZCSN03+ZMCCSS.ZCSN04+ZMCCSS.ZCSN05+ZMCCSS.ZCSN06+ZMCCSS.ZCSN07+ZMCCSS.ZCSN08+ZMCCSS.ZCSN09+ZMCCSS.ZCSN10+ZMCCSS.ZCSN11+ZMCCSS.ZCSN12) as CA_LY
//        from EIT.ZEUCDTA.ZMCCSS40 ZMCCSS
//        where ZMCCSS.ZCDIVI  like 'FR0' and ZMCCSS.ZCYEA4 like '{$anneeencours_1}' and ZMCCSS.ZCDIUS like '{$info_demande_xprice['numwp_client']}'";
//        $caencoursClients_1 = odbc_exec($this->odbc_conn4, $querycaencours_1);
//        $caencoursClient_1 = odbc_fetch_object($caencoursClients_1);
//        $CA_LY = $caencoursClient_1->CA_LY;
//        $this->view->caencoursClient_1=$CA_LY;
//        $anneeencours = date('Y')-1;
//        $querycaencours="select  
//         Sum(ZMCCSS.ZCSN01+ZMCCSS.ZCSN02+ZMCCSS.ZCSN03+ZMCCSS.ZCSN04+ZMCCSS.ZCSN05+ZMCCSS.ZCSN06+ZMCCSS.ZCSN07+ZMCCSS.ZCSN08+ZMCCSS.ZCSN09+ZMCCSS.ZCSN10+ZMCCSS.ZCSN11+ZMCCSS.ZCSN12) as CA_YTD
//
//         from EIT.ZEUCDTA.ZMCCSS40 ZMCCSS
//         where ZMCCSS.ZCDIVI  like 'FR0' and ZMCCSS.ZCYEA4 like '{$anneeencours}' and ZMCCSS.ZCDIUS like '{$info_demande_xprice['numwp_client']}'";
//         $caencoursClients = odbc_exec($this->odbc_conn4, $querycaencours);
//        $caencoursClient = odbc_fetch_object($caencoursClients);
//        
//        $CA_YTD = $caencoursClient->CA_YTD;
//        $this->view->caencoursClient=$CA_YTD;
//        $pourcent_progress=round(100-((100*$CA_LY)/$CA_YTD),2).'%';
//        $this->view->pourcent_progress=$pourcent_progress;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        $id_holon=$info_user['id_holon'];
        $holonuser = new Application_Model_DbTable_Holons();
        $holonuser1 = $holonuser->getHolon($id_holon);
        $nom_holon = $holonuser1['nom_holon'];
        $this->view->holon = $nom_holon;
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice['date_demande_xprice']);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        /*
         * on recherche si la validation existe déjà ou si elle est en attente;
         */
        $nomvalidationrecherche = "cdr";
        $tracking = $info_demande_xprice['tracking_number_demande_xprice'];
        $recherchevalidation = new Application_Model_DbTable_Validationsxprice();
        $recherchesvalidation = $recherchevalidation->getValidation($nomvalidationrecherche, $tracking);
        $infos_user = new Application_Model_DbTable_Users();
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice['id_demande_xprice']);

        $this->view->validations = $validationsDemandesXprices;
        //echo'<pre>',  var_export($validationsDemandesXprices),'</pre>';
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] =$userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        
        /*essai valid en cours*/
        $encours = new Application_Model_DbTable_Validationsdemandexprices();
        $encours1 = $encours->getValidForEncours($numwp);
       $i = (count($encours1)-1);
       $plop2=$encours1[$i]['etat_validation'] ;
       $plop3=$encours1[$i]['nom_validation'] ;
       if($plop2 =="validee" || $plop2=="validée"){
        switch ($plop3) {
            case "cdr":
                $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";

                break;
            case "fobfr":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="François Delauge";
                $encoursNom="encours";
                break;
            default:
                break;
        }
    }
    elseif($plop2=="creation"){
           $encoursFonction="chef de région";
           $encoursNom="encours";
       }
       elseif($plop2=="enAttente"){
           switch ($plop3) {
               case "reponse":
                  $encoursFonction=$info_user['nom_user'].' '. $info_user['prenom_user'];
                $encoursNom="encours"; 
                break;
            case "cdr":
                $encoursFonction="chef de région";
                $encoursNom="encours";
                break;
            case "fobfr":
                 $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            default:
                break;
        }
       }
        $this->view->encoursFonction = $encoursFonction;
        $this->view->encoursNom=$encoursNom;
        /*fin essai valid en cours*/
        /*
         * Fin du chargement des validations
         */

        $info_user = $infos_user->getUserDemande($user_id);

        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        var_dump(trim($info_demande_xprice['numwp_client']));
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
//        echo '<pre>',var_export($info_client),'</pre>';
        $this->view->info_client = $info_client[0];
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client[0]['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;    
    }
    public function trackingAction(){
         $track = $this->getRequest()->getParam('tracking_number_demande_xprice', null);
        $form = new Application_Form_TrackingSearch();
        //echo $track;
        if (!is_null($track)) {
            $form->populate(array("tracking_number_demande_xprice" => $track));
        }
        if ($this->getRequest()->isPost()) {
            $redirector = $this->_helper->getHelper('Redirector');

            if ($form->isValid($this->getRequest()->getPost())) {
                $tracksearch= new Application_Model_DbTable_Xprices();
                $r=$tracksearch->getTracking($track);
                //echo '<pre>',  var_export($r),'<pre>'; 
                if ($r['tracking_number_demande_xprice'] == $_POST['tracking_number_demande_xprice']) {
                    $redirector->gotoSimple('consultlibre', 'xprice', null, array('tracking' => $_POST['tracking_number_demande_xprice']));
                } else {
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "ce numéro d'offre n'a pas de concordance dans la base Xsuite";
                    $flashMessenger->addMessage($message);
                    $redirector->gotoSimple('tracking', 'xprice', null, array('tracking' => $_POST['tracking_number_demande_xprice']));
                }
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }
        $this->view->form = $form;
    }
    
    public function consultlibreAction() {
        $user = $this->_auth->getStorage()->read();
        $this->view->utilisateur=$user->id_fonction;
        $tiltop = $user->id_user;
        $this->view->cdr = $tiltop;
        $tracking = $this->getRequest()->getParam('tracking', null);
        $this->view->tracking = $tracking;
        /*
         * on va rechercher les informations concernant la demande_xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->searchAll($tracking);
        $numwp=$info_demande_xprice->num_workplace_demande_xprice;
        $this->view->numwp=$numwp;
         $ferme = new Application_Model_DbTable_Validationsdemandexprices();
        $fermeture = $ferme->searchFermeture($numwp);
        foreach($fermeture as $ferm){
        $plop1 = $ferm
                ;}
       // echo '<pre>',var_export($plop1),'</pre>';
      $this->view->fermeturevalide=$plop1['etat_validation'];
        $user_id = $info_demande_xprice->id_user;
        $this->view->info_demande_xprice = $info_demande_xprice;
//         $anneeencours_1 = date('Y')-2;
//        $querycaencours_1="select 
//        Sum(ZMCCSS.ZCSN01+ZMCCSS.ZCSN02+ZMCCSS.ZCSN03+ZMCCSS.ZCSN04+ZMCCSS.ZCSN05+ZMCCSS.ZCSN06+ZMCCSS.ZCSN07+ZMCCSS.ZCSN08+ZMCCSS.ZCSN09+ZMCCSS.ZCSN10+ZMCCSS.ZCSN11+ZMCCSS.ZCSN12) as CA_LY
//        from EIT.ZEUCDTA.ZMCCSS40 ZMCCSS
//        where ZMCCSS.ZCDIVI  like 'FR0' and ZMCCSS.ZCYEA4 like '{$anneeencours_1}' and ZMCCSS.ZCDIUS like '{$info_demande_xprice->numwp_client}'";
//        $caencoursClients_1 = odbc_exec($this->odbc_conn4, $querycaencours_1);
//        $caencoursClient_1 = odbc_fetch_object($caencoursClients_1);
//        $CA_LY = $caencoursClient_1->CA_LY;
//        $this->view->caencoursClient_1=$CA_LY;
//        $anneeencours = date('Y')-1;
//        $querycaencours="select  
//         Sum(ZMCCSS.ZCSN01+ZMCCSS.ZCSN02+ZMCCSS.ZCSN03+ZMCCSS.ZCSN04+ZMCCSS.ZCSN05+ZMCCSS.ZCSN06+ZMCCSS.ZCSN07+ZMCCSS.ZCSN08+ZMCCSS.ZCSN09+ZMCCSS.ZCSN10+ZMCCSS.ZCSN11+ZMCCSS.ZCSN12) as CA_YTD
//
//         from EIT.ZEUCDTA.ZMCCSS40 ZMCCSS
//         where ZMCCSS.ZCDIVI  like 'FR0' and ZMCCSS.ZCYEA4 like '{$anneeencours}' and ZMCCSS.ZCDIUS like '{$info_demande_xprice->numwp_client}'";
//         $caencoursClients = odbc_exec($this->odbc_conn4, $querycaencours);
//        $caencoursClient = odbc_fetch_object($caencoursClients);
//        
//        $CA_YTD = $caencoursClient->CA_YTD;
//        $this->view->caencoursClient=$CA_YTD;
//        $pourcent_progress=round(100-((100*$CA_LY)/$CA_YTD),2).'%';
//        $this->view->pourcent_progress=$pourcent_progress;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice->id_user);
        $id_holon=$info_user['id_holon'];
        $holonuser = new Application_Model_DbTable_Holons();
        $holonuser1 = $holonuser->getHolon($id_holon);
        $nom_holon = $holonuser1['nom_holon'];
        $this->view->holon = $nom_holon;
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice->date_demande_xprice);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        /*
         * on recherche si la validation existe déjà ou si elle est en attente;
         */
        $nomvalidationrecherche = "cdr";
        $tracking = $info_demande_xprice->tracking_number_demande_xprice;
        $recherchevalidation = new Application_Model_DbTable_Validationsxprice();
        $recherchesvalidation = $recherchevalidation->getValidation($nomvalidationrecherche, $tracking);
        $infos_user = new Application_Model_DbTable_Users();
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice->id_demande_xprice);

        $this->view->validations = $validationsDemandesXprices;
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] =$userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        
            /*essai valid en cours*/
        $encours = new Application_Model_DbTable_Validationsdemandexprices();
        $encours1 = $encours->getValidForEncours($numwp);
       // echo '<pre>',var_export($encours1),'</pre>';
//        for($i=0;$i<count($encours1);++$i){
//           $plop2=$encours1[$i]['etat_validation'] ;
//           $plop3=$encours1[$i]['nom_validation'] ;
//        }
       $i = (count($encours1)-1);
       $plop2=$encours1[$i]['etat_validation'] ;
       $plop3=$encours1[$i]['nom_validation'] ;
       if($plop2 =="validee" || $plop2=="validée"){
        switch ($plop3) {
            case "cdr":
                $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";

                break;
            case "fobfr":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="François Delauge";
                $encoursNom="encours";
                break;
            default:
                break;
        }
    }
    elseif($plop2=="creation"){
           $encoursFonction="chef de région";
           $encoursNom="encours";
       }
       elseif($plop2=="enAttente"){
           switch ($plop3) {
               case "reponse":
                  $encoursFonction=$info_user['nom_user'].' '. $info_user['prenom_user'];
                $encoursNom="encours"; 
                break;
            case "cdr":
                $encoursFonction="chef de région";
                $encoursNom="encours";
                break;
            case "fobfr":
                 $encoursFonction="Nicolas Thouin";
                $encoursNom="encours";
                break;
            
            case "supply":
                 $encoursFonction="Emmanuel Jourdain";
                $encoursNom="encours";
                break;
            
            case "dbd":
                 $encoursFonction="Alexandre Bauer";
                $encoursNom="encours";
                break;
            default:
                break;
        }
       }
        $this->view->encoursFonction = $encoursFonction;
        $this->view->encoursNom=$encoursNom;
        /*fin essai valid en cours*/
        /*
         * Fin du chargement des validations
         */
        /*
         * Fin du chargement des validations
         */

        $info_user = $infos_user->getUserDemande($user_id);

        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice->numwp_client);
        $this->view->info_client = $info_client;
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($info_demande_xprice->num_workplace_demande_xprice);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
    }
    public function recapAction(){

    } 
    public function consultchefmarcheAction(){
        $user = $this->_auth->getStorage()->read();
        $this->view->utilisateur=$user->id_fonction;
      
        $tiltop = $user->id_user;
        $this->view->cm = $tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp;
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
//echo '<pre>',  var_export($info_demande_xprice),'<pre>';
        $user_id = $info_demande_xprice['id_user'];
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        $id_holon=$info_user['id_holon'];
        $holonuser = new Application_Model_DbTable_Holons();
        $holonuser1 = $holonuser->getHolon($id_holon);
        $nom_holon = $holonuser1['nom_holon'];
        $this->view->holon = $nom_holon;
        $this->view->info_demande_xprice = $info_demande_xprice;
        $date = DateTime::createFromFormat('Y-m-d', $info_demande_xprice['date_demande_xprice']);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop = $dateplop;
        $info_user = $infos_user->getUserDemande($user_id);
 /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXprices = new Application_Model_DbTable_Validationsdemandexprices();
        $validationsDemandesXprices = $dbtValidationsDemandesXprices->getAllValidation($info_demande_xprice['id_demande_xprice']);
        
        $plopatt=count($validationsDemandesXprices)-1;
        
        $etat_en_cours=$validationsDemandesXprices[$plopatt]['etat_validation'];
        $this->view->etat_en_cours=$etat_en_cours;
        
        $this->view->validations = $validationsDemandesXprices;
        $usersValidations = array();

        foreach (@$validationsDemandesXprices as $key => $validationDemandeXprice) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXprice['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['description_fonction'];
        }
        $this->view->usersValidations = $usersValidations;
        /*
         * Fin du chargement des validations
         */
        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
       // var_dump($info_client);
        $this->view->info_client = $info_client;
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($info_client[0]['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        $nomclients = trim($info_client[0]['nom_client']);
        
        
        if ($this->getRequest()->isPost()) {
            
            $date_validation = date("Y-m-d H:i:s");
            $this->view->date_validation = $date_validation;
            $nom_validation = "comcm";
            $formData = $this->getRequest()->getPost();

            $nouvelle_validation = new Application_Model_DbTable_Validationsxprice();
            $nouv_validation = $nouvelle_validation->createValidation($formData['nom_validation'], $formData['date_validation'], $etat_en_cours, $formData['commentaire_chefmarche'], $user->id_user, $formData['tracking']);
            $valid_id_valid = new Application_Model_DbTable_Validationsxprice();
            $valid_id_valids = $valid_id_valid->getValidation($formData['nom_validation'], $formData['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $etat_en_cours,
                'commentaire' => $formData['commentaire_chefmarche'],
                'id_user' => $user->id_user, 'id_demande_xprice' => $info_demande_xprice['id_demande_xprice']
            );
           
            $commentId = $this->genererValidation($datasValidation);
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "votre commentaire a bien été enregistré.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
        }

    
    }
    public function rechercheAction(){
        
        $user = $this->_auth->getStorage()->read();
        $fonction = $user->id_fonction;
        $tiltop = $user->id_user;
        $users= new Application_Model_DbTable_Users();
        $clients= new Application_Model_DbTable_Clients();
        if($fonction==42 || $fonction==44 || $fonction==41 ||$fonction==45 || $fonction==5 ||$fonction==13 || $fonction==47 || $fonction==4 ){
       
        $result1 = $clients->rechercheClient();
//        $users= new Application_Model_DbTable_Users();
//        $result2 = $users->rechercheUser();
       
       }
        elseif($fonction == 46 || $fonction == 43){
            $result1=$clients->rechercheRGCClient($tiltop);
        }
        elseif($fonction ==6 || $fonction==3){
            $holon = $user->id_holon;
            $result1=$clients->rechercheDDLEADClient($holon);
//            var_dump($holon);
        }
        elseif($fonction == 10){
            $holon =$user->id_holon;
            switch ($holon){
            case 2:
                $likeholon =array(18,19,20);
                break;
            case 3 : 
                $likeholon =array(5,6,11,13);
                break;
            case 4 :
                $likeholon = array(8,9,10,14,31);
                break;
            }
            $result1 = $clients->rechercheRCDClient($likeholon);
        }
        elseif($fonction == 2){
            $result1 = $clients->rechercheITCClient($id_user);
        }
        
//        echo '<pre>',  var_export($result1),'</pre>';
         $this->view->result1=$result1;
    }
    public function recherche2Action(){
        $user = $this->_auth->getStorage()->read();
        $fonction = $user->id_fonction;
        $tiltop = $user->id_user;
//        $this->view->utilisateur=$user->id_fonction;
      
        
        $formData = $this->getRequest()->getPost();
        
        $xprice = new Application_Model_DbTable_Xprices();
        $listXprice = $xprice->getRecherche($formData['liste_client']);
         
          $this->view->listXprice=$listXprice;
    }
}
