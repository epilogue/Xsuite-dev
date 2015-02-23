<?php

class XdistribController extends Zend_Controller_Action
{
    public $odbc_conn = null;
    public $odbc_conn2 = null;
    public $odbc_conn3 = null;
    
    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
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

    public function indexAction()
    {
        /*
         * en fonction de la fonction de l'utilisateur  on va chercher  dans la bdd  les offres qui le concerne 
         * KAM et ITC  leurs offres 
         * Leader leurs offres et celles de leur holon
         * Chef de region  les offres de leurs régions
         * DBD et Dirco  toutes les offres 
         */
     $user = $this->_auth->getStorage()->read();
     $holon =$user->id_holon; 
     if ($user->id_fonction == 1 || $user->id_fonction==2){
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib();
         $recapitulatif2 = $recapitulatif1->searchByUser($user->id_user);
         $this->view->recapitulatif = $recapitulatif2;        
     }

 if($user->id_fonction == 10){
     switch ($holon){
         case 2:
             $tracking1="SP-FR-QC";
             $tracking2="SP-FR-QF";
             break;
         case 3:
             $tracking1="SP-FR-QE";
             $tracking2="SP-FR-QH";            
             break;
         case 4:
            $tracking1="SP-FR-QI";
            $tracking2="SP-FR-QK";            
             break;
         }
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib();
         $recapitulatif2=$recapitulatif1->searchByCDR($tracking1,$tracking2);
     }
      if($user->id_fonction == 5 || $user->id_fonction == 13){
         $recapitulatif1 = new Application_Model_DbTable_Xprices;
         $recapitulatif2=$recapitulatif1->searchforDBD();
     }
    $this->view->recapitulatif = $recapitulatif2;
    }
public function uploadnumwpAction(){
    
     $numwp = $this->getRequest()->getParam('numwp', null);
        $form = new Application_Form_UploadDistrib();
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
            $form->populate(array("num_offre_workplace" => $numwp));
        }
        if ($this->getRequest()->isPost()) {
            $redirector = $this->_helper->getHelper('Redirector');

            if ($form->isValid($this->getRequest()->getPost())) {

                $query = "select
	OOLINE.OBORNO as NBNUMWP,OOLINE.OBCUNO
	FROM EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO = '{$_POST['num_offre_workplace']}' AND OOLINE.OBDIVI='FR0' and OOLINE.OBCONO='100'";
                $results = odbc_exec($this->odbc_conn, $query);
                $r = odbc_fetch_object($results);
                if ($r->NBNUMWP === $_POST['num_offre_workplace']) {
                    $redirector->gotoSimple('create', 'xdistrib', null, array('numwp' => $_POST['num_offre_workplace']));
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
public function createAction(){
     $filename=$_FILES['nomfichier']['name'];
    
    $destination='home/www-dev/Xsuite-dev_mag/application/datas/filesDatas/';
    $destination2=$destination.basename($_FILES['nomfichier']['name']);
    if(move_uploaded_file($filename,$destination2) == true){
        echo 'oki fichier';
        
    }else{
        echo 'erreur fichier';
         var_dump($filename);
        
        var_dump($destination2);
    }
        $numwp = $this->getRequest()->getParam('num_offre_workplace', null);
        $demandes_xdistrib = new Application_Model_DbTable_Xdistrib();
        $demande_xdistrib = $demandes_xdistrib->getNumwp($numwp);
        if (!is_null($demande_xdistrib)) {
            $redirector = $this->_helper->getHelper('Redirector');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "Cette offre a déjà été créée.";
            $flashMessenger->addMessage($message);
            $message = "Veuillez cliquer sur : <a class=\"submit\" href=\"/xdistrib/tracking\">'Xdistrib : Consulter'</a>.";
            $flashMessenger->addMessage($message);
            $redirector->gotoSimple('index', 'xdistrib');
        }
        $this->view->numwp = $numwp;
//si le numero workplace est valide alors on fait la requête pour movex
// requête d'informations de l'offre et on va enregistrer les infos  dans les  tables temp_movex 
        if (!is_null($numwp)) {
            /*recuperation numwp et date*/
            $pirate = "select OOLINE.OBORNO,OOLINE.OBCUNO, OOLINE.OBRGDT, OOLINE.OBORNO, OOLINE.OBSMCD from EIT.CVXCDTA.OOLINE OOLINE where OOLINE.OBORNO='{$numwp}'";
            $infos_offre = odbc_exec($this->odbc_conn, $pirate);
            $infos_offres = odbc_fetch_object($infos_offre);
            $this->view->infos_offres = $infos_offres;
            echo  '<pre>', var_export($infos_offres),'</pre>';
            $dateinit = $infos_offres->OBRGDT;
            $dateinit3 = substr($dateinit, 0, 4);
            $dateinit2 = substr($dateinit, 4, 2);
            $dateinit1 = substr($dateinit, 6, 2);
            $dateinitf = array($dateinit1, $dateinit2, $dateinit3);
            $datefinal = implode('/', $dateinitf);
            $this->view->datefinal = $datefinal;
            
            /*insertion dans la table temp_movex_offre(numwp,date_offre,numwp_createur_offre,numwp_distributeur*/
            $temps= new Application_Model_DbTable_TempMovexOffre();
            $temp=$temps->createInfo($numwp, $dateinit, $infos_offres->OBSMCD, $infos_offres->OBCUNO);
            /*
             * fin de l'insertion 
             */
            
            /*insertion dans la table temp_movex_distributeur*/
            $query1bis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '$infos_offres->OBCUNO'";
            $infos_distributeur = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1bis));
            // echo  '<pre>', var_export($infos_distributeur),'</pre>';
              $adresse = $infos_distributeur['OKCUA1'] . $infos_distributeur['OKCUA2'] . $infos_distributeur['OKCUA3'] . $infos_distributeur['OKCUA4'];
              //echo $adresse;
            $query1ter = "select OOHEAD.OACHL1 from EIT.MVXCDTA.OOHEAD OOHEAD where OOHEAD.OACUNO = '$infos_offres->OBCUNO'";
            $numdistributeurwp = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1ter));
           // echo  '<pre>', var_export($numdistributeurwp['OACHL1']),'</pre>';
            $query1quart = "select ZMCPJO.Z2MCL1  from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '$infos_offres->OBCUNO' ";
            $industriewp = odbc_fetch_array(odbc_exec($this->odbc_conn3, $query1quart));
            //$this->view->industriewp = $industriewp ;
            $industriewp['Z2MCL1'] = trim($industriewp['Z2MCL1']);
            if ($industriewp['Z2MCL1'] == "" || $industriewp['Z2MCL1'] == " ") {
                    $industriewp['Z2MCL1'] = "SCI";
                }
                echo $industriewp['Z2MCL1'];
                
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
             echo '<pre>',var_export($info_industry),'</pre>';
            $tempDistribs= 0;
            
            /*fin insertion insertion table temp_movex_distributeur*/
            
            
            
            
            /*recuperation info createur de l'offre*/
            $user = $this->_auth->getStorage()->read();
            $zoneT = new Application_Model_DbTable_Zones();
            $zone = $zoneT->getZone($user->id_zone);
            /*creation du tracking number*/
            $Xdistribs = new Application_Model_DbTable_Xdistrib();
            $trackingNumber = Application_Model_DbTable_Xdistrib::makeTrackingNumber($zone['nom_zone'], $Xdistribs->lastId(true));
            $this->view->trackingNumber = $trackingNumber;
             //echo  '<pre>', var_export($trackingNumber),'</pre>';
            /*recuperation du numwp du createur de l'offre*/
            $query1 = "SELECT OOLINE.OBSMCD  as userwp FROM EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}'";
            $numwp_user = odbc_fetch_array(odbc_exec($this->odbc_conn, $query1));
            /*recuperation des donnees concernant le createur de l'offre*/
            $usertest = new Application_Model_DbTable_Users();
            $user_info = $usertest->getMovexUser($numwp_user['USERWP']);
            $this->view->user_info = $user_info;
            //echo  '<pre>', var_export($user_info),'</pre>';
            $id_holon = $user_info['id_holon'];
            $holonuser = new Application_Model_DbTable_Holons();
            $holonuser1 = $holonuser->getHolon($id_holon);
            $nom_holon = $holonuser1['nom_holon'];
            $this->view->holon = $nom_holon;
            /*recuperation de la fonction et de la zone de tracking  utilisé pour l'envoi des mails */
            $fonctioncreateur = $user_info['id_fonction'];
            $zonetracking = substr($trackingNumber, 6, 2);
            /*recuperation des donnees concernant l'offre 
             * numero offre
             * numero client
             * code article
             * reference article
             * quantite
             * prix demandé
             * prix tarif
             * date
             * identifiant
             */
            $query2 = "select OOLINE.OBORNO,OOLINE.OBCUNO,OOLINE.OBITNO,OOLINE.OBITDS,OOLINE.OBORQT,OOLINE.OBLNA2,OOLINE.OBNEPR,OOLINE.OBSAPR,OOLINE.OBELNO,OOLINE.OBRGDT,
                    OOLINE.OBLMDT,
                    OOLINE.OBSMCD
                    from EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}' AND OOLINE.OBDIVI LIKE 'FR0' AND OOLINE.OBCONO=100";
            $resultats = odbc_exec($this->odbc_conn, $query2);

