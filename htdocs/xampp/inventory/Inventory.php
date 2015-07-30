<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/inventory.css">
    <script src="js/jquery-1.11.3.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>

    <!-- FOR PRODUCTION
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    -->

</head>

<body>
<div class="container-fuild">
<div class="row">
        <button type="button" class="btn btn-info navbar-fixed-top" id="btn-printInventory">Print Inventory</button>

        <!-- Item Not Found Modal -->
        <div id="modal-new-item" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Item Not Found Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Item Not Found!</h4>
                    </div>
                    <div class="modal-body">
                        <p id="lbl-not-found-item"></p>

                        <p>This item is not in de database.<br>Would you like to add it?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" id="btn-insertNewItem">Yes</button>
                        <!--TODO: diseable backgound. See modal options -->
                    </div>
                </div>

            </div>
        </div>

        <!-- Edit Item Quantity Modal -->
        <div id="modal-edit-item-qty" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Edit Item Quantity Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit item</h4>
                    </div>
                    <div class="modal-body">
                        <p id="lbl-edit-item-mes"></p>

                        <div class="col-md-9">  <!-- TODO: make it a form -->
                            <input id="new-item-qty" name="new-item-qty" type="number" placeholder="Item Quantity"
                                   class="form-control input-md" autocomplete="off" required="">
                        </div>
                        <button id="btn-edit-item" type="button" class="btn btn-primary" data-upc="">Save
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Remove Item Modal -->
        <div id="modal-remove-item" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Remove Item Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Remove item</h4>
                    </div>
                    <div class="modal-body">
                        <p id="lbl-remove-item-mes"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button id="btn-remove-item" type="button" class="btn btn-primary" data-upc="">Confirm
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-3 col-lg-push-2">
            <div class="input-group">
                <input class="form-control" id="item-search" name="q" placeholder="Search for product" required
                       autocomplete="off">
                <!--
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                    </button>
                </span>
                -->
            </div>
        </div>

        <div class="col-md-10 col-md-offset-2">
            <table id="inventoryTable" class="table table-list-search table-hover" >
                <!-- TODO table hover  do not work-->
                <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Model</th>
                    <th>Description</th>
                    <th>Manufacture</th>
                    <th>Quantity</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="inventory-data">

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
                /*
                mb_language('uni');
                mb_internal_encoding('UTF-8');
                $conn->query("set names 'utf8'");
                */

                $sql = "SELECT ITEM.upc, item_no, model, manufacture, description, scaned_qty FROM ITEM, INVENTORY WHERE ITEM.upc = INVENTORY.upc";

                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['item_no'] . "</td>";
                    echo "<td>" . $row['model'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['manufacture'] . "</td>";
                    echo "<td>" . $row['scaned_qty'] . "</td>";
                    echo "<td><button class='btn btn-xs btn-edit-item' data-upc='" . $row['upc'] . "' data-model='" . $row['model'] . "' data-qty='" . $row['scaned_qty'] . "' data-toggle='modal'><span class='glyphicon glyphicon-pencil'></span></button>";
                    echo "<button class='btn btn-danger btn-xs btn-remove-item' data-upc='" . $row['upc'] . "' data-model='" . $row['model'] . "' data-title='Delete' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span></button></td>";
                    echo "</tr>";
                }
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-2 navbar-fixed-bottom">
            <input class="form-control" id="txtFldupc" name="upc" autofocus autocomplete="off"
                   placeholder="Scan UPC here">
        </div>
</div>
</div>

<script src="js/inventorySearch.js"></script>
<script src="js/inventory.js"></script>
</body>
</html>