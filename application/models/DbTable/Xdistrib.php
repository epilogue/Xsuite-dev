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
        $sql="select demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,client_distrib.nom_client,demande_xdistrib.date_demande_xdistrib,validations_demande_xdistrib.etat_validation from demande_xdistrib "
                . " join client_distrib on client_distrib.numwp_client = demande_xdistrib.numwp_client"
                ." join validations_demande_xdistrib on validations_demande_xdistrib.id_demande_xdistrib=demande_xdistrib.id_demande_xdistrib "
                . " where demande_xdistrib.id_user =$id order by demande_xdistrib.id_demande_xdistrib";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function tout(){
        $sql="select id_demande_xdistrib from demande_xdistrib";
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
                
                . " where demande_xdistrib.tracking_number_demande_xdistrib like '{$tracking1}%' or demande_xdistrib.tracking_number_demande_xdistrib like '{$tracking2}%' order by demande_xdistrib.date_demande_xdistrib desc,validations_demande_xdistrib.date_validation asc";
       
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
     public function searchforDBD($key){
        $sql="SELECT demande_xdistrib.date_demande_xdistrib,demande_xdistrib.id_demande_xdistrib, validations_demande_xdistrib.nom_validation, demande_xdistrib.num_workplace_demande_xdistrib, demande_xdistrib.tracking_number_demande_xdistrib, users.nom_user, max( demande_xdistrib.date_demande_xdistrib ) , demande_xdistrib.id_user, client_distrib.nom_client, validations_demande_xdistrib.etat_validation
FROM validations_demande_xdistrib
JOIN demande_xdistrib ON validations_demande_xdistrib.id_demande_xdistrib = demande_xdistrib.id_demande_xdistrib
JOIN users ON users.id_user =demande_xdistrib.id_user
JOIN client_distrib ON client_distrib.numwp_client = demande_xdistrib.numwp_client
WHERE validations_demande_xdistrib.id
IN (
SELECT max( validations_demande_xdistrib.id )
FROM `demande_xdistrib`
JOIN validations_demande_xdistrib ON validations_demande_xdistrib.id_demande_xdistrib = demande_xdistrib.`id_demande_xdistrib`
GROUP BY demande_xdistrib.`tracking_number_demande_xdistrib` order by demande_xdistrib.`date_demande_xdistrib` desc) and validations_demande_xdistrib.`id_demande_xdistrib`={$key} order by demande_xdistrib.`tracking_number_demande_xdistrib`";
   $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
     }
     public function searchforDD($id){
          $sql="select validations_demande_xdistrib.etat_validation, validations_demande_xdistrib.nom_validation,users.nom_user,demande_xdistrib.id_user,validations_demande_xdistrib.id_demande_xdistrib, demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,client_distrib.nom_client,demande_xdistrib.date_demande_xdistrib,validations_demande_xdistrib.id_user from demande_xdistrib "
                . "join client_distrib on client_distrib.numwp_client = demande_xdistrib.numwp_client"
                  . " join validations_demande_xdistrib on validations_demande_xdistrib.id_demande_xdistrib = demande_xdistrib.id_demande_xdistrib "
                  . " join users on users.id_user=demande_xdistrib.id_user "
                . " where demande_xdistrib.id_dd =$id order by demande_xdistrib.date_demande_xdistrib desc,validations_demande_xdistrib.date_validation asc";
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
     public function getServiceClient($numwp){
            $sql = "select mail_service_client from demande_xdistrib where num_workplace_demande_xdistrib= '$numwp'";
             $res = $this->getAdapter()->query($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
        }
        public function searchAll($tracking_number){
     $tracking_number = "$tracking_number";
    $sql="select * from demande_xdistrib where tracking_number_demande_xdistrib = '{$tracking_number}'";
    $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
      return $rest;
    }
}
