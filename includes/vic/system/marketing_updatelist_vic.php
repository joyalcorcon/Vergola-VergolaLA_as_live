<?php
$next_increment = 0;
$qShowStatus = "SHOW TABLE STATUS LIKE 'ver_lead_marketing_spend'";
$qShowStatusResult = mysql_query($qShowStatus) or die("Query failed: " . mysql_error() . "<br/>" . $qShowStatus);
$row = mysql_fetch_assoc($qShowStatusResult);
$next_increment = $row['Auto_increment'];
$_monthyear = "";
if(isset($_REQUEST['monthyear'])){
  $monthyear = $_REQUEST['monthyear'];
  $_monthyear = $_REQUEST['monthyear'];
}

if(isset($_REQUEST['year'])){
  $selected_year = $_REQUEST['year'];
  $year = $_REQUEST['year'];
}

if(isset($_REQUEST['month'])){
  $selected_month = $_REQUEST['month'];
  $month = $_REQUEST['month'];
  $monthName = $_REQUEST['month'];
}

if(isset($_REQUEST['category'])){
  $selected_category = $_REQUEST['category'];
}

if(isset($_REQUEST['source'])){
  $selected_source = $_REQUEST['source'];
}

if(isset($_REQUEST['mid'])){
  $selected_source_cf_id = $_REQUEST['mid'];
  $mid = $_REQUEST['mid'];
}

