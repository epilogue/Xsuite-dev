<?php

class Application_Model_DbTable_DemandeXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_xprev';

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