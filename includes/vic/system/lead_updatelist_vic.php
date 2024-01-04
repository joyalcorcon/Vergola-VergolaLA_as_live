<!-- Begin -->

<?php  
@$cat=$_GET['cat']; // Use this line or below line if register_global is off
//@$cat=$HTTP_GET_VARS['cat']; // Use this line or above line if register_global is off
/*
If register_global is off in your server then after reloading of the page to get the value of cat from query string we have to take special care.
*/
$db = JFactory::getDbo();
$id =$_REQUEST['cf_id'];
$cf_id =$_REQUEST['cf_id'];
$category_cf_id =$_REQUEST['cf_id'];
// $source_cf_id =$_REQUEST['cf_id'];
$source_cf_id =$_REQUEST['source_cf_id'];
$lead_cf_id =$_REQUEST['cf_id'];
$selected_source_cf_id = $_REQUEST['mid'];
// $_source_cf_id = $_REQUEST['source_cf_id'];



// $result = mysql_query("SELECT * FROM ver_chronoforms_data_lead_vic WHERE cf_id  = '$id'");
$result = mysql_query("SELECT l.lead,mc.section as category,mc.category as marketing_source,l.cf_id,l.marketing_id FROM ver_chronoforms_data_lead_vic AS l LEFT JOIN ver_chronoforms_data_marketing_category_vic AS mc ON mc.cf_id=l.marketing_id WHERE 1=1 AND l.cf_id  = '$cf_id'");
$retrieve = mysql_fetch_array($result);
if (!$result) 
    {
    die("Error: Data not found..");
    }  

  $Category=$retrieve['category'] ;  
  $Marketing_Source=$retrieve['marketing_source'] ;
  $Marketing_Lead=$retrieve['lead'] ;

  $selected_category=$retrieve['category'] ;
  $selected_source=$retrieve['marketing_source'] ;
  $selected_lead=$retrieve['lead'] ;

  


        
if(isset($_REQUEST['category_source'])){
  $_category = $_REQUEST['category_source'];
  $c_source = $_REQUEST['category_source'];
}

if(isset($_REQUEST['marketing_source'])){
  $_source = $_REQUEST['marketing_source'];
  $m_source = $_REQUEST['marketing_source'];
}

if(isset($_REQUEST['lead_source'])){
  $_lead = $_REQUEST['lead_source'];
  $l_source = $_REQUEST['lead_source'];
}

if(isset($_REQUEST['category'])){
  $is_addCategory = $_REQUEST['is_addCategory'];
  $c_source = $_REQUEST['category'];
  $selected_category = $_REQUEST['category'];
  // echo ($selected_category);
  if (($is_addCategory) || empty($c_source) || is_null($c_source)){
    // header('Location:'.JURI::base().'system-management-vic/lead-listing-vic/lead-vic');
  }
}

if(isset($_REQUEST['source'])){
  $is_addSource = $_REQUEST['is_addSource'];
  $m_source = $_REQUEST['source'];
  $selected_source = $_REQUEST['source'];
  // echo ($selected_source);
  if (($is_addSource) || empty($m_source) || is_null($m_source)){
    // header('Location:'.JURI::base().'system-management-vic/lead-listing-vic/lead-vic');
  }
}

if(isset($_REQUEST['lead'])){
  $is_addLead = $_REQUEST['is_addLead'];
  // $m_lead = $_REQUEST['lead'];
  $l_source = $_REQUEST['lead'];  
  $selected_lead = $_REQUEST['lead'];
  // echo ($selected_lead);
  if (($is_addLead) || empty($l_source) || is_null($l_source)){
    // header('Location:'.JURI::base().'system-management-vic/lead-listing-vic/lead-vic');
  }
}

// $_REQUEST['category_source'];
if(isset($_POST['category_source'])){ 
  $_selected_category = $_POST['category_source'];
}
if(isset($_POST['is_addCategory'])){ 
}
if(isset($_POST['is_addSource'])){ 
}
if(isset($_POST['is_addLead'])){ 
}

