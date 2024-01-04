<?php
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- initialise variables -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$enable_retrieve = array(
    'data_quote' => true, 
    'data_followup' => true, 
    'data_measurement' => true, 
    'data_contract_items' => true 
);

$vr_form_system_info = array();
$vr_form_queries_info = array();
$vr_form_billing_info = array();
$vr_form_items_data_entry = array();
$vr_type_ref_name = '';

$vr_type_reverse_map = array(
    'Single Bay VR0 - Drop-In' => 'VR0', 
    'Single Bay VR0' => 'VR0', 
    'Single Bay VR1 - Drop-In' => 'VR1', 
    'Single Bay VR1' => 'VR1', 
    'Double Bay VR2 - Drop-In' => 'VR2', 
    'Double Bay VR2' => 'VR2', 
    'Double Bay VR3 - Drop-In' => 'VR3', 
    'Double Bay VR3' => 'VR3', 
    'Double Bay VR3 - Thru-Gutter - Drop-In' => 'VR3G', 
    'Double Bay VR3 - Thru-Gutter' => 'VR3G', 
    'Triple Bay VR4 - Drop-In' => 'VR4', 
    'Triple Bay VR4' => 'VR4', 
    'Triple Bay VR5 - Drop-In' => 'VR5', 
    'Triple Bay VR5' => 'VR5', 
    'Quadruple Bay VR6 - Drop-In' => 'VR6', 
    'Quadruple Bay VR6' => 'VR6', 
    'Quadruple Bay VR7 - Drop-In' => 'VR7', 
    'Quadruple Bay VR7' => 'VR7', 
    'Double Bay VR8 - Gable - Drop-In' => 'VR8', 
    'Double Bay VR8 - Gable' => 'VR8', 
    'Double Bay VR9 - Gable - Drop-In' => 'VR9', 
    'Double Bay VR9 - Gable' => 'VR9'
);

$vr_section_map = array();
$results = executeDbQuery($sql_template_retrieve_section_list);
if ($results['error'] == 'null') {
    while ($r1 = mysql_fetch_array($results['data'])) {
        $vr_section_map[$r1['ref_name']] = $r1['display_name'];
    }
}

$enable_data_patching = true;


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data quote / data contract items -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$target_data_source = '';
$target_sql_template = '';
if (isset($api_data['access_mode'])) {
    switch ($api_data['access_mode']) {
        case 'quote_edit':
        case 'quote_view':
            $target_data_source = 'data_quote';
            $target_sql_template = $sql_template_retrieve_data_quote;
            break;
        case 'contract_bom_edit':
            $target_data_source = 'data_contract_items';
            $target_sql_template = $sql_template_retrieve_data_contract_items;
            break;
    }
}

$sql = '';
$results_retrieve_data[$target_data_source]['is_success'] = false;
$results_retrieve_data[$target_data_source]['total_record'] = 0;

