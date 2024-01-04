        function showBomFormItemDimensionPopup(bom_form_item_data_entry_index, form_action) {
            var popup_display_time_in_seconds = 1000;
            var popup_display_timer;
            var info_field_name = '';
            var target_vr_section_ref_name = vr_form_items_data_entry[bom_form_item_data_entry_index]['vr_section_ref_name'].toLowerCase();
            var target_vr_item_data_entry_ref_name = document.getElementById('vr_item_data_entry_ref_name_' + bom_form_item_data_entry_index).value;
            var enable_fill_up_default_dimension = false;

            if (bom_form_item_dimension_current_popup_index > -1) {
                hideBomFormItemDimensionPopup();
            }
            bom_form_item_dimension_current_popup_index = bom_form_item_data_entry_index;

            document.getElementById('vr_item_data_entry_image_full_size_container_' + bom_form_item_data_entry_index).style.display = 'block';
            document.getElementById('vr_item_data_entry_image_full_size_area_' + bom_form_item_data_entry_index).innerHTML = document.getElementById('bom_form_item_dimension_data_entry_table_area').innerHTML;

            if (vr_form_items_data_entry[bom_form_item_data_entry_index]['vr_item_display_name_input_type'] == 'Select Box') {
                document.getElementById('item_dimension_title_form_bom').innerHTML = document.getElementById('vr_item_data_entry_ref_name_' + bom_form_item_data_entry_index).options[document.getElementById('vr_item_data_entry_ref_name_' + bom_form_item_data_entry_index).selectedIndex].text;
            } else {
                document.getElementById('item_dimension_title_form_bom').innerHTML = document.getElementById('vr_item_data_entry_display_name_' + bom_form_item_data_entry_index).value;
            }
            document.getElementById('item_image_form_bom').src = document.getElementById('vr_item_data_entry_image_' + bom_form_item_data_entry_index).src;

            if (vr_form_items_data_entry[bom_form_item_data_entry_index]['bom_form_item_dimensions_info']) {
                if (vr_form_items_data_entry[bom_form_item_data_entry_index]['bom_form_item_dimensions_info']['item_dimension_record_index'] == '' || 
                    vr_form_items_data_entry[bom_form_item_data_entry_index]['bom_form_item_dimensions_info']['item_dimension_record_index'] == '0') {
                    enable_fill_up_default_dimension = true;
                } else {
                    if (vr_form_items_data_entry[bom_form_item_data_entry_index]['vr_item_ref_name'] != target_vr_item_data_entry_ref_name) {
                        enable_fill_up_default_dimension = true;
                    }
                }
            } else {
                vr_form_items_data_entry[bom_form_item_data_entry_index]['bom_form_item_dimensions_info'] = {};
                for (info_field_name in bom_form_item_dimensions_info) {
                    vr_form_items_data_entry[bom_form_item_data_entry_index]['bom_form_item_dimensions_info'][info_field_name] = '';
                }
                enable_fill_up_default_dimension = true;
            }

            if (enable_fill_up_default_dimension == true) {
                for (info_field_name in bom_form_item_dimensions_info) {
                    if (info_field_name != 'item_dimension_record_index') {
                        vr_form_items_data_entry[bom_form_item_data_entry_index]['bom_form_item_dimensions_info'][info_field_name] = vr_item_default_dimensions_list[target_vr_item_data_entry_ref_name][info_field_name];
                    }
                }
            }

            for (info_field_name in bom_form_item_dimensions_info) {
                if (document.getElementById(info_field_name + '_form_bom')) {
                    document.getElementById(info_field_name + '_form_bom').value = vr_form_items_data_entry[bom_form_item_data_entry_index]['bom_form_item_dimensions_info'][info_field_name];
                }
            }

            if (form_action == 'edit') {
                document.getElementById('bom_form_item_dimension_button_area').style.display = 'block';
            } else {
                popup_display_timer = window.setTimeout(
                    function() {
                        hideBomFormItemDimensionPopup()
                    }, 
                    popup_display_time_in_seconds
                );
            }

            if (target_vr_section_ref_name.search('gutter') >= 0) {
                document.getElementById('item_dimension_girth_side_a_info_form_bom_area').style.display = 'block';
                document.getElementById('item_dimension_girth_side_b_info_form_bom_area').style.display = 'block';

                document.getElementById('item_dimension_girth_side_a_sum_method_form_bom_area').innerHTML = '(A+C+E+F+G+H+P)';
                document.getElementById('item_dimension_girth_side_b_sum_method_form_bom_area').innerHTML = '(B+D+E+F+G+H+P)';
            } else {
                if (target_vr_section_ref_name.search('flashing') >= 0) {
                    document.getElementById('item_dimension_girth_side_a_info_form_bom_area').style.display = 'block';
                    document.getElementById('item_dimension_girth_side_b_info_form_bom_area').style.display = 'block';

                    document.getElementById('item_dimension_girth_side_a_sum_method_form_bom_area').innerHTML = '(A+C+E+F+G+H+P)';
                    document.getElementById('item_dimension_girth_side_b_sum_method_form_bom_area').innerHTML = '(B+D+E+F+G+H+P)';
                }
            }

            calculateBomFormGirthValues();
        }


        function hideBomFormItemDimensionPopup() {
            document.getElementById('vr_item_data_entry_image_full_size_container_' + bom_form_item_dimension_current_popup_index).style.display = 'none';
            document.getElementById('vr_item_data_entry_image_full_size_area_' + bom_form_item_dimension_current_popup_index).innerHTML = '';
        }


        function copyBomFormDimensionInfoFormValue() {
            var info_field_name = '';
            var temp_text = '';

            for (info_field_name in bom_form_item_dimensions_info) {
                if (document.getElementById(info_field_name + '_form_bom')) {
                    vr_form_items_data_entry[bom_form_item_dimension_current_popup_index]['bom_form_item_dimensions_info'][info_field_name] = document.getElementById(info_field_name + '_form_bom').value;
                }
            }
        }


        function loadContractRelatedPage(page_ref_name) {
            switch (page_ref_name) {
                case 'contract_details':
                    window.location = vr_form_url_info['contract_details'] + '&uc=' + vr_form_url_info['unique_code'];
                    break;
                case 'quote_details':
                    window.location = vr_form_url_info['quote_details'] + '&uc=' + vr_form_url_info['unique_code'];
                    break;
                case 'bom':
                    window.location = vr_form_url_info['bom'] + '&uc=' + vr_form_url_info['unique_code'];
                    break;
                case 'po':
                    window.location = vr_form_url_info['po'] + '&uc=' + vr_form_url_info['unique_code'];
                    break;
                case 'po_summary':
                    window.location = vr_form_url_info['po_summary'] + '&uc=' + vr_form_url_info['unique_code'];
                    break;
                case 'check_list':
                    window.location = vr_form_url_info['check_list'] + '&uc=' + vr_form_url_info['unique_code'];
                    break;
            }
        }


        function initInputElementsFormBom() {
            var temp_select_box = '';
            var dimension_types = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'p'];

            temp_select_box = initHtmlSelectBox(
                vr_fractions_list, 
                'item_dimension_length_fraction_form_bom', 
                [], 
                [], 
                'ref_name', 
                'display_name', 
                '', 
                true
            );
            temp_select_box = replaceSubstringInText(
                ['class="vr_form_field_selectbox_2"'], 
                ['class="vr_form_field_selectbox_fraction_1"'], 
                temp_select_box
            );
            temp_select_box = replaceSubstringInText(
                ['-- select --'], 
                ['Fracs'], 
                temp_select_box
            );
            document.getElementById('item_dimension_length_fraction_form_bom_area').innerHTML = temp_select_box;

            for (c1 = 0; c1 < dimension_types.length; c1++) {
                temp_select_box = initHtmlSelectBox(
                    vr_fractions_list, 
                    'item_dimension_' + dimension_types[c1] + '_fraction_form_bom', 
                    [], 
                    [], 
                    'ref_name', 
                    'display_name', 
                    '', 
                    true
                );
                temp_select_box = replaceSubstringInText(
                    ['class="vr_form_field_selectbox_2"'], 
                    ['class="vr_form_field_selectbox_fraction_1"'], 
                    temp_select_box
                );
                temp_select_box = replaceSubstringInText(
                    ['onchange=""'], 
                    ['onchange="calculateBomFormGirthValues()"'], 
                    temp_select_box
                );
                temp_select_box = replaceSubstringInText(
                    ['-- select --'], 
                    ['Fracs'], 
                    temp_select_box
                );
                document.getElementById('item_dimension_' + dimension_types[c1] + '_fraction_form_bom_area').innerHTML = temp_select_box;
            }


            temp_select_box = initHtmlSelectBox(
                vr_fractions_list, 
                'item_dimension_girth_side_a_fraction_form_bom', 
                [], 
                [], 
                'ref_name', 
                'display_name', 
                '', 
                true
            );
            temp_select_box = replaceSubstringInText(
                ['class="vr_form_field_selectbox_2"'], 
                ['class="vr_form_field_selectbox_fraction_1"'], 
                temp_select_box
            );
            temp_select_box = replaceSubstringInText(
                ['-- select --'], 
                ['Fracs'], 
                temp_select_box
            );
            document.getElementById('item_dimension_girth_side_a_fraction_form_bom_area').innerHTML = temp_select_box;


            temp_select_box = initHtmlSelectBox(
                vr_fractions_list, 
                'item_dimension_girth_side_b_fraction_form_bom', 
                [], 
                [], 
                'ref_name', 
                'display_name', 
                '', 
                true
            );
            temp_select_box = replaceSubstringInText(
                ['class="vr_form_field_selectbox_2"'], 
                ['class="vr_form_field_selectbox_fraction_1"'], 
                temp_select_box
            );
            temp_select_box = replaceSubstringInText(
                ['-- select --'], 
                ['Fracs'], 
                temp_select_box
            );
            document.getElementById('item_dimension_girth_side_b_fraction_form_bom_area').innerHTML = temp_select_box;
        }
