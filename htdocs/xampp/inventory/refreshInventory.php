<?php

function refreshInventory($conn, $username)
{
    $result = $conn->query("
    SELECT
        ITEM.upc,
        item_no,
        model,
        description,
        manufacture,
        scaned_qty
    FROM
        ITEM,
        INVENTORY
    WHERE
        ITEM.upc = INVENTORY.upc
        and user_id ='". $username ."'
    ORDER BY added_time");

    while ($row = $result->fetch_assoc()) {
        echo "<tr id='".$row['upc']."'>";
        echo "<td style='width:12%'>" . $row['item_no'] . "</td>";
        echo "<td style='width:30%'>" . $row['model'] . "</td>";
        echo "<td style='width:30%'>" . (empty($row['description']) ? " - " : $row['description']) . "</td>";
        echo "<td style='width:13%'>" . $row['manufacture'] . "</td>";
        echo "<td style='width: 5%'>" . $row['scaned_qty'] . "</td>";
        echo "<td style='width:7%'><button class='btn btn-xs btn-edit-item' data-upc=" . $row['upc'] . "  data-model=" . $row['model'] . " data-qty=" . $row['scaned_qty'] . " data-toggle='modal'><span class='glyphicon glyphicon-pencil'></span></button>";
        echo "<button class='btn btn-danger btn-xs btn-remove-item' data-upc=" . $row['upc'] . " data-model=" . $row['model'] . " data-title='Delete' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span></button></td>";
        echo "</tr>";
    }
}

