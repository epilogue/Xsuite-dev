$(document).ready(function (){
    $('.changepr').change(function(){
        var valeurTotal = 0;
        var totalM= parseInt($(this).data('msums'));
        var amount= parseFloat($(this).val());
        var finalAmount = totalM * amount;
        
        $('#'+$(this).data('targetid')).val(finalAmount);
        
        $('.valeurTotale').each(function(i,e){
            valeurTotal+=parseFloat($(e).val());
        });
        $('#spanTotal').html(valeurTotal);
    });
});