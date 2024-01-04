<?php 
$category = "";
$marketing_source = "";
$notes = "";
$lead = "";

if(isset($_POST['marketing_source']))
{
	$marketing_source = $_POST['marketing_source'];
	$sql = "SELECT marketing_source FROM  ver_chronoforms_data_lead_vic AS l WHERE active = 1";
}
//our pagination function is now in this file
function pagination($current_page_number, $total_records_found, $query_string = null)
{
	$page = 1;
	
	echo "Page: ";
	
	for ($total_pages = ($total_records_found/NUMBER_PER_PAGE); $total_pages > 0; $total_pages--)
	{
		if ($page != $current_page_number)
			echo "<a href=\"" . "system-management-vic/lead-listing-vic" . "?page=$page" . (($query_string) ? "&$query_string" : "") . "\">";

		if ($page == $current_page_number) {echo "<span class=\"current\">$page</span>";} else {echo "$page";}

		if ($page != $current_page_number)
			echo "</a>";

		$page++;
	}
}
 

define("NUMBER_PER_PAGE", 100); //number of records per page of the search results
$instance =& JURI::getInstance();
$url = JURI::getInstance()->toString();

echo "<div class='search-listing'>

<form id='filter_form'  method='post' method='post' style='float:none; width:90%; visibility: hidden;'>
	<label>Marketing Source:</label> 
	<select name='marketing_source' id='select_marketing_source' style='font-size:14px; padding:4px; min-width:100px;' onchange='document.getElementById(\"filter_form\").submit();'>
		<option value=\"\"  >Select All</option>"; ?>
		<?php
		 $sql = "SELECT * FROM ver_chronoforms_data_lead_vic WHERE active = 1 AND marketing_source != '' GROUP BY marketing_source ORDER BY marketing_source ASC";
		 // $sql = "SELECT l.lead,mc.section as category,mc.category as marketing_source,l.cf_id,l.marketing_id FROM ver_chronoforms_data_lead_vic AS l LEFT JOIN ver_chronoforms_data_marketing_category_vic AS mc ON mc.cf_id=l.marketing_id
		 $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
		    while ($src = mysql_fetch_assoc($sql_result)) { 
		      echo "<option value='".$src["marketing_source"]."'".($src["marketing_source"]==$selected_source ? " selected='selected'" : "").">".$src["marketing_source"]."</option>"; } ?>
<?php
echo "	</select> 
	<input type='submit' name='filter_item' id='filter_item' value='Filter' class='search-btn' onclick='document.getElementById(\"filter_form\").submit();'  />
</form>

</div>";

//display the search form
echo "<div class='search-listing'>
<form action='" . JRoute::_($url) . "' method='post' style='float:none; width:90%;'>
	<label>Search:</label> <input type='text' name='search_string' /> <input type='submit' name='submit' value='Search' class='search-btn' style='width:217px;' />
	<input type='button' class='add-btn' onclick=location.href='" . JURI::base() . "system-management-vic/lead-listing-vic/lead-updatelist-vic' value='Add New'>
</form>

</div>";

//load the current paginated page number
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$start = ($page-1) * NUMBER_PER_PAGE;

/**
* if we used the search form use those variables, otherwise look for
* variables passed in the URL because someone clicked on a page number
**/
$search = (isset($_POST['search_string'])?$_POST['search_string']:"");
// $sql = "SELECT category,marketing_source, lead, notes, cf_id FROM ver_chronoforms_data_lead_vic WHERE 1=1 ";
$sql = "SELECT l.lead,mc.section as category,mc.category as marketing_source,l.cf_id,l.marketing_id FROM ver_chronoforms_data_lead_vic AS l LEFT JOIN ver_chronoforms_data_marketing_category_vic AS mc ON mc.cf_id=l.marketing_id WHERE 1=1 AND l.active = 1";
$result = mysql_query($sql) or die(mysql_error());

if ($search){
	$sql .= " AND (mc.section LIKE '%"  . $search .  "%'" . " OR lead LIKE '%"  . $search .  "%'" . " OR mc.category LIKE '%"  . $search .  "%')" ;
}
//$sql .= " AND marketing_source='{$marketing_source}' ";
if(strlen($marketing_source)>0){
	$sql .= " AND mc.category='{$marketing_source}' "; 
}


//this return the total number of records returned by our query
$total_records = mysql_num_rows(mysql_query($sql));

//now we limit our query to the number of results we want per page
$sql .= " ORDER BY mc.category ASC, l.lead ASC LIMIT $start, " . NUMBER_PER_PAGE;

// echo $sql;
/**
* Next we display our pagination at the top of our search results
* and we include the search words filled into our form so we can pass
* this information to the page numbers. That way as they click from page
* to page the query will pull up the correct results
**/
//echo "<center><h1 class='search-records'>" . number_format($total_records) . " Records Found</h1></center>";
echo "<div class='pagination-layer'>";
pagination($page, $total_records, "category=$category&marketing_source=$marketing_source&lead=$lead&notes=$notes");
echo "</div>";

$loop = mysql_query($sql)
	or die ('cannot run the query because: ' . mysql_error());
	// echo "<table class='listing-table table-bordered'><thead><th style='width: 20%;'>Marketing Source</th><th>Lead Source</th><th>Notes</th></thead><tbody>";
	echo "<table class='listing-table table-bordered'><thead><th style='width: 20%;'>Category</th><th style='width: 20%;'>Marketing Source</th><th>Lead Source</th></thead><tbody>";
while ($record = mysql_fetch_assoc($loop)){
    echo "<tr class='pointer' onclick=location.href='" . $this->baseurl . "lead-listing-vic/lead-updatelist-vic?cf_id={$record['cf_id']}' >";
		// echo "<td>{$record['marketing_source']}</td> " . "<td>{$record['lead']}</td>" . "<td>{$record['notes']} </td>";
    echo "<td>{$record['category']}</td> " . "<td>{$record['marketing_source']}</td>" . "<td>{$record['lead']}</td>";
	echo "</tr>";
	echo "<tr></tr>";
}		
    echo "</tbody></table>"; 
    
echo "<div class='pagination-layer'>";
pagination($page, $total_records, "category=$category&marketing_source=$marketing_source&lead=$lead&notes=$notes");
echo "</div>";
