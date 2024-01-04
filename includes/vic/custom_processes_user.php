<?php
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
/* ===== begin custom configs user ===== */
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
$custom_configs_user = array(
    'user_groups' => array(
        '10' => 'System Admin', /* Victoria Admin */
        '29' => 'Accounts', /* Victoria Account User */
        '26' => 'Operation Manager', /* Victoria Operation Manager */
        '30' => 'Site Manager', /* Victoria Site Manager */
        '28' => 'Reception', /* Victoria Reception User */
        '27' => 'Sales Manager', /* Victoria Sales Manager */
        '9' => 'Sales Consultant', /* Victoria Users */
    ), 
    'user_access_profiles' => array(
        /* ===== ===== ===== ===== ===== */
        /* begin Victoria Admin */
        /* ===== ===== ===== ===== ===== */
        '10' => array(
            'client-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'builder-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'tender-folder-vic' => array(
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab enquiry tracker' => array('send mail' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'add-quote-vic' => array(
                'record action' => array('save' => true, 'save and close' => true)
            ), 
            'add-quote-vic > quote_edit' => array(
                'record action' => array('remove' => true, 'save' => true, 'save and close' => true, 'delete' => true, 'download pdf' => true, 'duplicate' => true, 'add vr items' => true)
            ), 
            'contract-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab bill of materials' => array('show' => true), 
                'tab purchase order' => array('show' => true), 
                'tab po summary' => array('show' => true), 
                'tab check list' => array('show' => true), 
                'tab vergola accounts' => array('edit' => true), 
                'tab vergola standard' => array('edit' => true), 
                'tab statutory approval' => array('edit' => true),
                'tab contract cancellation' => array('edit' => true), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('update' => true, 'cancel contract' => true)
            ), 
            'add-quote-vic > contract_bom' => array(
                'button bill of materials' => array('show' => true), 
                'button purchase order' => array('show' => true), 
                'button po summary' => array('show' => true), 
                'button check list' => array('show' => true), 
                'record action' => array('remove' => true, 'save' => true, 'process order' => true, 'cancel order' => true, 'add vr items' => true)
            ), 
            'contract-po-vic' => array(
                'record action' => array('cancel po' => true, 'save and process po' => true)
            )
        ), 
        /* end Victoria Admin */


        /* ===== ===== ===== ===== ===== */
        /* begin Victoria Account User */
        /* ===== ===== ===== ===== ===== */
        '29' => array(
            'client-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab costing info' => array('add new costing' => false, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => false, 'delete' => false)
            ), 
            'builder-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab costing info' => array('add new costing' => false, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('save' => false, 'delete' => false)
            ), 
            'tender-folder-vic' => array(
                'tab costing info' => array('add new costing' => false, 'view costing' => true, 'view contract' => true), 
                'tab enquiry tracker' => array('send mail' => false), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('save' => false, 'delete' => false)
            ), 
            'add-quote-vic' => array(
                'record action' => array('save' => false, 'save and close' => false)
            ), 
            'add-quote-vic > quote_edit' => array(
                'record action' => array('remove' => false, 'save' => false, 'save and close' => false, 'delete' => false, 'download pdf' => false, 'duplicate' => false, 'add vr items' => false)
            ), 
            'contract-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab bill of materials' => array('show' => true), 
                'tab purchase order' => array('show' => true), 
                'tab po summary' => array('show' => true), 
                'tab check list' => array('show' => true), 
                'tab vergola accounts' => array('edit' => true), 
                'tab vergola standard' => array('edit' => true), 
                'tab statutory approval' => array('edit' => true),
                'tab contract cancellation' => array('edit' => true), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('update' => true, 'cancel contract' => true)
            ), 
            'add-quote-vic > contract_bom' => array(
                'button bill of materials' => array('show' => true), 
                'button purchase order' => array('show' => true), 
                'button po summary' => array('show' => true), 
                'button check list' => array('show' => true), 
                'record action' => array('remove' => true, 'save' => true, 'process order' => true, 'cancel order' => true, 'add vr items' => true)
            ), 
            'contract-po-vic' => array(
                'record action' => array('cancel po' => true, 'save and process po' => true)
            )
        ), 
        /* end Victoria Account User */


        /* ===== ===== ===== ===== ===== */
        /* begin Victoria Operation Manager */
        /* ===== ===== ===== ===== ===== */
        '26' => array(
            'client-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => false, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'builder-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab costing info' => array('add new costing' => false, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('save' => false, 'delete' => false)
            ), 
            'tender-folder-vic' => array(
                'tab costing info' => array('add new costing' => false, 'view costing' => true, 'view contract' => true), 
                'tab enquiry tracker' => array('send mail' => false), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('save' => false, 'delete' => false)
            ), 
            'add-quote-vic' => array(
                'record action' => array('save' => false, 'save and close' => false)
            ), 
            'add-quote-vic > quote_edit' => array(
                'record action' => array('remove' => false, 'save' => false, 'save and close' => false, 'delete' => false, 'download pdf' => false, 'duplicate' => false, 'add vr items' => false)
            ), 
            'contract-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab bill of materials' => array('show' => true), 
                'tab purchase order' => array('show' => true), 
                'tab po summary' => array('show' => true), 
                'tab check list' => array('show' => true), 
                'tab vergola accounts' => array('edit' => true), 
                'tab vergola standard' => array('edit' => true), 
                'tab statutory approval' => array('edit' => true),
                'tab contract cancellation' => array('edit' => true), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('update' => true, 'cancel contract' => true)
            ), 
            'add-quote-vic > contract_bom' => array(
                'button bill of materials' => array('show' => true), 
                'button purchase order' => array('show' => true), 
                'button po summary' => array('show' => true), 
                'button check list' => array('show' => true), 
                'record action' => array('remove' => true, 'save' => true, 'process order' => true, 'cancel order' => true, 'add vr items' => true)
            ), 
            'contract-po-vic' => array(
                'record action' => array('cancel po' => true, 'save and process po' => true)
            )
        ), 
        /* end Victoria Operation Manager */


        /* ===== ===== ===== ===== ===== */
        /* begin Victoria Site Manager */
        /* ===== ===== ===== ===== ===== */
        '30' => array(
            'client-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab costing info' => array('add new costing' => false, 'view costing' => false, 'view contract' => false), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => false
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'builder-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab costing info' => array('add new costing' => false, 'view costing' => false, 'view contract' => false), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => false
                ), 
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('save' => false, 'delete' => false)
            ), 
            'tender-folder-vic' => array(
                'tab costing info' => array('add new costing' => false, 'view costing' => false, 'view contract' => false), 
                'tab enquiry tracker' => array('send mail' => false), 
                'tab follow up' => array(
                    'not interested' => false, 'costed' => false, 'quoted' => false, 'under consideration' => false, 
                    'future project' => false, 'won' => false, 'lost' => false, 
                    'project status' => false, 
                    'create contract' => false
                ), 
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('save' => false, 'delete' => false)
            ), 
            'add-quote-vic' => array(
                'record action' => array('save' => false, 'save and close' => false)
            ), 
            'add-quote-vic > quote_edit' => array(
                'record action' => array('remove' => false, 'save' => false, 'save and close' => false, 'delete' => false, 'download pdf' => false, 'duplicate' => false, 'add vr items' => false)
            ), 
            'contract-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab bill of materials' => array('show' => true), 
                'tab purchase order' => array('show' => true), 
                'tab po summary' => array('show' => true), 
                'tab check list' => array('show' => true), 
                'tab vergola accounts' => array('edit' => true), 
                'tab vergola standard' => array('edit' => true), 
                'tab statutory approval' => array('edit' => true),
                'tab contract cancellation' => array('edit' => true), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('update' => true, 'cancel contract' => false)
            ), 
            'add-quote-vic > contract_bom' => array(
                'button bill of materials' => array('show' => true), 
                'button purchase order' => array('show' => true), 
                'button po summary' => array('show' => true), 
                'button check list' => array('show' => true), 
                'record action' => array('remove' => false, 'save' => false, 'process order' => false, 'cancel order' => false, 'add vr items' => false)
            ), 
            'contract-po-vic' => array(
                'record action' => array('cancel po' => false, 'save and process po' => false)
            )
        ), 
        /* end Victoria Site Manager */


        /* ===== ===== ===== ===== ===== */
        /* begin Victoria Reception User */
        /* ===== ===== ===== ===== ===== */
        '28' => array(
            'client-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'builder-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'tender-folder-vic' => array(
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab enquiry tracker' => array('send mail' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'add-quote-vic' => array(
                'record action' => array('save' => true, 'save and close' => true)
            ), 
            'add-quote-vic > quote_edit' => array(
                'record action' => array('remove' => true, 'save' => true, 'save and close' => true, 'delete' => true, 'download pdf' => true, 'duplicate' => true, 'add vr items' => true)
            ), 
            'contract-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab bill of materials' => array('show' => true), 
                'tab purchase order' => array('show' => true), 
                'tab po summary' => array('show' => true), 
                'tab check list' => array('show' => true), 
                'tab vergola accounts' => array('edit' => true), 
                'tab vergola standard' => array('edit' => true), 
                'tab statutory approval' => array('edit' => false),
                'tab contract cancellation' => array('edit' => false),
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('update' => true, 'cancel contract' => false)
            ), 
            'add-quote-vic > contract_bom' => array(
                'button bill of materials' => array('show' => true), 
                'button purchase order' => array('show' => true), 
                'button po summary' => array('show' => true), 
                'button check list' => array('show' => true), 
                'record action' => array('remove' => false, 'save' => false, 'process order' => false, 'cancel order' => false, 'add vr items' => false)
            ), 
            'contract-po-vic' => array(
                'record action' => array('cancel po' => false, 'save and process po' => false)
            )
        ), 
        /* end Victoria Reception User */


        /* ===== ===== ===== ===== ===== */
        /* begin Victoria Sales Manager */
        /* ===== ===== ===== ===== ===== */
        '27' => array(
            'client-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'builder-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'tender-folder-vic' => array(
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab enquiry tracker' => array('send mail' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => true
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'add-quote-vic' => array(
                'record action' => array('save' => true, 'save and close' => true)
            ), 
            'add-quote-vic > quote_edit' => array(
                'record action' => array('remove' => true, 'save' => true, 'save and close' => true, 'delete' => true, 'download pdf' => true, 'duplicate' => true, 'add vr items' => true)
            ), 
            'contract-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab bill of materials' => array('show' => true), 
                'tab purchase order' => array('show' => true), 
                'tab po summary' => array('show' => true), 
                'tab check list' => array('show' => true), 
                'tab vergola accounts' => array('edit' => true), 
                'tab vergola standard' => array('edit' => true), 
                'tab statutory approval' => array('edit' => true),
                'tab contract cancellation' => array('edit' => true),
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('update' => true, 'cancel contract' => true)
            ), 
            'add-quote-vic > contract_bom' => array(
                'button bill of materials' => array('show' => true), 
                'button purchase order' => array('show' => true), 
                'button po summary' => array('show' => true), 
                'button check list' => array('show' => true), 
                'record action' => array('remove' => false, 'save' => false, 'process order' => false, 'cancel order' => false, 'add vr items' => false)
            ), 
            'contract-po-vic' => array(
                'record action' => array('cancel po' => false, 'save and process po' => false)
            )
        ), 
        /* end Victoria Sales Manager */


        /* ===== ===== ===== ===== ===== */
        /* begin Victoria Users */
        /* ===== ===== ===== ===== ===== */
        '9' => array(
            'client-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => false
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'builder-folder-vic' => array(
                'tab client details' => array('edit' => true), 
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => false
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'tender-folder-vic' => array(
                'tab costing info' => array('add new costing' => true, 'view costing' => true, 'view contract' => true), 
                'tab enquiry tracker' => array('send mail' => true), 
                'tab follow up' => array(
                    'not interested' => true, 'costed' => true, 'quoted' => true, 'under consideration' => true, 
                    'future project' => true, 'won' => true, 'lost' => true, 
                    'project status' => true, 
                    'create contract' => false
                ), 
                'tab sales' => array('save' => true, 'delete' => true), 
                'tab correspondence' => array('save' => true, 'delete' => true), 
                'tab statutory' => array('save' => true, 'delete' => true), 
                'tab photos' => array('save' => true, 'delete' => true), 
                'tab drawings' => array('save' => true, 'delete' => true), 
                'tab general' => array('save' => true, 'delete' => true), 
                'record action' => array('save' => true, 'delete' => true)
            ), 
            'add-quote-vic' => array(
                'record action' => array('save' => true, 'save and close' => true)
            ), 
            'add-quote-vic > quote_edit' => array(
                'record action' => array('remove' => true, 'save' => true, 'save and close' => true, 'delete' => true, 'download pdf' => true, 'duplicate' => true, 'add vr items' => true)
            ), 
            'contract-folder-vic' => array(
                'tab client details' => array('edit' => false), 
                'tab bill of materials' => array('show' => false), 
                'tab purchase order' => array('show' => false), 
                'tab po summary' => array('show' => false), 
                'tab check list' => array('show' => false), 
                'tab vergola accounts' => array('edit' => false), 
                'tab vergola standard' => array('edit' => false), 
                'tab statutory approval' => array('edit' => false),
                'tab contract cancellation' => array('edit' => false),
                'tab sales' => array('save' => false, 'delete' => false), 
                'tab correspondence' => array('save' => false, 'delete' => false), 
                'tab statutory' => array('save' => false, 'delete' => false), 
                'tab photos' => array('save' => false, 'delete' => false), 
                'tab drawings' => array('save' => false, 'delete' => false), 
                'tab general' => array('save' => false, 'delete' => false), 
                'record action' => array('update' => false, 'cancel contract' => false)
            ), 
            'add-quote-vic > contract_bom' => array(
                'button bill of materials' => array('show' => false), 
                'button purchase order' => array('show' => false), 
                'button po summary' => array('show' => false), 
                'button check list' => array('show' => false), 
                'record action' => array('remove' => false, 'save' => false, 'process order' => false, 'cancel order' => false, 'add vr items' => false)
            ), 
            'contract-po-vic' => array(
                'record action' => array('cancel po' => false, 'save and process po' => false)
            )
        )
        /* end Victoria Users */
    )
);
/* ===== end custom configs user ===== */
?>





