<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempFichierDistribArticle
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempFichierDistribArticle extends Zend_Db_Table_Abstract {
   
    protected $_name ='temp_fichier_distrib_article';
    
    public function createArticle(){
         $data = array(
           ''                   ,
           ''                 ,
           ''      ,
           ''          ,
           ''     ,
           ''        ,
           ''     ,
           '' ,
           'ville_client_final'      =>  $ville_client,
           'potentiel_client_final'  =>  $potentiel_client_final
        );
        $this->insert($data);
        return $this;   
    }
}
