$(document).ready(function () {
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

    function validateUpc(upc) {
        if (upc.length == 11) { // todo ne tient pas compte des UPC a 10 digits
            return '0' + upc;
        }// todo regular expression
    }

    function validateQty(number) {
        return !number.NaN && number > 0 && number % 1 === 0;
    }

    function scanItem(key, upc) {
        var x = key.which || key.keyCode;

        // if return is pressed
        if (x == 13) {
            upc = validateUpc(upc);

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

// Update item quantity button
    $(document).on("click", ".btn-edit-item", function () {
        var upc = $(this).data('upc');
        var model = $(this).data('model');
        var itemQty = $(this).data('qty');
        $("#lbl-edit-item-mes").html("<b>" + model + "</b>");
        $("#btn-edit-item").data("upc", upc);
        $("#new-item-qty").val(itemQty);
        $('#modal-edit-item-qty').modal('show');
    });

// Remove item button
    $(document).on("click", ".btn-remove-item", function () {
        var upc = $(this).data('upc');
        var model = $(this).data('model');
        $("#lbl-remove-item-mes").html("Are you sure you want to remove <b>" + model + "</b> from the inventory?");
        $("#btn-remove-item").data("upc", upc);
        $("#modal-remove-item").modal("show");
    });

    //$(document).on("click", "#btn-printInventory", printInventory());
    $(document).onclick(function(){alert(ds);});
    $(document).on("click", "#btn-edit-item", updateQuantity($(this).data('upc'), $('#new-item-qty').val()));
    $(document).on("click", "#btn-remove-item", removeItem($(this).data('upc')));

    $(document).keypress(scanItem(event, this.value));
});