<?php

class Application_Form_CreationDemande  extends Zend_Form {
    public function init() {
        $this->setMethod('post');
        
        /*
         * fieldset justificatif de la demande
         */

        $concurrent_demande_article = new Zend_Form_Element_Text('concurrent_demande_article');
        $concurrent_demande_article->setlabel('Concurrent visé par la demande de prix spe: ')
                ->setRequired(false);

        $part_demande_article = new Zend_Form_Element_Text('part_demande_article');
        $part_demande_article->setLabel('Parts de marché:');

        $mini_demande_article = new Zend_Form_Element_Text('mini_demande_article');
        $mini_demande_article->setLabel('Minimum de commande (ex: 200kits machines commandés tous les 2 mois) :')
                ->setRequired(false);

        $faible = $this->addElement("select", 'faible', array(
                    'label' => 'Démarche stratégique:',
                    'value' => -1
                ))
                ->getElement('faible');
        $faibleoptions = array("-1" => "choisissez la démarche",
            0 => "concentration des efforts",
            1 => "attaquer le faible",
            2 => "globalisation");

        $faible->addMultiOptions($faibleoptions);

        /*
         * fieldset commentaire
         */
        
        $commentaire_demande_article = new Zend_Form_Element_Textarea('commentaire_demande_article');
        $commentaire_demande_article->setRequired(false);
        
        /*
         * bouton de soumission
         */
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id_demande_article', 'submitbutton')
                ->setAttrib("class", "submit")
                ->setLabel("Envoyer X-price");
        
        /*
         * ajout des élements au form
         */
        
        $this->addElement($concurrent_demande_article)
             ->addElement($part_demande_article)
             ->addElement($mini_demande_article)
             ->addElement($faible)
             ->addElement($commentaire_demande_article);
        
        /*
         * création des fieldsets
         */
        
        $this->addDisplayGroup(array(
            "concurrent_demande_article",
            "part_demande_article",
            "mini_demande_article",
            "faible"
        ), 'justificatif', array('disableLoadDefaultDecorators' => true))
            ->addDisplayGroup(array("commentaire_demande_article"), 'commentaire', array('disableLoadDefaultDecorators' => true));
        
        $this->setDisplayGroupDecorators(array(
            'FormElements',
            'Fieldset'
        ));
        $this->getDisplayGroup('justificatif')
                ->setLegend("Justificatif de la demande")
                ->setAttrib("class", "field");
        $this->getDisplayGroup('commentaire')
                ->setLegend("Commentaires")
                ->setAttrib("class", "field");
        
        
        $this->addElement($submit);
    }
}