$is_edit = 0;
if(isset($_REQUEST['view']) && $_REQUEST['view']=="add"){
}else{
  $is_edit = 1;


$id =$_REQUEST['cf_id'];
$cf_id =$_REQUEST['cf_id'];

$month = mysql_real_escape_string($_REQUEST['month']);
$year = mysql_real_escape_string($_REQUEST['year']);

if(isset($_POST['category_source'])){
  $selected_category = $_REQUEST['category_source'];}

if(isset($_POST['marketing_source'])){
  $selected_source = $_REQUEST['marketing_source'];} 

if(isset($_POST['lead_source'])){
  $selected_lead = $_REQUEST['lead_source'];} 

if(isset($_POST['marketing_date'])){
  $_monthname = date("F", strtotime($marketing_month));
  $selected_month = $_REQUEST['marketing_date'];
}

$monthyear = mysql_real_escape_string($_REQUEST['monthyear']);
$category = mysql_real_escape_string($_REQUEST['category']);
$source = mysql_real_escape_string($_REQUEST['source']);
$lead = mysql_real_escape_string($_REQUEST['lead']);
$m_id = mysql_real_escape_string($_REQUEST['cf_id']);

if (isset($_REQUEST['monthyear']) && strlen($_REQUEST['monthyear']) > 0) {
}

if(isset($_POST['save']) || isset($_POST['save_new']))
{

  $year = mysql_escape_string($_POST['year']);
  $marketing_month = mysql_escape_string($_POST['marketing_date']);   
  $category_source = mysql_escape_string($_POST['category_source']);
  $marketing_source = mysql_escape_string($_POST['marketing_source']);
  $lead_source = mysql_escape_string($_POST['lead_source']);
  $lead = mysql_escape_string($_POST['lead_source']);
  $marketing_amount = mysql_escape_string($_POST['marketing_amount']);
  $marketing_month = $marketing_month + 1;
  $nmonth = date("n", strtotime($marketing_month));   
  $marketing_date = $year . '-' . $marketing_month. '-01';
  $monthNum = sprintf("%02s", $nmonth);
  $monthname = date("F", strtotime($marketing_month));

  if(isset($_POST['save_new']))
  { 
    
    $next_increment = 0;
    $qShowStatus = "SHOW TABLE STATUS LIKE 'ver_lead_marketing_spend'";
    $qShowStatusResult = mysql_query($qShowStatus) or die("Query failed: " . mysql_error() . "<br/>" . $qShowStatus);
    $row = mysql_fetch_assoc($qShowStatusResult);
    $next_increment = $row['Auto_increment'];

    $cf_id =$next_increment;

    mysql_query("INSERT INTO ver_lead_marketing_spend (marketing_amount,year,lead_id, marketing_date,month) VALUES ('$marketing_amount', '$year', '$lead', '$marketing_date', '$marketing_month' );")
          or die(mysql_error());
    echo "Saved!";
    echo $monthyear;

  }else if(isset($_POST['save'])){  
    mysql_query("UPDATE ver_lead_marketing_spend SET lead_id ='$lead', year ='$year', marketing_amount='$marketing_amount', marketing_date='$marketing_date', month='$marketing_month' WHERE id = '$id'")
          or die(mysql_error());
    echo "Updated!";
    echo $monthyear;
    // header('Location:' . JURI::base() . 'marketing-listing-vic/marketing-updatelist-vic?monthyear=' . $monthyear);
  }else{

  }
  header('Location:' . JURI::base() . 'marketing-listing-vic/marketing-updatelist-vic?monthyear=' . $monthyear);
  $selected_year = $_REQUEST['year'];
  $year = $_REQUEST['year'];
  $month = $_REQUEST['month'];
  $monthName = $_REQUEST['month'];

  $sql = "SELECT l.*,m.*,m.id AS cf_id,Sum(m.marketing_amount) AS marketing_amount_total,MONTH (m.marketing_date) AS monthNumber,MONTHNAME(m.marketing_date) AS monthName,CONCAT(MONTHNAME(m.marketing_date),'-',YEAR(m.marketing_date)) AS MonthYear ,YEAR(m.marketing_date) AS year FROM ver_lead_marketing_spend AS m INNER JOIN ver_chronoforms_data_lead_vic AS l ON l.cf_id=m.lead_id WHERE 1=1 AND m.active = 1 AND m.id='{$cf_id}' GROUP BY m.lead_id ORDER BY l.lead ASC;";
  $result = mysql_query($sql);

  $retrieve = mysql_fetch_array($result);
  if (!$result) {
    die("Error: Data not found..");
  }
  $monthyear = $retrieve['MonthYear'];

}
if (isset($_REQUEST['cf_id']) && strlen($_REQUEST['cf_id']) > 0) {
    $cf_id = mysql_real_escape_string($_REQUEST['cf_id']);
    $id = mysql_real_escape_string($_REQUEST['cf_id']);
    $m_id = mysql_real_escape_string($_REQUEST['cf_id']);
    
    $sql = "SELECT l.*,m.*,m.id AS cf_id,Sum(m.marketing_amount) AS marketing_amount_total,MONTH (m.marketing_date) AS monthNumber,MONTHNAME(m.marketing_date) AS monthName,CONCAT(MONTHNAME(m.marketing_date),'-',YEAR(m.marketing_date)) AS MonthYear, YEAR(m.marketing_date) AS year FROM ver_lead_marketing_spend AS m INNER JOIN ver_chronoforms_data_lead_vic AS l ON l.cf_id=m.lead_id WHERE 1=1 AND m.active = 1 AND m.id='{$cf_id}' GROUP BY m.lead_id ORDER BY l.lead ASC;";

    $sql = "
      SELECT
        l.*,m.*, mc.*,
        mc.section AS category, mc.category AS marketing_source,
        m.marketing_amount,
        Sum( m.marketing_amount ) AS marketing_amount_total,
        MONTH ( m.marketing_date ) AS monthNumber,
        MONTHNAME( m.marketing_date ) AS monthName,
        CONCAT( MONTHNAME( m.marketing_date ), '-', YEAR ( m.marketing_date ) ) AS MonthYear,
        YEAR ( m.marketing_date ) AS YEAR 
      FROM
        ver_lead_marketing_spend AS m
        INNER JOIN ver_chronoforms_data_lead_vic AS l ON l.cf_id = m.lead_id
        LEFT JOIN ver_chronoforms_data_marketing_category_vic AS mc ON l.marketing_id = mc.cf_id
      WHERE
        1 = 1 
        AND m.id = '{$cf_id}'
      GROUP BY m.lead_id 
      ORDER BY
        l.lead ASC;";   
    $result = mysql_query($sql);

    $retrieve = mysql_fetch_array($result);
    if (!$result) {
      die("Error: Data not found..");
    }else{    
    $monthyear = $retrieve['MonthYear'];
    $category_source = $retrieve['category'];
    $marketing_source = $retrieve['marketing_source'];
    $lead_source = $retrieve['lead'];
    $lead = $retrieve['lead'];
    $lead_id = $retrieve['lead_id'];
    $marketing_amount = $retrieve['marketing_amount'];
    $monthNumber = $retrieve['monthNumber'];
    $monthName = $retrieve['monthName'];
    $month = $retrieve['monthName'];
    $year = $retrieve['year'];

    $selected_year = $retrieve['year'];
    $selected_category = $retrieve['category'];
    $selected_source = $retrieve['marketing_source'];
    $selected_lead = $retrieve['lead'];
}
  }else if (!empty($id)) {
    $is_adding = 0;
  }else{
    $is_adding = 1;
  }
}
if (!empty($id) && $is_adding == 0) {
  if ($cf_id > 0 || $id > 0 || $m_id > 0 ) {
  } else {
    $cf_id = $_REQUEST['cf_id'];
    $m_id = $_REQUEST['cf_id'];
  }

  if ($year > 0 ) {
  } else {
    $year = $_REQUEST['year'];
  }

  if ($month > 0 ) {
  } else {
    $month = $_REQUEST['month'];
  }
  if(isset($_REQUEST['monthyear'])){
  }
} else {
}

