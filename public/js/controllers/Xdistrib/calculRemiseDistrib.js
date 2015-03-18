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
         var inter = Number(pwp*rad);
         var inter2 = Number(inter/100).toFixed(2);
         var pad = Number(pwp-inter2).toFixed(2);
          $('input#pad-'+k).val(pad); 
          $(this).val(parseFloat($(this).val())+'%');
     });
     $('input.pad').change(function(){
          /*calcul du prix en fonction de la remise
          *remise= 100-((pad*100)/pwp)
          * 
          */
         var idT = $(this).attr('id').split('-');
         var k = idT[1];
         var pwp = parseFloat($('td#pwp-'+k).html());
         var pad = parseFloat($(this).val());
         var inter1= Number(pad*100);
         var inter3= Number(inter1/pwp);
         var rad = Number(100 - inter3).toFixed(2);
         $('input#rad-'+k).val(rad)+'%';
          $(this).val(parseFloat($(this).val()));
         
     });
});