if ($enable_retrieve[$target_data_source] == true) {
    $sql = str_replace(
        array('[PROJECT_ID]'), 
        array($api_data['project_id']), 
        $target_sql_template
    );

    $results = executeDbQuery($sql);

    $total_record_outdated = 0;
    $total_record_updated = 0;
    $failure_indexes = array();

    $current_vr_type_ref_name = '';
    $current_vr_item_ref_name = '';
    $current_vr_item_count = array();
    $current_vr_item_sequence = -1;

    if ($results['error'] == 'null') {
        $results_retrieve_data[$target_data_source]['is_success'] = true;

        while ($r1 = mysql_fetch_array($results['data'])) {
            $current_item_index = count($vr_form_items_data_entry);

            $vr_form_items_data_entry[$current_item_index]['vr_record_index'] = $r1['cf_id'];
            $vr_form_items_data_entry[$current_item_index]['vr_type_display_name'] = $r1['framework'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_ref_name'] = $r1['inventoryid'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_display_name'] = $r1['description'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_webbing'] = $r1['webbing'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_colour'] = $r1['colour'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_finish'] = $r1['finish'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_uom'] = $r1['uom'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_unit_price'] = $r1['cost'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_qty'] = $r1['qty'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_length_feet'] = $r1['length_feet'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_length_inch'] = $r1['length_inch'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_length_fraction'] = $r1['length_fraction'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_rrp'] = $r1['rrp'];
            $vr_form_items_data_entry[$current_item_index]['vr_item_adhoc'] = ($r1['is_additional'] == 1) ? 'yes' : '';

            $current_vr_type_ref_name = $vr_type_reverse_map[$r1['framework']];
            $current_vr_item_ref_name = $r1['inventoryid'];
            if (! isset($current_vr_item_count[$r1['inventoryid']])) {
                $current_vr_item_count[$r1['inventoryid']] = 1;
            } else {
                $current_vr_item_count[$r1['inventoryid']]++;
            }
            $current_vr_item_sequence = $current_vr_item_count[$r1['inventoryid']] - 1;

            $limit_condition = " LIMIT 1 ";
            if (isset($r1['is_additional']) && $r1['is_additional'] == 0) {
                $limit_condition = " LIMIT " . $current_vr_item_sequence . ", 1 ";
            }

            $vr_form_items_data_entry[$current_item_index]['vr_type_ref_name'] = $current_vr_type_ref_name;
            $vr_form_items_data_entry[$current_item_index]['vr_section_display_name'] = $vr_section_map[$r1['section']];
            $vr_form_items_data_entry[$current_item_index]['vr_section_ref_name'] = $r1['section'];
            $vr_form_items_data_entry[$current_item_index]['vr_subsection_display_name'] = $r1['category'];
            $vr_form_items_data_entry[$current_item_index]['vr_subsection_ref_name'] = $r1['category'];

            $current_vr_section_ref_name = $r1['section'];
            $current_vr_subsection_ref_name = $r1['category'];

            $sql = str_replace(
                array('[VR_TYPE_REF_NAME]', '[VR_ITEM_REF_NAME]', '[LIMIT_CONDITION]'), 
                array($current_vr_type_ref_name, $current_vr_item_ref_name, $limit_condition), 
                $sql_template_retrieve_vr_form_items_config_list_by_item_info
            );

            $results2 = executeDbQuery($sql);
            $item_config_found = false;
            if ($results2['error'] == 'null') {
                if ($results2['num_rows'] > 0) {
                    $item_config_found = true;
                }

                // if ($enable_data_patching == false) {
                    /*
                    while ($r2 = mysql_fetch_array($results2['data'])) {
                        $vr_type_ref_name = $r2['vr_type_ref_name'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_display_name_input_type'] = $r2['vr_item_display_name_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_webbing_input_type'] = $r2['vr_item_webbing_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_colour_input_type'] = $r2['vr_item_colour_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_finish_input_type'] = $r2['vr_item_finish_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_uom_input_type'] = $r2['vr_item_uom_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_unit_price_input_type'] = $r2['vr_item_unit_price_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_qty_input_type'] = $r2['vr_item_qty_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_length_feet_input_type'] = $r2['vr_item_length_feet_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_length_inch_input_type'] = $r2['vr_item_length_inch_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_length_fraction_input_type'] = $r2['vr_item_length_fraction_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_rrp_input_type'] = $r2['vr_item_rrp_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_image'] = $r2['vr_item_image'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_image_input_type'] = $r2['vr_item_image_input_type'];

                        $vr_item_config_internal_ref_name = "";
                        if (isset($r1['is_additional']) && strlen($r1['is_additional']) > 0) {
                            if ($r1['is_additional'] == 0) {
                                $vr_item_config_internal_ref_name = $r2['vr_item_config_internal_ref_name'];
                            }
                        }
                        $vr_form_items_data_entry[$current_item_index]['vr_item_config_internal_ref_name'] = $vr_item_config_internal_ref_name;
                    }
                    */
                // }
            }

            // if ($enable_data_patching == true) {
                if ($item_config_found == false) {
                    /*
                    $sql = str_replace(
                        array('[VR_TYPE_REF_NAME]', '[VR_SECTION_REF_NAME]', '[VR_SUBSECTION_REF_NAME]'), 
                        array($current_vr_type_ref_name, $current_vr_section_ref_name, $current_vr_subsection_ref_name), 
                        $sql_template_retrieve_vr_form_items_config_list_by_section_info
                    );
                    */
                    $sql = str_replace(
                        array('[VR_SECTION_REF_NAME]', '[VR_SUBSECTION_REF_NAME]'), 
                        array($current_vr_section_ref_name, $current_vr_subsection_ref_name), 
                        $sql_template_retrieve_vr_form_items_config_list_by_section_info
                    );

                    $results2 = executeDbQuery($sql);
                }

                if (isset($results2['error']) && $results2['error'] == 'null') {
                    while ($r2 = mysql_fetch_array($results2['data'])) {
                        $vr_type_ref_name = $r2['vr_type_ref_name'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_display_name_input_type'] = $r2['vr_item_display_name_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_webbing_input_type'] = $r2['vr_item_webbing_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_colour_input_type'] = $r2['vr_item_colour_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_finish_input_type'] = $r2['vr_item_finish_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_uom_input_type'] = $r2['vr_item_uom_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_unit_price_input_type'] = $r2['vr_item_unit_price_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_qty_input_type'] = $r2['vr_item_qty_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_length_feet_input_type'] = $r2['vr_item_length_feet_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_length_inch_input_type'] = $r2['vr_item_length_inch_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_length_fraction_input_type'] = $r2['vr_item_length_fraction_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_rrp_input_type'] = $r2['vr_item_rrp_input_type'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_image'] = $r1['photo'];
                        $vr_form_items_data_entry[$current_item_index]['vr_item_image_input_type'] = $r2['vr_item_image_input_type'];

                        $vr_item_config_internal_ref_name = "";
                        if (isset($r1['is_additional']) && $r1['is_additional'] == 0) {
                            $vr_item_config_internal_ref_name = $r2['vr_item_config_internal_ref_name'];
                        }
                        $vr_form_items_data_entry[$current_item_index]['vr_item_config_internal_ref_name'] = $vr_item_config_internal_ref_name;
                    }
                }
            // }

            if ($api_data['access_mode'] == 'contract_bom_edit') {
                $sql2 = str_replace(
                    array('[CF_ID]', '[PROJECT_ID]', '[INVENTORY_ID]'), 
                    array($r1['cf_id'], $api_data['project_id'], $r1['inventoryid']), 
                    $sql_template_retrieve_data_contract_item_dimensions
                );
                $results2 = executeDbQuery($sql2);
                if ($results2['error'] == 'null') {
                    while ($r2 = mysql_fetch_array($results2['data'])) {
                        $vr_form_items_data_entry[$current_item_index]['bom_form_item_dimensions_info'] = array(
                            'item_dimension_record_index' => $r2['id'], 
                            'item_dimension_length_feet' => $r2['length_feet'], 
                            'item_dimension_length_inch' => $r2['length_inch'], 
                            'item_dimension_length_fraction' => $r2['length_fraction'], 
                            'item_dimension_a_inch' => $r2['dimension_a_inch'], 
                            'item_dimension_a_fraction' => $r2['dimension_a_fraction'], 
                            'item_dimension_b_inch' => $r2['dimension_b_inch'], 
                            'item_dimension_b_fraction' => $r2['dimension_b_fraction'], 
                            'item_dimension_c_inch' => $r2['dimension_c_inch'], 
                            'item_dimension_c_fraction' => $r2['dimension_c_fraction'], 
                            'item_dimension_d_inch' => $r2['dimension_d_inch'], 
                            'item_dimension_d_fraction' => $r2['dimension_d_fraction'], 
                            'item_dimension_e_inch' => $r2['dimension_e_inch'], 
                            'item_dimension_e_fraction' => $r2['dimension_e_fraction'], 
                            'item_dimension_f_inch' => $r2['dimension_f_inch'], 
                            'item_dimension_f_fraction' => $r2['dimension_f_fraction'],
                            'item_dimension_g_inch' => $r2['dimension_g_inch'], 
                            'item_dimension_g_fraction' => $r2['dimension_g_fraction'],
                            'item_dimension_h_inch' => $r2['dimension_h_inch'], 
                            'item_dimension_h_fraction' => $r2['dimension_h_fraction'], 
                            'item_dimension_p_inch' => $r2['dimension_p_inch'], 
                            'item_dimension_p_fraction' => $r2['dimension_p_fraction'], 
                            'item_dimension_girth_side_a_inch' => $r2['girth_side_a_inch'], 
                            'item_dimension_girth_side_a_fraction' => $r2['girth_side_a_fraction'], 
                            'item_dimension_girth_side_b_inch' => $r2['girth_side_b_inch'], 
                            'item_dimension_girth_side_b_fraction' => $r2['girth_side_b_fraction']
                        );
                    }
                }
            }
        }
    }
}


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data followup -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql = '';
$results_retrieve_data['data_followup']['is_success'] = false;
$results_retrieve_data['data_followup']['total_record'] = 0;

