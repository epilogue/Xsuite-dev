<?php

class Application_Model_DbTable_Zones extends Zend_Db_Table_Abstract {

    protected $_name = 'zones';

    public function getZone($id_zone) {
        $id_zone = intval($id_zone);
        $row = $this->fetchRow('id_zone=' . $id_zone);
        if (!$row) {
            throw new Exception("could not find row $id_zone");
        }
        return $row->toArray();
    }

    public function createZone($nom_zone, $description_zone, $id_holon) {
        $data = array(
            'nom_fonction' => $nom_fonction,
            'description_fonction' => $description_fonction,
            'id_holon ' => $id_holon
        );
        $this->insert($data);
    }

    public function updateZone($id_zone, $nom_zone, $description_zone, $id_holon) {

        $data = array(
            'nom_zone' => $nom_zone,
            'description_zone' => $description_zone,
            'id_holon' => $id_holon
        );

        $this->update($data, 'id_zone=' . (int) $id_zone);
    }

}

