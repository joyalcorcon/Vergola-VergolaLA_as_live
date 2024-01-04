<?php
// $responseBodyString = "{" .
//                 "\"fn1\":\"abc\", " .
//                 "\"fn2\":\"def\", " .
//                 "\"fn3\":[{\"name\":\"n1\", \"age\":\"11\"}, {\"name\":\"n2\", \"age\":\"12\"}]" .
//             "}";
// print_r($responseBodyString);
// echo '<br /><br />';

// $responseBodyArray = json_decode($responseBodyString, true);
// print_r($responseBodyArray);
// echo '<br /><br />';
// exit;









function pagination($current_page_number, $total_records_found, $query_string = null)
{
	$page = 1;
	
	echo "Page: ";
	
	for ($total_pages = ($total_records_found/NUMBER_PER_PAGE); $total_pages > 0; $total_pages--)
	{
		if ($page != $current_page_number)
			echo "<a href=\"" . "system-management-vic/folio-listing-vic" . "?page=$page" . (($query_string) ? "&$query_string" : "") . "\">";

		 if ($page == $current_page_number) {echo "<span class=\"current\">$page</span>";} else {echo "$page";}

		
		if ($page != $current_page_number)
			echo "</a>";

		$page++;
	}
}



define("NUMBER_PER_PAGE", 100); //number of records per page of the search results
$instance =& JURI::getInstance();
$url = JURI::getInstance()->toString();

//display the search form
echo "<div class='search-listing'>
<form action='" . JRoute::_($url) . "' method='post'>
	Search: <input type='text' name='search_string' /> <input type='submit' name='submit' value='Search' class='search-btn' />
</form>
<input type='button' class='add-btn' onclick=location.href='" . JURI::base() . "system-management-vic/folio-listing-vic/folio-manage-vic?module=&default_content_category=' value='Add New'>
<input type='button' class='add-btn' onclick=location.href='" . JURI::base() . "system-management-vic/folio-listing-vic?module=adhoc_email' value='Adhoc Email'>
</div>";


//load the current paginated page number
$page = ($_GET['page']) ? $_GET['page'] : 1;
$start = ($page-1) * NUMBER_PER_PAGE;

/**
* if we used the search form use those variables, otherwise look for
* variables passed in the URL because someone clicked on a page number
**/

$module = '';
if (isset($_REQUEST['module']) && strlen($_REQUEST['module']) > 0) {
	$module = $_REQUEST['module'];
}

$search = $_POST['search_string'];

$sql1 = "
    SELECT 
        document_handler_entity.id AS 'entity_id', 
        document_handler_folder.id AS 'folder_id', 
        document_handler_file.id AS 'file_id', 
        document_handler_entity.name AS 'entity_name', 
        document_handler_folder.name AS 'folder_name', 
        document_handler_file.name AS 'file_name', 
		document_handler_file.from AS 'file_from', 
		document_handler_file.to AS 'file_to', 
		document_handler_file.content_date AS 'file_content_date', 
		document_handler_file.status AS 'file_status' 
    FROM document_handler_entity 
    	LEFT JOIN  document_handler_entity_folder 
    		ON document_handler_entity.id = document_handler_entity_folder.entity_id 
    	LEFT JOIN document_handler_folder 
    		ON document_handler_entity_folder.folder_id = document_handler_folder.id 
    	LEFT JOIN document_handler_folder_file 
    		ON document_handler_folder.id = document_handler_folder_file.folder_id 
    	LEFT JOIN document_handler_file 
    		ON document_handler_folder_file.file_id = document_handler_file.id 
    WHERE document_handler_entity.date_deleted IS NULL 
    AND document_handler_folder.date_deleted IS NULL 
    AND document_handler_file.date_deleted IS NULL 
    AND document_handler_entity_folder.date_deleted IS NULL 
    AND document_handler_folder_file.date_deleted IS NULL 
    /*
    AND document_handler_entity.id IS NOT NULL 
    AND document_handler_folder.id IS NOT NULL 
    AND document_handler_file.id IS NOT NULL 
    */
	AND document_handler_entity.module = '" . addslashes($module) . "' 
	/* 
	AND document_handler_file.content_category = 'Template' 
	*/
	ORDER BY document_handler_folder.name, document_handler_entity.name, document_handler_file.name 
";

