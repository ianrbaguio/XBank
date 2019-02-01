<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//****** localhost ********
$hostname = 'localhost';
$username = 'root';
$password = 'iTsuna10';
$databasename = 'XBank';


//****** shared hosting *****
//$hostname = 'server136.web-hosting.com:21098';
//$username = 'ianrdcbi_ianbaguio';
//$password = 'iTsuna10';
//$databasename = 'ianrdcbi_XBank';

//create connection to database
$conn = new mysqli($hostname, $username, $password, $databasename);

$db = mysqli_connect($hostname, $username, $password, $databasename);

// Checks connection
if($conn -> connect_error)
{
    die("Connection failed: " . $conn -> connect_error);
     
}

 else 
{
     $status = 'Connection successful';
}
?>