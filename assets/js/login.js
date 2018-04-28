$(document).ready(function(){
    'use strict' ;
    /*Close the message*/
    $('.close-it-fast').click(function () {
        console.log($(this).parent().parent().fadeOut('slow'));
    });


    $(".login").animate({margin:'100px auto'},500);
    $(".login").animate({width:'400px'},500);
    $(".login").animate({maxHeight:'500px'},1000);
    
});
    



