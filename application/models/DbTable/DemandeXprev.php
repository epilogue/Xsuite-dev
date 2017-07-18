<?php

class Application_Model_DbTable_DemandeXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_xprev';

    public function getdatetrack($date){
        $sql="SELECT count(id_demande_xprev) as c, date_create as d from demande_xprev where date_create={$date} group by date_create";
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
       var_dump($requestResult);
       if(!is_null($requestResult)){
        $letters = 'abcdefghijklmnopqrstuvwxyz';
    $date = DateTime::createFromFormat('Y-m-d', $requestResult['d']);
    $res = $date->format('Ymd');
    $nNum = $requestResult['c'];
    
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
}