if(isset($_POST['save']))
{ 
  $category_save = $_POST['category_source'];
  $marketing_save = $_POST['marketing_source'];
  $lead_save = $_POST['lead_source'];
  $marketingid_save = $selected_source_cf_id;

  if(is_addCategory){
    $category_save = $_POST['input_category'];
  }

  if(is_addSource){
    $marketing_save = $_POST['input_marketing_source'];
  }

  if(is_addLead){
    $lead_save = $_POST['input_lead_source'];
  }  

  // mysql_query("INSERT INTO ver_chronoforms_data_lead_vic (marketing_source,lead) 
  // VALUES ('$marketing_save','$lead_save')")
  //       or die(mysql_error()); 
  // echo "Saved!";

  if(empty($id) && $is_adding==0){ 
    // if($is_adding==0){

    // $sql = "SELECT * FROM ver_chronoforms_data_lead_vic WHERE category  = '$category_save'";  
    // //error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    // $result = mysql_query($sql);


    // $retrieve = mysql_fetch_array($result);
    // if (!$result) {
    //     // die("Error: Data not found..");
    //     mysql_query("INSERT INTO ver_chronoforms_data_lead_vic (category, marketing_source, lead) 
    //     VALUES ('$category_save','$marketing_save','$lead_save')")
    //           or die(mysql_error()); 
    //     echo "Saved!";
    //     // $notification = "Successfully updated..";
         
    //   }else{
    //     die("Error: Record already exist..");
    //     // $notification = "Error: Record already exist..";

    //   //error_log("here 2: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    // }

      mysql_query("INSERT INTO ver_chronoforms_data_lead_vic (category, marketing_source, lead, marketing_id) 
      VALUES ('$category_save','$marketing_save','$lead_save','$marketingid_save')")
            or die(mysql_error()); 
      echo "Saved!";
    }else{
        mysql_query("UPDATE ver_chronoforms_data_lead_vic SET category ='$category_save', marketing_source ='$marketing_save', lead ='$lead_save', marketing_id ='$marketingid_save' WHERE cf_id = '{$id}' ")
              or die(mysql_error()); 
        $notification = "Successfully updated..";
    }

  header('Location:'.JURI::base().'system-management-vic/lead-listing-vic');    
}

if(isset($_POST['delete']))
{ 
  mysql_query("UPDATE ver_chronoforms_data_lead_vic SET active = 0 WHERE cf_id = '$id'")
        or die(mysql_error()); 
  echo "Deleted";
  
  header('Location:'.JURI::base().'system-management-vic/lead-listing-vic');    
}

if(isset($_POST['cancel']))
{ 
  header('Location:'.JURI::base().'system-management-vic/lead-listing-vic');      
}

// -----------------

// if(isset($_REQUEST['source'])){
//   $_section = $_REQUEST['source'];
// }

if(isset($_REQUEST['marketingid']) && strlen($_REQUEST['marketingid'])>0){
  //error_log("inside 1: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  //view inventory item based on request
  $marketingid = mysql_real_escape_string($_REQUEST['marketingid']);
  $id = mysql_real_escape_string($_REQUEST['marketingid']);
}else if(!empty($id)){
  //error_log("inside 2: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  //view item after adding.
  $is_adding = 0;
}else{
  //error_log("inside 3: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  $is_adding = 1;
  $Section = $_section;
}

if(!empty($id) && $is_adding==0){ 
// if(!empty($id) && $is_adding==1){   
  //error_log("here 1: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  if($marketingid>0 || $id>0 ){

  }else{
    $cf_id = $_REQUEST['cf_id'];
  }
$sql = "SELECT * FROM ver_chronoforms_data_lead_vic WHERE cf_id  = '$id'";  
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
$result = mysql_query($sql);


$retrieve = mysql_fetch_array($result);
if (!$result) 
    {
    die("Error: Data not found..");
    } 
  
  // Inventory Details
  $CFID = $retrieve['cf_id'];       
  $LeadID = $retrieve['cf_id'];
  $MarketingID = $retrieve['marketing_id'];

  // $Marketing_Source = (empty($_source)?$retrieve['section']:$_source);

  $Category = $retrieve['category'] ;
  $Marketing_Source = $retrieve['marketing_source'] ;
  $Marketing_Lead = $retrieve['lead'] ;
}else{
  //error_log("here 2: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
} 

