<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrixConcurrent
 *
 * @author frhubym
 */
class Application_Model_DbTable_PrixConcurrent extends Zend_Db_Table_Abstract{
    
    protected $_name = 'prix_concurrent';
    
    public function create($nom_concurrent,$reference_article,$prix_concurrent,$prix_special_concurrent,$numwp){
        $data=array('nom_concurrent'=>$nom_concurrent,
            'reference_article'=>$reference_article,
            'prix_concurrent'=>$prix_concurrent,
            'prix_special_concurrent'=>$prix_special_concurrent,
            'numwp'=>$numwp);
         $this->insert($data);
        return $this;
    }
    //put your code here
}
