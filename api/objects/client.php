<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Client
{

    //database conenction and table name
    private $conn;
    private $table_name = "Clients";
    //object properties
    public $clientID;
    public $firstName;
    public $lastName;
    public $savingsID;
    public $chequingID;
    public $savingsBalance;
    public $chequingBalance;

    // constructor with $db as database connection
    public function __construct($db)
    {

        //this is how to access properties/variables of a class in php
        $this->conn = $db;
    }

    public function read()
    {

        $query = "";

        if ($this->clientID > 0)
        {
            //select query
            $query = "SELECT Clients.ClientID, "
                    . "FirstName, "
                    . "LastName, "
                    . "SavingsID, "
                    . "ChequingID, "
                    . "SavingsBalance, "
                    . "ChequingBalance "
                    . "FROM Clients "
                    . "INNER JOIN Savings ON Savings.ClientID = Clients.ClientID "
                    . "INNER JOIN Chequing ON Chequing.ClientID = Clients.ClientID "
                    . "WHERE Clients.ClientID = '$this->clientID'";
        }
        elseif($this->savingsID > 0)
        {
            
            //select query
            $query = "SELECT Clients.ClientID, "
                    . "FirstName, "
                    . "LastName, "
                    . "Savings.SavingsID, "
                    . "'N/A' AS ChequingID, "
                    . "Savings.SavingsBalance, "
                    . "'N/A' AS ChequingBalance "
                    . "FROM Clients "
                    . "INNER JOIN Savings ON Savings.ClientID = Clients.ClientID "
                    . "WHERE Savings.SavingsID = '$this->savingsID'";
        }
        elseif($this->chequingID > 0)
        {
            //select query
            $query = "SELECT Clients.ClientID, "
                    . "FirstName, "
                    . "LastName, "
                    . "'N/A' AS SavingsID, "
                    . "ChequingID, "
                    . "'N/A' AS SavingsBalance, "
                    . "ChequingBalance "
                    . "FROM Clients "
                    . "INNER JOIN Chequing ON Chequing.ClientID = Clients.ClientID "
                    . "WHERE Chequing.ChequingID = '$this->chequingID'";
        }

        //echo $query;
        //prepare query statement
        $result = mysqli_query($this->conn, $query);

        if ($result)
        {

            while ($row = mysqli_fetch_array($result))
            {

                //set values to object
                $this->clientID = $row["ClientID"];
                $this->firstName = $row["FirstName"];
                $this->lastName = $row["LastName"];
                $this->savingsID = $row["SavingsID"];
                $this->chequingID = $row["ChequingID"];
                $this->savingsBalance = $row["SavingsBalance"];
                $this->chequingBalance = $row["ChequingBalance"];
            }
        }
    }

//    //function that reads a client info
//    public function read(){
//        
//        //select query
//        $query = "SELECT Clients.ClientID, "
//                .       "FirstName, "
//                .       "LastName, "
//                .       "SavingsID, "
//                .       "ChequingID, "
//                .       "SavingsBalance, "
//                .       "ChequingBalance "
//                ."FROM Clients "
//                ."INNER JOIN Savings ON Savings.ClientID = Clients.ClientID "
//                ."INNER JOIN Chequing ON Chequing.ClientID = Clients.ClientID "
//                ."WHERE Clients.ClientID = '$this->clientID'";
//        
//        //echo $query;
//        //prepare query statement
//        $result = mysqli_query($this->conn, $query);
//        
//        return $result;
//    }
}

?>
