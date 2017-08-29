<?php

class Application_Model_DbTable_DemandeArticleXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_article_xprev';

     public function createDemandeArticle($data) {
        var_dump($this->insert($data));
        return $this;
    }
    
    public function getarticleprev($tracking){
        $sql="select * from demande_article_xprev  where demande_article_xprev.tracking like '{$tracking}'";
        var_dump($sql);
                $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}
