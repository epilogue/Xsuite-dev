<?php

class Application_Model_DbTable_Validationsxprice extends Zend_Db_Table_Abstract
{

    protected $_name = 'validations_xprice';

public function createValidation($nom_validation,$date_validation,$etat_validation,$commentaire_validation,$id_user,$tracking_number){
    $data =array(
        'nom_validation'=>$nom_validation,
        'date_validation'=>$date_validation,
        'etat_validation'=>$etat_validation,
        'commentaire_validation'=>$commentaire_validation,
        'id_user'=>$id_user,
        'tracking_number_demande_xprice'=>$tracking_number);
     $this->insert($data);
        return $this;
}
public function getValidation($nom_validation,$tracking_number) {
     $nom_validation = "$nom_validation";
        $tracking_number = "$tracking_number";
        $plop = $this->getAdapter();
       
        $where = $plop->quoteInto('nom_validation = ?',$nom_validation)
                . $plop->quoteInto('And tracking_number_demande_xprice = ?', $tracking_number);
       $plop2= $this->fetchAll($where);
        return $plop2->toArray();
}
public function getAllValidation($tracking_number){
    $tracking_number="$tracking_number";
     $rows = $this->fetchAll("tracking_number_demande_xprice = '{$tracking_number}'");
        if (!$rows) {
            return null;
        } else {
            return $rows->toArray();
        }
}
}

