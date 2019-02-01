<?php
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

//if(isset($_GET['accountType']))
//{
//    echo "Type: " . $_GET['accountType'];
//    echo "ID: ". $_POST['accountID'];
//        
//}
?>

<html>
    <head>
        <title>XBank - New Transaction</title>
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
        <link rel="stylesheet" type="text/css" href="css/XBankLoading.css">
    </head>
    <body>

        <header class="text-center">
            <h1> <img alt="X Bank Logo" src="images/XBankLogo.png"> A Bank Of Opportunity</h1>
        </header>



        <nav id="menu" class="header">
            <a style="background-color:white; color:black" href="main.php"> Bank Accounts </a>
            <a style="color:yellow; margin-left: 2%; " href="help.php"> Help </a>

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
        
        <div id="PageLoadingDiv">
            <div class="pageloading">
            </div>
            
            <p>Getting your information. Please wait.</p> 
        </div>

        <div class="container text-center center-block" id="TransactionOptions" style="margin-top:10px;">
            <b>Enter new Transaction: </b><br /><br/>
            <select id="TransactOptions">
                <option value="Deposit">Deposit</option>
                <option value="Withdraw">Withdraw</option>
                <option value="Transfer">Transfer</option>
            </select>
            <br /><br />
            <span id="AccountOption">To:</span> <select id="AccountDropDown"></select>
            <span id="TransferToOption" style="display:none"> <br/> <br/> To: <input id="AccountTypeNumber" type="text" maxlength="4" style="text-align:center; width: 50px;"> - <input id="AccountID" type="text" maxlength="4" style="text-align:center; width: 50px;"></span> <br /> <br/>
            Amount: <input type="text" id="Amount" name="Amount" placeholder="0.00" style="text-align:right;"> <br /> <br />
            <input class="ProcessButton" type="submit" name="ProcessTransaction" id="ProcessTransaction" value="Process" style="margin-right: 10px;" />
            <input class="OptionButtons" type="button" name="CancelTransaction" id="CancelTransaction" value="Cancel" onclick="window.location = 'main.php'" style="margin-right: 10px; " />
        </div>
        
        <div id="HiddenDatasDiv">
            <input type="hidden" id="accountType" name="accountType" value="<?php echo $_GET['accountType']; ?>">
            <input type="hidden" id="accountID" name="accountID" value="<?php echo $_POST['accountID'];?>">
        </div>
        
        <div id="errorDiv" class="text-center">
            
        </div>
        
        <div id="ProcessTransactionDiv" style="display:none; margin-top:10px;">
        <h2 class="text-center">Please wait while we process your transaction.</h2>
        <div id="LoaderDiv" class="loader"></div>
        </div>

        <div id='footer' class="text-center">
            <hr/>
            © Ian Baguio <br>
            Date Created: January 31, 2018 <br>
            Date Modified: January 9, 2019 <br>

            <img src="images/XBankLogo.png" alt="XBank">
        </div>
      
        <script src="javascript/XBankNewTransact.js" type="text/javascript">
        </script>
    </body> 
</html>