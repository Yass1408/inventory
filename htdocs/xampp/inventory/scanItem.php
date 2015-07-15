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
    $stmt->execute() or die($stmt->error);

    if (!$result = $stmt->get_result()) {
        echo "procedure sp_update_inventory return NULL"; // TODO: handle this error

    } else {
        $row = $result->fetch_assoc();
        if (!$row['in_db']) {
            echo "item_not_found"; // TODO: CREATE A SPECIAL ERROR FOR THIS CONDITION
        } else {
            echo '
                    <table>
                        <tr>
                            <th>Item<br>Number</th>
                            <th>Model</th>
                            <th>Wholesale</th>
                            <th>scaned<br>Quantity</th>
                        </tr>';

            do {
                echo "<tr>";
                echo "<td>" . $row['item_no'] . "</td>";
                echo "<td>" . $row['model'] . "</td>";
                echo "<td>" . $row['wholesale'] . "$</td>";
                echo "<td>" . $row['scaned_qty'] . "</td>";
                echo "</tr>";
            } while ($row = $result->fetch_assoc());
            echo "</table>";
        }
    }
    /* free results */
    $stmt->free_result();

    /* close statement */
    $stmt->close();
}
$conn->close();
?>