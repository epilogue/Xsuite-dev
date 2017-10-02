/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 *  Type: Date or Number or String
Default: null
The minimum selectable date. When set to null, there is no minimum.
Multiple types supported:

    Date: A date object containing the minimum date.
    Number: A number of days from today. For example 2 represents two days from today and -1 represents yesterday.
    String: A string in the format defined by the dateFormat option,
     or a relative date. Relative dates must contain value and period pairs;
      valid periods are "y" for years, "m" for months, "w" for weeks, and "d" for days. 
      For example, "+1m +7d" represents one month and seven days from today.

Code examples:

Initialize the datepicker with the minDate option specified:
1
2
3
	

$( ".selector" ).datepicker({
  minDate: new Date(2007, 1 - 1, 1)
});
 */
var articleId = 0;

function newArticleLine() {
    var baseHtml = $('#addRefTPL').html();
    var toHtml = baseHtml.replace(/__id__/g, articleId);
    $("#table_mois tbody").append(toHtml);
    var usedAid = articleId;
    articleId++;
    return usedAid;
}
$(document).ready(function(){
     $("#date_debut").MonthPicker({
       lang:'fr',
       MonthFormat: 'mm-yy',
       MinMonth:1,
       MaxMonth:'+1y',
       OnAfterChooseMonth: function() { 
        //alert($(this).val());
        $("#table_mois").show();
        $("#ajout_article").show();
        $.get ('/xprev/liaisonmois/date_debut/'+$(this).val(),
          {},
          function(data){
              $('#table_mois thead').html(data);
          },'html');
          $("#ajout_article").click(function(e){
         e.preventDefault();
        var id = newArticleLine();
        $('.champM').unbind('change');
        $('.champM').change(function(){
            console.log('plopM');
            var valeurTotal = 0;
            $('.champM').each(function(i,e){
                var valM = $(e).val();
                if(valM == "") {
                    valeurTotal+=0;
                } else {
                    valeurTotal+=parseFloat($(e).val());
                }
            });
            console.log("tagadaM : "+valeurTotal);
            if(valeurTotal > 0) {
                $('#submitM').attr('disabled', false);
                $('#mVide').hide();
            } else {
                $('#submitM').attr('disabled', true);
                $('#mVide').show();
            }
        });
        console.log(id);
        $('input[name="refart['+id+'][reference]"]').change(function(e)
        {
            console.log('tagada');
              $.get ('/xprev/verifreference/reference/'+$(this).val(),
              {},
              function(data){
                  if(!$.trim(data)){
                  alert("la reference rentree n'existe pas dans movex");
              }
                  $('input[name="refart['+id+'][code_article]"]').val(data);
              },'html');
//               });
        });
        $('.resetbuton').unbind('click');
        $('.resetbuton').click(function(e){
            //supprimer toute la ligne
             e.preventDefault();
             //$('tr[name ="ligne['+$(this).data('id')+']"]').remove();
             //$("tr").eq($(this).data('id')).remove();
              $('#table_mois tr:eq('+$(this).data('id')+')').remove();
             // $('#table_mois thead').html(data);
//          },'html');
            //alert($(this).data('id'));
             $('input[name="refart['+$(this).data('id')+'][reference]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][code_article]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m1]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m2]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m3]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m4]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m5]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m6]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m7]"]').val(""); 
             $('input[name="refart['+$(this).data('id')+'][m8]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m9]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m10]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m11]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m12]"]').val("");
             $('.champM').first().change();
        });
    });
//    
    }
    });
    var id = newArticleLine();
    $('.champM').unbind('change');
        $('.champM').change(function(){
            console.log('plopM');
            var valeurTotal = 0;
            $('.champM').each(function(i,e){
                var valM = $(e).val();
                if(valM == "") {
                    valeurTotal+=0;
                } else {
                    valeurTotal+=parseFloat($(e).val());
                }
            });
            console.log("tagadaM : "+valeurTotal);
            if(valeurTotal > 0) {
                $('#submitM').attr('disabled', false);
                $('#mVide').hide();
            } else {
                $('#submitM').attr('disabled', true);
                $('#mVide').show();
            }
        });
        $('.resetbuton').unbind('click');
        $('.resetbuton').click(function(e){
            
             e.preventDefault();
            //alert($(this).data('id'));
             $('input[name="refart['+$(this).data('id')+'][reference]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][code_article]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m1]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m2]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m3]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m4]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m5]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m6]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m7]"]').val(""); 
             $('input[name="refart['+$(this).data('id')+'][m8]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m9]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m10]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m11]"]').val("");
             $('input[name="refart['+$(this).data('id')+'][m12]"]').val(""); 
             $('.champM').first().change();
        });
    $('input[name="refart['+id+'][reference]"]').change(function(e)
        {
              $.get ('/xprev/verifreference/reference/'+$(this).val(),
              {},
              function(data){
                   if(!$.trim(data)){
                  alert("la reference rentree n'existe pas dans movex"); }
                  $('input[name="refart['+id+'][code_article]"]').val(data);
              },'html');
//           });  
        });
    $('input[name="refart[0][reference]"]').attr('required',true);
    $('input[name="refart[0][code_article]"]').attr('required',true);
});