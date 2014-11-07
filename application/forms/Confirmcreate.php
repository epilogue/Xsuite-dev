<?php

class Application_Form_Confirmcreate extends Zend_Form {

    public function init() {
        var_dump($_POST);
        $this->setMethod('post');
        $this->setAction('../xprice/prixfobfr');
        $num_offre_workplace = new Zend_Form_Element_Text('num_offre_worplace');
        $num_offre_workplace->setLabel("Vous Confirmez la création de l'offre : ")
                ->setValue($_POST["num_offre_worplace"]);

        $submit = new Zend_Form_Element_Submit('submit');
        $this->addElements(array($num_offre_workplace, $submit));
    }

}

