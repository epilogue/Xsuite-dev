<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempMovexOffre
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempMovexDistrib extends Zend_Db_Table_Abstract {
    protected $_name = 'temp_movex_distrib';
    
    public function createdistrib($numwp,$numwp_distributeur,$code_industry,$numwp_distributeur_10,$potentiel,$adresse){
         $data = array(
            'numwp' => $numwp,
             'numwp_distributeur'=>$numwp_distributeur,
             'code_industry'=>$code_industry,
             'numwp_distributeur_10'=>$numwp_distributeur_10,
             'potentiel'=>$potentiel,
             'adresse'=>$adresse
        );
        $this->insert($data);
        return $this;
    
        
    }
    
}
