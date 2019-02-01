<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../dbUtility.php';

session_start();

$clientID = $_SESSION['clientID'];
$clientType = $_SESSION['clientType'];
$LiveChatID = (isset($_GET['id'])) ? $_GET['id'] : 0;

if (isset($_GET['submit']) && strip_tags($_GET['submit']) == "CreateChat")
{
    //grab client's info
    $clientinfoSQL = "SELECT * FROM Clients WHERE ClientID = '$clientID'";

    $result = mysqli_query($db, $clientinfoSQL);
    $data = mysqli_fetch_assoc($result);

//create new livechat
    $clientName = $data['FirstName'] . " " . $data['LastName'];
    $livechatSQL = "INSERT INTO ActiveLiveChat(ClientID, ClientName) VALUES('$clientID', '$clientName')";

    if (mysqli_query($db, $livechatSQL))
    {
        $chatID = mysqli_insert_id($db);

        echo "livechat.php?id=" . $chatID;
    } else
    {
        echo "Error: " . $livechatSQL . "<br />" . mysqli_error($conn);
    }
}

if (isset($_GET['submit']) && strip_tags($_GET['submit']) == "CheckClient")
{
    $clientTypeSQL = "SELECT ClientType FROM Clients WHERE ClientID = '$clientID';";

    $result = mysqli_query($db, $clientTypeSQL);
    $data = mysqli_fetch_assoc($result);

    echo $data['ClientType'];
}

if (isset($_GET['submit']) && strip_tags($_GET['submit']) == "checkAdmin" && $LiveChatID > 0)
{
    if ($clientType == "Client")
    {

        $checkAdminArray = Array();
        $checkAdminSQL = "SELECT IFNULL(AdminID, 0) AS AdminID, IFNULL(AdminName, '')AS AdminName FROM ActiveLiveChat WHERE ChatID = '$LiveChatID'";

        if ($result = mysqli_query($db, $checkAdminSQL))
        {
            while ($row = mysqli_fetch_array($result))
            {
                array_push($checkAdminArray, array("id" => $row['AdminID'], "name" => $row['AdminName']));
            }
        }

        echo json_encode($checkAdminArray);
    } else if ($clientType == "Admin")
    {
        $adminArray = Array();

        //grab client's info
        $clientinfoSQL = "SELECT * FROM Clients WHERE ClientID = '$clientID'";

        $result = mysqli_query($db, $clientinfoSQL);
        $data = mysqli_fetch_assoc($result);

        //create new livechat
        $clientName = $data['FirstName'] . " " . $data['LastName'];

        $adminSQL = "UPDATE ActiveLiveChat SET AdminID = '$clientID', AdminName = '$clientName' WHERE ChatID = '$LiveChatID'";

        mysqli_query($db, $adminSQL);

        $livechatinfoSQL = "SELECT ClientID, ClientName FROM ActiveLiveChat WHERE ChatID = '$LiveChatID'";

        if ($result = mysqli_query($db, $livechatinfoSQL))
        {
            while ($row = mysqli_fetch_array($result))
            {
                array_push($adminArray, array("id" => $row['ClientID'], "name" => $row['ClientName']));
            }
        }

        echo json_encode($adminArray);
    }
}

if (isset($_POST['submit']) && strip_tags($_POST['submit']) == "GetLiveChats" && $clientType == "Admin")
{

    $chatArray = Array();

    $livechatSQL = "SELECT ChatID, ClientID, ClientName FROM ActiveLiveChat";

    if ($result = mysqli_query($db, $livechatSQL))
    {
        while ($row = mysqli_fetch_array($result))
        {
            array_push($chatArray, array("id" => $row['ChatID'], "name" => $row['ClientName'], "url" => "livechat.php?id=" . $row['ChatID']));
        }
    }

    echo json_encode($chatArray);
}

if (isset($_POST['submit']) && strip_tags($_POST['submit']) == "newMessage")
{
    $Message = strip_tags($_POST['message']);
    //grab client's info
    $clientinfoSQL = "SELECT * FROM Clients WHERE ClientID = '$clientID'";

    $result = mysqli_query($db, $clientinfoSQL);
    $data = mysqli_fetch_assoc($result);

    //create new livechat
    $clientName = $data['FirstName'] . " " . $data['LastName'];

    $MessageSQL = "INSERT INTO ChatMessages(ChatID, ClientName, Message) VALUES('$LiveChatID', '$clientName', '$Message' )";
    
    if(mysqli_query($db, $MessageSQL)){
        echo "Message Sent.";
    }
}

if (isset($_GET['submit']) && strip_tags($_GET['submit']) == "checkMessages")
{
    $MessagesArray = Array();
    
    //grab client's info
    $clientinfoSQL = "SELECT * FROM Clients WHERE ClientID = '$clientID'";
    
    $clientMessage = false; //determines if message is from client/admin itself

    $result = mysqli_query($db, $clientinfoSQL);
    $data = mysqli_fetch_assoc($result);

    //create new livechat
    $firstName = $data['FirstName'];
    $clientName = $data['FirstName'] . " " . $data['LastName'];

    $MessageSQL = "SELECT * FROM ChatMessages WHERE ChatID = '$LiveChatID'";
    
    if($result = mysqli_query($db, $MessageSQL)){
        
        while($row = mysqli_fetch_array($result)){
            
            $clientMessage = ($row['ClientName'] == $clientName) ? true: false;
            
            array_push($MessagesArray, Array("ClientName" => $row['ClientName'], "Message" => $row['Message'], "fromClient" => $clientMessage));
            
        }
        
    }
    
    echo json_encode($MessagesArray);
}
?>