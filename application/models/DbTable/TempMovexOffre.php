<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempMovexOffre
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempMovexOffre extends Zend_Db_Table_Abstract {
    protected $_name = 'temp_movex_offre';
    
    public function createInfo($numwp,$date,$userwp,$numwp_distributeur){
         $data = array(
            'numwp' => $numwp,
            'date' => $date,
            'userwp' => $userwp,
             'numwp_distrib'=>$numwp_distributeur
        );
        $this->insert($data);
        return $this;   
    }
    public function getMovexUser($numwp){
        $sql = "select distinct users.nom_user,users.prenom_user,users.tel_user,users.email_user,users.numwp_user,holons.nom_holon,holons.id_holon,zones.id_zone,zones.nom_zone "
                . " from temp_movex_offre "
                . " join users on temp_movex_offre.userwp = users.numwp_user "
                . " join holons on  holons.id_holon = users.id_holon "
                . " join zones on zones.id_zone = users.id_zone where temp_movex_offre.numwp = '$numwp'";
//      $res= $this->getAdapter()->query($sql);
//      
//      $rest = $res->fetchObject();
//      return $rest;
      $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
    public function getDistrib($numwp){
        $sql="select distinct temp_fichier_distrib_info.distrib,temp_fichier_distrib_info.nom_contact_distrib,temp_fichier_distrib_info.ville_distrib,temp_fichier_distrib_info.codepostal_distrib,temp_movex_offre.numwp_distrib "
                . " from temp_movex_offre "
                . " join  temp_fichier_distrib_info on temp_movex_offre.numwp = temp_fichier_distrib_info.numwp "
                . " where temp_movex_offre.numwp = $numwp";
//        $res= $this->getAdapter()->query($sql);
//      $rest = $res->fetchObject();
//      return $rest;
       $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
    public function getClientFinal($numwp){
        $sql="select distinct temp_fichier_distrib_info.nom_client_final,temp_client.numwp_client,temp_client.codepostal_client,temp_client.ville_client,temp_client.potentiel,temp_client.nom_industry from temp_movex_offre join temp_fichier_distrib_info  on temp_movex_offre.numwp=temp_fichier_distrib_info.numwp join temp_client on temp_movex_offre.numwp=temp_client.numwp where temp_movex_offre.numwp= $numwp";
      $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
