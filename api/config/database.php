<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Database
{

    //database credentials
    //********** LOCALHOST CREDENTIALS**********
    private $host = "localhost";
    private $db_name = "XBank";
    private $username = "root";
    private $password = "iTsuna10";
    public $conn;
    public $db;

    //**********  SHARED HOSTING CREDENTIALS
    //private $host = "localhost";
    //private $host = 'server136.web-hosting.com:21098';
    //private $password = "iTsuna10";
    //private $db_name = "ianrdcbi_XBank";
    //get database connection function
    public function getConnection()
    {

        try
        {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);

            // Checks connection
            if ($this->conn->connect_error)
            {
                die("Connection failed: " . $this->conn->connect_error);
            } else
            {
                $status = 'Connection successful';
            }
        } catch (Exception $ex)
        {
            echo "Connection Error: " . $ex->getMessage();
        }

        return $this->db;
    }

}

?>
