/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    $("#PageLoadingDiv").hide();
    GetBankAccountInfo();
    
});

//function GetBankAccountInfo()
//{
//    $.ajax({url: 'mainBackend.php',
//    method: 'POST',
//    dataType: 'JSON',
//    success: function(data)
//    {
//        //success call will show bank accounts information to the main page
//        //source(create table): https://stackoverflow.com/questions/14643617/create-table-using-javascript
//       var table = document.getElementById("BankAccountsTable");
//       var header = table.createTHead();
//       var titleRow = header.insertRow(0);
//       var titleCell = titleRow.insertCell(0);
//       
//       titleCell.style.fontWeight = 'bold';
//       titleCell.innerHTML = "Accounts:";
//       
//       for(var i = 0; i < data.length; i++)
//       {
//           var returndata = data[i];
//
//           var AccountID = returndata.id.slice(0,4) + "-" + returndata.id.slice(4, returndata.id.length);
//           
//           var row = table.insertRow();
//           row.className = 'AccountsInfoTR';
//           var accountCell = row.insertCell();
//           var balanceCell = row.insertCell();
//           
//           var TransactionButton = document.createElement('button');
//           TransactionButton.className = "inputLink";
//           TransactionButton.value = returndata.type;
//           //TransactionButton.onclick = SendInfoTransaction(returndata.type);
//           TransactionButton.innerHTML = AccountID;
//           
//           
//           accountCell.style.float = 'left';
//           accountCell.innerHTML = returndata.type + ": " + "<button class='inputLink' name='type' id='type' value='"+ returndata.type+"' click='"+ SendInfoTransaction(returndata.type) + "'>" + AccountID + "</button></td>";
//           
//           balanceCell.style.float = 'right';
//           balanceCell.style.fontWeight = 'bold';
//           balanceCell.innerHTML = "$" + returndata.balance;
//       }
//       
//       
//       
//    },
//    error: function(error)
//    {
//        console.log(error);
//    } 
//    });
//        
//}

function GetBankAccountInfo()
{
    $.ajax({url: 'mainBackend.php',
    method: 'POST',
    dataType: 'JSON',
    success: function(data)
    {
        //success call will show bank accounts information to the main page
       // var listString = "<form method='post' action='Transactions.php'>";
       //var listString = "<table>";
       // listString += "<table>";
        var listString = "<tr> <th>Accounts: </th></tr>";
        for(var i = 0; i < data.length; i++)
        {
            var returndata = data[i];

            var AccountID = returndata.id.slice(0,4) + "-" + returndata.id.slice(4, returndata.id.length);
            
            listString += "<tr class='AccountInfoTR'>";
            listString += "<td style='float:left'>" + returndata.type + ": <button class='inputLink' name='accountdetails' id='accountdetails' value='"+ returndata.type+ "|" + returndata.id +"'>" + AccountID + "</button></td>";
            //listString += "<td style='float:left'>" + returndata.type + ": <button class='inputLink' name='type' id='type' value='"+ returndata.type+ "|" + returndata.id + "' onclick='SendInfoTransaction(this)'>" + AccountID + "</button></td>";
            //listString += "<td style='float:left'>" + returndata.type + ": <input class='inputLink' type='submit' name='type' id='type' value='"+AccountID+"'></td>";
            listString += "<td class='table_amount_column'>$" + returndata.balance + "</td>";
            listString += "</tr>";
            
            //*****https://stackoverflow.com/questions/15315315/how-do-i-add-a-button-to-a-td-using-js***!!
            //
            //alert("ID: " + returndata.id + " Balance: " + returndata.balance)
        }
        
        //listString += "</table>";
        //listString += "</form>";
        $("#BankAccountsTable").html(listString);
    },
    error: function(error)
    {
        console.log(error);
    } 
    });
        
}

function SendInfoTransaction(type, id)
{  
   
    $.ajax({
        url: 'TransactionsBackEnd.php',
        method: 'GET',
        data: {'account': id, 'type': type},
        dataType: 'JSON'
    });

}



