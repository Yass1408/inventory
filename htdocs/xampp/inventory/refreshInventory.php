<!DOCTYPE html>
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

        th {
            text-align: left;
        }
    </style>
</head>

<body>

<?php

$servername = "localhost";
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
/*
mb_language('uni'); 
mb_internal_encoding('UTF-8');
$conn->query("set names 'utf8'");
*/

$sql = "
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
<div id="inventoryTable-wrapper">
    <table id="inventoryTable">
        <tr>
            <th>Item<br>Number</th>
            <th>Model</th>
            <th>Wholesale</th>
            <th>scaned<br>Quantity</th>
        </tr>';

while ($row = $result->fetch_assoc()) {
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
?>

<script>
    var xmlhttp;

    function loadXMLDoc(url, cfunc) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = cfunc;
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function updateInventory(key, upc) {
        var x = key.which || key.keyCode;

        // if return is pressed
        if (x == 13) {

            // add the scanned item in the inventory
            loadXMLDoc("newItemInventory.php?upc="+upc, function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    alert(xmlhttp.responseText);
                    document.getElementById("inventoryTable-wrapper").innerHTML = xmlhttp.responseText;
                }
            });

            // reset input for next scan
            document.getElementById("upcInput").value = "";

        }
    }

    function addNewItem(item_no, model, wholesale, scaned_qty) {
        var table = document.getElementById("inventoryTable");
        var row = table.insertRow(-1);

        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);

        cell0.innerHTML = item_no;
        cell1.innerHTML = model;
        cell2.innerHTML = wholesale;
        cell3.innerHTML = scaned_qty;
    }

</script>

<p>
    Scan new item in the input field below
</p>
<input id="upcInput" type="text" name="upc" autofocus autocomplete="off"
       onkeypress="updateInventory(event, this.value)">

<br>

<div id="inventoryTable-wrapper">
    <b>Person info will be listed here...</b>
</div>

</body>
</html>