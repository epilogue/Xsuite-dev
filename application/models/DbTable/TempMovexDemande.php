<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TempMovexDemande
 *
 * @author frhubym
 */
class Application_Model_DbTable_TempMovexDemande extends Zend_Db_Table_Abstract {
    protected $_name = 'temp_movex_demande';
    
    function createDemandeTemp($code_article,$reference_article,$prix_tarif,$quantite,$prix_demande,$remise_demande,$numwp,$prix_accorde,$remise_accorde,$code_acquisition,$prix_fob,$prix_cif,$marge){
        $data=array(
            'code_article'=>$code_article,
            'reference_article'=>$reference_article,
            'prix_tarif'=>$prix_tarif,
            'quantite'=>$quantite,
            'prix_demande'=>$prix_demande,
            'remise_demande'=>$remise_demande,
            'numwp'=>$numwp,
            'prix_accorde'=>$prix_accorde,
            'remise_accorde'=>$remise_accorde,
            'code_acquisition'=>$code_acquisition,
            'prix_fob'=>$prix_fob,
            'prix_cif'=>$prix_cif,
            'marge'=>$marge);
        
        $this->insert($data);
        return $this;   
    }
     public function InserPrixFob($prixciff, $code_article, $numwp) {
        $code_article = "$code_article";
        $numwp = "$numwp";
        $prixciff = floatval($prixciff);
        $plop = $this->getAdapter();
        $datas = array('prix_fob' => $prixciff, 'prix_cif' => $prixciff);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto('And numwp = ?', $numwp);
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
                . $plop->quoteInto('And numwp = ?', $numwp);
        $plop2 = $this->update($datas, $where);
        return $plop2;
    }
    public function updatecif($cifs, $code_article, $numwp) {
        $code_article = "$code_article";
        $numwp = "$numwp";
        $plop = $this->getAdapter();
        $datas = array('prix_cif' => $cifs);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto(' And numwp = ?', $numwp);
        $plop2 = $this->update($datas, $where);
        return $plop2;
    }
     public function getDemandeArticlexdistrib($numwp) {
        $numwp = "$numwp";
        $rows = $this->fetchAll("numwp = '{$numwp}'");
        if (!$rows) {
            return null;
        } else {
            return $rows->toArray();
        }
    }
    public function updateMarge($marge, $code_article, $numwp) {
        $code_article = "$code_article";
        $numwp = "$numwp";
        $plop = $this->getAdapter();
        $datas = array('marge' => $marge);
        $where = $plop->quoteInto('code_article = ?', $code_article)
                . $plop->quoteInto('numwp = ?', $numwp);
        $plop2 = $this->update($datas, $where);
        return $plop2;
    }
    public function demande($numwp){
        $sql = "select temp_movex_demande.code_article,temp_movex_demande.reference_article,temp_movex_demande.prix_tarif,temp_movex_demande.quantite,temp_fichier_distrib_article.prix_achat_actuel,temp_fichier_distrib_article.prix_achat_demande_distrib, temp_fichier_distrib_article.prix_achat_demande_client_final,temp_fichier_distrib_article.remise_supplementaire,temp_movex_offre.date, temp_movex_demande.prix_fob,temp_movex_demande.prix_cif";
    }
}
