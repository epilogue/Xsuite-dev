<?php

class Application_Model_DbTable_HierarchieXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'hierarchie_xprev';

    public function getHierarchie($holon,$fonction){
        $sql= "select users.email_user,hierarchie.id_user from hierarchie_xprev join users on users.id_user = hierarchie.id_user where hierarchie.id_holon =$holon and hierarchie.id_fonction = $fonction";
        $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
     if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
