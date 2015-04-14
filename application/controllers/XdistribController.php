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
     protected function sendEmail($params) {
        $mail = new Xsuite_Mail();
        $mail->setSubject($params['sujet'])
                ->setBodyText(sprintf($params['corpsMail'], $params['url']))
                ->addTo($params['destinataireMail'])
                ->send();
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
     if($user->id_fonction == 6){
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib();
         $recapitulatif2 = $recapitulatif1->searchforDD($user->id_user);
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
    //echo '<pre>',var_export($recapitulatif2),'</pre>';
    }
     protected function genererValidation($datas) {
        $dbtValidation = new Application_Model_DbTable_Validationsdemandexdistrib();
        $now = new Datetime();
        $commentaire = (!is_null($datas['commentaire']) && trim($datas['commentaire']) != "") ? trim($datas['commentaire']) : null;
        $validations_demande_xdistrib_id = (array_key_exists('reponse', $datas) && trim($datas['reponse']) != "") ? $datas['reponse'] : null;
        $dbtValidation->createValidation(
                $validations_demande_xdistrib_id,$datas['id_demande_xdistrib'],$datas['tiltop'],$datas['nom_validation'], $now->format('Y-m-d H:i:s'), $datas['validation'],  $commentaire );
        if (!is_null($commentaire)) {
            return $dbtValidation->lastId();
        } else {
            return null;
        }
    }
    public function createnofileAction(){
        $numwp = $this->getRequest()->getParam('numwp', null);
        /* on vérifie que la demande  n'existe pas */
        $demandes_xdistrib = new Application_Model_DbTable_Xdistrib();
        $demandeXdistrib = $demandes_xdistrib->getNumwp($numwp);
        if (!is_null($demandeXdistrib)) {
            $redirector = $this->_helper->getHelper('Redirector');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "Cette offre a déjà été créée.";
            $flashMessenger->addMessage($message);
            $redirector->gotoSimple('index', 'xdistrib');
        }
        $this->view->numwp = $numwp;
        if (!is_null($numwp)) {
            $sql = "select * from EIT.CVXCDTA.OOLINE OOLINE where OOLINE.OBORNO='{$numwp}'";
            $infos_offre = odbc_exec($this->odbc_conn, $sql);
            $infos_offres = odbc_fetch_object($infos_offre);
            $this->view->infos_offres=$infos_offres;
            /*
             *'OBDLSP-> numéro client final (10 chiffres)'
             *'OBCUNO-> numéro distributeur (5 chiffres)'
             *'OBRGDT->date de l'offre'
             *'OBSMCD -> id du contact (tc smc)'
             *'OBCHID-> FR--------(7lettres nom + premiere lettre prenom) créateur de la demande DD)
             */
            $numwp_user=$infos_offres->OBSMCD;
            $nomdeb = trim($infos_offres->OBCHID);
            $nomdebu=substr($nomdeb,2,-1);
            $infodd=new Application_Model_DbTable_Users();
            $infos_dd=$infodd->getUserName($nomdebu);
            $this->view->infos_dd=$infos_dd;
            $infotc=new Application_Model_DbTable_Users();
            $infos_tc = $infotc->getMovexUser($numwp_user);
            $this->view->infos_tc=$infos_tc;
            $dateinit = $infos_offres->OBRGDT;
            $dateinit3 = substr($dateinit, 0, 4);
            $dateinit2 = substr($dateinit, 4, 2);
            $dateinit1 = substr($dateinit, 6, 2);
            $dateinitf = array($dateinit1, $dateinit2, $dateinit3);
            $datefinal = implode('/', $dateinitf);
            $this->view->datefinal = $datefinal;
            $user = $this->_auth->getStorage()->read();
            $query1bis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '{$infos_offres->OBDLSP}'";
            $infos_client = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1bis));
            $this->view->infos_client=$infos_client;
            $query1quart = "select ZMCPJO.Z2MCL1  from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '{$infos_offres->OBDLSP}' ";
            $industriewp = odbc_fetch_array(odbc_exec($this->odbc_conn3, $query1quart));
            $this->view->industriewp = $industriewp;
            $industriewp['Z2MCL1'] = trim($industriewp['Z2MCL1']);
            if ($industriewp['Z2MCL1'] == "" || $industriewp['Z2MCL1'] == " ") {
                $industriewp['Z2MCL1'] = "SCI";
            }
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
            $querydisbis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '{$infos_offres->OBCUNO}'";
            $infos_distrib = odbc_fetch_array(odbc_exec($this->odbc_conn2, $querydisbis));
            $this->view->infos_distrib=$infos_distrib;   
             $query1quart2 = "select * from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '{$infos_offres->OBCUNO}' ";
            $industriewp4 = odbc_fetch_array(odbc_exec($this->odbc_conn3, $query1quart2));
            
            $sqlaffiche = "select
                OOLINE.OBITNO,
                OOLINE.OBITDS,
                OOLINE.OBORQT,
                OOLINE.OBLNA2,
                OOLINE.OBNEPR,
                OOLINE.OBSAPR,
                OOLINE.OBELNO
                from EIT.CVXCDTA.OOLINE OOLINE WHERE OOLINE.OBORNO='{$numwp}'  AND OOLINE.OBDIVI LIKE 'FR0' AND OOLINE.OBCONO=100";
                $affiche_offres=odbc_exec($this->odbc_conn, $sqlaffiche);
               
         while( $affiche_offre[]=odbc_fetch_array($affiche_offres)){
             $this->view->affiche_offre=$affiche_offre;
         }
    }
       if ($this->getRequest()->isPost()) {
       $formData = $this->getRequest()->getPost();
       $result= array_combine($formData['reference'],$formData['quantite']);
      $result2=  array_combine( $formData['reference'],$formData['prix_tarif_dis']);
//       $redirector = $this->_helper->getHelper('Redirector');
//            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
//            $message = "votre offre  a bien été créée.";
//            $flashMessenger->addMessage($message);
//            $redirector->gotoSimple('index', 'xdistrib');
       echo '<pre>',var_export($formData),'</pre>';
        echo '<pre>',var_export($result),'</pre>';
        echo '<pre>',var_export($result2),'</pre>';
       }
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

            /* upload du fichier xlsx coorespondant à l'offre */
