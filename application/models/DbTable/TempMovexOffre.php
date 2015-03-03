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
        $sql = "select users.nom_user,users.prenom_user,users.tel_user,users.email_user,users.numwp_user,holons.nom_holon"
                . " from temp_movex_offre "
                . " join users on temp_movex_offre.userwp = users.numwp_user"
                . "join holons.id_holon = users.id_holon where temp_movex_offre.numwp = '$numwp'";
      $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
      return $rest;
    }
}
