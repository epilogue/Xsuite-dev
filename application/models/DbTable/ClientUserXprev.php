<?php

class Application_Model_DbTable_ClientUserXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'client_user_xprev';

   public function createclientuser($data){
       $this->insert($data);
        return $this;
   }
   
    public function lastId($tracking) {
        $sql = "select id_client_user_xprev from client_user_xprev where tracking ='{$tracking}'";
        
        $res = $this->getAdapter()->query($sql);
        $rest = $res->fetchObject();
          if (!$rest) {
            return null;
        } else {
            return $rest;
        }
        
    }
}