if($this->getRequest()->isPost()){
        $numwp= $_POST['num_offre_workplace'];
        $filename=$_FILES['nomfichier']['name'];
        ini_set("display_errors", E_ALL);
        $destination=APPLICATION_PATH.'/datas/filesDatas/';
        $plop= new Zend_File_Transfer_Adapter_Http();
        $plop->setDestination($destination);
        if(!$plop->receive()) {
            var_dump($plop->getMessages());
        }
        
        /*fin de l'upload  le fichier se trouve dans datas/filesDatas*/
        /*lecture du fichier xlsx utilisation de la librairie PHPExcel */
        // $numwp = $this->getRequest()->getParam('num_offre_workplace', null);

        include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
        $inputFileName = APPLICATION_PATH.'/datas/filesDatas/'.$filename;
        // Chargement du fichier Excel
        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        /**
        * récupération de la première feuille du fichier Excel
        * @var PHPExcel_Worksheet $sheet
        */
        $sheet = $objPHPExcel->getSheet(0);
        $i=0;
        $excellContent = array();
        foreach($sheet->getRowIterator() as $row) {
            if($i<4) {
                $i++;
                continue;
            }
            $rowC = array();
        // On boucle sur les cellule de la ligne
            foreach ($row->getCellIterator() as $cell) {
                $rowC[] = $cell->getValue();
            }
            $excellContent[] = $rowC;
        }
        $nomcontact=$excellContent[1][1];
        $nom_distributeur=$excellContent[4][1];
        $nom_client_final=$excellContent[4][6];
        $numwp_client_final=$excellContent[4][8];
        $code_postal_distributeur=$excellContent[5][1];
        $ville_distributeur=$excellContent[5][3];
        $code_postal_client_final=$excellContent[5][6];
        $ville_client_final=$excellContent[5][8];
        $contact_distributeur=$excellContent[6][1];

          /* deuxième iteration  on va  recuperer les données  concernant les articles  on boucle tant qu'on a pas de ligne  vide  ou  que l'on ne rencontre pas ''concurrence''*/ 
        $j=0;
        foreach($sheet->getRowIterator() as $row) {
            if($j <14) {
                $j++;
                continue;
            }
            $rowC2 = array();
            // On boucle sur les cellule de la ligne
            foreach ($row->getCellIterator() as $cell) {
                $rowC2[] = $cell->getValue();
            }
            $excellContent2[] = $rowC2;
        }
        foreach($excellContent2 as $key=>$row){
            if($row[0]== NULL ||$row[0]=="CONCURRENCE"){
                break; }else{   
                $rows[]=$row;
            }      
        }
        $rowsbis=array_filter(array_map('array_filter',$rows));
//       echo '<pre>', var_export($rowsbis),'</pre>';

        ///*troisieme iteration on va chercher 
        // * le nom des concurrents les references
        // *  articles le prix concurrent
        // * le prix spé concurrent 
        // */
        $m=0;
        foreach($sheet->getRowIterator() as $row) {
            if($m<14) {
                $m++;
            continue;
            }
            $rowC3 = array();
            // On boucle sur les cellule de la ligne
            foreach ($row->getCellIterator() as $cell) {
                $rowC3[] = $cell->getValue();
        }
            $excellContent3[] = $rowC3;
        }
        foreach ($excellContent3 as $key=>$val){
        $plopinette[]=trim($val[0]);   
        }
        $keydebut=array_search('Concurrents',$plopinette);
        $keyfin =array_search('Contexte de la demande (historique client, situation concurrentielle, évolution du compte, enjeux…)',$plopinette);
        $debut = $keydebut+1;
        $fin=$keyfin;

        for($n=$debut;$n<$fin;$n++){
            $row1=$excellContent3[$n];
            $rows3[]=$row1;
        }
        $rows3bis=array_filter(array_map('array_filter',$rows3));

        /*iteration 4*/
        $p=0;
        foreach($sheet->getRowIterator() as $row) {
            if($p<14) {
                $p++;
                continue;
            }
            $rowC4 = array();
            // On boucle sur les cellule de la ligne
            foreach ($row->getCellIterator() as $cell) {
                $rowC4[] = $cell->getValue();
            }
            $excellContent4[] = $rowC4;
        }
        foreach ($excellContent4 as $key=>$val){
            $plopinette1[]=trim($val[0]);   
        }
        $keydebut1 =array_search('Contexte de la demande (historique client, situation concurrentielle, évolution du compte, enjeux…)',$plopinette1);
        $keyfin1 =array_search('Services associés du distributeur',$plopinette1);
        $debut1 = $keydebut1+1;
        $fin1=$keyfin1-1;

        for($q=$debut1;$q<$fin1;$q++){
            $row5=$excellContent4[$q];
            $rows6[]=$row5;
        }
        $rows6bis=array_filter(array_map('array_filter',$rows6));

        /*iteration 5 on va chercher les services associes */
        $r=0;
        foreach($sheet->getRowIterator() as $row) {
            if($r<14) {
                $r++;
                continue;
            }
            $rowC5 = array();
            // On boucle sur les cellule de la ligne
            foreach ($row->getCellIterator() as $cell) {
                $rowC5[] = $cell->getValue();
            }
            $excellContent5[] = $rowC5;
        }
        foreach ($excellContent5 as $key=>$val){
            $plopinette2[]=trim($val[0]);
        }
        $keydebut2 =array_search('Services associés du distributeur',$plopinette2);
        $keyfin2 =array_search('Services associés du distributeur',$plopinette1);
        $debut2 = $keydebut2+1;
        $fin2=$keyfin2+2;

        for($t=$debut2;$t<$fin2;$t++){
            $row6=$excellContent5[$t];
            $rows7[]=$row6;
        }
        $rows7bis=array_filter(array_map('array_filter',$rows7));  


        /*
         * fin de lecture du fichier xlsx
         */

        /*
         * insertion des données du fichier xlsx  dans les tables temporaires
         *
         */
        $tempinfodistrib= new Application_Model_DbTable_TempFichierDistribInfo();
        $tempinfodistribs = $tempinfodistrib->createInfo($numwp, $nom_distributeur, $code_postal_distributeur, $ville_distributeur, $contact_distributeur, $nom_client_final, $numwp_client_final, $code_postal_client_final, $ville_client_final);
        $temparticledistrib = new Application_Model_DbTable_TempFichierDistribArticle();
        foreach($rowsbis as $value){
            $temparticledistribs = $temparticledistrib->createArticle($numwp, trim($value[0]), $value[1], $value[2], $value[3], $value[5], $value[6]);
        }
        $tempprixconcurrent = new Application_Model_DbTable_TempFicherDistribPrixConcurrent();
        foreach ($rows3bis as $value){
            $tempprixconcurrents=$tempprixconcurrent->createPrixConcurrent($numwp, $value[0], $value[1], $value[3], $value[5]);
        }

        $tempContexte= new Application_Model_DbTable_TempFichierContexte();
        $tempContextes=$tempContexte->createContexte($numwp,$rows6bis[0][0] , $rows7bis[0][0]);
        /*
         * fin de l'insertion des données dans les tables temporaires
         */
        /* début d'insertion des données movex dans les tables temporaires*/

        //$numwp = $this->getRequest()->getParam('num_offre_workplace', null);
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
            $pirate = "select OOLINE.OBCHID,OOLINE.OBORNO,OOLINE.OBCUNO, OOLINE.OBRGDT, OOLINE.OBDLSP, OOLINE.OBSMCD from EIT.CVXCDTA.OOLINE OOLINE where OOLINE.OBORNO='{$numwp}'";
            $infos_offre = odbc_exec($this->odbc_conn, $pirate);
            $infos_offres = odbc_fetch_object($infos_offre);
            $this->view->infos_offres = $infos_offres;
//            echo '<pre>',  var_export($infos_offres),'</pre>'; (exit);
            $nomdeb = trim($infos_offres->OBCHID);
            $nomdebu=substr($nomdeb,2,-1);
            $infodd=new Application_Model_DbTable_Users();
            $infos_dd=$infodd->getUserName($nomdebu);
            $this->view->infos_dd=$infos_dd;
            $dateinit = $infos_offres->OBRGDT;
            $dateinit3 = substr($dateinit, 0, 4);
            $dateinit2 = substr($dateinit, 4, 2);
            $dateinit1 = substr($dateinit, 6, 2);
            $dateinitf = array($dateinit1, $dateinit2,$dateinit3);
            $datefinal = implode('/', $dateinitf);
            $this->view->datefinal = $datefinal;
            $datef=array($dateinit3, $dateinit2,$dateinit1) ;
            $date=implode('-',$datef);
            /*insertion dans la table temp_movex_offre(numwp,date_offre,numwp_createur_offre,numwp_distributeur*/
            $temps= new Application_Model_DbTable_TempMovexOffre();
            $temp=$temps->createInfo($numwp, $dateinit, $infos_offres->OBSMCD, $infos_offres->OBCUNO);
            /*
             * fin de l'insertion 
             */

            /*
             * insertion dans la table temp_movex_distributeur
             */
            $query1bis = "select * from EIT.MVXCDTA.OCUSMA OCUSMA where OCUSMA.OKCUNO = '$infos_offres->OBCUNO'";
            $infos_distributeur = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1bis));
            $adresse = $infos_distributeur['OKCUA1'] . $infos_distributeur['OKCUA2'] . $infos_distributeur['OKCUA3'] . $infos_distributeur['OKCUA4']; //echo $adresse;
            $query1ter = "select OOHEAD.OACHL1 from EIT.MVXCDTA.OOHEAD OOHEAD where OOHEAD.OACUNO = '$infos_offres->OBCUNO'";
            $numdistributeurwp = odbc_fetch_array(odbc_exec($this->odbc_conn2, $query1ter));
            $query1quart = "select ZMCPJO.Z2MCL1  from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '$infos_offres->OBCUNO' ";
            $industriewp = odbc_fetch_array(odbc_exec($this->odbc_conn3, $query1quart));
            $industriewp['Z2MCL1'] = trim($industriewp['Z2MCL1']);
            if ($industriewp['Z2MCL1'] == "" || $industriewp['Z2MCL1'] == " ") {
                $industriewp['Z2MCL1'] = "SCI";
            }
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
             $id_industry =$info_industry['id_industry'];
             $numwp_distributeur5 = $infos_offres->OBCUNO;
             $numwp_distributeur10 = $numdistributeurwp['OACHL1'];
             $potentiel_distributeur=$infos_distributeur['OKCFC7'];
             $tempDistribs=new Application_Model_DbTable_TempMovexDistrib();
             $tempDistrib=$tempDistribs->createdistrib($numwp, $numwp_distributeur5, $id_industry, $numwp_distributeur10, $potentiel_distributeur, $adresse);

            /*
             * fin insertion insertion table temp_movex_distributeur
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
                $agreement1 = "I000001";
                $agreement2 = "I000002";
                $agreement3 = "I000003";
                $query3 = "select * from EIT.MVXCDTA.MPAGRP MPAGRP where MPAGRP.AJCONO = '$mmcono'  AND MPAGRP.AJOBV2 = '{$itnoarticle['OBITNO']}' AND MPAGRP.AJOBV1 = '$division'  ORDER BY MPAGRP.AJAGNB";
                $resultats3 = odbc_Exec($this->odbc_conn2, $query3);
                $prixciffob[] = odbc_fetch_object($resultats3);
                $acquis= "select MITBAL.MBITNO, MITBAL.MBPUIT from EIT.MVXCDTA.MITBAL MITBAL where MITBAL.MBITNO ='{$itnoarticle['OBITNO']}'";
                $resultatsacquis=odbc_Exec($this->odbc_conn2, $acquis);
                $resultatacquis[] = odbc_fetch_object($resultatsacquis);
            }
            $demandes_articles_xdistrib = new Application_Model_DbTable_TempMovexDemande();
            foreach ($this->view->resultat as $resultarticle) {
                $demande_article_xdistrib = $demandes_articles_xdistrib->createDemandeTemp(trim($resultarticle['OBITNO']),trim($resultarticle['OBITDS']),$resultarticle['OBSAPR'], $resultarticle['OBORQT'], $resultarticle['OBNEPR'],$numwp,$resultarticle['OBNEPR'], round(100 - ($resultarticle['OBNEPR'] * 100 / $resultarticle['OBSAPR']), 2),null,null,null,null);
            }

            /*insertion et update  prix fob et cif*/ 
            foreach ($prixciffob as $key => $value) {
                $insertprix = new Application_Model_DbTable_TempMovexDemande();
               $inserprix = $insertprix->InserPrixFob($value->AJPUPR, $value->AJOBV2, $numwp);
            }
            foreach($resultatacquis as $key=>$value){
                $insertacquis= new Application_Model_DbTable_TempMovexDemande();
                $inseracquis = $insertacquis->InserCodeAcquis($value->MBPUIT, $value->MBITNO, $numwp);
            }

            $updatecif1 = new Application_Model_DbTable_TempMovexDemande();
            $updatecif2 = $updatecif1->getDemandeArticlexdistrib($numwp);                   
            foreach($updatecif2 as $result){
                if($result['code_acquisition']=='2'){
                    $cifs= ($result['prix_fob'])*1.07;
                    $cif=round($cifs,2);
                    $updatecif3 = $updatecif1->updatecif($cif, $result['code_article'], $numwp);
                }
            }
