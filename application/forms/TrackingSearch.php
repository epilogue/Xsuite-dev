<?php

class Application_Form_TrackingSearch extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        $this->setAction('/xprice/tracking');
        $this->setAttrib("class", "little_form");


        $tracking_number_demande_xprice = new Zend_Form_Element_Text('tracking_number_demande_xprice');
        $tracking_number_demande_xprice->setLabel("numéro tracking de la Xprice : ")
                ->setRequired(TRUE)
                ->setDescription("exemple: SP-FR-QX00000")
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('regex', false, array('/^SP-FR-Q[a-zA-Z][a-zA-Z][0-9][0-9][0-9][0-9][0-9]/', 'messages' => array(Zend_Validate_Regex::NOT_MATCH => "numéro invalide")))
                ->addValidator('NotEmpty', true, array('messages' => array(Zend_Validate_NotEmpty::IS_EMPTY => "le champ tracking_number ne peut pas être vide.")));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('tracking_number_demande_xprice', 'submitbutton')
                ->setAttrib('class','submit')
                ->setLabel('entrer');
        $this->addElements(array($tracking_number_demande_xprice, $submit));
    }

}