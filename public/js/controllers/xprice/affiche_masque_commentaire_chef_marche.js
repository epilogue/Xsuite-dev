var comments = true;
$(document).ready(function (){
    $('button#Buttoncom').click(function(){
        if(comments == true) {
            comments = false;
            $('div#commentaire_chef_marche').hide();
            $(this).html('laisser un commentaire');
        } else {
            comments = true;
            $('div#commentaire_chef_marche').show();
            $(this).hide();
        }
        return false;
    });
    $('button#Buttoncom').click();
});
