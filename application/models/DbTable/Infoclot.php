<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_DbTable_Infoclot extends Zend_Db_Table_Abstract {
    protected $_name = 'infoclot';
    
    public function createinfoclot($data){
        $this->insert($data);
        return $this;
    }
    public function getinfoclot($tracking){
        $sql = "select * from infoclot where tracking = '{$tracking}'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
}