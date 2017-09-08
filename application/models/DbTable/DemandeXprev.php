<?php

class Application_Model_DbTable_DemandeXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_xprev';

    public function getdatetrack($date){
        $sql="SELECT count(id_demande_xprev) as c, date_create as d from demande_xprev where date_create='{$date}' group by date_create";
         var_dump($sql);
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        var_dump($rest);
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
        $sql="select demande_xprev.tracking,demande_xprev.date_create,users.nom_user,(commercial.nom_user)as nom_commercial,designation_validation_xprev.nom_validation_xprev,client_user_xprev.nom_client_user_xprev from demande_xprev "
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
                . "users.nom_user,(commercial.nom_user)as nom_commercial,"
                . "users.id_user,(commercial.id_user)as id_commercial,"
                . "designation_validation_xprev.nom_validation_xprev,"
                . "client_user_xprev.nom_client_user_xprev,"
                . "client_user_xprev.code_client_users_xprev,"
                . "niveau_risque_xprev.nom_risque_xprev,"
                . "type_demande_xprev.nom_type_demande_xprev,"
                . "client_xprev.nom_client_xprev,"
                . "client_xprev.code_user_client_xprev,"
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
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_n1`='{$justification}' WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    public function  uplogxprev($statut,$validation,$justification,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_log`='{$justification}' WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    public function  updopxprev($statut,$validation,$justification,$tracking){
        $sql ="UPDATE `demande_xprev` SET `id_validation`='{$validation}',  `id_statut_xprev`='{$statut}', `justification_dop`='{$justification}' WHERE  `tracking`='{$tracking}'";
//         var_dump($sql); exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
}
