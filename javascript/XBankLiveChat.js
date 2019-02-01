/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var adminBool = false;

//Gets the GET data from URL in javascript
var url_string = document.URL;
var url = new URL(url_string);
var chatID = url.searchParams.get("id");

$(document).ready(function () {
    checkAdmin();
    $("#SendButton").click(newMessage);
    checkMessages();

});

function checkAdmin() {

    var AdminInterval = setInterval(function () {
        $.ajax({
            url: "phpFunctions/livechatFunction.php?id=" + chatID,
            data: {submit: "checkAdmin"},
            method: "GET",
            dataType: "JSON",
            success: function (returnData) {
                if (returnData[0].name !== "" || returnData[0].id > 0) {
                    $("#AdminLoadingDiv").hide();
                    clearInterval(AdminInterval);

                    var connectedHTML = "<ul> <li>" + returnData[0].name + "</li> </ul>";

                    $("#ConnectedWithDiv").html(connectedHTML);
                }
            }
        });
    }, 2500);

}

function checkMessages() {
    var checkInterval = 500; //check messages every 500ms

    setInterval(function () {
        $.ajax({
            url: "phpFunctions/livechatFunction.php?id=" + chatID,
            data: {submit: "checkMessages"},
            method: "GET",
            dataType: "JSON",
            success: function (returnData) {
                console.log(returnData);

                var messageHTML = "";
                for (var i = 0; i < returnData.length; i++)
                {
                    var rD = returnData[i];

                    console.log("FromClient: " + rD.fromClient);
                    if (rD.fromClient === false)
                    {
                        messageHTML += "<div style='max-width:50%; clear:both; float:left; margin:5px; border: 1px solid blue; background-color:blue; border-radius:5px; color:yellow; padding: 0 5px;'>";
                        messageHTML += "<p><label for='message' style='margin-right:5px;'>" + rD.ClientName + ": </label>" + rD.Message + "</p>";
                        messageHTML += "</div>";
                    } else
                    {
                        messageHTML += "<div style='max-width:50%; clear:both; float:right; text-align:right; margin:5px; background-color: #ffff99; color: blue; border-radius: 5px; padding: 0 5px;'>";
                        messageHTML += "<p>" + rD.Message + "<label for='message' style='margin-left: 5px;'> :You </label>" + "</p>";
                        messageHTML += "</div>";
                    }

                    $("#ChatMessages").html(messageHTML);
                }
            }
        });
    }, checkInterval);


}

function newMessage()
{
    $.ajax({
        url: "phpFunctions/livechatFunction.php?id=" + chatID,
        data: {submit: "newMessage", message: $("#TextMessageTextArea").val()},
        method: "POST",
        dataType: "text",
        complete: function () {

            $("#TextMessageTextArea").val('');
        }
    });
}


