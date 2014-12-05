<?php
/**
 * Description of HistoriqueCommentaire
 *
 * @author frhubym
 */

class Application_Model_DbTable_HistoriqueCommentaire extends Zend_Db_Table_Abstract
{

    protected $_name = 'historique_commentaire';

public function createHistorique($id_validation,$id_user,$commentaire_reponse,$tracking_number){
    $data =array(
        'id_validation'=>$nom_validation,
        'id_user'=>$id_user,
        'commentaire_reponse'=>$commentaire_reponse,
             'tracking_number'=>$tracking_number);
     $this->insert($data);
        return $this;
}
public function getHistorique($id_histo_commentaire,$id_validation,$tracking_number) {
     
        $plop = $this->getAdapter();
       
        $where = $plop->quoteInto()
                . $plop->quoteInto();
       $plop2= $this->fetchAll($where);
        return $plop2->toArray();
}
}
