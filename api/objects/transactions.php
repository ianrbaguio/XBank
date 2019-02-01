<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transactions
 *
 * @author Ronan
 */
class Transactions
{
    //put your code here
    public $conn;
    public $table;
    
    //object properties
    public $transactionType;
    public $transactDescription;
    public $amount;
    public $accountUserID;
    public $accountType;
    public $accountID;
    public $transferAccountType;
    public $transferAccountID;
    public $transactionOutput;
    
    //class constructor
    public function __construct($db){
        $this->conn = $db;
    }
    
    //new transaction function
    public function newTransaction(){
        
        $transactionSQL = "CALL sp_Transactions('$this->transactionType', "
                . " '$this->transactDescription', "
                . " '$this->amount', "
                . " '$this->accountUserID', "
                . " '$this->accountType', "
                . " '$this->accountID', "
                . " '$this->transferAccountType', "
                . " '$this->transferAccountID', "
                . "  @output);";
        
        $result = mysqli_query($this->conn, $transactionSQL);
        
        while($row = mysqli_fetch_array($result)){
            
            $this->transactionOutput = $row['result'];
            
        }   
    }
}
