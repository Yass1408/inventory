﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="js/jquery-1.11.3.js"></script>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>

<body>

<?php
/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eos";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Convert the query result into utf8
$conn->query("SET character_set_results=utf8");

mb_language('uni'); 
mb_internal_encoding('UTF-8');
$conn->query("set names 'utf8'");


$sql="
SELECT 
    item_no, 
    model, 
    wholesale, 
    scaned_qty
FROM 
    ITEM, 
    INVENTORY 
WHERE ITEM.upc = INVENTORY.upc";

$result = $conn->query($sql);

echo '
<div id="inventory">
    <table>
        <tr>
            <th>Item<br>Number</th>
            <th>Model</th>
            <th>Wholesale</th>
            <th>scaned<br>Quantity</th>
        </tr>';
    
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['item_no'] . "</td>";
    echo "<td>" . $row['model'] . "</td>";
    echo "<td>" . $row['wholesale'] . "$</td>";
    echo "<td>" . $row['scaned_qty'] . "</td>";
    echo "</tr>";
}
echo "</table></div>";

$conn->close();
echo "<br><br>connexion ended"
*/?>

<script>
function showUser(key, upc) {
    var x = key.which || key.keyCode;

    if (x == 13) {
        if (upc == "") {
            document.getElementById("inventoryTable").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("inventoryTable").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","newItemInventory.php?upc="+upc,true);
            xmlhttp.send();
            
            // reset input for next scan
            document.getElementById("upc").value = "";
        }
    }
}
</script>

<p>Scan new item in the input field below</p>
<input id ="upc" type="text" name="upc" autofocus onkeypress="showUser(event, this.value)">

<br>
<div id="inventoryTable"><b>Person info will be listed here...</b></div>

</body>
</html>