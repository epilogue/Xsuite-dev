<?php

class Application_Model_DbTable_Articles extends Zend_Db_Table_Abstract {

    protected $_name = 'articles';

    public function createArticle($reference_article, $code_article, $description_article) {
        $data = array(
            'reference_article' => $reference_article,
            'code_article' => $code_article,
            'description_article' => $description_article
        );
        $this->insert($data);
        return $this;
    }

    public function getArticle($code_article) {
        $code_article = "$code_article";
        $row = $this->fetchRow("code_article = '{$code_article}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }

}

