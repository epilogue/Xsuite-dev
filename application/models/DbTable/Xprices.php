<?php

class Application_Model_DbTable_Xprices extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_xprices';

    public function createXprice($num_workplace_demande_xprice, $tracking_number_demande_xprice, $commentaire_demande_xprice, $date_demande_xprice, $justificatif_demande_xprice,$justificatif2_demande_xprice,$justificatif3_demande_xprice,$justificatif4_demande_xprice, $id_user, $id_validation = null, $numwp_client) {
        $data = array(
            'num_workplace_demande_xprice' => $num_workplace_demande_xprice,
            'tracking_number_demande_xprice' => $tracking_number_demande_xprice,
            'commentaire_demande_xprice' => $commentaire_demande_xprice,
            'date_demande_xprice' => $date_demande_xprice,
            'justificatif_demande_xprice' => $justificatif_demande_xprice,
            'justificatif2_demande_xprice' => $justificatif2_demande_xprice,
            'justificatif3_demande_xprice' => $justificatif3_demande_xprice,
            'justificatif4_demande_xprice' => $justificatif4_demande_xprice,
            'id_user' => $id_user,
            'id_validation' => $id_validation,
            'numwp_client' => $numwp_client
        );
        $this->insert($data);
        return $this;
    }

    public function updateXprice($id_demande_xprice, $num_workplace_demande_xprice, $tracking_number_demande_xprice, $commentaire_demande_xprice, $date_demande_xprice, $justificatif_demande_xprice,$justificatif2_demande_xprice,$justificatif3_demande_xprice,$justificatif4_demande_xprice, $id_user, $id_validation = null, $numwp_client) {

        $data = array(
            'num_workplace_demande_xprice' => $num_workplace_demande_xprice,
            'tracking_number_demande_xprice' => $tracking_number_demande_xprice,
            'commentaire_demande_xprice' => $commentaire_demande_xprice,
            'date_demande_xprice' => $date_demande_xprice,
            'justificatif_demande_xprice' => $justificatif_demande_xprice,
            'justificatif2_demande_xprice' => $justificatif2_demande_xprice,
            'justificatif3_demande_xprice' => $justificatif3_demande_xprice,
            'justificatif4_demande_xprice' => $justificatif4_demande_xprice,
            'id_user' => $id_user,
            'id_validation' => $id_validation,
            'numwp_client' => $numwp_client
        );
        $this->update($data, 'id_demande_xprice=' . (int) $id_demande_xprice);
        return $this;
    }

    public function prixfob($trackingNumber) {
        $query = "select * from demande_xprices"
                . " join demande_articles_xprice"
                . " on demande_xprices.tracking_number_demande_xprice = demande_articles_xprice.tracking_number_demande_xprice "
                . "where tracking_number_demande_xprice =$trackingNumber ";
    }

    public static function makeTrackingNumber($zone, $nombre) {
        $annee = 'T';
        // @todo générer l'année
        // construction du nombre
        $baseNombre = "00000";
        $grandNombre = "{$baseNombre}{$nombre}";
        $nombre = substr($grandNombre, strlen("{$nombre}"));
        return "SP-FR-{$zone}{$annee}{$nombre}";
    }

    public function lastId($increase = false) {
        $sql = $this->getAdapter()->query("select MAX(id_demande_xprice) AS lastId from demande_xprices;");
        $res = $sql->fetchObject();
        if ($increase) {
            return $res->lastId + 1;
        } else {
            return $res->lastId;
        }
    }

    public function getNumwp($numwp) {
        $numwp = "$numwp";
        $row = $this->fetchRow("num_workplace_demande_xprice = '{$numwp}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }

    public function fetchAll($numwp) {

    }
    
    public function deleteByNumwp($numwp) {
       
    }

    public function getTracking($tracking_number) {
        $tracking_number = "$tracking_number";
        $row = $this->fetchRow("tracking_number_demande_xprice = '{$tracking_number}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }
public function searchAll($tracking_number){
     $tracking_number = "$tracking_number";
    $sql="select * from demande_xprices where tracking_number_demande_xprice = '{$tracking_number}'";
    $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
      return $rest;
}
}

