<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'dbUtility.php';
require_once 'functions.php';

$clientID = $_SESSION['clientID'];



$getData = Array();
$chequingData = Array();
$savingsData = Array();
$accountData = Array();
$returnData = Array();

$chosenAccount = strip_tags($_POST['account']);
$chosentype = strip_tags($_POST['type']);

//pagination variables
$limit = 10;
$page = 1;
$totalpage = 1;

if (isset($_GET['page']))
{
    $page = strip_tags($_GET['page']);
    
}

$result = mysqli_query($db,"SELECT COUNT(*) as 'Total' from Transactions WHERE AccountID = '$chosenAccount' ORDER BY TransactionDate desc");
$data = mysqli_fetch_assoc($result);

if(ceil($data['Total'] / $limit) > 1)
{
    $totalpage = ceil($data['Total'] / $limit);
    
    if($page > $totalpage)
    {
        $page = $totalpage;
    }
}
    
$offset = ($page - 1) * $limit;

GetTransactions($chosentype, $chosenAccount);

function GetTransactions($type, $id)
{
    global $getData, $db, $clientID, $chequingData, $savingsData, $accountData, $returnData, $limit,$totalpage, $offset;

    $selectedAccountID = 0;
    $selectedAccountBalance = 0;

    //Grabs the accountID 
    $chequingQuery = "SELECT ChequingID, ChequingBalance FROM Chequing WHERE ClientID = '$clientID'";
    if ($result = mysqli_query($db, $chequingQuery))
    {
        while ($row = mysqli_fetch_array($result))
        {
            array_push($chequingData, array("chequingID" => $row['ChequingID'], "chequingBalance" => $row['ChequingBalance']));
        }
    }


    //Grabs the accountID 
    $savingsQuery = "SELECT SavingsID, SavingsBalance FROM Savings WHERE ClientID = '$clientID'";
    if ($result = mysqli_query($db, $savingsQuery))
    {
        while ($row = mysqli_fetch_array($result))
        {

            array_push($savingsData, array("savingsID" => $row['SavingsID'], "savingsBalance" => $row['SavingsBalance']));
        }
    }

    //Grabs the selected account details
    if (strtolower($type) == "chequing")
    {
        $selectedchequingQuery = "SELECT ChequingID, ChequingBalance FROM Chequing WHERE ChequingID = '$id' and ClientID = '$clientID'";
        if ($result = mysqli_query($db, $selectedchequingQuery))
        {
            while ($row = mysqli_fetch_array($result))
            {
                $selectedAccountID = $row['ChequingID'];
                $selectedAccountBalance = $row['ChequingBalance'];
            }

            $accountData = array("id" => $selectedAccountID, "balance" => $selectedAccountBalance);
        }
    } elseif (strtolower($type) == "savings")
    {
        $selectedsavingsQuery = "SELECT SavingsID, SavingsBalance FROM Savings WHERE SavingsID = '$id' and ClientID = '$clientID'";
        if ($result = mysqli_query($db, $selectedsavingsQuery))
        {
            while ($row = mysqli_fetch_array($result))
            {
                $selectedAccountID = $row['SavingsID'];
                $selectedAccountBalance = $row['SavingsBalance'];
            }

            $accountData = array("id" => $selectedAccountID, "balance" => $selectedAccountBalance);
        }
    }

    //Grabs all transactions based on accountID
    
    $TransactionQuery = "SELECT TransactionDate AS TransactionDate, Description, Amount, Balance FROM Transactions WHERE AccountID = '$id' ORDER BY TransactionDate desc LIMIT ". $limit . " OFFSET ". $offset;
    if ($result = mysqli_query($db, $TransactionQuery))
    {
        while ($row = mysqli_fetch_array($result))
        {

            //stores id and balance to the postData array
            array_push($getData, array("date" => date('F j, Y', strtotime($row['TransactionDate'])), "description" => $row['Description'], "amount" => $row['Amount'], "balance" => $row['Balance']));
        }
    }
    $returnData = array("data" => $getData, "chequing" => $chequingData, "savings" => $savingsData, "account" => $accountData, "totalpages" => $totalpage);

    echo json_encode($returnData);
}

?>
