<?php
session_start();
require "refreshInventory.php";

$upc = $_GET['upc'];
$store_id = 1;


// Create connection
$conn = new mysqli("localhost", $_SESSION["name"], $_SESSION["pass"], $_SESSION["database"]);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Convert the query result into utf8
$conn->query("SET character_set_results=utf8");

$stmt = $conn->prepare("
INSERT INTO INVENTORY (upc, user_id, store_id, scaned_qty)
VALUES ((SELECT upc FROM ITEM WHERE upc = ? and (verified=1 or added_by=?)), ?, ?, 1)
ON DUPLICATE KEY UPDATE scaned_qty = scaned_qty + 1");

/* Binds variables to prepared statement */
$stmt->bind_param('sssi', $upc, $_SESSION["name"], $_SESSION["name"], $store_id);

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


refreshInventory($conn, $_SESSION["name"]);

$conn->close();
