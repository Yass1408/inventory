<?php
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='filename.xls'");
header("Cache-Control: max-age=0");
?>

<!--<!DOCTYPE html>-->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<!--    <script src="js/jquery-1.11.3.js"></script>-->
<!--    <script src="bootstrap/js/bootstrap.js"></script>-->
</head>
<body>
<div class="col-md-8">
    <table id="inventoryTable" class="table table-list-search table-hover">
        <thead>
        <tr>
            <th>Upc</th>
            <th>Item Number</th>
            <th>Model</th>
            <th>Description</th>
            <th>Manufacture</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php
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

        $stmt = $conn->query("SELECT item.upc, item_no, model, manufacture, description, inventory.scaned_qty FROM item, inventory WHERE item.upc = inventory.upc");

        while ($row = $stmt->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['upc'] . "</td>";
            echo "<td>" . $row['item_no'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['manufacture'] . "</td>";
            echo "<td>" . $row['scaned_qty'] . "</td>";
            echo "</tr>";
        }
        ?>

        <?php
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
