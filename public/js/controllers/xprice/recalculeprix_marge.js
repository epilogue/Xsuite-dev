function calculTotal() {
    var total = 0;
    $("input.caa").each(function (i, e){
        total += parseFloat($(e).val());
    });
    $("#caat").val(total);
}
function moyenne(){
    var aa = 0;
    $("input.caa").each(function (i, e){
        aa += parseFloat($(e).val());
    });
     
     var b = parseFloat($('td.cab').html());
var moy =Number(b);
    $("input#mo").val(aa);
    
}

function moyenneMarge(){
     var totalma = 0;
     var nombrema=0;
    $("input.ma").each(function (i, e){
        totalma += parseFloat($(e).val());
        nombrema++;
    });
    
    var moyma = totalma/nombrema;
    $("input#mamo").val(moyma);
}

$(document).ready(function (){
    $('input.pda').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var qt =parseFloat($('td#qt-'+k).html());
        var caa=((parseFloat($(this).val()))*qt);
        $('input#caa-'+k).val(caa);
        var ra = Number(100 - ((parseFloat($(this).val())*100)/parseFloat($('td#pwp-'+k).html()))).toFixed(2);
        $('input#ra-'+k).val(ra+'%');
        var ma = Number(100*(1 -(parseFloat($('td#cif-'+k).html())/parseFloat($(this).val())))).toFixed(2);
         $('input#ma-'+k).val(ma+'%');
         calculTotal();
         moyenne();
         moyenneMarge();
    });
    $('input.ra').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var qt =parseFloat($('td#qt-'+k).html());
        var pwp = parseFloat($('td#pwp-'+k).html());
        var ra = parseFloat($(this).val());
        var pda = Number(((100-ra)*pwp)/100).toFixed(2);
        $('input#pda-'+k).val(pda);
        var caa=((Number(((100-ra)*pwp)/100))*qt);
        $('input#caa-'+k).val(caa);
        var ma = Number(100*(1-(parseFloat($('td#cif-'+k).html())/Number(((100-ra)*pwp)/100))).toFixed(2));
        $('input#ma-'+k).val(ma+'%');
        $(this).val(parseFloat($(this).val())+'%');
        calculTotal();
        moyenne();
        moyenneMarge();
    });
    
     $('input.ma').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var qt = parseFloat($('td#qt-'+k).html());
        var pwp = parseFloat($('td#pwp-'+k).html());
        var cif = parseFloat($('td#cif-'+k).html());
        var ma = parseFloat($(this).val());
        var pda = Number(cif/(1-(ma/100))).toFixed(2);
        $('input#pda-'+k).val(pda);
        var caa=((Number(cif/(1-(ma/100))))*qt);
        $('input#caa-'+k).val(caa);
        $(this).val(parseFloat($(this).val())+'%');
        var ra = Number(100-(Number(pda))*100/pwp).toFixed(2);
        $('input#ra-'+k).val(ra);
        
        calculTotal();
        moyenne();
        moyenneMarge();
    });
});
