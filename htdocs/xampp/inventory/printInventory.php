<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <script src="js/jquery-1.11.3.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="col-md-8">
    <table id="inventoryTable" class="table table-list-search table-hover">
        <thead>
        <tr>
            <th>Upc</th>
            <th>Item Number</th>
            <th>Model</th>
            <th>Brand</th>
            <th>Color</th>
            <th>Package</th>
            <th>Package <br> Quantity</th>
            <th>Wholesale</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php
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

        $stmt = $conn->query("SELECT item.upc, item_no, model, brand, color, package, pack_qty, wholesale, inventory.scaned_qty FROM item, inventory WHERE item.upc = inventory.upc");

        while ($row = $stmt->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['upc'] . "</td>";
            echo "<td>" . $row['item_no'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['brand'] . "</td>";
            echo "<td>" . $row['color'] . "</td>";
            echo "<td>" . $row['package'] . "</td>";
            echo "<td>" . $row['pack_qty'] . "</td>";
            echo "<td>" . $row['wholesale'] . "$</td>";
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
