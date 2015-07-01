<?php

class Application_Model_DbTable_Fonctions extends Zend_Db_Table_Abstract
{

    protected $_name = 'fonctions';

public function getFonction($id_fonction) {
        $id_fonction =(int)$id_fonction;
        $row = $this->fetchRow('id_fonction='.$id_fonction);
        if(!$row){
            throw new Exception ("could not find row $id_fonction");
        }
        return $row->toArray();
    }
    
  
    
    public function createFonction($nom_fonction,$description_fonction) {
        $data =array(
            'nom_fonction'=>$nom_fonction,
            'description_fonction'=>$description_fonction    
        );
        $this->insert($data);
        
    }
    public function updateFonction($id_fonction,$nom_fonction,$description_fonction) {
        
         $data =array(
            'nom_fonction'=>$nom_fonction,
            'description_fonction'=>$description_fonction    
        );   
        
        $this->update($data,'id_fonction='.(int)$id_fonction);
    }
    
    public function allFonction(){
        $sql="select * from fonctions order by nom_fonction asc";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}

