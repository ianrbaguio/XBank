<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Header: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

//database connection
include_once '../config/database.php';
include_once '../objects/client'
. '.php';

// instantiate database and client object
$database = new Database();
$db = $database->getConnection();

// initiliaze client object
$client = new Client($db);

//set clientID property of record to read, if non then die();
//$client->clientID = isset($_GET['clientid']) ? $_GET["clientid"] : die();

if(isset($_GET['clientid'])){
    $client->clientID = strip_tags($_GET["clientid"]);
}
elseif(isset($_GET['savingsid'])){
    $client->savingsID = strip_tags($_GET["savingsid"]);
}
elseif(isset($_GET['chequingid'])){
    $client->chequingID = strip_tags($_GET["chequingid"]);
}
else{
    die();
}

$client->read();

if($client->firstName != null){
    
    //create array
    $client_arr = array(
      "clientID" => $client->clientID,
      "firstName" => $client->firstName,
      "lastName" => $client->lastName,
      "savingsID" => $client->savingsID,
      "savingsBalance" => $client->savingsBalance,
      "chequingID" => $client->chequingID,
      "chequingBalance" => $client->chequingBalance
    );
    
    //set response code - 200 OK
    http_response_code(200);
    
    //make it in json format
    echo json_encode($client_arr);
}
else
{
    //no client found
    http_response_code(404);
    
    //client not found error message
    echo json_encode(array("message" => "Client not found."));
}



//************* OLD READ ALL API ***************
//read clients info from here
//$stmt = $client->read(92650000);

//If there is something
//if ($stmt)
//{
//    if (mysqli_num_rows($stmt) > 0)
//    {
//        while ($row = mysqli_fetch_array($stmt))
//        {
//
//            array_push($client_arr, array(
//                "clientID" => $row["ClientID"],
//                "firstName" => $row["FirstName"],
//                "lastName" => $row["LastName"],
//                "savingsID" => $row["SavingsID"],
//                "chequingID" => $row["ChequingID"],
//                "savingsBalance" => $row["SavingsBalance"],
//                "chequingBalance" => $row["ChequingBalance"]
//            ));
//        }
//        
//        echo json_encode($client_arr);
//    }
//    else{
//        
//        //No Client Found
//        http_response_code(404);
//        
//        //Return error that no user found
//        echo json_encode(array("message" => "No clients found"));
//        
//    }
//}
//else{
//    
//    //No Client Found
//        http_response_code(404);
//        
//        //Return error that no user found
//        echo json_encode(array("message" => "No clients found"));
//}
?>
