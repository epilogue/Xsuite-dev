<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempFicherDistribPrixConcurrent
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempFicherDistribPrixConcurrent extends Zend_Db_Table_Abstract {
   
    protected $_name ='temp_fichier_distrib_prix_concurrent';
    
    public function createPrixConcurrent ($numwp,$concurrent,$reference_produit_conccurent,$prix_tarif_concurrent,$prix_spe_accorde_concurrent){
        $data = array(
            'numwp' =>$numwp,
            'concurrent'=>$concurrent,
            'reference_produit'=>$reference_produit_conccurent,
            'prix_tarif_concurrent' => $prix_tarif_concurrent,
            'prix_spe_accorde_concurrent' =>$prix_spe_accorde_concurrent
        );
         $this->insert($data);
        return $this;
    }
    public function getAll($numwp){
        $sql="select * from temp_fichier_distrib_prix_concurrent where temp_fichier_distrib_prix_concurrent.numwp = $numwp ";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
