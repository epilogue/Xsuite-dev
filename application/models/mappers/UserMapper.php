<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserMapper
 *
 * @author mag
 */
class Application_Model_UserMapper {
    protected $_dbTable;
    
    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception ('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    
    public function getDbTable() {
        if(null === $this->_dbTable){
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }
}
