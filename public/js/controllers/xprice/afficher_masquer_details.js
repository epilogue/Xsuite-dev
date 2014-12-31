/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var comments = true;
$(document).ready(function (){
    $('button#detailbutton').click(function(){
        if(comments == true) {
            comments = false;
            $('div#demandeArticle').hide();
            $(this).html('Détails');
        } else {
            comments = true;
            $('div#demandeArticle').show();
            $(this).html(' Masquer Détails');
        }
        return false;
    });
    $('button#detailbutton').click();
});


