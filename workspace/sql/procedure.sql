
DROP PROCEDURE IF EXISTS sp_update_inventory;
DELIMITER $$
CREATE PROCEDURE sp_update_inventory(p_upc varchar(30), p_store_id INT(4))
BEGIN     
    DECLARE v_item_in_db VARCHAR(30);
    DECLARE v_is_present INT DEFAULT FALSE;
    
    DECLARE v_scaned_qty INT default 0;
    
    SELECT upc INTO v_item_in_db FROM ITEM WHERE upc = p_upc;
    
    -- if item exists in database
    IF v_item_in_db IS NOT NULL THEN

        SELECT scaned_qty INTO v_scaned_qty FROM INVENTORY WHERE upc = p_upc;
    
        IF v_scaned_qty = 0 THEN
            -- If the item is not yet in the INVENTORY table, insert it
            INSERT INTO INVENTORY (upc, store_id, scaned_qty)
            VALUES (p_upc, p_store_id, 1);
            
            SET v_is_present = false;
            
        ELSE
            -- If the item is already in the INVENTORY table, just increment its scaned quantity value
            UPDATE INVENTORY SET scaned_qty = scaned_qty + 1
            WHERE upc = p_upc;
            
            SET v_is_present = true;
            
        END IF;
    
         -- We suppose that the item exists in the Database. 
        SELECT
            --IFNULL((select model from item where upc=p_upc), 0) = 1 as in_inventory, -- Return 1 if the item is in the inventory and 0 otherwise
            item_no, 
            model, 
            wholesale, 
            scaned_qty
        FROM 
            ITEM, 
            INVENTORY 
        WHERE 
            ITEM.upc = INVENTORY.upc AND 
            ITEM.upc = p_upc;
    
    /*ELSE
        RAISE ERROR
    */
    END IF;
    
   

END;
$$
DELIMITER ;