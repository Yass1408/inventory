<!DOCTYPE html>
    <html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="js/jquery-1.11.3.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
</head>
<body>

<form class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Insert new Item</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldItemNo">Product Number</label>
            <div class="col-md-4">
                <input id="txtFldItemNo" name="txtFldItemNo" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldModel">Model</label>
            <div class="col-md-4">
                <input id="txtFldModel" name="txtFldModel" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectBrand">Brand</label>
            <div class="col-md-4">
                <select id="selectBrand" name="selectBrand" class="form-control">
                    <option value="1">Leatherman</option>
                    <option value="2">Led Lenser</option>
                </select>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectColor">Color</label>
            <div class="col-md-4">
                <select id="selectColor" name="selectColor" class="form-control">
                    <option value="0">--</option>
                    <option value="1">Black</option>
                    <option value="2">Blue</option>
                    <option value="99">Other</option>
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldFeature">Feature</label>
            <div class="col-md-4">
                <input id="txtFldFeature" name="txtFldFeature" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldSheath">Sheath</label>
            <div class="col-md-4">
                <input id="txtFldSheath" name="txtFldSheath" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectPackage">Package</label>
            <div class="col-md-4">
                <select id="selectPackage" name="selectPackage" class="form-control">
                    <option value="1">BOX</option>
                    <option value="2">PKG</option>
                    <option value="3">PEG</option>
                    <option value="4">GIFT</option>
                    <option value="5">OTHER</option>
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldPackQty">Package Quantity</label>
            <div class="col-md-4">
                <input id="txtFldPackQty" name="txtFldPackQty" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldMsrp">MSRP</label>
            <div class="col-md-4">
                <input id="txtFldMsrp" name="txtFldMsrp" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldUmp">UMP</label>
            <div class="col-md-4">
                <input id="txtFldUmp" name="txtFldUmp" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="txtFldWholesale">Wholesale</label>
            <div class="col-md-4">
                <input id="txtFldWholesale" name="txtFldWholesale" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="btnNewItem">Save Item</label>
            <div class="col-md-4">
                <button id="btnNewItem" name="btnNewItem" class="btn btn-inverse">Save</button>
            </div>
        </div>

    </fieldset>
</form>


</body>
</html>