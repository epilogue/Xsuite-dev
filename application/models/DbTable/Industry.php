<?php

class Application_Model_DbTable_Industry extends Zend_Db_Table_Abstract
{

    protected $_name = 'industry';
    
public function getMovexIndustry($industriewp) {
        $industriewp="$industriewp";
        $row = $this->fetchRow("code_movex_industry = '{$industriewp}' ");
       
        if(!$row){
            throw new Exception("could not find row $industriewp");
        }
        return $row->toArray();
    }
public function getIndustry($id_industry) {
        $row = $this->fetchRow("id_industry = '{$id_industry}'");
        if (!$row) {
            return null;
        } else {
            return $row->toArray();
        }
    }
    public function allCodeSmcIndustry(){
        $sql="select distinct(code_smc_industry) from industry";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function allIndustry(){
        $sql="select * from industry";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    public function updateIndustry($id_industry,$nom_industry,$code_smc_industry,$code_movex_industry,$description_industry){
        $data=array(
            "nom_industry"=>$nom_industry,
            "code_smc_industry"=>$code_smc_industry,
            "code_movex_industry"=>$code_movex_industry,
            "description_industry"=>$description_industry
        );
        $this->update($data, 'id_industry=' . (int) $id_industry);
        return $this;
        
    }
    public function createIndustry($nom_industry, $code_smc_industry,$code_movex_industry,$description_industry) {
        $data = array(
           "nom_industry" => $nom_industry,
             "code_smc_industry" => $code_smc_industry,
            "code_movex_industry" => $code_movex_industry,
            "description_industry" => $description_industry
        );
        $this->insert($data);
        return $this;
    }
}

