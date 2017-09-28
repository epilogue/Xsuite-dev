<?php

class XprevController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
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
    protected function sendEmail($params) {
        $mail = new Xsuite_Mail();
        $mail->setSubject($params['sujet'])
                ->setBodyText(sprintf($params['corpsMail'], $params['url']))
                ->addTo($params['destinataireMail'])
                ->send();
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
        //var_dump($num_mois);
        $month= intval(substr($num_mois,0,2)) ;
        $year = intval(substr($num_mois,-2));
        //var_dump($year);
        //var_dump($month);
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
       // var_dump($tab);
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
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $xprev = new Application_Model_DbTable_DemandeXprev();
        $Holon = new Application_Model_DbTable_Holons();
        $infoHolon =$Holon->getHolon($user->id_holon);
        //var_dump($user);
        //var_dump($infoHolon);
        //var_dump($infoUser['id_fonction']);
        /*fonction niveau0*/
        $fn0 = array(4,18,38);
        /* fonction niveau1*/
        $fn1 =array(1,2,6,43,44,46,26,27,28,29,30,34,35,36,37,40);
         /*fonction niveau2*/
        $fn2 = array(3,41,45,42);
        /*fonction niveau2bis*/
        $fn2bis = array(10,41);
        /*fonction niveau3*/
        $fn3 = array(32,23,50,39);
        if($infoUser['id_fonction'] =='2' || $infoUser['id_fonction'] =='46'){
            $listeXprev= $xprev->getuserxprev($user->id_user);
            $listeN1Xprev= null;
        }elseif($infoUser['id_fonction'] =='3' || $infoUser['id_fonction'] =='45' || $infoUser['id_fonction'] =='44' ||$infoUser['id_fonction'] =='43' ){
             $listeN1Xprev= $xprev->getusern1xprev($user->id_holon);
             $listeXprev= $xprev->getuserxprev($user->id_user);
        }
        elseif($infoUser['id_fonction'] =='10'){
            /* recherche sur les 2 premiers caratères du holon*/
            $nom_holon = $infoHolon['nom_holon'];
            $holon= substr($nom_holon,0,2);
            var_dump($holon);
            $listeRegXprev= $xprev->getuserregxprev($holon);
            $listeN1Xprev= null;
            $listeXprev= null;
        } elseif($infoUser['id_fonction']=='23' || $infoUser['id_fonction']=='39' ||$infoUser['id_fonction']=='32' || $infoUser['id_fonction']=='50'){
            $listeAllXprev= $xprev->getallxprev();
            $listeRegXprev= null;
            $listeN1Xprev= null;
            $listeXprev= null;
        }
//        echo '<pre>',  var_export($listeN1Xprev),'</pre>';
//        echo '<pre>',  var_export($listeXprev),'</pre>';
//        echo '<pre>',  var_export($listeRegXprev),'</pre>';
        $this->view->fonction = $user->id_fonction;
        $this->view->nom = $user->nom_user;
        $this->view->iduser = $user->id_user;
        $this->view->listexprev = $listeXprev;
        $this->view->listeAllxprev = $listeAllXprev;
        $this->view->listeN1xprev = $listeN1Xprev;
        $this->view->listeRegxprev = $listeRegXprev;
        $this->view->fn0 = $fn0;
        $this->view->fn1 = $fn1;
        $this->view->fn2 = $fn2;
        $this->view->fn2bis = $fn2bis;
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
        $fichier = new Application_Model_DbTable_FichierXprev();
        $basecodeclient = new Application_Model_DbTable_Baseclient();
        $listecodeclient = $basecodeclient->getAllcodeclient();
        $typedemande = new Application_Model_DbTable_TypeDemandeXprev();
        $listetypedemande = $typedemande->alltypedemande();
        $niveaurisque = new Application_Model_DbTable_NiveauRisqueXprev();
        $listeniveaurisque = $niveaurisque->allniveaurisque();
        $etatvalidation = new Application_Model_DbTable_EtatValidationXprev();
        $xprev = new Application_Model_DbTable_DemandeXprev();
        $newetatvalidation = $etatvalidation->getEtat($etatcreat);
        $datejour = date('d-m-Y');
        $datecreate =date('Y-m-d');
        $moiscreate = date('m-Y');
        /*passage a la vue*/
        $this->view->newetatvalidation=$newetatvalidation;
        $this->view->listetypedemande=$listetypedemande;
        $this->view->datecreate=$datejour;
        $this->view->moiscreate=$moiscreate;
        $this->view->listeniveaurisque=$listeniveaurisque;
        $this->view->infoCodeClient=$listecodeclient;
        $this->view->infoUser=$infoUser;
        
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
//           echo '<pre>',  var_export($formData),'</pre>'; 
            
            /*creation du tracking number */
            $newprev= new Application_Model_DbTable_DemandeXprev();
            $prevnew = $newprev->getdatetrack($datecreate);
            $trackingnumber = Application_Model_DbTable_DemandeXprev::makeTrackingNumber($prevnew);           
            $uploaddir =APPLICATION_PATH."/../public/fichiers/Xprev/Creation/";
            
            /*creation de la date de fin */
            $num_mois = $this->getRequest()->getParam('date_debut',null);
            //var_dump($num_mois);
            $month= intval(substr($num_mois,0,2)) ;
            $year = intval(substr($num_mois,-2));
            //var_dump($year);
            //var_dump($month);
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
            
            /** mise au format des date*/
            $datedebut1= '01-'.$formData['date_debut'];
            $datedebut2 = date_create_from_format('d-m-Y',$datedebut1);
            $datedebut3= date_format($datedebut2, 'Y-m-d');
            $date_fin1= end($tab);
            $date_fin2 ='01-'.$date_fin1['month'].'-20'.$date_fin1['year'];
            $date_fin1['month'] = ($date_fin1['month']<10)?'0'.$date_fin1['month']:$date_fin1['month'];
            $date_fin4 ='20'.$date_fin1['year'].'-'.$date_fin1['month'].'-01';
            //var_dump($date_fin4);
            /*recuperation des id client  et client_user*/
            $idclient = $basecodeclient->getId($formData['num_client']);
            $idclientuser = $basecodeclient->getId($formData['code_user']);
            var_dump($idclientuser);
            /*insertion en bdd pour la table client_user_xprev*/
             $client_user = new Application_Model_DbTable_ClientUserXprev();
             $datauserclient = array(
                 'tracking'=>$trackingnumber,
                 'code_client_users_xprev'=>$idclientuser[0]['code_client'],
                 'nom_client_user_xprev'=>$idclientuser[0]['nom_client']  
             );
             $newclientuser = $client_user->createclientuser($datauserclient);
             $id_client_user = $client_user->lastId($trackingnumber);
             /*insertion en bdd pour la table client_xprev*/
             $client = new Application_Model_DbTable_ClientXprev();
             $dataclient = array(
                 'tracking'=>$trackingnumber,
                 'code_user_client_xprev'=>$idclientuser[0]['code_client'],
                 'nom_client_xprev'=>$idclientuser[0]['nom_client']  
             );
             $newclient = $client->createclient($dataclient);
              $id_client = $client->lastId($trackingnumber);
            /*insertion en bdd dans la table demande_xprev*/
            $data =array (
                    'tracking'=>$trackingnumber,
                    'id_users'=>$infoUser['id_user'],
                    'id_commercial'=>$infoUser['id_user'],
                    'date_create'=>$datecreate,
                    'date_debut'=>$datedebut3,
                    'date_fin'=>$date_fin4,
                    'id_client_xprev'=>$id_client->id_client_xprev,
                    'id_client_user_xprev'=>$id_client_user->id_client_user_xprev,
                    'valeur_totale'=>null,
                    'id_statut_xprev'=>$etatcreat,
                    'id_niveau_risque_xprev'=>$formData['risque'],
                    'id_type_demande_xprev'=>$formData['type'],
                    'id_validation'=>2,
                    'justification'=>$formData['motif_create'],
                    'justification_n1'=>null,
                    'justification_log'=>null,
                    'justification_dop'=>null,
                    'justification_supp'=>null,
                    'justification_traitement'=>null,
                    'justification_cloture'=>null
                                        );
             $newdemande = $xprev->createDemande($data);
             
             /* insertion en bdd dans la table demande_article_xprev*/
             
             foreach($formData['refart'] as $refart){
                 if($refart['m1']==''){
                     $$refart['m1']=0;
                 }
                 if($refart['m2']==''){
                     $$refart['m2']=0;
                 }
                 if($refart['m3']==''){
                     $$refart['m3']=0;
                 }
                 if($refart['m4']==''){
                     $$refart['m4']=0;
                 }
                 if($refart['m5']==''){
                     $$refart['m5']=0;
                 }
                 if($refart['m6']==''){
                     $$refart['m6']=0;
                 }
                 if($refart['m7']==''){
                     $$refart['m7']=0;
                 }
                 if($refart['m8']==''){
                     $$refart['m8']=0;
                 }
                 if($refart['m9']==''){
                     $$refart['m9']=0;
                 }
                 if($refart['m10']==''){
                     $$refart['m10']=0;
                 }
                 if($refart['m11']==''){
                     $$refart['m11']=0;
                 }
                 if($refart['m12']==''){
                     $$refart['m12']=0;
                 }
                 $total_article_mois =($refart['m1']+$refart['m2']+$refart['m3']+$refart['m4']+$refart['m5']+$refart['m6']+$refart['m7']+$refart['m8']+$refart['m9']+$refart['m10']+$refart['m11']+$refart['m12']);
             $data2 = array(
                 'tracking'=>$trackingnumber,
                 'code_article'=>$refart['code_article'],
                    'reference_article'=>$refart['reference'],
                    'prix_revient'=>null,
                    'shikomi'=>null,
                    'm1'=>$refart['m1'],
                    'm2'=>$refart['m2'],
                    'm3'=>$refart['m3'],
                    'm4'=>$refart['m4'],
                    'm5'=>$refart['m5'],
                    'm6'=>$refart['m6'],
                    'm7'=>$refart['m7'],
                    'm8'=>$refart['m8'],
                    'm9'=>$refart['m9'],
                    'm10'=>$refart['m10'],
                    'm11'=>$refart['m11'],
                    'm12'=>$refart['m12'],
                    'total_article_mois'=>$total_article_mois,
                    'valeur_totale'=>null
                );
              //echo '<pre>',  var_export($data2),'</pre>'; exit();
              $xprevarticle = new Application_Model_DbTable_DemandeArticleXprev();
              $newarticle = $xprevarticle->createDemandeArticle($data2);
             }
             foreach($formData['refart'] as $refart){
                 $mmcono = "100";
                 $query3 = "select * from EIT.MVXCDTA.MITFAC MITFAC where MITFAC.M9CONO = '$mmcono' AND MITFAC.M9ITNO = '{$refart['code_article']}' and MITFAC.M9FACI ='I01'";
                 $resultats3 = odbc_Exec($this->odbc_conn2, $query3);
                 $prixrevient[] = odbc_fetch_object($resultats3);
               // echo '<pre>',(var_export($prixrevient)),'</pre>'; 
             }
             foreach($prixrevient as $key=>$value1){
                 $totalarticle = $xprevarticle->sommemois($value1->M9ITNO, $trackingnumber);
                 //var_dump($totalarticle); 
                 $datauprevient = $xprevarticle->uprevient($trackingnumber,$value1->M9ITNO,$value1->M9UCOS);
                 $upvaleurtotale =$xprevarticle->upvaleurtotale($value1->M9ITNO, $trackingnumber,$totalarticle[0]['total_article_mois']);
                 
             }
             if(isset($_FILES['fichierCreationXprev']['name'])){
                if($_FILES['fichierCreationXprev']['size']<=2000000){
                    $extension_upload1 =strrchr($_FILES['fichierCreationXprev']['name'],'.');
                    $name = explode('.',$_FILES['fichierCreationXprev']['name']);
                    $file = $name[0].$trackingnumber.$extension_upload1;
                    $uploadfile = $uploaddir.$file;
                    if(move_uploaded_file($_FILES['fichierCreationXprev']['tmp_name'], $uploadfile)){
                        echo "tout ok";
                        $datafichier = array(
                            'tracking_xprev'=>$trackingnumber,
                            'nom_fichier_xprev'=>$file,
                            'chemin_fichier_xprev'=>"/fichiers/Xprev/Creation/".$file
                        );
                        $newfichier = $fichier->createFichierXprev($datafichier);
                    }else{
                        echo "tout foutu";
                    }
                }
            }
             /**envoi mail au N+1*/
             /*recherche du destinataire*/
             $id_holon = $infoUser['id_holon'];
             $id_fonction = $infoUser['id_fonction'];
             $hierarchie = new Application_Model_DbTable_HierarchieXprev();
             $destinataire = $hierarchie->gethierarchie($id_holon,$id_fonction);
             //var_dump($destinataire);
             /* appel de la fonction send mail*/
             $emailVars = Zend_Registry::get('emailVars');
             /* creation des parametre du mail*/
             $params=array();
             //$params['destinataireMail']=$destinataire->email_user;
             $params['destinataireMail']="mhuby@smc-france.fr";
             
             $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/validn1/tracking/{$trackingnumber}";
             $params['corpsMail']="Bonjour,\n"
                                . "\n"
                                . "Vous avez une nouvelle demande Xprev({$trackingnumber}) à valider.\n"
                                . "Veuillez vous rendre à l'adresse url : \n"
                                . "%s"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Xsuite";
             $params['sujet']="validation Xprev $trackingnumber ";
              //echo '<pre>',  var_export($params),'</pre>';
               $this->sendEmail($params);
            $redirector = $this->_helper->getHelper('Redirector');
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $message = "votre demande de prévision a bien été créée.";
            $flashMessenger->addMessage($message);
            $redirector->gotoSimple('index', 'xprev'); 
        }
    }
    public function consultAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        //var_dump($tracking);
        
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
        
        /*creation du tableau de date  */
            $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
