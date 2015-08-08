<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>InventoryIt</title>

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

    <script src="_js/inventorySearch.js"></script>
    <script src="_js/inventory.js"></script>

    <style>
        body {
            padding-top: 51px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }

    </style>
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
                <a href="">INVENTORY</a>
            </li>
            <li>
                <a href="" id="btn-printInventory" data-toggle="collapse" data-target="#export-options">EXPORT
                    INVENTORY</a>
                <ul id="export-options" class="collapse">
                    <li>
                        <a href="printInventory.php">EXCEL</a>
                    </li>
                    <li>
                        <a href="">PDF</a>
                    </li>
                </ul>
            </li>
            <li>
            <li>
                <a href="">EDIT DATABASE</a>
            </li>
            <li>
                <a href="">SETTINGS</a>
            </li>
            <li>
                <a href="">CONTACT</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <!-- Navigation -->
                    <nav class="navbar navbar-inverse navbar-fixed-top">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
<!--                            <div class="navbar-header">-->
<!--                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"-->
<!--                                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">-->
<!--                                    <span class="sr-only">Toggle navigation</span>-->
<!--                                    <span class="icon-bar"></span>-->
<!--                                    <span class="icon-bar"></span>-->
<!--                                    <span class="icon-bar"></span>-->
<!--                                </button>-->
<!--                                <a class="navbar-brand" href="#">Brand</a>-->
<!--                            </div>-->

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
<!--                                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>-->
<!--                                    <li><a href="#">Link</a></li>-->
                                    <li>
                                        <div>
                                            <a href="#menu-toggle" class="navbar-brand" id="menu-toggle">
                                                <!-- <span class='glyphicon glyphicon-chevron-left'></span> -->
                                                &nbsp;Menu</a>
                                        </div>
                                    </li>

                                </ul>
                                <div class="navbar-form navbar-left">
                                    <div class="form-group">
                                        <input class="form-control" id="txtFldupc" name="upc" onkeypress="alert('fds')"
                                               autofocus
                                               autocomplete="off"
                                               placeholder="Scan UPC here"
                                               required>
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                                <ul class="nav navbar-nav navbar-right">
                                    <li>
                                          <span class='glyphicon glyphicon-search navbar-brand'>&nbsp;</span>
                                    </li>
                                    <li>
<!--                                         Search Text Field-->
                                        <form class="navbar-form navbar-left" role="search">
                                          <div class="form-group">
                                              <input class="form-control" id="item-search" name="q"
                                                     placeholder="Search for product"
                                                     required
                                                     autocomplete="off">
                                        </form>
                                         </div>
                                    </li>

                                </ul>
                            </div>
                            <!-- /.navbar-collapse -->
                        </div>
                        <!-- /.container-fluid -->
                    </nav>
                    <!-- /Navigation -->

                    <?php include "_html/modal.html"; ?> <!--TODO CORRECT GO BACK SO THE TABLE IS ALWAYS UP TO DATE-->


                    <!-- Inventory Table -->
                    <table id="inventoryTable" class="table table-list-search table-hover table-fixed">
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

                    <!-- <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>-->

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

</body>

</html>
