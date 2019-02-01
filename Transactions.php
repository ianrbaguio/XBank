<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if(isset($_POST['accountdetails']))
{
    $_SESSION['accountdetails'] = $_POST['accountdetails'];
}

$accountDetails = $_SESSION['accountdetails'];
$splitIndex = strpos($accountDetails, "|");

$accountType = substr($accountDetails, 0, $splitIndex);
$selectedID = substr($accountDetails, $splitIndex + 1, strlen($accountDetails));

$page = 1;

if(isset($_GET['page']))
{
    $page = strip_tags($_GET['page']);
}



if(!($_SESSION['username']) && !($_SESSION['clientID']))
{
    session_destroy();
    
    header("Location:index.php");
    
    die();
}

//LogOut button
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
        <title>XBank - Transactions</title>
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
                <button class="dropbtn"> <img src="images/XBank profilepic logo.gif"> <?php echo $_SESSION["username"] ?> <i id="caretdownTrans" class="fa fa-caret-down"> </i>
                </button>
                <div class="AccountDropDown-Content">
                    <a href="#">Profile</a>
                    <form method="post" action="Transactions.php">
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

        <input type="hidden" value="<?php echo $accountType ?>" name="AccountType" id="AccountType">
        <input type="hidden" value="<?php echo $selectedID ?>" name="AccountTypeID" id="AccountTypeID">
        <input type="hidden" value="<?php echo $page ?>" name="CurrentPage" id="HiddenCurrentPage">

        <div class='container' style="font-size: 14px; width: 75%; margin-top: 25px;" >

            <div id="TransactionsAccountInfo" style="background-color: #cccccc">

                <dl id="TransactionInfos">
                    <dt id="AccountType"><?php echo $accountType ?></dt> <dd id="AccountNumber">0000-0000</dd>
                    <dt>Balance</dt> <dd id="BalanceStatus">$0.00</dd>
                </dl>

            </div>

            <div id="TransactionOptions" style="background-color: blue; color:yellow; margin-bottom: 10px;">
                <span style="font-weight:bold; margin-left: 5px;">What would you like to do?</span>
                <br />
                <br/>
                <form method="post" action="NewTransaction.php?accountType=<?php echo $accountType ?>">
                    <button class="OptionButtons" value="<?php echo $selectedID ?>" name="accountID" >Deposit/Withdraw</button>
                </form>
                <br/><span style="font-weight:bold; margin-left: 5px;">- OR -</span><br />
                <span style="margin-left:5px;">From: <select class="DropDownOptions" id="FromDropDown"> </select> To:  <select class="DropDownOptions" id="ToDropDown" ></select> <br />
                <span style="margin-left:5px;">Amount: </span> <input class="transaction_amount" type="text" name="amount" id="amount" placeholder="$0.00"> <button class="OptionButtons" id="TransferButton" style="margin-bottom: 5px; width: 150px;">Transfer</button></span>
                
                <div id="TransferOptionErrorDiv" style="color:yellow; padding:5px;">
                    
                </div>
            </div>

            <div id="TransactionsBody">
                <!--<table id="TransactionsTable">
                    
                </table>-->
            </div>
            
            <div id="paginationDiv" class="pagination">

            </div>

        </div>

        <div id='footer'>
            <hr>
            © Ian Baguio <br>
            Date Created: January 31, 2018 <br>
            Date Modified: January 9, 2019 <br>
            <img src="images/XBankLogo.png" alt="XBank">
        </div>
        
        <script src="javascript/XBankTransactions.js" type="text/javascript"></script>
    </body>

</html>
