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
    
    public function createArticle($numwp,$reference_article,$quantite,$prix_actuel_achat,$prix_achat_demande_distrib,$prix_achat_demande_client_final,$serie){
         $data = array(
           'numwp'                            => $numwp,
           'reference_article'                => $reference_article,
           'quantite'                         => $quantite,
           'prix_achat_actuel'                => $prix_actuel_achat,
           'prix_achat_demande_distrib'       => $prix_achat_demande_distrib,
           'prix_achat_demande_client_final'  => $prix_achat_demande_client_final,
             'serie'                          => $serie
        );
        $this->insert($data);
        return $this;   
    }
}