$sql2 = "
    SELECT 
        document_handler_entity_folder_file.id, 
        document_handler_entity.id AS 'entity_id', 
        document_handler_folder.id AS 'folder_id', 
        document_handler_file.id AS 'file_id', 
        document_handler_entity.name AS 'entity_name', 
        document_handler_folder.name AS 'folder_name', 
        document_handler_file.name AS 'file_name', 
		document_handler_file.from AS 'file_from', 
		document_handler_file.to AS 'file_to', 
		document_handler_file.content_date AS 'file_content_date', 
		document_handler_file.status AS 'file_status' 
    FROM document_handler_entity 
        LEFT JOIN document_handler_entity_folder_file 
            ON document_handler_entity.id = document_handler_entity_folder_file.entity_id 
        LEFT JOIN document_handler_folder 
            ON document_handler_entity_folder_file.folder_id = document_handler_folder.id 
        LEFT JOIN document_handler_file 
            ON document_handler_entity_folder_file.file_id = document_handler_file.id 
    WHERE document_handler_entity.date_deleted IS NULL 
    AND document_handler_folder.date_deleted IS NULL 
    AND document_handler_file.date_deleted IS NULL 
    AND document_handler_entity_folder_file.date_deleted IS NULL 
    AND document_handler_entity.id IS NOT NULL 
    AND document_handler_folder.id IS NOT NULL 
    AND document_handler_file.id IS NOT NULL 
    /*
	AND document_handler_entity.module = '" . addslashes($module) . "' 
	*/
	/* 
	AND document_handler_file.content_category = 'Template' 
	*/
	ORDER BY document_handler_folder.name, document_handler_entity.name, document_handler_file.name 
";

$target_sql = $sql1;
if ($module == '') {
	$target_sql = $sql2;
}

$result = mysql_query($target_sql) or die(mysql_error());

if ($search)
	$target_sql .= " 
		AND ( 
			document_handler_entity.name LIKE '%"  . addslashes($search) .  "%' 
			OR document_handler_folder.name LIKE '%"  . addslashes($search) .  "%' 
			OR document_handler_file.name LIKE '%"  . addslashes($search) .  "%' 
			OR document_handler_file.from LIKE '%"  . addslashes($search) .  "%' 
			OR document_handler_file.to LIKE '%"  . addslashes($search) .  "%' 
			OR document_handler_file.content_date LIKE '%"  . addslashes($search) .  "%' 
		) 
	";
	
//this return the total number of records returned by our query
$total_records = mysql_num_rows(mysql_query($target_sql));

//now we limit our query to the number of results we want per page
$target_sql .= " LIMIT $start, " . NUMBER_PER_PAGE;

/**
* Next we display our pagination at the top of our search results
* and we include the search words filled into our form so we can pass
* this information to the page numbers. That way as they click from page
* to page the query will pull up the correct results
**/
echo "<center><h1 class='search-records'>" . number_format($total_records) . " Records Found</h1></center>";
echo "<div class='pagination-layer'>";
pagination($page, $total_records, "lead=$lead");
echo "</div>";

$loop = mysql_query($target_sql)
	or die ('cannot run the query because: ' . mysql_error());
echo "
	<table class='listing-table table-bordered'>
		<thead>
		</thead>
		<tbody>";

$current_folder_name = '';
while ($record = mysql_fetch_assoc($loop)) {
	if ($current_folder_name != $record['folder_name']) {
		$current_folder_name = $record['folder_name'];
	    echo "
			<tr>
				<td colspan='5' style='font-family: verdana, arial; font-size:11pt; font-weight:bold;'>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='5' style='font-family: verdana, arial; font-size:11pt; font-weight:bold;'>{$current_folder_name}</td>
			</tr>
			<tr style='background-color: #cccccc;'>
				<th>Sections</th>
				<th>Documents</th>
				<th>Sender</th>
				<th>Receiver</th>
				<th>Content Date</th>
			</tr>
			";
	}
    echo "
		<tr class='pointer' onclick=location.href='" . $this->baseurl . "folio-listing-vic/folio-manage-vic?module=&default_entity_id={$record['entity_id']}&default_folder_id={$record['folder_id']}&default_file_id={$record['file_id']}&default_content_category='>
			<td>{$record['entity_name']}</td>
			<td>{$record['file_name']}</td>
			<td>{$record['file_from']}</td>
			<td>{$record['file_to']}</td>
			<td>{$record['file_content_date']}</td>
		</tr>
		";
}

echo "
			<tr>
				<td colspan='5' style='font-family: verdana, arial; font-size:11pt; font-weight:bold;'>&nbsp;</td>
			</tr>
		</tbody>
	</table>
"; 
    

echo "<div class='pagination-layer'>";
pagination($page, $total_records, "lead=$lead");
echo "</div>";