// echo $monthyear;
// echo ltrim($monthyear,-5);
// echo substr($monthyear, -4);
// echo strtok($monthyear, '-');
$selected_year = substr($monthyear, -4);
$monthName = strtok($monthyear, '-');

if(isset($_POST['delbtn'])){ 
  $cf_id = mysql_real_escape_string($_POST['cf_id']);
  // $sql = "DELETE from ver_lead_marketing_spend WHERE id = '$cf_id'";
  $sql = "UPDATE ver_lead_marketing_spend SET active = 0 WHERE id = '$cf_id'";
  mysql_query($sql) or die(mysql_error()); $notification = "Item has been deleted.";
  header('Location:' . JURI::base() . 'marketing-listing-vic/marketing-updatelist-vic?monthyear=' . $monthyear);  
}

if(isset($_POST['cancel'])){ 
  header('Location:'.JURI::base().'marketing-listing-vic');     
}

?>
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/lightbox.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/jquery-ui-1.11.4/jquery-ui.css'; ?>" />  
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/custom.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/system-maintenance.css'; ?>" />

<div>
  <h2><?php if(!$is_adding) echo "Edit"; else echo "Add";  ?> Marketing Expenditures [<?php echo $monthyear; ?>] </h2>
  <?php if(strlen($notification)>0){echo "<div class='notification_result'>{$notification}</div>";} ?>
  <div id="notification" class="notification_box hide"  ></div>
  <input type='hidden' name='year_' id='year_' value='<?php echo $year_; ?>' />
  <input type='hidden' name='monthName_' id='monthName_' value='<?php echo $monthName_; ?>' />