// -----------------
?>


<!-- <form method="post"> -->

<?php if (strlen($notification) > 0) {
  // echo "<div class='notification_result'>{$notification}</div>";
} 
  // echo $m_source;
  // echo "<div class='notification_result'>{$m_source}</div>";
  // echo "<div class='notification_result'>{$is_adding}</div>";
  
?>
<?php if(strlen($notification)>0){echo "<div class='notification_result'>{$notification}</div>";} ?>
<h2><?php if(!$is_adding) echo "Edit"; else echo "Add";  ?> Marketing Marketing Leads </h2>
<div id="notification" class="notification_box hide"  ></div>
<input type='hidden' name='is_adding' id='is_adding' value='<?php echo $is_adding; ?>' />
<input type='hidden' name='id' id='id' value='<?php echo $cf_id; ?>' />
<input type='hidden' name='cf_id' id='cf_id' value='<?php echo $cf_id; ?>' />
<input type='hidden' name='source_cf_id' id='source_cf_id' value='<?php echo $selected_source_cf_id; ?>' />
<input type='hidden' name='lead_cf_id' id='lead_cf_id' value='<?php echo $lead_cf_id; ?>' />
<input type='hidden' name='is_addSource' id='is_addSource' value='<?php echo $is_addSource; ?>' />
<input type='hidden' name='_source' id='_source' value='<?php echo $_source; ?>' />
<input type='hidden' name='m_source' id='m_source' value='<?php echo $m_source; ?>' />
<input type='hidden' name='Marketing_Source' id='Marketing_Source' value='<?php echo $Marketing_Source; ?>' />
<input type='hidden' name='Category' id='Category' value='<?php echo $Category; ?>' />
<input type='hidden' name='l_source' id='l_source' value='<?php echo $l_source; ?>' />
<input type='hidden' name='marketing_source' id='marketing_source' value='<?php echo $l_source; ?>' />
<input type='hidden' name='category' id='category' value='<?php echo $l_source; ?>' />
<input type='hidden' name='source' id='source' value='<?php echo $source; ?>' />
<input type='hidden' name='_selected_category' id='_selected_category' value='<?php echo $_selected_category; ?>' />

