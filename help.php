<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if (!($_SESSION['username']) && !($_SESSION['clientID']))
{
    session_destroy();

    header("Location:index.php");

    die();
}

if (isset($_POST['submit']) && $_POST['submit'] == "Log Out")
{
    //Destroy session
    session_destroy();

    header("Location:index.php");

    die();
}

$getPage = "livechat";

if (isset($_GET['source']) && $_GET['source'] != "")
{
    $getPage = $_GET['source'];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>XBank</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/XBankCSS.css">
        <link rel="stylesheet" type="text/css" href="css/XBankMain.css">
    <body>
        <header class="text-center">
            <h1> <img alt="X Bank Logo" src="images/XBankLogo.png"> A Bank Of Opportunity</h1>
        </header>

        <nav id="menu" class="header">
            <a style="background-color:white; color:black" href="main.php"> Bank Accounts </a>
            <a style="color:yellow; margin-left: 2%; " href="help.php?source=livechat"> Help </a>

            <div style="float: right" class="AccountDropDown">                       
                <button class="dropbtn"> <img src="images/XBank profilepic logo.gif"> <?php echo $_SESSION["username"] ?> <i id="caretdown" class="fa fa-caret-down"> </i>
                </button>
                <div class="AccountDropDown-Content">
                    <a href="#">Profile</a>
                    <form method="post" action="main.php">
                        <input type="submit" name="submit" value="Log Out">
                    </form>
                </div>
            </div>
        </nav>

        <div id='ContainerDiv'>
            <div id='SideNavDiv' class='sidenav'>
                <span style="font-weight:bold; font-size: 12px;">HELP:</span>
                <ul>
                    <li><a id="LiveChatMenu" href="#">Live chat</a></li>
                </ul>

            </div>

            <div id='HelpContentDiv' style='margin-left: 200px;'>

            </div>

        </div>

        <div id='footer'>
            <hr>
            © Ian Baguio <br>
            Date Created: January 31, 2018 <br>
            Date Modified: January 9, 2019 <br>

            <img src="images/XBankLogo.png" alt="XBank">
        </div>

        <script src="javascript/XBankJS.js" type="text/javascript"></script>

        <script type="text/javascript">
            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();

            $("#ContentDiv").height(contentHeight);

            var loadPage = "<?php echo $getPage ?>";

            if (loadPage === "livechat")
            {
                $("#HelpContentDiv").load("helplivechat.php", function (response, status, xhr) {

                    if (status === "success")
                    {
                        contentHeight = ($("#HelpContentDiv").height() > $("#SideNavDiv").height()) ? $("#HelpContentDiv").height() : $("#SideNavDiv").height();

                        $("#HelpContentDiv").height(contentHeight);
                        
                    } else {
                        $("#HelpContentDiv").html("<h3 style='text-align:center; color:red'>Page Load Failed.</h3> <p style='text-align:center;'>Please refresh page.</p>");
                    }
                });
            }

        </script>
        
        <script src="javascript/XBankHelp.js" type="text/javascript"></script>

    </body>

</html>
