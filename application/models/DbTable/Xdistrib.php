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
        $annee = 'S';
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
}
