/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//*******GLOBAL VARIABLES*******

$(document).ready(function () {

    checkUsername();

});



//function that validates each filled form
function Validator()
{
    var Username = document.getElementById('newUsername');
    var Password = document.getElementById('newPassword');
    var ConfirmPassword = document.getElementById('confirmPassword');
    var FirstName = document.getElementById('FirstName');
    var LastName = document.getElementById('LastName');
    var City = document.getElementById('City');
    var Address1 = document.getElementById('Address1');
    var Email = document.getElementById('Email');
    var Province = document.getElementById('Province');
    var PostalCode = document.getElementById('PostalCode');
    var Phone = document.getElementById('Phone');
    var SecurityQuestion = document.getElementById('SecurityQuestion');
    var SQAnswer = document.getElementById('SQAnswer');
    var ChequingBalance = document.getElementById('Chequing');
    var SavingsBalance = document.getElementById('Savings');

    //regex expressions
    var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; //regex expression for email address
    var PostalCodePatt = /[A-Z][0-9][A-Z][- ][0-9][A-Z][0-9]/; //regex expression for postal code
    var PhonePatt = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im; //regex expression for phone numbers

    //Check if all forms has been filled
    if (FirstName.value === '' || LastName.value === '' || Username === '' ||
            City.value === '' || Address1.value === '' || Province === '' ||
            SecurityQuestion === '' || SQAnswer === '')
    {
        $('#errorstatus').html('<b style="color:red"> ERROR:</b> Please fill all required forms!');

    }

    //Regex expression to check for phone numbers
    else if (!Phone.value.match(PhonePatt))
    {
        $('#errorstatus').html('<b style="color:red"> ERROR:</b> Invalid phone number!');

    }

    //Regex expression to check for Postal Code
    else if (!PostalCode.value.match(PostalCodePatt))
    {
        $('#errorstatus').html('<b style="color:red"> ERROR:</b> Invalid postal code!');

    }

    //Regex expression to check if email contains @ and .
    else if (!Email.value.match(emailPattern))
    {
        $('#errorstatus').html('<b style="color:red"> ERROR:</b> Invalid email address!');

    }

    //Checks if password and confirm password are the same
    else if (Password.value !== ConfirmPassword.value)
    {
        $('#errorstatus').html('<b style="color:red"> ERROR:</b> re-enter password / confirm password!');

    }

    //Checks if SavingsBalance is a number
    else if ($.isNumeric(SavingsBalance))
    {
        $('#errorstatus').html('<b style="color:red"> ERROR:</b> Invalid input on Savings form!');
    }

    //Checks if ChequeingBalance is a number
    else if ($.isNumeric(ChequingBalance))
    {
        $('#errorstatus').html('<b style="color:red"> ERROR:</b> Invalid input on Chequeing form!');
    }

    //If everything is good then proceed. server side(PHP/MySQL) will check for username/email validation
    else
    {
        sendData();
    }

}

//Check username on the database after user done typing in username textbox
function checkUsername()
{
    //checks if username exists while key down
    var typingTimer;
    var doneTypingInterval = 1000;

    $("#newUsername").keyup(function (event) {
        //inputValue as to which key has been pressed
        var inputValue = event.which;

        if (inputValue === 8 || inputValue === 32 || (inputValue >= 48 && inputValue <= 57) || (inputValue >= 65 && inputValue <= 90) || (inputValue >= 97 && inputValue <= 122)) {

            clearTimeout(typingTimer);
            $("#checkUsernameSpan").html("<img src='images/loading_gif_1.gif' class='pageloading_gif'>");
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        }
        
        //avoid keyup function to fire multiple times.
        event.stopImmediatePropagation();
    });

    $("#newUsername").keydown(function (event) {
        
        //inputValue as to check which key has been pressed
        var inputValue = event.which;
        
        if(inputValue === 8 || inputValue === 32 || (inputValue >= 48 && inputValue <=57) || (inputValue >= 65 && inputValue <= 90) || (inputValue >= 97 && inputValue <= 122)) {
            clearTimeout(typingTimer);
            $("#checkUsernameSpan").html("<img src='images/loading_gif_1.gif' class='pageloading_gif'>");
        }
        
        //avoid keydown function to fire multiple times
        event.stopImmediatePropagation();
        
    });
}

//Checks username if it exists, to let registering user know if it's already exists or not
function doneTyping()
{
    if($("#newUsername").val() !== ""){
        $.ajax({
        url: 'functions.php',
        type: 'POST',
        dataType: "text",
        data: {submit: "checkUsername", newUsername: $("#newUsername").val()},
        beforeSend: function () {
            $("#checkUsernameSpan").html("<img src='images/loading_gif_1.gif' class='pageloading_gif'>");
        },
        success: function (returnData) {
            if (returnData === "0") {
                $("#checkUsernameSpan").html("<img src='images/verified_icon.png' class='pageloading_gif'>");
            } else {
                $("#checkUsernameSpan").html("<img src='images/x_icon.png' class='pageloading_gif'>");
            }
        },
        error: function (error) {
            alert("ERROR: " + error);
        }
    });
    }
    else{
        $("#checkUsernameSpan").html("");
    }
    
}

function sendData()
{
    var postData = {submit: 'register', username: $('#newUsername').val(), newpass: $('#newPassword').val(),
        firstName: $('#FirstName').val(), lastName: $('#LastName').val(), city: $('#City').val(),
        address1: $('#Address1').val(), address2: $('#Address2').val(), province: $('#Province').val(), postalCode: $('#PostalCode').val(),
        email: $('#Email').val(), phone: $('#Phone').val(), securityQuestion: $('#SecurityQuestion').val(), SQAnswer: $('#SQAnswer').val(),
        bday: $('#Birthdate').val(), chequing: $('#Chequing').val(), savings: $('#Savings').val()};

    //use AJAX to send post variables to PHP
    $.ajax({
        url: 'functions.php',
        type: 'POST',
        data: postData,
        success: function (returndata) {
            window.location.href = 'registered.php';
        },
        error: function (error) {
            alert("ERROR: " + Object.values(error));
        }
    });
};