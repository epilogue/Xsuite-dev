/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $(document).ready(function (){
     $(function() {
        var idT = $(this).attr('id').split('-');
        var k = idT[1];
        $( "div#dialog-" +k).dialog({
           
        autoOpen: false,
        show: {
        effect: "blind",
        duration: 1000
        },
        hide: {
        effect: "explode",
        duration: 1000
        }
        });
        $("button.historique" ).click(function() {
            var idT = $(this).attr('id').split('-');
            var k = idT[1];
            $( "div#dialog-"+k ).dialog( "open" );
        });
});
});
