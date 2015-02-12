/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    var plop= $('input#fermeturevalide').val();
 if(plop=="fermee"){
        $("body").addClass("fermee");
      // $("p").css({ color: "red", background: "blue" });
    }
 if(plop=="nonValide"){
      $("body").addClass("refusee");
 }
    
});

function changeyourbody(){
    
};

