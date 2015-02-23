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
class Application_Model_DbTable_TempMovexOffre extends Zend_Db_Table_Abstract {
    protected $_name = 'temp_movex_offre';
    
    public function createInfo($numwp,$date,$userwp,$numwp_distributeur){
         $data = array(
            'reference_article' => $numwp,
            'code_article' => $date,
            'description_article' => $userwp,
             'numwp_distrib'=>$numwp_distributeur
        );
        $this->insert($data);
        return $this;
    
        
    }
}