            while ($resultat[] = odbc_fetch_array($resultats)) {
                    $this->view->resultat = $resultat;
                }
                /* recuperation du code acquisition , prif fob et cif*/
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
                    $acquis= "select MITBAL.MBITNO, MITBAL.MBPUIT from EIT.MVXCDTA.MITBAL MITBAL where MITBAL.MBITNO ='{$itnoarticle['OBITNO']}'";
                    $resultatsacquis=odbc_Exec($this->odbc_conn2, $acquis);
                    $resultatacquis[] = odbc_fetch_object($resultatsacquis);
                }
            $this->view->prixciffob = $prixciffob;
            
             /*
             * à partir du code distributeur de la table ooline on va chercher dans la table ocusma
             * les informations concernant le distributeur pour pouvoir les afficher dans la vue phtml
             */
            $query1bis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '{$resultat[0]['OBCUNO']}'";
            $infos_distributeur = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1bis));
            $this->view->infos_distributeur = $infos_distributeur;
            $query1ter = "select OOHEAD.OACHL1 from EIT.MVXCDTA.OOHEAD OOHEAD where OOHEAD.OACUNO = '{$resultat[0]['OBCUNO']}'";
            $numdistributeurwp = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1ter));
            $this->view->numdistributeurwp = $numdistributeurwp['OACHL1'];
            
            /*a partir d'ici on a toute les infos obligatoire pour enregistrer la demande Xdistrib*/
            $demande_xdistrib = $demandes_xdistrib->createXdistrib(
                            $numwp, $trackingNumber, null,null,$infos_offres->OBRGDT,null, $user_info['id_user'], null,null, $numdistributeurwp['OACHL1']); 
            /* fin insertion demande_xdistrib */
            /*recuperation code industry*/
            $query1quart = "select ZMCPJO.Z2MCL1  from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '{$resultat[0]['OBCUNO']}' ";
            $industriewp = odbc_fetch_array(odbc_exec($this->odbc_conn3, $query1quart));
            $this->view->industriewp = $industriewp ;
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
                    echo '<pre>',var_export($info_industry),'</pre>';
                }
                $distributeurs = new Application_Model_DbTable_Distributeurs();
                        $distributeur = $distributeurs->getDistributeurnumwp($numdistributeurwp['OACHL1']);

                        $adresse_distributeur = $infos_distributeur['OKCUA1'] . $infos_distributeur['OKCUA2'] . $infos_distributeur['OKCUA3'] . $infos_distributeur['OKCUA4'];
                        /*insertion distributeur dans la bdd */
                        if (is_null($distributeur)) {
                            $newdistributeur = $distributeurs->createDistributeur($infos_distributeur['OKCUNM'],null,null, $numdistributeurwp['OACHL1'],null, $adresse_distributeur,null, $info_industry['id_industry'], $infos_distributeur['OKCFC7']);
                        }
                        /*fin insertion distributeur*/
                        
             /* debut Insertion dans les tables Articles  et  demande_Article_Xdistrib */
                    $articles_xdistrib = new Application_Model_DbTable_Articles();
                    $demandes_articles_xdistrib = new Application_Model_DbTable_DemandeArticlexdistrib();
                    foreach ($this->view->resultat as $resultarticle) {
                        $articleexist = $articles_xdistrib->getArticle($resultarticle['OBITNO']);
                        if (is_null($articleexist)) {
                            $articles_xdistrib = $articles_xdistrib->createArticle($resultarticle['OBITDS'], $resultarticle['OBITNO'], null);
                        }
                        $demande_article_xdistrib = $demandes_articles_xdistrib->createDemandeArticlexdistrib($resultarticle['OBSAPR'], $resultarticle['OBNEPR'],null, $resultarticle['OBORQT'], round(100 - ($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR']), 2), $infos_offres->OBRGDT,$resultarticle['OBNEPR'], round(100 - ($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR']), 2), null, null, null,null, $trackingNumber, $resultarticle['OBITNO'], $resultarticle['OBITDS'], $numwp,null);
                    }
                    
                    /*insertion et update  prix fob et cif*/
                    foreach ($prixciffob as $key => $value) {
                        $insertprix = new Application_Model_DbTable_DemandeArticlexdistrib();
                        $inserprix = $insertprix->InserPrixFob($value->AJPUPR, $value->AJOBV2, $numwp);
                    }
                    foreach($resultatacquis as $key=>$value){
                        $insertacquis= new Application_Model_DbTable_DemandeArticlexdistrib();
                        $inseracquis = $insertacquis->InserCodeAcquis($value->MBPUIT, $value->MBITNO, $numwp);
                    }
                    
                    $updatecif1 = new Application_Model_DbTable_DemandeArticlexdistrib();
                    $updatecif2 = $updatecif1->getDemandeArticlexdistrib($numwp);                   
                        foreach($updatecif2 as $result){
                            if($result['code_acquisition']=='2'){
                                $cifs= ($result['prix_fob_demande_article'])*1.07;
                                $cif=round($cifs,2);
                                $updatecif3 = $updatecif1->updatecif($cif, $result['code_article'], $result['tracking_number_demande_xdistrib']);
                            }
                                                     
                        }
                        $margeupdate1=new Application_Model_DbTable_DemandeArticlexdistrib();
                        $margeupdate2=$margeupdate1->getDemandeArticlexdistrib($numwp);
                        foreach($margeupdate2 as $res){
                            $marges = 1-($res['prix_cif_demande_article']/$res['prix_accorde_demande_article']);
                            $marge=$marges*100;
                            $margeupdate3=$margeupdate1->updateMarge($marge, $res['code_article'],$res['tracking_number_demande_xdistrib']);
                        }
                        
