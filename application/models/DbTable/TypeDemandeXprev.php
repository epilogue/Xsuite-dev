<?php

class Application_Model_DbTable_TypeDemandeXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'type_demande_xprev';

    public function alltypedemande(){
        $sql="select * from type_demande_xprev";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
