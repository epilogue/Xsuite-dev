/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*fonction rajouter par Jonathan 04112014 pour le fichier list.phtml
 * Cette fonction permet de afficher et de cacher des informations du boutton 
 * détail
 */
function afficher(objet)
{
    if(document.getElementById(objet).style.visibility==="hidden")
    {
        document.getElementById(objet).style.visibility="visible";
        document.getElementById('bouton_'+objet).innerHTML='Cacher détail';
    }
    else
    {
        document.getElementById(objet).style.visibility="hidden";
        document.getElementById('bouton_'+objet).innerHTML='Détail';
    }
    return true;
}
