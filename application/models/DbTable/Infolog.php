<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_DbTable_Infolog extends Zend_Db_Table_Abstract {
    protected $_name = 'infolog';
    
    public function createinfolog($data){
        $this->insert($data);
        return $this;
    }
    public function getinfolog($tracking){
        $sql = "select * from infolog where tracking = '{$tracking}'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function updateinfolog($tracking,$id_infolog,$supplement){
        $sql = "update infolog set reponse_infolog ='\"{$supplement}\"  where tracking='{$tracking}' and id_infolog ={$id_infolog} ";
        $res = $this->getAdapter()->query($sql);
       
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
}