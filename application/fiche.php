<?php 

 
  //r�cup�ration des valeurs des champs:
  
  
 	$tracking     = $_POST["tracking"] ;
	$tracking = str_replace( "'", "", $tracking);


  	$societe     = $_POST["societe"] ;
	$societe = str_replace( "'", "", $societe);
	
	
  	$adresse     = $_POST["adresse"] ;
	$adresse = str_replace( "'", "", $adresse);
	
	
  	$code_postal     = $_POST["code_postal"] ;
	$code_postal = str_replace( "'", "", $code_postal);
	
	
  	$ville     = $_POST["ville"] ;
	$ville = str_replace( "'", "", $ville);
	
	$contact     = $_POST["contact"] ;
	$contact = str_replace( "'", "", $contact);
	
	$email     = $_POST["email"] ;
	$email = str_replace( "'", "", $email);


	$tel     = $_POST["tel"] ;
	$tel = str_replace( "'", "", $tel);


	$fax     = $_POST["fax"] ;
	$fax = str_replace( "'", "", $fax);

	$rma     = $_POST["rma"] ;
	$rma = str_replace( "'", "", $rma);

	$ref    = $_POST["ref"] ;
	$ref = str_replace( "'", "", $ref);

	$manuf     = $_POST["manuf"] ;
	$manuf= str_replace( "'", "", $manuf);

	$facture     = $_POST["facture"] ;
	$facture = str_replace( "'", "", $facture);

	$probleme     = $_POST["probleme"] ;
	$probleme = str_replace( "'", "", $probleme);

	$quantite     = $_POST["quantite"] ;
	$quantite = str_replace( "'", "", $quantite);

	$retour     = $_POST["retour"] ;
	$retour = str_replace( "'", "", $retour);

	$type     = $_POST["type"] ;
	$type = str_replace( "'", "", $type);

 	$retour_client     = $_POST["retour_client"] ;
	$retour_client = str_replace( "'", "", $retour_client);



