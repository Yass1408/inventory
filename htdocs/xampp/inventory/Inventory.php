﻿<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/inventory.css">
    <script src="js/jquery-1.11.3.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="js/inventory.js"></script>

    <!-- FOR PRODUCTION
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    -->
</head>

<body>
<div class="container">
    <div class="row">

        <button type="button" class="btn btn-info" onclick="printInventory()">Print Inventory
        </button>

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
                        <button type="button" class="btn btn-primary" onclick="insertNewItem()">Yes</button>
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
                        <button id="btn-edit-item" type="button" class="btn btn-primary" data-upc=""
                                onclick="updateQuantity($(this).data('upc'), $('#new-item-qty').val())">Save
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button id="btn-remove-item" type="button" class="btn btn-primary" data-upc=""
                                onclick="removeItem($(this).data('upc'))">Yes
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-3">
            <form action="#" method="get">
                <div class="input-group">
                    <!-- USE TWITTER TYPEAHEAD JSON WITH API TO SEARCH -->
                    <input class="form-control" id="item-search" name="q" placeholder="Search for" required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>

        <div class="col-md-8">
            <table id="inventoryTable" class="table table-list-search table-hover">
                <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Model</th>
                    <th>Wholesale</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody id="inventory-data">

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
                /*
                mb_language('uni');
                mb_internal_encoding('UTF-8');
                $conn->query("set names 'utf8'");
                */

                $sql = "SELECT ITEM.upc, item_no, model, wholesale, scaned_qty FROM ITEM, INVENTORY WHERE ITEM.upc = INVENTORY.upc";

                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['item_no'] . "</td>";
                    echo "<td>" . $row['model'] . "</td>";
                    echo "<td>" . $row['wholesale'] . "$</td>";
                    echo "<td>" . $row['scaned_qty'] . "</td>";
                    echo "<td><button class='btn btn-xs btn-edit-item' data-upc=" . $row['upc'] . "  data-model=" . $row['model'] . " data-qty=" . $row['scaned_qty'] . " data-toggle='modal'><span class='glyphicon glyphicon-pencil'></span></button></td>";
                    echo "<td><button class='btn btn-danger btn-xs btn-remove-item' data-upc=" . $row['upc'] . " data-model=" . $row['model'] . " data-title='Delete' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span></button></td>";
                    echo "</tr>";
                }

                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <input class="form-control" id="txtFldupc" name="upc" autofocus autocomplete="off"
                   placeholder="Scan UPC here"
                   onkeypress="scanItem(event, this.value)">
        </div>
    </div>
</div>

<!-- JS to put into a load event callback -->
<script>
    var xmlhttp; // TODO: get rid of this global variable

    function loadXMLDoc(url, cfunc) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = cfunc;
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }

    function scanItem(key, upc) {
        var x = key.which || key.keyCode;

        // if return is pressed
        if (x == 13) {

            // add the scanned item in the inventory
            loadXMLDoc("scanItem.php?upc=" + upc, function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if (xmlhttp.responseText == "ITEM_NOT_FOUND_EXCEPTION") {
                        $('#lbl-not-found-item').html(upc);
                        $('#modal-new-item').modal("show");
                    } else {
                        document.getElementById("inventory-data").innerHTML = xmlhttp.responseText;
                    }
                }
            });
            // reset input for next scan
            $("#txtFldupc").val("");
        }
    }

    function printInventory() {
        window.location.href = 'printInventory.php';
    }
    function insertNewItem() {
        window.location.href = 'newItemForm.php?upc=' + $("#lbl-not-found-item").html();
    }

    function removeItem(upc) {
        loadXMLDoc("removeItem.php?upc=" + upc, function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("inventory-data").innerHTML = xmlhttp.responseText;
            }
        });
        $('#modal-remove-item').modal('hide');
    }

    function validateQty(number) {
        return !number.NaN && number > 0 && number % 1 === 0;
    }

    function updateQuantity(upc, quantity) {
        if (validateQty(quantity)) {
            loadXMLDoc("updateQuantity.php?upc=" + upc + "&quantity=" + quantity, function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("inventory-data").innerHTML = xmlhttp.responseText;
                }
            });
            $('#modal-edit-item-qty').modal('hide');
        } else {
            // TODO: error message
        }
    }

    $(document).on("click", ".btn-edit-item", function () {
        var upc = $(this).data('upc');
        var model = $(this).data('model');
        var itemQty = $(this).data('qty');
        $("#lbl-edit-item-mes").html("<b>" + model + "</b>");
        $("#btn-edit-item").data("upc", upc);
        $("#new-item-qty").val(itemQty);
        $('#modal-edit-item-qty').modal('show');
    });

    $(document).on("click", ".btn-remove-item", function () {
        var upc = $(this).data('upc');
        var model = $(this).data('model');
        $("#lbl-remove-item-mes").html("Are you sure you want to remove <b>" + model + "</b> from the inventory?");
        $("#btn-remove-item").data("upc", upc);
        ;
        $("#modal-remove-item").modal("show");
    });

</script>
</body>
</html>