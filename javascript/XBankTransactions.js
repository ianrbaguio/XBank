/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    
    GetTransactionInfo();

    $("#TransferButton").click(TransferTransaction);
    
    $("#PageLoadingDiv").hide();
});

function GetTransactionInfo()
{
    $.ajax({
        url: 'TransactionsBackEnd.php?page=' + $("#HiddenCurrentPage").val(),
        method: 'POST',
        dataType: 'JSON',
        data: {type: $("#AccountType").val(), account: $("#AccountTypeID").val()},
        success: function (returnedData)
        {
            //success call will show bank accounts information to the main page
            //var listString = "<form method='get' action='Transactions.php'>";   
            var AccountID = returnedData.account.id.slice(0, 4) + "-" + returnedData.account.id.slice(4, returnedData.account.id.length);

            //Shows available account that can be transfer (FROM)
            var FromDropDown = document.getElementById("FromDropDown");

            //If chequing type is choose then it will show chequing account first
            if ($("#AccountType").val() === "Chequing")
            {
                for (var i = 0; i < returnedData.chequing.length; i++)
                {
                    var rd = returnedData.chequing[i];
                    var AccountReturn = rd.chequingID.slice(0, 4) + "-" + rd.chequingID.slice(4, rd.chequingID.length);
                    var option = document.createElement("option");
                    option.text = "Chequing: " + AccountReturn + "($" + rd.chequingBalance + ")";
                    option.value = "Chequing|" + rd.chequingID;
                    FromDropDown.add(option);

                }

                for (var i = 0; i < returnedData.savings.length; i++)
                {
                    var rd = returnedData.savings[i];
                    var AccountReturn = rd.savingsID.slice(0, 4) + "-" + rd.savingsID.slice(4, rd.savingsID.length);
                    var option = document.createElement("option");
                    option.text = "Savings: " + AccountReturn + "($" + rd.savingsBalance + ")";
                    option.value = "Savings|" + rd.savingsID;
                    FromDropDown.add(option);

                }

                //If savings type is choose then it will show savings account first
            } else if ($("#AccountType").val() === "Savings")
            {
                for (var i = 0; i < returnedData.savings.length; i++)
                {
                    var rd = returnedData.savings[i];
                    var AccountReturn = rd.savingsID.slice(0, 4) + "-" + rd.savingsID.slice(4, rd.savingsID.length);
                    var option = document.createElement("option");
                    option.text = "Savings: " + AccountReturn + "($" + rd.savingsBalance + ")";
                    option.value = "Savings|" + rd.savingsID;
                    FromDropDown.add(option);

                }
                for (var i = 0; i < returnedData.chequing.length; i++)
                {
                    var rd = returnedData.chequing[i];
                    var AccountReturn = rd.chequingID.slice(0, 4) + "-" + rd.chequingID.slice(4, rd.chequingID.length);
                    var option = document.createElement("option");
                    option.text = "Chequing: " + AccountReturn + "($" + rd.chequingBalance + ")";
                    option.value = "Chequing|" + rd.chequingID;
                    FromDropDown.add(option);

                }
            }


            //Shows available account that can be transfer to (TO)
            var ToDropDown = document.getElementById("ToDropDown");
            for (var i = 0; i < returnedData.chequing.length; i++)
            {
                //Make sure it doesn't caught the selected transaction account
                if (returnedData.account.id !== returnedData.chequing[i].chequingID)
                {
                    var rd = returnedData.chequing[i];
                    var AccountReturn = rd.chequingID.slice(0, 4) + "-" + rd.chequingID.slice(4, rd.chequingID.length);
                    var option = document.createElement("option");
                    option.text = "Chequing: " + AccountReturn + "($" + rd.chequingBalance + ")";
                    option.value = "Chequing|" + rd.chequingID;
                    ToDropDown.add(option);
                }

            }

            for (var i = 0; i < returnedData.savings.length; i++)
            {
                //Make sure it doesn't caught the selected transaction account
                if (returnedData.account.id !== returnedData.savings[i].savingsID)
                {
                    var rd = returnedData.savings[i];
                    var AccountReturn = rd.savingsID.slice(0, 4) + "-" + rd.savingsID.slice(4, rd.savingsID.length);
                    var option = document.createElement("option");
                    option.text = "Savings: " + AccountReturn + "($" + rd.savingsBalance + ")";
                    option.value = "Savings|" + rd.savingsID;
                    ToDropDown.add(option);
                }

            }

            var option = document.createElement("option");
            option.text = "Other";
            ToDropDown.add(option);

            //Shows available account to transfer
            //Shows transaction history  
            var listString = "<table>";
            listString += "<tr style='background-color: blue; color:white;'> <th class='mobile_column'>Date</th> <th>Description</th> <th class='mobile_column'>Amount</th> <th>Balance</th></tr>";
            for (var i = 0; i < returnedData.data.length; i++)
            {
                var rd = returnedData.data[i];

                listString += "<tr class='AccountInfoTR'>";
                listString += "<td class='mobile_column'>" + rd.date + "</td>";
                listString += "<td>" + rd.description + "</td>";

                if (rd.amount > 0.00)
                {
                    listString += "<td style='color: green' class='mobile_column'> $" + rd.amount + "</td>";
                } else if (rd.amount < 0.00)
                {

                    listString += "<td style='color: red' class='mobile_column'> $" + (rd.amount * -1) + "</td>";

                }

                listString += "<td> $" + rd.balance + "</td>";
                listString += "</tr>";

                //*****https://stackoverflow.com/questions/15315315/how-do-i-add-a-button-to-a-td-using-js***!!
                //
                //alert("ID: " + rd.id + " Balance: " + rd.balance)
            }

            var pages = "";

            if (returnedData.totalpages > 5)
            {
                for (var i = 1; i <= 5; i++)
                {
                    pages += "<a href='?page=" + i + "'>" + i + "</a>";
                }
            } else
            {
                for (var i = 1; i <= returnedData.totalpages; i++)
                {
                    pages += "<a href='?page=" + i + "'>" + i + "</a>";
                }
            }
            $("#AccountNumber").html(AccountID);
            $("#BalanceStatus").html("$" + returnedData.account.balance);
            listString += "</table>";
            $("#paginationDiv").html(pages);
            $("#TransactionsBody").html(listString);


        },
        error: function (error)
        {
            console.log(error);
        }
    });
}


