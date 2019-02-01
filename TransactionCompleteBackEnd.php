<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'dbUtility.php';
require_once 'functions.php';

if (isset($_POST['submit']) && $_POST['submit'] == 'transactID')
{
    $clientID = $_SESSION['clientID'];
    $amount = strip_tags($_POST['amount']);
    $accountID = strip_tags($_POST['id']);
    $date = strip_tags($_POST['date']);
    $transactionType = strtoupper(strip_tags($_POST['type']));
    $transactionID = -1;
    
    if(strtolower($transactionType) == "withdraw" || strtolower($transactionType) == "transfer")
    {
        $amount = $amount * -1;
    }

    $query = "SELECT TransactionID FROM Transactions WHERE AccountID = '$accountID' AND ClientID = '$clientID' 
             AND Description LIKE '$transactionType' AND Amount = '$amount' AND TransactionDate LIKE '%$date%' ORDER BY TransactionDate desc LIMIT 1;";

    if ($result = mysqli_query($db, $query))
    {
        while ($row = mysqli_fetch_array($result))
        {
            $transactionID = $row['TransactionID'];
        }
    } else
    {
        echo "Error: " . $query . "<br />" . mysqli_error($conn);
    }

    echo $transactionID;
}


?>