<form class="Chronoform hasValidation" method="post" id="chronoform_Marketing_Vic" action="<?php echo JURI::base(); ?>marketing-listing-vic\marketing-updatelist-vic" enctype="multipart/form-data">
  <input type='hidden' name='id' id='id' value='<?php echo $id; ?>' />
  <input type='hidden' name='cf_id' id='cf_id' value='<?php echo $cf_id; ?>' />
  <input type='hidden' name='m_id' id='m_id' value='<?php echo $m_id; ?>' />
  <input type='hidden' name='year' id='year' value='<?php echo $year; ?>' />
  <input type='hidden' name='monthName' id='monthName' value='<?php echo $monthName; ?>' />
  <input type='hidden' name='selected_month' id='selected_month' value='<?php echo $selected_month; ?>' />
  <input type='hidden' name='month' id='month' value='<?php echo $month; ?>' />
  <input type='hidden' name='monthyear' id='monthyear' value='<?php echo $monthyear; ?>' />  
  <input type='hidden' name='lead' id='lead' value='<?php echo $lead; ?>' />
  <input type='hidden' name='marketing_amount' id='marketing_amount' value='<?php echo $marketing_amount; ?>' />
  <input type='hidden' name='is_adding' id='is_adding' value='<?php echo $is_adding; ?>' />
  <input type='hidden' name='is_edit' id='is_edit' value='<?php echo $is_edit; ?>' />
  <input type='hidden' name='category_source' id='category_source' value='<?php echo $category_source; ?>' />
  <input type='hidden' name='marketing_source' id='marketing_source' value='<?php echo $marketing_source; ?>' />
  <input type='hidden' name='lead_source' id='lead_source' value='<?php echo $lead_source; ?>' />
  <input type='hidden' name='selected_category' id='selected_category' value='<?php echo $selected_category; ?>' />
  <input type='hidden' name='lead' id='lead' value='<?php echo $lead; ?>' />
  <input type='hidden' name='selected_source_cf_id' id='selected_source_cf_id' value='<?php echo $selected_source_cf_id; ?>' />
  
  
  <table class="inventory-table">
    <tr>
      <th width="10%">Year</th>
      <th width="20%">Month</th>   
    </tr>
    <tr>
       <td>
        <div id="cbo_year">
          <select name="year" id="year">
            <option value='<?php echo $year; ?>'></option>
            <?php        
            for ($i_year = date('Y') - 10; $i_year <= date('Y'); $i_year++) {
                $selected = $year == $i_year ? ' selected' : '';
                echo "<option value='".$i_year."'".($i_year==$selected_year ? " selected='selected'" : "").">{$i_year}</option>";
            } ?>
          </select>
        </div>
      </td>
      <td>
        <div id="cbo_month">
          <select name="marketing_date" id="marketing_date">
            <option value='<?php echo $month; ?>'></option>
            <?php
            
              foreach (['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'] as $monthNumber => $month) {
                $month = date("F", mktime(0, 0, 0, $month, 10));
                $selected_month = date("F", mktime(0, 0, 0, $selected_month, 10));
                if ($selected_month != ''){
                }
                echo "<option value='".$monthNumber."'".($month==$monthName ? " selected='selected'" : "").">{$month}</option>";
    
            }
            ?>          
          </select>
        </div>
      </td>
    </tr>
    <tr>   
      <th width="25%">Category</th>
      <th width="25%">Source</th>
      <th width="35%">Lead</th>
      <th width="10%">Amount</th>
      <th></th>
    </tr>
    <tr>
      <td class="row2">        
          <div id="cbo_category">
            <select class="suburb-list" name="category_source" id="category_source" >
              <option value=""></option>
              <?php
                $sql = "SELECT distinct section as category, sectionid FROM ver_chronoforms_data_marketing_category_vic WHERE 1=1 ORDER BY section ASC";
                $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
                  while ($src = mysql_fetch_assoc($sql_result)) { 
                    echo "<option value='".$src["category"]."'".($src["category"]==$selected_category ? " selected='selected'" : "").">".$src["category"]."</option>"; } ?>
            </select>          
          </div>
        </td>
        <td>
          <div id="cbo_marketing_source">        
            <select class="suburb-list" name="marketing_source" id="marketing_source" >
              <option value=""></option>
              <?php             
                $sql = "SELECT distinct category as marketing_source, sectionid FROM ver_chronoforms_data_marketing_category_vic WHERE 1=1 ORDER BY section ASC";
                if (!empty($selected_category) || $selected_category != '') {              
                  $sql = "SELECT distinct category as marketing_source, sectionid, cf_id AS source_cf_id FROM ver_chronoforms_data_marketing_category_vic WHERE section = '$selected_category' AND 1=1 ORDER BY section ASC"; }
                  $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
                  while ($src = mysql_fetch_assoc($sql_result)) { 
                    echo "<option id='".$selected_source_cf_id=$src["source_cf_id"]."' value='".$src["marketing_source"]."'".($src["marketing_source"]==$selected_source ? " selected='selected'" : "").">".$src["marketing_source"]." </option>"; } ?>
            </select>          
          </div>
        </td>
        <td>
          <div id="cbo_lead_source" >
            <select class="suburb-list" name="lead_source" id="lead_source">
            <option value=""></option>
              <?php 
                $sql = "SELECT * FROM ver_chronoforms_data_lead_vic WHERE 1=1 ORDER BY lead ASC";
                if (!empty($mid) && $mid > 0) {
                  $sql = "SELECT * FROM ver_chronoforms_data_lead_vic WHERE marketing_id = '$mid' AND 1=1 ORDER BY lead ASC";
                }
                $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
                  while ($_lead = mysql_fetch_assoc($sql_result)) { 
                    echo "<option value='".$_lead["cf_id"]."'".($_lead["lead"]==$lead ? " selected='selected'" : "").">".$_lead["lead"]."</option>"; } ?>        
            </select>
          </div>
        </td> 
      <td class="rrp"><input type="text" id="marketing_amount" name="marketing_amount" value='<?php echo $marketing_amount; ?>'></td>
    </tr>
  </table>




