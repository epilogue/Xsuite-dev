<?php 
require_once ('./ClassphpImap.php');
$host="{webmail.smc-france.fr:143/imap}"; // voir http://fr.php.net/imap_open
$login="frhubym"; //imap login
$password="plop08"; //imap password
$savedirpath="./Bureau/testconfig" ; // attachement will save in same directory where scripts run othrwise give abs path
$jk=new MailAttachmentManager($host, $login, $password, $savedirpath);

echo $host;
echo $jk;
?>