//        echo '<pre>',var_export($tab),'</pre>';
        $this->view->infoMois = $tab;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        
    }
    public function validn1Action(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        //var_dump($tracking);
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
        //echo '<pre>',  var_export($infoUser),'</pre>';
         $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
       // echo '<pre>',var_export($tab),'</pre>';
        $this->view->infoMois = $tab;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
            //echo '<pre>',  var_export($formData),'</pre>'; 
            /*mettre à jour la demande xprev 
             * au niveau du nom de la validation
             * commentaire validation
             * l'etat de la validation accepté/refusé
             */
            $emailVars = Zend_Registry::get('emailVars');
                 /* creation des parametre du mail*/
                 $params=array();
            /*envoi du mail à la log*/
            if($formData['validn1']=='1'){
//                echo 'plop'; 
                $statut=1;
                $validation =3;
                $justification =$formData['motif_validation'];
                //var_dump($justification);
                
                $upn1 = $Prev->upn1xprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="logistique@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/validlog/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande Xprev({$tracking}) à valider.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="validation Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision a bien été prise en compte et envoyée à la logistique.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev'); 
            }else{
                /*on va chercher le mail du createur de la demande */
                $statut=4;
                $validation =5;
                $justification = $formData['motif_validation'];
                $upn1 = $Prev->upn1xprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/consult/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "Votre demande Xprev({$tracking})a été refusée.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "pour la consulter."
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="refus Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision a bien été refusée.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev');
            }
        }
    }
   
    public function validlogAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $listeallcommercial = $User->rechercheUserCompletion();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        var_dump($tracking);
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
        $infolog = new Application_Model_DbTable_Infolog();
        $infodemandeinfolog = $infolog->getinfolog($tracking);
        $uploaddir =APPLICATION_PATH."/../public/fichiers/Xprev/Log/";
