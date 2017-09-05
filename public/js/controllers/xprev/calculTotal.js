$(document).ready(function (){
    $('.changepr').change(function(){
        var totalM= parseInt($(this).data('msums'));
        var amount= parseFloat($(this).val());
        var finalAmount = totalM * amount;
        
        $('#'+$(this).data('targetid')).val(finalAmount);
    });
});