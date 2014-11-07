<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Xprice
 *
 * @author mag
 */
class Application_Model_Mapper_Xprices {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_DbTable_Abstract) {
            throw new Exception('Invalid table data gateway provided');
            $this->_dbTable = $dbTable;
            return $this;
        }
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTtable_Xprices');
        }
        return $this->_dbTable;
    }

    //put your code here
}