//                        require ('library/PHPExcel/Classes/PHPExcel.php');
//                        $essai = new PHPExcel();
                        //exit();
            if ($this->getRequest()->isPost()) {
                    $formData = $this->getRequest()->getPost();
//                        /* insertion Clients
//                        on regarde dans la base si le client existe */
//                        $clients = new Application_Model_DbTable_Clients();
//                        $client = $clients->getClientnumwp($formData['numclientwp']);
//                        if(is_null($client)){
//                            $newclient = $clients->createClient($formData['nom_client'], $formData['numclientwp'], $formData['adresse_client'], $idIndustryClient, $formData['potentiel']);
//                        }
//                       
//
//                        $numwpexist = $demandes_xdistrib->getNumwp($numwp);
//                        $firstComment = null;
//                        if (is_null($numwpexist)) {
//                            $demande_xdistrib = $demandes_xdistrib->createXdistrib(
//                            $numwp, $trackingNumber, null,null,$infos_offres->OBRGDT,null, $user_info['id_user'], null,null, $numdistributeurwp['OACHL1']);
//                            $dbtValidationDemande = new Application_Model_DbTable_Validationsdemandexdistribs();
//                            if (!is_null($formData['commentaire_demande_xdistrib']) && trim($formData['commentaire_demande_xdistrib']) != "") {
//                                $now = new DateTime();
//                                $validationDemande = $dbtValidationDemande->createValidation(
//                                        "creation", $now->format('Y-m-d H:i:s'), "creation", $user_info['id_user'], $demande_xdistrib->lastId(), trim($formData['commentaire_demande_xdistrib']));
//                                $firstComment = $dbtValidationDemande->lastId();
//                            }
//                        }
                        
//  /* Insertion dans les tables Articles  et  demande_Article_Xdistrib */
//                    $articles_xdistrib = new Application_Model_DbTable_Articles();
//                    $demandes_articles_xdistrib = new Application_Model_DbTable_DemandeArticlexdistrib();
//                    foreach ($this->view->resultat as $resultarticle) {
//                        $articleexist = $articles_xdistrib->getArticle($resultarticle['OBITNO']);
//                        if (is_null($articleexist)) {
//                            $articles_xdistrib = $articles_xdistrib->createArticle($resultarticle['OBITDS'], $resultarticle['OBITNO'], null);
//                        }
//                        $demande_article_xdistrib = $demandes_articles_xdistrib->createDemandeArticlexdistrib($resultarticle['OBSAPR'], $resultarticle['OBNEPR'],$formData['prixClientFinal'][trim($resultarticle['OBITNO'])], $resultarticle['OBORQT'], round(100 - ($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR']), 2), $infos_offres->OBRGDT,$resultarticle['OBNEPR'], round(100 - ($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR']), 2), null, null, null,$formData['MargeMoyenne'], $trackingNumber, $resultarticle['OBITNO'], $resultarticle['OBITDS'], $numwp,null);
//                    }
//                    foreach ($prixciffob as $key => $value) {
//                        /* a ajouter
//                         *  requete suivante : select MITBAL.MBPUIT as acquisition from eit.MVXCDTA.MITBAL MITBAL where MITBAL.MBITNO='$value->AJOBV2' ;
//                            if $acquisition ==1 ou 3 prix fob = prix cif 
//                         * if $acquisition == 2 cif =1.07*fob
//                         * 
//                         *                          */
//                        $insertprix = new Application_Model_DbTable_DemandeArticlexdistrib();
//                        $inserprix = $insertprix->InserPrixFob($value->AJPUPR, $value->AJOBV2, $numwp);
//                    }
//                    foreach($ $resultatacquis as $key=>$value){
//                        $insertacquis= new Application_Model_DbTable_DemandeArticlexdistrib();
//                        $inseracquis = $insertacquis->InserCodeAcquis($value->MBPUIT, $value->MBITNO, $numwp);
//                    }
//                    
//                    $updatecif1 = new Application_Model_DbTable_DemandeArticlexdistrib();
//                    $updatecif2 = $updatecif1->getDemandeArticlexdistrib($numwp);                   
//                        foreach($updatecif2 as $result){
//                            if($result['code_acquisition']=='2'){
//                                $cifs= ($result['prix_fob_demande_article'])*1.07;
//                                $cif=round($cifs,2);
//                                $updatecif3 = $updatecif1->updatecif($cif, $result['code_article'], $result['tracking_number_demande_xprices']);
//                            }
//                           
//                            
//                        }
//                        $margeupdate1=new Application_Model_DbTable_DemandeArticlexdistrib();
//                        $margeupdate2=$margeupdate1->getDemandeArticlexdistrib($numwp);
//                        foreach($margeupdate2 as $res){
//                            $marges = 1-($res['prix_cif_demande_article']/$res['prix_accorde_demande_article']);
//                            $marge=$marges*100;
//                            $margeupdate3=$margeupdate1->updateMarge($marge, $res['code_article'],$result['tracking_number_demande_xdistrib']);
//                        }
//                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
//                $message = "l'offre $numwp a été envoyé.";
//                $flashMessenger->addMessage($message);
//                $redirector = $this->_helper->getHelper('Redirector');
//                $redirector->gotoSimple('index', 'xdistrib');
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

