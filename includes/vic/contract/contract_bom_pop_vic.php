<?php
$page_name = 'contract_bom';
if (isset($_REQUEST['page_name'])) {
    $page_name = $_REQUEST['page_name'];
}
header('Location:' . JURI::base() . 'add-quote-vic?project_id=' . $_REQUEST['projectid'] . '&page_name=' . $page_name . '&uc=' . date('YmdHisu'));
?>