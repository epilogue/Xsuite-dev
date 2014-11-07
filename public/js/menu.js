/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

deroule = function(){
    var derouleElement = document.getElementById("menu").getElementsByTagName("li");
    for(var i=0;i<derouleElement.length;i++){
        derouleElement[i].onmouseover = function(){
            this.className+= "deroule";
        }
        derouleElement[i].onmouseover = function(){
            this.className = this.className.replace(new RegExp("derouleb"),"");
        }
    }
}
if(window.attachEvent)
    window.attachEvent("onload",deroule);