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
class Application_Model_DbTable_TempClient extends Zend_Db_Table_Abstract {
   protected $_name = 'temp_client';
   
   public function createTemp($numwp,$numwp_client,$codepostal_client,$potentiel,$ville_client,$nom_industry,$id_industry,$nom_client){
      $data = array('numwp' =>$numwp,
          'numwp_client'=>$numwp_client,
          'codepostal_client'=>$codepostal_client,
          'potentiel'=>$potentiel,
          'ville_client'=>$ville_client,
          
          'nom_industry'=>$nom_industry,
          'id_industry'=>$id_industry,
          'nom_client'=>$nom_client);
       $this->insert($data);
        return $this;
   }
   public function truncateAll(){
       $query = "TRUNCATE TABLE temp_client,"
               . "TRUNCATE TABLE temp_fichier_contexte,"
               . "TRUNCATE TABLE temp_fichier_distrib_article,"
               . "TRUNCATE TABLE temp_fichier_distrib_info,"
               . "TRUNCATE TABLE temp_fichier_distrib_prix_concurrent,"
               . "TRUNCATE TABLE temp_movex_demande,temp_movex_distrib,"
               . "TRUNCATE TABLE temp_movex_offre ";
        $this->getAdapter()->query($query);
   }
    
}
