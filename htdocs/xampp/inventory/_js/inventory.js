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
            xmlhttp.open("GET", url + "&rand=" + Math.floor(Math.random() * 1000), true);
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
        // Scan new item
        $("#txtFldupc").keypress(function (key) {
            var txtFldUpc = $("#txtFldupc");

            //if (!txtFldUpc.is(":focus") && !$("#item-search").is(":focus")) {
            //txtFldUpc.focus();
            //txtFldUpc.val(String.fromCharCode(key.which));
            //}

            var upc = txtFldUpc.val();
            var x = key.which || key.keyCode;
            // if return is pressed

            if (x == 13) {
                upc = validateUpc(upc);

                // add the scanned item in the inventory
                loadXMLDoc("scanItem.php?upc=" + upc, function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        //TODO if item added to inventory: label->last item added UPC
                        if (xmlhttp.responseText == "ITEM_NOT_FOUND_EXCEPTION") {
                            txtFldUpc.blur();
                            //TODO find a way to focus on YES button
                            $('#lbl-not-found-item').html(upc);
                            $('#modal-new-item').modal("show");
                        } else {
                            document.getElementById("inventory-data").innerHTML = xmlhttp.responseText;

                            // Item added label
                            $('#lbl-itemAdded-title').css('display', 'inherit');
                            $('#lbl-itemAdded').html(upc);

                            //highlight item table row
                            //$('#' + upc).addClass('selected');
                            setTimeout(highlightTableRow, 200);
                        }
                    }
                });
                // Focus on last added item
                //location.href = '#'+upc;
                //$('#'+upc).addClass('selected');

                // reset input for next scan
                $(this).val("");

                //txtFldUpc.focus();
            }
        });

        // Highlight the last item scanned
        function highlightTableRow() {
            var upc = $('#lbl-itemAdded').html();
            location.href = '#' + upc;
            $('#' + upc).addClass('selected');
            $("#txtFldupc").focus();
        }


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


        // Menu toggle
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });


        // Adjust inventory table
        var $window = $(window).on('resize', function () {
            var content = $('#sidebar-wrapper').height();
            var header = $('#navigation-wrapper').height() * 2;
            var tableWrapper = $('#table-wrapper').height(content - header);
            var tableHeaderWrapper = $('#table-header-wrapper').height();

            $('#table-body-wrapper').height(tableWrapper.height() - tableHeaderWrapper);
        }).trigger('resize'); //on page load

    }
)
;