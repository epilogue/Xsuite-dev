<?php 
require_once ('./ClassphpImap.php');
require_once './config.php';
$jk=new MailAttachmentManager($host, $login, $password, $savedirpath);
$jk->openMailBox();
$extensionpc=$jk->fetch_list_with_attachments();

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