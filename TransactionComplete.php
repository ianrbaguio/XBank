<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

$accountID = '';
if(isset($_POST['accountID']))
{
    $accountID = substr(strip_tags($_POST['accountID']), 0,4) . "-" . substr(strip_tags($_POST['accountID']), 4, strlen(strip_tags($_POST['accountID'])));       
}

$error = "";

if(isset($_POST['errorTransaction']))
{
    $error = strip_tags($_POST['errorTransaction']);
}
?>

<html>
    <head>
        <title>XBank - Transaction Processed</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/XBankMain.css">
        <link rel="stylesheet" type="text/css" href="css/XBankTransactions.css">
    </head>
    <body>

        <header class="text-center">
            <h1> <img alt="X Bank Logo" src="images/XBankLogo.png"> A Bank Of Opportunity</h1>
        </header>



        <nav id="menu" class="header">
            <a style="background-color:white; color:black" href="main.php"> Bank Accounts </a>
            <a style="color:yellow; margin-left: 2%; " href="#"> Help </a>

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
        
        
        <div id="TransactionCompleteDiv" style="text-align: center; margin-top:10px; font-size: 12px;">
            <p style="font-weight:bold; font-size: 25px;">Transaction processed</p>
            
            <p><b>Transaction:</b> <span id="transactionType"><?php echo $_GET['transactionType']; ?></span> </p>
            <p><b>Amount: </b> $<span id="amount"><?php echo $_GET['amount']; ?></span></p>
            <p><b>Account: </b> <span id="accountID"><?php echo $accountID ?></span> </p>
            <p><b>Transaction Number: </b> <span id="transactionID"></span></p>
            <input type="hidden" value="<?php echo $_POST['accountID']; ?>" id="hiddenAccountID" name="hiddenAccountID"> 
        </div>
        
        <input type="hidden" value="<?php echo $error;?>" id="errorTransaction" name="errorTransaction">
        
        <div id="TransactionErrorDiv" style="text-align:center; margin-top:10px; font-size: 12px; display:none;">
            <p style="font-weight:bold; color:red; font-size: 25px;">Transaction Error</p>
            
            <p><b>Possible Error:</b> <span id="ErrorCauseSpan"></span></p>
            <p>Please try again</p>
            
        </div>
        
        <div id='footer' class="text-center">
            <hr/>
            © Ian Baguio <br>
            Date Created: January 31, 2018 <br>
            Date Modified: January 9, 2019 <br>

            <img src="images/XBankLogo.png" alt="XBank">
        </div>
       
        <script src="javascript/XBankTransactComplete.js" type="text/javascript"></script>
    </body> 
</html>