function TransferTransaction()
{

    //FromDropDown
    //ToDropDown

    //Account variables
    var pipeLineAccountIndex = $("#FromDropDown option:selected").val().indexOf("|");
    var AccountType = $("#FromDropDown option:selected").val().substring(0, pipeLineAccountIndex);
    var AccountID = $("#FromDropDown option:selected").val().substring(pipeLineAccountIndex + 1, $("#FromDropDown option:selected").val().length);

    //Transfer account variables
    var pipeLineTransferIndex = $("#ToDropDown option:selected").val().indexOf("|");
    var TransferAccountType = $("#ToDropDown option:selected").val().substring(0, pipeLineTransferIndex);
    var TransferAccountID = $("#ToDropDown option:selected").val().substring(pipeLineTransferIndex + 1, $("#ToDropDown option:selected").val().length);

    if (AccountID === TransferAccountID)
    {
        var error = "<b style='color:red'> ERROR: </b> Cannot transfer to the same account";
        $("#TransferOptionErrorDiv").html(error);
    } else if ($("#amount").val() <= 0 || isNaN($("#amount").val()))
    {
        var error = "<b style='color:red'> ERROR: </b> Invalid amount";
        $("#TransferOptionErrorDiv").html(error);
    } else
    {
        if (TransferAccountID === "Other")
        {
            var location = "NewTransaction.php?accountType=" + AccountType;

            var form = "<input type='hidden' name='accountID' id='accountID' value='" + AccountID + "'>";

            $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
        } else
        {
            var error = "processing..";
            $("#TransferOptionErrorDiv").html(error);

            setTimeout(function () {
                $.ajax({
                    url: "NewTransactionBackEnd.php",
                    dataType: "JSON",
                    method: "POST",
                    data: {newTransaction: "transfer", amount: $("#amount").val(), type: AccountType, id: AccountID, transfer: TransferAccountID},
                    success: function (returnData) {
                        //console.log("SUCCESS");

                        var location = "TransactionComplete.php?amount=" + $("#amount").val() + "&transactionType=Transfer&type=" + AccountType;
                        var form = '';
                        form += "<input type='hidden' name='accountID' id='accountID' value='" + AccountID + "'>";
                        form += "<input type='hidden' name='transferAccountID' id='transferAccountID' value='" + $("#AccountTypeNumber").val() + $("#AccountID").val() + AccountID + "'>";
                        if (returnData.output === "unknown account")
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
}