//        echo '<pre>',  var_export($listeallcommercial),'</pre>';
//         echo '<pre>',  var_export($infoPrev),'</pre>';
         $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
        //echo '<pre>',var_export($tab),'</pre>';
        $this->view->listeallcommercial=$listeallcommercial;
        $this->view->infoMois = $tab;
        $this->view->infodemandeinfo = $infodemandeinfolog;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
//            echo '<pre>',  var_export($formData),'</pre>'; 
            /*mis a jour de la demande de xprev  si le commercial change */
            if($formData['nom_commercial']!=$infoPrev[0]['id_commercial']){
                $modifcomm = $Prev->upcommercial($formData['nom_commercial'],$tracking);
            }
            $revient = array_combine($formData['code_article'], $formData['prix_revient']);
            $valeur = array_combine($formData['code_article'], $formData['valeur_totale']);
            $shikomi = array_combine($formData['code_article'], $formData['shikomi']);
           // echo '<pre>',  var_export($revient),'</pre>';
            //echo '<pre>',  var_export($valeur),'</pre>';
                  
            /*mettre à jour la demande xprev 
             * au niveau du nom de la validation
             * commentaire validation
             * l'etat de la validation accepté/refusé
             * shikomi ou pas 
             * prix de revient
             * insertion pour les fichiers
             */
            foreach($revient as $keys=>$value){
                $uprevient1= $ArticlePrev->uprevient($tracking, $keys, $value);
            }
            foreach($valeur as $keys=>$value){
                $valeur1 = $ArticlePrev->upvaleurtotale1($keys, $tracking, $value);
            }
           foreach($shikomi as $key=>$value){
                  $shikomi1 = $ArticlePrev->upshikomi($value, $key, $tracking);
              }  
            
            if(isset($_FILES['fichierLogXprev']['name'])){
                if($_FILES['fichierLogXprev']['size']<=2000000){
                    $extension_upload1 =strrchr($_FILES['fichierLogXprev']['name'],'.');
                    $name = explode('.',$_FILES['fichierLogXprev']['name']);
                    $file = $name[0].$tracking.$extension_upload1;
                    $uploadfile = $uploaddir.$file;
                    if(move_uploaded_file($_FILES['fichierLogXprev']['tmp_name'], $uploadfile)){
                        echo "tout ok";
                        $datafichier = array(
                            'tracking_xprev'=>$tracking,
                            'nom_fichier_xprev'=>$file,
                            'chemin_fichier_xprev'=>"/fichiers/Xprev/Log/".$file
                        );
                        $newfichier = $fichier->createFichierXprev($datafichier);
                    }else{
                        echo "tout foutu";
                    }
                }
            }
            $emailVars = Zend_Registry::get('emailVars');
                 /* creation des parametre du mail*/
                 $params=array();
            /*envoi du mail à dop*/
            if($formData['validlog']=='1'){
//                echo 'plop'; 
                $statut=1;
                $validation =4;
                $justification =$formData['motif_validation'];
                var_dump($justification);
                
                $upn1 = $Prev->uplogxprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="dop@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/validdop/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande Xprev({$tracking}) à valider.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="validation Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision a bien été prise en compte et envoyée à DOP.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev'); 
            }elseif($formData['validlog']=='0'){
                /*on va chercher le mail du createur de la demande */
                $statut=4;
                $validation =5;
                $justification = $formData['motif_validation'];
                $upn1 = $Prev->uplogxprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/consult/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "Votre demande Xprev({$tracking})a été refusée.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "pour la consulter."
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="refus Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision a bien été refusée.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev');
            }
            elseif ($formData['validlog']=='2') {
             /*si demande d'info envoiau createur */
                $statut=1;
                $validation =4;
                $justification = $formData['motif_validation'];
                $datalog=array( 'tracking'=>$tracking,'demande_infolog'=>$justification,'reponse_infolog'=>null);
                $newinfolog = $infolog->createinfolog($datalog);
                 //$params['destinataireMail']="createur@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/supplementinfolog/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "demande de renseignement  complémentaire de la logistique \n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "pour répondre. \n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="demande d'information de la log  Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "demande de complément d'information pour la demande de prévision a bien été envoyée.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev');
            }
        }
    }
    public function supplementinfologAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
        $infolog = new Application_Model_DbTable_Infolog();
        $infodemandeinfolog = $infolog->getinfolog($tracking);
        $uploaddir =APPLICATION_PATH."/../public/fichiers/Xprev/Supp/log/";
