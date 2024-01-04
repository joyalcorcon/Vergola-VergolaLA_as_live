<?php
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data quote  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_quote = "
    INSERT INTO ver_chronoforms_data_quote_vic 
    (
        quoteid,                        projectid,                  project_name, 
        framework_type,                 framework,                  inventoryid, 
        description,                    webbing,                    colour, 
        finish,                         uom,                        cost, 
        qty,                            length_feet,                length_inch, 
        length_fraction,                rrp,                        is_additional, 
        customisation_options,          created_at 
    )
    VALUES 
    (
        '[QUOTE_ID]',                   '[PROJECT_ID]',             '[PROJECT_NAME]', 
        '[VR_FRAMEWORK_TYPE]',          '[VR_TYPE_DISPLAY_NAME]',   '[VR_ITEM_REF_NAME]', 
        '[VR_ITEM_DISPLAY_NAME]',       '[VR_ITEM_WEBBING]',        '[VR_ITEM_COLOUR]', 
        '[VR_ITEM_FINISH]',             '[VR_ITEM_UOM]',            '[VR_ITEM_UNIT_PRICE]', 
        '[VR_ITEM_QTY]',                '[VR_ITEM_LENGTH_FEET]',    '[VR_ITEM_LENGTH_INCH]', 
        '[VR_ITEM_LENGTH_FRACTION]',    '[VR_ITEM_RRP]',            '[VR_ITEM_ADHOC]', 
        '[CUSTOMISATION_OPTIONS]',      NOW() 
    );
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data followup  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_followup = "
    INSERT INTO ver_chronoforms_data_followup_vic 
    (
        quoteid,                                quotedate,                              projectid, 
        project_name,                           rep_id,                                 sales_rep, 
        framework_type,                         default_color,                          sales_comm, 
        sales_comm_cost,                        com_pay1,                               com_pay2, 
        com_final,                              install_comm,                           install_comm_cost, 
        payment_deposit,                        payment_progress,                       payment_final, 
        subtotal_vergola,                       subtotal_disbursement,                  total_cost, 
        total_gst,                              total_cost_gst,                         total_rrp_gst, 
        total_rrp,                              gst_percent,                            comm_percent, 
        is_builder_project,                     status,                                 customisation_options, 
        created_at,                             updated_at 
    )
    VALUES 
    (
        '[QUOTE_ID]',                           '[QUOTE_DATE]',                         '[PROJECT_ID]', 
        '[PROJECT_NAME]',                       '[SALES_REP_ID]',                       '[SALES_REP_NAME]', 
        '[VR_FRAMEWORK_TYPE]',                  '[VR_DEFAULT_COLOUR]',                  '[VR_COMMISSION_SALES_COMMISSION]', 
        '[VR_COMMISSION_SALES_COMMISSION]',     '[VR_COMMISSION_PAY1]',                 '[VR_COMMISSION_PAY2]', 
        '[VR_COMMISSION_FINAL]',                '[VR_COMMISSION_INSTALLER_PAYMENT]',    '[VR_COMMISSION_INSTALLER_PAYMENT]', 
        '[VR_PAYMENT_DEPOSIT]',                 '[VR_PAYMENT_PROGRESS_PAYMENT]',        '[VR_PAYMENT_FINAL_PAYMENT]', 
        '[VR_PAYMENT_VERGOLA]',                 '[VR_PAYMENT_DISBURSEMENT_SUB_TOTAL]',  '[VR_PAYMENT_SUB_TOTAL]', 
        '[VR_PAYMENT_TAX]',                     '[VR_PAYMENT_TAX]',                     '[VR_PAYMENT_TOTAL]', 
        '[TOTAL_RRP]',                          '[GST_PERCENT]',                        '[COMM_PERCENT]', 
        '[IS_BUILDER_PROJECT]',                 'Costed',                               '[CUSTOMISATION_OPTIONS]', 
        NOW(),                                  NOW() 
    );
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data measurement  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_measurement = "
    INSERT INTO ver_chronoforms_data_measurement_vic 
    (
        projectid,                  framework_type,         width_feet, 
        width_inch,                 length_feet,            length_inch, 
        created_at 
    )
    VALUES 
    (
        '[PROJECT_ID]',             '[VR_FRAMEWORK_TYPE]',  '[VR_WIDTH_FEET]', 
        '[VR_WIDTH_INCH]',          '[VR_LENGTH_FEET]',     '[VR_LENGTH_INCH]', 
        NOW() 
    );
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data letters  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_letters = "
    INSERT INTO ver_chronoforms_data_letters_vic 
    (
        clientid,       template_name,      template_content, 
        datecreated 
    )
    VALUES 
    (
        '[CLIENT_ID]',  '[TEMPLATE_NAME]',  '{[TEMPLATE_CONTENT]}', 
        NOW() 
    );
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data contract items  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_contract_items = "
    INSERT INTO ver_chronoforms_data_contract_items_vic 
    (
        quoteid,                        projectid,                  project_name, 
        framework_type,                 framework,                  inventoryid, 
        description,                    webbing,                    colour, 
        finish,                         uom,                        cost, 
        qty,                            length_feet,                length_inch, 
        length_fraction,                rrp,                        is_additional, 
        customisation_options,          created_at 
    )
    VALUES 
    (
        '[QUOTE_ID]',                   '[PROJECT_ID]',             '[PROJECT_NAME]', 
        '[VR_FRAMEWORK_TYPE]',          '[VR_TYPE_DISPLAY_NAME]',   '[VR_ITEM_REF_NAME]', 
        '[VR_ITEM_DISPLAY_NAME]',       '[VR_ITEM_WEBBING]',        '[VR_ITEM_COLOUR]', 
        '[VR_ITEM_FINISH]',             '[VR_ITEM_UOM]',            '[VR_ITEM_UNIT_PRICE]', 
        '[VR_ITEM_QTY]',                '[VR_ITEM_LENGTH_FEET]',    '[VR_ITEM_LENGTH_INCH]', 
        '[VR_ITEM_LENGTH_FRACTION]',    '[VR_ITEM_RRP]',            '[VR_ITEM_ADHOC]', 
        '[CUSTOMISATION_OPTIONS]',      NOW() 
    );
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data contract bom meterial  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_contract_bom_meterial = "
    INSERT INTO ver_chronoforms_data_contract_bom_meterial_vic 
    ( 
            contract_item_cf_id,        section, 
            projectid,                  inventoryid,                materialid, 
            raw_cost,                   qty,                        length_feet, 
            length_inch,                length_fraction,            supplierid 
    ) 
    (
        SELECT  
            '[CONTRACT_ITEM_CF_ID]',    '[VR_SECTION_REF_NAME]', 
            '[PROJECT_ID]',             im.inventoryid,             im.materialid, 
            dm.raw_cost,                '[VR_ITEM_QTY]',            '[LENGTH_FEET]', 
            '[LENGTH_INCH]',            '[LENGTH_FRACTION]',        dm.supplierid 
        FROM ver_chronoforms_data_inventory_material_vic AS im 
            JOIN ver_chronoforms_data_materials_vic AS dm ON dm.cf_id = im.materialid 
        WHERE im.inventoryid = '[INVENTORY_ID]' 
    );
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data contract bom  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_contract_bom = "
    INSERT INTO ver_chronoforms_data_contract_bom_vic 
    ( 
        orderdate,                          quoteid,                        projectid, 
        framework_type,                     framework,                      description, 
        inventoryid,                        colour,                         finish, 
        uom,                                qty,                            length_feet, 
        length_inch,                        length_fraction,                cost, 
        rrp,                                contract_item_cf_id,            inventory_section, 
        inventory_category,                 supplierid,                     is_reorder 
    ) 
    VALUES 
    ( 
        NOW(),                              '[QUOTE_ID]',                   '[PROJECT_ID]', 
        '[VR_FRAMEWORK_TYPE]',              '[VR_TYPE_DISPLAY_NAME]',       '[VR_ITEM_DISPLAY_NAME]', 
        '[VR_ITEM_REF_NAME]',               '[VR_ITEM_COLOUR]',             '[VR_ITEM_FINISH]', 
        '[VR_ITEM_UOM]',                    '[VR_ITEM_QTY]',                '[VR_ITEM_LENGTH_FEET]', 
        '[VR_ITEM_LENGTH_INCH]',            '[VR_ITEM_LENGTH_FRACTION]',    '[VR_ITEM_UNIT_PRICE]', 
        '[VR_ITEM_RRP]',                    '[CONTRACT_ITEM_CF_ID]',        '[VR_SECTION_REF_NAME]', 
        '[VR_SUBSECTION_REF_NAME]',     '[SUPPLIER_ID]',                '[IS_REORDER]'
    );
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- insert data contract item dimensions  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_insert_data_contract_item_dimensions = "
    INSERT INTO ver_chronoforms_data_contract_items_deminsions 
    (
        cf_id,                          quoteid,                    projectid, 
        inventoryid, 
        length_feet,                    length_inch,                length_fraction, 
        dimension_a_inch,               dimension_a_fraction, 
        dimension_b_inch,               dimension_b_fraction, 
        dimension_c_inch,               dimension_c_fraction, 
        dimension_d_inch,               dimension_d_fraction, 
        dimension_e_inch,               dimension_e_fraction, 
        dimension_f_inch,               dimension_f_fraction,
        dimension_g_inch,               dimension_g_fraction,         
        dimension_h_inch,               dimension_h_fraction,
        dimension_p_inch,               dimension_p_fraction, 
        girth_side_a_inch,              girth_side_a_fraction, 
        girth_side_b_inch,              girth_side_b_fraction, 
        created_at 
    )
    VALUES 
    (
        '[CF_ID]',                      '[QUOTE_ID]',               '[PROJECT_ID]', 
        '[VR_ITEM_REF_NAME]', 
        '[LENGTH_FEET]',                '[LENGTH_INCH]',            '[LENGTH_FRACTION]', 
        '[DIMENSION_A_INCH]',           '[DIMENSION_A_FRACTION]', 
        '[DIMENSION_B_INCH]',           '[DIMENSION_B_FRACTION]', 
        '[DIMENSION_C_INCH]',           '[DIMENSION_C_FRACTION]', 
        '[DIMENSION_D_INCH]',           '[DIMENSION_D_FRACTION]', 
        '[DIMENSION_E_INCH]',           '[DIMENSION_E_FRACTION]', 
        '[DIMENSION_F_INCH]',           '[DIMENSION_F_FRACTION]', 
        '[DIMENSION_G_INCH]',           '[DIMENSION_G_FRACTION]',
        '[DIMENSION_H_INCH]',           '[DIMENSION_H_FRACTION]',
        '[DIMENSION_P_INCH]',           '[DIMENSION_P_FRACTION]', 
        '[GIRTH_SIDE_A_INCH]',           '[GIRTH_SIDE_A_FRACTION]', 
        '[GIRTH_SIDE_B_INCH]',           '[GIRTH_SIDE_B_FRACTION]', 
        NOW() 
    );
