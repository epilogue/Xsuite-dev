/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function (){
     $('input.rad').change(function (){
         /*calcul du prix en fonction de la remise
          *prixachat actuel= prixtarif-((prixtarif*remise)/100)
          * 
          */
         var idT = $(this).attr('id').split('-');
         var k = idT[1];
         var pwp = parseFloat($('td#pwp-'+k).html());
         var rad = parseFloat($(this).val());
         var inter=Number(pwp*rad);
         var inter2=Number(inter/100);
         var pad = Number(pwp-inter2);
          $('input#pad-'+k).val(pad); 
          $(this).val(parseFloat($(this).val())+'%');
     });
});