//        echo '<pre>',  var_export($infodemandeinfolog),'</pre>';
        $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
        //echo '<pre>',var_export($tab),'</pre>';
        $this->view->infoMois = $tab;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        $this->view->infodemandelog = $infodemandeinfolog;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
           echo '<pre>',  var_export($formData),'</pre>';  
//           echo '<pre>',  var_export($_FILES),'</pre>';  
//           exit();
            if(isset($_FILES['fichierSupplogXprev']['name'])){
                if($_FILES['fichierSupplogXprev']['size']<=2000000){
                    $extension_upload1 =strrchr($_FILES['fichierSupplogXprev']['name'],'.');
                    $name = explode('.',$_FILES['fichierSupplogXprev']['name']);
                    $file = $name[0].$tracking.$extension_upload1;
                    $uploadfile = $uploaddir.$file;
                    if(move_uploaded_file($_FILES['fichierSupplogXprev']['tmp_name'], $uploadfile)){
                        echo "tout ok";
                        $datafichier = array(
                            'tracking_xprev'=>$tracking,
                            'nom_fichier_xprev'=>$file,
                            'chemin_fichier_xprev'=>"/fichiers/Xprev/Supp/log/".$file
                        );
                        $newfichier = $fichier->createFichierXprev($datafichier);
                    }else{
                        echo "tout foutu";
                    }
                }
            }
            $updateinfosupp = $infolog->updateinfolog($tracking,$formData['id_infolog'],$formData['supplement']);
            $emailVars = Zend_Registry::get('emailVars');
             //$params['destinataireMail']="logistique@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/validlog/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "l'itc a répondu à votre demande d'information pour la demande Xprev({$tracking}) à traiter.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="réponse demande d'information  Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la réponse pour la demande de prévision a bien été prise en compte et envoyée à la logistique.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev'); 
        }
    }
    public function validdopAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        //var_dump($tracking);
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
        $infolog = new Application_Model_DbTable_Infolog();
        $infodemandeinfolog = $infolog->getinfolog($tracking);
        $infodop = new Application_Model_DbTable_Infodop();
        $infodemandeinfodop = $infodop->getinfodop($tracking);
        //$info_createur = $User->getUser($infoPrev[0]['id_users']);
        //echo '<pre>',  var_export($infoUser),'</pre>';
         $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
        //echo '<pre>',var_export($tab),'</pre>';
        $this->view->infoMois = $tab;
        $this->view->infodemandeinfolog = $infodemandeinfolog;
        $this->view->infodemandeinfodop = $infodemandeinfodop;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
            //echo '<pre>',  var_export($formData),'</pre>'; 
            /*mettre à jour la demande xprev 
             * au niveau du nom de la validation
             * commentaire validation
             * l'etat de la validation accepté/refusé
             */
            $emailVars = Zend_Registry::get('emailVars');
                 /* creation des parametre du mail*/
                 $params=array();
            /*envoi du mail à la log*/
            if($formData['validdop']=='1'){
//                echo 'plop'; 
                $statut=1;
                $validation =6;
                $justification =$formData['motif_validation'];
                //var_dump($justification);
                
                $updop = $Prev->updopxprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="logistique@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/traitement/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande Xprev({$tracking}) à traiter.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="validation Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision a bien été prise en compte et envoyée à la logistique.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev'); 
            }elseif($formData['validdop']=='0'){
                /*on va chercher le mail du createur de la demande */
                $statut=4;
                $validation =5;
                $justification = $formData['motif_validation'];
                $upn1 = $Prev->updopxprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="$info_createur['mail_user']";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/consult/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "Votre demande Xprev({$tracking})a été refusée.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "pour la consulter."
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="refus Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision a bien été refusée.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev');
            }
            elseif ($formData['validdop']=='2') {
             /*si demande d'info envoi a la logistique */
                $statut=1;
                $validation =4;
                $justification = $formData['motif_validation'];
                $upn1 = $Prev->updopxprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="logistique@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/supplementinfodop/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "demande de renseignement complémentaire\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "pour répondre."
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="demande d'information Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "demande de complément d'information pour la demande de prévision a bien été envoyée.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev');
            }
        }
    }
    public function supplementinfodopAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        //var_dump($tracking);
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
        $infolog = new Application_Model_DbTable_Infolog();
        $infodemandeinfolog = $infolog->getinfolog($tracking);
        $infodop = new Application_Model_DbTable_Infodop();
        $infodemandeinfodop = $infodop->getinfodop($tracking);
        $uploaddir =APPLICATION_PATH."/../public/fichiers/Xprev/Supp/dop/";
        //echo '<pre>',  var_export($infoUser),'</pre>';
         $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
       // echo '<pre>',var_export($tab),'</pre>';
        $this->view->infodemandeinfolog = $infodemandeinfolog;
        $this->view->infodemandedop = $infodemandeinfodop;
        $this->view->infoMois = $tab;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
           if(isset($_FILES['fichierSuppdopXprev']['name'])){
                if($_FILES['fichierSuppdopXprev']['size']<=2000000){
                    $extension_upload1 =strrchr($_FILES['fichierSuppdopXprev']['name'],'.');
                    $name = explode('.',$_FILES['fichierSuppdopXprev']['name']);
                    $file = $name[0].$tracking.$extension_upload1;
                    $uploadfile = $uploaddir.$file;
                    if(move_uploaded_file($_FILES['fichierSuppdopXprev']['tmp_name'], $uploadfile)){
                        echo "tout ok";
                        $datafichier = array(
                            'tracking_xprev'=>$tracking,
                            'nom_fichier_xprev'=>$file,
                            'chemin_fichier_xprev'=>"/fichiers/Xprev/Supp/dop/".$file
                        );
                        $newfichier = $fichier->createFichierXprev($datafichier);
                    }else{
                        echo "tout foutu";
                    }
                }
            }
            $updateinfosupp = $infodop->updateinfodop($tracking,$formData['id_infodop'],$formData['supplement']);
            $emailVars = Zend_Registry::get('emailVars');
                 /* creation des parametre du mail*/
                 $params=array();
            /*envoi du mail à dop*/
                 //$params['destinataireMail']="dop@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/validdop/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "les informations supplémentaires ont été ajoutées vous pouvez valider la demande Xprev({$tracking}) à valider.\n"
                                    . " à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="réponse demande d'information complémentaire Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "les informations complémentaires ont bien été ajoutées.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev'); 
           
        }
    }
    public function traitementAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $listeallcommercial = $User->rechercheUserCompletion();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        //var_dump($tracking);
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
//        echo '<pre>',  var_export($listeallcommercial),'</pre>';
//         echo '<pre>',  var_export($infoPrev),'</pre>';
         $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
        //echo '<pre>',var_export($tab),'</pre>';
        $this->view->listeallcommercial=$listeallcommercial;
        $this->view->infoMois = $tab;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