";










/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve colour list -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_colour_list = "
    SELECT 
        colour AS 'ref_name', 
        colour AS 'display_name', 
        cf_id AS 'display_order' 
    FROM ver_chronoforms_data_colour_vic 
    ORDER BY cf_id 
    LIMIT 1000;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve section list -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_section_list = "
    SELECT 
        section AS 'ref_name', 
        section_display_name AS 'display_name', 
        section_display_order AS 'display_order' 
    FROM ver_chronoforms_data_section_vic 
    GROUP BY section 
    ORDER BY section_display_order 
    LIMIT 1000;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve subsection list -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_subsection_list = "
    SELECT 
        section AS 'section_ref_name', 
        section_display_name, 
        section_display_order, 
        category AS 'subsection_ref_name', 
        category AS 'subsection_display_name', 
        subsection_display_order 
    FROM ver_chronoforms_data_section_vic 
    ORDER BY section_display_order, subsection_display_order 
    LIMIT 1000;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve item list -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_item_list = "
    SELECT 
        ver_chronoforms_data_section_vic.section AS 'section_ref_name', 
        ver_chronoforms_data_section_vic.section_display_name, 
        ver_chronoforms_data_section_vic.section_display_order, 
        ver_chronoforms_data_section_vic.category AS 'subsection_ref_name', 
        ver_chronoforms_data_section_vic.category AS 'subsection_display_name', 
        ver_chronoforms_data_section_vic.subsection_display_order, 
        ver_chronoforms_data_inventory_vic.inventoryid AS 'item_ref_name', 
        ver_chronoforms_data_inventory_vic.description AS 'item_display_name', 
        ver_chronoforms_data_inventory_vic.cf_id AS 'item_display_order', 
        ver_chronoforms_data_inventory_vic.uom AS 'item_uom', 
        ver_chronoforms_data_inventory_vic.rrp AS 'item_unit_price', 
        ver_chronoforms_data_inventory_vic.photo AS 'item_image', 
        IFNULL(ver_chronoforms_data_inventory_vic.customisation_options, '') AS 'item_customisation_options' 
    FROM ver_chronoforms_data_section_vic 
        LEFT JOIN ver_chronoforms_data_inventory_vic 
            ON ver_chronoforms_data_section_vic.section = ver_chronoforms_data_inventory_vic.section 
            AND ver_chronoforms_data_section_vic.category = ver_chronoforms_data_inventory_vic.category 
    ORDER BY 
        ver_chronoforms_data_section_vic.section_display_order, 
        ver_chronoforms_data_section_vic.subsection_display_order, 
        ver_chronoforms_data_inventory_vic.cf_id 
    LIMIT 1000;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve vr form items config list -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_vr_form_items_config_list = "
    SELECT 
        ic.vr_type_ref_name, 
        ic.vr_type_display_name, 
        ic.vr_section_ref_name, 
        ic.vr_section_display_name, 
        ic.vr_subsection_ref_name, 
        ic.vr_subsection_display_name, 
        ic.vr_item_ref_name, 
        iv.description AS 'vr_item_display_name', 
        ic.vr_item_display_name_input_type, 
        ic.vr_item_webbing, 
        ic.vr_item_webbing_input_type, 
        ic.vr_item_colour, 
        ic.vr_item_colour_input_type, 
        ic.vr_item_finish, 
        ic.vr_item_finish_input_type, 
        iv.uom AS 'vr_item_uom', 
        ic.vr_item_uom_input_type, 
        iv.rrp AS 'vr_item_unit_price', 
        ic.vr_item_unit_price_input_type, 
        ic.vr_item_qty, 
        ic.vr_item_qty_input_type, 
        ic.vr_item_length_feet, 
        ic.vr_item_length_feet_input_type, 
        ic.vr_item_length_inch, 
        ic.vr_item_length_inch_input_type, 
        ic.vr_item_length_fraction, 
        ic.vr_item_length_fraction_input_type, 
        ic.vr_item_rrp, 
        ic.vr_item_rrp_input_type, 
        iv.photo AS 'vr_item_image', 
        ic.vr_item_image_input_type, 
        ic.vr_item_config_internal_ref_name, 
        ic.vr_item_adhoc, 
        ic.vr_record_index, 
        ic.status 
    FROM tblvrformitemsconfig ic 
        LEFT JOIN ver_chronoforms_data_inventory_vic iv 
            ON ic.vr_item_ref_name = iv.inventoryid COLLATE utf8_unicode_ci 
    WHERE ic.vr_type_ref_name = '[VR_TYPE_REF_NAME]' 
    AND ic.status IN ('active', 'hidden') 
    ORDER BY ic.display_order 
    LIMIT 1000;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve vr form items config list by item info -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_vr_form_items_config_list_by_item_info = "
    SELECT 
        vr_type_ref_name, 
        vr_section_display_name, 
        vr_section_ref_name, 
        vr_subsection_display_name, 
        vr_subsection_ref_name, 
        vr_item_display_name_input_type, 
        vr_item_webbing_input_type, 
        vr_item_colour_input_type, 
        vr_item_finish_input_type, 
        vr_item_uom_input_type, 
        vr_item_unit_price_input_type, 
        vr_item_qty_input_type, 
        vr_item_length_feet_input_type, 
        vr_item_length_inch_input_type, 
        vr_item_length_fraction_input_type, 
        vr_item_rrp_input_type, 
        vr_item_image, 
        vr_item_image_input_type, 
        vr_item_config_internal_ref_name 
    FROM tblvrformitemsconfig 
    WHERE vr_type_ref_name = '[VR_TYPE_REF_NAME]' 
    AND vr_item_ref_name = '[VR_ITEM_REF_NAME]' 
    ORDER BY id 
    [LIMIT_CONDITION]; 
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve vr form items config list by section info -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_vr_form_items_config_list_by_section_info = "
    SELECT 
        vr_type_ref_name, 
        vr_section_display_name, 
        vr_section_ref_name, 
        vr_subsection_display_name, 
        vr_subsection_ref_name, 
        vr_item_display_name_input_type, 
        vr_item_webbing_input_type, 
        vr_item_colour_input_type, 
        vr_item_finish_input_type, 
        vr_item_uom_input_type, 
        vr_item_unit_price_input_type, 
        vr_item_qty_input_type, 
        vr_item_length_feet_input_type, 
        vr_item_length_inch_input_type, 
        vr_item_length_fraction_input_type, 
        vr_item_rrp_input_type, 
        vr_item_image, 
        vr_item_image_input_type, 
        vr_item_config_internal_ref_name 
    FROM tblvrformitemsconfig 
    WHERE vr_section_ref_name = '[VR_SECTION_REF_NAME]' 
    AND vr_subsection_ref_name = '[VR_SUBSECTION_REF_NAME]' 
    ORDER BY id 
    LIMIT 1; 
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve total process order items by section info -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_total_process_order_items_by_section_info = "
    SELECT 
        ds.section AS 'ref_name', 
        ds.section_display_name AS 'display_name', 
        ds.section_display_order AS 'display_order', 
        ( 
            SELECT COUNT(*) 
            FROM ver_chronoforms_data_contract_bom_vic dcb 
            WHERE dcb.projectid = '[PROJECT_ID]' 
            AND dcb.quoteid = '[QUOTE_ID]' 
            AND dcb.inventory_section = ds.section 
        ) AS 'total_process_order_items' 
    FROM ver_chronoforms_data_section_vic ds 
    GROUP BY ds.section 
    ORDER BY ds.section_display_order 
    LIMIT 1000;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data quote  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_quote = "
    SELECT 
        dq.cf_id, 
        dq.framework_type, 
        dq.framework, 
        dq.inventoryid, 
        dq.description, 
        dq.webbing, 
        dq.colour, 
        dq.finish, 
        dq.uom, 
        iv.rrp AS 'cost', 
        dq.qty, 
        dq.length_feet, 
        dq.length_inch, 
        dq.length_fraction, 
        dq.rrp, 
        dq.is_additional, 
        iv.section, 
        iv.category, 
        iv.photo 
    FROM ver_chronoforms_data_quote_vic dq 
        LEFT JOIN ver_chronoforms_data_inventory_vic iv 
            ON dq.inventoryid = iv.inventoryid 
        LEFT JOIN ver_chronoforms_data_section_vic ds 
            ON iv.section = ds.section 
            AND iv.category = ds.category 
    WHERE dq.projectid = '[PROJECT_ID]' 
    ORDER BY ds.section_display_order, dq.cf_id; 
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data followup  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_followup = "
    SELECT * FROM ver_chronoforms_data_followup_vic WHERE projectid = '[PROJECT_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data measurement  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_measurement = "
    SELECT * FROM ver_chronoforms_data_measurement_vic WHERE projectid = '[PROJECT_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data client info  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_clientpersonal = "
    SELECT * FROM ver_chronoforms_data_clientpersonal_vic WHERE clientid = '[QUOTE_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data systable  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_systable = "
    SELECT * FROM ver_chronoforms_data_systable_vic WHERE cf_id  = '1';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve status data followup  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_status_data_followup = "
    SHOW TABLE STATUS LIKE 'ver_chronoforms_data_followup_vic';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data contract items  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_contract_items = "
    SELECT 
        dci.cf_id, 
        dci.framework_type, 
        dci.framework, 
        dci.inventoryid, 
        dci.description, 
        dci.webbing, 
        dci.colour, 
        dci.finish, 
        dci.uom, 
        dci.cost, 
        dci.qty, 
        dci.length_feet, 
        dci.length_inch, 
        dci.length_fraction, 
        dci.rrp, 
        dci.is_additional, 
        iv.section, 
        iv.category, 
        iv.photo 
    FROM ver_chronoforms_data_section_vic ds 
        LEFT JOIN ver_chronoforms_data_inventory_vic iv 
            ON ds.section = iv.section AND ds.category = iv.category 
        LEFT JOIN ver_chronoforms_data_contract_items_vic dci 
            ON iv.inventoryid = dci.inventoryid 
    WHERE dci.projectid = '[PROJECT_ID]' 
    ORDER BY ds.section_display_order, dci.quoteid, dci.projectid, dci.cf_id;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data contract item default dimensions  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_contract_items_default_deminsions = "
    SELECT * FROM ver_chronoforms_data_contract_items_default_deminsions;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data contract item dimensions  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_data_contract_item_dimensions = "
    SELECT * FROM ver_chronoforms_data_contract_items_deminsions 
    WHERE cf_id = '[CF_ID]' 
    AND projectid = '[PROJECT_ID]' 
    AND inventoryid = '[INVENTORY_ID]' 
    LIMIT 1;
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve last insert id  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_retrieve_last_insert_id = "
    SELECT LAST_INSERT_ID() AS 'last_insert_id';
