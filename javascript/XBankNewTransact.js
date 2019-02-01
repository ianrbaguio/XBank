/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//bool that determines if drop down came from transfer value
var DropDownState = false;

$(document).ready(function () {

    $("#PageLoadingDiv").hide();
//    console.log("Type: " + accountType);
//    console.log("ID: " + accountID);
    var accountType = $("#accountType").val();
    var accountID = $("#accountID").val();
    var userID = $("#userID").val();
//    var type = accountType;
//    var id = accountID

    GetAccounts(accountType, accountID);
    //check if dropdown change
    $("#TransactOptions").change(function ()
    {
        //dropdown change to transfer
        if ($('#TransactOptions option:selected').val() === "Transfer")
        {
            $("#AccountOption").fadeOut("slow", function () {
                $("#AccountOption").html("From:").fadeIn();
            });

            $("#TransferToOption").fadeIn().show();

            DropDownState = true;
        }

        //dropdown change from transfer
        else if (DropDownState)
        {
            $("#AccountOption").fadeOut("slow", function () {
                $("#AccountOption").html("To:").fadeIn();
            });

            $("#TransferToOption").fadeOut("slow", function () {
                $("#TransferToOption").hide();
            });
            DropDownState = false;
        }
    });

    $("#ProcessTransaction").click(function () {
        ProcessTransaction();
        console.log("Process Transact click");
    });
});


function GetAccounts(selectedType, selectedID)
{
    $.ajax({
        url: "NewTransactionBackEnd.php",
        method: "POST",
        dataType: "JSON",
        data: {submit: "getAccounts", accountType: selectedType, accountID: selectedID},
        success: function (returnedData)
        {
            var AccountDropDown = document.getElementById("AccountDropDown");

            var option = document.createElement("option");
            var rdSelected = returnedData.selected;
            var accountSelectedID = rdSelected.id.slice(0, 4) + "-" + rdSelected.id.slice(4, rdSelected.id.length);
            option.text = rdSelected.type.charAt(0).toUpperCase() + rdSelected.type.slice(1) + ": " + accountSelectedID + "($" + rdSelected.balance + ")";
            option.value = rdSelected.type + "|" + rdSelected.id;
            AccountDropDown.add(option);

            for (var i = 0; i < returnedData.accounts.length; i++)
            {
                var rd = returnedData.accounts[i];
                var option = document.createElement("option");
                var accountID = rd.id.slice(0, 4) + "-" + rd.id.slice(4, rd.id.length);
                option.text = rd.type.charAt(0).toUpperCase() + rd.type.slice(1) + ": " + accountID + "($" + rd.balance + ")";
                option.value = rd.type + "|" + rd.id;
                AccountDropDown.add(option);

            }
        },
        error: function (error)
        {
            console.log(error);
        }
    }
    );
}

function ProcessTransaction()
{
    //No Amount Entered
    if (isNaN($("#Amount").val()) || $("#Amount").val() === "")
    {
        $("#errorDiv").html("<br /><b style='color:red;'> ERROR: </b> Invalid Amount!");

    //Negative Amount entered
    } else if ($("#Amount").val() <= 0)
    {
        $("#errorDiv").html("<br /><b style='color:red;'> ERROR: </b> Amount must be greater than or equal to 0!");
    }
    //No Account Or Invalid Account for transfer entered
    else if ($('#TransactOptions option:selected').val() === "Transfer" && isNaN($("#AccountTypeNumber").val() + $("#AccountID").val()))
    {

        $("#errorDiv").html("<br /><b style='color:red;'> ERROR: </b> Invalid Account!");

    } else
    {
        if ($('#errorDiv').is(':visible'))
        {
            $('#errorDiv').hide();
        }
        var accountDropdown = document.getElementById("AccountDropDown");
        var accountSelected = accountDropdown.options[accountDropdown.selectedIndex].value;
        var accountType = accountSelected.substring(0, accountSelected.indexOf('|'));
        var accountID = accountSelected.substring(accountSelected.indexOf('|') + 1, accountSelected.length);
        var roundedAmount = (Math.round($("#Amount").val() * 100) / 100);
        $("#TransactionOptions").hide();
        $("#ProcessTransactionDiv").show();

        setTimeout(function () {
            $.ajax({
                url: "NewTransactionBackEnd.php",
                dataType: "JSON",
                method: "POST",
                data: {newTransaction: $('#TransactOptions option:selected').val(), amount: roundedAmount, type: accountType, id: accountID, transfer: $("#AccountTypeNumber").val() + $("#AccountID").val()},
                success: function (returnData) {
                    //console.log("SUCCESS");
                   
                   var location = "TransactionComplete.php?amount=" + roundedAmount + "&transactionType=" + $('#TransactOptions option:selected').val() + "&type=" + accountType;
                   var form = '';
                   form += "<input type='hidden' name='accountID' id='accountID' value='" + accountID + "'>";
                   form += "<input type='hidden' name='transferAccountID' id='transferAccountID' value='" + $("#AccountTypeNumber").val() + $("#AccountID").val() + accountID + "'>";
                   if(returnData.output === "unknown account")
                   {
                       form += "<input type='hidden' name='errorTransaction' id='errorTransaction' value='" + returnData.output + "'>";
                   }
                   
                   $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }, 1000);


    }
}

