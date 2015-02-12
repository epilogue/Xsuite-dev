/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    //var plop= $('input#fermeturevalide').val();

function changeyourbody(){
    var plop= $('input#fermeturevalide').val();
    alert(plop);
 if(plop=="fermee"){
        $('html').css('background-image', 'url("/images/Valide2.jpg")');
    }
    
};
