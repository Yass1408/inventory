<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upc = $_GET['upc']; //TODO Create a class item and insert item

    $itemNo = test_input($_POST["txtFldItemNo"]);
    $model = test_input($_POST["txtFldModel"]);
    $manufacture = test_input($_POST["selectManufacture"]);
    $description = test_input($_POST["txtFldDescription"]);


    // Create connection
    $conn = new mysqli("localhost", $_SESSION["name"], $_SESSION["pass"], $_SESSION["database"]);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = "INSERT INTO item (upc, item_no, model, manufacture, description, added_by) VALUE ('" . $upc . "','" . $itemNo . "','" . $model . "','" . $manufacture. "','" . $description . "','" . $_SESSION['name'] . "')";

    if (!$conn->query($stmt)) {
        die("Error: " . $stmt . "<br>" . $conn->error);
    }

    $stmt = "INSERT INTO inventory (upc, user_id, store_id, scaned_qty) VALUE ('". $upc ."', '".$_SESSION["name"]."', 1, 1)"; // TODO don't hard code store_id a

    if (!$conn->query($stmt)) {
        die("Error: " . $stmt . "<br>" . $conn->error);
    }

    header("location:inventory.php", true, 303);

// ENDIF
}

// TODO this function already exists. create a utils class!
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