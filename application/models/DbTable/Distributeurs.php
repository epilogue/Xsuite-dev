<?php

class Application_Model_DbTable_Distributeurs extends Zend_Db_Table_Abstract {

    protected $_name = 'distributeurs';

    public function getDistributeurnumwp($numwp) {
        $numwp= "$numwp";
        $row = $this->fetchRow("num_workplace_demande_xdistrib= '{$numwp}'");
        if (!$row) {
            //throw new Exception("could not find row $numwp_distributeur");
            return null;
        } else {
            return $row->toArray();
        }
    }

    public function createDistributeur($nom_distributeur,$contact_distributeur, $numwp_distributeur,$agence_distributeur, $code_postal_distributeur,$id_industry,$potentiel,$numwp) {
        $data = array(
            'nom_distributeur' => $nom_distributeur,
            'contact_distributeur' => $contact_distributeur,
            'numwp_distributeur' => $numwp_distributeur,
            'agence_distributeur' => $agence_distributeur,
            'code_postal_distributeur' => $code_postal_distributeur,
            'id_industry' => $id_industry,
            'potentiel' => $potentiel,
            'num_workplace_demande_xdistrib'=>$numwp
        );
        $this->insert($data);
         //echo $this->insert($data);
        return $this;
       
    }

}

