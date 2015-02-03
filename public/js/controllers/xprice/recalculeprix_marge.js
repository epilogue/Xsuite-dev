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
     
     var b = parseFloat($('input#cab').val());
var c= Number(100*(1-(aa/b)));
    $("input#mo").val(c);
    
}

function moyenneMarge(){
        var ccif=parseFloat($('input#ccif').val());
          var ccat = parseFloat($('input#caat').val());
    
    var moyma =100*(1- (ccif /ccat));
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
