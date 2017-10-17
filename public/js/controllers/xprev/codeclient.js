/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    $('#num_client').change(function(e)
    {
          $('#nom_client').val($('#num_client option:selected').data('nom'));
          
          $.get ('/xprev/liaisoncodeuser/num_client/'+$(this).val(),
          {},
          function(data){
              $('#code_user').html(data);
              if($('#code_user option').length == 1) {
                  $('#code_user').change();
              }
          },'html');
    });
   $('#code_user').change(function(e)
    {
          $('#nom_client_user').val($('#code_user option:selected').data('nom'));
      });
      
});

