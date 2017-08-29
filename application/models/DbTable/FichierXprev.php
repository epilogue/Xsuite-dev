<?php

class Application_Model_DbTable_FichierXprev extends Zend_Db_Table_Abstract
{

    protected $_name = 'fichier_xprev';


    public function createFichierXprev($data){
        
        $this->insert($data);
        return $this;
    }
   public function getfichier($tracking){
       $sql="select from fichier_xprev where fichier_xprev.tracking_xprev like '{$tracking}'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
   }
}

