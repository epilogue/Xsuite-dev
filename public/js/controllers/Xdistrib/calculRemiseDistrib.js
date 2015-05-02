function calculTotal() {
    var total = 0;
    
    $("input.caa").each(function (i, e){
        total += parseFloat($(e).val());
    });
    $("#caat-affiche").val(defaultFormat(total));
    $("#caat").val(Number(total).toFixed(2));
}
function calculTotalcif() {
    var total = 0;
    $("input.totcif").each(function (i, e){
        total += parseFloat($(e).val());
    });
    $("#ccif-affiche").val(defaultFormat(total));
    $("#ccif").val(Number(total).toFixed(2));
}

function calculTotalfob() {
    var total = 0;
    $("input.totfob").each(function (i, e){
        total += parseFloat($(e).val());
    });
    $("#cfob-affiche").val(defaultFormat(total));
    $("#cfob").val(Number(total).toFixed(2));
}
function moyenne(){
    var aa = 0;
    $("input.caa").each(function (i, e){
        aa += parseFloat($(e).val());
    });
     
    var b = parseFloat($('input#cab').val());
    var c = Number(100*(1-(aa/b))).toFixed(2);
    $("input#mo").val(c + '%');
    
}

function moyenneMarge(){
    var ccif = parseFloat($('input#ccif').val());
    var ccat = parseFloat($('input#caat').val());
    
    var moyma = 100*(1- (ccif /ccat)).toFixed(2);
    $("input#mamo").val(moyma +'%');
}

function moyenneMargeFob(){
   
    var tpd = parseFloat($('input#tpd').val());
    var ccif = parseFloat($('input#ccif').val());
    var moymafob = 100*(1- (ccif /tpd)).toFixed(2);
//    $("input#mamofob").val(defaultFormat(moymafob) +'%');
    $("input#mamofob").val(moymafob+'%');
}


$(document).ready(function (){
    $('input.pda').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var qt = parseFloat($('td#qt-'+k).html());
        var cif = parseFloat($('td#cif-'+k).html());
        var caa=((parseFloat($(this).val()))*qt);
        $('input#caa-'+k).val(caa);
        var ra = Number(100 - ((parseFloat($(this).val())*100)/parseFloat($('input#pwp-'+k).val()))).toFixed(2);
        $('input#ra-'+k).val(ra+'%');
         /*marge=1-(coutCif/prixvente)*/
        var ma = Number(100*(1 -(cif/parseFloat($(this).val())))).toFixed(2);
        $('input#ma-'+k).val(ma+'%');
        calculTotal();
        moyenne();
        moyenneMarge();
    });
    $('input.ra').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var qt =parseFloat($('td#qt-'+k).html());
        var pwp = parseFloat($('input#pwp-'+k).val());
        var ra = parseFloat($(this).val());
        var cif = parseFloat($('td#cif-'+k).html());
        var pda = Number(((100-ra)*pwp)/100).toFixed(2);
        $('input#pda-'+k).val(pda);
        var caa=((Number(((100-ra)*pwp)/100))*qt);
        $('input#caa-'+k).val(caa);
        /*marge=1-(coutCif/prixvente)*/
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
        var pwp = parseFloat($('input#pwp-'+k).val());
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
     $('input.margefob').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var qt = parseFloat($('td#qt-'+k).html());
        var pwp = parseFloat($('input#pwp-'+k).val());
        var cif = parseFloat($('td#prixcif-'+k).html());
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
    $('input.prixcif').change(function(){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
          var qt = parseFloat($('td#qt-'+k).html());
        var pd = parseFloat($('td#pd-'+k).html());
        var prixcif = parseFloat($(this).val());
        $(this).val(parseFloat($(this).val())+'€'); 
        var totcif=Number(prixcif*qt).toFixed(2);
        var margefob = Number(100*(1-(prixcif/pd))).toFixed(2);
        $('input#margefob-'+k).val(margefob +'%');
        $('input#totcif-'+k).val(totcif);
        calculTotal();
        moyenne();
        moyenneMarge();
        calculTotalcif();
        moyenneMargeFob();
    });
     $('input.prixfob').change(function(){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var qt = parseFloat($('td#qt-'+k).html());
        var pd = parseFloat($('td#pd-'+k).html());
        var prixfob = parseFloat($(this).val());
         var totfob=Number(prixfob*qt).toFixed(2);
         $(this).val(parseFloat($(this).val())+'€'); 
          $('input#totfob-'+k).val(totfob);
         calculTotalfob();
          });
          
    $('#ouiFob').click(function(){
        $('input.prixcif').change();
        return true;
    });
});
