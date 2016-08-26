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
public function rechercheDistributeur() {
       $sql="select distinct(numwp_distributeur),nom_distributeur from distributeurs order by nom_distributeur ASC";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
//        var_dump($sql);
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheRGCDistributeur($id_user){
        $sql = "select distinct(distributeurs.numwp_distributeur),distributeurs.nom_distributeurs from distributeurs "
                . " join  demande_xdistrib on demande_xdistrib.numwp_distributeur = distributeurs.numwp_distributeur"
                . " where demande_xdistrib.id_user=$id_user";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
     public function rechercheDDLEADDistributeur($holon){
        $sql = "select distinct(distributeurs.numwp_distributeur), distributeurs.nom_distributeur from distributeurs "
                . " join demande_xdistrib on demande_xdistrib.numwp_distributeur = distributeurs.numwp_distributeur "
                . " join users on users.id_user = demande_xdistrib.id_user "
                . "where users.id_holon = $holon";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
     public function rechercheRCDDistributeur($likeholon){
        $sql ="select distinct(distributeurs.numwp_distributeur), distributeurs.nom_distributeur from distributeurs "
                . " join demande_xdistrib on demande_xdistrib.numwp_distributeur= distributeurs.numwp_distributeur "
                . " join users on users.id_user=demande_xdistrib.id_user "
                . " where users.id_holon in (".implode(',', $likeholon).")";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheITCDistributeur($id_user){
        $sql = "select distinct(distributeurs.numwp_distributeur),distributeurs.nom_distributeur from distributeurs "
                . " join  demande_xdistrib on demande_xdistrib.numwp_distributeur = distributeurs.numwp_distributeur "
                . " where demande_xdistrib.id_user=$id_user";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}

