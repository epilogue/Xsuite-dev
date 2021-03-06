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
       $sql="select distinct(numwp_client),nom_client from clients order by nom_client ASC";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheRGCClient($id_user){
        $sql = "select distinct(clients.numwp_client),clients.nom_client from clients "
                . " join  demande_xprices on demande_xprices.numwp_client = clients.numwp_client "
                . " where demande_xprices.id_user=$id_user";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheDDLEADClient($holon){
        $sql = "select distinct(clients.numwp_client), clients.nom_client from clients "
                . " join demande_xprices on demande_xprices.numwp_client = clients.numwp_client "
                . " join users on users.id_user = demande_xprices.id_user "
                . "where users.id_holon = $holon";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
    public function rechercheRCDClient($likeholon){
        $sql ="select distinct(clients.numwp_client), clients.nom_client from clients "
                . " join demande_xprices on demande_xprices.numwp_client= clients.numwp_client "
                . " join users on users.id_user=demande_xprices.id_user "
                . " where users.id_holon in (".implode(',', $likeholon).")";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheITCClient($id_user){
        $sql = "select distinct(clients.numwp_client),clients.nom_client from clients "
                . " join  demande_xprices on demande_xprices.numwp_client = clients.numwp_client "
                . " where demande_xprices.id_user=$id_user";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}

