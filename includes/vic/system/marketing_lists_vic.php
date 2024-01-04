<?php 
$year = "";
$monthyear = "";
$lead = "";



if(isset($_POST['year']))
{
	$year = $_POST['year'];
	// $sql1 = "SELECT year FROM  ver_chronoforms_data_lead_vic AS l ";
	$sql = "
			SELECT
				l.lead,
				l.notes,
				m.id,
				m.lead_id,
				m.marketing_amount,
				Sum( m.marketing_amount ) AS marketing_amount_total,
				m.target_amount,
				m.target_contract,
				m.marketing_date,
				MONTH ( m.marketing_date ),
				CONCAT( MONTHNAME( m.marketing_date ), ' ', m.`year` ) AS MonthYear,
				m.dateFromTo,
				m.`year` 
			FROM
				ver_lead_marketing_spend AS m
				INNER JOIN ver_chronoforms_data_lead_vic AS l ON l.cf_id = m.lead_id 
			WHERE
				1 = 1 AND m.active = 1
			GROUP BY
				m.marketing_date 
			ORDER BY
				m.marketing_date DESC";
}
//our pagination function is now in this file
function pagination($current_page_number, $total_records_found, $query_string = null)
{
	$page = 1;
	
	echo "Page: ";
	
	for ($total_pages = ($total_records_found/NUMBER_PER_PAGE); $total_pages > 0; $total_pages--)
	{
		if ($page != $current_page_number)
			echo "<a href=\"" . "marketing-listing-vic" . "?page=$page" . (($query_string) ? "&$query_string" : "") . "\">";

		if ($page == $current_page_number) {echo "<span class=\"current\">$page</span>";} else {echo "$page";}

		if ($page != $current_page_number)
			echo "</a>";

		$page++;
	}
}
 

define("NUMBER_PER_PAGE", 100); //number of records per page of the search results
$instance =& JURI::getInstance();
$url = JURI::getInstance()->toString();

$year_start  = date('Y') - 10;
$year_end = date('Y'); // current Year
$selected_year = 1992; // user date of birth year
                       // 
// use this to set an option as selected (ie you are pulling existing values out of the database)
$already_selected_value = date('Y');
$earliest_year = date('Y') - 10;

echo "<div class='search-listing'>

<form id='filter_form'  method='post' method='post' style='float:none; width:90%;'>
	<label>Marketing Year:</label> 
	<select name='year' id='select_marketing_year' style='font-size:14px; padding:4px; min-width:100px;' onchange='document.getElementById(\"filter_form\").submit();'>
		<option value=\"\"  >Show All</option>";		
		// foreach (range(date('Y'), $earliest_year) as $x) {
		// print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; }
		for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
		    $selected = $selected_year == $i_year ? ' selected' : '';
		    echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
		} 
		
echo "
	</select>

<input type='submit' name='filter_item' id='filter_item' value='Filter' class='search-btn' onclick='document.getElementById(\"filter_form\").submit();'  />
</form>

</div>";

//display the search form
echo "<div class='search-listing'>
<form action='" . JRoute::_($url) . "' method='post' style='float:none; width:90%;'>
	<label>Search:</label> <input type='text' name='search_string' /> <input type='submit' name='submit' value='Search' class='search-btn' style='width:217px;' />
	<input type='button' class='add-btn' onclick=location.href='" . JURI::base() . "marketing-listing-vic/marketing-updatelist-vic' value='Add New'>
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
$sql = "
		SELECT

			l.lead,
			l.notes,
			m.id AS cf_id,
			m.lead_id,
			m.marketing_amount,
			Sum( m.marketing_amount ) AS marketing_amount_total,
			m.target_amount,
			m.target_contract,
			m.marketing_date,
			MONTH( m.marketing_date ) AS month,			
			CONCAT( MONTHNAME( m.marketing_date ), '-', YEAR(m.marketing_date) ) AS MonthYear,
			m.dateFromTo,
			m.`year` 
		FROM
			ver_lead_marketing_spend AS m
			INNER JOIN ver_chronoforms_data_lead_vic AS l ON l.cf_id = m.lead_id 
		WHERE
			1=1 AND m.active = 1  ";
$result = mysql_query($sql) or die(mysql_error());
$arrayResult = mysql_fetch_array($result);
$num_rows = mysql_num_rows($result);

if ($search){
	$sql .= " AND lead LIKE '%"  . $search .  "%'" . " OR MONTHNAME(m.marketing_date) LIKE '%"  . $search .  "%'" ;
}	
//$sql .= " AND year='{$year}' ";
if(strlen($year)>0){
	// $sql .= " AND m.year='{$year}' "; 
	$sql .= " AND m.year='{$year}' "; 
}


//this return the total number of records returned by our query
$total_records = mysql_num_rows(mysql_query($sql));

//now we limit our query to the number of results we want per page
// $sql .= " GROUP BY m.marketing_date ORDER BY m.marketing_date DESC LIMIT $start, " . NUMBER_PER_PAGE;
$sql .= " GROUP BY m.marketing_date ORDER BY YEAR(m.marketing_date) DESC, MONTH(m.marketing_date) DESC LIMIT $start, " . NUMBER_PER_PAGE;

