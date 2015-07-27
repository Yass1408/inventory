<?php

function refreshInventory($conn)
{
    $result = $conn->query("
    SELECT
        ITEM.upc,
        item_no,
        model,
        wholesale,
        scaned_qty
    FROM
        ITEM,
        INVENTORY
    WHERE
        ITEM.upc = INVENTORY.upc");

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
}

