<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempMovexDemande
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempMovexDemande extends Zend_Db_Table_Abstract {
    protected $_name = 'temp_movex_demande';
    
    function createDemandeTemp($code_article,$reference_article,$prix_tarif,$prix_demande,$remise_demande,$numwp,$code_acquisition,$prix_fob,$prix_cif){
        $data=array(
            'code_article'=>$code_article,
            'reference_article'=>$reference_article,
            'prix_tarif'=>$prix_tarif,
            'prix_demande'=>$prix_demande,
            'remise_demande'=>$remise_demande,
            'numwp'=>$numwp,
            'code_acquisition'=>$code_acquisition,
            'prix_fob'=>$prix_fob,
            'prix_cif'=>$prix_cif);
        
        $this->insert($data);
        return $this;   
    }
    //put your code here
}
