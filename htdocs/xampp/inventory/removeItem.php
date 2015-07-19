<?php
require "refreshInventory.php";

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

$stmt = $conn->prepare("DELETE FROM inventory WHERE upc = ?");

/* Binds variables to prepared statement */
$stmt->bind_param('s', $upc);

/* execute query */
$stmt->execute() or die($stmt->error);

/* free results */
$stmt->free_result();

/* close statement */
$stmt->close();

////////////////////////////////////////////////////////////

$stmt = $conn->query("SELECT
    ITEM.upc,
    item_no,
    model,
    wholesale,
    scaned_qty
FROM
    ITEM,
    INVENTORY
WHERE
    ITEM.upc = INVENTORY.upc");


refreshInventory($stmt);

$conn->close();
?>