<?php

class Application_Model_DbTable_DemandeXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_xprev';

    public function getdatetrack($date){
        $sql="SELECT count(id_demande_xprev) as c, date_create as d from demande_xprev where date_create='{$date}' group by date_create";
         //var_dump($sql);
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
       // var_dump($rest);
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function recherche($formdata){
       // var_dump($formdata);
        $sql ="select distinct(demande_article_xprev.tracking),demande_xprev.id_demande_xprev,demande_xprev.date_create,(commercial.nom_user) as nom_commercial,(emetteur.nom_user) as nom_emetteur,client_user_xprev.nom_client_user_xprev,statut_xprev.nom_statut_xprev,designation_validation_xprev.nom_validation_xprev from demande_xprev "
                . "left join users as commercial on commercial.id_user = demande_xprev.id_commercial "
                . "left join users as emetteur  on emetteur.id_user = demande_xprev.id_users "
                . "left join statut_xprev on statut_xprev.id_statut_xprev = demande_xprev.id_statut_xprev "
                . "left join client_user_xprev on client_user_xprev.id_client_user_xprev = demande_xprev.id_client_user_xprev "
                . "left join demande_article_xprev on demande_article_xprev.tracking = demande_xprev.tracking "
                 . " join designation_validation_xprev  on designation_validation_xprev.id_designation_validation_xprev = demande_xprev.id_validation "
                . "where 1";
        $sqlsuite="";
        $sqlsuite2="";
        
       
        if(empty($sqlsuite) and !empty($formdata['nom_client'])){
                $sqlsuite.=" and client_user_xprev.code_client_users_xprev ='{$formdata['nom_client']}'";
            }
        if(empty($sqlsuite) and !empty($formdata['nom_statut'])){
                $sqlsuite.=" and  demande_xprev.id_statut_xprev='{$formdata['nom_statut']}'";
            }
        if (empty($sqlsuite) and !empty($formdata['tracking'])) {
                $sqlsuite.=" and  demande_xprev.tracking='{$formdata['tracking']}'";
            }
        if(empty($sqlsuite) and !empty($formdata['date_createdeb_prev']) && !empty($formdata['date_createfin_prev'])) {
            
            $datedeb1= explode('-',$formdata['date_createdeb_prev']);
            $datefin1= explode('-',$formdata['date_createfin_prev']);
            $datedeb= $datedeb1[2]."-".$datedeb1[1]."-".$datedeb1[0];
            $datefin=$datefin1[2]."-".$datefin1[1]."-".$datefin1[0];
            $sqlsuite .= " and demande_xprev.date_create between str_to_date('{$datedeb}' ,'%Y-%m-%d') and str_to_date('{$datefin}','%Y-%m-%d') ";
        }
        if(empty($sqlsuite) and !empty($formdata['date_findeb_prev']) && !empty($formdata['date_finfin_prev'])) {
            
            $datedeb1= explode('-',$formdata['date_findeb_prev']);
            $datefin1= explode('-',$formdata['date_finfin_prev']);
            $datedeb= $datedeb1[2]."-".$datedeb1[1]."-".$datedeb1[0];
            $datefin=$datefin1[2]."-".$datefin1[1]."-".$datefin1[0];
            $sqlsuite .= " and demande_xprev.date_fin between str_to_date('{$datedeb}' ,'%Y-%m-%d') and str_to_date('{$datefin}','%Y-%m-%d') ";
        }
        if (empty($sqlsuite) and !empty($formdata['reference'])) {
            $sqlsuite.=" and  demande_article_xprev.reference_article='{$formdata['reference']}'";
        }
        if(empty($sqlsuite) and !empty($formdata['nom_commercial'])){
            $sqlsuite.=" and  demande_xprev.id_commercial='{$formdata['nom_commercial']}'";
        }
        if(empty($sqlsuite) and !empty($formdata['nom_emetteur'])){
            $sqlsuite.=" and  demande_xprev.id_users='{$formdata['nom_emmetteur']}'";
        }
        if(!empty($sqlsuite) and !empty($formdata['nom_client'])){
                $sqlsuite2.=" or client_user_xprev.code_client_users_xprev ='{$formdata['nom_client']}'";
            }
        if(!empty($sqlsuite) and !empty($formdata['nom_statut'])){
                $sqlsuite2.=" or  demande_xprev.id_statut_xprev='{$formdata['nom_statut']}'";
            }
        if (!empty($sqlsuite) and !empty($formdata['tracking'])) {
                $sqlsuite2.=" or  demande_xprev.tracking='{$formdata['tracking']}'";
            }
        if(!empty($sqlsuite) and !empty($formdata['date_createdeb_prev']) && !empty($formdata['date_createfin_prev'])) {
            
            $datedeb1= explode('-',$formdata['date_createdeb_prev']);
            $datefin1= explode('-',$formdata['date_createfin_prev']);
            $datedeb= $datedeb1[2]."-".$datedeb1[1]."-".$datedeb1[0];
            $datefin=$datefin1[2]."-".$datefin1[1]."-".$datefin1[0];
            $sqlsuite2 .= " or demande_xprev.date_create between str_to_date('{$datedeb}' ,'%Y-%m-%d') and str_to_date('{$datefin}','%Y-%m-%d') ";
        }
        if(!empty($sqlsuite) and !empty($formdata['date_findeb_prev']) && !empty($formdata['date_finfin_prev'])) {
            
            $datedeb1= explode('-',$formdata['date_findeb_prev']);
            $datefin1= explode('-',$formdata['date_finfin_prev']);
            $datedeb= $datedeb1[2]."-".$datedeb1[1]."-".$datedeb1[0];
            $datefin=$datefin1[2]."-".$datefin1[1]."-".$datefin1[0];
            $sqlsuite2 .= " or demande_xprev.date_fin between str_to_date('{$datedeb}' ,'%Y-%m-%d') and str_to_date('{$datefin}','%Y-%m-%d') ";
        }
        if (!empty($sqlsuite) and !empty($formdata['reference'])) {
            $sqlsuite2.=" or demande_article_xprev.reference_article='{$formdata['reference']}'";
        }
        if(!empty($sqlsuite) and !empty($formdata['nom_commercial'])){
            $sqlsuite2.=" or  demande_xprev.id_commercial='{$formdata['nom_commercial']}'";
        }
         //var_dump($sqlsuite);
         //var_dump($sqlsuite2);
         $sql.=$sqlsuite;
        
        $sql.=$sqlsuite2;
        var_dump($sql);
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public static function makeTrackingNumber($requestResult) {
       /*dabord choisr la date de debut
        * commencer l'incrementation a A et la poursuivre  si la date et toujours la meme/ par rapport a la date precedemment insereee
        * si la date du jour et superieur a la date precedemment alors reprendre l'incrementation a A si la date et la meme poursuivre l'incrementation alphabet
        */
       // echo 'plop <br > ';
       //var_dump($requestResult);
       if(!is_null($requestResult)){
        $letters = 'abcdefghijklmnopqrstuvwxyz';
    $date = DateTime::createFromFormat('Y-m-d', $requestResult[0]['d']);
    $res = $date->format('Ymd');
    $nNum = $requestResult[0]['c'];
    
    do {
        if($nNum > 25) {
            $res .= strtoupper($letters[25]);
            $nNum -= 25;
        } else {
            $res .= strtoupper($letters[$nNum]);
            $nNum = 0;
        }
    } while ($nNum > 0);
       } else {
           $date=new DateTime();
           $res = $date->format('Ymd');
           $res .="A";
       }
    $track = "PV-".$res;
    
    return $track;
    }
    public function getAllcodeclient() {
       $sql="select distinct(code_client), nom_client from baseclient where baseclient.code_client like '%0000' or baseclient.code_client like '%XXXX'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
public function getAllcodeuser($code_client) {
       $sql="select * from baseclient where baseclient.code_client like '{$code_client}%'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function createDemande($data) {
      $this->insert($data);
        return $this;
    }
    
    public function getuserxprev($id_user){
        $sql="select demande_xprev.tracking,demande_xprev.date_create,users.nom_user,(commercial.nom_user)as nom_commercial,designation_validation_xprev.nom_validation_xprev,client_user_xprev.nom_client_user_xprev from demande_xprev "
                . " join users on users.id_user = demande_xprev.id_users "
                . " join users as commercial on commercial.id_user = demande_xprev.id_commercial "
                . " join client_user_xprev on client_user_xprev.id_client_user_xprev=demande_xprev.id_client_user_xprev "
                . " join designation_validation_xprev  on designation_validation_xprev.id_designation_validation_xprev = demande_xprev.id_validation "
                . " where demande_xprev.id_users = {$id_user}";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function getusern1xprev($id_holon){
        $sql="select demande_xprev.tracking,demande_xprev.date_create,users.id_user,users.nom_user,(commercial.nom_user)as nom_commercial,designation_validation_xprev.nom_validation_xprev,client_user_xprev.nom_client_user_xprev from demande_xprev "
                . " join users on users.id_user = demande_xprev.id_users "
                . " join users as commercial on commercial.id_user = demande_xprev.id_commercial "
                . " join client_user_xprev on client_user_xprev.id_client_user_xprev=demande_xprev.id_client_user_xprev "
                . " join designation_validation_xprev  on designation_validation_xprev.id_designation_validation_xprev = demande_xprev.id_validation "
                . " where users.id_holon = {$id_holon}";
                $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
     public function getuserregxprev($holon_court){
        $sql="select demande_xprev.tracking,demande_xprev.date_create,users.nom_user,(commercial.nom_user)as nom_commercial,designation_validation_xprev.nom_validation_xprev,client_user_xprev.nom_client_user_xprev from demande_xprev "
                . " join users on users.id_user = demande_xprev.id_users "
                . " join users as commercial on commercial.id_user = demande_xprev.id_commercial "
                . " join holons on holons.id_holon=users.id_holon "
                . " join client_user_xprev on client_user_xprev.id_client_user_xprev=demande_xprev.id_client_user_xprev "
                . " join designation_validation_xprev  on designation_validation_xprev.id_designation_validation_xprev = demande_xprev.id_validation "
                . " where holons.nom_holon like '{$holon_court}%'";
       // var_dump($sql);
                $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function getallxprev(){
        $sql="select demande_xprev.tracking,demande_xprev.date_create,users.nom_user,(commercial.nom_user)as nom_commercial,designation_validation_xprev.nom_validation_xprev,client_user_xprev.nom_client_user_xprev from demande_xprev "
                . " join users on users.id_user = demande_xprev.id_users "
                . " join users as commercial on commercial.id_user = demande_xprev.id_commercial "
                . " join client_user_xprev on client_user_xprev.id_client_user_xprev=demande_xprev.id_client_user_xprev "
                . " join designation_validation_xprev  on designation_validation_xprev.id_designation_validation_xprev = demande_xprev.id_validation ";
               
                $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function getprev($tracking){
        $sql="select "
                . " demande_xprev.tracking,"
                . "demande_xprev.date_create,"
                . "demande_xprev.justification,"
                . "demande_xprev.justification_n1,"
                . "demande_xprev.justification_dop,"
                . "demande_xprev.justification_log,"
                . "demande_xprev.justification_supp,"
                . "demande_xprev.justification_traitement,"
                . "demande_xprev.justification_cloture,"
                . "users.nom_user, "
                . "(commercial.nom_user)as nom_commercial, "
                . "users.id_user, "
                . "(users.email_user) as email_emetteur ,"
                . "(commercial.id_user)as id_commercial,"
                . "designation_validation_xprev.nom_validation_xprev,"
                . "client_user_xprev.nom_client_user_xprev,"
                . "client_user_xprev.code_client_users_xprev,"
                . "niveau_risque_xprev.nom_risque_xprev,"
                . "type_demande_xprev.nom_type_demande_xprev,"
                . "client_xprev.nom_client_xprev,"
                . "client_xprev.code_user_client_xprev,"
                . "demande_xprev.date_fin, "
                . "demande_xprev.date_debut "
                . " from demande_xprev "
                . " join client_xprev on client_xprev.id_client_xprev = demande_xprev.id_client_xprev "
                . " join users on users.id_user = demande_xprev.id_users "
                . " join niveau_risque_xprev on niveau_risque_xprev.id_niveau_risque_xprev = demande_xprev.id_niveau_risque_xprev "
                . " join type_demande_xprev on type_demande_xprev.id_type_demande_xprev = demande_xprev.id_type_demande_xprev "
                . " join users as commercial on commercial.id_user = demande_xprev.id_commercial "
                . " join holons on holons.id_holon=users.id_holon "
                . " join client_user_xprev on client_user_xprev.id_client_user_xprev=demande_xprev.id_client_user_xprev "
                . " join designation_validation_xprev  on designation_validation_xprev.id_designation_validation_xprev = demande_xprev.id_validation "
                . " where demande_xprev.tracking like '{$tracking}' ";
        //var_dump($sql);
                $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function  upn1xprev($statut,$validation,$justification,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_n1`=\"{$justification}\" WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    public function  uplogxprev($statut,$validation,$justification,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_log`=\"{$justification}\" WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    public function  updopxprev($statut,$validation,$justification,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_dop`=\"{$justification}\"  WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    public function  upsuppxprev($statut,$validation,$justification,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_supp`=\"{$justification}\"  WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    
    public function  upcommercial($id_commercial,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_commercial`='{$id_commercial}' WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    
    public function  uptraitementxprev($statut,$validation,$justification,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_traitement`=\"{$justification}\" WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    public function getAlltracking(){
        $sql="select tracking, id_demande_xprev from demande_xprev";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
    public function extractxprev($formdata){
        $sql=" (demande_xprev.tracking) as tracking, "
                . " (commercial.nom_user) as commercial, "
                . " (demande_article_xprev.code_article) as NO_PRODUIT, "
                . " (demande_article_xprev.reference_article) as REF_PRODUIT, "
                . " (demande_xprev.date_create) as date_creation, "
                . " (demande_xprev.date_fin) as fin_de_validite, "
                . " (statut_xprev.nom_statut_xprev) as statut_prevision "
                . " (client_user_xprev.code_client_users_xprev) as code_client, "
                . " (client_user_xprev.nom_client_user_xprev) as nom client,"
                . "demande_article_xprev.m1, "
                . "demande_article_xprev.m2, "
                . "demande_article_xprev.m3, "
                . "demande_article_xprev.m4, "
                . "demande_article_xprev.m5, "
                . "demande_article_xprev.m6, "
                . "demande_article_xprev.m7, "
                . "demande_article_xprev.m8, "
                . "demande_article_xprev.m9, "
                . "demande_article_xprev.m10, "
                . "demande_article_xprev.m11, "
                . "demande_article_xprev.m12, "
                . "demande_xprev.date_debut "
                . " from demande.xprev "
                . " left join users as commercial on commercial.id_user = demande_xprev.id_commercial "
                . " left join demande_article_xprev on demande_article_xprev.tracking =demande_xprev.tracking "
                . " left join statut_xprev on statut_xprev.id_statut_xprev= demandexprev.id_statut_xprev "
                . " left join client_user_xprev on client_user_xprev.id_client_user_xprev=demande_xprev.id_client_user_xprev  "
                . " where 1";
        $sqlsuite="";
         if(!empty($formdata['nom_client'])){
                $sqlsuite.=" and client_user_xprev.code_client_users_xprev ='{$formdata['nom_client']}'";
            }
        if(!empty($formdata['nom_statut'])){
                $sqlsuite.=" and  demande_xprev.id_statut_xprev='{$formdata['nom_statut']}'";
            }
        if (!empty($formdata['tracking'])) {
                $sqlsuite.=" and  demande_xprev.tracking='{$formdata['tracking']}'";
            }
        if(!empty($formdata['date_createdeb_prev']) && !empty($formdata['date_createfin_prev'])) {
            
            $datedeb1= explode('-',$formdata['date_createdeb_prev']);
            $datefin1= explode('-',$formdata['date_createfin_prev']);
            $datedeb= $datedeb1[2]."-".$datedeb1[1]."-".$datedeb1[0];
            $datefin=$datefin1[2]."-".$datefin1[1]."-".$datefin1[0];
            $sqlsuite .= " and demande_xprev.date_create between str_to_date('{$datedeb}' ,'%Y-%m-%d') and str_to_date('{$datefin}','%Y-%m-%d') ";
        }
        if(!empty($formdata['date_findeb_prev']) && !empty($formdata['date_finfin_prev'])) {
            
            $datedeb1= explode('-',$formdata['date_findeb_prev']);
            $datefin1= explode('-',$formdata['date_finfin_prev']);
            $datedeb= $datedeb1[2]."-".$datedeb1[1]."-".$datedeb1[0];
            $datefin=$datefin1[2]."-".$datefin1[1]."-".$datefin1[0];
            $sqlsuite .= " and demande_xprev.date_fin between str_to_date('{$datedeb}' ,'%Y-%m-%d') and str_to_date('{$datefin}','%Y-%m-%d') ";
        }
        if (!empty($formdata['reference'])) {
            $sqlsuite.=" and  demande_article_xprev.reference_article='{$formdata['reference']}'";
        }
        if(!empty($formdata['nom_commercial'])){
            $sqlsuite.=" and  demande_xprev.id_commercial='{$formdata['nom_commercial']}'";
        }
        if(!empty($formdata['nom_emetteur'])){
            $sqlsuite.=" and  demande_xprev.id_users='{$formdata['nom_emmetteur']}'";
        }
          $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
