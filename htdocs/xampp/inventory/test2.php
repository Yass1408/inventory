<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
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
$upc = $_GET['upc'];
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

$sql = "SELECT fx_update_inventory('" . $upc . "', '1') as code";
$result = $conn->query($sql);
$code = $result->fetch_object()->code;

if ($code == 0) {
    //the item does not exists in the database
    echo "the item is not yet in the database";

} elseif ($code == 1) {
    //the item has just been scaned
    $sql = "
				SELECT
		            item_no,
		            model,
		            wholesale,
		            '1' AS scaned_qty
		        FROM
		            ITEM
		        WHERE upc = '" . $upc . "'";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<script type='text/javascript'>", "addNewItem('" . $row[item_no] . "','" . $row[model] . "','" . $row[wholesale] . "','" . $row[scaned_qty] . "');", "</script>";
    }
    echo "item added!";

} elseif ($code == 2) {
    //the item is already in the inventory
    $sql = "
				SELECT
					item_no,
		            model,
		            wholesale,
		            scaned_qty
		        FROM
		            ITEM,
		            INVENTORY
		        WHERE
		            ITEM.upc = INVENTORY.upc";

    $result = $conn->query($sql);

    echo '
        <table>
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
    echo "</table>";

    echo "<h1>table updated</h1>";
}

$conn->close();
?>
</body>
</html>