<?php

class Application_Form_User extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        // les validations ( email  , non vide ...)
        $emptyValidator = new Zend_Validate_NotEmpty();
        $emptyValidator->setMessage('Ce champ est vide : veuillez le compléter ');

        $emailValidator = new Zend_Validate_EmailAddress();
        $emailValidator->setMessage("l'adresse mail n'est pas valide");
        //on va rechercher l'id et le nom des fonctions
        $useMap = new Application_Model_DbTable_Fonctions();
        $fonctions = $useMap->fetchAll();
        //on va rechercher l'id et le nom  de l'holon
        $optMap = new Application_Model_DbTable_Holons();
        $holons = $optMap->fetchAll();
        //on va chercher l'id et le nom de la zone
        $zonMap = new Application_Model_DbTable_Zones();
        $zones = $zonMap->fetchAll();

        $this->setName('user');
        $id_user = new Zend_Form_Element_Hidden('id_user');
        $id_user->addFilter('Int');

        $nom_user = new Zend_Form_Element_Text('nom_user');
        $nom_user->setLabel('Nom :')
                ->setRequired(true);

        $prenom_user = new Zend_Form_Element_Text('prenom_user');
        $prenom_user->setLabel('Prenom :')
                ->setRequired(true);

        $tel_user = new Zend_Form_Element_Text('tel_user');
        $tel_user->setLabel('Tel :')
                ->setRequired(true);

        $email_user = new Zend_Form_Element_Text('email_user');
        $email_user->setLabel('Email :')
                ->setRequired(true)
                ->addValidator($emailValidator);

        $password_user = new Zend_Form_Element_Text('password_user');
        $password_user->setLabel('Mot de passe:')
                ->setRequired(FALSE);
        $numwp_user = new Zend_Form_Element_Text('numwp_user');
        $numwp_user->setLabel('user_wp:')
                ->setRequired(FALSE);

        //sélecteur pour les fonctions
        $id_fonction = $this->addElement("select", 'id_fonction', array(
                    'label' => 'fonction :',
                    'value' => -1
                ))
                ->getElement('id_fonction');
        $fonctoptions = array("-1" => "choisissez une fonction");
        foreach ($fonctions as $fonction) {
            $fonctoptions[$fonction->id_fonction] = "{$fonction->nom_fonction} ";
        }
        $id_fonction->addMultiOptions($fonctoptions);


        //sélecteur pour les holons

        $id_holon = $this->addElement("select", 'id_holon', array(
                    'label' => 'holon :',
                    'value' => -1
                ))
                ->getElement('id_holon');
        $holoptions = array("-1" => "choisissez un holon");
        foreach ($holons as $holon) {
            $holoptions[$holon->id_holon] = "{$holon->nom_holon} ";
        }
        $id_holon->addMultiOptions($holoptions);


        //sélecteur pour les zones

        $id_zone = $this->addElement("select", 'id_zone', array(
                    'label' => 'zone:',
                    'value' => -1
                ))
                ->getElement('id_zone');
        $zonoptions = array("-1" => "choisissez une zone :");
        foreach ($zones as $zone) {
            $zonoptions[$zone->id_zone] = "{$zone->nom_zone} ";
        }
        $id_zone->addMultiOptions($zonoptions);

        //sélecteur pour les niveau

        $niveau = $this->addElement("select", 'niveau', array(
                    'label' => 'niveau :',
                    'value' => -1
                ))
                ->getElement('niveau');
        $nivoptions = array(
            "-1" => "choisissez un niveau",
            "niveau0" => "niveau 0",
            "niveau1" => "niveau 1",
            "niveau2" => "niveau 2",
            "niveau3" => "niveau 3",
            "niveau4" => "niveau 4"
        );

        $niveau->addMultiOptions($nivoptions);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id_user', 'submitbutton');

        $this->addElements(array($id_user, $nom_user, $prenom_user, $email_user, $id_holon, $tel_user, $id_fonction, $password_user, $numwp_user, $niveau, $submit));
    }

}