// echo $sql;
/**
* Next we display our pagination at the top of our search results
* and we include the search words filled into our form so we can pass
* this information to the page numbers. That way as they click from page
* to page the query will pull up the correct results
**/
//echo "<center><h1 class='search-records'>" . number_format($total_records) . " Records Found</h1></center>";
echo "<div class='pagination-layer'>";
pagination($page, $total_records, "year=$year&lead=$lead&MonthYear=$monthyear");
echo "</div>";

$loop = mysql_query($sql)
	or die ('cannot run the query because: ' . mysql_error());
	// echo "<table class='listing-table table-bordered'><thead><th style='width: 20%;'>Marketing Source</th><th>Lead Source</th><th>Notes</th></thead><tbody>";
	echo "<table class='listing-table table-bordered'><thead><th style='width: 20%;'>Marketing Month Year</th><th>Total Amount</th><th>Enquiries</th><th>Contracts</th></thead><tbody>";
while ($record = mysql_fetch_assoc($loop)){
    // echo "<tr class='pointer' onclick=location.href='" . $this->baseurl . "marketing-listing-vic/marketing-updatelist-vic?cf_id={$record['cf_id']}' >";    
    // echo "<tr class='pointer' onclick=location.href='" . $this->baseurl . "marketing-listing-vic/marketing-updatelist-vic?year={$record['year']}&month={$record['month']}' >";
    echo "<tr class='pointer' onclick=location.href='" . $this->baseurl . "marketing-listing-vic/marketing-updatelist-vic?monthyear={$record['MonthYear']}' >";
		// echo "<td>{$record['year']}</td> " . "<td>{$record['lead']}</td>" . "<td>{$record['notes']} </td>";
    echo "<td>{$record['MonthYear']}</td> " . "<td>{$record['marketing_amount_total']}</td> " . "<td>{$record['']}</td> " . "<td>{$record['']}</td>";
	echo "</tr>";
	echo "<tr></tr>";
}		
    echo "</tbody></table>"; 
    
echo "<div class='pagination-layer'>";
pagination($page, $total_records, "year=$year&lead=$lead&MonthYear=$monthyear");
echo "</div>";


//function to create a table
function makeTable($table, $columns){
    $numFields = count($columns)-1;
    $query = 'SELECT * FROM '.$table;
    $result = mysql_query($query);

    while ($arrayResult = mysql_fetch_array($result)){
        echo '<tr>';
            for ($i = 0; $i <= $numFields; $i++){ //2nd for loop
                echo '<td>'.$arrayResult[$columns[$i]].'</td>';
            }
        echo '</tr>';
    }
}?>




<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/lightbox.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/jquery-ui-1.11.4/jquery-ui.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/custom.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/system-maintenance.css'; ?>" />

<script src="<?php echo JURI::base() . 'jscript/jquery.min.js'; ?>"></script>
<script src="<?php echo JURI::base() . 'jscript/jquery-ui-1.11.4/jquery-ui.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'jscript/lightbox.js'; ?>"></script>
<SCRIPT language="javascript">
  function change_section() {
    var section = $("#section option:selected").val();
    var inventoryid = $("#inventoryid").val();
    var inv_param = "";
    if (inventoryid.length > 0) {
      inv_param = "&inventoryid=" + inventoryid;
    }

    location.href = "<?php echo JURI::base(); ?>marketing-listing-vic/marketing-updatelist-vic?section=" + section + inv_param;
  }


  function showdrop() {
    var section = $("#section").val(); // get the value of currently selected section
    $.ajax({
      type: "post",
      dataType: "text",
      data: "section=" + section,
      url: "<?php echo JURI::base() . 'includes/vic/category_vic.php'; ?>", // page to which the ajax request is passed
      success: function(response) {
        $("#category").html(response); // set the result to category dropdown
        $("#category").show();
      }
    })


  }


  function addRow(tableID) {

    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;

    for (var i = 0; i < colCount; i++) {

      var newcell = row.insertCell(i);

      newcell.innerHTML = table.rows[0].cells[i].innerHTML;
      //alert(newcell.childNodes);
      switch (newcell.childNodes[0].type) {
        case "text":
          newcell.childNodes[0].value = "";
          break;
        case "checkbox":
          newcell.childNodes[0].checked = false;
          break;
        case "select-one":
          newcell.childNodes[0].selectedIndex = 0;
          break;
      }
    }
  }

  function deleteRow(tableID) {
    try {
      var table = document.getElementById(tableID);
      var rowCount = table.rows.length;

      for (var i = 0; i < rowCount; i++) {
        var row = table.rows[i];

        var chkbox = row.cells[0].childNodes[0];
        if (null != chkbox && true == chkbox.checked) {
          if (rowCount <= 1) {
            alert("Cannot delete all the rows.");
            break;
          }
          table.deleteRow(i);
          rowCount--;
          i--;
        }


      }
    } catch (e) {
      alert(e);
    }
  }
</SCRIPT>
<h2><?php if ($is_adding) echo "Add";  ?> Marketing</h2>
<?php if (strlen($notification) > 0) {
  echo "<div class='notification_result'>{$notification}</div>";
}