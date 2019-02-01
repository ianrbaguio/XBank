<?php

require_once 'functions.php';

//Opens up a new session when someone logged-in
//if( isset($_POST['submit']) && $_POST['submit'] == 'Log In' &&
//$_POST['username'] == "admin" && $_POST['password'] == "Test123")
//{
//    $_SESSION['username'] = 'admin';
//    $_SESSION['password'] = $_POST['password'];
//    
//    $_POST['security'] = "Enter admin password";
//    $_POST['answer'] = "Test123";
//    
//    header("Location:SQuestion.php");
//    
//    die();
//}

?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <title>XBank</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/XBankCSS.css">
    </head>
    <body>
        <header class="text-center">
            <div>
            <h1 id="header">Welcome to <img  alt="X Bank Logo" src="images/XBankLogo.png"></h1>
            </div>
        </header>
        
        <!--LOGIN DIV -->
        <div id="login" class="header">
            <a class="current_header" style="color:black;" href="index.php"> Online Banking </a>
            <a href='AboutXBank.php'>About XBank </a> 
       </div>
       
        <div id="signIn" class="container login">
            
            <div class='sign_in_div'>       
                   
            <h3>Sign in to Online Banking</h3>
            
             <form method="post" action="index.php">
                Username: <input type='text' name="username" style='color:black;'> </br> </br>
                Password: <input type='password' name="password" style='color:black;'> </br>
                <input type="submit" name='submit' value='Log In' class="login_button">
            </form>
            
            <p style="color: red; margin-left: 75px; margin-top: 10px;"> <?php echo $error; ?></p>
                
            </div>
               
            
            <div class='newMember'>
                <h3 class="new_member_h3" style=''> New Member?</h3> </br>     
                <input type='button' name='SignUp' value='Sign Up' class="signup_button" onClick="document.location.href='signup.html'">
            </div>
                
            
            
        </div>
        
<!--        <div id="indexStatus">
            <p style="text-align: center;"> Status: <?php //echo $status;?></p>
        </div>-->
        
        <div id='footer'>
                <hr>
            © Ian Baguio <br>
            Date Created: January 31, 2018 <br>
            Date Modified: January 9, 2019 <br>
            
            <img src="images/XBankLogo.png" alt="XBank">
        </div>
        
    <script src="javascript/XBankJS.js" type="text/javascript"></script>
    </body>
    
</html>
