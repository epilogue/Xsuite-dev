<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempFichierContexte
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempFichierContexte extends Zend_Db_Table_Abstract {
   
    protected $_name ='temp_fichier_contexte';
    
    public function createContexte ($numwp,$contexte_demande,$services_associes){
        $data = array(
            'numwp' =>$numwp,
            'contexte_demande'=>$contexte_demande,
            'services_associes'=>$services_associes
        );
         $this->insert($data);
        return $this;
    }
     public function getAll($numwp){
        $sql="select * from temp_fichier_contexte where temp_fichier_contexte.numwp = $numwp ";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    //put your code here
}
    //put your code here

