<?php

class Application_Model_DbTable_Industry extends Zend_Db_Table_Abstract
{

    protected $_name = 'industry';
    
public function getMovexIndustry($industriewp) {
        $code_movex_industry = "$code_movex_industry";
        $row = $this->fetchRow('code_movex_industry like "'."{$industriewp}".'"');
        if(!$row){
            throw new Exception("could not find row $industriewp");
        }
        return $row->toArray();
    }

}

