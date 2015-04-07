<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Xdistrib
 *
 * @author frhubym
 */
class Application_Model_DbTable_Xdistrib extends Zend_Db_Table_Abstract {
     protected $_name = 'demande_xdistrib';
    public static function makeTrackingNumber($zone, $nombre) {
        $annee = 'T';
        // @todo générer l'année
        // construction du nombre
        $baseNombre = "00000";
        $grandNombre = "{$baseNombre}{$nombre}";
        $nombre = substr($grandNombre, strlen("{$nombre}"));
        return "SPD-FR-{$zone}{$annee}{$nombre}";
    }
     public function getNumwp($numwp) {
        $numwp = "$numwp";
        $row = $this->fetchRow("num_workplace_demande_xdistrib = '{$numwp}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }
     public function getTracking($tracking_number) {
        $tracking_number = "$tracking_number";
        $row = $this->fetchRow("tracking_number_demande_xdistrib = '{$tracking_number}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }
    public function createXDistrib($num_workplace_demande_xdistrib, $tracking_number_demande_xdistrib,$contexte_demande, $date_demande_xdistrib, $service_associe, $id_user,$id_dd, $id_validation = null, $numwp_client,$numwp_distributeur) {
        $data = array(
            'num_workplace_demande_xdistrib' => $num_workplace_demande_xdistrib,
            'tracking_number_demande_xdistrib' => $tracking_number_demande_xdistrib,
            'contexte_demande'=>$contexte_demande,
            'date_demande_xdistrib' => $date_demande_xdistrib,
            'service_associe' => $service_associe,
            'id_user' => $id_user,
            'id_dd'=>$id_dd,
            'id_validation' => $id_validation,
            'numwp_client' => $numwp_client,
            'numwp_distributeur' =>$numwp_distributeur
        );
        $this->insert($data);
        return $this;
    }
    
    public function lastId($increase = false) {
        $sql = $this->getAdapter()->query("select MAX(id_demande_xdistrib) AS lastId from demande_xdistrib;");
        $res = $sql->fetchObject();
        if ($increase) {
            return $res->lastId + 1;
        } else {
            return $res->lastId;
        }
    }
    
    public function searchByUser($id){
        $sql="select demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,client_distrib.nom_client,demande_xdistrib.date_demande_xdistrib from demande_xdistrib "
                . "join client_distrib on client_distrib.numwp_client = demande_xdistrib.numwp_client"
                . " where demande_xdistrib.id_user =$id order by demande_xdistrib.id_demande_xdistrib";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function searchByCDR($tracking1,$tracking2){
         
        $sql="select demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,clients.nom_client,demande_xdistrib.date_demande_xdistrib from demande_xdistrib "
                . "join clients on clients.numwp_client = demande_xdistrib.numwp_client "
                . "join users on users.id_user = demande_xdistrib.id_user"
                
                . " where demande_xdistrib.tracking_number_demande_xdistrib like '{$tracking1}%' or demande_xdistrib.tracking_number_demande_xdistrib like '{$tracking2}%' order by demande_xdistrib.date_demande_xdistrib desc";
       
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
     public function searchforDBD(){
        $sql="select demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,clients.nom_client,demande_xdistrib.date_demande_xdistrib from demande_xdistrib"
                . " join clients on clients.numwp_client = demande_xdistrib.numwp_client"
                . " join users on users.id_user = demande_xdistrib.id_user"
                . " join validations_demande_xdistrib  on validations_demande_xdistrib.id_demande_xprice = demande_xdistrib.id_demande_xdistrib "
                . " where validations_demande_xdistrib.nom_validation like 'dbd'  and validations_demande_xdistrib.etat_validation like 'enAttente' order by demande_xdistrib.date_demande_xdistrib desc";
   $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
     }
     public function searchforDD($id){
          $sql="select demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,client_distrib.nom_client,demande_xdistrib.date_demande_xdistrib from demande_xdistrib "
                . "join client_distrib on client_distrib.numwp_client = demande_xdistrib.numwp_client"
                . " where demande_xdistrib.id_dd =$id order by demande_xdistrib.id_demande_xdistrib";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
     }
     public function getContext($numwp){
          $sql="select contexte_demande from demande_xdistrib where num_workplace_demande_xdistrib = $numwp";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
         
     }
}
