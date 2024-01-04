        function getVrDimensionsLengthInfo() {
            var results = {
                "vr_lengths_in_value_for_calculation": [], 
                "vr_lengths_feet_in_value_for_display": [], 
                "vr_lengths_inch_in_value_for_display": [], 
                "total_vr_length_feet_in_value_for_display": '', 
                "total_vr_length_inch_in_value_for_display": ''
            };
            var c1 = 0;
            var vr_type_info = getVrTypeInfo();
            var number_of_bay = parseInt(vr_type_info['number_of_bay']);
            var current_vr_length_in_string = '';
            var current_vr_length_in_value_for_calculation = 0.0;
            var total_vr_length_in_value_for_calculation = 0.0;
            var vr_lengths_in_value_for_calculation = [];
            var total_vr_length_in_value_for_display = '';
            var vr_lengths_in_value_for_display = [];
            var vr_lengths_feet_in_value_for_display = [];
            var vr_lengths_inch_in_value_for_display = [];
            var total_vr_length_feet_in_value_for_display = '';
            var total_vr_length_inch_in_value_for_display = '';
            var temp_array = [];
            var temp_float = 0.0;

            for (c1 = 0; c1 < number_of_bay; c1++) {
                current_vr_length_in_string = document.getElementById('vr_length_feet_form_query_' + c1).value + '\'' + document.getElementById('vr_length_inch_form_query_' + c1).value;
                current_vr_length_in_value_for_calculation = convertValueForCalculation(current_vr_length_in_string);
                total_vr_length_in_value_for_calculation += current_vr_length_in_value_for_calculation;
                vr_lengths_in_value_for_calculation[vr_lengths_in_value_for_calculation.length] = current_vr_length_in_value_for_calculation;
                vr_lengths_in_value_for_display[vr_lengths_in_value_for_display.length] = revertValueForCalculation(current_vr_length_in_value_for_calculation);

                temp_array = vr_lengths_in_value_for_display[vr_lengths_in_value_for_display.length - 1].split('\'');
                vr_lengths_feet_in_value_for_display[vr_lengths_feet_in_value_for_display.length] = temp_array[0];
                vr_lengths_inch_in_value_for_display[vr_lengths_inch_in_value_for_display.length] = temp_array[1];
            }
            total_vr_length_in_value_for_display = revertValueForCalculation(total_vr_length_in_value_for_calculation);
            temp_array = total_vr_length_in_value_for_display.split('\'');
            temp_float = parseFloat(temp_array[0]);
            total_vr_length_feet_in_value_for_display = temp_float.toFixed(2);
            temp_float = parseFloat(temp_array[1]);
            total_vr_length_inch_in_value_for_display = temp_float.toFixed(2);

            results = {
                "vr_lengths_in_value_for_calculation": vr_lengths_in_value_for_calculation, 
                "vr_lengths_feet_in_value_for_display": vr_lengths_feet_in_value_for_display, 
                "vr_lengths_inch_in_value_for_display": vr_lengths_inch_in_value_for_display, 
                "total_vr_length_feet_in_value_for_display": total_vr_length_feet_in_value_for_display, 
                "total_vr_length_inch_in_value_for_display": total_vr_length_inch_in_value_for_display
            };

            return results;
        }


        function getVrDimensionsWidthInfo() {
            var results = {
                "vr_width_in_value_for_calculation": '', 
                "vr_width_feet_in_value_for_display": '', 
                "vr_width_inch_in_value_for_display": ''
            };
            var vr_width_in_string = '';
            var vr_width_in_value_for_calculation = 0.0;
            var vr_width_in_value_for_display = '';
            var vr_width_feet_in_string = '';
            var vr_width_feet_in_value_for_display = '';
            var vr_width_inch_in_string = '';
            var vr_width_inch_in_value_for_display = '';
            var temp_array = [];
            var temp_float = 0.0;            
            if (document.getElementById('vr_width_feet_form_query')) {
                if (document.getElementById('vr_width_feet_form_query').value.length == 0 || 
                    isNaN(document.getElementById('vr_width_feet_form_query').value)) {
                    vr_width_feet_in_string = '0';
                }else{
                    vr_width_feet_in_string = document.getElementById('vr_width_feet_form_query').value;
                }
            }
            if (document.getElementById('vr_width_inch_form_query')) {
                if (document.getElementById('vr_width_inch_form_query').value.length == 0 || 
                    isNaN(document.getElementById('vr_width_inch_form_query').value)) {
                    vr_width_inch_in_string = '0';
                }else{
                    vr_width_inch_in_string = document.getElementById('vr_width_inch_form_query').value;
                }
            }
            // vr_width_feet_in_string = document.getElementById('vr_width_feet_form_query').value;
            // vr_width_inch_in_string = document.getElementById('vr_width_inch_form_query').value;
            vr_width_in_string = vr_width_feet_in_string + '\'' + vr_width_inch_in_string;
            vr_width_in_value_for_calculation = convertValueForCalculation(vr_width_in_string);
            vr_width_in_value_for_display = revertValueForCalculation(vr_width_in_value_for_calculation);

            temp_array = vr_width_in_value_for_display.split('\'');
            vr_width_feet_in_value_for_display = temp_array[0];
            vr_width_inch_in_value_for_display = temp_array[1];

            results = {
                "vr_width_in_value_for_calculation": vr_width_in_value_for_calculation, 
                "vr_width_feet_in_value_for_display": vr_width_feet_in_value_for_display, 
                "vr_width_inch_in_value_for_display": vr_width_inch_in_value_for_display
            };

            return results;
        }


        function getVrFormItemInfoByAdhocCriteria(vr_form_items_source, adhoc_criteria) {
            var c1 = 0;
            var c2 = 0;
            var c3 = 0;
            var i1;
            var vr_form_item_info = [];
            var total_adhoc_criteria_found = 0;
            var current_adhoc_criteria_field_name1 = '';
            var current_adhoc_criteria_field_value1 = '';
            var current_vr_form_item_source_field_value1 = '';
            var current_adhoc_criteria_field_name2 = '';
            var current_adhoc_criteria_field_value2 = '';
            var current_vr_form_item_source_field_value2 = '';
            var temp_text1 = '';
            var temp_text2 = '';
            var temp_text3 = '';
            var ignore_field_found = false;

            for (c1 = 0; c1 < vr_form_items_source.length; c1++) {
                total_adhoc_criteria_found = 0;
                for (c2 = 0; c2 < adhoc_criteria['search_info'].length; c2++) {
                    current_adhoc_criteria_field_name1 = adhoc_criteria['search_info'][c2]['field_name'];
                    current_adhoc_criteria_field_value1 = adhoc_criteria['search_info'][c2]['field_value'];
                    current_vr_form_item_source_field_value1 = vr_form_items_source[c1][current_adhoc_criteria_field_name1];
                    if (current_vr_form_item_source_field_value1.toLowerCase() == current_adhoc_criteria_field_value1.toLowerCase()) {
                        ignore_field_found = false;
                        for (c3 = 0; c3 < adhoc_criteria['search_ignore_info'].length; c3++) {
                            current_adhoc_criteria_field_name2 = adhoc_criteria['search_ignore_info'][c3]['field_name'];
                            current_adhoc_criteria_field_value2 = adhoc_criteria['search_ignore_info'][c3]['field_value'];
                            current_vr_form_item_source_field_value2 = vr_form_items_source[c1][current_adhoc_criteria_field_name2];
                            if (current_vr_form_item_source_field_value2.toLowerCase() == current_adhoc_criteria_field_value2.toLowerCase()) {
                                ignore_field_found = true;
                            }
                        }
                        if (ignore_field_found == false) {
                            total_adhoc_criteria_found++;
                        }
                    }
                }
                if (total_adhoc_criteria_found == adhoc_criteria['search_info'].length) {
                    temp_text1 = '';
                    for (c2 = 0; c2 < adhoc_criteria['retrieve_info'].length; c2++) {
                        current_adhoc_criteria_field_name1 = adhoc_criteria['retrieve_info'][c2]['field_name'];
                        temp_text1 += '"' + current_adhoc_criteria_field_name1 + '":"' + vr_form_items_source[c1][current_adhoc_criteria_field_name1] + '", ';
                    }
                    temp_text2 = '"row_index":' + c1;
                    temp_text3 = '{' + temp_text1.substring(0, temp_text1.length - 2) + ', ' + temp_text2 + '}';
                    vr_form_item_info[vr_form_item_info.length] = eval('(' + temp_text3 + ')');
                }
            }

            return vr_form_item_info;
        }


        function assignVrDimensionsToVrFormBeamRows() {
            var temp_array = [];
            var vr_lengths_in_value_for_calculation = [];
            var vr_lengths_feet_in_value_for_display = [];
            var vr_lengths_inch_in_value_for_display = [];
            var total_vr_length_feet_in_value_for_display = '';
            var total_vr_length_inch_in_value_for_display = '';
            var vr_width_in_value_for_calculation = '';
            var vr_width_feet_in_value_for_display = '';
            var vr_width_inch_in_value_for_display = '';

            temp_array = getVrDimensionsLengthInfo();
            vr_lengths_in_value_for_calculation = temp_array['vr_lengths_in_value_for_calculation'];
            vr_lengths_feet_in_value_for_display = temp_array['vr_lengths_feet_in_value_for_display'];
            vr_lengths_inch_in_value_for_display = temp_array['vr_lengths_inch_in_value_for_display'];
            total_vr_length_feet_in_value_for_display = temp_array['total_vr_length_feet_in_value_for_display'];
            total_vr_length_inch_in_value_for_display = temp_array['total_vr_length_inch_in_value_for_display'];

            temp_array = getVrDimensionsWidthInfo();
            vr_width_in_value_for_calculation = temp_array['vr_width_in_value_for_calculation'];
            vr_width_feet_in_value_for_display = temp_array['vr_width_feet_in_value_for_display'];
            vr_width_inch_in_value_for_display = temp_array['vr_width_inch_in_value_for_display'];

            setVrFormItemDataEntryRowValuesByInternalRefName(
                'beam_front_and_rear', 
                [
                    {"form_item_name":"vr_item_data_entry_length_feet", "variable_name":"vr_item_length_feet", "col_value":total_vr_length_feet_in_value_for_display}, 
                    {"form_item_name":"vr_item_data_entry_length_inch", "variable_name":"vr_item_length_inch", "col_value":total_vr_length_inch_in_value_for_display}
                ]
            );

            setVrFormItemDataEntryRowValuesByInternalRefName(
                'beam_left_and_right', 
                [
                    {"form_item_name":"vr_item_data_entry_length_feet", "variable_name":"vr_item_length_feet", "col_value":vr_width_feet_in_value_for_display}, 
                    {"form_item_name":"vr_item_data_entry_length_inch", "variable_name":"vr_item_length_inch", "col_value":vr_width_inch_in_value_for_display}
                ]
            );

            setVrFormItemDataEntryRowValuesByInternalRefName(
                'beam_intermediate', 
                [
                    {"form_item_name":"vr_item_data_entry_length_feet", "variable_name":"vr_item_length_feet", "col_value":vr_width_feet_in_value_for_display}, 
                    {"form_item_name":"vr_item_data_entry_length_inch", "variable_name":"vr_item_length_inch", "col_value":vr_width_inch_in_value_for_display}
                ]
            );

            setVrFormItemDataEntryRowValuesByInternalRefName(
                'beam_front_and_rear_bay_1', 
                [
                    {"form_item_name":"vr_item_data_entry_length_feet", "variable_name":"vr_item_length_feet", "col_value":vr_lengths_feet_in_value_for_display[0]},
                    {"form_item_name":"vr_item_data_entry_length_inch", "variable_name":"vr_item_length_inch", "col_value":vr_lengths_inch_in_value_for_display[0]}
                ]
            );

            setVrFormItemDataEntryRowValuesByInternalRefName(
                'beam_front_and_rear_bay_2', 
                [
                    {"form_item_name":"vr_item_data_entry_length_feet", "variable_name":"vr_item_length_feet", "col_value":vr_lengths_feet_in_value_for_display[1]},
                    {"form_item_name":"vr_item_data_entry_length_inch", "variable_name":"vr_item_length_inch", "col_value":vr_lengths_inch_in_value_for_display[1]}
                ]
            );
        }


        function calculateTotalGutterLining() {
            var adhoc_criteria1 = {};
            var vr_form_item_info1 = [];
            var adhoc_criteria2 = {};
            var vr_form_item_info2 = [];
            var c1 = 0;
            var current_vr_length_in_string = '';
            var current_vr_length_in_value_for_calculation = 0.0;
            var total_vr_length_in_value_for_calculation = 0.0;
            var total_vr_length_in_value_for_display = '';
            var temp_array = [];
            var total_gutter_lining_length_feet = '';
            var total_gutter_lining_length_inch = '';

            adhoc_criteria1 = {
                "search_info": [
                   {"field_name": "vr_section_ref_name", "field_value": "Guttering"}
                ], 
                "search_ignore_info": [
                   {"field_name": "vr_item_config_internal_ref_name", "field_value": "gutter_lining"}
                ], 
                "retrieve_info": [
                   {"field_name": "vr_item_qty"}, 
                   {"field_name": "vr_item_length_feet"}, 
                   {"field_name": "vr_item_length_inch"}, 
                   {"field_name": "vr_item_rrp"}
                ]
            };
            vr_form_item_info1 = getVrFormItemInfoByAdhocCriteria(vr_form_items_data_entry, adhoc_criteria1);

            for (c1 = 0; c1 < vr_form_item_info1.length; c1++) {
                current_vr_length_in_string = vr_form_item_info1[c1]['vr_item_length_feet'] + '\'' + vr_form_item_info1[c1]['vr_item_length_inch'];
                current_vr_length_in_value_for_calculation = convertValueForCalculation(current_vr_length_in_string);
                total_vr_length_in_value_for_calculation += parseFloat(vr_form_item_info1[c1]['vr_item_qty']) * current_vr_length_in_value_for_calculation;
            }
            total_vr_length_in_value_for_display = revertValueForCalculation(total_vr_length_in_value_for_calculation);
            temp_array = total_vr_length_in_value_for_display.split('\'');
            total_gutter_lining_length_feet = temp_array[0];
            total_gutter_lining_length_inch = temp_array[1];
            total_gutter_lining_length_feet = formatOutputValue('float', total_gutter_lining_length_feet);
            total_gutter_lining_length_inch = formatOutputValue('float', total_gutter_lining_length_inch);

            // setVrFormItemDataEntryRowValuesByInternalRefName(
            //     'gutter_lining', 
            //     [
            //         {"form_item_name":"vr_item_data_entry_length_feet", "variable_name":"vr_item_length_feet", "col_value":total_gutter_lining_length_feet}, 
            //         {"form_item_name":"vr_item_data_entry_length_inch", "variable_name":"vr_item_length_inch", "col_value":total_gutter_lining_length_inch}
            //     ]
            // );

            if (vr_form_system_info['access_mode'] != 'contract_bom_edit') {
                adhoc_criteria2 = {
                    "search_info": [
                       {"field_name": "vr_item_ref_name", "field_value": "IRV31"}
                    ], 
                    "search_ignore_info": [
                    ], 
                    "retrieve_info": [
                       {"field_name": "vr_item_qty"}, 
                       {"field_name": "vr_item_length_feet"}, 
                       {"field_name": "vr_item_length_inch"}, 
                       {"field_name": "vr_item_rrp"}
                    ]
                };
                vr_form_item_info2 = getVrFormItemInfoByAdhocCriteria(vr_form_items_data_entry, adhoc_criteria2);
                if (vr_form_item_info2.length > 0) {
                    setVrFormItemDataEntryRowValuesByRowIndex(
                        vr_form_item_info2[0]['row_index'], 
                        [
                            {"form_item_name":"vr_item_data_entry_length_feet", "variable_name":"vr_item_length_feet", "col_value":total_gutter_lining_length_feet}, 
                            {"form_item_name":"vr_item_data_entry_length_inch", "variable_name":"vr_item_length_inch", "col_value":total_gutter_lining_length_inch}
                        ]
                    );
                }
            }
        }


        function calculateLouvreRelatedInfo() {
            var adhoc_criteria1 = {};
            var vr_form_item_info1 = [];
            var c1 = 0;
            var minimum_inch_per_louvre = 7.87402;
            var total_louvre = 0;
            var total_endcap = 0;
            var grand_total_endcap = 0;
            var total_pivot_strip = 0;
            var total_link_bar = 0;

            adhoc_criteria1 = {
                "search_info": [
                   {"field_name": "vr_section_ref_name", "field_value": "Vergola"}, 
                   {"field_name": "vr_subsection_ref_name", "field_value": "Louvers"}
                ], 
                "search_ignore_info": [
                ], 
                "retrieve_info": [
                   {"field_name": "vr_item_qty"}, 
                   {"field_name": "vr_item_length_feet"}, 
                   {"field_name": "vr_item_length_inch"}, 
                   {"field_name": "vr_item_rrp"}
                ]
            };
            vr_form_item_info1 = getVrFormItemInfoByAdhocCriteria(vr_form_items_data_entry, adhoc_criteria1);

            adhoc_criteria2 = {
                "search_info": [
                   {"field_name": "vr_section_ref_name", "field_value": "Vergola"}, 
                   {"field_name": "vr_subsection_ref_name", "field_value": "Accessories"}, 
                   {"field_name": "vr_item_ref_name", "field_value": "IRV59"}, 
                   {"field_name": "vr_item_display_name", "field_value": "Pivot strip"} 
                ], 
                "search_ignore_info": [
                ], 
                "retrieve_info": [
                   {"field_name": "vr_item_qty"}, 
                   {"field_name": "vr_item_length_feet"}, 
                   {"field_name": "vr_item_length_inch"}, 
                   {"field_name": "vr_item_rrp"}
                ]
            };
            vr_form_item_info2 = getVrFormItemInfoByAdhocCriteria(vr_form_items_data_entry, adhoc_criteria2);

            adhoc_criteria3 = {
                "search_info": [
                   {"field_name": "vr_section_ref_name", "field_value": "Vergola"}, 
                   {"field_name": "vr_subsection_ref_name", "field_value": "Accessories"}, 
                   {"field_name": "vr_item_ref_name", "field_value": "IRV60"}, 
                   {"field_name": "vr_item_display_name", "field_value": "Link Bar"} 
                ], 
                "search_ignore_info": [
                ], 
                "retrieve_info": [
                   {"field_name": "vr_item_qty"}, 
                   {"field_name": "vr_item_length_feet"}, 
                   {"field_name": "vr_item_length_inch"}, 
                   {"field_name": "vr_item_rrp"}
                ]
            };
            vr_form_item_info3 = getVrFormItemInfoByAdhocCriteria(vr_form_items_data_entry, adhoc_criteria3);

            adhoc_criteria4 = {
                "search_info": [
                   {"field_name": "vr_section_ref_name", "field_value": "Vergola"}, 
                   {"field_name": "vr_subsection_ref_name", "field_value": "Accessories"}, 
                   {"field_name": "vr_item_ref_name", "field_value": "IRV58"}, 
                   {"field_name": "vr_item_display_name", "field_value": "Endcap"} 
                ], 
                "search_ignore_info": [
                ], 
                "retrieve_info": [
                   {"field_name": "vr_item_qty"}, 
                   {"field_name": "vr_item_length_feet"}, 
                   {"field_name": "vr_item_length_inch"}, 
                   {"field_name": "vr_item_rrp"}
                ]
            };
            vr_form_item_info4 = getVrFormItemInfoByAdhocCriteria(vr_form_items_data_entry, adhoc_criteria4);

            for (c1 = 0; c1 < vr_form_item_info1.length; c1++) {
                total_louvre = vr_form_item_info1[c1]['vr_item_qty'];
                total_endcap = total_louvre * 2;
                grand_total_endcap += total_endcap;
                total_pivot_strip = Math.ceil(total_endcap / 12);
                total_link_bar = Math.ceil(total_louvre / 12);

                if (vr_form_system_info['access_mode'] == 'quote_add' || 
                    vr_form_system_info['access_mode'] == 'quote_edit') {
                    setVrFormItemDataEntryRowValuesByRowIndex(
                        vr_form_item_info2[c1]['row_index'], 
                        [{"form_item_name":"vr_item_data_entry_qty", "variable_name":"vr_item_qty", "col_value":total_pivot_strip}]
                    );

                    setVrFormItemDataEntryRowValuesByRowIndex(
                        vr_form_item_info3[c1]['row_index'], 
                        [{"form_item_name":"vr_item_data_entry_qty", "variable_name":"vr_item_qty", "col_value":total_link_bar}]
                    );
                }
            }

            setVrFormItemDataEntryRowValuesByRowIndex(
                vr_form_item_info4[0]['row_index'], 
                [{"form_item_name":"vr_item_data_entry_qty", "variable_name":"vr_item_qty", "col_value":grand_total_endcap}]
            );
        }
