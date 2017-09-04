<?php

class Application_Model_DbTable_DemandeArticleXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_article_xprev';

     public function createDemandeArticle($data) {
        var_dump($this->insert($data));
        return $this;
    }
    
    public function getarticleprev($tracking){
        $sql="select * from demande_article_xprev  where demande_article_xprev.tracking like '{$tracking}'";
        //var_dump($sql);
                $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function uprevient($tracking,$code_article,$prix_revient){
        $sql = "update demande_article_xprev set prix_revient={$prix_revient} where code_article={$code_article} and tracking like '{$tracking}'";
       // var_dump($sql); exit();
        $res = $this->getAdapter()->query($sql);
        $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
    }
    
    public function sommemois($code_article,$tracking){
        $sql = "select sum(m1+m2+m3+m4+m5+m6+m7+m8+m9+m10+m11+m12) as total from demande_article_xprev where code_article ={$code_article} and tracking like {$tracking}";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
