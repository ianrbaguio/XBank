<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functions.php';
?>

<html>
    <head>
        <title>XBank - Registered</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/XBankSQuestion.css">
    </head>
    <body>

        <header class="text-center">
            <h1> <img alt="X Bank Logo" src="images/XBankLogo.png"></h1>
        </header>


        <hr>

        <div class='text-center container'>


            <h2><b>New member registered!</b></h2> <br>
            
            <h2><b><?php echo $registrationStatus; ?></b></h2> <br>

            <h3><b>Thank you for choosing XBank, you will be redirected to login page, if the page didn't redirect in 5 secs please click 
                    <a href='index.php'>here</a></b></h3> <br>

            <p id='javascriptTest'> </p>

            <div id='footer'>
                <hr>
                © Ian Baguio <br>
                Date Created: January 31, 2018 <br>
                Date Modified: January 9, 2019 <br>

                <img src="images/XBankLogo.png" alt="XBank">
            </div>


            <script src="javascript/XBankRegistration.js" type="text/javascript"></script>
    </body>

</html>
