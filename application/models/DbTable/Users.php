<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract {

    protected $_name = 'users';

    public function getUser($id_user) {
        $id_user = (int) $id_user;

        $row = $this->fetchRow('id_user=' . $id_user);
        if (!$row) {
            throw new Exception("could not find row $id_user");
        }
        return $row->toArray();
    }
    public function getAll(){
        $sql = "select id_user as id_commercial, nom_user as nom_commercial from users order by nom_user asc";
          $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function getAllUser(){
        $sql = "select id_user as id_emetteur, nom_user as nom_emetteur from users order by nom_user asc";
          $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function getUserDemande($id_user) {
        $id_user = (int) $id_user;
        $row = $this->fetchRow('id_user = ' . $id_user);
        if (!$row) {
            throw new Exception("could not find row $id_user");
        }
        return $row->toArray();
    }

    public function getMovexUser($numwp_user) {
        // $query = "select * from users where numwp_user = $numwp_user";
        $numwp_user = "$numwp_user";
        $row = $this->fetchRow('numwp_user like "' . "{$numwp_user}" . '"');
        if (!$row) {
            throw new Exception("could not find row $numwp_user");
        }
        return $row->toArray();
    }

    /* @todo commentaire franck
     * Ajouter un "return $this" permettrais le chainage des appels
     */

    public function createUser($nom_user, $prenom_user, $tel_user, $email_user, $password_user, $numwp_user, $id_fonction, $id_zone, $id_holon, $niveau) {
        $data = array(
            'nom_user' => $nom_user,
            'prenom_user' => $prenom_user,
            'tel_user' => $tel_user,
            'email_user' => $email_user,
            'password_user' => $password_user,
            'numwp_user' => $numwp_user,
            'id_fonction' => $id_fonction,
            'id_zone' => $id_zone,
            'id_holon' => $id_holon,
            'niveau' => $niveau
        );
        $this->insert($data);
        return $this;
    }

    public function updateUser($id_user, $nom_user, $prenom_user, $tel_user, $email_user, $password_user, $numwp_user, $id_fonction, $id_zone, $id_holon, $niveau) {

        $data = array(
            'nom_user' => $nom_user,
            'prenom_user' => $prenom_user,
            'tel_user' => $tel_user,
            'email_user' => $email_user,
            'password_user' => $password_user,
            'numwp_user' => $numwp_user,
            'id_fonction' => $id_fonction,
            'id_zone' => $id_zone,
            'id_holon' => $id_holon,
            'niveau' => $niveau
        );
        $this->update($data, 'id_user=' . (int) $id_user);
        return $this;
    }

    public function createFromForm(Application_Form_User $form) {
        $data = array(
            'nom_user' => $form->getValue('nom_user'),
            'prenom_user' => $form->getValue('prenom_user'),
            'tel_user' => $form->getValue('tel_user'),
            'email_user' => $form->getValue('email_user'),
            'id_holon' => $form->getValue('id_holon'),
            'id_fonction' => $form->getValue('id_fonction'),
            'numwp_user' => $form->getValue('numwp_user'),
            'id_zone' => $form->getValue('id_zone'),
            'password_user' => $form->getValue('password_user'),
            'niveau' => $form->getValue('niveau')
        );
        $this->insert($data);
        return $this;
    }

    public function updateFromForm($form) {
        $data = array(
            'nom_user' => $form->getValue('nom_user'),
            'prenom_user' => $form->getValue('prenom_user'),
            'tel_user' => $form->getValue('tel_user'),
            'email_user' => $form->getValue('email_user'),
            'id_holon' => $form->getValue('id_holon'),
            'id_fonction' => $form->getValue('id_fonction'),
            'numwp_user' => $form->getValue('numwp_user'),
            'id_zone' => $form->getValue('id_zone'),
            'password_user' => $form->getValue('password_user'),
            'niveau' => $form->getValue('niveau')
        );
        $this->update($data, 'id_user=' . (int) $form->getValue('id_user'));
        return $this;
    }

    public function deleteUser($id_user) {
        $this->delete('id_user=' . (int) $id_user);
    }

    public function getFonctionLabel($id_user) {
        $db = $this->getAdapter();
        $select = $db->select()
                ->from("users", array("users.id_user", "fonctions.description_fonction","nom_user","prenom_user"))
                ->join(array("fonctions"), "fonctions.id_fonction = users.id_fonction")
                ->where("users.id_user ='{$id_user}'");
        $res = $select->query();
        $result = $res->fetch();
        if (!$result) {
            return null;
        } else {
            return $result;
        }
    }
    public function getPassword($email_user){
         $email_user = "$email_user";
    $sql="select password_user , email_user from users where email_user = '{$email_user}'";
//    var_dump($sql);
    $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
     if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function getUserName($name){
    $name="$name";
    $sql ="select zones.id_zone, zones.nom_zone,nom_user,prenom_user,email_user,id_user,tel_user from users join zones on zones.id_zone=users.id_zone where nom_user like '{$name}%' and id_fonction= 6 ";
      $res = $this->getAdapter()->query($sql);
       $rest = $res->fetchObject();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheUser() {
       $sql="select * from users where id_fonction = 1 or id_fonction = 2  or id_fonction = 3";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function rechercheUserCompletion() {
       $sql="select nom_user,prenom_user,id_user from users order by nom_user ASC";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
    public function updatefonctionuser($data){
        $sql="update users set id_fonction = {$data['id_fonction']} , id_holon = {$data['id_holon']}, niveau={$data['niveau']} where id_user={$data['id_user']}";
        $res = $this->getAdapter()->query($sql);
       
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
}
