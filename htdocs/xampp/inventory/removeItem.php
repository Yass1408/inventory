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

$stmt = $conn->prepare("DELETE FROM inventory WHERE upc = ? and user_id = ?");

/* Binds variables to prepared statement */
$stmt->bind_param('ss', $upc, $_SESSION["name"]);

/* execute query */
$stmt->execute() or die($stmt->error);

/* free results */
$stmt->free_result();

/* close statement */
$stmt->close();


refreshInventory($conn,$_SESSION["name"]);

$conn->close();
