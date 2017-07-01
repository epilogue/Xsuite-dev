<?php

class Application_Model_DbTable_NiveauRisqueXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'niveau_risque_xprev';

    public function allniveaurisque(){
        $sql="select * from niveau_risque_xprev";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
