<?php
/**
 * Description of Informations
 *
 * @author frhubym
 */
class Application_Model_DbTable_Informations extends Zend_Db_Table_Abstract {
    protected $_name = 'demande_xprices';
    public function InformationGenerale($numwp){
        $query="SELECT * FROM demande_xprices"
        ."JOIN clients ON clients.numwp_client = demande_xprices.numwp_client"
        ."JOIN users ON users.id_user = demande_xprices.id_user"
        ."WHERE num_workplace_demande_xprice = $numwp";
        $res= $this->getAdapter()->query($query);
        $resultat = $res->fetchObject();
        return $resultat;
    }
    public function InformationHolon($id_user){
        $query="select * from users"
                ."join holons on holons.id_holon = users.id_holon"
                ."join zones on zones.id_zone = users.id_zone"
                ."where users.id_user = $id_user";
        $res1= $this->getAdapter()->query($query);
        $resultat1 = $res1->fetchObject();
        return $resultat1;
    }
}
