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

if ($stmt = $conn->prepare("CALL sp_update_inventory(?, ?)")) {

    /* Binds variables to prepared statement */
    $stmt->bind_param('si', $upc, $store_id);

    /* execute query */
    $stmt->execute() or die($stmt->error);

    if (!$result = $stmt->get_result()) {
        //the query return NULL
        echo "item_not_found"; // TODO: handle this error

    } else {
        refreshInventory($result);
    }
    /* free results */
    $stmt->free_result();

    /* close statement */
    $stmt->close();
}
$conn->close();
