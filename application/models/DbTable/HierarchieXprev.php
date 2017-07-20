<?php

class Application_Model_DbTable_HierarchieXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'hierarchie_xprev';

    public function getHierarchie($holon,$fonction){
        $sql= "select users.email_user,hierarchie_xprev.id_user from hierarchie_xprev join users on users.id_user = hierarchie_xprev.id_user where hierarchie_xprev.id_holon ={$holon} and hierarchie_xprev.id_fonction ={$fonction}";
        $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
     if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
