<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functions.php';

$answerStatus = '';


//Check's if there's a logged in user if not then redirect to index page
if(!($_SESSION['username']) && !($_SESSION['clientID']))
{
    session_unset();
    
    session_destroy();
    
    header("Location:index.php");
    
    die();
}
else
{
    $username = $_SESSION['username'];
    $clientID = $_SESSION['clientID'];
}

//user clicked on cancel button
if(isset($_POST['submit']) && $_POST['submit'] == "Cancel")
{
    //destroys session
    session_destroy();
    
    header("Location:index.php");
    
    die();
}

/************************************************
 * Grabs security question from database
 ************************************************/
$username = strip_tags($_SESSION['username']);

//Filters for user security question
$query = "SELECT SecurityQuestion FROM Clients WHERE username = '$username'";

$result = mysqli_query($db, $query);

$row = mysqli_fetch_array($result);

$sQuestion = $row['SecurityQuestion'];

/*****************************************************
 * Checks answer
 *****************************************************/
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //OK button clicked
    if(isset($_POST['submit']) && $_POST['submit'] == "OK" && !empty($_POST['answer']))
    {
        $sAnswer = mysqli_real_escape_string($db, strip_tags($_POST['answer']));
        
        $query = "SELECT SecurityAnswer from Clients WHERE username = '$username'";
        //run query
        if($result = mysqli_query($db, $query))
        {
            //grab data from row
            while($row = mysqli_fetch_array($result))
            {
                if(password_verify($sAnswer, $row['SecurityAnswer']))
                {
                    $_SESSION['username'] = $username;
                    
                    $_SESSION['clientID'] = $clientID;
                   
                    header("Location:main.php");
                   
                    die();
                }
                else
                {
                    $answerStatus = 'Incorrect answer.';
                }
            }
        }
        
        
    }
}

//Checks if there's a logged in user
//if(!($_SESSION["username"]))
//{
//    header("Location:index.php");
//    
//    die();
//}

//$security = 'Enter admin password ';
//$answer = 'Test123';
//
////Cancel button
//if(isset($_POST['submit']) && $_POST['submit'] == "Cancel")
//{
//    //Destroy session
//    session_destroy();
//    
//    header("Location:index.php");
//    
//    die();
//}
//
//if(isset($_POST['submit']) && $_POST['submit'] == "OK"
//        && $_POST['answer'] == $answer)
//{
//    header("Location:main.php");
//    
//    die();
//}
?>

<html>
    <head>
        <title>XBank - Security Question</title>
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
           
            <div id='SQuestion'>
                <div class="question_div">
                    Question: <?php
                    echo $sQuestion;
                ?>
                </div>
                
                <form method='post' action='SQuestion.php'>
                    <div class="answer_div">
                    <span class='required'>Answer:</span> <input type='text' name='answer' size='20'>
                    <p style="color:red;"> <?php echo $answerStatus; ?></p>
                </div>
                
                <input class='OKButton' type='submit' name='submit' value='OK'>
                <input class='CancelButton' type='submit' name='submit' value='Cancel'>
                </form>
                
            </div>
            
            <h3> <b style='color: red;'>WARNING:</b> </h3> <p>For security purposes, we would like you to enter your personal security question everytime you login for security purposes. </p>
            
           <!-- <p><b>NOTE:</b> Logged-in page is still in a work in progress and is not live yet. Thank you for testing XBank.</p> -->
            
        </div>
        
        <div id='footer'>
                <hr>
            © Ian Baguio <br>
            Date Created: January 31, 2018 <br>
            Date Modified: January 9, 2019 <br>
            
            <img src="images/XBankLogo.png" alt="XBank">
        </div>    
 </body>
 
</html>

