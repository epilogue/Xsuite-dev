$(document).ready(function (){
    $('input.pda').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var ra = Number(100 - ((parseFloat($(this).val())*100)/parseFloat($('td#pwp-'+k).html()))).toFixed(2);
        $('input#ra-'+k).val(ra+'%');
        var ma = Number(1 -(parseFloat($('td#cif').val()))/parseFloat($(this).val())).toFixed(2);
    });
    $('input.ra').change(function (){
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        var pwp = parseFloat($('td#pwp-'+k).html());
        var ra = parseFloat($(this).val());
        
        var pda = Number(((100-ra)*pwp)/100).toFixed(2);
        $('input#pda-'+k).val(pda);
        $(this).val(parseFloat($(this).val())+'%')
    });
});
