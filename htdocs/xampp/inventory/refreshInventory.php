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

th {text-align: left;}
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "yassine";
$password = "2217";
$dbname = "eos";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql="SELECT * FROM store";
$result = $conn->query($sql);

echo "
<table>
    <tr>
        <th>Store_id</th>
        <th>name</th>
        <th>adress</th>
    </tr>";
    
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['store_id'] . "</td>";
    echo "<td>" . $row['store_name'] . "</td>";
    echo "<td>" . $row['store_adress'] . "</td>";
    echo "</tr>";
}
echo "</table>";
$conn->close();
echo "connexion ended!"
?>
</body>
</html>