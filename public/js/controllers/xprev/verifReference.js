/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    $('.refartReference').change(function(e)
    {
          $.get ('/xprev/verifReference/reference/'+$(this).val(),
          {},
          function(data){
              $('#refart['+$(this).data(id)+'][code_article]').html(data);
          },'html');
    });
});
