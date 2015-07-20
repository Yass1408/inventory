<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <script src="js/jquery-1.11.3.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
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

$stmt = "SELECT * FROM INVENT";
?>
</body>
</html>

<?php
$conn->close();
?>