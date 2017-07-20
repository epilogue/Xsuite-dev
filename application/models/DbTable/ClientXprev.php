<?php

class Application_Model_DbTable_ClientXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'client_xprev';
public function createclient($data){
       $this->insert($data);
        return $this;
   }
    public function lastId($tracking) {
        $sql = "select id_client_xprev from client_xprev where tracking = {$tracking};";
        
        $res = $this->getAdapter()->query($sql);
        $rest = $res->fetchObject();
          if (!$rest) {
            return null;
        } else {
            return $rest;
        }
        
    }
}