//                                $margeupdate1=new Application_Model_DbTable_TempMovexDemande();
//                                $margeupdate2=$margeupdate1->getDemandeArticlexdistrib($numwp);
//                                foreach($margeupdate2 as $res){
//                                    $marges = 1-($res['prix_cif']/$res['prix_accorde']);
//                                    $marge=$marges*100;
//                                    $margeupdate3=$margeupdate1->updateMarge($marge, $res['code_article'],$numwp);
//                                }

        /* creation table temporaire pour  client */
            $queryClientFinal = "select ZMCPJO.Z2MCL1  from EIT.SMCCDTA.ZMCPJO  ZMCPJO where ZMCPJO.Z2CUNO= '$numwp_client_final' ";
            $clientFinalwp = odbc_fetch_array(odbc_exec($this->odbc_conn3, $queryClientFinal));
            $clientFinalwp['Z2MCL1'] = trim($clientFinalwp['Z2MCL1']);
            if ($clientFinalwp['Z2MCL1'] == "" || $clientFinalwp['Z2MCL1'] == " ") {
                    $clientFinalwp['Z2MCL1'] = "SCI";
            }
             if (isset($clientFinalwp['Z2MCL1']) && $clientFinalwp['Z2MCL1'] != '' && $clientFinalwp['Z2MCL1'] != ' ' && $industriewp['Z2MCL1'] != '  ') {
                $industry = new Application_Model_DbTable_Industry();
                $info_industry_client_final= $industry->getMovexIndustry($clientFinalwp['Z2MCL1']);
                $this->view->info_industry_client_final = $info_industry_client_final;
            } else {
                $plopClientFinal = "SCI";
                $industry = new Application_Model_DbTable_Industry();
                $info_industry_client_final = $industry->getMovexIndustry($plopClientFinal);
                $this->view->info_industry_client_final = $info_industry_client_final;                   
            }
                //echo '<pre>',  var_export($info_industry_client_final),'</pre>';
            $id_industry_client_final =$info_industry_client_final['id_industry'];
            $nom_industry=$info_industry_client_final['description_industry'];
          
            $clientTemps= new Application_Model_DbTable_TempClient();
            $clientTemp= $clientTemps->createTemp($numwp,$infos_offres->OBDLSP,$code_postal_client_final,$ville_client_final,$nom_industry,$id_industry,$nom_client_final);
            
            $clientDEF= new Application_Model_DbTable_ClientDistrib();
            $clientDefs= $clientDEF->createClientDistrib($numwp,$infos_offres->OBDLSP,$code_postal_client_final,$ville_client_final,$nom_industry,$id_industry,$nom_client_final,null);
        /*fin de l'insertion des données movex dans les tables temporaires */
            /* debut de requettage  pour affichage des informations  dans le phtml*/
            /*requete info_ vendeur, info_distrib,info_client*/ 
            /*recuperation des donnees concernant le createur de l'offre*/
            $user_infos = new Application_Model_DbTable_TempMovexOffre();
            $user_info = $user_infos->getMovexUser($numwp);
            $this->view->user_info = $user_info[0];
            $nom_zone = $user_info[0]['nom_zone'];
