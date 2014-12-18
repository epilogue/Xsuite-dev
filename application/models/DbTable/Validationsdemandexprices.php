<?php

class Application_Model_DbTable_Validationsdemandexprices extends Zend_Db_Table_Abstract {

    protected $_name = 'validations_demande_xprices';

    public function createValidation($nom_validation, $date_validation, $etat_validation, $id_user, $id_demande_xprice, $commentaire = null, $validations_demande_xprices_id = null) {
        $data = array(
            'nom_validation' => $nom_validation,
            'date_validation' => $date_validation,
            'etat_validation' => $etat_validation,
            'id_user' => $id_user,
            'id_demande_xprice' => $id_demande_xprice,
            'commentaire' => $commentaire,
            'validations_demande_xprices_id' => $validations_demande_xprices_id
        );
        $this->insert($data);
        return $this;
    }

    public function getValidation($nom_validation, $id_demande_xprice) {
        $nom_validation = "$nom_validation";
        $plop = $this->getAdapter();

        $where = $plop->quoteInto('nom_validation = ?', $nom_validation)
                . $plop->quoteInto('And id_demande_xprice = ?', $id_demande_xprice);
        $plop2 = $this->fetchAll($where);
        return $plop2->toArray();
    }

    public function getAllValidation($id_demande_xprice) {
        $plop = $this->getAdapter();
        $select = $plop->select()
                ->from("validations_demande_xprices")
                ->where("id_demande_xprice = {$id_demande_xprice}")
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

}
