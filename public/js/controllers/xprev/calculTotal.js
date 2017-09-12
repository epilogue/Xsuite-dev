$(document).ready(function (){
    $('.changepr').change(function(){
        var valeurTotal = 0;
        var totalM= parseInt($(this).data('msums'));
        var amount= parseFloat($(this).val());
        var finalAmount = totalM * amount;
        
        $('#'+$(this).data('targetid')).val(finalAmount);
        
        console.log(valeurTotal);
        $('.valeurTotale').each(function(i,e){
            console.log(parseFloat($(e).val()));
            valeurTotal+=parseFloat($(e).val());
            console.log(valeurTotal);
        });
            console.log(valeurTotal);
        $('#spanTotal').html(valeurTotal);
    });
});