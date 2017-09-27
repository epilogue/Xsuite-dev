<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_DbTable_Infodop extends Zend_Db_Table_Abstract {
    protected $_name = 'infodop';
    
    public function createinfodop($data){
        $this->insert($data);
        return $this;
    }
    public function getinfodop($tracking){
        $sql = "select * from infodop where tracking = '{$tracking}'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function updateinfodop($tracking,$id_infodop,$supplement){
        $sql = "update infodop set reponse_infodop ='{$supplement}' where tracking='{$tracking}' and id_infodop ={$id_infodop} ";
        $res = $this->getAdapter()->query($sql);
       
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
}