/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    $('#num_client').change(function(e)
    {
        e.preventDefault();
        console.log( $('#nom_client option[value="'+$(this).val()+'"]'));
        console.log( $('#nom_client option[value="'+$(this).val()+'"]'));
        console.log( $('#num_client option[value="'+$(this).val()+'"]'));
         $('#nom_client option[value="'+$(this).data-nom+'"]');
    });
});

