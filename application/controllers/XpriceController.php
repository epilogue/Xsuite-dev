<?php

class XpriceController extends Zend_Controller_Action {

   // public $dsn="DRIVER=Client Access ODBC Driver(32-bit);UID=EU65535;PWD=CCS65535;SYSTEM=10.105.80.32;DBQ=CVXCDTA";
   // public $dsn = "Database=CVXCDTA;UID=EU65535;PWD=CCS65535;";
   // public $dsn = "Movex";
    //public $dsn2 = "DRIVER={MySQL};Server=127.0.0.1;Database=MVXCDTA;UID=root;PWD=geek;";
    //public $dsn2 = "";
    public $odbc_conn = null;
    public $odbc_conn2 = null;

    //  public $odbc_conn3= null;

    public function init() {
        //$this->dsn = Zend_Registry::get("dsnString");
//        $this->odbc_conn = odbc_connect($this->dsn, "", "");
        $this->odbc_conn = odbc_connect('Movex', "EU65535", "CCS65535");
        if (!$this->odbc_conn) {
            echo "pas d'accès à la base de données CVXDTA";
        }
        $this->_auth = Zend_Auth::getInstance();
        $this->view->messages = $this->_helper->flashMessenger->getMessages();

       // $this->dsn2 = Zend_Registry::get("dsn2String");
        $this->odbc_conn2 = odbc_connect('Movex2', "EU65535", "CCS65535");
        if (!$this->odbc_conn2) {
            echo "pas d'accès à la base de données MVXCDTA";
        }
        // $this->odbc_conn3 = odbc_connect($this->dsn3,"","");
        //if(!$this->odbc_conn3){
        //    print odbc_errormsg();
        //}
    }