";










/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- update data quote  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_update_data_quote = "
    UPDATE ver_chronoforms_data_quote_vic SET  
        project_name = '[PROJECT_NAME]',                    framework_type = '[VR_FRAMEWORK_TYPE]', 
        framework = '[VR_TYPE_DISPLAY_NAME]',               inventoryid = '[VR_ITEM_REF_NAME]', 
        description = '[VR_ITEM_DISPLAY_NAME]',             webbing = '[VR_ITEM_WEBBING]', 
        colour = '[VR_ITEM_COLOUR]',                        finish = '[VR_ITEM_FINISH]', 
        uom = '[VR_ITEM_UOM]',                              cost = '[VR_ITEM_UNIT_PRICE]', 
        qty = '[VR_ITEM_QTY]',                              length_feet = '[VR_ITEM_LENGTH_FEET]', 
        length_inch = '[VR_ITEM_LENGTH_INCH]',              length_fraction = '[VR_ITEM_LENGTH_FRACTION]', 
        rrp = '[VR_ITEM_RRP]',                              is_additional = '[VR_ITEM_ADHOC]', 
        customisation_options = '[CUSTOMISATION_OPTIONS]',  updated_at = NOW() 
    WHERE projectid = '[PROJECT_ID]' 
    AND cf_id = [VR_RECORD_INDEX];
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- update data followup  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_update_data_followup = "
    UPDATE ver_chronoforms_data_followup_vic SET  
        project_name = '[PROJECT_NAME]',                                framework_type = '[VR_FRAMEWORK_TYPE]', 
        default_color = '[VR_DEFAULT_COLOUR]',                          sales_comm = '[VR_COMMISSION_SALES_COMMISSION]', 
        sales_comm_cost = '[VR_COMMISSION_SALES_COMMISSION]',           com_pay1 = '[VR_COMMISSION_PAY1]', 
        com_pay2 = '[VR_COMMISSION_PAY2]',                              com_final = '[VR_COMMISSION_FINAL]', 
        install_comm = '[VR_COMMISSION_INSTALLER_PAYMENT]',             install_comm_cost = '[VR_COMMISSION_INSTALLER_PAYMENT]', 
        payment_deposit = '[VR_PAYMENT_DEPOSIT]',                       payment_progress = '[VR_PAYMENT_PROGRESS_PAYMENT]', 
        payment_final = '[VR_PAYMENT_FINAL_PAYMENT]',                   subtotal_vergola = '[VR_PAYMENT_VERGOLA]', 
        subtotal_disbursement = '[VR_PAYMENT_DISBURSEMENT_SUB_TOTAL]',  total_cost = '[VR_PAYMENT_SUB_TOTAL]', 
        total_gst = '[VR_PAYMENT_TAX]',                                 total_cost_gst = '[VR_PAYMENT_TAX]', 
        total_rrp_gst = '[VR_PAYMENT_TOTAL]',                           total_rrp ='[TOTAL_RRP]', 
        gst_percent = '[GST_PERCENT]',                                  comm_percent = '[COMM_PERCENT]', 
        customisation_options = '[CUSTOMISATION_OPTIONS]',              updated_at = NOW() 
    WHERE projectid = '[PROJECT_ID]' 
    AND cf_id = [VR_RECORD_INDEX];
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- update data measurement  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_update_data_measurement = "
    UPDATE ver_chronoforms_data_measurement_vic SET  
        framework_type = '[VR_FRAMEWORK_TYPE]',     width_feet = '[VR_WIDTH_FEET]', 
        width_inch = '[VR_WIDTH_INCH]',             length_feet = '[VR_LENGTH_FEET]', 
        length_inch = '[VR_LENGTH_INCH]',           updated_at = NOW() 
    WHERE projectid = '[PROJECT_ID]' 
    AND cf_id = [VR_RECORD_INDEX];
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- update data letters  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_update_data_letters = "
    UPDATE ver_chronoforms_data_letters_vic SET  
        template_content = '{[TEMPLATE_CONTENT]}',  dateupdated = NOW() 
    WHERE clientid = '[CLIENT_ID]' 
    AND template_name = '[TEMPLATE_NAME]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- update data contract items  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_update_data_contract_items = "
    UPDATE ver_chronoforms_data_contract_items_vic SET  
        project_name = '[PROJECT_NAME]',                    framework_type = '[VR_FRAMEWORK_TYPE]', 
        framework = '[VR_TYPE_DISPLAY_NAME]',               inventoryid = '[VR_ITEM_REF_NAME]', 
        description = '[VR_ITEM_DISPLAY_NAME]',             webbing = '[VR_ITEM_WEBBING]', 
        colour = '[VR_ITEM_COLOUR]',                        finish = '[VR_ITEM_FINISH]', 
        uom = '[VR_ITEM_UOM]',                              cost = '[VR_ITEM_UNIT_PRICE]', 
        qty = '[VR_ITEM_QTY]',                              length_feet = '[VR_ITEM_LENGTH_FEET]', 
        length_inch = '[VR_ITEM_LENGTH_INCH]',              length_fraction = '[VR_ITEM_LENGTH_FRACTION]', 
        rrp = '[VR_ITEM_RRP]',                              is_additional = '[VR_ITEM_ADHOC]', 
        customisation_options = '[CUSTOMISATION_OPTIONS]',  updated_at = NOW() 
    WHERE projectid = '[PROJECT_ID]' 
    AND cf_id = [VR_RECORD_INDEX];
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- update data contract item dimensions  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_update_data_contract_item_dimensions = "
    UPDATE ver_chronoforms_data_contract_items_deminsions SET  
        inventoryid = '[VR_ITEM_REF_NAME]', 
        length_feet = '[LENGTH_FEET]', length_inch = '[LENGTH_INCH]', 
        length_fraction = '[LENGTH_FRACTION]', dimension_a_inch = '[DIMENSION_A_INCH]', 
        dimension_a_fraction = '[DIMENSION_A_FRACTION]', dimension_b_inch = '[DIMENSION_B_INCH]', 
        dimension_b_fraction = '[DIMENSION_B_FRACTION]', dimension_c_inch = '[DIMENSION_C_INCH]', 
        dimension_c_fraction = '[DIMENSION_C_FRACTION]', dimension_d_inch = '[DIMENSION_D_INCH]', 
        dimension_d_fraction = '[DIMENSION_D_FRACTION]', dimension_e_inch = '[DIMENSION_E_INCH]', 
        dimension_e_fraction = '[DIMENSION_E_FRACTION]', dimension_f_inch = '[DIMENSION_F_INCH]', 
        dimension_f_fraction = '[DIMENSION_F_FRACTION]', dimension_g_inch = '[DIMENSION_G_INCH]', 
        dimension_g_fraction = '[DIMENSION_G_FRACTION]', dimension_h_inch = '[DIMENSION_H_INCH]',
        dimension_h_fraction = '[DIMENSION_H_FRACTION]', dimension_p_inch = '[DIMENSION_P_INCH]',
        dimension_p_fraction = '[DIMENSION_P_FRACTION]', girth_side_a_inch = '[GIRTH_SIDE_A_INCH]', 
        girth_side_a_fraction = '[GIRTH_SIDE_A_FRACTION]', girth_side_b_inch = '[GIRTH_SIDE_B_INCH]', 
        girth_side_b_fraction = '[GIRTH_SIDE_B_FRACTION]', 
        updated_at = NOW() 
    WHERE projectid = '[PROJECT_ID]' 
    AND id = [VR_RECORD_INDEX];
