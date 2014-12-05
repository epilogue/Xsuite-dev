<?php
/**
 * Description of HistoriqueCommentaire
 *
 * @author frhubym
 */

class Application_Model_DbTable_HistoriqueCommentaire extends Zend_Db_Table_Abstract
{

    protected $_name = 'historique_commentaire';

public function createHistorique($tracking_number,$id_validation,$id_user,$commentaire_reponse){
    $data =array('tracking_number'=>$tracking_number,
        'id_validation'=>$id_validation,
        'id_user'=>$id_user,
        'commentaire_reponse'=>$commentaire_reponse
             );
     $this->insert($data);
        return $this;
}
public function getHistorique($tracking_number,$id_validation) {
     
        $plop = $this->getAdapter();
       
        $where = $plop->quoteInto('tracking_number =?',$tracking_number)
                . $plop->quoteInto('and id_validation = ?',$id_validation);
       $plop2= $this->fetchAll($where);
        return $plop2->toArray();
}
}
