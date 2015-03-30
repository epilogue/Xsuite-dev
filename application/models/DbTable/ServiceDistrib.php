<?php

class Application_Model_DbTable_ServiceDistrib extends Zend_Db_Table_Abstract {

    protected $_name = 'service_distrib';

    public function createServiceDistrib($numwp,$produitdedie,$ecatalogue,$journeetech,$accescom,$identconc,$interlocuteur,$service__associe){
        $data=array(
           'numwp'=> $numwp,
            'produit_dedie'=>$produitdedie,
            'e_catalogue'=>$ecatalogue,
            'journee_tech'=>$journeetech,
            'accescom'=>$accescom,
            'identconc'=>$identconc,
            'interlocuteur'=>$interlocuteur,
            'service_associe'=>$service__associe
        );
        $this->insert($data);
        return $this;
    }
    public function getService($numwp){
        $row = $this->fetchRow("numwp = '{$numwp}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }
}