//            echo '<pre>',  var_export($formData),'</pre>'; 
            /*mis a jour de la demande de xprev  si le commercial change */
            if($formData['nom_commercial']!=$infoPrev[0]['id_commercial']){
                $modifcomm = $Prev->upcommercial($formData['nom_commercial'],$tracking);
            }
            $revient = array_combine($formData['code_article'], $formData['prix_revient']);
            $valeur = array_combine($formData['code_article'], $formData['valeur_totale']);
            $shikomi = array_combine($formData['code_article'], $formData['shikomi']);
           // echo '<pre>',  var_export($revient),'</pre>';
            //echo '<pre>',  var_export($valeur),'</pre>';
                  
            /*mettre à jour la demande xprev 
             * au niveau du nom de la validation
             * commentaire validation
             * l'etat de la validation accepté/refusé
             * shikomi ou pas 
             * prix de revient
             * insertion pour les fichiers
             */
            foreach($revient as $keys=>$value){
                $uprevient1= $ArticlePrev->uprevient($tracking, $keys, $value);
            }
            foreach($valeur as $keys=>$value){
                $valeur1 = $ArticlePrev->upvaleurtotale1($keys, $tracking, $value);
            }
           foreach($shikomi as $key=>$value){
                  $shikomi1 = $ArticlePrev->upshikomi($value, $key, $tracking);
              }  
            
            
            $emailVars = Zend_Registry::get('emailVars');
                 /* creation des parametre du mail*/
                 $params=array();