    public function indexAction() {
        // action body
        $tracking = $this->getRequest()->getParam('tracking_number', null);
        $form = new Application_Form_Recherchexprice();
        if (!is_null($tracking)) {
            $form->populate(array("tracking_number" => $tracking));
        }

        // var_dump($tracking_number);

        if ($this->getRequest()->isPost()) {
            $redirector = $this->_helper->getHelper('Redirector');

            if ($form->isValid($this->getRequest()->getPost())) {
                $tracking_number = 'SP-FR-' . $tracking;
                //var_dump($tracking_number);
                $getstracking = new Application_Model_DbTable_Xprices;
                $gettracking = $getstracking->getTracking($tracking_number);
                if (!is_null($gettracking)) {
                    $redirector->gotoSimple('list', 'xprice', null, array('tracking_number' => $_POST['tracking_number']));
                } else {
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "ce tracking number  n'a pas de concordance dans la base Xsuite";
                    $flashMessenger->addMessage($message);
                    $redirector->gotoSimple('index', 'xprice', null, array('tracking_number' => $_POST['tracking_number']));
                }
            }
        }
        $this->view->form = $form;
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
        $form->populate(array("num_offre_worplace" => $numwp));}
        if ($this->getRequest()->isPost()) {
            $redirector = $this->_helper->getHelper('Redirector');

            if ($form->isValid($this->getRequest()->getPost())) {
                //$query = "select OOLINE.OBORNO as nbNumwp FROM EIT.CVXCDTA.OOLINE WHERE OOLINE.OBORNO = '{$_POST['num_offre_worplace']}' AND OOLINE.OBDIVI='FR0' and OOLINE.OBCONO='100';";
                $query = "select
	OOLINE.OBORNO as NBNUMWP,OOLINE.OBCUNO
	FROM EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO = '{$_POST['num_offre_worplace']}' AND OOLINE.OBDIVI='FR0' and OOLINE.OBCONO='100'";
                $results = odbc_exec($this->odbc_conn, $query);
                $r = odbc_fetch_object($results);
                //var_dump($r); var_dump($_POST['num_offre_worplace']);exit();
                if ($r->NBNUMWP === $_POST['num_offre_worplace']){
                    $redirector->gotoSimple('create', 'xprice', null, array('numwp' => $_POST['num_offre_worplace']));
                } else {
                    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                    $message = "ce numéro d'offre n'a pas de concordance dans la base MOVEX2";
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
            $message = "Veuillez cliquer sur : <a href=\"/xprice/update\">'Xprice : Modifier'</a> ou cliquez dans le menu de gauche.";
            $flashMessenger->addMessage($message);
            $redirector->gotoSimple('index', 'xprice');
        }
        $this->view->numwp = $numwp;
        
        if (!is_null($numwp)) {
            //si le numero workplace est valide alors on fait la requête pour movex
            // requête d'informations de l'offre
            $pirate = "select OOLINE.OBORNO, OOLINE.OBRGDT, OOLINE.OBORNO from EIT.CVXCDTA.OOLINE OOLINE where OOLINE.OBORNO='{$numwp}'";
            $infos_offre = odbc_exec($this->odbc_conn,$pirate);
            $infos_offres = odbc_fetch_object($infos_offre);
            // echo '<pre>', var_export($infos_offres, false), '</pre>';
            $this->view->infos_offres = $infos_offres;
            $user = $this->_auth->getStorage()->read();
            $zoneT = new Application_Model_DbTable_Zones();
            $zone = $zoneT->fetchRow(array('id_zone' => $user->id_zone));
            $Xprices = new Application_Model_DbTable_Xprices();
            $trackingNumber = Application_Model_DbTable_Xprices::makeTrackingNumber($zone->nom_zone, $Xprices->lastId(true));
            // $this->view->trackingNumber = Application_Model_DbTable_Xprices::makeTrackingNumber($zone->nom_zone, $Xprices->lastId(true));
            $this->view->trackingNumber = $trackingNumber;
            // requetes pour remplir le phtml :
            //requete 1 pour remplir  les données du commercial à partir du numwp
            $query1 = "SELECT OOLINE.OBSMCD  as userwp FROM EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}'";
            $numwp_user = odbc_fetch_array(odbc_exec($this->odbc_conn, $query1));
            $usertest = new Application_Model_DbTable_Users();
            $user_info = $usertest->getMovexUser($numwp_user['USERWP']);
            $this->view->user_info = $user_info;
            $id_holon = $user_info['id_holon'];
            $holonuser = new Application_Model_DbTable_Holons();
            $holonuser1 = $holonuser->getHolon($id_holon);
            $nom_holon = $holonuser1['nom_holon'];
            $this->view->holon = $nom_holon;
            $fonctioncreateur= $user_info['id_fonction'];
                $zonetracking=substr($trackingNumber,6,2);
            /*
             * on va chercher les informations concernant les articles dans la table ooline à partir du numwp
             * pour pouvoir ensuite les afficher dans la vue à l'aide d'un foreach
             */
            $query2 = "select OOLINE.OBORNO,OOLINE.OBCUNO,OOLINE.OBITNO,OOLINE.OBITDS,OOLINE.OBORQT,OOLINE.OBLNA2,OOLINE.OBNEPR,OOLINE.OBSAPR,OOLINE.OBELNO,OOLINE.OBRGDT,
                    OOLINE.OBLMDT,
                    OOLINE.OBSMCD 
                    from EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}' AND OOLINE.OBDIVI LIKE 'FR0' AND OOLINE.OBCONO=100";
            $resultats = odbc_exec($this->odbc_conn, $query2);

            while ($resultat[] = odbc_fetch_array($resultats)) {
                $this->view->resultat = $resultat;
            }
            /* aller chercher prix fob prix cif sur la base MVCDXTA en utilisant les tables KOPCDT(date) KOITNO ( code article) et KO ( prix cif)
             *
             */foreach ($this->view->resultat as $itnoarticle) {
                $query3 = "select MCHEAD.KOPCDT, MCHEAD.KOCSU3, MCHEAD.KOITNO from EIT.MVXCDTA.MCHEAD MCHEAD where MCHEAD.KOITNO = {$itnoarticle['OBITNO']}";


                $resultats3 = odbc_Exec($this->odbc_conn2, $query3);
                $prixciffob[] = odbc_fetch_object($resultats3);
            }
            $this->view->prixciffob = $prixciffob;

            /*
             * à partir du code client de la table ooline on va chercher dans la table ocusma
             * les informations concernant le client pour pouvoir les afficher dans la vue phtml
             */
            $query1bis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '{$resultat[0]['OBCUNO']}'";
            $infos_client = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1bis));
            $this->view->infos_client = $infos_client;
            /*
             * information concernant  le projet industry auquel appartient le client
             *    donc à partir du code movex industry on va chercher dans la base xsuite
             *  le nom de l'industrie auquel le client appartient pour ensuite l'afficher dans la vue
             */
//            $industry = new Application_Model_DbTable_Industry();
//            $info_industry = $industry->getMovexIndustry($infos_client['OKCUCL']);
//            $this->view->info_industry = $info_industry;
        }
        $form = new Application_Form_CreationDemande();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $emailVars = Zend_Registry::get('emailVars');
                //alors si le client n'existe pas ' on insert d'abord dans la table client
                //"select id_client from clients where id_client = {$infos_client['OKCUNO']}";
                $clients = new Application_Model_DbTable_Clients();
                $client = $clients->getClientnumwp($infos_client['OKCUNO']);

                $adresse_client = $infos_client['OKCUA1'] . $infos_client['OKCUA2'] . $infos_client['OKCUA3'] . $infos_client['OKCUA4'];

                if (is_null($client)) {
                    $newclient = $clients->createClient($infos_client['OKCUNM'], $infos_client['OKCUNO'], $adresse_client, $infos_client['OKCUCL']);
                }
                // et ensuite  on insert dans la table demande_xprices
                //si le client existe  alors on insert immédiatement dans la table demande_xprices

                $numwpexist = $demandes_xprice->getNumwp($numwp);
                if (is_null($numwpexist)) {
                    $demande_xprice = $demandes_xprice->createXprice(
                            $numwp, $trackingNumber, $formData['commentaire_demande_article'], $infos_offres->OBRGDT, $formData['mini_demande_article'], $user_info['id_user'], null, $infos_client['OKCUNO']);
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
                    $demande_xprice = $demandes_xprice->createDemandeArticlexprice($resultarticle['OBNEPR'], $resultarticle['OBSAPR'], $resultarticle['OBORQT'], round($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR'], 2), $infos_offres->OBRGDT, null, null, null, null, null, $trackingNumber, $resultarticle['OBITNO'], $resultarticle['OBITDS'], $numwp);
                }
                foreach ($prixciffob as $value) {
                    $insertprix = new Application_Model_DbTable_DemandeArticlexprices();
                    $inserprix = $insertprix->InserPrixFob($value->KOCSU3, $value->KOITNO, $numwp);
                }
                /*
                 * ici, envoi des mails 
                 * NE PAS TOUCHER SOUS PEINE D'EFFONDREMENT DE L'APPLI
                 *  à partir de la ligne 244 à la ligne 393
                 */
                
                /*Dans un premier lieu on vérifie la fonction du créateur de la demande  : 
                 * en fonction de sa fonction envoie de mail à un ou des destinataires : 
                 * si ITC ou KAM alors envoie mail pour consultation au leader et au chef de région
                 * si leader  et dd envoie mail au chef de région.
                 */
                $emailVars = Zend_Registry::get('emailVars');
                $fonctioncreateur= $user_info['id_fonction'];
                $holoncreateur= $user_info['id_holon'];
                /*
                 * ici si itc ou kam envoie mail au leader en fonction du holon pour consultation
                 */
                  if($fonctioncreateur==1 || $fonctioncreateur ==2 ){
                    switch($holoncreateur){
                        case 5:
                        $destinataireMail2=$emailVars->listes->leaderis01;
                        break;
                        case 6:
                        $destinataireMail2=$emailVars->listes->leaderis03;
                        break;
                        case 7:
                        $destinataireMail2=$emailVars->listes->leaderis06;
                        break;
                        case 8:
                        $destinataireMail2=$emailVars->listes->leaderiw01;
                        break;
                        case 9:
                        $destinataireMail2=$emailVars->listes->leaderiw02;
                        break;
                        case 10:
                        $destinataireMail2=$emailVars->listes->leaderiw03;
                        break;
                        case 11:
                        $destinataireMail2=$emailVars->listes->leaderis02;
                        break;
                        case 12:
                        $destinataireMail2=$emailVars->listes->leaderis05;
                        break;
                        case 13:
                        $destinataireMail2=$emailVars->listes->leaderis04;
                        break;
                        case 14:
                        $destinataireMail2=$emailVars->listes->leaderiw04;
                        break;
                        case 15:
                        $destinataireMail2=$emailVars->listes->leaderiw05;
                        break;
                        case 16:
                        $destinataireMail2=$emailVars->listes->leaderiw06;
                        break;
                        case 17:
                        $destinataireMail2=$emailVars->listes->leaderiw07;
                        break;
                        case 18:
                        $destinataireMail2=$emailVars->listes->leaderin01;
                        break;
                        case 19:
                        $destinataireMail2=$emailVars->listes->leaderin02;
                        break;
                        case 20:
                        $destinataireMail2=$emailVars->listes->leaderin03;
                        break;
                        case 21:
                        $destinataireMail2=$emailVars->listes->leaderin04;
                        break;
                        case 22:
                        $destinataireMail2=$emailVars->listes->leaderin05;
                        break;
                        case 23:
                        $destinataireMail2=$emailVars->listes->leaderin06;
                        break;
            }
                  $url2 = "http://{$_SERVER['SERVER_NAME']}/xprice/consultleader/numwp/{$numwp}";
                    $corpsMail2 = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XPrice à consulter.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xsuite";
                    $mail2 = new Xsuite_Mail();
                    $mail2->setSubject("XPrice : Nouvelle Offre à consulter de {$user_info['nom']} pour {$infos_client['nom_client']}")
                        ->setBodyText(sprintf($corpsMail2, $url2))
                        ->addTo($destinataireMail2)
                        ->send();
                  }
                 /*
                  * ici si fonction itc kam ou leader  envoie de mail au chef de region pour validation
                  */
                $zonetracking=substr($trackingNumber,6,2);
                if( $fonctioncreateur==1 || $fonctioncreateur ==2 ||  $fonctioncreateur==3){
                    if($zonetracking =="QA"){     
                        $destinataireMail1 = $emailVars->listes->qa;
                    }
                    elseif($zonetracking =="QC" || $zonetracking =="QF") {
                        $destinataireMail1= $emailVars->listes->CDRNORD;
                    }
                    elseif($zonetracking =="QE" || $zonetracking =="QH") {
                        $destinataireMail1 = $emailVars->listes->CDREST;
                    }
                    elseif($zonetracking =="QI" || $zonetracking =="QK") {
                        $destinataireMail1 = $emailVars->listes->CDROUEST;
                    }
                    $url1 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefregion/numwp/{$numwp}";
                    $corpsMail1 = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XPrice à valider.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xsuite";
                    $mail1 = new Xsuite_Mail();
                    $mail1->setSubject("XPrice : Nouvelle Offre à valider de {$user_info['nom']} pour {$infos_client['nom_client']}")
                        ->setBodyText(sprintf($corpsMail1, $url1))
                        ->addTo($destinataireMail1)
                        ->send();
                }
                /*
                 * ici si le createur de la demande est un dd un cdr ou un dm alors envoie de mail au chef de marché
                 */
                elseif ($fonctioncreateur==7 || $fonctioncreateur==6 || $fonctioncreateur ==11) {
                    if($zonetracking=="QA" || $zonetracking=="QF" ||$zonetracking=="QE" || $zonetracking=="QI" || $zonetracking=="QC" ||$zonetracking=="QH" ||$zonetracking=="QK"){
                        $destinataireMail3 = $emailVars->listes->cm;
                        $url3 = "http://{$_SERVER['SERVER_NAME']}/xprice/validatechefmarche/numwp/{$numwp}";
                    $corpsMail3 = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XPrice à valider.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xsuite";
                    $mail3 = new Xsuite_Mail();
                    $mail3->setSubject("XPrice : Nouvelle Offre à valider de {$user_info['nom']} pour {$infos_client['nom_client']}")
                        ->setBodyText(sprintf($corpsMail3, $url3))
                        ->addTo($destinataireMail3)
                        ->send();
                    }
            }
                 else{
                     $corpsMail="tagada";
                     $mailto="mhuby@smc-france.fr";
                     $mail=new Xsuite_Mail;
                     $mail->setSubject("plop")
                 ->setBodyText(sprintf($corpsMail))
                             ->addTo($mailto)
                             ->send();}
                /*
                 * FIN DE PAS TOUCHER
                 * Fin du traitement
                 */
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "Votre demande à bien été enregistrée .'{$zonetracking}'.'{$fonctioncreateur}'";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            } else {
                $form->populate($formData);
            }
        }
        $this->view->form = $form;
    }
    public function consultleaderAction(){
        
    }
    public function validatechefregionAction(){
        $user = $this->_auth->getStorage()->read();
        // var_dump($user);

        $numwp = $this->getRequest()->getParam('numwp', null);
        //var_dump($numwp);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
//        echo '<pre>', var_export($info_demande_xprice), '</pre>';
        $user_id = $info_demande_xprice['id_user'];
        var_dump($user_id);
//        exit();
        $this->view->info_demande_xprice = $info_demande_xprice;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        echo '<pre>', var_export($info_user), '</pre>';
        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
        echo '<pre>',var_export($info_client),'</pre>';
        $this->view->info_client = $info_client;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        echo '<pre>',  var_export($info_demande_article_xprice,true),'</pre>';
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
    }
    
    public function prixfobfrAction() {
        $user = $this->_auth->getStorage()->read();
        // var_dump($user);

        $numwp = $this->getRequest()->getParam('numwp', null);
        //var_dump($numwp);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
//        echo '<pre>', var_export($info_demande_xprice), '</pre>';
        $user_id = $info_demande_xprice['id_user'];
//        var_dump($user_id);
//        exit();
        $this->view->info_demande_xprice = $info_demande_xprice;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        //echo '<pre>', var_export($info_user), '</pre>';
        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
        //echo '<pre>',var_export($info_client),'</pre>';
        $this->view->info_client = $info_client;
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        //echo '<pre>',  var_export($info_demande_article_xprice,true),'</pre>';
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        $anneecourante=date('Y');
        foreach ($info_demande_article_xprice as $value) { $query = "select *  from 
                    EIT.MVXCDTA.MCHEAD MCHEAD WHERE MCHEAD.KOITNO = '{$value['code_article']}'and substring(MCHEAD.KOPCDT,1,4) like '$anneecourante%'";
                                      
            $infos_prixfobfr = odbc_exec($this->odbc_conn2, $query);
            while ($info_prixfobfr = odbc_fetch_array($infos_prixfobfr)) {
                $date1 = substr($info_prixfobfr['KOPCDT'], 0, -4);
                $date2 = substr($info_prixfobfr['KOPCDT'], 4, -2);
                $date3 = substr($info_prixfobfr['KOPCDT'], 6, 2);
                $date = implode('-', array($date1, $date2, $date3));
                $this->view->info_prixfobfr = $info_prixfobfr;
            }
        }

        if ($this->getRequest()->isPost()) {
            $date_validationfobfr = date("d-m-Y");
            $etat = "validé";
            $nom_validationfobfr = "fobfr";
            $formData[] = $this->getRequest()->getPost();
            //echo "<pre>", var_export($formData),"</pre>";
            foreach ($formData as $datas) {
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
                $validation = $validations->createValidation($nom_validationfobfr, $date_validationfobfr, $etat, $datas['commentaire_fobfr'], $user->id_user, $datas['tracking_number']);
            }
            //changer l'adresse mail et faire en sorte que ce  soit le supply chain qui recoive le mail
            $emailVars = Zend_Registry::get('emailVars');
            $fobfrMail = $emailVars->listes->fobfr;
            $url = "http://{$_SERVER['SERVER_NAME']}/xprice/validatesupply/numwp/{$numwp}";
            $corpsMail = "Bonjour,\n"
                    . "\n"
                    . "Vous avez une nouvelle demande XPrice à valider.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Prix fobfr.";
            $mail = new Xsuite_Mail();
            $mail->setSubject("XPrice : Nouvelle demande à valider.")
                    ->setBodyText(sprintf($corpsMail, $url))
                    ->addTo($fobfrMail)
                    ->send();
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "les prix fob et cif  ont bien été enregistrés.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xprice');
        } else {

        }
    }

    public function deleteAction() {
        // action body
    }

    public function validatesupplyAction() {
        $user = $this->_auth->getStorage()->read();
        // var_dump($user);
        $nom_validation = "fobfr";
        $numwp = $this->getRequest()->getParam('numwp', null);
        //var_dump($numwp);
        $this->view->numwp = $numwp;
        /*
         * on va rechercher les informations concernant la demande _xprice
         */
        $infos_demande_xprice = new Application_Model_DbTable_Xprices();
        $info_demande_xprice = $infos_demande_xprice->getNumwp($numwp);
        //echo '<pre>', var_export($info_demande_xprice), '</pre>';
        // var_dump( $info_demande_xprice['id_user']);
        $this->view->info_demande_xprice = $info_demande_xprice;
        $infos_user = new Application_Model_DbTable_Users();
        $info_user = $infos_user->getUserDemande($info_demande_xprice['id_user']);
        // echo '<pre>',var_export($info_user),'</pre>';
        $this->view->info_user = $info_user;
        $infos_client = new Application_Model_DbTable_Clients();
        $info_client = $infos_client->getClientnumwp($info_demande_xprice['numwp_client']);
        //echo '<pre>',var_export($info_client),'</pre>';
        $this->view->info_client = $info_client;
        $infos_validation = new Application_Model_DbTable_Validationsxprice();
        $info_validation = $infos_validation->getValidation($nom_validation, $info_demande_xprice['tracking_number_demande_xprice']);
        $this->view->info_validation = $info_validation;
        //echo '<pre>',var_export($info_validation,true),'</pre>';
        $infos_demande_article_xprice = new Application_Model_DbTable_DemandeArticlexprices();
        $info_demande_article_xprice = $infos_demande_article_xprice->getDemandeArticlexprice($numwp);
        //echo '<pre>',  var_export($info_demande_article_xprice,true),'</pre>';
        $this->view->info_demande_article_xprice = $info_demande_article_xprice;
        foreach ($info_demande_article_xprice as $value) {


            $query = "select * from EIT.MVXCDTA.MCHEAD MCHEAD WHERE MCHEAD.KOITNO = '{$value['code_article']}' order by KOPCDT desc limit 1";
            $infos_prixfobfr = odbc_exec($this->odbc_conn2, $query);
            while ($info_prixfobfr = odbc_fetch_array($infos_prixfobfr)) {
                $date1 = substr($info_prixfobfr['KOPCDT'], 0, -4);
                $date2 = substr($info_prixfobfr['KOPCDT'], 4, -2);
                $date3 = substr($info_prixfobfr['KOPCDT'], 6, 2);
                $date = implode('-', array($date1, $date2, $date3));
                $this->view->info_prixfobfr = $info_prixfobfr;
            }
        }
        if ($this->getRequest()->isPost()) {
            $date_validationsupply = date("d-m-Y");
            $etat = "validé";
            $nom_validationsupply = "supply";
            $formData[] = $this->getRequest()->getPost();
            foreach ($formData as $datas) {
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
                $validation = $validations->createValidation($nom_validationsupply, $date_validationsupply, $etat, $datas['commentaire_fobfr'], $user->id_user, $datas['tracking_number']);
            }
        }
    }
    
    public function validatedbdAction(){
    
    }
    public function validatedircoAction(){
    
    }

    public function updateAction() {

    }
    
    public function listAction() {
        $tracking = $this->getRequest()->getParam('tracking_number', null);
        $tracking_number = 'SP-FR-' . $tracking;
        $this->view->tracking_number = $tracking_number;
        $infos = new Application_Model_DbTable_DemandeArticlexprices();
        $info = $infos->listtracking($tracking_number);
        //echo '<pre>', var_export($info, true), '</pre>';
        $num_workplace_demande_xprice= "$num_workplace_demande_xprice" ;
        $this->view->num_workplace_demande_xprice=$num_workplace_demande_xprice;
        
        $tests = new Application_Model_DbTable_DemandeArticlexprices();
        $test = $tests->sommePrixDemandeArticle($num_workplace_demande_xprice);
       // echo '<pre>', var_export($test, true), '</pre>';         
        
    }

}

