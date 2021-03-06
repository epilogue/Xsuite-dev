<?php

class Application_Model_DbTable_DemandeArticlexdistrib extends Zend_Db_Table_Abstract {

    protected $_name = 'demande_article_xdistrib';

    public function createDemandeArticlexdistrib($prix_tarif,$prix_achat_actuel,$prix_demande_article,$prix_client_final,$quantite_demande_article,$serie,$date_demande_xdistrib, $prix_accorde_demande_article, $remise_accorde_demande_article, $prix_fob_demande_article, $prix_cif_demande_article, $marge_demande_article, $tracking_number_demande_xdistrib, $code_article, $reference_article, $num_workplace_demande_xdistrib,$code_acquisition) {
        $data = array(
            'prix_tarif' => $prix_tarif,
            'prix_achat_actuel' =>$prix_achat_actuel,
            'prix_demande_article'=> $prix_demande_article,
            'prix_client_final'=>$prix_client_final,
            'quantite_demande_article'=> $quantite_demande_article,
            'serie'=>$serie,
            'date_demande_xdistrib' => $date_demande_xdistrib,
            'prix_accorde_demande_article' => $prix_accorde_demande_article,
            'remise_accorde_demande_article' => $remise_accorde_demande_article,
            'prix_fob_demande_article' => $prix_fob_demande_article,
            'prix_cif_demande_article' => $prix_cif_demande_article,
            'marge_demande_article' => $marge_demande_article,
            'tracking_number_demande_xdistrib' => $tracking_number_demande_xdistrib,
            'code_article' => $code_article,
            'reference_article' => $reference_article,
            'num_workplace_demande_xdistrib' => $num_workplace_demande_xdistrib,
            'code_acquisition' => $code_acquisition
        );
        $this->insert($data);
        return $this;
    }
public function createArticleDemandeNoFile($data){
    $data['prix_tarif']=floatval($data['prix_tarif']);
    $data['prix_achat_actuel']=  floatval($data['prix_achat_actuel']);
    $data['prix_demande_article']= floatval($data['prix_demande_article']);
    $data['prix_client_final']= floatval($data['prix_client_final']);
    $data['quantite_demande_article']= intval($data['quantite_demande_article']);
//       echo '<pre>',var_export($data, true),'</pre>'; 
    $this->insert($data);
        return $this;
}
    public function getDemandeArticlexdistrib($numwp) {
        $numwp = "$numwp";
        $rows = $this->fetchAll("num_workplace_demande_xdistrib = '{$numwp}'");
        if (!$rows) {
            return null;
        } else {
            return $rows->toArray();
        }
    }

    public function InserPrixFob($prixciff, $code_article, $numwp) {
        $code_article = "$code_article";
        $numwp = "$numwp";
        $prixciff = floatval($prixciff);
        $plop = $this->getAdapter();
        $datas = array('prix_fob_demande_article' => $prixciff, 'prix_cif_demande_article' => $prixciff);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto('And num_workplace_demande_xdistrib = ?', $numwp);
        $plop2 = $this->update($datas, $where);
        return $plop2;
    }
     public function InserCodeAcquis($codeAcquis, $code_article, $numwp) {
        $code_article = "$code_article";
        $numwp = "$numwp";
        $codeAcquis = $codeAcquis;
        $plop = $this->getAdapter();
        $datas = array('code_acquisition' => $codeAcquis);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto('And num_workplace_demande_xdistrib = ?', $numwp);
        $plop2 = $this->update($datas, $where);
        return $plop2;
    }

    public function updatecif($cifs, $code_article, $tracking_number) {
        
        $cif=floatval($cifs);
        $tracking_number = "$tracking_number";
        $sql="update demande_article_xdistrib set prix_cif_demande_article=$cif where code_article =$code_article And tracking_number_demande_xdistrib ='{$tracking_number}'";
//        var_dump($sql); exit();
        $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
        
//        var_dump($plop2);
        return $plop2;
    }

    public function updatefob($fobs, $code_article, $tracking_number) {
        $code_article = "$code_article";
        $tracking_number = "$tracking_number";
        $plop = $this->getAdapter();
        $datas = array('prix_fob_demande_article' => $fobs);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto(' And tracking_number_demande_xdistrib = ?', $tracking_number);
        $plop2 = $this->update($datas, $where);
        return $plop2;
    }
    
     public function updateSerie($reference,$tracking_number,$serie) {
        //$reference = "$reference";
        //$tracking_number = "$tracking_number";
        //$serie="$serie";
         $sql ="UPDATE `demande_article_xdistrib` SET `serie`='{$serie}' WHERE `reference_article`='{$reference}' and `tracking_number_demande_xdistrib`='{$tracking_number}'";
//         var_dump($sql);exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
       
    }
    
