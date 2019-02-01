/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function ()
{
    //First FadeOut (Welcome to XBank)
    $("#header").fadeOut(3000, function ()
    {
        // $(this).html('<h1>A Bank of Opportunity <img src="images/XBankLogo.png" height="190" /><h1>').fadeToggle(3000);

        $(this).html('<h1>A Bank of Opportunity <img src="images/XBankLogo.png" height="190" /><h1>').fadeToggle(3000);

        //Second FadeOut (A Bank of Opportunity)
        $(this).fadeOut(3000, function ()
        {
            $(this).html("");

            //Last FadeIn(XBankLogo)
            $(this).prepend('<img src="images/XBankLogo.png" />').fadeToggle(3000);
        });
    });
});

