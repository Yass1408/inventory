<?php


class user
{
    public function __construct($user_id){

        $qry_str = mysql_query("SELECT * FROM users WHERE Id=$userId");

}

}

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
/*
mb_language('uni');
mb_internal_encoding('UTF-8');
$conn->query("set names 'utf8'");
*/
refreshInventory($conn, $username); //TODO give a unique ID with AJAX
$conn->close();