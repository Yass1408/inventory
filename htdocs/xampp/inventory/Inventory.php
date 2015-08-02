<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="_css/simple-sidebar.css" rel="stylesheet">

    <!-- Inventory CSS -->
    <link href="_css/inventory.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="_js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="">
                    Eastern Outdoor
                </a>
            </li>
            <li>
                <a href="">Inventory</a>
            </li>
            <li>
                <a href="">Item Search</a>
            </li>
            <li>
                <a href="printInventory.php" id="btn-printInventory">Print Inventory</a>
            </li>
            <li>
                <a href="">Settings</a>
            </li>
            <li>
                <a href="">About</a>
            </li>
            <li>
                <a href="">Contact</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

                    <?php include "html/modal.html"; ?>

                    <!-- Search Text Field -->
                    <div class="col-md-3">
                        <div class="input-group">
                            <input class="form-control" id="item-search" name="q" placeholder="Search for product"
                                   required
                                   autocomplete="off">
                            <!--
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                            -->
                        </div>
                    </div>

                    <!-- UPC Scan Text Field -->
                    <div class="col-md-2 navbar-fixed-bottom">
                        <input class="form-control" id="txtFldupc" name="upc" autofocus autocomplete="off"
                               placeholder="Scan UPC here">
                    </div>

                    <!-- Inventory Table -->
                    <table id="inventoryTable" class="table table-list-search table-hover">
                        <!-- TODO table hover  do not work-->
                        <thead>
                        <tr>
                            <th>Item Number</th>
                            <th>Model</th>
                            <th>Description</th>
                            <th>Manufacture</th>
                            <th>Quantity</th>
                            <th><span class='glyphicon glyphicon-edit'>&nbsp;</span></th>
                        </tr>
                        </thead>
                        <tbody id="inventory-data">

                        <?php
                        require "refreshInventory.php";

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
                        refreshInventory($conn, $username); //TODO give a unique ID with AJAX
                        $conn->close();
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->


<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

<script src="_js/inventorySearch.js"></script>
<script src="_js/inventory.js"></script>

</body>

</html>
