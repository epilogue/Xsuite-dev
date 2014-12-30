/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var comments = true;
$(document).ready(function (){
    $('button#historiqueVal').click(function(){
        if(comments == true) {
            comments = false;
            $('fieldset#valid_hist').hide();
            $(this).html('Historique validation');
        } else {
            comments = true;
            $('fieldset#valid_hist').show();
            $(this).html(' Masquer historique');
        }
        return false;
    });
    $('button#historiqueVal').click();
});
