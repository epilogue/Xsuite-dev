<?php

class Application_Model_DbTable_Distributeurs extends Zend_Db_Table_Abstract {

    protected $_name = 'distributeurs';

    public function getDistributeurnumwp($numwp_distributeur) {
        $numwp_distributeur = "$numwp_distributeur";
        $row = $this->fetchRow("numwp_distributeur = '{$numwp_distributeur}'");
        if (!$row) {
            //throw new Exception("could not find row $numwp_distributeur");
            return null;
        } else {
            return $row->toArray();
        }
    }

    public function createClient($nom_distributeur, $prenom_distributeur, $numwp_distributeur, $adresse_distributeur, $id_industry,$potentiel) {
        $data = array(
            'nom_distributeur' => $nom_distributeur,
            'prenom_disributeur' =>$prenom_distributeur,
            'numwp_distributeur' => $numwp_distributeur,
            'adresse_distributeur' => $adresse_distributeur,
            'id_industry' => $id_industry,
            'potentiel' =>$potentiel
        );
        $this->insert($data);
        return $this;
    }

}