//            echo '<pre>',var_export($user_info),'</pre>';
            $distrib_infos = new Application_Model_DbTable_TempMovexOffre();
            $distrib_info=$distrib_infos->getDistrib($numwp);
            $this->view->distrib_info = $distrib_info[0];
            /*fin de requettage pour l'affichage des infos dans le phtml*/
            $client_infos= new Application_Model_DbTable_TempMovexOffre();
            $client_info=$client_infos->getClientFinal($numwp);
            $this->view->client_info=$client_info[0];
            $article_infos = new Application_Model_DbTable_TempMovexDemande();
            $article_info= $article_infos->demande($numwp);
            //var_dump($numwp);
            //echo '<pre>',  var_export($article_info),'</pre>'; 
            $this->view->article_info=$article_info;
            $concurrent_infos=new Application_Model_DbTable_TempFicherDistribPrixConcurrent();
            $concurrent_info=$concurrent_infos->getAll($numwp);
            $this->view->concurrent_info=$concurrent_info;
            $context_infos=new Application_Model_DbTable_TempFichierContexte();
            $context_info=$context_infos->getAll($numwp);
            $this->view->context_info=$context_info[0]['contexte_demande'];
            $this->view->service_info=$context_info[0]['services_associes'];
            $Xdistrib = new Application_Model_DbTable_Xdistrib();
            $trackingNumber = Application_Model_DbTable_Xdistrib::makeTrackingNumber($nom_zone, $Xdistrib->lastId(true));
            $this->view->trackingNumber = $trackingNumber;
        }
        $Defxdistribs= new Application_Model_DbTable_Xdistrib();
        $defxdistrib = $Defxdistribs->createXDistrib($numwp, $trackingNumber,$context_info[0]['contexte_demande'],$date,$context_info[0]['services_associes'], $user_info[0]['id_user'],$infos_dd->id_user,null,$infos_offres->OBDLSP,$numwp_distributeur5);
        $Defxdistribarticles= new Application_Model_DbTable_DemandeArticlexdistrib();
        foreach($article_info as $art){
            $marge_demande_article = 100*(1-($art['prix_cif']/$art['prix_achat_demande_distrib']));
            $Defxdistribarticle = $Defxdistribarticles->createDemandeArticlexdistrib(
                    $art['prix_tarif'],
                    $art['prix_achat_actuel'] ,
                    $art['prix_achat_demande_distrib'],
                    $art['prix_achat_demande_client_final'],
                    $art['quantite'],
                    $art['serie'],
                    $art['date'],
                    null,
                    null,
                    $art['prix_fob'], 
                    $art['prix_cif'],
                    $marge_demande_article,
                    $trackingNumber,
                    $art['code_article'],
                    $art['reference_article'],
                    $numwp,
                    $art['code_acquisition']);
        } 
        $DefConcurrents = new Application_Model_DbTable_PrixConcurrent();
        foreach($concurrent_info as $con){
             $DefConcurrent = $DefConcurrents->create($con['concurrent'],$con['reference_produit'],$con['prix_tarif_concurrent'],$con['prix_spe_accorde_concurrent'],$con['numwp']);
        }
       $defDistributeurs=new Application_Model_DbTable_Distributeurs();
       $defDistributeur=$defDistributeurs->createDistributeur($distrib_info[0]['distrib'], $distrib_info[0]['nom_contact_distrib'],$distrib_info[0]['numwp_distrib'],$distrib_info[0]['ville_distrib'],$distrib_info[0]['codepostal_distrib'], $id_industry,$potentiel_distributeur);
       

    }
    $fichierdef = APPLICATION_PATH.'/datas/filesDatas/'.$filename;
     unlink($fichierdef);
    }
    public function maildispatchAction(){
         $user_connect = $this->_auth->getStorage()->read();
          $emailVars = Zend_Registry::get('emailVars');
      if ($this->getRequest()->isPost()) {
        $formData = $this->getRequest()->getPost();
         $numwp=$formData['numwp']; 
        $tempClienttruns= new Application_Model_DbTable_TempClient();
        $tempClienttrun=$tempClienttruns->truncateAll(); 
        /*on va chercher des infos sur le user
        * si id_fonction =1 ou =2 alors envoi mail pour validation au dd de la zone 
        * si id_fonction =6 alors envoi mail pour validation au drv de la zone 
        */
        $info_service=new Application_Model_DbTable_ServiceDistrib();
        $infos_services=$info_service->createServiceDistrib($formData['numwp'], $formData['produitdedie'], $formData['ecatalogue'], $formData['journeetech'], $formData['accescom'], $formData['identconc'], $formData['interlocuteur'], $formData['service_associe']);
        $infos_users= new Application_Model_DbTable_Users();
        $id_user = $formData['id_user'];
        $info_user = $infos_users->getUser($id_user);
        $nom_client=$formData['nom_client'];
        $nom_distrib=$formData['nom_distrib'];
        $demandes_xdistrib = new Application_Model_DbTable_Xdistrib();
        $numwpexist = $demandes_xdistrib->getNumwp($numwp);
        $firstComment = null;
        if (!is_null($numwpexist)) {
            $dbtValidationDemande = new Application_Model_DbTable_Validationsdemandexdistrib();
            if (!is_null($formData['contexte']) && trim($formData['contexte']) != "") {
                $now = new DateTime();
                $validationDemande = $dbtValidationDemande->createValidation(null,$demandes_xdistrib->lastId(),$user_connect->id_user, "creation", $now->format('Y-m-d H:i:s'), "creation", null);
                $firstComment = $dbtValidationDemande->lastId();
            }
        }  
        $trackingNumber=$formData['trackingNumber'];
        $zonetracking = substr($trackingNumber, 7, 2);
        $destinataire=$formData['info_dd'];
        $params1=array();
        $params=array();
        if($user_connect->id_fonction == "6"){
            switch ($zonetracking) {
                case "QA":
                    $destinataireMail1 = $emailVars->listes->QA;
                    break;
                case "QC":
                    $destinataireMail1 = $emailVars->listes->CDRNORD;
                    break;
                case "QF":
                    $destinataireMail1 = $emailVars->listes->CDRNORD;
                    break;
                case "QE":
                    $destinataireMail1 = $emailVars->listes->CDREST;
                    break;
                case "QH":
                    $destinataireMail1 = $emailVars->listes->CDREST;
                    break;
                case "QI":
                    $destinataireMail1 = $emailVars->listes->CDROUEST;
                    break;
                case "QK":
                    $destinataireMail1 = $emailVars->listes->CDROUEST;
                    break;
            }
             $params['destinataireMail']=$destinataireMail1;
             $params['url']="http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedrv/numwp/{$numwp}";
             $params['corpsMail']="Bonjour,\n"
                                . "\n"
                                . "la demande XDistrib({$trackingNumber}/{$numwp}) de {$info_user['nom_user']} {$info_user['prenom_user']}  pour {$nom_distrib}/{$nom_client} est à valider.\n"
                                . "pour la valider veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                               . "Xsuite";
             $params['sujet']=" XDistrib :L'offre XDistrib {$trackingNumber}/{$numwp} de {$info_user['nom_user']} {$info_user['prenom_user']} pour {$nom_distrib}/{$nom_client} est à valider";
            $this->sendEmail($params);
            }
            elseif($user_connect->id_fonction == "1" || $user_connect->id_fonction== "2" || $user_connect->id_fonction == "3" ){
                $params1['destinataireMail']="mhuby@smc-france.fr";//$mail_dd;
                $params1['url']="http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedd/numwp/{$numwp}";
                $params1['corpsMail']="Bonjour,\n"
                            . "\n"
                            . "la demande XDistrib({$trackingNumber}/{$numwp}) de {$destinataire}/{$info_user['nom_user']} {$info_user['prenom_user']}  pour {$nom_distrib}/{$nom_client} est à valider .\n"
                            . "pour la valider veuillez vous rendre à l'adresse url : \n"
                            . "%s"
                            . "\n\n"
                            . "Cordialement,\n"
                            . "\n"
                            . "--\n"
                           . "Xsuite";
                $params1['sujet']=" XDistrib :L'offre XDistrib {$trackingNumber}/{$numwp} de {$info_user['nom_user']} {$info_user['prenom_user']} pour {$nom_distrib}/{$nom_client} est à valider";
                $this->sendEmail($params1);
//                echo '</pre>',  var_dump($params1['destinataireMail']),'</pre>';
            }    
//            $redirector = $this->_helper->getHelper('Redirector');
//            $redirector->gotoSimple('index', 'xdistrib');
        }
    }
    public function readerAction(){
  

    }
    public function consultAction()
    {
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp;
        $infos_demande_xdistrib= new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $dateinit=$info_demande_xdistrib['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $ferme = new Application_Model_DbTable_Validationsdemandexdistrib();
        $fermeture = $ferme->searchFermeture($numwp);
        foreach($fermeture as $ferm){
            $plop1 = $ferm;
        }
        $numwp_dis=  substr($info_demande_xdistrib['numwp_distributeur'], 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp_dis);
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib['id_user']);
        $nom_holon=new Application_Model_DbTable_Holons();
        $holon_nom=$nom_holon->getHolon($user_info['id_holon']);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib['numwp_client']);
        $info_article=new Application_Model_DbTable_DemandeArticlexdistrib();
        $article_info= $info_article->getDemandeArticlexdistrib($numwp);
        $info_concurrent=new Application_Model_DbTable_PrixConcurrent();
        $concurrent_info=$info_concurrent->getConcurrent($numwp);
        $info_contexte = new Application_Model_DbTable_Xdistrib();
        $contexte_info1= $info_contexte->getContext($numwp);
        $contexte_info2=$contexte_info1[0];
        $contexte_info=$contexte_info2;
        $info_service = new Application_Model_DbTable_ServiceDistrib();
        $service_info = $info_service->getService($numwp);
        $this->view->service_info=$service_info;
        $this->view->contexte_info = $contexte_info;
        $this->view->concurrent_info=$concurrent_info;
        $this->view->article_info=$article_info;
        $this->view->nom_holon=$holon_nom;
        $this->view->client_info=$client_info;
        $this->view->user_info=$user_info;
        $this->view->distrib_info=$distrib_info;
        $nomvalidationrecherche = "cdr";
        $tracking = $info_demande_xdistrib['tracking_number_demande_xdistrib'];
        $recherchevalidation = new Application_Model_DbTable_Validationsxdistrib();
        $recherchesvalidation = $recherchevalidation->getValidation($nomvalidationrecherche, $tracking);
        $infos_user = new Application_Model_DbTable_Users();
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXdistrib = new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationsDemandesXdistrib = $dbtValidationsDemandesXdistrib->getAllValidation($info_demande_xdistrib['id_demande_xdistrib']);

        $this->view->validations = $validationsDemandesXdistrib;
        //echo'<pre>',  var_export($validationsDemandesXprices),'</pre>';
        $usersValidations = array();

        foreach (@$validationsDemandesXdistrib as $key => $validationDemandeXdistri) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXdistri['id_user']);
            $usersValidations[$key]['fonction'] =$userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        $this->view->fermeturevalide=$plop1['etat_validation'];
        $this->view->dateplop=$dateplop;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
    } 
    public function trackingAction(){
         $track = $this->getRequest()->getParam('tracking_number_demande_xdistrib', null);
        $form = new Application_Form_TrackingSearchDistrib();
        //echo $track;
        if (!is_null($track)) {
            $form->populate(array("tracking_number_demande_xdistrib" => $track));
        }
        if ($this->getRequest()->isPost()) {
            $redirector = $this->_helper->getHelper('Redirector');

            if ($form->isValid($this->getRequest()->getPost())) {
                $tracksearch= new Application_Model_DbTable_Xdistrib();
                $r=$tracksearch->getTracking($track);
//                echo '<pre>',  var_export($r),'<pre>'; 
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
                    $redirector->gotoSimple('createnofile', 'xdistrib', null, array('numwp' => $_POST['num_offre_worplace']));
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
    
    public function validateddAction(){
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->dd = $tiltop;
        $this->view->tiltop=$tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $dateinit=$info_demande_xdistrib['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop=$dateplop;
        $numwp_dis=  substr($info_demande_xdistrib['numwp_distributeur'], 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp_dis);
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib['id_user']);
        $nom_holon=new Application_Model_DbTable_Holons();
        $holon_nom=$nom_holon->getHolon($user_info['id_holon']);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib['numwp_client']);
        $info_article=new Application_Model_DbTable_DemandeArticlexdistrib();
        $article_info= $info_article->getDemandeArticlexdistrib($numwp);
        $info_concurrent=new Application_Model_DbTable_PrixConcurrent();
        $concurrent_info=$info_concurrent->getConcurrent($numwp);
        $info_contexte = new Application_Model_DbTable_Xdistrib();
        $contexte_info1= $info_contexte->getContext($numwp);
        $contexte_info2=$contexte_info1[0];
        $contexte_info=$contexte_info2;
        $info_service = new Application_Model_DbTable_ServiceDistrib();
        $service_info = $info_service->getService($numwp);
        $this->view->service_info=$service_info;
        $this->view->contexte_info = $contexte_info;
        $this->view->concurrent_info=$concurrent_info;
        $this->view->article_info=$article_info;
        $this->view->nom_holon=$holon_nom;
        $this->view->client_info=$client_info;
        $this->view->user_info=$user_info;
        $this->view->distrib_info=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        /*
         * on recherche si la validation existe déjà ou si elle est en attente;
         */
        $nomvalidationrecherche = "dd";
        $tracking = $info_demande_xdistrib['tracking_number_demande_xdistrib'];
        $recherchevalidation = new Application_Model_DbTable_Validationsxdistrib();
        $recherchesvalidation = $recherchevalidation->getValidation($nomvalidationrecherche, $tracking);
        
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXdistrib = new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationsDemandesXdistribs = $dbtValidationsDemandesXdistrib->getAllValidation($info_demande_xdistrib['id_demande_xdistrib']);

        $this->view->validations = $validationsDemandesXdistribs;
        $usersValidations = array();

        foreach (@$validationsDemandesXdistribs as $key => $validationDemandeXdistrib) {
            $userValidationInfos = $info_user->getFonctionLabel($validationDemandeXdistrib['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['description_fonction'];
        }
        $this->view->usersValidations = $usersValidations;
        $blocages=new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationdbd="dbd";
        $blocage = $blocages->getValidation( $validationdbd, $info_demande_xdistrib['id_demande_xdistrib']);
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
            $redirector->gotoSimple('index', 'xdistrib');}
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
            $nom_validation = "dd";
            $formData = $this->getRequest()->getPost();
//echo '<pre>',  var_export($formData),'</pre>';
            $nouvelle_validation = new Application_Model_DbTable_Validationsxdistrib();
            $nouv_validation = $nouvelle_validation->createValidation($formData['nom_validation'], $formData['date_validation'], $formData['validation'], $formData['commentaire_dd'], $formData['tiltop'], $formData['tracking']);
            $valid_id_valid = new Application_Model_DbTable_Validationsxdistrib();
            $valid_id_valids = $valid_id_valid->getValidation($formData['nom_validation'], $formData['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $formData['validation'],
                'commentaire' => $formData['commentaire_dd'],
                'tiltop' => $formData['tiltop'], 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
            );
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
             $emailVars = Zend_Registry::get('emailVars');
            if (isset($formData['validation']) && $formData['validation'] == "validee"){
                $destIndustry =intval($client_info['id_industry']) ; 
                $emailVars = Zend_Registry::get('emailVars');
                $params=array();
                $params1=array();
                    switch ($destIndustry) {
                    case ($destIndustry > 0 && $destIndustry < 77 ):
                        $destinataireMail = $emailVars->listes->carIndustries1;
                        break;
                    case ($destIndustry > 76 && $destIndustry < 138 ):
                        $destinataireMail = $emailVars->listes->LifeandScience;
                        break;
                    case ($destIndustry > 137 && $destIndustry < 272 ):
                        $destinataireMail = $emailVars->listes->Electronique;
                        break;
                    case ($destIndustry > 271 && $destIndustry < 314 ):
                        $destinataireMail = $emailVars->listes->foodIndustries;
                        break;
                    case ($destIndustry > 313 && $destIndustry <= 415 ):
                        $destinataireMail = $emailVars->listes->environnementEnergie;
                        break;
                }
                $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consultchefmarche/numwp/{$numwp}";
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XDistrib {$tracking}/{$numwp} à consulter de {$user_info['nom_user']} pour {$client_info['nom_client']}.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "XDistrib";
                $params['destinataireMail'] = $destinataireMail;
                $params['sujet'] = " XDistrib : Nouvelle demande Xdistrib {$tracking}/{$numwp} à consulter de {$user_info['nom_user']} pour {$client_info['nom_client']}.";
               
                $this->sendEmail($params);
                $zonetracking = substr($tracking, 7, 2);
                switch ($zonetracking) {
                    case "QA":
                        $destinataireMail1 = $emailVars->listes->QA;
                        break;
                    case "QC":
                        $destinataireMail1 = $emailVars->listes->CDRNORD;
                        break;
                    case "QF":
                        $destinataireMail1 = $emailVars->listes->CDRNORD;
                        break;
                    case "QE":
                        $destinataireMail1 = $emailVars->listes->CDREST;
                        break;
                    case "QH":
                        $destinataireMail1 = $emailVars->listes->CDREST;
                        break;
                    case "QI":
                        $destinataireMail1 = $emailVars->listes->CDROUEST;
                        break;
                    case "QK":
                        $destinataireMail1 = $emailVars->listes->CDROUEST;
                        break;
                }
                    //
                    //echo '<pre>',  var_export($destinataireMail1),'</pre>'; exit();
                if (!is_null($firstComment)) {
                    $url1 = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedrv/numwp/{$numwp}/com/{$firstComment}";
                } else {
                    $url1 = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedrv/numwp/{$numwp}";
                }
                $corpsMail1 = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XDistrib ( {$tracking}/{$numwp}) à valider.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "XDistrib";
                $mail1 = new Xsuite_Mail();
                $mail1->setSubject("XDistrib : Nouvelle Offre XDistrib {$tracking}/{$numwp} à valider de {$user_info['nom_user']} pour {$client_info['nom_client']}")
                        ->setBodyText(sprintf($corpsMail1, $url1))
                        ->addTo($destinataireMail1)
                        ->send();
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande a été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');    
            }
            elseif(isset($formData['validation']) && $formData['validation'] == "nonValide") {
                $params2 = array();
                $params2['destinataireMail'] = $info_user['email_user'] ;
                $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params2['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XDistrib $tracking/$numwp a été refusée pour le client {$client_info['nom_client']} par le dd.\n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "XDistrib.";
                $params2['sujet'] = " XDistrib :demande $tracking/$numwp refusée par votre dd.";
                $this->sendEmail($params2);

                $message = "la demande a été refusée.";
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
            elseif (isset($formData['validation']) && $formData['validation'] == "enAttente") {
                $idvalidhisto = new Application_Model_DbTable_Validationsxdistrib();
                $lastidvalid = $idvalidhisto->getValidation($formData['nom_validation'], $formData['tracking']);
                $newhistocomm = new Application_Model_DbTable_HistoriqueCommentaire();
                $newhisto = $newhistocomm->createHistorique($formData['tracking'], $lastidvalid[0]['id_validation'], $info_user['id_user']);
                $lastidhisto = new Application_Model_DbTable_HistoriqueCommentaire();
                $lasthisto = $lastidhisto->getHistorique($formData['tracking'], $lastidvalid[0]['id_validation']);

                $params3 = array();
                $params3['destinataireMail'] = $info_user['email_user'];
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}/histo/{$lasthisto[0]['id_histo_commentaire']}";
                if (!is_null($commentId)) {
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}";
                }

                $params3['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XDistrib $tracking/$numwp pour le client {$client_info['nom_client']} est en attente d'une réponse de votre part.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "XDistrib.";
                $params3['sujet'] = " XDistrib:demande XDistrib $tracking/$numwp pour le client {$client_info['nom_client']} en attente de réponse.";
                $this->sendEmail($params1);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande est en attente de réponse du commercial.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
            }
         }
    }
    public function validatedrvAction(){
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->cdr = $tiltop;
        $this->view->tiltop=$tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $dateinit=$info_demande_xdistrib['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop=$dateplop;
        $numwp_dis=  substr($info_demande_xdistrib['numwp_distributeur'], 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp_dis);
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib['id_user']);
        $nom_holon=new Application_Model_DbTable_Holons();
        $holon_nom=$nom_holon->getHolon($user_info['id_holon']);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib['numwp_client']);
        $info_article=new Application_Model_DbTable_DemandeArticlexdistrib();
        $article_info= $info_article->getDemandeArticlexdistrib($numwp);
        $info_concurrent=new Application_Model_DbTable_PrixConcurrent();
        $concurrent_info=$info_concurrent->getConcurrent($numwp);
        $info_contexte = new Application_Model_DbTable_Xdistrib();
        $contexte_info1= $info_contexte->getContext($numwp);
        $contexte_info2=$contexte_info1[0];
        $contexte_info=$contexte_info2;
        $info_service = new Application_Model_DbTable_ServiceDistrib();
        $service_info = $info_service->getService($numwp);
        $this->view->service_info=$service_info;
        $this->view->contexte_info = $contexte_info;
        $this->view->concurrent_info=$concurrent_info;
        $this->view->article_info=$article_info;
        $this->view->nom_holon=$holon_nom;
        $this->view->client_info=$client_info;
        $this->view->user_info=$user_info;
        $this->view->distrib_info=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        /*
         * on recherche si la validation existe déjà ou si elle est en attente;
         */
        $nomvalidationrecherche = "cdr";
        $tracking = $info_demande_xdistrib['tracking_number_demande_xdistrib'];
        $recherchevalidation = new Application_Model_DbTable_Validationsxdistrib();
        $recherchesvalidation = $recherchevalidation->getValidation($nomvalidationrecherche, $tracking);
        
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXdistrib = new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationsDemandesXdistribs = $dbtValidationsDemandesXdistrib->getAllValidation($info_demande_xdistrib['id_demande_xdistrib']);

        $this->view->validations = $validationsDemandesXdistribs;
        $usersValidations = array();

        foreach (@$validationsDemandesXdistribs as $key => $validationDemandeXdistrib) {
            $userValidationInfos = $info_user->getFonctionLabel($validationDemandeXdistrib['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['description_fonction'];
        }
        $this->view->usersValidations = $usersValidations;
        $blocages=new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationdbd="dbd";
        $blocage = $blocages->getValidation( $validationdbd, $info_demande_xdistrib['id_demande_xdistrib']);
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
            $redirector->gotoSimple('index', 'xdistrib');}
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
//echo '<pre>',  var_export($formData),'</pre>';
            $nouvelle_validation = new Application_Model_DbTable_Validationsxdistrib();
            $nouv_validation = $nouvelle_validation->createValidation($formData['nom_validation'], $formData['date_validation'], $formData['validation'], $formData['commentaire_cdr'], $formData['tiltop'], $formData['tracking']);
            $valid_id_valid = new Application_Model_DbTable_Validationsxdistrib();
            $valid_id_valids = $valid_id_valid->getValidation($formData['nom_validation'], $formData['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $formData['validation'],
                'commentaire' => $formData['commentaire_cdr'],
                'tiltop' => $formData['tiltop'], 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
            );
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
             $emailVars = Zend_Registry::get('emailVars');
            if (isset($formData['validation']) && $formData['validation'] == "validee"){
                $emailVars = Zend_Registry::get('emailVars');
                $params1=array();
                $destinataireMail1=$emailVars->listes->fobfr;
                if (!is_null($firstComment)) {
                    $url1 = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatefobfr/numwp/{$numwp}/com/{$firstComment}";
                } else {
                    $url1 = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatefobfr/numwp/{$numwp}";
                }
                $corpsMail1 = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XDistrib ( {$tracking}/{$numwp}) à valider.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "XDistrib";
                $mail1 = new Xsuite_Mail();
                $mail1->setSubject("XDistrib : Nouvelle Offre XDistrib {$tracking}/{$numwp} à valider de {$user_info['nom_user']} pour {$client_info['nom_client']}")
                        ->setBodyText(sprintf($corpsMail1, $url1))
                        ->addTo($destinataireMail1)
                        ->send();
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande a été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');    
            }
            elseif(isset($formData['validation']) && $formData['validation'] == "nonValide") {
                $params2 = array();
                $params2['destinataireMail'] = $info_user['email_user'] ;
                $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params2['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XDistrib $tracking/$numwp a été refusée pour le client {$client_info['nom_client']} par le dd.\n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "XDistrib.";
                $params2['sujet'] = " XDistrib :demande $tracking/$numwp refusée par votre chef de région.";
                $this->sendEmail($params2);

                $message = "la demande a été refusée.";
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
            }
            elseif (isset($formData['validation']) && $formData['validation'] == "enAttente") {
                $idvalidhisto = new Application_Model_DbTable_Validationsxdistrib();
                $lastidvalid = $idvalidhisto->getValidation($formData['nom_validation'], $formData['tracking']);
                $newhistocomm = new Application_Model_DbTable_HistoriqueCommentaire();
                $newhisto = $newhistocomm->createHistorique($formData['tracking'], $lastidvalid[0]['id_validation'], $info_user['id_user']);
                $lastidhisto = new Application_Model_DbTable_HistoriqueCommentaire();
                $lasthisto = $lastidhisto->getHistorique($formData['tracking'], $lastidvalid[0]['id_validation']);

                $params3 = array();
                $params3['destinataireMail'] = $info_user['email_user'];
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xprice/update/numwp/{$numwp}/histo/{$lasthisto[0]['id_histo_commentaire']}";
                if (!is_null($commentId)) {
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}";
                }

                $params3['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande XDistrib $tracking/$numwp pour le client {$client_info['nom_client']} est en attente d'une réponse de votre part.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "XDistrib.";
                $params3['sujet'] = " XDistrib:demande XDistrib $tracking/$numwp pour le client {$client_info['nom_client']} en attente de réponse.";
                $this->sendEmail($params1);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande est en attente de réponse du commercial.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
            }
         }
    }
    public function consultchefmarcheAction(){
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->cm = $tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $dateinit=$info_demande_xdistrib['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop=$dateplop;
        $numwp_dis=  substr($info_demande_xdistrib['numwp_distributeur'], 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp_dis);
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib['id_user']);
        $nom_holon=new Application_Model_DbTable_Holons();
        $holon_nom=$nom_holon->getHolon($user_info['id_holon']);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib['numwp_client']);
        $info_article=new Application_Model_DbTable_DemandeArticlexdistrib();
        $article_info= $info_article->getDemandeArticlexdistrib($numwp);
        $info_concurrent=new Application_Model_DbTable_PrixConcurrent();
        $concurrent_info=$info_concurrent->getConcurrent($numwp);
        $info_contexte = new Application_Model_DbTable_Xdistrib();
        $contexte_info1= $info_contexte->getContext($numwp);
        $contexte_info2=$contexte_info1[0];
        $contexte_info=$contexte_info2;
        $info_service = new Application_Model_DbTable_ServiceDistrib();
        $service_info = $info_service->getService($numwp);
        $this->view->service_info=$service_info;
        $this->view->contexte_info = $contexte_info;
        $this->view->concurrent_info=$concurrent_info;
        $this->view->article_info=$article_info;
        $this->view->nom_holon=$holon_nom;
        $this->view->client_info=$client_info;
        $this->view->user_info=$user_info;
        $this->view->distrib_info=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        
        
        $dbtValidationsDemandesXdistribs = new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationsDemandesXdistrib = $dbtValidationsDemandesXdistribs->getAllValidation($info_demande_xdistrib['id_demande_xdistrib']);
        
        $plopatt=count($validationsDemandesXdistrib)-1;
        
        $etat_en_cours=$validationsDemandesXdistrib[$plopatt]['etat_validation'];
        $this->view->etat_en_cours=$etat_en_cours;
        
        $this->view->validations = $validationsDemandesXdistrib;
        $usersValidations = array();

        foreach (@$validationsDemandesXdistrib as $key => $validationDemandeXdistrib) {
            $userValidationInfos = $info_user->getFonctionLabel($validationDemandeXdistrib['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['description_fonction'];
        }
        $this->view->usersValidations = $usersValidations;
        if ($this->getRequest()->isPost()) {
            
            $date_validation = date("Y-m-d H:i:s");
            $this->view->date_validation = $date_validation;
            $nom_validation = "comcm";
            $formData = $this->getRequest()->getPost();

            $nouvelle_validation = new Application_Model_DbTable_Validationsxdistrib();
            $nouv_validation = $nouvelle_validation->createValidation($formData['nom_validation'], $formData['date_validation'], $etat_en_cours, $formData['commentaire_chefmarche'], $user->id_user, $formData['tracking']);
            $valid_id_valid = new Application_Model_DbTable_Validationsxdistrib();
            $valid_id_valids = $valid_id_valid->getValidation($formData['nom_validation'], $formData['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $etat_en_cours,
                'commentaire' => $formData['commentaire_chefmarche'],
                'tiltop' => $user->id_user, 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
            );
           
            $commentId = $this->genererValidation($datasValidation);
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "votre commentaire a bien été enregistré.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xprice');
        }
    }
    public function validatefobfrAction(){
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->fobfr = $tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $dateinit=$info_demande_xdistrib['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop=$dateplop;
        $numwp_dis=  substr($info_demande_xdistrib['numwp_distributeur'], 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp_dis);
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib['id_user']);
        $nom_holon=new Application_Model_DbTable_Holons();
        $holon_nom=$nom_holon->getHolon($user_info['id_holon']);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib['numwp_client']);
        $info_article=new Application_Model_DbTable_DemandeArticlexdistrib();
        $article_info= $info_article->getDemandeArticlexdistrib($numwp);
        $info_concurrent=new Application_Model_DbTable_PrixConcurrent();
        $concurrent_info=$info_concurrent->getConcurrent($numwp);
        $info_contexte = new Application_Model_DbTable_Xdistrib();
        $contexte_info1= $info_contexte->getContext($numwp);
        $contexte_info2=$contexte_info1[0];
        $contexte_info=$contexte_info2;
        $info_service = new Application_Model_DbTable_ServiceDistrib();
        $service_info = $info_service->getService($numwp);
        $this->view->service_info=$service_info;
        $this->view->contexte_info = $contexte_info;
        $this->view->concurrent_info=$concurrent_info;
        $this->view->article_info=$article_info;
        $this->view->nom_holon=$holon_nom;
        $this->view->client_info=$client_info;
        $this->view->user_info=$user_info;
        $this->view->distrib_info=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        $blocages=new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationdbd="dbd";
        $blocage = $blocages->getValidation( $validationdbd, $info_demande_xdistrib['id_demande_xdistrib']);
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
                $redirector->gotoSimple('index', 'xdistrib');}
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
            echo  '<pre>',var_export($datas),'</pre>';
            $nomclients=trim($client_info['nom_client']);
//            foreach ($formData as $datas) {
            $fobs = array_combine($datas['code_article'], $datas['prix_fob']);
            $cifs = array_combine($datas['code_article'], $datas['prix_cif']);
            $marges = array_combine($datas['code_article'],$datas['marge']);

            foreach ($cifs as $key => $value) {
                $prixcifs = new Application_Model_DbTable_DemandeArticlexdistrib();
                $prixcif = $prixcifs->updatecif($value, $key, $datas['tracking']);
            }
            foreach ($fobs as $key => $value) {
                $prixfobs = new Application_Model_DbTable_DemandeArticlexdistrib();
                $prixfob = $prixcifs->updatefob($value, $key, $datas['tracking']);
            }
            foreach ($marges as $key => $value){
                $margeinit = new Application_Model_DbTable_DemandeArticlexdistrib();
                $marge= $margeinit->insertMarge($value, $key, $datas['tracking']);
            }
            $validations = new Application_Model_DbTable_Validationsxdistrib();
            $validation = $validations->createValidation($datas['nom_validation'], $datas['date_validation'], $datas['validation'], $datas['commentaire_fobfr'], $datas['fobfr'], $datas['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validationfobfr, 'validation' => $etat,
                'commentaire' => $formData['commentaire_fobfr'],
                'id_user' => $user->id_user, 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
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
                $url = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatesupply/numwp/{$numwp}/com/{$commentId}";
            } else {
                $url = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatesupply/numwp/{$numwp}";
            }
            $corpsMail = "Bonjour,\n"
                    . "\n"
                    . "Vous avez une nouvelle demande Xdistrib $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Prix fobfr.";
            $mail = new Xsuite_Mail();
            $mail->setSubject(" XPrice : Nouvelle demand Xdistrib $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider .")
                    ->setBodyText(sprintf($corpsMail, $url))
                    ->addTo($Mailsupply)
                    ->send();
            $corpsMail2 = "Bonjour,\n"
                    . "\n"
                    . "Vous avez une nouvelle demande Xdistrib $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Prix fobfr.";
            $mail2 = new Xsuite_Mail();
            $mail2->setSubject(" XPrice : Nouvelle demand Xdistrib $trackingNumber/$numwp de {$info_user['nom_user']} pour le client $nomclients à valider .")
                    ->setBodyText(sprintf($corpsMail2, $url))
                    ->addTo($Mailfobfr)
                    ->send();
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "les prix fob et cif  ont bien été enregistrés.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xdistrib');
        } else {

        }
    }
}

