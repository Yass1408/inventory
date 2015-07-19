<?php
$upc = $_GET['upc'];
$store_id = 1;

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

$stmt = $conn->prepare("DELETE FROM inventory WHERE upc = ?;
SELECT
    ITEM.upc,
    item_no,
    model,
    wholesale,
    scaned_qty
FROM
    ITEM,
    INVENTORY
WHERE
    ITEM.upc = INVENTORY.upc;");

/* Binds variables to prepared statement */
$stmt->bind_param('s', $upc);

/* execute query */
$stmt->execute() or die($stmt->error);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['item_no'] . "</td>";
    echo "<td>" . $row['model'] . "</td>";
    echo "<td>" . $row['wholesale'] . "$</td>";
    echo "<td>" . $row['scaned_qty'] . "</td>";
    echo "<td><button class='btn btn-xs btn-edit-item' data-upc=" . $row['upc'] . "  data-model=" . $row['model'] . " data-qty=" . $row['scaned_qty'] . " data-toggle='modal'><span class='glyphicon glyphicon-pencil'></span></button></td>";
    echo "<td><button class='btn btn-danger btn-xs btn-remove-item' data-upc=" . $row['upc'] . " data-model=" . $row['model'] . " data-title='Delete' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span></button></td>";
    echo "</tr>";
}
echo "</table>";


/* free results */
$stmt->free_result();

/* close statement */
$stmt->close();

$conn->close();
?>