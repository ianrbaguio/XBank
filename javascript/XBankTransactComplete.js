/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    GetTransactionID($("#amount").html(), $("#hiddenAccountID").val(), $("#transactionType").html());
});


function GetTransactionID(amount, id, type)
{
    var today = new Date();
    var date = formatDate(today);

    if ($("#errorTransaction").val() !== "")
    {
        $("#TransactionCompleteDiv").hide();
        $("#ErrorCauseSpan").html($("#errorTransaction").val());
        $("#TransactionErrorDiv").show();
    } else
    {
        $.ajax({
            url: 'TransactionCompleteBackEnd.php',
            dataType: 'TEXT',
            method: 'POST',
            data: {submit: 'transactID', amount: amount, type: type, id: id, date: date},
            success: function (returnData) {

                if (returnData !== -1) {
                    $("#transactionID").html(returnData);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}

//gives the current date with the yyyy-mm-dd format, reference: https://stackoverflow.com/questions/23593052/format-javascript-date-to-yyyy-mm-dd
function formatDate(date) {
    var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}


