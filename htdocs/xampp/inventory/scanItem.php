<?php
require "refreshInventory.php";

$upc = $_GET['upc'];
$store_id = 1;

$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "eos";

// Create connection
$conn = new mysqli($serverName, $username, $password, $dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Convert the query result into utf8
$conn->query("SET character_set_results=utf8");

$stmt = $conn->prepare("INSERT INTO INVENTORY (upc, user_id, store_id, scaned_qty) VALUES ((SELECT upc FROM ITEM WHERE upc = ?), ?, ?, 1) ON DUPLICATE KEY UPDATE scaned_qty = scaned_qty + 1");

/* Binds variables to prepared statement */
$stmt->bind_param('ssi', $upc, $username, $store_id);

/* execute query */
if (!$stmt->execute()) {
    echo 'ITEM_NOT_FOUND_EXCEPTION';
    die;
} else {
    /* free results */
    $stmt->free_result();
}

/* close statement */
$stmt->close();


refreshInventory($conn, $username);

$conn->close();
