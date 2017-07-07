<?php

class Application_Model_DbTable_FichierXprev extends Zend_Db_Table_Abstract
{

    protected $_name = 'fichier_xprev';


    public function createFichierXprev($data){
        
        $this->insert($data);
        return $this;
    }
   
}

