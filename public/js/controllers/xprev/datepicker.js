/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 *  Type: Date or Number or String
Default: null
The minimum selectable date. When set to null, there is no minimum.
Multiple types supported:

    Date: A date object containing the minimum date.
    Number: A number of days from today. For example 2 represents two days from today and -1 represents yesterday.
    String: A string in the format defined by the dateFormat option,
     or a relative date. Relative dates must contain value and period pairs;
      valid periods are "y" for years, "m" for months, "w" for weeks, and "d" for days. 
      For example, "+1m +7d" represents one month and seven days from today.

Code examples:

Initialize the datepicker with the minDate option specified:
1
2
3
	

$( ".selector" ).datepicker({
  minDate: new Date(2007, 1 - 1, 1)
});
 */

$(document).ready(function(){
     $("#monthpicker").MonthPicker({
       lang:'fr',
       MinMonth:1,
       MaxMonth:'+1y'
    });
    
    $("#monthpicker").change(function(e){
        
    $.get ('/xprev/liaisonmois/date_debut/'+$(this).val(),
          {},
          function(data){
              $('#motif_create').html(data);
          },'html');
    });
});