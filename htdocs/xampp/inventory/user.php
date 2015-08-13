<?php


class user
{
    public function __construct($user_id){

        $qry_str = mysql_query("SELECT * FROM users WHERE Id=$user_Id");

}

}


// Create connection
$conn = new mysqli("localhost", $_SESSION["name"], $_SESSION["pass"], $_SESSION["database"]);
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