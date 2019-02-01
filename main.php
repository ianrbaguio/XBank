<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of main
 *
 * @author IanBaguio
 */
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if (!($_SESSION['username']) && !($_SESSION['clientID']))
{
    session_destroy();

    header("Location:index.php");

    die();
}

//$security = 'Enter admin password ';
//$answer = 'Test123';
//Cancel button
if (isset($_POST['submit']) && $_POST['submit'] == "Log Out")
{
    //Destroy session
    session_destroy();

    header("Location:index.php");

    die();
}
?>

<html>
    <head>
        <title>XBank - Welcome</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/XBankMain.css">
    </head>
    <body>

        <header class="text-center">
            <h1> <img alt="X Bank Logo" src="images/XBankLogo.png"> A Bank Of Opportunity</h1>
        </header>



        <nav id="menu" class="header">
            <a style="background-color:white; color:black" href="main.php"> Bank Accounts </a>
            <a style="color:yellow; margin-left: 2%; " href="help.php?source=livechat"> Help </a>

            <div style="float: right" class="AccountDropDown">                       
                <button class="dropbtn"> <img src="images/XBank profilepic logo.gif"> <?php echo $_SESSION["username"] ?> <i id="caretdown" class="fa fa-caret-down"> </i>
                </button>
                <div class="AccountDropDown-Content">
                    <a href="#">Profile</a>
                    <form method="post" action="main.php">
                        <input type="submit" name="submit" value="Log Out">
                    </form>
                </div>
            </div>
        </nav>

        <hr>

        <div id="PageLoadingDiv">
            <div class="pageloading">
            </div>
            
            <p>Getting your information. Please wait.</p> 
        </div>

        <div class='container' style="font-size: 14px; width: 60%;" >


            <!-- <h3><b>NOTE:</b> Logged-in page is still in a work in progress and is not live yet. Thank you for testing XBank.</h3> -->

            <div id="BankAccounts">
                <form method='post' action='Transactions.php?page=1'>
                    <table id="BankAccountsTable">

                    </table>
                </form>
            </div>

            <div id="TestDiv">

            </div>

        </div>

        <div id='footer' class="text-center">
            <hr>
            © Ian Baguio <br>
            Date Created: January 31, 2018 <br>
            Date Modified: January 9, 2019 <br>

            <img src="images/XBankLogo.png" alt="XBank">
        </div>

        <script src="javascript/XBankMain.js" type="text/javascript"></script>
    </body> 
</html>