<?php
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
/* ===== begin custom functions user ===== */
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
class CustomFunctionsUser {
    function getUserGroupKey($user_group_info) {
        $user_group_key = '';

        foreach ($user_group_info as $key1 => $value1) {
            $user_group_key = $key1;
        }

        return $user_group_key;
    }
}
/* ===== end custom functions user ===== */
?>





<?php
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
/* ===== begin custom processes user ===== */
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
$current_signed_in_user_info = JFactory::getUser();

$custom_functions_user = new CustomFunctionsUser();
$current_signed_in_user_group_key = $custom_functions_user->getUserGroupKey($current_signed_in_user_info->groups);
/* ===== end custom processes user ===== */
?>


<?php 
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
/* ===== begin custom config timezone ===== */
/* ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== */
if(HOST_SERVER!=""){
    if(HOST_SERVER=="LA"){
        $utc = new DateTimeZone('America/Los_Angeles');
        $dt = new DateTime('now', $utc);        
        $default_local_timezone = $dt->format('Y-m-d H:i:s');       
    }else if(HOST_SERVER=="SA"){
    
    }else if(HOST_SERVER=="Victoria"){
    
    }else{
    echo "Host server value mismatched or cannot be retrieved. \n Please check server configuration";
    exit;
    };
}
/* ===== end custom config timezone ===== */