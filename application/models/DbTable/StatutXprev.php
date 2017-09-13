<?php

class Application_Model_DbTable_StatutXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'statut_xprev';

    public function getAllStatut(){
        $sql="select nom_statut_xprev,id_statut_xprev from statut_xprev";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
