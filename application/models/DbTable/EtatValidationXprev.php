<?php

class Application_Model_DbTable_EtatValidationXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'etat_validation_xprev';

    public function getEtat($id_etat) {
        $row = $this->fetchRow("id_etat_validation_xprev =$id_etat");
       
        if(!$row){
            throw new Exception("etat introuvable");
        }
        return $row->toArray();
    }
    
}
