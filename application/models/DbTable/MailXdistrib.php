<?php
class Application_Model_DbTable_MailXdistrib extends Zend_Db_Table_Abstract
{

    protected $_name = 'mail_xdistrib';


    public function createMailXdistrib($data){
        
        $this->insert($data);
        return $this;
    }
   public function getmail($tracking){
       $sql="select * from mail_xdistrib where mail_xdistrib.tracking_xdistrib like '{$tracking}'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
   }
}

