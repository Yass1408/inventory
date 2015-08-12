<?php
session_start();
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <!-- Bootstrap Core CSS -->
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="vendor/components/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    </head>
    <body>

    <?php
    $upc = $_GET['upc'];

    // todo validate upc length
    // Create connection
    $conn = new mysqli("localhost", $_SESSION["name"], $_SESSION["pass"], $_SESSION["database"]);
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
                    <input id="txtFldItemNo" name="txtFldItemNo" type="text" placeholder=""
                           class="form-control input-md"
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
                    <input id="txtFldDescription" name="txtFldDescription" type="text" placeholder=""
                           class="form-control input-md"
                           autocomplete="off">

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