<?php

class Application_Form_CreationXprice extends Zend_Form {

    public function init() {

        /* les appels à la base MOVEX nous permettent de récuperer ces données
         *      $reference_article        = $resultat->OBITDS;
         *      $code_article             = $resultat-> OBITNO;
         *      $prix_article             = $resultat->OBSAPR;
         *      $prix_demande_article     = $resultat->OBNEPR;
         *      $quantite_demande_article = $resultat->OBRQT;
         *      $numero_offre_workplace   = $resultat->OBORNO;
         *      $num_workplace_user       = $resultat->OBSMCD;
         *      $num_workplace_client     = $resultat->OBCUNO;
         *      $date_demande             = $resultat->OBRGDT;
         *      $date_livraison           = $resultat->OBELNO;
         *      $nom_client               = $resultatbis->OKCUNM;
         *      $code_movex_industry      = $resultatbis->OKCUCL;
         *      $holon_commercial         = $resultatbis->OKACGR;
         *      $potentiel_client         = $resultatbis->OKCFC7;
         *      $adresse_client_1         = $resultatbis->OKCUA1;
         *      $adresse_client_2         = $resultatbis->OKCUA2;
         *      $adresse_client_3         = $resultatbis->OKCUA3;
         *      $adresse_client_4         = $resultatbis->OKCUA4;
         *      $tel_client               = $resultatbis->OKPHNO;
         * A partir du num_workplace du commercial on va pouvoir aller
         * chercher dans la base user les informations le concernant
         *
         */
        /* Construction du tracking number
         * pour le cas des Xprice le tracking number se constituera de la manière suivante :
         * concaténation de :
         * SP =spécial price
         * FR pour france
         * la zone QA,QE,QF.....
         * l'année qui est indiquée par le japon est qui est désigné par une lettre
         * et pour finir un numéro qui correspondra au dernier id entré+1 cela donnera
         * SP-FR-QAS1
         */
        $this->setMethod('post');
        $this->setAction('../xprice/confirmCreate');
        $numwp_user = "IP14";
        $usertest = new Application_Model_DbTable_Users();
        $usermap = $usertest->getMovexUser($numwp_user);
        $nom_user1 = $usermap['nom_user'];
        $prenom_user1 = $usermap['prenom_user'];
        $tel_user1 = $usermap['tel_user'];
        $email_user1 = $usermap['email_user'];
        $id_holon = $usermap['id_holon'];
        $id_user1 = $usermap['id_user'];
        $holonuser = new Application_Model_DbTable_Holons();
        $holonuser1 = $holonuser->getHolon($id_holon);
        $nom_holon = $holonuser1['nom_holon'];

        /* fieldset offre */

        $num_offre_workplace = new Zend_Form_Element_Text('num_offre_worplace');
        $num_offre_workplace->setLabel("Numéro d'offre workplace : ");

        $date_offre = new Zend_Form_Element_Text('date_offre');
        $date_offre->setLabel("Date de l'offre :");
        //->setValue($date_demande);

        $tracking_number = new Zend_Form_Element_Text('tracking_number');
        $tracking_number->setLabel("Tracking_number :");
        //->setValue( $tracking_number1));
        /*
         * filedset1 identité du commercial
         */
        $nom_user = new Zend_Form_Element_Text('nom_user');
        $nom_user->setLabel('Nom:')
                ->setValue($usermap['nom_user']);

        $prenom_user = new Zend_Form_Element_Text('prenom_user');
        $prenom_user->setLabel('Prénom:')
                ->setValue($prenom_user1);

        $tel_user = new Zend_Form_Element_Text('tel_user');
        $tel_user->setLabel('Téléphone:')
                ->setValue($tel_user1);

        $email_user = new Zend_Form_Element_Text('email_user');
        $email_user->setLabel('Email:')
                ->setValue($email_user1);

        $holon_user = new Zend_Form_Element_Text('holon_user');
        $holon_user->setLabel('Holon:')
                ->setValue($nom_holon);

        $numwp_user2 = new Zend_Form_Element_Text('numwp_user');
        $numwp_user2->setLabel('Identifiant workplace:')
                ->setValue($numwp_user);


        /* fieldset2 identité du client */
        $nom_client = new Zend_Form_Element_Text('nom_client');
        $nom_client->setLabel('Nom :')
        /* ->setValue($resultatbis->OKCUNM) */
        ;

        $numwp_client = new Zend_Form_Element_Text('numwp_client');
        $numwp_client->setlabel('Numéro client :');

        $industry = new Zend_Form_Element_Text('industry');
        $industry->setlabel('Industrie :');

        $potentiel_client = new Zend_Form_Element_Text('potentiel_client');

        $potentiel_client->setLabel('Potentiel :');

        /* fieldset 3  la demande article
         * construction du tableau à partir du foreach
         */
        $code_article = new Zend_Form_Element_Text('code_article');
        $code_article->setlabel('code article:');

        $reference_article = new Zend_Form_Element_Text('reference_article');
        $reference_article->setLabel('référence:');

        $quantite_demande_article = new Zend_Form_Element_Text('quantite_demande_article');
        $quantite_demande_article->setLabel('quantité :');

        $prixwp_demande_article = new Zend_Form_Element_Text('prixwp_demande_article');
        $prixwp_demande_article->setLabel('prix workplace :');

        $prix_demande_article = new Zend_Form_Element_Text('prix_demande_article');
        $prix_demande_article->setLabel('prix demandé :');


        $remise_demande_article = new Zend_Form_Element_Text('remise_demande_article');
        $prix_demande_article->setLabel('remise demandée :');



        /*
         * fieldset 4 justificatif de la demande
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

        $commentaire_demande_article = new Zend_Form_Element_Textarea('commentaire_demande_article');
        $commentaire_demande_article->setLabel('Commentaire commercial:')
                ->setRequired(false);


        $this->setName('demande_article');
        $id_demande_article = new Zend_Form_Element_Hidden('id_demande_article');
        $id_demande_article->addFilter('Int');





        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id_demande_article', 'submitbutton');

        $this->addElements(array(
            $date_offre,
            $num_offre_workplace,
            $tracking_number,
            $commentaire_demande_article,
            $nom_client,
            $industry,
            $potentiel_client,
            $numwp_client,
            $nom_user,
            $prenom_user,
            $email_user,
            $holon_user,
            $tel_user,
            $numwp_user2,
            $concurrent_demande_article,
            $mini_demande_article,
            $part_demande_article,
            $faible,
            $id_demande_article,
            $code_article,
            $reference_article,
            $quantite_demande_article,
            $prix_demande_article,
            $remise_demande_article,
            $prixwp_demande_article,
            $submit));


        $this->addDisplayGroup(array(
            $num_offre_workplace,
            $date_offre,
            $tracking_number
                ), 'wp', array('legend' => 'offre workplace'));
        $wp = $this->getDisplayGroup('wp');
        $wp->setDecorators(array('FormElements',
            'Fieldset',
            array('HtmlTag',
                array('tag' => 'div', 'openOnly' => true))));

        $this->addDisplayGroup(array(
            $nom_user,
            $prenom_user,
            $email_user,
            $holon_user,
            $tel_user,
            $numwp_user2
                ), 'info_user', array('legend' => 'Informations commercial'));
        $info_user = $this->getDisplayGroup('info_user');
        $info_user->setDecorators(array('FormElements',
            'Fieldset',
            array('HtmlTag',
                array('tag' => 'div', 'openOnly' => true))));

        $this->addDisplayGroup(array(
            $nom_client,
            $numwp_client,
            $industry,
            $potentiel_client
                ), 'info_client', array('legend' => 'Informations client'));
        $info_client = $this->getDisplayGroup('info_client');
        $info_client->setDecorators(array('FormElements',
            'Fieldset',
            array('HtmlTag',
                array('tag' => 'div', 'openOnly' => true))));

        $this->addDisplayGroup(array(
            $code_article,
            $reference_article,
            $quantite_demande_article,
            $prixwp_demande_article,
            $prix_demande_article,
            $remise_demande_article
                ), 'article', array('legend' => 'Articles'));
        $article = $this->getDisplayGroup('article');
        $article->setDecorators(array('FormElements',
            'Fieldset',
            array('HtmlTag',
                array('tag' => 'div', 'openOnly' => true))));

        $this->addDisplayGroup(array(
            $concurrent_demande_article,
            $mini_demande_article,
            $part_demande_article,
            $faible
                ), 'justificatif', array('legend' => 'Justificatif de la demande'));
        $justificatif = $this->getDisplayGroup('justificatif');
        $justificatif->setDecorators(array('FormElements',
            'Fieldset',
            array('HtmlTag',
                array('tag' => 'div', 'openOnly' => true))));

        $this->addDisplayGroup(array(
            $commentaire_demande_article
                ), 'commentaire', array('legend' => 'Commentaires'));
        $commentaire = $this->getDisplayGroup('commentaire');
        $commentaire->setDecorators(array('FormElements',
            'Fieldset',
            array('HtmlTag',
                array('tag' => 'div', 'openOnly' => true))));

        $this->addDisplayGroup(array(
            $id_demande_article,
            $submit
                ), 'envoi', array('legend' => ''));
        $envoi = $this->getDisplayGroup('envoi');
        $envoi->setDecorators(array('FormElements',
            'Fieldset',
            array('HtmlTag',
                array('tag' => 'div', 'openOnly' => true))));
    }

}

