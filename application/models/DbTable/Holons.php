<?php

class Application_Model_DbTable_Holons extends Zend_Db_Table_Abstract
{

    protected $_name = 'holons';

public function getHolon($id_holon) {
        $id_holon =(int)$id_holon;
        $row = $this->fetchRow('id_holon='.$id_holon);
        if(!$row){
            throw new Exception ("could not find row $id_holon");
        }
        return $row->toArray();
    }
    public function allHolon(){
        $sql="select * from holons";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}