<?php
if (isset($_REQUEST['cf_id']) && strlen($_REQUEST['cf_id']) > 0) {
  $sql = "
        SELECT
          l.lead,
          l.notes,
          l.marketing_source,
          m.id AS cf_id,
          m.lead_id,
          m.marketing_amount,
          Sum( m.marketing_amount ) AS marketing_amount_total,
          m.target_amount,
          m.target_contract,
          m.marketing_date,
          MONTH (m.marketing_date),
          MONTHNAME(m.marketing_date) AS month,
          CONCAT( MONTHNAME( m.marketing_date ), '-', YEAR(m.marketing_date) ) AS MonthYear,
          m.dateFromTo,
          YEAR(m.marketing_date) AS year 
        FROM
          ver_lead_marketing_spend AS m
          INNER JOIN ver_chronoforms_data_lead_vic AS l ON l.cf_id = m.lead_id 
        WHERE
          1 = 1 AND m.active = 1
          AND m.id  = '{$cf_id}'
        GROUP BY
          m.lead_id
        ORDER BY
          l.lead ASC ";
  $result = mysql_query($sql);


  $retrieve = mysql_fetch_array($result);
  if (!$result) {
    die("Error: Data not found..");
  }


  $monthyear = $retrieve['MonthYear'];
  $marketing_source = $retrieve['marketing_source'];
  $lead = $retrieve['lead'];
  $marketing_amount = $retrieve['marketing_amount'];
}
$sql = "
      SELECT
        l.lead,
        mc.section AS category, mc.category AS marketing_source,
        m.id AS cf_id,
        m.lead_id,
        m.marketing_amount,
        CONCAT('$', FORMAT(m.marketing_amount, 2)) AS _amount,
        Sum( m.marketing_amount ) AS marketing_amount_total,
        m.target_amount,
        m.target_contract,
        m.marketing_date,
        MONTH ( m.marketing_date ),
        CONCAT( MONTHNAME( m.marketing_date ), '-', YEAR(m.marketing_date)) AS MonthYear,
        m.dateFromTo,
        YEAR(m.marketing_date) AS year  
      FROM
        ver_lead_marketing_spend AS m
        INNER JOIN ver_chronoforms_data_lead_vic AS l ON l.cf_id = m.lead_id 
        LEFT JOIN ver_chronoforms_data_marketing_category_vic AS mc ON l.marketing_id = mc.cf_id
      WHERE
        1 = 1 AND m.active = 1
        AND CONCAT(MONTHNAME(m.marketing_date),'-',YEAR(m.marketing_date)) = '{$monthyear}'
      GROUP BY
        m.lead_id
      ORDER BY
        l.lead ASC ";
