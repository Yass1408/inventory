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

if ($stmt = $conn->prepare("CALL sp_update_inventory(?, ?)")) {

    /* Binds variables to prepared statement */
    $stmt->bind_param('si', $upc, $store_id);

    /* execute query */
    $stmt->execute();

    if (!$result = $stmt->get_result()) {
        //the query return NULL
        echo "item_not_found"; // TODO: handle this error

    } else {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['item_no'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['wholesale'] . "$</td>";
            echo "<td>" . $row['scaned_qty'] . "</td>";
            echo "<td><button class='btn btn-xs' value=" . $row['upc'] . " data-toggle='modal' data-target='#edit-item-qty'><span class='glyphicon glyphicon-pencil'></span></button></td>";
            echo '<td><button class="btn btn-danger btn-xs" value=' . $row['upc'] . ' data-title="Delete" data-toggle="modal" data-target="#remove-item" ><span class="glyphicon glyphicon-trash"></span></button></td>';
            echo "</tr>";
        }
        echo "</table>";
    }
    /* free results */
    $stmt->free_result();

    /* close statement */
    $stmt->close();
}
$conn->close();
?>