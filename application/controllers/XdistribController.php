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
        
        $comId = $this->getRequest()->getParam('com', null);
        if (!is_null($comId)) {
            $comId = intval($comId);
            $dbtValidation = new Application_Model_DbTable_Validationsdemandexdistrib();
            if ($dbtValidation->checkId($comId) == true) {
                $this->view->commentId = $comId;
            } else {
                $this->view->commentId = null;
            }
        } else {
            $this->view->commentId = null;
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
     $fonction=$user->id_fonction;
//     echo $fonction;
     $this->view->createur=$user->id_user;
     $this->view->fonction=$fonction;
     if($user->id_fonction == 35){
         $distrib=array("I02055","I01045");
         $recapitulatif1=new Application_Model_DbTable_Xdistrib();
         $plop1=$recapitulatif1->rechercheridRCDN($distrib);
   //      echo '<pre>',var_export($plop1),'</pre>';
//         foreach($plop1 as $value){
//            $popi[]= $value['id_demande_xdistrib'];
//         }
         foreach($plop1 as $value1){
             $recapitulatif2[] = $recapitulatif1->essaiTest($value1['id_demande_xdistrib']);
         }//echo '<pre>',var_export($recapitulatif2),'</pre>';
     }
     if($user->id_fonction == 36){
         $distrib=array("I01990");
         $recapitulatif1=new Application_Model_DbTable_Xdistrib();
         $plop1=$recapitulatif1->rechercheridRCDN($distrib);
         foreach($plop1 as $value){
             $recapitulatif2[] =$recapitulatif1->essaiTest($value['id_demande_xdistrib']);
         }
     }
     if($user->id_fonction == 37){
         $distrib=array("I00789","I00264","I00662","I00412","I01796","I01800","I03174","I03383","I01803","I04736","I03697","I04732","I01799","I04957","I03517","I05061","I01808","I02688","I04956","I05065"
);
         $recapitulatif1=new Application_Model_DbTable_Xdistrib();
         $plop1=$recapitulatif1->rechercheridRCDN($distrib);
        // echo '<pre>',var_export($plop1),'</pre>';
//         foreach($plop1 as $value){
//            $popi[]= $value['id_demande_xdistrib'];
//         }
         foreach($plop1 as $value1){
             $recapitulatif2[] = $recapitulatif1->essaiTest($value1['id_demande_xdistrib']);
         }//echo '<pre>',var_export($recapitulatif2),'</pre>';
     }
     if($user->id_fonction == 34){
          $distrib=array("I03624","I05285","I03317","I02557","I00415","I00678","I04380","I03214","I02886","I03621","I02929","I02932","I03912","I05223","I02920"
);
         $recapitulatif1=new Application_Model_DbTable_Xdistrib();
         $plop1=$recapitulatif1->rechercheridRCDN($distrib);
        // echo '<pre>',var_export($plop1),'</pre>';
//         foreach($plop1 as $value){
//            $popi[]= $value['id_demande_xdistrib'];
//         }
         foreach($plop1 as $value1){
             $recapitulatif2[] = $recapitulatif1->rechercheDBD($value1['id_demande_xdistrib']);
         }//echo '<pre>',var_export($recapitulatif2),'</pre>';
     }
     if ($user->id_fonction == 1 || $user->id_fonction==2){
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib();
         $recapitulatif2 = $recapitulatif1->searchByUser($user->id_user);
        // echo '<pre>',var_export($recapitulatif2),'</pre>';
         $r = array();
     for ($index = 0; $index < count($recapitulatif2); $index++) {
         if(($index +1) > count($recapitulatif2)-1) {
             $r[] = $recapitulatif2[$index];
         } else {
             if($recapitulatif2[$index]['num_workplace_demande_xdistrib'] != $recapitulatif2[$index+1]['num_workplace_demande_xdistrib']) {
                 $r[] = $recapitulatif2[$index];
             }
         }
     }
     unset($recapitulatif2);
     $recapitulatif2[] = $r;
         $this->view->recapitulatif = $recapitulatif2;        
     }
     if($user->id_fonction == 6){
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib();
         $recapitulatifbistek = $recapitulatif1->searchforDD($user->id_user);
          foreach ($recapitulatifbistek as $value){
            
                $popi[]=$value['id_demande_xdistrib'];
            }
            $popi1=array_unique($popi);
           // echo '<pre>',var_export($popi1) ,'</pre>';
            foreach($popi1 as $value){
                $recapitulatif3[]= $recapitulatif1->essaiTest($value);
            }
            $recapitulatif2=$recapitulatif3; 
     }
   
     if($user->id_fonction == 10){
     switch ($holon){
         case 2:
             $tracking1='/SPD-FR-QC/';
             $tracking2='/SPD-FR-QF/';
             break;
         case 3:
             $tracking1='/SPD-FR-QE/';
             $tracking2='/SPD-FR-QH/';            
             break;
         case 4:
            $tracking1='/SPD-FR-QI/';
            $tracking2='/SPD-FR-QK/';            
             break;
         }
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib();
//          $demandes=new Application_Model_DbTable_Xdistrib();
//         $demande= $demandes->tout();
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib;
         $plop1=$recapitulatif1->rechercheridDBD();
        foreach($plop1 as $value){
            
         $recapitulatif2bis=$recapitulatif1->rechercheDBD($value['id_demande_xdistrib']);
         $r[]=$recapitulatif2bis;
         }
        
         foreach($r as $tagada){foreach($tagada as $value){
             if(preg_match($tracking1,$value['tracking_number_demande_xdistrib'])==1 || preg_match($tracking2,$value['tracking_number_demande_xdistrib'] )==1 ) {
                 $plopr[] =$value; 
             }
         }}
         $recapitulatif2[] = $plopr;
     }
      if($user->id_fonction ==5|| $user->id_fonction == 13 || $user->id_fonction == 29 || $user->id_fonction == 23 || $user->id_fonction == 32){
         $recapitulatif1 = new Application_Model_DbTable_Xdistrib;
         $plop1=$recapitulatif1->rechercheridDBD();
            //echo '<pre>',var_export($plop1) ,'</pre>';
         //$plop1=array_unique($plopi);
         foreach($plop1 as $value){
             $recapitulatif2[] =$recapitulatif1->rechercheDBD($value['id_demande_xdistrib']);
         }
     } // echo '<pre>',var_export($recapitulatif2) ,'</pre>';
    $this->view->recapitulatif = $recapitulatif2;
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
//       echo '<pre>',var_export($formData),'</pre>';
//        echo '<pre>',var_export($result),'</pre>';
//        echo '<pre>',var_export($result2),'</pre>';
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
//var_dump($excellContent[4][8]);exit();
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
//      echo '<pre>', var_export($rowsbis),'</pre>';

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
             $tempDistrib=$tempDistribs->createdistrib(trim($numwp), trim($numwp_distributeur5), $id_industry, $numwp_distributeur10, $potentiel_distributeur, $adresse);

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
//            echo '<pre>',  var_export($infos_offres->OBDLSP),'</pre>';
            $id_industry_client_final =$info_industry_client_final['id_industry'];
            $nom_industry=$info_industry_client_final['description_industry'];
          
            $clientTemps= new Application_Model_DbTable_TempClient();
            $clientTemp= $clientTemps->createTemp(trim($numwp),$infos_offres->OBDLSP,$code_postal_client_final,$ville_client_final,$nom_industry,$id_industry,$nom_client_final);
            
            $clientDEF= new Application_Model_DbTable_ClientDistrib();
            $clientDefs= $clientDEF->createClientDistrib(trim($numwp),$infos_offres->OBDLSP,$code_postal_client_final,$ville_client_final,$nom_industry,$id_industry,$nom_client_final,null);
//        exit();
            /*fin de l'insertion des données movex dans les tables temporaires */
            /* debut de requettage  pour affichage des informations  dans le phtml*/
            /*requete info_ vendeur, info_distrib,info_client*/ 
            /*recuperation des donnees concernant le createur de l'offre*/
            $user_infos = new Application_Model_DbTable_TempMovexOffre();
           
            $user_info = $user_infos->getMovexUser($numwp);
            
            $this->view->user_info = $user_info[0];
            if(is_null($user_info[0]['id_user']))
                {
               $polop= $this->_auth->getStorage()->read();
                $user_info[0]['id_user']= $polop->id_user;  
                };
            $nom_zone = $user_info[0]['nom_zone'];
           // echo '<pre>',var_export($user_info),'</pre>';
            $distrib_infos = new Application_Model_DbTable_TempFichierDistribInfo();
            $distrib_info=$distrib_infos->getDistrib($numwp);
            $this->view->distrib_info = $distrib_info[0];
           // echo '<pre>',var_export($distrib_info),'</pre>';            
            /*fin de requettage pour l'affichage des infos dans le phtml*/
            $client_infos= new Application_Model_DbTable_TempMovexOffre();
            $distribnumwps= new Application_Model_DbTable_TempMovexDistrib();
            $distribnum=$distribnumwps->getnumdis($numwp);
          //echo '<pre>',var_export($distribnum),'</pre>';
            $client_info=$client_infos->getClientFinal($numwp);
            $this->view->client_info=$client_info[0];
            $article_infos = new Application_Model_DbTable_TempMovexDemande();
            $article_info= $article_infos->demande($numwp);
            //var_dump($numwp);
//            echo '<pre>',  var_export($article_info),'</pre>'; exit();
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
        $userCreat = $this->_auth->getStorage()->read();
        $Defxdistribs= new Application_Model_DbTable_Xdistrib();
        $defxdistrib = $Defxdistribs->createXDistrib($numwp, $trackingNumber,$context_info[0]['contexte_demande'],$date,$context_info[0]['services_associes'],$user_info[0]['id_user'],$userCreat->id_user,null,$infos_offres->OBDLSP,$numwp_distributeur5);
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
                    $art['prix_achat_demande_distrib'],
                    round(100 - ( $art['prix_achat_demande_distrib'] * 100 / $art['prix_tarif']), 2),
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
       $defDistributeur=$defDistributeurs->createDistributeur($distrib_info[0]['distrib'], $distrib_info[0]['nom_contact_distrib'],$distribnum[0]['numwp_distributeur'],$distrib_info[0]['ville_distrib'],$distrib_info[0]['codepostal_distrib'], $id_industry,$potentiel_distributeur,$distrib_info[0]['numwp']);
       

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
        if($user_connect->id_fonction == "6" || $user_connect->id_fonction == "34" || $user_connect->id_fonction == "35" || $user_connect->id_fonction == "36" || $user_connect->id_fonction == "37" ){
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
                $params1['destinataireMail']=$mail_dd;
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
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xdistrib');
        }
    }
    public function readerAction(){}
    public function consultAction()
    {
        $numwp = $this->getRequest()->getParam('numwp', null);
        $user = $this->_auth->getStorage()->read();
        $this->view->utilisateur=$user->id_fonction;
        $tiltop = $user->id_user;
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
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
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
        //echo'<pre>',  var_export($validationsDemandesXdistribs),'</pre>';
        $usersValidations = array();

        foreach (@$validationsDemandesXdistrib as $key => $validationDemandeXdistri) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXdistri['id_user']);
            $usersValidations[$key]['fonction'] =$userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        $this->view->fermeturevalide=$plop1['etat_validation'];
        $this->view->dateplop=$dateplop;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        $encours = new Application_Model_DbTable_Validationsdemandexdistrib();
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
        $encoursFonction=$user_info['nom_user'].' '. $user_info['prenom_user'];
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
        $tracking = $this->getRequest()->getParam('tracking', null);
        $this->view->tracking = $tracking;
        $user = $this->_auth->getStorage()->read();
         $this->view->utilisateur=$user->id_fonction;
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->searchAll($tracking);
        $numwp=$info_demande_xdistrib->num_workplace_demande_xdistrib;
        $this->view->numwp=$numwp;
        $dateinit=$info_demande_xdistrib->date_demande_xdistrib;
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $ferme = new Application_Model_DbTable_Validationsdemandexdistrib();
        $fermeture = $ferme->searchFermeture($numwp);
        foreach($fermeture as $ferm){
            $plop1 = $ferm;
        }
        $numwp_dis=  substr($info_demande_xdistrib->numwp_distributeur, 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib->id_user);
        $nom_holon=new Application_Model_DbTable_Holons();
        $holon_nom=$nom_holon->getHolon($user_info['id_holon']);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib->numwp_client);
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
        $tracking = $info_demande_xdistrib->tracking_number_demande_xdistrib;
        $recherchevalidation = new Application_Model_DbTable_Validationsxdistrib();
        $recherchesvalidation = $recherchevalidation->getValidation($nomvalidationrecherche, $tracking);
        $infos_user = new Application_Model_DbTable_Users();
        /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXdistrib = new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationsDemandesXdistrib = $dbtValidationsDemandesXdistrib->getAllValidation($info_demande_xdistrib->id_demande_xdistrib);

        $this->view->validations = $validationsDemandesXdistrib;
        //echo'<pre>',  var_export($validationsDemandesXdistribs),'</pre>';
        $usersValidations = array();

        foreach (@$validationsDemandesXdistrib as $key => $validationDemandeXdistri) {
            $userValidationInfos = $infos_user->getFonctionLabel($validationDemandeXdistri['id_user']);
            $usersValidations[$key]['fonction'] =$userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        $this->view->fermeturevalide=$plop1['etat_validation'];
        $this->view->dateplop=$dateplop;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        $encours = new Application_Model_DbTable_Validationsdemandexdistrib();
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
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
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
        $encours = new Application_Model_DbTable_Validationsdemandexdistrib();
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
                        $destinataireMail2 = $emailVars->listes->carIndustries1;
                    }elseif(in_array($destIndustry, $car2)){
                        $destinataireMail2 = $emailVars->listes->carIndustries;
                    }elseif(in_array($destIndustry, $LS)){
                        $destinataireMail2 = $emailVars->listes->LifeandScience;
                    }elseif(in_array($destIndustry, $Elec)){
                       $destinataireMail2 = $emailVars->listes->Electronique;
                    }elseif(in_array($destIndustry, $food)){
                       $destinataireMail2 = $emailVars->listes->foodIndustries;
                    }elseif(in_array($destIndustry, $food1)){
                       $destinataireMail2 = $emailVars->listes->foodIndustries1;
                    }elseif(in_array($destIndustry,$EE)){
                        $destinataireMail2 = $emailVars->listes->environnementEnergie;
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
                $params['destinataireMail'] = $destinataireMail2;
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
                $redirector->gotoSimple('index', 'xdistrib');
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
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/histo/{$lasthisto[0]['id_histo_commentaire']}";
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
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
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
        $encours = new Application_Model_DbTable_Validationsdemandexdistrib();
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
                $params2['destinataireMail'] = $user_info['email_user'] ;
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
                $redirector->gotoSimple('index', 'xdistrib');
            }
            elseif (isset($formData['validation']) && $formData['validation'] == "enAttente") {
                $idvalidhisto = new Application_Model_DbTable_Validationsxdistrib();
                $lastidvalid = $idvalidhisto->getValidation($formData['nom_validation'], $formData['tracking']);
                $newhistocomm = new Application_Model_DbTable_HistoriqueCommentaire();
                $newhisto = $newhistocomm->createHistorique($formData['tracking'], $lastidvalid[0]['id_validation'], $user->id_user);
                $lastidhisto = new Application_Model_DbTable_HistoriqueCommentaire();
                $lasthisto = $lastidhisto->getHistorique($formData['tracking'], $lastidvalid[0]['id_validation']);

                $params3 = array();
                $params3['destinataireMail'] = $user_info['email_user'];
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/histo/{$lasthisto[0]['id_histo_commentaire']}";
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
                $this->sendEmail($params3);

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
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
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
        $encours = new Application_Model_DbTable_Validationsdemandexdistrib();
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
                $redirector->gotoSimple('index', 'xdistrib');
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
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
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
            $this->view->etat=$etat;
            $nom_validationfobfr = "fobfr";
            $formData = $this->getRequest()->getPost();
            $datas = $this->getRequest()->getPost();
//            echo  '<pre>',var_export($datas),'</pre>';
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
            $validation = $validations->createValidation($datas['nom_validation'], $datas['date_validation'], $etat, $datas['commentaire_fobfr'], $datas['fobfr'], $datas['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validationfobfr, 'validation' => $etat,
                'commentaire' => $formData['commentaire_fobfr'],
                'tiltop' => $datas['fobfr'], 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
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
                    . "Vous avez une nouvelle demande Xdistrib {$datas['tracking']}/$numwp de {$user_info['nom_user']} pour le client{$client_info['nom_client']} à valider.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Prix fobfr.";
            $mail = new Xsuite_Mail();
            $mail->setSubject(" Xdistrib : Nouvelle demand Xdistrib {$datas['tracking']}/$numwp de {$user_info['nom_user']} pour le client {$client_info['nom_client']} à valider .")
                    ->setBodyText(sprintf($corpsMail, $url))
                    ->addTo($Mailsupply)
                    ->send();
            $corpsMail2 = "Bonjour,\n"
                    . "\n"
                    . "Vous avez une nouvelle demande Xdistrib {$datas['tracking']}/$numwp de {$user_info['nom_user']} pour le client{$client_info['nom_client']} à valider.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Prix fobfr.";
            $mail2 = new Xsuite_Mail();
            $mail2->setSubject(" Xdistrib : Nouvelle demand Xdistrib {$datas['tracking']}/$numwp de {$user_info['nom_user']} pour le client {$client_info['nom_client']} à valider .")
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
    public function validatesupplyAction(){
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->supply = $tiltop;
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
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
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
            $date_validationsupply = date("Y-m-d H:i:s");
            $this->view->date_validationsupply = $date_validationsupply;
            $etat = "validée";
            $nom_validationsupply = "supply";
            $formData = $this->getRequest()->getPost();
            $datas = $this->getRequest()->getPost();
            $nomclients=trim($client_info['nom_client']);
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
            $validation = $validations->createValidation($datas['nom_validation'], $datas['date_validation'], $etat, $datas['commentaire_supply'], $datas['supply'], $datas['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validationsupply, 'validation' => $etat,
                'commentaire' => $formData['commentaire_supply'],
                'tiltop' => $datas['supply'], 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
            );
            if (array_key_exists('reponse', $formData)) {
                $datasValidation['reponse'] = $formData['reponse'];
            }

            $commentId = $this->genererValidation($datasValidation);
            $emailVars = Zend_Registry::get('emailVars');
            $destinatairemail =$emailVars->listes->DBD;
                if (!is_null($commentId)) {
                    $url = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedbd/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $url = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedbd/numwp/{$numwp}";
                }
                $corpsMail = "Bonjour,\n"
                        . "\n"
                        . "Vous avez une nouvelle demande XDistrib {$datas['tracking']}/$numwp de  {$user_info['nom_user']} pour le client $nomclients à valider.\n"
                        . "Veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Supply Chain Manager.";
            $emailVars = Zend_Registry::get('emailVars');
            $mail = new Xsuite_Mail();
            $mail->setSubject(" Xdistrib: Nouvelle demande Xdistrib {$datas['tracking']}/$numwp de {$user_info['nom_user']} pour le client $nomclients à valider.")
                    ->setBodyText(sprintf($corpsMail, $url))
                    ->addTo($destinatairemail)
                    ->send();
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "les prix fob et cif  sont bien validés.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xdistrib');
        }
    }
    public function validatedbdAction(){
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->dbd = $tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        $nom_validation = 'dbd';
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $dateinit=$info_demande_xdistrib['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop=$dateplop;
        $numwp_dis=  substr($info_demande_xdistrib['numwp_distributeur'], 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
        //var_dump(trim($distrib_info['numwp_distributeur'])); exit();
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib['id_user']);
        $dd_info=$info_user->getUser($info_demande_xdistrib['id_dd']);
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
        $nomclients=$client_info['nom_client'];
        $fonctioncreateur = $user_info['id_fonction'];
        $info_service = new Application_Model_DbTable_ServiceDistrib();
        $service_info = $info_service->getService($numwp);
        $developpeurdistribs=new Application_Model_DbTable_Users;
        $developpeurdistrib=$developpeurdistribs->getUser($info_demande_xdistrib['id_dd']);
        $maildevdistrib=$developpeurdistrib['email_user'];
        $this->view->service_info=$service_info;
        $this->view->contexte_info = $contexte_info;
        $this->view->concurrent_info=$concurrent_info;
        $this->view->article_info=$article_info;
        $this->view->nom_holon=$holon_nom;
        $this->view->client_info=$client_info;
        $this->view->user_info=$user_info;
        $this->view->distrib_info=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        $this->nom_validation = $nom_validation;
        //echo '<pre>',  var_export($article_info),'</pre>';
        $blocages=new Application_Model_DbTable_Validationsdemandexdistrib();
        $blocage = $blocages->getValidation($nom_validation, $info_demande_xdistrib['id_demande_xdistrib']);
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
         /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXdistrib = new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationsDemandesXdistrib = $dbtValidationsDemandesXdistrib->getAllValidation($info_demande_xdistrib['id_demande_xdistrib']);

        $this->view->validations = $validationsDemandesXdistrib;
        $usersValidations = array();

        foreach (@$validationsDemandesXdistrib as $key => $validationDemandeXdistrib) {
            $userValidationInfos = $info_user->getFonctionLabel($validationDemandeXdistrib['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        /*essai valid en cours*/
        $encours = new Application_Model_DbTable_Validationsdemandexdistrib();
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
        $encoursFonction=$user_info['nom_user'].' '. $user_info['prenom_user'];
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
        if ($this->getRequest()->isPost()) {
            $date_validation = date("Y-m-d H:i:s");
            $this->view->date_validation = $date_validation;
            $nom_validation = 'dbd';
            $this->nom_validation = $nom_validation;
            $datas = $this->getRequest()->getPost();
            $tracking=$datas['tracking'];
//            echo '<pre>',  var_export($datas),'</pre>'; 
            $emailVars = Zend_Registry::get('emailVars');
            $prix_accordes = array_combine($datas['code_article'], $datas['prix_accorde_article']);
            $remise_accordes = array_combine($datas['code_article'], $datas['remise_accorde_article']);
            $marge = array_combine($datas['code_article'],$datas['marge']); 
            foreach ($remise_accordes as $key => $value) {
                $remisesDirco = new Application_Model_DbTable_DemandeArticlexdistrib();
                $remiseDirco = $remisesDirco->insertRemiseAccorde($value, $key, $datas['tracking']);
            }
            foreach ($prix_accordes as $key => $value) {
                $prixDirco = new Application_Model_DbTable_DemandeArticlexdistrib();
                $priDirco = $prixDirco->insertPrixAccorde($value, $key, $datas['tracking']);
            }
            foreach($marge as $key=>$value){
                $margeinit=new Application_Model_DbTable_DemandeArticlexdistrib();
                $marges = $margeinit->updateMarge($value,$key,$datas['tracking']);
            }
            $margemin = false;
            foreach ($marge as $key => $value2) {
                $margesmc = substr($value2,0,-1);
                if ($margesmc < 0) {
                    $margemin = true;   
                } 
            }
            $mamo=  substr($datas['mamo'], 0,-1);
            if($margemin==false && $mamo >10 && $datas['validation']=="validee"){
                $datas['validation']="fermee";
            }elseif($margemin==false && $mamo >10 && $datas['validation']=="nonValide"){
                 $datas['validation']="nonValide";
            }
            $validations = new Application_Model_DbTable_Validationsxdistrib();
             $validation = $validations->createValidation($datas['nom_validation'], $datas['date_validation'], $datas['validation'], $datas['commentaire_dbd'], $datas['dbd'], $datas['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $datas['validation'],
                'commentaire' => $datas['commentaire_dbd'],
                'tiltop' => $datas['dbd'], 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
            );
            if (array_key_exists('reponse', $datas)) {
                $datasValidation['reponse'] = $datas['reponse'];
            }
            $commentId = $this->genererValidation($datasValidation);
/*$maildevdistrib="mhuby@smc-france.fr";*/
            $mailSC=/*"mhuby@smc-france.fr";*/"distributeurs@smc-france.fr";
            if (isset($datas['validation']) && $datas['validation'] == "validee") {
                $params1 = array();
                if ($margemin == true or $datas['mamo']< 10){
                    $params1['destinataireMail'] = $emailVars->listes->Dirco;
                    if (!is_null($commentId)) {
                        $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedirco/numwp/{$numwp}";
                    } else {
                        $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validatedirco/numwp/{$numwp}";
                    }

                    $params1['corpsMail'] = "Bonjour,\n"
                            . "\n"
                            . "Vous avez une nouvelle demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients à valider .\n"
                            . "Vous pouvez la valider à cette adresse url : \n"
                            . "%s"
                            . "\n\n"
                            . "Cordialement,\n"
                            . "\n"
                            . "--\n"
                            . "dbd.";
                    $params1['sujet'] = "  Xdistrib :nouvelle demande Xdistrib $tracking/$numwp à valider $numwp de {$user_info['nom_user']} pour le client $nomclients .";

                    $this->sendEmail($params1);
                }
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp  pour le client $nomclients a bien été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
            }
            elseif(isset($datas['validation']) && $datas['validation'] == "fermee"){
                     /*envoi de mail au tc, au cdr, au leader, au cm et au service client.*/
                $params2 = array();
                $params3 = array();
                $params4 = array();
                $params5 = array();
                $params6 = array();
                $params7 = array();
                $params8 = array();
                $params8bis = array();
                $numwp_distributeur=trim($distrib_info['numwp_distributeur']);
                //essai  de creation de fichier csv  + envoi  en piece-jointe pour le distributeur brammer 
                if($numwp_distributeur=='I02055' || $numwp_distributeur=='I01045'){
//                    $essaisdemandes= new Application_Model_DbTable_DemandeArticlexdistrib();
//                    $essaidemandecsv= $essaisdemandes->getDemandeArticlexdistrib($numwp);
//                    $cheminessai ="{$numwp}.'.csv'";
//                    $delimiteur =';';
//                    $fichier=fopen($cheminessai,'w+');
//                    foreach($essaidemandecsv as $dataessai){
//                        
//                    }
                 $mailRCDN= $emailVars->listes->brammer;}
                elseif($numwp_distributeur=='I03624' ||
                        $numwp_distributeur=='I05285' ||
                        $numwp_distributeur=='I03317' ||
                        $numwp_distributeur=='I02557' ||
                        $numwp_distributeur=='I00415' ||
                        $numwp_distributeur=='I00678' ||
                        $numwp_distributeur=='I04380' ||
                        $numwp_distributeur=='I03214' ||
                        $numwp_distributeur=='I02886' ||
                        $numwp_distributeur=='I03621' ||
                        $numwp_distributeur=='I02929' ||
                        $numwp_distributeur=='I02932' ||
                        $numwp_distributeur=='I03912' ||
                        $numwp_distributeur=='I05223' ||
                        $numwp_distributeur=='I02920')
                    {
                     $mailRCDN= $emailVars->listes->mbedexis;
                }elseif( 
                        $numwp_distributeur=='I00264' ||
                        $numwp_distributeur=='I00789' ||
                        $numwp_distributeur=='I00662' ||
                        $numwp_distributeur=='I00412' ||
                        $numwp_distributeur=='I01796' ||
                        $numwp_distributeur=='I01800' ||
                        $numwp_distributeur=='I03174' ||
                        $numwp_distributeur=='I03383' ||
                        $numwp_distributeur=='I01803' ||
                        $numwp_distributeur=='I04736' ||
                        $numwp_distributeur=='I03697' ||
                        $numwp_distributeur=='I04732' ||
                        $numwp_distributeur=='I01799' ||
                        $numwp_distributeur=='I04957' ||
                        $numwp_distributeur=='I03517' ||
                        $numwp_distributeur=='I05061' ||
                        $numwp_distributeur=='I01808' ||
                        $numwp_distributeur=='I02688' ||
                        $numwp_distributeur=='I04956' ||
                        $numwp_distributeur=='I05065' ){
                        $mailRCDN= $emailVars->listes->orexad;
                }
                elseif( $numwp_distributeur=='I01990') {
                         $mailRCDN= $emailVars->listes->rs;
            } else{$mailRCDN=$maildevdistrib;}
                $params8['destinataireMail']=$mailRCDN;
                $params8['url']="http://{$_SERVER['SERVER_NAME']}/xdistrib/avenant/numwp/{$numwp}";
                 $params8['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $trackingNumber/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Veuillez télécharger l'avenant de cette demande à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params8['sujet'] = " Xdistrib :demande Xdistrib  $trackingNumber/$numwp pour le client $nomclients validée par Directeur Commercial/ lien pour Avenant .";
                $this->sendEmail($params8);
                $params1bis['destinataireMail'] =/*"mhuby@smc-france.fr";*/"mrita@smc-france.fr";
                $params1bis['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params1bis['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $trackingNumber/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params1bis['sujet'] = "  Xdistrib :demande Xdistrib $trackingNumber/$numwp pour le client $nomclients validée par Directeur Commercial.";
                $this->sendEmail($params1bis);
                $params7['destinataireMail']=$maildevdistrib;
                $params7['url']="http://{$_SERVER['SERVER_NAME']}/xdistrib/avenant/numwp/{$numwp}";
                $params7['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $trackingNumber/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Veuillez télécharger l'avenant de cette demande à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params7['sujet'] = " Xdistrib :demande Xdistrib  $trackingNumber/$numwp pour le client $nomclients validée par Directeur Commercial/ lien pour Avenant .";
                $this->sendEmail($params7);
                
                    $params2['destinataireMail'] =$user_info['email_user']; 
                    
                    $params3['destinataireMail'] =$mailSC; 
                     if (!is_null($commentId)) {
                    $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}/com/{$commentId}";
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                    } else {
                    $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                    $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                    }
                    $params2['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp a été validée par le Directeur Business Developpement .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                    $params2['sujet'] = " XDistrib :demande Xdistrib $tracking/$numwp pour $nomclients validée par Directeur Business Developpement.";
                    $params3['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients faites par le Deveveloppeur Distributeur {$developpeurdistrib['nom_user']} a été validée par le dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                         ."et envoyer la quotation à {$developpeurdistrib['nom_user']}"       
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params3['sujet'] = "  XDistrib : la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée .";
                
                $this->sendEmail($params2);
                $this->sendEmail($params3);
                //envoi au leader 
                if ($fonctioncreateur=="1") {
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
                        }
                         $params4['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";

                         $params4['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le DBD.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params4['sujet']=" XDistrib :  Offre Xdistrib $tracking/$numwp  de {$user_info['nom_user']} pour $nomclients validée par le DBD";
                      $this->sendEmail($params4);           
                    }
                //envoi au cdr
                $zonetracking = substr($tracking, 7, 2);
                if ($fonctioncreateur=="1" or $fonctioncreateur=="2" or $fonctioncreateur=="3") {
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
                        $params5['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";

                         $params5['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le DBD.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params5['sujet']=" XDistrib :Offre Xdistrib$tracking/$numwp de {$user_info['nom_user']} pour $nomclients validée par le DBD";
                      $this->sendEmail($params5); 
                    }
                     $destIndustry = $client_info['id_industry'];
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
                        $destinataireMail6 = $emailVars->listes->carIndustries1;
                    }elseif(in_array($destIndustry, $car2)){
                        $destinataireMail6 = $emailVars->listes->carIndustries;
                    }elseif(in_array($destIndustry, $LS)){
                        $destinataireMail6 = $emailVars->listes->LifeandScience;
                    }elseif(in_array($destIndustry, $Elec)){
                       $destinataireMail6 = $emailVars->listes->Electronique;
                    }elseif(in_array($destIndustry, $food)){
                       $destinataireMail6 = $emailVars->listes->foodIndustries;
                    }elseif(in_array($destIndustry, $food1)){
                       $destinataireMail6 = $emailVars->listes->foodIndustries1;
                    }elseif(in_array($destIndustry,$EE)){
                        $destinataireMail6 = $emailVars->listes->environnementEnergie;
                    }
                $params6['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params6['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande XDistrib $numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le DBD.\n"
                        . "Pour consulter la demande Xdistrib $tracking/$numwp veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xdistrib";
                $params6['destinataireMail'] = $destinataireMail6;
                $params6['sujet'] = " Xdistrib : La demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le DBD.";
                $this->sendEmail($params6);
                   $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp  pour le client $nomclients a bien été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib'); 
                
                 }
                
            elseif (isset($datas['validation']) && $datas['validation']=='enAttente') {
                $params = array();
                $params1=array();
                $params['destinataireMail'] = $user_info['email_user'];
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp pour le client $nomclients est en attente de réponse à la question posée par dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params['sujet'] = " Xdistrib :demande Xdistrib $tracking/$numwp mise en attente par Directeur Business Developpement.";
                $this->sendEmail($params);
                $params1['destinataireMail'] = $dd_info['email_user'];
                if (!is_null($commentId)) {
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}";
                }
                $params1['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp pour le client $nomclients est en attente de réponse à la question posée par dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params1['sujet'] = " Xdistrib :demande Xdistrib $tracking/$numwp mise en attente par Directeur Business Developpement.";
                $this->sendEmail($params1);
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp est en attente de réponse du commercial.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
            } elseif (isset($datas['validation']) && $datas['validation'] == 'nonValide') {
                $params = array();
                $params1 = array();
                $params['destinataireMail'] =$user_info['email_user'];
                $params1['destinataireMail'] =$maildevdistrib;
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}/com/{$commentId}";
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                    $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp pour le client $nomclients est non validée par dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params1['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp pour le client $nomclients est non validée par dbd .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params['sujet'] = "  Xdistrib :demande Xdistrib $tracking/$numwp pour le client $nomclients non validée par dbd.";
                $params1['sujet'] = "  Xdistrib :demande Xdistrib $tracking/$numwp pour le client $nomclients non validée par dbd.";
                $this->sendEmail($params);
                $this->sendEmail($params1);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp n'a pas été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
            }
        }
    }
    public function validatedircoAction(){
        $user = $this->_auth->getStorage()->read();
        $tiltop = $user->id_user;
        $this->view->dircouser = $tiltop;
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        $nom_validation = 'dirco';
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $dateinit=$info_demande_xdistrib['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $dateinit);
        $dateplop = $date->format('d/m/Y');
        $this->view->dateplop=$dateplop;
        $numwp_dis=  substr($info_demande_xdistrib['numwp_distributeur'], 0, 6);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
        $info_user=new Application_Model_DbTable_Users;
        $user_info=$info_user->getUser($info_demande_xdistrib['id_user']);
        $nom_holon=new Application_Model_DbTable_Holons();
        $holon_nom=$nom_holon->getHolon($user_info['id_holon']);
        $id_holon=$user_info['id_holon'];
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
        $nomclients=$client_info['nom_client'];
        $fonctioncreateur = $user_info['id_fonction'];
        $info_service = new Application_Model_DbTable_ServiceDistrib();
        $service_info = $info_service->getService($numwp);
        $developpeurdistribs=new Application_Model_DbTable_Users;
        $developpeurdistrib=$developpeurdistribs->getUser($info_demande_xdistrib['id_dd']);
        $maildevdistrib=$developpeurdistrib['email_user'];
        $this->view->service_info=$service_info;
        $this->view->contexte_info = $contexte_info;
        $this->view->concurrent_info=$concurrent_info;
        $this->view->article_info=$article_info;
        $this->view->nom_holon=$holon_nom;
        $this->view->client_info=$client_info;
        $destIndustry=$client_info['id_industry'];
        $this->view->user_info=$user_info;
        $this->view->distrib_info=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
        $this->nom_validation = $nom_validation;
        $blocages=new Application_Model_DbTable_Validationsdemandexdistrib();
        $blocage = $blocages->getValidation($nom_validation, $info_demande_xdistrib['id_demande_xdistrib']);
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
         /*
         * chargement des validations avec leurs commentaires
         */
        $dbtValidationsDemandesXdistrib = new Application_Model_DbTable_Validationsdemandexdistrib();
        $validationsDemandesXdistrib = $dbtValidationsDemandesXdistrib->getAllValidation($info_demande_xdistrib['id_demande_xdistrib']);

        $this->view->validations = $validationsDemandesXdistrib;
        $usersValidations = array();

        foreach (@$validationsDemandesXdistrib as $key => $validationDemandeXdistrib) {
            $userValidationInfos = $info_user->getFonctionLabel($validationDemandeXdistrib['id_user']);
            $usersValidations[$key]['fonction'] = $userValidationInfos['prenom_user'].' ' .$userValidationInfos['nom_user'];
        }
        $this->view->usersValidations = $usersValidations;
        /*essai valid en cours*/
        $encours = new Application_Model_DbTable_Validationsdemandexdistrib();
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
        if ($this->getRequest()->isPost()) {
            $date_validation = date("Y-m-d H:i:s");
            $this->view->date_validation = $date_validation;
            $nom_validation = 'dirco';
            $this->nom_validation = $nom_validation;
            $datas = $this->getRequest()->getPost();
           $datas = $this->getRequest()->getPost();
            $tracking=$datas['tracking'];
           // echo '<pre>',  var_export($datas),'</pre>'; exit();
            $emailVars = Zend_Registry::get('emailVars');
            $prix_accordes = array_combine($datas['code_article'], $datas['prix_accorde_article']);
            $remise_accordes = array_combine($datas['code_article'], $datas['remise_accorde_article']);
            $marge = array_combine($datas['code_article'],$datas['marge']); 
            foreach ($remise_accordes as $key => $value) {
                $remisesDirco = new Application_Model_DbTable_DemandeArticlexdistrib();
                $remiseDirco = $remisesDirco->insertRemiseAccorde($value, $key, $datas['tracking']);
            }
            foreach ($prix_accordes as $key => $value) {
                $prixDirco = new Application_Model_DbTable_DemandeArticlexdistrib();
                $priDirco = $prixDirco->insertPrixAccorde($value, $key, $datas['tracking']);
            }
            foreach($marge as $key=>$value){
                $margeinit=new Application_Model_DbTable_DemandeArticlexdistrib();
                $marges = $margeinit->updateMarge($value,$key,$datas['tracking']);
            }
            $validations = new Application_Model_DbTable_Validationsxdistrib();
             $validation = $validations->createValidation($datas['nom_validation'], $datas['date_validation'], $datas['validation'], $datas['commentaire_dirco'], $datas['dirco'], $datas['tracking']);

            $datasValidation = array(
                'nom_validation' => $nom_validation, 'validation' => $datas['validation'],
                'commentaire' => $datas['commentaire_dirco'],
                'tiltop' => $datas['dirco'], 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
            );
            if (array_key_exists('reponse', $datas)) {
                $datasValidation['reponse'] = $datas['reponse'];
            }
            $commentId = $this->genererValidation($datasValidation);
/*$maildevdistrib="mhuby@smc-france.fr";*/
            $mailSC=/*"mhuby@smc-france.fr";*/"distributeurs@smc-france.fr";
            $params = array();
            $params1 =array();
            $params1bis =array();
            $params2 = array();
            $params3=  array();
            $params4=  array();
            $params5 = array();
            $params6 = array();
            if (isset($datas['validation']) && $datas['validation'] == "fermee") {
                 $params8 = array();
                 $numwp_distributeur=trim($distrib_info['numwp_distributeur']);
                if($numwp_distributeur=='I02055' || $numwp_distributeur=='I01045'){
                $mailRCDN= $emailVars->listes->brammer;
                }elseif($numwp_distributeur=='I03624' ||
                        $numwp_distributeur=='I00789' ||
                        $numwp_distributeur=='I05285' ||
                        $numwp_distributeur=='I03317' ||
                        $numwp_distributeur=='I02557' ||
                        $numwp_distributeur=='I00415' ||
                        $numwp_distributeur=='I00678' ||
                        $numwp_distributeur=='I04380' ||
                        $numwp_distributeur=='I03214' ||
                        $numwp_distributeur=='I02886' ||
                        $numwp_distributeur=='I03621' ||
                        $numwp_distributeur=='I02929' ||
                        $numwp_distributeur=='I02932' ||
                        $numwp_distributeur=='I03912' ||
                        $numwp_distributeur=='I05223' ||
                        $numwp_distributeur=='I02920') {
                     $mailRCDN= $emailVars->listes->mbedexis;
                }elseif( 
                        $numwp_distributeur=='I00264' ||
                        $numwp_distributeur=='I00662' ||
                        $numwp_distributeur=='I00412' ||
                        $numwp_distributeur=='I01796' ||
                        $numwp_distributeur=='I01800' ||
                        $numwp_distributeur=='I03174' ||
                        $numwp_distributeur=='I03383' ||
                        $numwp_distributeur=='I01803' ||
                        $numwp_distributeur=='I04736' ||
                        $numwp_distributeur=='I03697' ||
                        $numwp_distributeur=='I04732' ||
                        $numwp_distributeur=='I01799' ||
                        $numwp_distributeur=='I04957' ||
                        $numwp_distributeur=='I03517' ||
                        $numwp_distributeur=='I05061' ||
                        $numwp_distributeur=='I01808' ||
                        $numwp_distributeur=='I02688' ||
                        $numwp_distributeur=='I04956' ||
                        $numwp_distributeur=='I05065' ){
                        $mailRCDN= $emailVars->listes->orexad;
                }
                elseif( $numwp_distributeur=='I01990') {
                         $mailRCDN= $emailVars->listes->rs;
            } else{$mailRCDN=$maildevdistrib;}
                $params8['destinataireMail']=$mailRCDN;
                $params8['url']="http://{$_SERVER['SERVER_NAME']}/xdistrib/avenant/numwp/{$numwp}";
                 $params8['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $tracking/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Veuillez télécharger l'avenant de cette demande à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "dbd.";
                $params8['sujet'] = " Xdistrib :demande Xdistrib  $tracking/$numwp pour le client $nomclients validée par Directeur Commercial/ lien pour Avenant .";
                $this->sendEmail($params8);
                $params6['destinataireMail']=$maildevdistrib;
                $params6['url']="http://{$_SERVER['SERVER_NAME']}/xdistrib/avenant/numwp/{$numwp}";
                $params6['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Veuillez télécharger  l'avenant de  cette demande  à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params6['sujet'] = " Xdistrib :demande Xdistrib  $tracking/$numwp pour le client $nomclients validée par Directeur Commercial/ lien pour Avenant .";
                $this->sendEmail($params6);
                $params['destinataireMail'] =/*"mhuby@smc-france.fr";*/$user_info['email_user'];
                $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params['sujet'] = " Xdistrib :demande Xdistrib  $tracking/$numwp pour le client $nomclients validée par Directeur Commercial.";
                $this->sendEmail($params);
                 
                $params1['destinataireMail'] =$mailSC;
                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params1['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $tracking/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params1['sujet'] = "  Xdistrib :demande Xdistrib $tracking/$numwp pour le client $nomclients validée par Directeur Commercial.";
                $this->sendEmail($params1);
                 $params1bis['destinataireMail'] ="mrita@smc-france.fr";
                $params1bis['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params1bis['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $tracking/$numwp pour le client $nomclients a été validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params1bis['sujet'] = "  Xdistrib :demande Xdistrib $tracking/$numwp pour le client $nomclients validée par Directeur Commercial.";
                $this->sendEmail($params1bis);
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
                            case "31":
                                $params2['destinataireMail'] = $emailVars->listes->leaderiw08;
                                break;
                        }
                         $params2['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";

                         $params2['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params2['sujet']=" Xdistrib :  Offre Xdistrib  $tracking/$numwp  de {$user_info['nom_user']} pour $nomclients validée par le Dirco";
                      $this->sendEmail($params2);           
                    }
                    //envoi au cdr
                     $zonetracking = substr($tracking, 7, 2);
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
                        $params3['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";

                        $params3['corpsMail'] = "Bonjour,\n"
                                . "\n"
                                . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                                . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
                        $params3['sujet']=" Xdistrib :Offre Xdistrib  $tracking/$numwp de {$user_info['nom_user']} pour $nomclients validée par le Dirco";
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
                        $destinataireMail4 = $emailVars->listes->carIndustries1;
                    }elseif(in_array($destIndustry, $car2)){
                        $destinataireMail4 = $emailVars->listes->carIndustries;
                    }elseif(in_array($destIndustry, $LS)){
                        $destinataireMail4 = $emailVars->listes->LifeandScience;
                    }elseif(in_array($destIndustry, $Elec)){
                       $destinataireMail4 = $emailVars->listes->Electronique;
                    }elseif(in_array($destIndustry, $food)){
                       $destinataireMail4 = $emailVars->listes->foodIndustries;
                    }elseif(in_array($destIndustry, $food1)){
                       $destinataireMail4 = $emailVars->listes->foodIndustries1;
                    }elseif(in_array($destIndustry,$EE)){
                        $destinataireMail4 = $emailVars->listes->environnementEnergie;
                    }
                $params4['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params4['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                        . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xdistrib";
                $params4['destinataireMail'] = $destinataireMail4;
                $params4['sujet'] = " Xdistrib : La demande Xdistrib  $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le Dirco.";
                $this->sendEmail($params4);
                 $params5['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params5['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le Dirco.\n"
                        . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xdistrib";
                $params5['destinataireMail'] = $emailVars->listes->DBD;
                $params5['sujet'] = " Xdistrib : La demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été validée par le Dirco.";
                $this->sendEmail($params5);
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp pour le client$nomclients a bien été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
                
            } elseif (isset($datas['validation']) && $datas['validation'] == 'enAttente') {
                $emailVars = Zend_Registry::get('emailVars');
                $params['destinataireMail'] =/*"mhuby@smc-france.fr";*/$user_info['email_user'] ;
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp est en attente de réponse à la question posée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params['sujet'] = " Xdistrib :demande $numwp pour le client $nomclients est mise en attente par le Directeur Commercial.";
                $this->sendEmail($params);

                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre Xdistrib $tracking/$numwp pour le client $nomclients est en attente de réponse du commercial.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
            } elseif (isset($datas['validation']) && $datas['validation'] == 'nonValide') {
                $emailVars = Zend_Registry::get('emailVars');
                $params['destinataireMail'] = /*"mhuby@smc-france.fr" ;*/$user_info['email_user'];
                if (!is_null($commentId)) {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}/com/{$commentId}";
                } else {
                    $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                }
                $params['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "Votre demande Xdistrib $tracking/$numwp pour le client $nomclients n'est pas validée par le Directeur Commercial .\n"
                        . "Vous pouvez la consulter à cette adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Directeur Commercial.";
                $params['sujet'] = " Xdistrib :demande Xdistrib $tracking/$numwp pour le client$nomclients non validée par Le Directeur Commercial.";
                $this->sendEmail($params);
                $params5['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/consult/numwp/{$numwp}";
                $params5['corpsMail'] = "Bonjour,\n"
                        . "\n"
                        . "la demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été refusée par le Dirco.\n"
                        . "Pour consulter la demande veuillez vous rendre à l'adresse url : \n"
                        . "%s"
                        . "\n\n"
                        . "Cordialement,\n"
                        . "\n"
                        . "--\n"
                        . "Xdistrib";
                $params5['destinataireMail'] =$emailVars->listes->DBD;
                $params5['sujet'] = " Xdistrib : La demande Xdistrib $tracking/$numwp de {$user_info['nom_user']} pour le client $nomclients a été refusée par le Dirco.";
                $this->sendEmail($params5);
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "l'offre $numwp pour le client $nomclients n'a pas été validée.";
                $flashMessenger->addMessage($message);
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoSimple('index', 'xdistrib');
            }
        }
    }
    public function updateAction(){
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
        $infos = new Application_Model_DbTable_Xdistrib();
        $info = $infos->getNumwp($numwp);
        $id_demande_xdistrib = $info['id_demande_xdistrib'];
        $tracking_number = $info['tracking_number_demande_xdistrib'];
        $this->view->tracking_number = $tracking_number;
        $date_offre = $info['date_demande_xdistrib'];
        $date = DateTime::createFromFormat('Y-m-d', $date_offre);
        $dateplop = $date->format('d/m/Y');
        $this->view->date_offre = $dateplop;
        $id_commercial = $info['id_user'];
        $numwp_client = $info['numwp_client'];
        $info_client = new Application_Model_DbTable_ClientDistrib;
        $infos_client = $info_client->getClientnumwp($numwp_client);
        $info_commercial = new Application_Model_DbTable_Users();
        $infos_commercial = $info_commercial->getUser($id_commercial);
        $tests = new Application_Model_DbTable_DemandeArticlexdistrib();
        $test = $tests->sommePrixDemandeArticle($numwp);
        $this->view->montant_total = $test->total;
        $this->view->infos_client = $infos_client[0];
        $nomclients=trim($infos_client[0]['nom_client']);
        $noms_industrie = new Application_Model_DbTable_Industry();
        $nom_industrie = $noms_industrie->getIndustry($infos_client[0]['id_industry']);
        $this->view->nom_industrie = $nom_industrie;
        $infos_demande_article_xdistrib = new Application_Model_DbTable_DemandeArticlexdistrib();
        $info_demande_article_xdistrib = $infos_demande_article_xdistrib->getDemandeArticlexdistrib($numwp);
        $this->view->info_demande_article_xdistrib = $info_demande_article_xdistrib;
        /* recupération des commentaires concernant la demande */
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);

        $commentairesoffre = new Application_Model_DbTable_Validationsdemandexdistrib();
        $commentaireoffre = $commentairesoffre->getAllValidation($id_demande_xdistrib);
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
                'nom_validation' => $nom_validation, 'validation' => "Réponse",
                'commentaire' => $formData['reponse_comm'],
                'tiltop' => $user->id_user, 'id_demande_xdistrib' => $info_demande_xdistrib['id_demande_xdistrib']
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
//                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/update/numwp/{$numwp}/histo/{$lasthisto[0]['id_histo_commentaire']}";
            if (!is_null($commentId)) {
                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validate{$fonctions[$idF]}/numwp/{$numwp}/com/{$commentId}";
            } else {
                $params1['url'] = "http://{$_SERVER['SERVER_NAME']}/xdistrib/validate{$fonctions[$idF]}/numwp/{$numwp}";
            }

            $params1['corpsMail'] = "Bonjour,\n"
                    . "\n"
                    . "Une réponse a été apportée à la question que vous avez posé sur demande Xdistrib $tracking_number/$numwp.\n"
                    . "Veuillez vous rendre à l'adresse url : \n"
                    . "%s"
                    . "\n\n"
                    . "Cordialement,\n"
                    . "\n"
                    . "--\n"
                    . "Xdistrib.";
            $params1['sujet'] = " Xdistrib : réponse sur la demande Xdistrib  $tracking_number/$numwp pour le client $nomclients.";
            //echo '<pre>',  var_export($params1),'</pre>'; exit();
            $this->sendEmail($params1);

            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "la demande est en attente de réponse du {$fonctions[$idF]}.";
            $flashMessenger->addMessage($message);
            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoSimple('index', 'xdistrib');
        }
    }
    public function avenant2Action(){
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
        $info_article=new Application_Model_DbTable_DemandeArticlexdistrib();
        $article_info= $info_article->getDemandeArticlexdistrib($numwp);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib['numwp_client']);
        $this->view->client_distrib=$client_info;
        $this->view->article_info=$article_info;
        $this->view->info_distrib=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
      // echo '<pre>', var_export($distrib_info),'</pre>';
    }
    public function avenantAction(){
        $numwp = $this->getRequest()->getParam('numwp', null);
        $this->view->numwp = $numwp; 
        $infos_demande_xdistrib = new Application_Model_DbTable_Xdistrib();
        $info_demande_xdistrib = $infos_demande_xdistrib->getNumwp($numwp);
        $numwp_dis=trim($info_demande_xdistrib['numwp_distributeur']);
       
        $info_distrib=new Application_Model_DbTable_Distributeurs();
        $distrib_info=$info_distrib->getDistributeurnumwp($numwp);
        $info_article=new Application_Model_DbTable_DemandeArticlexdistrib();
        $article_info= $info_article->getDemandeArticlexdistrib($numwp);
        $info_client=new Application_Model_DbTable_ClientDistrib();
        $client_info=$info_client->getClientdistrib($info_demande_xdistrib['numwp_client']);
        $dates= new Application_Model_DbTable_Validationsdemandexdistrib();
        $date= $dates->datefermeture($numwp);
        
        $datefinale4=date( 'Y' ,strtotime($date[0]['date_validation']));
        $datefinale3=date( 'm' ,strtotime($date[0]['date_validation']));
        $datefinale2=date( 'd' ,strtotime($date[0]['date_validation']));
        $datefinale1=$datefinale2.'/'.$datefinale3.'/'.$datefinale4;
//          echo '<pre>', var_export($datefinale1),'</pre>'; exit();
        $this->view->date=$datefinale1;
        $this->view->client_distrib=$client_info;
        $this->view->article_info=$article_info;
        $this->view->info_distrib=$distrib_info;
        $this->view->info_demande_xdistrib=$info_demande_xdistrib;
    }
}