//                echo 'plop'; 
                $statut=1;
                $validation =7;
                $justification =$formData['motif_validation'];
                var_dump($justification);
                
                $upn1 = $Prev->uptraitementxprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="logistique@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/cloture/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "Vous avez une nouvelle demande Xprev({$tracking}) à cloturer.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="cloture Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision a bien été traitée par la logistique.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev'); 
            
        }
    }
    public function clotureAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $tracking = $this->getRequest()->getParam('tracking', null);
        //var_dump($tracking);
        $Prev = new Application_Model_DbTable_DemandeXprev();
        $infoPrev = $Prev->getprev($tracking);
        $fichier = new Application_Model_DbTable_FichierXprev();
        $infoFichier = $fichier->getfichier($tracking);
        $ArticlePrev = new Application_Model_DbTable_DemandeArticleXprev();
        $infoArticle = $ArticlePrev->getarticleprev($tracking);
        //echo '<pre>',  var_export($infoUser),'</pre>';
         $num_mois =  $infoPrev[0]['date_debut'];
           
            $date=explode('-',$num_mois);
            
            $month = intval($date[1]);
           
            $year = intval(substr($date[0],-2));
            
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
            
        //echo '<pre>',var_export($tab),'</pre>';
        $this->view->infoMois = $tab;
        $this->view->infoPrev = $infoPrev[0];
        $this->view->infoArticle = $infoArticle;
        $this->view->infoFichier = $infoFichier;
        $this->view->infoUser = $infoUser;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
            //echo '<pre>',  var_export($formData),'</pre>'; 
            /*mettre à jour la demande xprev 
             * au niveau du nom de la validation
             * commentaire validation
             * l'etat de la validation accepté/refusé
             */
            $emailVars = Zend_Registry::get('emailVars');
                 /* creation des parametre du mail*/
                 $params=array();
            /*envoi du mail à la log*/
            
