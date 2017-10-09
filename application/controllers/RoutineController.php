<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
//        /* Initialize action controller here */
//        /* @todo commentaire
//         * Exemple d'authentification forcée pour toutes les actions de ce controlleur
//         */
//        $auth = Zend_Auth::getInstance();
//        $user = $auth->getIdentity();
//        if (is_null($user)) {
//            $this->_helper->redirector('index', 'login');
//        } else {
//            /* @todo commentaire 
//             * Et donc, ici, on peut faire de l'acl de manière plus fine
//             */
//        }
    }
 protected function sendEmail($params) {
        $mail = new Xsuite_Mail();
        $mail->setSubject($params['sujet'])
                ->setBodyText(sprintf($params['corpsMail'], $params['url']))
                ->addTo($params['destinataireMail'])
                ->send();
    }
    public function routineAction() {
       $emailVars = Zend_Registry::get('emailVars');
             /* creation des parametre du mail*/
//         foreach($listeMailing as $listeMailing1){
             $params=array();
//             $params['destinataireMail']=$listeMailing1['email_user'];
             $params['destinataireMail']="mhuby@smc-france.fr";
             $params['corpsMail']="Bonjour,\n"
                                . "\n"
                                . "pour information la prévision {$listeMailing1['tracking']} pour le client {$listeMailing1['nom_client']} arrive à échéance {$listeMailing1['date_fin']}.\n"
                                . "Nous avons besoin d'une nouvelle prévision afin de conserver la mise en stock et de raccourcir les délais.\n"
                                ." Merci de faire le point avec client et de nous faire éventuellement une Xprev\n "
                                . " avec un commentaire sur les raisons de la demande de mise en stock et les engagements clients.\n"
                                . "\n\n"
                                . "Cordialement,\n"
                                . "\n"
                                . "--\n"
                                . "Le service Logistique";
             $params['sujet']="fin de validité de la prévision dans 3 mois pour la prévision {$listeMailing1['tracking']} pour {$listeMailing1['nom_client']}";
              //echo '<pre>',  var_export($params),'</pre>';
               $this->sendEmail($params);
//         }
    }

}

