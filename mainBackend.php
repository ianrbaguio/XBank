<?php

require_once 'functions.php';
require_once 'dbUtility.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//This is the back-end stuff on main page that will grab all the information
//of the client's bank account information.

$clientID = $_SESSION['clientID'];

//data array that holds both chequing/savings id and balance
$postData = Array();

GetBankAccountInfo($clientID);

function GetBankAccountInfo($ID)
{
    global $db, $postData;
    
    // gets the chequing account info from client
    $chequingQuery = "SELECT ChequingID, ChequingBalance FROM Chequing WHERE ClientID = '$ID'";
    
    if($result = mysqli_query($db, $chequingQuery))
    {
        while ($row = mysqli_fetch_array($result))
        {
            
          //stores id and balance to the postData array
          array_push($postData, array("id" => $row['ChequingID'], "balance" => $row['ChequingBalance'], "type" => "Chequing"));
          //echo "Chequing ID: ". $row['ChequingID'] . " Balance: ". $row['ChequingBalance'];  
        }
    }
    
    
    $savingsQuery = "SELECT SavingsID, SavingsBalance FROM Savings WHERE ClientID = '$ID'";
    
    if($result = mysqli_query($db, $savingsQuery))
    {
        while($row = mysqli_fetch_array($result))
        {
            //stores id and balance to the postData array
            array_push($postData, array("id" => $row['SavingsID'], "balance" => $row['SavingsBalance'], "type" => "Savings"));
        }
    }
}
    
    //echo json_encode so it datas can be retrieved on javascript file (XBankMain.js)
    echo json_encode($postData);
?>   