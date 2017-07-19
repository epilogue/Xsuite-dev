<?php

class Application_Model_DbTable_DemandeArticleXprev extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_article_xprev';

     public function createDemandeArticle($data) {
        var_dump($this->insert($data));
        return $this;
    }
}
