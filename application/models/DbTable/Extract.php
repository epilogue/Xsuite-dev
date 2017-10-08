<?php

class Application_Model_DbTable_Extract extends Zend_Db_Table_Abstract {

    protected $_name = 'extract_xprev';

    public function createextract($data){
       $this->insert($data);
        return $this;
   }
   
   public function upquantite($tracking,$code,$reference,$quantite){
       $sql = "update extract_xprev set quantite = $quantite where tracking like '{$tracking}' and code_article = $code and reference_article = $reference";
       $res = $this->getAdapter()->query($sql);
       
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
   }
}
