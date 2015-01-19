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
    public function createXDistrib($num_workplace_demande_xdistrib, $tracking_number_demande_xdistrib, $commentaire_demande_xdistrib, $date_demande_xdistrib, $justificatif_demande_xdistrib,$justificatif2_demande_xdistrib,$justificatif3_demande_xdistrib,$justificatif4_demande_xdistrib, $id_user, $id_validation = null, $numwp_client,$numwp_distributeur) {
        $data = array(
            'num_workplace_demande_xdistrib' => $num_workplace_demande_xdistrib,
            'tracking_number_demande_xdistrib' => $tracking_number_demande_xdistrib,
            'commentaire_demande_xdistrib' => $commentaire_demande_xdistrib,
            'date_demande_xdistrib' => $date_demande_xdistrib,
            'justificatif_demande_xdistrib' => $justificatif_demande_xdistrib,
            'justificatif2_demande_xdistrib' => $justificatif2_demande_xdistrib,
            'justificatif3_demande_xdistrib' => $justificatif3_demande_xdistrib,
            'justificatif4_demande_xdistrib' => $justificatif4_demande_xdistrib,
            'id_user' => $id_user,
            'id_validation' => $id_validation,
            'numwp_client' => $numwp_client,
            'numwp_distributeur' =>$numwp_distrib
        );
        $this->insert($data);
        return $this;
    }
}
