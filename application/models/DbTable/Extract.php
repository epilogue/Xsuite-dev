<?php

class Application_Model_DbTable_Extract extends Zend_Db_Table_Abstract {

    protected $_name = 'extract_xprev';

    public function createextract($data){
       $this->insert($data);
        return $this;
   }
}