<!-- <form class="Chronoform hasValidation" method="post" id="chronoform_Lead_Vic" action="<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic">   -->
<form method="post"  enctype="multipart/form-data">
<table class="update-table">
    <tr>
    <td class="row1">Category</td>
    <td class="row2">
      <input type="text" name="input_category" id="input_category" value="<?php echo $Category ?>"/>
      <div id="cbo_category">
        <select class="suburb-list" name="category_source" id="category_source" >
          <option value=""></option>
          <?php
           // $sql = "SELECT * FROM ver_chronoforms_data_lead_vic WHERE category != '' GROUP BY category ORDER BY category ASC";
          // $sql = "SELECT * FROM ver_chronoforms_data_marketing_category_vic WHERE section != '' GROUP BY section ORDER BY category ASC";
          $sql = "SELECT distinct section as category, sectionid FROM ver_chronoforms_data_marketing_category_vic WHERE 1=1 ORDER BY section ASC";
           $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);

              while ($src = mysql_fetch_assoc($sql_result)) { 
                echo "<option value='".$src["category"]."'".($src["category"]==$selected_category ? " selected='selected'" : "").">".$src["category"]."</option>"; } ?>
        </select>          
      </div>
    </td>
    <td class="row2" style="width: 800px; padding-left: 6%;visibility: hidden;">
      <label class="input productionstart">
        <input type="hidden" id="category_cf_id" name="" value="">      
        <input style="margin: 0 0 0 -350px;width: 22px;" type="checkbox" name="chkboxCategory" id="chkboxCategory">
        <span class="visible" style="padding-right: -151px;">Check the box to manually type category </span>
      </label>
    </td>    
  </tr>
    <tr>
    <td class="row1">Marketing Source</td>
    <td class="row2">
      <input type="text" name="input_marketing_source" id="input_marketing_source" value="<?php echo $Marketing_Source ?>"/>
      <div id="cbo_marketing_source">        
        <select class="suburb-list" name="marketing_source" id="marketing_source" >
          <option value=""></option>
          <?php
           // $sql = "SELECT * FROM ver_chronoforms_data_lead_vic WHERE marketing_source != '' GROUP BY marketing_source ORDER BY marketing_source ASC";
           $sql = "SELECT distinct category as marketing_source, sectionid FROM ver_chronoforms_data_marketing_category_vic WHERE 1=1 ORDER BY section ASC";
           if (!empty($selected_category) || $selected_category != '') {
              // $_sel_cat = "section = '$selected_category' AND";
              $sql = "SELECT distinct category as marketing_source, sectionid, cf_id AS source_cf_id FROM ver_chronoforms_data_marketing_category_vic WHERE section = '$selected_category' AND 1=1 ORDER BY section ASC";
           }            
           // $sql = "SELECT distinct category as marketing_source, sectionid FROM ver_chronoforms_data_marketing_category_vic WHERE '{$_sel_cat}' 1=1 ORDER BY section ASC";
           // echo $sql;
           $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
              while ($src = mysql_fetch_assoc($sql_result)) { 
                echo "<option id='".$selected_source_cf_id=$src["source_cf_id"]."' value='".$src["marketing_source"]."'".($src["marketing_source"]==$selected_source ? " selected='selected'" : "").">".$src["marketing_source"]." </option>"; } 
                if (!empty($src["marketing_source"]) || $src["marketing_source"] != '') {
                  // $source_cf_id = $src["source_cf_id"];
                }
                ?>
        </select>          
      </div>
    </td>
    <td class="row2" style="width: 800px; padding-left: 6%;visibility: hidden;">
      <label class="input productionstart">
        <input type="hidden" id="" name="" value="<?php echo $source_cf_id ?>">      
        <input style="margin: 0 0 0 -350px;width: 22px;" type="checkbox" name="chkboxSource" id="chkboxSource">
        <span class="visible" style="padding-right: -151px;">Check the box to manually type marketing source </span>
      </label>
    </td>    
  </tr>
   <tr>
    <td class="row1">Lead Source</td>
    <td class="row2">
      <input type="text" name="input_lead_source" id="input_lead_source" style="<?php if($is_adding) echo ""; else echo "display: none;";  ?>" value="<?php echo $Marketing_Lead ?>"/>    
      <div id="cbo_lead_source" >
        <option value=""></option>
        <select class="suburb-list" name="lead_source" id="lead_source" style="<?php if($is_adding) echo "display: none;"; else echo "";  ?>">
          <?php 
            $sql = "SELECT * FROM ver_chronoforms_data_lead_vic ORDER BY lead ASC";
            $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
              while ($_lead = mysql_fetch_assoc($sql_result)) { 
                echo "<option value='".$_lead["lead"]."'".($_lead["lead"]==$selected_lead ? " selected='selected'" : "").">".$_lead["lead"]."</option>"; } ?>
        </select>
      </div>
    </td>
    <td class="row2" style="width: 800px; padding-left: 6%; visibility: hidden;">
      <label class="input productionstart">
        <input type="hidden" id="lead_cf_id" name="" value="">      
        <input type="checkbox" name="chkboxLead" id="chkboxLead" style="margin: 0 0 0 -350px;width: 22px;" >
        <span class="visible" style="padding-right: -151px;">Check the box to manually type lead source </span>
      </label>
    </td>  
  </tr>

  <tr>
    <td class="row1">&nbsp;</td>
    <td class="row2"><input type="submit" name="save" value="Save" class="update-btn" /> <input type="submit" name="delete" value="Delete" class="update-btn" /> <input type="submit" name="cancel" value="Cancel" class="update-btn" /></td>
  </tr>