    public function updatePrixClient($reference,$tracking_number,$prix) {
        //$reference = "$reference";
       // $tracking_number = "$tracking_number";
        //$prix="$prix";
         $sql ="UPDATE `demande_article_xdistrib` SET `prix_client_final`='{$prix}' WHERE `reference_article`='{$reference}' and `tracking_number_demande_xdistrib`='{$tracking_number}'";
        // var_dump($sql);exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
       
    }
public function updatePrixAchatActuel($reference,$tracking_number,$prix){
     $sql ="UPDATE `demande_article_xdistrib` SET `prix_achat_actuel`='{$prix}' WHERE `reference_article`='{$reference}' and `tracking_number_demande_xdistrib`='{$tracking_number}'";
        // var_dump($sql);exit();
          $res = $this->getAdapter()->query($sql);
        
        if (!$res) {
            return null;
        } else {
            return $res;
        }
}

public function listtracking($tracking_number) {
        $db = $this->getAdapter();
        $select = $db->select()
                ->from(array("demande_xprices"), array("demande_xprices.tracking_number_demande_xprice",
                    "commentaire_demande_xprice",
                    "demande_xprices.date_demande_xprice",
                    "demande_xprices.numwp_client",
                    "demande_article_xprices.code_article",
                    "demande_article_xprices.reference_article",
                    "demande_article_xprices.prixwplace_demande_article",
                    "demande_article_xprices.prix_demande_article",
                    "demande_article_xprices.quantite_demande_article",
                    "demande_article_xprices.remise_demande_article",
                    "validations_xprice.nom_validation",
                    "validations_xprice.etat_validation",
                    "validations_xprice.date_validation"))
                    
                ->join(array("demande_article_xprices"), "demande_xprices.tracking_number_demande_xprice=demande_article_xprices.tracking_number_demande_xprice")
                ->join(array("clients"), " clients.numwp_client=demande_xprices.numwp_client")
                ->join(array("validations_xprice"), "demande_xprices.tracking_number_demande_xprice=validations_xprice.tracking_number_demande_xprice")
                ->where("demande_xprices.tracking_number_demande_xprice='{$tracking_number}'");
//        var_dump($select->__toString());
//        exit();

        $plop = $select->query();
        $result = $plop->fetchAll();
        //var_dump($result);
        //exit();
        if (!$result) {
            return null;
        } else {
            return $result;
        }
    }
    //creation de la fonction qui additionne le montant des prix_demande_article recuperer
    //a checker
    public function sommePrixDemandeArticle($num_workplace_demande_xdistrib) {
       $num_workplace_demande_xdistrib="$num_workplace_demande_xdistrib";
       $sql="select SUM(`prix_demande_article` * `quantite_demande_article`) as total from `demande_article_xdistrib` where `num_workplace_demande_xdistrib`= '$num_workplace_demande_xdistrib'";
      $res= $this->getAdapter()->query($sql);
      $rest = $res->fetchObject();
      return $rest;
      
    }
   public function insertRemiseAccorde($remiseDirco,$code_article, $tracking_number) {
     $code_article = "$code_article";
        $tracking_number = "$tracking_number";
        $remiseDirco=floatVal("$remiseDirco");
        $plop = $this->getAdapter();
        $datas = array('remise_accorde_demande_article' => $remiseDirco);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto('And tracking_number_demande_xdistrib = ?', $tracking_number);
        $plop2 = $this->update($datas, $where);
   return $plop2;
   
   }
   
    public function insertPrixAccorde($prixDirco,$code_article, $tracking_number) {
     $code_article = "$code_article";
        $tracking_number = "$tracking_number";
        $prixDirco=floatVal("$prixDirco");
        $plop = $this->getAdapter();
        $datas = array('prix_accorde_demande_article' => $prixDirco);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto('And tracking_number_demande_xdistrib = ?', $tracking_number);
        $plop2 = $this->update($datas, $where);
   return $plop2;
   
   }
   public function insertMarge($marge,$code_article, $tracking_number) {
     $code_article = "$code_article";
        $tracking_number = "$tracking_number";
        $marge=floatVal("$marge");
        $plop = $this->getAdapter();
        $datas = array('marge_demande_article' => $marge);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto('And tracking_number_demande_xdistrib = ?', $tracking_number);
        $plop2 = $this->update($datas, $where);
   return $plop2;
   
   }
    public function updateMarge($marge, $code_article, $numwp) {
        $code_article = "$code_article";
        $numwp = "$numwp";
        $plop = $this->getAdapter();
        $datas = array('marge_demande_article' => $marge);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto(' And num_workplace_demande_xdistrib = ?', $numwp);
        $plop2 = $this->update($datas, $where);
        return $plop2;
    }
    public function ploparticle($numwp){
       $sql="select code_article from demande_article_xdistrib where num_workplace_demande_xdistrib =$numwp"; 
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    } 
    public function article(){
        $sql="select distinct(code_article) from demande_article_xdistrib";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
    
    public function articleComptabilite(){
        $sql="select distinct(code_article) from demande_article_xdistrib union select distinct(code_article) from demande_article_xprices ";
        $res = $this->getAdapter()->query($sql);
        $rest=$res->fetchAll();
        if (!$rest) {
            return null;
        } else {
            return $rest;
        }
    }
}