";










/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data quote  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_quote = "
    DELETE FROM ver_chronoforms_data_quote_vic 
    WHERE projectid = '[PROJECT_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data quote by record index  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_quote_by_record_index = "
    DELETE FROM ver_chronoforms_data_quote_vic 
    WHERE projectid = '[PROJECT_ID]' 
    AND cf_id = '[CF_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data followup  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_followup = "
    DELETE FROM ver_chronoforms_data_followup_vic 
    WHERE projectid = '[PROJECT_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data measurement  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_measurement = "
    DELETE FROM ver_chronoforms_data_measurement_vic 
    WHERE projectid = '[PROJECT_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data letters  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_letters = "
    DELETE FROM ver_chronoforms_data_letters_vic 
    WHERE clientid = '[CLIENT_ID]' 
    AND template_name = '[TEMPLATE_NAME]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data contract items by record index -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_contract_items_by_record_index = "
    DELETE FROM ver_chronoforms_data_contract_items_vic 
    WHERE projectid = '[PROJECT_ID]' 
    AND cf_id = '[CF_ID]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data contract bom meterial  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_contract_bom_meterial = "
    DELETE FROM ver_chronoforms_data_contract_bom_meterial_vic 
    WHERE projectid = '[PROJECT_ID]' 
    AND section = '[VR_SECTION_REF_NAME]';
";


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- delete data contract bom  -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql_template_delete_data_contract_bom = "
    DELETE FROM ver_chronoforms_data_contract_bom_vic 
    WHERE projectid = '[PROJECT_ID]' 
    AND inventory_section = '[VR_SECTION_REF_NAME]';
";
?>