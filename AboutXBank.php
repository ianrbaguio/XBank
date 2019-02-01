<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$getPage = "faqs";
require_once 'PHPMailer/PHPMailer.php';

$success = "";

if(isset($_POST['submit']) && $_POST['submit'] == "SEND")
{
    $to = "ianr.baguio@yahoo.com";
    $subject = "XBANK Feedback";
    $message = strip_tags($_POST['message']);
    $headers = "From: " . strip_tags($_POST['EmailTB']);
    
    echo mail($to, $subject, $message, $headers);
    if(mail($to, $subject, $message, $headers))
    {
        $success = "<span style='color:green'>Email has been sent! Thank you for your feedback.</span>";
    }
 else
    {
        $success = "<span style='color:red'>Error while email is being sent.</span>";
    }
}

if (isset($_GET['source']))
{
    $getPage = strip_tags($_GET['source']);
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
    </head>
    <body>
        <header class="text-center">
            <div>
                <h1 id="header">Welcome to <img  alt="X Bank Logo" src="images/XBankLogo.png"></h1>
            </div>
        </header>

        <!--LOGIN DIV -->
        <div id="login" class="header">
            <a href="index.php"> Online Banking </a>
            <a style="background-color:white; color:black;" href='AboutXBank.php'>About XBank </a> 
        </div>

        <div id='ContainerDiv'>
            <div id='SideNavDiv' class='sidenav'>
                <span style="font-weight:bold; font-size: 12px;">ABOUT XBANK:</span>
                <ul>
                    <li><a id='FeedbackMenu' href='AboutXBank.php'>Feedbacks</a></li>
                    <li><a id="FAQSMenu" href="AboutXBank.php?source=faqs">FAQS</a></li>
                    <li><a id="ModificationsMenu" href="?source=modifications">Modification</a></li>
                    <li><a id="ReferencesMenu" href="AboutXBank.php?source=references">References</a></li>
                    <li><a id="APIMenu" href="AboutXBank.php?source=api">API</a></li>
                </ul>

            </div>

            <div id='ContentDiv' style='margin-left: 200px;'>
                <div style='text-align: center;'>
                    <h2>FEEDBACK</h2>
                    <form method='post'>
                        Email: <input type='text' name='EmailTB' id='EmailTB' placeholder='Enter your email' style='width:25%;' /> <br/>
                        <textarea name='message' style='width:40%; height: 150px; margin-top:10px;' placeholder='Enter your message'></textarea>
                        <br/>
                        <span style='color:red;'>*</span> If you have any feedbacks or suggestions. You can send me an email. Thank you.
                        <br/>
                        <input type='submit' name='submit' id='submitemail' value='SEND' style='background-color:blue; color:yellow;'/>
                    </form>
                    <div>
                        <?php echo $success; ?>
                    </div>
                </div>
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
        <script>

            var getPage = "<?php echo $getPage; ?>";


            $(document).ready(function () {

                //%20 - represents space as urlencode but is this is a bad practice (?)

                if (getPage === 'modifications')
                {
                    $("#ContentDiv").load("./About%20XBank/modifications.html", function (response, status, xhr) {
                        if (status === "success")
                        {
                            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
                            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();

                            $("#ContentDiv").height(contentHeight);
                        } else if (status === "error")
                        {
                            $("#ContentDiv").html("<h3 style='text-align:center; color:red'>Page Load Failed.</h3>' <p>Please refresh page.</p>");
                        }
                    });

                } else if (getPage === 'faqs')
                {
                    $("#ContentDiv").load("./About%20XBank/faqs.html", function (response, status, xhr) {
                        if (status === "success")
                        {
                            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
                            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();

                            $("#ContentDiv").height(contentHeight);
                        } else if (status === "error")
                        {
                            $("#ContentDiv").html("<h3 style='text-align:center; color:red'>Page Load Failed.</h3> <p style='text-align:center;'>Please refresh page.</p>");

                            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
                            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();

                            $("#ContentDiv").height(contentHeight);
                        }
                    });
                } else if (getPage === 'references')
                {
                    $("#ContentDiv").load("./About%20XBank/references.html", function (response, status, xhr) {
                        if (status === "success")
                        {
                            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
                            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();

                            $("#ContentDiv").height(contentHeight);
                        } else if (status === "error")
                        {
                            $("#ContentDiv").html("<h3 style='text-align:center; color:red'>Page Load Failed.</h3> <p style='text-align:center;'>Please refresh page.</p>");

                            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
                            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();

                            $("#ContentDiv").height(contentHeight);
                        }
                    });
                } else if (getPage === 'api') {

//                    $("#ContentDiv").load("./About%20XBank/api.html", function (response, status, xhr) {
//                        if (status === "success")
//                        {
//                            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
//                            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();
//
//                            $("#ContentDiv").height(contentHeight);
//                        } else if (status === "error")
//                        {
//                            $("#ContentDiv").html("<h3 style='text-align:center; color:red'>Page Load Failed.</h3> <p style='text-align:center;'>Please refresh page.</p>");
//
//                            //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
//                            var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();
//
//                            $("#ContentDiv").height(contentHeight);
//                        }
//                    });

                    location.href = "api/api.html";

                } else
                {
                    //variable is using conditional(ternary operator) its basically and if/else condition: (condition) ? trueValue : falseValue
                    var contentHeight = ($("#ContainerDiv").height() > $("#SideNavDiv").height()) ? $("#ContainerDiv").height() : $("#SideNavDiv").height();

                    $("#ContentDiv").height(contentHeight);
                }

            });
        </script>`
    </body>

</html>