if ($enable_retrieve['data_followup'] == true) {
    $sql = str_replace(
        array('[PROJECT_ID]'), 
        array($api_data['project_id']), 
        $sql_template_retrieve_data_followup
    );

    $results = executeDbQuery($sql);
    if ($results['error'] == 'null') {
        $results_retrieve_data['data_followup']['is_success'] = true;

        $r1 = mysql_fetch_array($results['data']);

        $vr_form_system_info['quote_id'] = $r1['quoteid'];
        $vr_form_system_info['quote_date'] = $r1['quotedate'];
        $vr_form_system_info['project_id'] = $r1['projectid'];
        $vr_form_system_info['sales_rep_id'] = $r1['rep_id'];
        $vr_form_system_info['sales_rep_name'] = $r1['sales_rep'];

        $vr_form_queries_info['vr_record_index'] = $r1['cf_id'];
        $vr_form_queries_info['vr_project_name'] = $r1['project_name'];
        $vr_form_queries_info['vr_framework_type'] = $r1['framework_type'];
        $vr_form_queries_info['vr_default_colour'] = $r1['default_color'];

        $vr_form_billing_info['vr_record_index'] = $r1['cf_id'];
        $vr_form_billing_info['vr_commission_sales_commission'] = $r1['sales_comm'];
        $vr_form_billing_info['vr_commission_pay1'] = $r1['com_pay1'];
        $vr_form_billing_info['vr_commission_pay2'] = $r1['com_pay2'];
        $vr_form_billing_info['vr_commission_final'] = $r1['com_final'];
        $vr_form_billing_info['vr_commission_installer_payment'] = ($r1['install_comm_cost'] > 0) ? $r1['install_comm_cost'] : $r1['install_comm'];
        $vr_form_billing_info['vr_payment_deposit'] = $r1['payment_deposit'];
        $vr_form_billing_info['vr_payment_progress_payment'] = $r1['payment_progress'];
        $vr_form_billing_info['vr_payment_final_payment'] = $r1['payment_final'];
        $vr_form_billing_info['vr_payment_vergola'] = $r1['subtotal_vergola'];
        $vr_form_billing_info['vr_payment_disbursement_sub_total'] = $r1['subtotal_disbursement'];
        $vr_form_billing_info['vr_payment_sub_total'] = $r1['total_cost'];
        $vr_form_billing_info['vr_payment_tax'] = $r1['total_cost_gst'];
        $vr_form_billing_info['vr_payment_total'] = $r1['total_rrp_gst'];
        $vr_form_billing_info['vr_payment_vr_items_rrp'] = $r1['total_rrp'];

        if ($vr_type_ref_name == 'VR8' || 
            $vr_type_ref_name == 'VR9') {
            $customisation_options = json_decode($r1['customisation_options'], true);
            $vr_form_queries_info['vr_run_feet'] = $customisation_options['vr_run_feet'];
            $vr_form_queries_info['vr_run_inch'] = $customisation_options['vr_run_inch'];
            $vr_form_queries_info['vr_rise_feet'] = $customisation_options['vr_rise_feet'];
            $vr_form_queries_info['vr_rise_inch'] = $customisation_options['vr_rise_inch'];
        }
    }
}


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- retrieve data measurement -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
$sql = '';
$results_retrieve_data['data_measurement']['is_success'] = false;
$results_retrieve_data['data_measurement']['total_record'] = 0;

