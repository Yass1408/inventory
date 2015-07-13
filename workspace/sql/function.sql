
DROP FUNCTION IF EXISTS fx_update_inventory;
DELIMITER $$
CREATE FUNCTION fx_update_inventory(p_upc varchar(30), p_store_id INT(4))
    RETURNS INT(1) MODIFIES SQL DATA
BEGIN
    /* the function returns
        1 if the item is in the database but not yet in the inventory
        2 if the item is already in the inventory
        3 if the item does not exists in the database
    */
    DECLARE v_item_in_db VARCHAR(30);
    DECLARE v_scaned_qty INT default 0;
    DECLARE item_not_found CONDITION FOR SQLSTATE '45000';
    
    SELECT upc INTO v_item_in_db FROM ITEM WHERE upc = p_upc;
    
    IF v_item_in_db IS NOT NULL THEN
    -- if item exists in database

        SELECT scaned_qty INTO v_scaned_qty FROM INVENTORY WHERE upc = p_upc;
    
        IF v_scaned_qty = 0 THEN
            -- If the item is not yet in the INVENTORY table, insert it
            INSERT INTO INVENTORY (upc, store_id, scaned_qty)
            VALUES (p_upc, p_store_id, 1);
            RETURN 1;
        ELSE
            -- If the item is already in the INVENTORY table, just increment its scaned quantity value
            UPDATE INVENTORY SET scaned_qty = scaned_qty + 1
            WHERE upc = p_upc;
            RETURN 2;            
        END IF;
    
    ELSE
    -- the item does not exists in the database.
        return 0;
            
    END IF;
END;
$$
DELIMITER ;