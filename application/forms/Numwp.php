<?php

class Application_Form_Numwp extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        $this->setAction('/xprice/numwp');
        $this->setAttrib("class", "little_form");


        $num_offre_workplace = new Zend_Form_Element_Text('num_offre_worplace');
        $num_offre_workplace->setLabel("numéro d'offre workplace : ")
                ->setRequired(TRUE)
                ->setDescription("exemple: 00906XXXXXX")
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('regex', false, array('/^00[9][0][6][0-9]/', 'messages' => array(Zend_Validate_Regex::NOT_MATCH => "numéro invalide")))
                ->addValidator('NotEmpty', true, array('messages' => array(Zend_Validate_NotEmpty::IS_EMPTY => "le champ offre workplace ne peut pas être vide.")));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('num_offre_workplace', 'submitbutton')
                ->setAttrib('class','submit')
                ->setLabel('entrer');
        $this->addElements(array($num_offre_workplace, $submit));
    }

}

