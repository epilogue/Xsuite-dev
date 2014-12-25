var comments = true;
$(document).ready(function (){
    $('button#histButton').click(function(){
        if(comments == true) {
            comments = false;
            $('fieldset#comm_user').hide();
            $(this).html('Afficher les commentaires');
        } else {
            comments = true;
            $('fieldset#comm_user').show();
            $(this).html('Masquer les commentaires');
        }
        return false;
    });
    $('button#histButton').click();
});