$result = mysql_query($sql) or die(mysql_error());

$loop = mysql_query($sql) or die ('cannot run the query because: ' . mysql_error()); echo "<table class='listing-table table-bordered' style='width: 50%;'>
    <thead>
        <tr style=''>
            <th>Month-Year</th>
            <th>Category</th>
            <th>Marketing Source</th>
            <th>Lead</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>"; 
    $amount_ = (number_format($record["marketing_amount"], 2));
    while ($record = mysql_fetch_assoc($loop))
    echo "<tr class='pointer' onclick=location.href='" . $this->baseurl . "marketing-updatelist-vic?cf_id={$record['cf_id']}'>
            <td>{$record['MonthYear']}</td>
            <td>{$record['category']}</td>
            <td>{$record['marketing_source']}</td>
            <td>{$record['lead']}</td>
            <td>{$record['_amount']}</td>
            <td><input type='submit' value='Delete' style='margin:0 0 0 5px;' id='delbtn' name='delbtn' class='update-btn' onclick=\"document.getElementById('cf_id').value='{$record['cf_id']}';\"/></td>
            </td></tr>"; 
    echo "</tbody></table>"; ?>
      
      <div id="postbtn">
        <input type="submit" value="Save" id="savebtn" name="<?php echo ($is_adding ? "save_new" : "save"); ?>" class="update-btn">
        <input type="submit" value="Cancel" id="cancelbtn" name="cancel" class="update-btn" onclick=location.href='<?php echo JURI::base() . 'marketing-listing-vic'; ?>' />
        <input type="hidden" value="Delete" id="delbtnAll" name="delbtnAll" class="update-btn" onclick="return confirm('Are you sure you want to delete this item?');">
      </div>
    </form>
    </div>

<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/lightbox.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/jquery-ui-1.11.4/jquery-ui.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/custom.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/system-maintenance.css'; ?>" />

