<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and transactions object
include_once '../config/database.php';
include_once '../objects/transactions.php';

$database = new Database();
$db = $database->getConnection();

$transaction = new Transactions($db);

// get sent json to be edited (Gets the raw POST data)
$data = json_decode(file_get_contents("php://input"));

//$transaction->transactionType = $data->transactionType; // deposit, withdraw or transfer
$transaction->transactionType = "transfer"; // deposit, withdraw or transfer
$transaction->transactDescription = $data->transactDescription; // transaction description
$transaction->amount = $data->amount; // amount entered
$transaction->accountUserID = $data->accountUserID; // userID / clientID
$transaction->accountType = $data->accountType; // chequing / savings
$transaction->accountID = $data->accountID; // savings chequing ID
$transaction->transferAccountType = $data->transferAccountType; // savings / chequing
$transaction->transferAccountID = $data->transferAccountID; // savings / chequing ID

//make sure that this parameters are filled and the amount must be greater than 0
if ($transaction->transferAccountType != NULL 
    && $transaction->transferAccountType != "" 
    && $transaction->transferAccountID != NULL 
    && $transaction->transferAccountID != 0
    && $transaction->amount > 0)
{
    $transaction->newTransaction();

    if ($transaction->transactionOutput != NULL && $transaction->transactionOutput != "")
    {

        http_response_code(200);

        echo json_encode(array("message" => $transaction->transactionOutput));
    } else
    {

        http_response_code(404);

        echo json_encode(array("message" => "Cannot process transaction."));
    }
} else
{
    die();
}
?>