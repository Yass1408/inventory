
DROP PROCEDURE IF EXISTS sp_update_inventory;
DELIMITER $$
CREATE PROCEDURE sp_update_inventory(p_upc varchar(30), p_store_id INT(4))
MODIFIES SQL DATA
BEGIN     
    DECLARE v_item_in_db VARCHAR(30);
    DECLARE v_is_present INT DEFAULT FALSE;    
    DECLARE v_scaned_qty INT default 0;
    DECLARE item_not_found CONDITION FOR SQLSTATE '45000';
 

    INSERT INTO INVENTORY (upc, store_id, scaned_qty)
    VALUES ((SELECT upc FROM ITEM WHERE upc = p_upc), p_store_id, 1)
    ON DUPLICATE KEY UPDATE scaned_qty = scaned_qty + 1;

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
        ITEM.upc = INVENTORY.upc;

END;
$$
DELIMITER ;