</table>

<!-- End -->




<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/lightbox.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/jquery-ui-1.11.4/jquery-ui.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/custom.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base() . 'jscript/system-maintenance.css'; ?>" />
<script src="<?php echo JURI::base() . 'jscript/jquery.min.js'; ?>"></script>
<script src="<?php echo JURI::base() . 'jscript/jquery-ui-1.11.4/jquery-ui.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'jscript/lightbox.js'; ?>"></script>
<script type="text/javascript">

<?php
  $category_result = mysql_query("SELECT * FROM `ver_chronoforms_data_lead_vic` WHERE category <> '' GROUP BY category");
  $category = array();
  while ($row = mysql_fetch_assoc($category_result)) {
    $row_array['value'] = $row['category'];
    $row_array['label'] = $row['category'];
    $row_array['category_cf_id'] = $row['cf_id'];
    $row_array['category'] = $row['category'];
    array_push($category, $row_array);
  }
  echo "var category = " . json_encode($category);
?>

<?php
  $result = mysql_query("SELECT * FROM `ver_chronoforms_data_lead_vic` WHERE marketing_source <> '' GROUP BY marketing_source");
  $source = array();
  while ($row = mysql_fetch_assoc($result)) {
    $row_array['value'] = $row['marketing_source'];
    $row_array['label'] = $row['marketing_source'];
    $row_array['market_cf_id'] = $row['cf_id'];
    $row_array['marketing_source'] = $row['marketing_source'];
    array_push($source, $row_array);
  }
  echo "var source = " . json_encode($source);
?>

<?php
  $result = mysql_query("SELECT * FROM `ver_chronoforms_data_lead_vic` ORDER BY lead ASC");
  $lead = array();
  while ($row = mysql_fetch_assoc($result)) {
    $row_array['value'] = $row['lead'];
    $row_array['label'] = $row['lead'];
    $row_array['lead_cf_id'] = $row['cf_id'];
    $row_array['lead'] = $row['lead'];
    array_push($lead, $row_array);
  }
  echo "var lead = " . json_encode($lead);
?>

