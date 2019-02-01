<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'dbUtility.php';

//start session
session_start(); //*NOTE: session_start() must always be on top or else it will resets $_SESSION global array

$registrationStatus = "";
$error = "";

//Processing form data when form has been submitted and checks if the request method is post
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    /*     * *************************************************************************
      //All forms has been filled
     * 
     * Login-system
     * **************************************************************** */
    if ((!empty($_POST['username']) || !empty($_POST['password'])) && isset($_POST['submit']) && $_POST['submit'] == 'Log In')
    {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        //Filter Query by username
        $query = "SELECT ClientID,ClientType,username, password FROM Clients WHERE username = '$username'";

        //run query
        if ($result = mysqli_query($db, $query))
        {
            //return the number of rows
            $count = mysqli_num_rows($result);

            //no account founds then show invalid account error
            if ($count == 0)
            {
                $error = 'Invalid account';
            }

            //account found in the database
            else
            {
                //fetch row result and save it as an array value
                while ($row = mysqli_fetch_array($result))
                {
                    //checks if password entered is the same as the hashed password
                    if (password_verify($password, $row['password']))
                    {

                        //set session as username
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['clientID'] = $row['ClientID'];
                        $_SESSION['clientType'] = $row['ClientType'];

                        //redirect to the security question page
                        header("Location:SQuestion.php");

                        die();
                    }

                    //Account not found/exists in database
                    else
                    {
                        $error = 'Incorrect username/password';
                    }
                }
            }
        }


//    if(password_verify(strip_tags($_POST['password']), $row['password']))
//    {
//        session_start();
//        
//        $_SESSION['username'] = $username;
//        
//        header("Location:SQuestion.php");
//     
//    }
//    else
//    {
//       $error = 'Invalid Account';
//    }
    }

//All forms not been filled
    else
    {
        $error = "Error: Please fill all form!";
    }


    /***************REGISTER FUNCTION*********************
     * 
     * Registration System
     * *************************************************** */

    if (isset($_POST['submit']) && $_POST['submit'] == "register")
    {
        $dataArray = Array(); //Array that holds returned datas
        $registrationStatus = "";

        //Clients new info variables
        $username = mysqli_real_escape_string($db, strip_tags($_POST['username']));
        $password = mysqli_real_escape_string($db, password_hash(strip_tags($_POST['newpass']), PASSWORD_DEFAULT));
        $firstName = mysqli_real_escape_string($db, strip_tags($_POST['firstName']));
        $lastName = mysqli_real_escape_string($db, strip_tags($_POST['lastName']));
        $address1 = mysqli_real_escape_string($db, strip_tags($_POST['address1']));
        $address2 = mysqli_real_escape_string($db, strip_tags($_POST['address2']));
        $city = mysqli_real_escape_string($db, strip_tags($_POST['city']));
        $province = mysqli_real_escape_string($db, strip_tags($_POST['province']));
        $postalCode = mysqli_real_escape_string($db, strip_tags($_POST['postalCode']));
        $email = mysqli_real_escape_string($db, strip_tags($_POST['email']));
        $phone = mysqli_real_escape_string($db, strip_tags($_POST['phone']));
        $secQuestion = mysqli_real_escape_string($db, strip_tags($_POST['securityQuestion']));
        $secAnswer = mysqli_real_escape_string($db, password_hash(strip_tags($_POST['SQAnswer']), PASSWORD_DEFAULT));
        $birthday = mysqli_real_escape_string($db, strip_tags($_POST['bday']));
        $chequingBalance = mysqli_real_escape_string($db, strip_tags($_POST['chequing']));
        $savingsBalance = mysqli_real_escape_string($db, strip_tags($_POST['savings']));
        
        //if security question doesn't include ? then add it to the security question string
        if(!(strpos($secQuestion, '?')))
        {
            $secQuestion .= "?";
        }

        //Checks database if username already existed 
        $query = "SELECT username FROM Clients WHERE username = '$username'";
        $result = mysqli_query($db, $query);

        //return the number of rows
        $user = mysqli_num_rows($result);

        //username already exists
        if ($user == 1)
        {
            $registrationStatus = 'Sorry, that username already exists!';
            header("Location:index.php");
            exit();
        }

        //username doesn't exists and allow for registration
        if ($user < 1)
        {
            $query = "INSERT INTO Clients(ClientType, username, password, FirstName, LastName, Address1, Address2, City, Province,
                  PostalCode, Phone, Email, Birthdate, SecurityQuestion, SecurityAnswer) 
                  VALUES('Client', '$username', '$password', '$firstName', '$lastName', '$address1', '$address2', '$city',
                         '$province', '$postalCode', '$phone', '$email', '$birthday', '$secQuestion', '$secAnswer')";


            If (mysqli_query($db, $query))
            {
                //gets the last ID from the inserted query (new registered member)
                $last_id = mysqli_insert_id($db);

                //Adds chequing info to database
                $chequingquery = "INSERT INTO Chequing(ClientID, ChequingBalance)
                               VALUES('$last_id', '$chequingBalance');";

                
                if(mysqli_query($db, $chequingquery))
                {
                    $lastchequing_id = mysqli_insert_id($db);
                    
                    $chequingTransactionQuery = "INSERT INTO Transactions(ClientID, AccountID, Description, Amount, Balance)
                                                 VALUES('$last_id', '$lastchequing_id', 'DEPOSIT', '$chequingBalance', '$chequingBalance');";
                    
                    mysqli_query($db, $chequingTransactionQuery);
                }

                //Adds saving info to database
                $savingsquery = "INSERT INTO Savings(ClientID, SavingsBalance)
                             VALUES ('$last_id', '$savingsBalance')";

                if(mysqli_query($db, $savingsquery))
                {
                    $lastsavings_id = mysqli_insert_id($db);
                            
                    $savingsTransactionQuery = "INSERT INTO Transactions(ClientID, AccountID, Description, Amount, Balance)
                                                 VALUES('$last_id', '$lastsavings_id', 'DEPOSIT', '$savingsBalance', '$savingsBalance');";
                    
                    mysqli_query($db, $savingsTransactionQuery);
                }


                $registrationStatus = "New member registered!";
                header("Location:registered.php");
                exit();
                
            } else
            {
                echo "Error: " . $query . "<br />" . mysqli_error($conn);
            }
        }

//        //Shows mysql error
//        echo mysqli_errno($db) . ': ' . mysqli_error($db); //UNCOMMENT THIS FOR DEBUG


        /*         * ************CODE THAT SUPPOSED TO RETURN DATA TO JAVASCRIPT BUT DOESN'T WORK **************    

          //returnArray on success callback in JS file(XBankServerJS)
          $returnArray = Array('status' => $status);

          //json_encode return array allow for Javascript to be read
          echo json_encode($returnArray);

         */
    }
    
    if(isset($_POST['submit']) && $_POST['submit'] == "checkUsername"){
        
        $newUsername = strip_tags($_POST['newUsername']);
        
        $checkUsernameSQL = "SELECT COUNT(username) AS 'username' FROM Clients WHERE username = '$newUsername'";
        
        if($result = mysqli_query($db, $checkUsernameSQL)){
            while($row = mysqli_fetch_array($result)){
                echo $row['username'];
            }
        }
    }
}
?>
