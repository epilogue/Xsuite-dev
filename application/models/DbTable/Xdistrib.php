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
        $annee = 'V';
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
     public function getTracking($tracking_number) {
        $tracking_number = "$tracking_number";
        $row = $this->fetchRow("tracking_number_demande_xdistrib = '{$tracking_number}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }
    public function createXDistrib($num_workplace_demande_xdistrib, $tracking_number_demande_xdistrib,$contexte_demande, $date_demande_xdistrib, $service_associe, $id_user,$id_dd, $id_validation = null,$numwp_client,$numwp_distributeur) {
        $data = array(
            'num_workplace_demande_xdistrib' => $num_workplace_demande_xdistrib,
            'tracking_number_demande_xdistrib' => $tracking_number_demande_xdistrib,
            'contexte_demande'=>$contexte_demande,
            'date_demande_xdistrib' => $date_demande_xdistrib,
            'service_associe' => $service_associe,
            'id_user' => $id_user,
            'id_dd'=>$id_dd,
            'id_validation' => $id_validation,
            'numwp_client' => $numwp_client,
            'numwp_distributeur' =>$numwp_distributeur
        );
        $this->insert($data);
        return $this;
    }
    
    public function lastId($increase = false) {
        $sql = $this->getAdapter()->query("select MAX(id_demande_xdistrib) AS lastId from demande_xdistrib;");
        $res = $sql->fetchObject();
        if ($increase) {
            return $res->lastId + 1;
        } else {
            return $res->lastId;
        }
    }
    
    public function searchByUser($id){
        $sql="select demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,client_distrib.nom_client,demande_xdistrib.date_demande_xdistrib,validations_demande_xdistrib.etat_validation from demande_xdistrib "
                . " join client_distrib on client_distrib.numwp_client = demande_xdistrib.numwp_client"
                ." join validations_demande_xdistrib on validations_demande_xdistrib.id_demande_xdistrib=demande_xdistrib.id_demande_xdistrib "
                . " where demande_xdistrib.id_user =$id order by demande_xdistrib.id_demande_xdistrib";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function tout(){
        $sql="select id_demande_xdistrib from demande_xdistrib order by id_demande_xdistrib desc";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function searchByCDR($tracking1,$tracking2){
         
        $sql="select demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,clients.nom_client,demande_xdistrib.date_demande_xdistrib from demande_xdistrib "
                . "join clients on clients.numwp_client = demande_xdistrib.numwp_client "
                . "join users on users.id_user = demande_xdistrib.id_user"
                
                . " where demande_xdistrib.tracking_number_demande_xdistrib like '{$tracking1}%' or demande_xdistrib.tracking_number_demande_xdistrib like '{$tracking2}%' order by demande_xdistrib.date_demande_xdistrib desc,validations_demande_xdistrib.date_validation asc";
       
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
     public function searchForDGCN(){
            $sql="select  distinct(demande_xdistrib.num_workplace_demande_xdistrib),validations_demande_xdistrib.id, demande_xdistrib.id_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,client_distrib.nom_client,demande_xdistrib.date_demande_xdistrib, validations_demande_xdistrib.etat_validation,validations_demande_xdistrib.nom_validation,distributeurs.nom_distributeur,users.nom_user  from demande_xdistrib
 join client_distrib ON client_distrib.numwp_client = demande_xdistrib.numwp_client 
 join users ON users.id_user =demande_xdistrib.id_user 
 join distributeurs on distributeurs.num_workplace_demande_xdistrib = demande_xdistrib.num_workplace_demande_xdistrib 
JOIN validations_demande_xdistrib ON validations_demande_xdistrib.id_demande_xdistrib = demande_xdistrib.`id_demande_xdistrib` 
 where  users.id_holon in ( 2, 18, 19, 20, 21, 22, 23, 32, 33) order by demande_xdistrib.`date_demande_xdistrib` desc, validations_demande_xdistrib.date_validation asc";
       var_dump($sql);
       echo 'plop3';
            $res = $this->getAdapter()->query($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
        }
    
     public function searchforDBD($key){
        $sql="SELECT demande_xdistrib.date_demande_xdistrib, "
            . "demande_xdistrib.id_demande_xdistrib, "
            . "validations_demande_xdistrib.nom_validation, "
            . "demande_xdistrib.num_workplace_demande_xdistrib, "
            . "demande_xdistrib.tracking_number_demande_xdistrib, "
            . "users.nom_user,
                demande_xdistrib.date_demande_xdistrib,
                demande_xdistrib.id_user,
                client_distrib.nom_client, validations_demande_xdistrib.etat_validation,
                distributeurs.nom_distributeur 
FROM validations_demande_xdistrib

JOIN demande_xdistrib ON validations_demande_xdistrib.id_demande_xdistrib = demande_xdistrib.id_demande_xdistrib
JOIN users ON users.id_user =demande_xdistrib.id_user
join distributeurs on distributeurs.num_workplace_demande_xdistrib = demande_xdistrib.num_workplace_demande_xdistrib 
JOIN client_distrib ON client_distrib.numwp_client = demande_xdistrib.numwp_client
WHERE validations_demande_xdistrib.id
IN ( SELECT max( validations_demande_xdistrib.id )
FROM `demande_xdistrib`
JOIN validations_demande_xdistrib ON validations_demande_xdistrib.id_demande_xdistrib = demande_xdistrib.`id_demande_xdistrib` "
. "GROUP BY demande_xdistrib.`tracking_number_demande_xdistrib` " 
."order by demande_xdistrib.`id_demande_xdistrib` desc"
. ") and validations_demande_xdistrib.`id_demande_xdistrib`={$key} "
. "order by demande_xdistrib.`date_demande_xdistrib` desc";
   $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
     }
     public function searchforDD($id){
          $sql="select validations_demande_xdistrib.etat_validation,validations_demande_xdistrib.date_validation, validations_demande_xdistrib.nom_validation,users.nom_user,demande_xdistrib.id_user,validations_demande_xdistrib.id_demande_xdistrib, demande_xdistrib.id_demande_xdistrib, demande_xdistrib.num_workplace_demande_xdistrib,demande_xdistrib.tracking_number_demande_xdistrib,client_distrib.nom_client,demande_xdistrib.date_demande_xdistrib,validations_demande_xdistrib.id_user "
                 . " ,distributeurs.nom_distributeur "
                  . "from demande_xdistrib "
                . "join client_distrib on client_distrib.numwp_client = demande_xdistrib.numwp_client"
                  . " join validations_demande_xdistrib on validations_demande_xdistrib.id_demande_xdistrib = demande_xdistrib.id_demande_xdistrib "
                  . " join users on users.id_user=demande_xdistrib.id_user "
                   . "join distributeurs on distributeurs.num_workplace_demande_xdistrib =demande_xdistrib.num_workplace_demande_xdistrib "
                
                . " where demande_xdistrib.id_dd =$id order by demande_xdistrib.date_demande_xdistrib desc,validations_demande_xdistrib.date_validation asc";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
     }
     public function getContext($numwp){
          $sql="select contexte_demande from demande_xdistrib where num_workplace_demande_xdistrib = $numwp";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
         
     }
     public function getServiceClient($numwp){
            $sql = "select mail_service_client from demande_xdistrib where num_workplace_demande_xdistrib= '$numwp'";
             $res = $this->getAdapter()->query($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
        }
        public function searchAll($tracking_number){
     $tracking_number = "$tracking_number";
    $sql="select * from demande_xdistrib where tracking_number_demande_xdistrib = '{$tracking_number}'";
    $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
      return $rest;
    }
    public function essaiTest($value){
        $sql="select validations_demande_xdistrib.nom_validation,"
                . "validations_demande_xdistrib.etat_validation,"
                . "validations_demande_xdistrib.date_validation,"
                . "validations_demande_xdistrib.id_demande_xdistrib,"
                . "users.nom_user,"
                . "client_distrib.nom_client,"
                . "demande_xdistrib.date_demande_xdistrib,"
                . " demande_xdistrib.num_workplace_demande_xdistrib,"
                 . " demande_xdistrib.tracking_number_demande_xdistrib"
                . " ,distributeurs.nom_distributeur "
                . " from validations_demande_xdistrib"
                ." join demande_xdistrib on demande_xdistrib.id_demande_xdistrib=validations_demande_xdistrib.id_demande_xdistrib"
                ." join client_distrib on client_distrib.numwp = demande_xdistrib.num_workplace_demande_xdistrib "
                ." join users on users.id_user=demande_xdistrib.id_user "
                 . "join distributeurs on distributeurs.num_workplace_demande_xdistrib =demande_xdistrib.num_workplace_demande_xdistrib "
                
                . " where validations_demande_xdistrib.id_demande_xdistrib='$value' "
                . "and demande_xdistrib.id_demande_xdistrib='$value' "
                . "and validations_demande_xdistrib.id = (select "
                    . "max(validations_demande_xdistrib.id) "
                    . "from validations_demande_xdistrib "
                    . "where validations_demande_xdistrib.id_demande_xdistrib='$value')"
                . " order by validations_demande_xdistrib.date_validation desc";
            $res= $this->getAdapter()->query($sql);
       $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
    }
    public function rechercheridDBD(){
        $sql ="select id_demande_xdistrib from demande_xdistrib order by demande_xdistrib.date_demande_xdistrib desc";
         $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
       
    }
    public function rechercheDBD($value){
        $sql= "select"
                . " users.nom_user,"
                . " users.id_user,"
                . " demande_xdistrib.num_workplace_demande_xdistrib,"
                . " demande_xdistrib.tracking_number_demande_xdistrib,"
                . " client_distrib.nom_client,"
                . " demande_xdistrib.date_demande_xdistrib,"
                . " validations_demande_xdistrib.etat_validation, "
                . " validations_demande_xdistrib.nom_validation, "
                . " validations_demande_xdistrib.id, "
                . " distributeurs.nom_distributeur "
                . " from demande_xdistrib "
                . "join distributeurs on distributeurs.num_workplace_demande_xdistrib =demande_xdistrib.num_workplace_demande_xdistrib "
                . "join users on users.id_user=demande_xdistrib.id_user "
                . "join client_distrib on client_distrib.numwp=demande_xdistrib.num_workplace_demande_xdistrib "
                . "join validations_demande_xdistrib on validations_demande_xdistrib.id_demande_xdistrib=demande_xdistrib.id_demande_xdistrib"
                . " where validations_demande_xdistrib.id = ("
                    . "select max(validations_demande_xdistrib.id) "
                    . "from validations_demande_xdistrib "
                    . "where validations_demande_xdistrib.id_demande_xdistrib='$value')"
                . " and demande_xdistrib.id_demande_xdistrib='$value'"
                . " order by demande_xdistrib.date_demande_xdistrib desc";
//        echo $sql;
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheridDGCN(){
        $sql = "select id_demande_xdistrib from demande_xdistrib join users on users.id_user = demande_xdistrib.id_user where users.id_holon in ( 2, 18, 19, 20, 21, 22, 23, 32, 33)order by demande_xdistrib.date_demande_xdistrib desc";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
     public function rechercheridRCDN($values){
         $essai="'" . implode("','", $values) . "'";
        $sql ="select id_demande_xdistrib from demande_xdistrib where numwp_distributeur IN ($essai) order by demande_xdistrib.date_demande_xdistrib desc";
        //echo $sql;
         $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
       
    }
    public function mailconsultRCDN($numwp){
        $sql = "select numwp_distributeur from distributeurs where num_workplace_demande_xdistrib={$numwp}";
         $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
    public function getRecherche($numwp_distributeur){
            $sql = "select distinct(demande_xdistrib.num_workplace_demande_xdistrib), demande_xdistrib.id_demande_xdistrib, demande_xdistrib.tracking_number_demande_xdistrib,distributeurs.nom_distributeur,demande_xdistrib.date_demande_xdistrib,users.nom_user  from demande_xdistrib"
                    . " join distributeurs on distributeurs.numwp_distributeur = demande_xdistrib.numwp_distributeur"
                    . " join users on users.id_user = demande_xdistrib.id_user"
                     //. " join validations_demande_xprices  on validations_demande_xprices.id_demande_xprice = demande_xprices.id_demande_xprice "
                    . " where demande_xdistrib.numwp_distributeur = '{$numwp_distributeur}'"
                    . "order by demande_xdistrib.date_demande_xdistrib desc";
                    $res = $this->getAdapter()->query($sql);
                    
//                    var_dump($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
        }
    public function getComptableRecherche($code_distrib,$code_article){
       $sql = "select distinct(demande_xdistrib.num_workplace_demande_xdistrib), demande_xdistrib.id_demande_xdistrib, demande_xdistrib.tracking_number_demande_xdistrib,distributeurs.nom_distributeur,demande_xdistrib.date_demande_xdistrib,users.nom_user  from demande_xdistrib"
                    . " join distributeurs on distributeurs.numwp_distributeur = demande_xdistrib.numwp_distributeur"
                    . " join users on users.id_user = demande_xdistrib.id_user "
               . " join demande_article_xdistrib on demande_article_xdistrib.tracking_number_demande_xdistrib=demande_xdistrib.tracking_number_demande_xdistrib "
                    . " where demande_xdistrib.numwp_distributeur = '{$code_distrib}' "
                    . " and demande_article_xdistrib.code_article = {$code_article} "
                            . "union select distinct(demande_xprices.num_workplace_demande_xprice), demande_xprices.id_demande_xprice, demande_xprices.tracking_number_demande_xprice,clients.nom_client,demande_xprices.date_demande_xprice,users.nom_user  from demande_xprices "
                    . " join dclients on clients.numwp_client = demande_xprices.numwp_client"
                    . " join users on users.id_user = demande_xprices.id_user "
               . " join demande_article_xprices on demande_article_xprices.tracking_number_demande_xprice=demande_xprices.tracking_number_demande_xprice "
                    . " where demande_xprices.numwp_client = '{$code_distrib}' "
                    . " and demande_article_xprices.code_article = {$code_article} ";
                    $res = $this->getAdapter()->query($sql);
                    
//                   var_dump($sql);
            $rest=$res->fetchAll();
            if (!$rest) {
                return null;
            } else {
                return $rest;
            }
    }
}

