<?php

class Application_Model_DbTable_Clients extends Zend_Db_Table_Abstract {

    protected $_name = 'clients';

    public function getClientnumwp($numwp_client) {
       $sql="select * from clients where clients.numwp_client='{$numwp_client}'";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }

    public function createClient($nom_client, $numwp_client, $adresse_client, $id_industry,$potentiel) {
        $data = array(
            'nom_client' => $nom_client,
            'numwp_client' => $numwp_client,
            'adresse_client' => $adresse_client,
            'id_industry' => $id_industry,
            'potentiel' => $potentiel
        );
        $this->insert($data);
        return $this;
    }
public function rechercheClient() {
       $sql="select distinct(numwp_client),nom_client from clients";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}

