<?php
echo 'new item process!';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $upc = $_GET['upc']; //TODO trouver un moyen plus elegant de chercher le UPC

    $itemNo = test_input($_POST["txtFldItemNo"]);
    $model = test_input($_POST["txtFldModel"]);
    $brand = test_input($_POST["selectBrand"]);
    $color = test_input($_POST["selectColor"]);
    $feature = test_input($_POST["txtFldFeature"]);
    $sheath = test_input($_POST["txtFldSheath"]);
    $package = test_input($_POST["selectPackage"]);
    $packageQty = test_input($_POST["txtFldPackQty"]);
    $msrp = test_input($_POST["txtFldMsrp"]);
    $ump = test_input($_POST["txtFldUmp"]);
    $wholesale = test_input($_POST["txtFldWholesale"]);

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

    $stmt = "INSERT INTO item (upc, item_no, model, brand, color, feature, sheath, package, pack_qty, msrp, ump, wholesale) VALUE ('" . $upc . "','" . $itemNo . "','" . $model . "','" . $brand . "','" . $color . "','" . $feature . "','" . $sheath . "','" . $package . "','" . $packageQty . "'," . $msrp . "," . $ump . "," . $wholesale . ")";

    if (!$conn->query($stmt)) {
        echo "Error: " . $stmt . "<br>" . $conn->error;
    }

    $stmt = "INSERT INTO inventory (upc, store_id, scaned_qty) VALUE ('". $upc ."', 1, 1)"; // TODO dont hard code store_id

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