?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>RMA</title>
        <style type="text/css">
        <!--
        .Style1 {
                font-family: Arial, Helvetica, sans-serif;
                font-weight: bold;
                font-size: 18px;
        }
        .Style2 {font-size: 18px; font-family: Arial, Helvetica, sans-serif;}
        .Style3 {font-family: Arial, Helvetica, sans-serif}
        #Layer2 {
                position:absolute;
                width:230px;
                height:115px;
                z-index:2;
                left: 366px;
                top: 254px;
        }
        #Layer3 {
                position:absolute;
                width:554px;
                height:26px;
                z-index:1;
                left: 43px;
                top: 612px;
        }
        #Layer4 {
                position:absolute;
                width:251px;
                height:18px;
                z-index:2;
                left: 300px;
                top: 12px;
        }
        #Layer5 {
                position:absolute;
                width:89px;
                height:28px;
                z-index:2;
                left: 531px;
                top: 8px;
        }
        #Layer6 {
                position:absolute;
                width:94px;
                height:137px;
                z-index:2;
                left: 11px;
                top: 96px;
        }
        #Layer7 {
                position:absolute;
                width:596px;
                height:115px;
                z-index:2;
                left: 14px;
                top: 437px;
        }
        #Layer8 {
                position:absolute;
                width:208px;
                height:16px;
                z-index:2;
                left: 77px;
                top: 647px;
        }
        #Layer9 {
                position:absolute;
                width:616px;
                height:115px;
                z-index:2;
                left: 6px;
                top: 711px;
        }
        #Layer10 {
                position:absolute;
                width:527px;
                height:38px;
                z-index:2;
                left: 76px;
                top: 870px;
        }
        #Layer11 {
                position:absolute;
                width:472px;
                height:136px;
                z-index:2;
                left: 536px;
                top: 91px;
        }
        #Layer12 {
                position:absolute;
                width:512px;
                height:161px;
                z-index:2;
                left: 106px;
                top: 96px;
        }
        .Style9 {font-size: 16px}
        .Style10 {font-weight: bold; font-family: Arial, Helvetica, sans-serif;}
        .Style11 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        #Layer13 {
                position:absolute;
                width:200px;
                height:20px;
                z-index:2;
                left: 324px;
                top: 653px;
        }
        .Style14 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
        #Layer14 {
                position:absolute;
                width:341px;
                height:22px;
                z-index:2;
                left: 9px;
                top: 337px;
        }

        #Layer15 {
                position:absolute;
                width:341px;
                height:22px;
                z-index:2;
                left: 9px;
                top: 373px;
        }
        -->
        </style>
    </head>
    <body>
        <div id="Layer1" style="position:absolute; width:573px; height:38px; z-index:1; left: 1px; top: 1px;">
        <table width="644" height="923" border="2" bordercolor="#3399FF">
              <tr>
                <td width="632" height="915" align="left" valign="top" bordercolor="#3399FF"><p align="left"><span class="Style1 Style1"><img src="../Logo SMC Bleu.jpg" width="121" height="38" />AUTORISATION RETOUR MARCHANDISE </span> <span class="Style2">(RMA)</span></p>
                  <div id="Layer6">
                    <p align="right" class="Style11">Soci&eacute;t&eacute; : <br />
        Adresse :
            <br />
        Code postal :
        <br />
        Ville : <br />
        <br />
        Nom Contact  : <br />
        Email :
        <br />
        Tel :
        <br />
        Fax : </p>
                  </div>

                  <p class="Style9"><span class="Style11"><strong>Exp&eacute;diteur :</strong></span></p>
                  <div class="Style10" id="Layer14">N&deg; Dossier : <strong><?php echo $tracking ?></strong></div>
                          <div class="Style10" id="Layer15">N&deg; Retour Client: <strong><?php echo $retour_client ?></strong></div>

                  <p class="Style9"><br>
                    <br>
                  </p>
                  <div class="Style11" id="Layer12"><strong><?php echo $societe ?><br>
                  <?php echo $adresse ?></span><br>
                  <?php echo $code_postal ?></span><br>
                  <?php echo $ville ?></span><br>
                  <?php echo $contact ?></span><br>
                  <?php echo $email ?></span><br>
                  <?php echo $tel ?></span><br>
                  <?php echo $fax ?></span></strong><br>
                  </div>
                  <p class="Style9"><br>
                    <br>
                    <br>
                    <br>
                  </p>
                  <p class="Style9">&nbsp;</p>
                  <p class="Style9">&nbsp;</p>
                  <div class="Style11" id="Layer7">REFERENCE PRODUIT :
                      <strong><?php echo $ref ?></strong><br />
                      <br />
                      CODE FABRICATION : 
                      <strong><?php echo $manuf ?></strong><br />
                      <br />
                      NUMERO DE FACTURE : 
                      <strong><?php echo $facture ?></strong><br />
                      <br />
                      PROBLEME RENCONTRE : 
                      <strong><?php echo $probleme ?></strong><br />
                      <br />
                      QUANTITE : 
                      <strong><?php echo $quantite ?></strong><br />
                      <br />
                </div>
                  <p class="Style9"><br>
                  </p>
                  <p class="Style9">&nbsp;</p>
                  <p class="Style9">&nbsp;</p>
                  <div class="Style9" id="Layer8">
                    <table width="205" border="1" align="center">
                      <tr>
                        <td width="195"><div align="left"><span class="Style10">N&deg; RMA : </span><strong class="Style10"><?php echo $rma ?></strong></div></td>
                      </tr>
                    </table>
                  </div>
                  <p class="Style9">&nbsp;</p>
                  <p class="Style9">&nbsp;</p>
                  <p class="Style9"><br>
                  </p>
                  <div class="Style11" id="Layer9">



                    <p align="left" class="Style3 ">- CE DOCUMENT DEVRA ACCOMPAGNER LE PRODUIT ET ETRE VISIBLE DE L'EXTERIEUR DU CARTON</p>
                    <p align="left" class="Style3 ">- N�envoyez aucun  produit avant d�avoir obtenu un num�ro de RMA, sinon le produit vous sera r�exp�di�.</p><br/>

        <p align="left" class="Style3 ">-Le produit d�fectueux doit parvenir au si�ge de SMC-France � Bussy Saint Georges dans un d�lai maximum de 1 semaine apr�s attribution du num�ro de RMA. </p>
                    <p align="left" class="Style3 ">- <p>
                  </div>
                  <p class="Style9"><br>
                  </p>
                  <div> 
                        <p align="left" class="Style3 " style="font-style:italic">-Ce produit est la propri�t� du client, ce dernier ne peut �tre remis en stock par SMC. </p><br/><br/>
                        <p align="left" class="Style3 " style="font-style:italic">-En renvoyant son produit, le client accepte que celui-ci soit test� et d�mont� par SMC dans le cadre d�un diagnostic technique. Si le dysfonctionnement du produit est av�r�, le produit sera r�par� ou remplac� au titre de la garantie. Si le d�faut est li� � une cause ext�rieure non pris en charge par la garantie, le produit d�fectueux pourra, sur demande, vous �tre retourn� en l��tat et � vos frais dans un d�lai de 2 mois maximum apr�s r�ception du rapport d�expertise. Au-del� de ce d�lai, le produit sera d�truit par SMC.</p><br/><br/>
                        <p align="left" class="Style3 " style="font-style:italic">-Si l'expertise ne r�v�le aucun dysfonctionnement propre au produit, celui-ci vous sera renvoy� et il sera alors proc�d� � la facturation des frais d'envoi A/R, selon nos Conditions G�n�rales de Ventes, dans le cas d'un retour sous garantie.</p><br/><br/>


                </div>
                  <p align="left" class="Style3 Style9">&nbsp;</p>
                 <p align="left" class="Style3 Style9">&nbsp;</p>
                 <div class="Style14" id="Layer13"> <?php if ($type == "Oui") echo "retour sous garantie"; else echo "Commande Expertise"; ?> </div>
                 <p align="left" class="Style3 Style9">&nbsp;</p>
                 <p align="left" class="Style3 Style9">&nbsp;</p>
                <div class="Style11" id="Layer2">
                  <p><strong>Adresse de livraison :</strong></p>
                  <p>SMC PNEUMATIQUE SA  <br>Support Technique<br />1, boulevard de Strasbourg<br />Parc Gustave Eiffel<br />77600 BUSSY SAINT GEORGES</p>
                  Tel : 01.64.76.21.65<br />
                  Email: support-technique@smc-france.fr</div>


                <p align="left" class="Style3 Style9">&nbsp; </p></td>
            </tr>
          </table>
        </div>
    </body>
</html>