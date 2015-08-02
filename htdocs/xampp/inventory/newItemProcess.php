<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upc = $_GET['upc']; //TODO trouver un moyen plus elegant de chercher le UPC

    $itemNo = test_input($_POST["txtFldItemNo"]);
    $model = test_input($_POST["txtFldModel"]);
    $manufacture = test_input($_POST["selectManufacture"]);
    $description = test_input($_POST["txtFldDescription"]);

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

    $stmt = "INSERT INTO item (upc, item_no, model, manufacture, description) VALUE ('" . $upc . "','" . $itemNo . "','" . $model . "','" . $manufacture. "','" . $description . "')";

    if (!$conn->query($stmt)) {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }

    $stmt = "INSERT INTO inventory (upc, user_id, store_id, scaned_qty) VALUE ('". $upc ."', '".$username."', 1, 1)"; // TODO don't hard code store_id a

    if (!$conn->query($stmt)) {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }

    header("location:inventory.php", true, 303);

// ENDIF
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if (empty($data)) {
        $data = 0;
    }
    return $data;
}

$conn->close();
?>