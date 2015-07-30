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
        } else {
            return upc;
        }// todo regular expression
    }

    function validateQty(number) {
        return !number.NaN && number > 0 && number % 1 === 0;
    }

    // TODO --> enter upc from document $(document).keypress(function (key) {
    $("#txtFldupc").keypress(function (key) {
        var txtFldUpc = $("#txtFldupc");
        /*
        if (!txtFldUpc.is(":focus") && !$("#item-search").is(":focus")) {
            txtFldUpc.focus();
            txtFldUpc.val(String.fromCharCode(key.which));
        }
        */
        var upc = txtFldUpc.val();
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
            $(this).val("");
        }
    });

    $("#btn-printInventory").click(function () {
        window.location.href = 'printInventory.php';
    });

    $("#btn-insertNewItem").click(function insertNewItem() {
        window.location.href = 'newItemForm.php?upc=' + $("#lbl-not-found-item").html();
    });

    $("#btn-remove-item").click(function () {
        loadXMLDoc("removeItem.php?upc=" + $(this).data('upc'), function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("inventory-data").innerHTML = xmlhttp.responseText;
            }
        });
        $('#modal-remove-item').modal('hide');
    });

    $("#btn-edit-item").click(function () {
        var newQty = $('#new-item-qty').val();
        if (validateQty(newQty)) {
            loadXMLDoc("updateQuantity.php?upc=" + $(this).data('upc') + "&quantity=" + newQty, function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("inventory-data").innerHTML = xmlhttp.responseText;
                }
            });
            $('#modal-edit-item-qty').modal('hide');
        } else {
            // TODO: error message
        }
    });

// Update item quantity button
    $(document).on("click", ".btn-edit-item", function () {
        var upc = $(this).data('upc');
        var model = $(this).data('model'); // TODO bug avec l'affichage du model dans la boite de dialogue
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
        $("#lbl-remove-item-mes").html("Are you sure you want to delete: <br><b>" + model + "</b></br>");
        $("#btn-remove-item").data("upc", upc);
        $("#modal-remove-item").modal("show");
    });

    //$(document).on("click", "#btn-printInventory", printInventory());
    //$("#btn-insertNewItem").click(function () {
    //    alert('d');
    //});
    //$(document).on("click", "#btn-edit-item", updateQuantity($('#new-item-qty').val()));
    //$(document).on("click", "#btn-remove-item", removeItem($(this).data('upc')));


});