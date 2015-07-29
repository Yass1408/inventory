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

$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "eos";
// todo validate upc length
// Create connection
$conn = new mysqli($serverName, $username, $password, $dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Convert the query result into utf8
$conn->query("SET character_set_results=utf8");


function getOption($sql, $required = false)
{
    global $conn;
    $result = $conn->query($sql);
    echo '<option value="0">&nbsp;</option>';
    $nbOption = 1;
    while ($row = $result->fetch_array()) {
        echo '<option value="' . $row[0] . '">' . $row[0] . '</option>'; // TODO give each item a value
        $nbOption++;
    }
    if (!$required) {
        echo '<option value="' . $row[0] . '">Other</option>';
    }
}

function getManufacture()
{
    getOption("SELECT DISTINCT manufacture FROM item WHERE manufacture != '' ORDER BY manufacture", true);
}


?>
<form class="form-horizontal" id="new-item-form" method="post"
      action="<?php echo htmlspecialchars('newItemProcess.php?upc=' . $upc); ?>">
    <fieldset>

        <!-- Form Name -->
        <legend>Insert new Item <br><?php echo $upc ?></legend>

        <!-- Product Number Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldItemNo">Product Number</label>

            <div class="col-md-4">
                <input id="txtFldItemNo" name="txtFldItemNo" type="text" placeholder="" class="form-control input-md"
                       autocomplete="off" required="" autofocus>
            </div>
        </div>

        <!-- Model Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldModel">Model</label>

            <div class="col-md-4">
                <input id="txtFldModel" name="txtFldModel" type="text" placeholder="" class="form-control input-md"
                       autocomplete="off" required="">

            </div>
        </div>

        <!-- Manufacture Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectManufacture">manufacture</label>

            <div class="col-md-4">
                <select id="selectManufacture" name="selectManufacture" class="form-control">
                    <?php getManufacture() ?>
                </select>
            </div>
        </div>

        <!-- Description Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtDescription">Description</label>

            <div class="col-md-4">
                <input id="txtFldDescription" name="txtFldDescription" type="text" placeholder="" class="form-control input-md"
                       autocomplete="off" required="">

            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="btnNewItem">Save Item</label>

            <div class="col-md-4">
                <button id="btnNewItem" name="btnNewItem" class="btn btn-primary submit">Save</button>
            </div>
        </div>

    </fieldset>
</form>
</body>
</html>

<?php
$conn->close();
?>