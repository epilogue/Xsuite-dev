<?php

class Application_Model_DbTable_HierarchieXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'hierarchie_xprev';

    public function getHierarchie($holon,$fonction){
        $sql= "select users.email_user,hierarchie_xprev.id_user from hierarchie_xprev join users on users.id_user = hierarchie_xprev.id_user where hierarchie_xprev.id_holon ={$holon} and hierarchie_xprev.id_fonction ={$fonction}";
        $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
     if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function affichehierarchienord(){
        $sql = "select distinct(users.id_user), holons.id_holon, fonctions.id_fonction,users.nom_user,fonctions.nom_fonction, holons.nom_holon from hierarchie_xprev "
                . "left join users on users.id_user = hierarchie_xprev.id_user "
                . " left join holons on holons.id_holon = users.id_holon "
                . " left join fonctions on fonctions.id_fonction= users.id_fonction "
                . " where holons.nom_holon like 'IN%' order by holons.nom_holon ";
       // var_dump($sql);exit();
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function affichehierarchieest(){
        $sql = "select distinct(users.id_user), holons.id_holon, fonctions.id_fonction,users.nom_user,fonctions.nom_fonction, holons.nom_holon from hierarchie_xprev "
                . "left join users on users.id_user = hierarchie_xprev.id_user "
                . " left join holons on holons.id_holon = users.id_holon "
                . " left join fonctions on fonctions.id_fonction= users.id_fonction "
                . " where holons.nom_holon like 'IS%' order by holons.nom_holon ";
       // var_dump($sql);exit();
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function affichehierarchieouest(){
        $sql = "select distinct(users.id_user), holons.id_holon, fonctions.id_fonction,users.nom_user,fonctions.nom_fonction, holons.nom_holon from hierarchie_xprev "
                . "left join users on users.id_user = hierarchie_xprev.id_user "
                . " left join holons on holons.id_holon = users.id_holon "
                . " left join fonctions on fonctions.id_fonction= users.id_fonction "
                . " where holons.nom_holon like 'IW%' order by holons.nom_holon ";
       // var_dump($sql);exit();
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function affichehierarchieouestsud(){
        $sql = "select distinct(users.id_user), holons.id_holon, fonctions.id_fonction,users.nom_user,fonctions.nom_fonction, holons.nom_holon from hierarchie_xprev "
                . "left join users on users.id_user = hierarchie_xprev.id_user "
                . " left join holons on holons.id_holon = users.id_holon "
                . " left join fonctions on fonctions.id_fonction= users.id_fonction "
                . " where holons.nom_holon like 'IV%' order by holons.nom_holon ";
       // var_dump($sql);exit();
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function uphierarchie($data){
        $sql="update hierarchie_xprev set id_user = {$data['id_user']} where id_holon = {$data['id_holon']} and id_fonction={$data['fonctionn1']} or id_fonction={$data['fonctionn2'] }";
        var_dump($sql);
        exit();
        $res = $this->getAdapter()->query($sql);
       
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
}
