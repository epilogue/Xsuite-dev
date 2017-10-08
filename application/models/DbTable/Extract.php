<?php

class Application_Model_DbTable_Extract extends Zend_Db_Table_Abstract {

    protected $_name = 'extract_xprev';

    public function createextract($data){
       $this->insert($data);
        return $this;
   }
   
   public function upquantite($tracking,$code,$quantite){
       $sql = "update extract_xprev set quantite = $quantite ,set code_article= '{$code}' where tracking like '{$tracking}'";
       $res = $this->getAdapter()->query($sql);
       
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
   }
}
