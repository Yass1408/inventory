
DROP PROCEDURE IF EXISTS sp_update_inventory;
DELIMITER $$
CREATE PROCEDURE sp_update_inventory(p_upc varchar(30), p_store_id INT(4))
BEGIN     
    DECLARE v_item_in_db   VARCHAR(30);
    DECLARE v_ordered_qty INT default 0;
    DECLARE v_is_present INT DEFAULT FALSE;
    
    SELECT ordered_qty INTO v_ordered_qty FROM INVENTORY WHERE upc = p_upc;
    SELECT upc INTO v_item_in_db FROM ITEM WHERE upc = p_upc;
    
    -- if item exists in database
    IF v_item_in_db IS NOT NULL THEN
    
        IF v_ordered_qty = 0 THEN
            -- If the item is not yet in the INVENTORY table, insert it
            INSERT INTO INVENTORY (upc, store_id, ordered_qty)
            VALUES (p_upc, p_store, 1);
            
            SET v_is_present = false;
            
        ELSE
            -- If the item is already in the INVENTORY table, juste increment its ordered quantity value
            UPDATE INVENTORY SET ordered_qty = ordered_qty + 1
            WHERE upc = p_upc;
            
            SET v_is_present = true;
            
        END IF;
    
    /*ELSE
        RAISE ERROR
    */
    END IF;
END;
$$
DELIMITER ;