<script src="<?php echo JURI::base() . 'jscript/jquery.min.js'; ?>"></script>
<script src="<?php echo JURI::base() . 'jscript/jquery-ui-1.11.4/jquery-ui.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'jscript/lightbox.js'; ?>"></script>
<SCRIPT language="javascript">

  $(document).ready(function() {
    // $("#cbo_year > #year").focus();
    const months = {
      '0': 'January',
      '1': 'February',
      '2': 'March',
      '3': 'April',
      '4': 'May',
      '5': 'June',
      '6': 'July',
      '7': 'August',
      '8': 'September',
      '9': 'October',
      '10': 'November',
      '11': 'December'      
    }

    $("#cbo_year > #year").on('change', function(e) {  
      let year = this.value;  
      if (year != null || year != ''){        
        year_param = "&year="+year;
        $("#cbo_month > #marketing_date").focus();
      }
      console.log(year);
    });

    $("#cbo_month > #marketing_date").on('change', function(e) {  
      let month = this.value;
      var year = $("#cbo_year > #year").val();
      var monthyear = months[month] +'-'+ year;
      var _month = months[month];
      $("#month").val(month);
      $("#monthName").val(_month);
      $("#selected_month").val(_month);
      if (year != null || year != ''){        
        year_param = "&year="+year;
      }
        
      if (month != null || month != ''){        
        month_param = "&month="+_month;
        monthyear_param = "monthyear="+monthyear;
        location.href = "<?php echo JURI::base(); ?>marketing-listing-vic/marketing-updatelist-vic?"+monthyear_param+year_param+month_param;
        $("#cbo_category > #category_source").focus();
      }

      $("#monthyear").val(monthyear);
      console.log(year);
      console.log(months[month]);
      console.log(_month);
      console.log(monthyear);
    });

    $("#cbo_category > #category_source").on('change', function(e) {    
      let category = this.value;
      var month1 = $("#month").val();
      var month = $("#monthName").val();
      var selected_month = $("#selected_month").val();
      var year = $("#cbo_year > #year").val();
      var monthyear = month +'-'+ year;
      var _month = months[month];
      $("#monthyear").val(monthyear);
      if ($("#monthyear").val() != null || $("#monthyear").val() != ''){
      }

      if (year != null || year != ''){        
        year_param = "&year="+year;
        if (month != null || month != ''){        
          month_param = "&month="+month;
          monthyear_param = "&monthyear="+monthyear;
        }
      }

      if (month != null || month != ''){        
        month_param = "&month="+month;
      }

      $("#selected_category").val(category);
      $("#category").val(category);

      console.log(category);
      console.log(month);
      location.href = "<?php echo JURI::base(); ?>marketing-listing-vic/marketing-updatelist-vic?category="+category+monthyear_param+year_param+month_param;
    });

     
    $("#cbo_marketing_source > #marketing_source").on('change', function(e) {          
      let source = this.value;
      var selected_source_cf_id = $('#cbo_marketing_source > #marketing_source').find('option[value="' + source + '"]').attr('id');
      var category = $("#cbo_category > #category_source").val();
      var month = $("#monthName").val();
      var year = $("#cbo_year > #year").val();
      var monthyear = month +'-'+ year;
      if (year != null || year != ''){        
        year_param = "&year="+year;
        if (month != null || month != ''){        
          month_param = "&month="+month;
          monthyear_param = "&monthyear="+monthyear;
        }
      }
      if (category != null || category != ''){        
        category_param = "&category="+category;
      }
      if (selected_source_cf_id != null || selected_source_cf_id != ''){        
        mid_param = "&mid="+selected_source_cf_id;
      }
      $("#_source").val(source);
      $("#m_source").val(source);
      $("#selected_source_cf_id").val(selected_source_cf_id);
      $("#selected_source").val(source);
      $("#input_marketing_source").val(source);
      $("#Marketing_Source").val(source);       
      $("#source").val(source);
      console.log(source);
      location.href = "<?php echo JURI::base(); ?>marketing-listing-vic/marketing-updatelist-vic?source="+source+category_param+monthyear_param+year_param+month_param+mid_param;
    });

    $("#cbo_lead_source > #lead_source").on('change', function(e) {  
      let lead = this.value;  
      $("#_lead").val(lead);
      console.log(lead);
    });

    $("#savebtn").on('click', function(e) {
      var month = $("#month").val();
      var year = $("#cbo_year > #year").val();
      var monthyear = month +'-'+ year;
      if (year != null || year != ''){        
        year_param = "&year="+year;
      }
        
      if (month != null || month != ''){        
        month_param = "&month="+month;
        monthyear_param = "monthyear="+monthyear;
      }
      // $("#cbo_category > #category_source").val() = "";
      // $("#cbo_marketing_source > #marketing_source").val() = "";
      // alert(monthyear_param);
      // location.href = "<?php echo JURI::base(); ?>marketing-listing-vic/marketing-updatelist-vic?"+monthyear_param;
      console.log(monthyear);
    });


});     
    

    


    

    



    

    
    

    

  </SCRIPT>
  <!-- <h2><?php if ($is_adding) echo "Add";  ?> Marketing</h2> -->
  <?php if (strlen($notification) > 0) {
    echo "<div class='notification_result'>{$notification}</div>";
  }