$(document).ready(function() {
  // $("#is_addSource").val("0");
  // document.getElementById("input_lead_source").style.display = 'block';
  // document.getElementById("input_marketing_source").style.display = 'block';
  // $("#raw_lead").val("");
  // document.getElementById("is_addSource").val;
  // document.getElementById("input_marketing_source").style.display = 'none';
  $("#input_category").hide();
  $("#input_marketing_source").hide();
  // $("#input_lead_source").hide();
  if ($("#is_adding")){
    // $("#input_lead_source").hide();
  }
  

  $("#input_category").autocomplete({
      source: category,
  });

  $("#input_marketing_source").autocomplete({
      source: source,
  });

  $("#input_lead_source").autocomplete({
      source: lead,
  });
    // var source_config = {
    //   source: source,
    //   select: function(event, ui) {

    //     $("#source_cf_id").val(ui.item.id);
    //     $("#marketing_source").val(ui.item.marketing_source);
    //   },
    //   minLength: 1
    // };
    // $("#input_marketing_source").autocomplete(source_config);
    // $("#input_lead_source").autocomplete(source_config);
    // if (source_config && source_config.length > 0) {
    //     console.log('myArray is not empty.');
    // }else{
    //     console.log('myArray is empty.');
    // }
  // });  
// };

// $("#input_lead_source").autocomplete({
//     source: lead,
// });
// 
  // var lead_config = {
  //   source: lead_config,
  //   select: function(event, ui) {

  //     $("#lead_cf_id").val(ui.item.id);
  //     $("#lead").val(ui.item.lead);
  //   },
  //   minLength: 1
  // };
  // $("#input_lead_source").autocomplete(lead_config);
  // $("#input_lead_source").autocomplete(source_config);
  // if (source_config && source_config.length > 0) {
  //     console.log('myArray is not empty.');
  // }else{
  //     console.log('myArray is empty.');
  // }

});

  function showdrop()
  {
       var section=$("#section").val();   // get the value of currently selected section
       $.ajax({
      type:"post",
      dataType:"text",
      data:"section="+section,
      url:"<?php echo JURI::base().'includes/vic/category_vic.php'; ?>",         // page to which the ajax request is passed
      success:function(response)
      {
               $("#category").html(response);   // set the result to category dropdown
       $("#category").show();
      }
  })


  }

  $(function() {

    $("#input_category").on('blur', function(e) {  
      let category = this.value;
      var category_cf_id = $("#category_cf_id").val();
      // var category = $("#category option:selected").val("");
      $("#c_source").val(category);
      $("#cbo_category > #category_source").val(category);
      $("#category").val(category);
      console.log(category);
      if(category_cf_id.length>0){
        src_param = "&cf_id="+category_cf_id;
      }
      // location.href = "<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic?source="+source+src_param;
    });
  
    $("#input_marketing_source").on('blur', function(e) {  
      let source = this.value;
      var source_cf_id = $("#source_cf_id").val();
      // var marketing_source = $("#marketing_source option:selected").val("");
      $("#m_source").val(source);
      $("#cbo_marketing_source > #marketing_source").val(source);
      $("#source").val(source);
      console.log(source);
      if(source_cf_id.length>0){
        src_param = "&cf_id="+source_cf_id;
      }
      // location.href = "<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic?source="+source+src_param;
    });

    $("#input_lead_source").on('blur', function(e) {  
      let lead = this.value;
      // var cf_id = $("#cf_id").val();
      // var marketing_source = $("#marketing_source option:selected").val("");
      var lead_cf_id = $("#lead_cf_id").val();
      $("#l_source").val(lead);
      $("#cbo_lead_source > #mlead_source").val(lead);
      $("#lead").val(lead);
      console.log(lead);
      if(lead_cf_id.length>0){
        src_param = "&cf_id="+lead_cf_id;
      }
      // location.href = "<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic?source="+source+src_param;
    });    

    $("#chkboxCategory").on('change', function(e) {    
      // let is_addCategory = this.checked;
      let is_addCategory = document.getElementById('chkboxCategory').checked
      console.log(is_addCategory); 
      if (document.getElementById('chkboxCategory').checked) {
          document.getElementById("input_category").style.display = 'block';
          document.getElementById("cbo_category").style.display = 'none';
          $("#is_addCategory").val("1");
          // var category = $("#cbo_category > #category").val("");                    
      } else {
        document.getElementById("input_category").style.display = 'none';
        document.getElementById("cbo_category").style.display = 'block';
        $("#is_addCategory").val("0");
        // var marketing_source = $("#cbo_marketing_source > #marketing_source").val();
      }
    });

    $("#chkboxSource").on('change', function(e) {    
      // let is_addSource = this.checked;
      let is_addSource = document.getElementById('chkboxSource').checked
      console.log(is_addSource); 
      if (document.getElementById('chkboxSource').checked) {
          document.getElementById("input_marketing_source").style.display = 'block';
          document.getElementById("cbo_marketing_source").style.display = 'none';
          $("#is_addSource").val("1");
          // var marketing_source = $("#cbo_marketing_source > #marketing_source").val("");                    
      } else {
        document.getElementById("input_marketing_source").style.display = 'none';
        document.getElementById("cbo_marketing_source").style.display = 'block';
        $("#is_addSource").val("0");
        // var marketing_source = $("#cbo_marketing_source > #marketing_source").val();
      }
    });


    $("#chkboxLead").on('change', function(e) {    
      // let is_addLead = this.checked;
      let is_addLead = document.getElementById('chkboxLead').checked
      console.log(is_addLead); 
      if (document.getElementById('chkboxLead').checked) {
          document.getElementById("input_lead_source").style.display = 'block';
          document.getElementById("cbo_lead_source").style.display = 'none';
          $("#is_addLead").val("1");
          // var lead_source = $("#cbo_lead_source > #lead_source").val("");
      } else {
        document.getElementById("input_lead_source").style.display = 'none';
        document.getElementById("cbo_lead_source").style.display = 'block';
        $("#is_addLead").val("0");
        // var lead_source = $("#cbo_lead_source > #lead_source").val();
      }
    });


    $("#cbo_category > #category_source").on('change', function(e) {    
      let category = this.value;
      var category_cf_id = $("#category_cf_id").val();
      var cf_id = $("#cf_id").val();
      var is_addCategory = $("#is_addCategory").val();
      var src_param = "";
      if(category_cf_id.length>0){
        src_param = "&cf_id="+category_cf_id;
      }
      if(cf_id.length>0){
        cf_id_param = "&cf_id="+cf_id;
      }else{
        cf_id_param = "";
      }
      if (category != null || category != ''){        
        category_param = "&category="+category;
      }
      $("#_category").val(category);
      $("#c_source").val(category);

      $("#selected_category").val(category);
      $("#input_category").val(category);
      $("#Category").val(category);       
      $("#category").val(category);
      console.log(category_cf_id);
      // location.href = "<?php echo JURI::base(); ?>marketing-listing-vic/marketing-updatelist-vic?category="+category+monthyear_param+year_param+month_param;
      location.href = "<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic?"+cf_id_param+category_param;
    });

    $("#cbo_marketing_source > #marketing_source").on('change', function(e) {    
      let source = this.value;
      var category = $("#cbo_category > #category_source").val();
      var cf_id = $("#cf_id").val();
      var source_cf_id = $("#source_cf_id").val();      

      // var marketing_source_cf_id = this.source_cf_id;
      var source0 = $("#cbo_marketing_source > #marketing_source").value;
      var is_addSource = $("#is_addSource").val();
      var src_param = "";
      // var val = document.getElementById('txt_name').value;
      // var selected_source_cf_id = $('#cbo_marketing_source > #marketing_source').find('option[value="' + source + '"]').attr('id');
      var selected_source_cf_id = $('#cbo_marketing_source > #marketing_source').find('option[value="' + source + '"]').attr('id');
      // alert(text);
      if(source_cf_id.length>0){
        src_param = "&cf_id="+source_cf_id;
      }
      if(cf_id.length>0){
        cf_id_param = "&cf_id="+cf_id;
      }else{
        cf_id_param = "";
      }
      if (category != null || category != ''){        
        category_param = "&category="+category;
      }
      if (source != null || source != ''){        
        source_param = "&source="+source;
      }
      if (selected_source_cf_id != null || selected_source_cf_id != ''){        
        mid_param = "&mid="+selected_source_cf_id;
      }
      $("#_source").val(source);
      $("#m_source").val(source);

      $("#selected_source").val(source);
      $("#input_marketing_source").val(source);
      $("#Marketing_Source").val(source);       
      $("#Selected_Marketing_ID").val(selected_source_cf_id);
      $("#source").val(source);
      console.log(selected_source_cf_id);
      location.href = "<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic?"+cf_id_param+category_param+source_param+mid_param;
      // location.href = "<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic?source="+source+src_param;
    });

    $("#cbo_lead_source > #lead_source").on('change', function(e) {  
    let lead = this.value;  
      var lead_cf_id = $("#lead_cf_id").val();
      var is_addLead = $("#is_addLead").val();
      var src_param = "";
      if(lead_cf_id.length>0){
        src_param = "&cf_id="+lead_cf_id;
      }
      $("#_lead").val(lead);
      $("#l_source").val(lead);
      console.log(lead);
      // location.href = "<?php echo JURI::base(); ?>system-management-vic/lead-listing-vic/lead-updatelist-vic?lead="+lead+src_param;
    });
});

  </script>  