//                echo 'plop'; 
                $statut=3;
                $validation =8;
                $justification =$formData['motif_validation'];
                //var_dump($justification);
                
                $updop = $Prev->updopxprev($statut,$validation,$justification,$tracking);
                 //$params['destinataireMail']="user@smc-france.fr";
                 $params['destinataireMail']="mhuby@smc-france.fr";

                 $params['url'] = "http://{$_SERVER['SERVER_NAME']}/xprev/consult/tracking/{$tracking}";
                 $params['corpsMail']="Bonjour,\n"
                                    . "\n"
                                    . "la demande Xprev({$tracking}) est cloturée.\n"
                                    . "Veuillez vous rendre à l'adresse url : \n"
                                    . "%s"
                                    . "\n\n"
                                    . "Cordialement,\n"
                                    . "\n"
                                    . "--\n"
                                    . "Xsuite";
                $params['sujet']="Cloture Xprev $tracking ";
                  //echo '<pre>',  var_export($params),'</pre>';
                $this->sendEmail($params);
                $redirector = $this->_helper->getHelper('Redirector');
                $flashMessenger = $this->_helper->getHelper('FlashMessenger');
                $message = "la demande de prévision est cloturée.";
                $flashMessenger->addMessage($message);
                $redirector->gotoSimple('index', 'xprev'); 
            
        }
    }

    public function rechercheAction(){
        $user = $this->_auth->getStorage()->read();
        /*information concernant la personne connectée*/
        $User = new Application_Model_DbTable_Users();
        $infoUser = $User->getUser($user->id_user);
        $Holon = new Application_Model_DbTable_Holons();
        $infoHolon =$Holon->getHolon($user->id_holon);
        $Xprev = new Application_Model_DbTable_DemandeXprev();
        $ArticleXprev = new Application_Model_DbTable_DemandeArticleXprev();
        $Statut = new Application_Model_DbTable_StatutXprev();
        $Client = new Application_Model_DbTable_ClientUserXprev();
        $listeAllclient =$Client->searchClientUser() ;
        $listeAllcommercial=$User->getAll() ;
        $listeAlluser =$User->getAllUser() ;
        $listeAlltracking = $Xprev->getAlltracking();
        $listeAllreference =$ArticleXprev->getAllreference() ;
        $listeAllstatut = $Statut->getAllStatut();
         $fn0 = array(4,18,38);
        /* fonction niveau1*/
        $fn1 =array(1,2,6,43,44,46,26,27,28,29,30,34,35,36,37,40);
         /*fonction niveau2*/
        $fn2 = array(3,41,45,42);
        /*fonction niveau2bis*/
        $fn2bis = array(10,41);
        /*fonction niveau3*/
        $fn3 = array(32,23,50,39);
        $this->view->fonction = $user->id_fonction;
        $this->view->listeallreference=$listeAllreference;
        $this->view->listeallcommercial=$listeAllcommercial;
        $this->view->listealltracking=$listeAlltracking;
        $this->view->listeallstatut=$listeAllstatut;
        $this->view->listeallclient=$listeAllclient;
        $this->view->listealluser=$listeAlluser;
        $this->view->infoUser = $infoUser;
        $this->view->fn0 = $fn0;
        $this->view->fn1 = $fn1;
        $this->view->fn2 = $fn2;
        $this->view->fn2bis = $fn2bis;
        $this->view->fn3 = $fn3;
        if($this->getRequest()->isPost()){
            $formData =  $this->getRequest()->getPost();
          echo '<pre>',  var_export($formData),'</pre>';
           $recherche = new Application_Model_DbTable_DemandeXprev();
           $newRecherche =$recherche->recherche($formData);     
        }
        else{    
        }
        
        $this->view->formData=$formData;
        $this->view->formdata=$newRecherche;
    }
    
    public function extractAction(){
        $this->_helper->layout->disableLayout();
        header('Content-type: text/csv');
        $formdata=$_POST;
        header('Content-Disposition: attachment; filename="extractXprev.csv"');
        $Xprev = new Application_Model_DbTable_DemandeXprev();
        $listXprev = $Xprev->extractxprev($formdata);
        
       echo '"'. str_replace(';', '";"',implode(';', array_keys($listXprev[0]))).'"' . PHP_EOL;
       foreach ($listXprev as $ligne) {
           echo '"'. str_replace(';', '";"', implode(';',  $ligne)).'"' . PHP_EOL;
       }
    }
}

