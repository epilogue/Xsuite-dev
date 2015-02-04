<?php

class Application_Model_DbTable_Validationsdemandexdistribs extends Zend_Db_Table_Abstract {

    protected $_name = 'validations_demande_xdistrib';

    public function createValidation($nom_validation, $date_validation, $etat_validation, $id_user, $id_demande_xdistrib, $commentaire = null, $validations_demande_xdistrib_id = null) {
        $data = array(
            'nom_validation' => $nom_validation,
            'date_validation' => $date_validation,
            'etat_validation' => $etat_validation,
            'id_user' => $id_user,
            'id_demande_xdistrib' => $id_demande_xdistrib,
            'commentaire' => $commentaire,
            'validations_demande_xdistrib_id' => $validations_demande_xdistrib_id
        );
        $this->insert($data);
        return $this;
    }

    public function getValidationById($id_validation) {
        $id_validation = (int) $id_validation;

        $row = $this->fetchRow('id=' . $id_validation);
        if (!$row) {
            throw new Exception("could not find row $id_validation");
        }
        return $row->toArray();
    }

    public function getValidation($nom_validation, $id_demande_xdistrib) {
        $nom_validation = "$nom_validation";
        $plop = $this->getAdapter();

        $where = $plop->quoteInto('nom_validation = ?', $nom_validation)
                . $plop->quoteInto('And id_demande_xdistrib = ?', $id_demande_xdistrib);
        $plop2 = $this->fetchAll($where);
        return $plop2->toArray();
    }

    public function getAllValidation($id_demande_xdistrib) {
        $plop = $this->getAdapter();
        $select = $plop->select()
                ->from("validations_demande_xdistrib")
                ->where("id_demande_xdistrib = {$id_demande_xdistrib}")
                ->group(array("id_user", "id"))
                ->order(array('date_validation', 'id_user'))
        ;
        $query = $select->query();
        $rows = $query->fetchAll();
        if (!$rows) {
            return null;
        } else {
            return $rows;
        }
    }

    public function lastId($increase = false) {
        $sql = $this->getAdapter()->query("select MAX(id) AS lastId from {$this->_name};");
        $res = $sql->fetchObject();
        if ($increase) {
            return $res->lastId + 1;
        } else {
            return $res->lastId;
        }
    }

    public function checkId($id) {
        $sql = $this->getAdapter()->query("select id from {$this->_name} where id={$id}");
        $res = $sql->fetch();
        if (array_key_exists('id', $res) && $res['id'] == $id) {
            return true;
        } else {
            return false;
        }
    }

}
