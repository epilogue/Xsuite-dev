<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempClient
 *
 * @author frhubym
 */
class Application_Model_DbTable_ClientDistrib extends Zend_Db_Table_Abstract {
   protected $_name = 'client_distrib';
   
   public function createClientDistrib($numwp,$numwp_client,$codepostal_client,$potentiel,$ville_client,$nom_industry,$id_industry,$nom_client,$client_pac=null){
      $data = array('numwp' =>$numwp,
          'numwp_client'=>$numwp_client,
          'codepostal_client'=>$codepostal_client,
          'potentiel'=>$potentiel,
          'ville_client'=>$ville_client,
          'nom_industry'=>$nom_industry,
          'id_industry'=>$id_industry,
          'nom_client'=>$nom_client,
          'client_pac'=>$client_pac);
       $this->insert($data);
        return $this;
   }   
   public function updateClientDistrib($client_pac){
    

}
}

