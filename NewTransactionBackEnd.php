<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'dbUtility.php';
require_once 'functions.php';

$clientID = $_SESSION['clientID'];

$returnData = array(); //json encoded return data
$transactReturnData = array();

$selectedAccountData = array(); //selected account for dropdown first option

$accountData = array(); //grabs all savings/chequing account

if (isset($_POST['accountType']) && isset($_POST['accountID']))
{
    GetAccounts(strip_tags($_POST['accountType']), strip_tags($_POST['accountID']));
}

if (isset($_POST['newTransaction']))
{
    $transaction = strip_tags($_POST['newTransaction']);

    $amount = strip_tags($_POST['amount']);
    $accountID = strip_tags($_POST['id']);
    $accountType = strtolower(strip_tags($_POST['type']));
    $clientID = strip_tags($_SESSION['clientID']);

    switch (strtolower($transaction))
    {
        //deposit transaction
        case "deposit":
            $output = "";

            $depositQuery = "CALL sp_Transactions('deposit', 'DEPOSIT', '$amount', '$clientID', '$accountType', '$accountID', NULL, NULL, @depOut)";

            if ($result = mysqli_query($db, $depositQuery))
            {
                while ($row = mysqli_fetch_array($result))
                {
                    $output = $row['result'];
                }

                $transactReturnData = array("output" => $output);

                echo json_encode($transactReturnData);
            } else
            {
                echo "Error: " . $depositQuery . "<br />" . mysqli_error($conn);
            }
            break;

        //withdraw transaction
        case "withdraw":
            $output = "";

            $withdrawQuery = "CALL sp_Transactions('withdraw', 'WITHDRAW', '$amount', '$clientID', '$accountType', '$accountID', NULL, NULL, @withOut)";

            if ($result = mysqli_query($db, $withdrawQuery))
            {
                while ($row = mysqli_fetch_array($result))
                {
                    $output = $row['result'];
                }

                $transactReturnData = array("output" => $output);

                echo json_encode($transactReturnData);
            } else
            {
                echo "Error: " . $withdrawQuery . "<br />" . mysqli_error($conn);
            }
            break;
        case "transfer":
            $output = "";
            $transferAccountID = strip_tags($_POST['transfer']);
            $transferType = "";

            $checkTransferAccountType = "SELECT * FROM Savings WHERE SavingsID = '$transferAccountID';";
            
            $result = mysqli_query($db, $checkTransferAccountType);
            
            if (mysqli_num_rows($result) == 1)
            {
                $transferType = "savings";
            } else
            {
                $checkTransferAccountType = "SELECT * FROM Chequing WHERE ChequingID = '$transferAccountID';";
                
                $result = mysqli_query($db, $checkTransferAccountType);

                if (mysqli_num_rows($result) == 1)
                {
                    $transferType = "chequing";
                } else
                {
                    $output = "unknown account";
                    $transactReturnData = array("output" => $output);
                    echo json_encode($transactReturnData);
                    break;
                }
            }

            if ($transferType != "")
            {
                $transferQuery = "CALL sp_Transactions('transfer', 'TRANSFER', '$amount', '$clientID', '$accountType', '$accountID', '$transferType', '$transferAccountID', @transferOut)";
                if ($result = mysqli_query($db, $transferQuery))
                {
                    while ($row = mysqli_fetch_array($result))
                    {
                        $output = $row['result'];
                    }

                    $transactReturnData = array("output" => $output);

                    echo json_encode($transactReturnData);
                } else
                {
                    echo "Error: " . $transferQuery . "<br />" . mysqli_error($conn);
                }
            }


            $transferQuery = "";
            break;
        default:
            $output = "Unknown Transaction";
            $transactReturnData = array("output" => $output);

            echo json_encode($transactReturnData);
            
    }
}

function GetAccounts($selectedType, $selectedID)
{
    global $getData, $db, $clientID, $selectedAccountData, $savingsData, $accountData, $returnData;

    $excludeChequingID = 0;
    $excludeSavingsID = 0;

    if (strtolower($selectedType) == 'savings')
    {
        $savingsQuery = "SELECT SavingsID, SavingsBalance FROM Savings WHERE SavingsID = '$selectedID'";

        if ($result = mysqli_query($db, $savingsQuery))
        {
            while ($row = mysqli_fetch_array($result))
            {
                $selectedAccountData = array("id" => $row['SavingsID'], "balance" => $row['SavingsBalance'], "type" => "savings");
            }
        }

        $excludeSavingsID = $selectedID;
    } else if (strtolower($selectedType) == 'chequing')
    {
        $chequingQuery = "SELECT ChequingID, ChequingBalance FROM Chequing WHERE ChequingID = '$selectedID'";

        if ($result = mysqli_query($db, $chequingQuery))
        {
            while ($row = mysqli_fetch_array($result))
            {
                $selectedAccountData = array("id" => $row['ChequingID'], "balance" => $row['ChequingBalance'], "type" => "chequing");
            }
        }

        $excludeChequingID = $selectedID;
    }

    //Grabs all account
    $chequingQuery = "SELECT ChequingID, ChequingBalance FROM Chequing WHERE ClientID = '$clientID' AND ChequingID <> '$excludeChequingID'";

    if ($result = mysqli_query($db, $chequingQuery))
    {
        while ($row = mysqli_fetch_array($result))
        {
            array_push($accountData, array("id" => $row['ChequingID'], "balance" => $row['ChequingBalance'], "type" => "chequing"));
        }
    }

    $savingsQuery = "SELECT SavingsID, SavingsBalance FROM Savings WHERE ClientID = '$clientID' AND SavingsID <> '$excludeSavingsID'";

    if ($result = mysqli_query($db, $savingsQuery))
    {
        while ($row = mysqli_fetch_array($result))
        {
            array_push($accountData, array("id" => $row['SavingsID'], "balance" => $row['SavingsBalance'], "type" => "savings"));
        }
    }

    $returnData = array("selected" => $selectedAccountData, "accounts" => $accountData);

    echo json_encode($returnData);
}
