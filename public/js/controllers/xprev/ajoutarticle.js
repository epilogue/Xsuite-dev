/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var articleId = 0;

function newArticleLine() {
    var baseHtml = $('#addRefTPL').html();
    var toHtml = baseHtml.replace(/__id__/g, articleId);
    $("#table_mois").append(toHtml);
    var usedAid = articleId;
    articleId++;
    return usedAid;
}

$(document).ready(function(){
     $("#ajout_article").click(function(e){
         e.preventDefault();
         console.log('plop');
        var id = newArticleLine();
        console.log(id);
                 //name="refart[__id__][reference]"
        $('input[name="refart['+id+'][reference]"]').change(function(e)
        {
            console.log('tagada');
              $.get ('/xprev/verifreference/reference/'+$(this).val(),
              {},
              function(data){
                  $('#refart['+$(this).data(id)+'][code_article]').val(data);
              },'html');
        });
    //});
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
        });
    });
    var id = newArticleLine();
    $('input[name="refart['+id+'][reference]"]').change(function(e)
        {
              $.get ('/xprev/verifreference/reference/'+$(this).val(),
              {},
              function(data){
                  $('#refart['+$(this).data(id)+'][code_article]').val(data);
              },'html');
        });
    $('select[name="refart[0][reference]"]').attr('required',true);
    $('input[name="refart[0][code_article]"]').attr('required',true);
    
});

