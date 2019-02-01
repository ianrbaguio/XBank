/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $("#LiveChatButton").click(CreateLiveChat);
    
    CheckClientType();
});


function CreateLiveChat(){
    
    $.ajax({
        url: "phpFunctions/livechatFunction.php",
        data: {submit: 'CreateChat'},
        method: "GET",
        dataType: "text",
        success: function(returnData){
            
            window.location.href = returnData;
        } 
    }); 
}

function CheckClientType(){
    $.ajax({
        url: "phpFunctions/livechatFunction.php",
        data: {submit: 'CheckClient'},
        method: "GET",
        dataType: "text",
        success: function(returnData){
            
            if(returnData === "Client")
            {
                $("#ClientDiv").show();
                $("#AdminDiv").hide();
            }
            else if(returnData === "Admin")
            {
                AvailableLiveChats();
                $("#AdminDiv").show();
                $("#ClientDiv").hide();
            }
        }
    });
}

function AvailableLiveChats()
{
    $.ajax({
        url: "phpFunctions/livechatFunction.php",
        data:{submit: 'GetLiveChats'},
        method: "POST",
        dataType: "JSON",
        success: function(returnData){
            
            console.log(returnData);
            
            var LiveChatHTML = "<ul>";
            
            for(var i = 0; i < returnData.length; i++)
            {
                var rd = returnData[i];
                LiveChatHTML += "<li> <a href='" + rd.url + "'>" + rd.id + " - " + rd.name + "</a></li> ";
                
            }
            LiveChatHTML += "</ul>";
            
            $("#ListLiveChatDiv").html(LiveChatHTML);
        }
    });
}

function checkAdmin()
{
        $.ajax({
            url: "phpFunctions/livechatFunction.php",
            data:{submit: 'checkAdmin'},
            method: "POST",
            dataType: "JSON",
            success:function(returnData){
                
            }
        });
    
}

