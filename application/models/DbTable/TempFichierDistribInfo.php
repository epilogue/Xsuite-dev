<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempFichierDistribInfo extends Zend_Db_Table_Abstract{
    protected $_name='temp_fichier_distrib_info';
    
    public function createInfo($numwp,$nom_distrib,$code_postal_distributeur,$ville_distributeur,$nom_contact,$nom_client,$numwp_client,$code_postal_client,$ville_client){
         $data = array(
           'numwp'                   =>  $numwp,
           'distrib'                 =>  $nom_distrib,
           'codepostal_distrib'      =>  $code_postal_distributeur,
           'ville_distrib'           =>  $ville_distributeur,
           'nom_contact_distrib'     =>  $nom_contact,
           'nom_client_final'        =>  $nom_client,
           'numwp_client_final'      =>  $numwp_client,
           'codepostal_client_final' =>  $code_postal_client,
           'ville_client_final'      =>  $ville_client
        );
        $this->insert($data);
        return $this;   
    }
}
