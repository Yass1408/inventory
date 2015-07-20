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

function getBrand()
{
    getOption("SELECT DISTINCT brand FROM item where brand != '' ORDER BY brand", true);
}

function getColor()
{
    getOption("SELECT DISTINCT color FROM item where color != '' ORDER BY color");
}

function getPackage()
{
    getOption("SELECT DISTINCT package FROM item where package != '' ORDER BY package");
}

?>
<form class="form-horizontal" id="new-item-form" method="post" action="<?php echo htmlspecialchars('newItemProcess.php?upc='.$upc); ?>">
    <fieldset>

        <!-- Form Name -->
        <legend>Insert new Item <br><?php echo $upc ?></legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldItemNo">Product Number</label>

            <div class="col-md-4">
                <input id="txtFldItemNo" name="txtFldItemNo" type="text" placeholder="" class="form-control input-md"
                       autocomplete="off" required="" autofocus>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldModel">Model</label>

            <div class="col-md-4">
                <input id="txtFldModel" name="txtFldModel" type="text" placeholder="" class="form-control input-md"
                       autocomplete="off" required="">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectBrand">Brand</label>

            <div class="col-md-4">
                <select id="selectBrand" name="selectBrand" class="form-control">
                    <?php getBrand() ?>
                </select>
            </div>
        </div>
        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectColor">Color</label>

            <div class="col-md-4">
                <select id="selectColor" name="selectColor" class="form-control">
                    <?php getColor() ?>
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldFeature">Feature</label>

            <div class="col-md-4">
                <input id="txtFldFeature" name="txtFldFeature" type="text" placeholder=""
                       class="form-control input-md"
                       autocomplete="off">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldSheath">Sheath</label>

            <div class="col-md-4">
                <input id="txtFldSheath" name="txtFldSheath" type="text" placeholder=""
                       class="form-control input-md"
                       autocomplete="off">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectPackage">Package</label>

            <div class="col-md-4">
                <select id="selectPackage" name="selectPackage" class="form-control">
                    <?php getPackage() ?>
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldPackQty">Package Quantity</label>

            <div class="col-md-4">
                <input id="txtFldPackQty" name="txtFldPackQty" type="text" placeholder=""
                       class="form-control input-md"
                       autocomplete="off">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldMsrp">MSRP</label>

            <div class="col-md-4">
                <input id="txtFldMsrp" name="txtFldMsrp" type="text" placeholder="" class="form-control input-md"
                       autocomplete="off">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldUmp">UMP</label>

            <div class="col-md-4">
                <input id="txtFldUmp" name="txtFldUmp" type="text" placeholder="" class="form-control input-md"
                       autocomplete="off">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldWholesale">Wholesale</label>

            <div class="col-md-4">
                <input id="txtFldWholesale" name="txtFldWholesale" type="text" placeholder=""
                       class="form-control input-md" autocomplete="off">

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