<?php 
require_once ('./ClassphpImap.php');
require_once './config.php';
$jk=new MailAttachmentManager($host, $login, $password, $savedirpath);
$jk->openMailBox();
//echo '<pre>', var_export($jk->getList($mbName), true), '</pre>';
//echo '<pre>', var_export($jk->check(), true), '</pre>';
$extensionpc=$jk->fetch_list_with_attachments();
foreach ($extensionpc as $extensionpc2){
               $tableau[]=$extensionpc2 ;
              //$this->saveAttachment("{$key}_{$mKey}_{$attachement['filename']}", $this->getFileData($key, $attachement['pos'], $attachement['type']));
          }
          //echo '<pre>', var_export($jk->fetch_list_with_attachments(), true), '</pre>';
echo '<pre>', var_export($tableau, true), '</pre>';
//echo '<pre>', var_dump($jk->getMbox()), '</pre>';

/**
 * Paramètres de save_all_attachements :
 * $jk->($search = null, $limit = null);
 * $search : si null : liste tous les mails de la boîte définie en paramètres
 * $search : utilisé pour chercher des mails en fonctions de critères
 *     voir "criteria" dans : http://php.net/manual/fr/function.imap-search.php
 * $limit : utilisé si $search = null
 * $limit : si null: cherche les pièces jointes dans tout les mails
 * $limit : utilisé pour limiter la recherche à un certain nombre de mails
 *  voir "sequence" dans : http://php.net/manual/fr/function.imap-fetch-overview.php
 */
$jk->save_all_attachements();

$jk->closeMailBox();

//echo $host;
//echo $jk;