if ($enable_retrieve['data_measurement'] == true) {
    $sql = str_replace(
        array('[PROJECT_ID]'), 
        array($api_data['project_id']), 
        $sql_template_retrieve_data_measurement
    );

    $results = executeDbQuery($sql);
    if ($results['error'] == 'null') {
        $results_retrieve_data['data_measurement']['is_success'] = true;

        $vr_form_queries_info['vr_length_info'] = array(
            'vr_record_indexes' => array(), 
            'vr_lengths_feet' => array(), 
            'vr_lengths_inch' => array()
        );
        $current_item_index = 0;
        while ($r1 = mysql_fetch_array($results['data'])) {
            $vr_form_queries_info['vr_length_info']['vr_record_indexes'][$current_item_index] = $r1['cf_id'];
            $vr_form_queries_info['vr_length_info']['vr_lengths_feet'][$current_item_index] = $r1['length_feet'];
            $vr_form_queries_info['vr_length_info']['vr_lengths_inch'][$current_item_index] = $r1['length_inch'];
            $vr_form_queries_info['vr_width_feet'] = $r1['width_feet'];
            $vr_form_queries_info['vr_width_inch'] = $r1['width_inch'];
            $current_item_index++;
        }
        $vr_form_queries_info['vr_number_of_bay'] = count($vr_form_queries_info['vr_length_info']['vr_record_indexes']);
    }
}


/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- process retrieve data results -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
if ($results_retrieve_data[$target_data_source]['is_success'] == true && 
    $results_retrieve_data['data_followup']['is_success'] == true) {
    $api_response['error'] = 'null';
} else {
    $api_response['error'] = '10020';
}

$api_response['message'] = array(
);

$api_response['data'] = array(
    'vr_form_system_info' => $vr_form_system_info, 
    'vr_form_queries_info' => $vr_form_queries_info, 
    'vr_form_billing_info' => $vr_form_billing_info, 
    'vr_form_items_data_entry' => $vr_form_items_data_entry
);
?>