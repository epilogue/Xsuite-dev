<?php

class Application_Model_DbTable_DemandeXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_xprev';

    public static function makeTrackingNumber($date) {
       /*dabord choisr la date de debut
        * commencer l'incrementation a A et la poursuivre  si la date et toujours la meme/ par rapport a la date precedemment insereee
        * si la date du jour et superieur a la date precedemment alors reprendre l'incrementation a A si la date et la meme poursuivre l'incrementation alphabet
        */
        $date_initiale = new date('05-07-2017');
        $date_create =$date ;
        return "PV-";
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
