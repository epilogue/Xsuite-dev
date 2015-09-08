<?php

class Application_Model_DbTable_Validationsdemandexdistrib extends Zend_Db_Table_Abstract {

    protected $_name = 'validations_demande_xdistrib';

    public function createValidation( $validations_demande_xdistrib_id = null, $id_demande_xdistrib, $id_user, $nom_validation, $date_validation, $etat_validation,  $commentaire = null) {
        $data = array( 
            'validations_demande_xdistrib_id' => $validations_demande_xdistrib_id,
            'id_demande_xdistrib' => $id_demande_xdistrib,
            'id_user' => $id_user,
            'nom_validation' => $nom_validation,
            'date_validation' => $date_validation,
            'etat_validation' => $etat_validation,
            'commentaire' => $commentaire,
           
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
 public function searchFermeture($numwp){
            $sql = "SELECT etat_validation,demande_xdistrib.num_workplace_demande_xdistrib 
                FROM validations_demande_xdistrib
            join demande_xdistrib on demande_xdistrib.id_demande_xdistrib= validations_demande_xdistrib.id_demande_xdistrib
             WHERE demande_xdistrib.num_workplace_demande_xdistrib =$numwp ";
            
             $res = $this->getAdapter()->query($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
        }
        public function getValidForEncours($numwp){
            $sql="SELECT nom_validation,etat_validation FROM validations_demande_xdistrib
join demande_xdistrib on demande_xdistrib.id_demande_xdistrib =validations_demande_xdistrib.id_demande_xdistrib where num_workplace_demande_xdistrib = $numwp";
             $res = $this->getAdapter()->query($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
        }
        public function datefermeture($numwp){
            $sql="select validations_demande_xdistrib.date_validation FROM validations_demande_xdistrib
join demande_xdistrib on demande_xdistrib.id_demande_xdistrib =validations_demande_xdistrib.id_demande_xdistrib where num_workplace_demande_xdistrib = $numwp and etat_validation='fermee'";
            $res = $this->getAdapter()->query($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
        }
}
