<?php

$next_increment = 0;
$qShowStatus = "SHOW TABLE STATUS LIKE 'ver_chronoforms_data_inventory_vic'";
$qShowStatusResult = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
$row = mysql_fetch_assoc($qShowStatusResult);
$next_increment = $row['Auto_increment'];
$getinventoryid = 'IRV'.$next_increment;
$_section = ""; 
$is_adding = 0;
$has_error = 0;
$notification = "";

if(isset($_POST['delbtn']))
{ 
  //error_log("INSIDE cf_id: ".$_POST['cf_id'], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  $id= mysql_real_escape_string($_POST['inventoryid']); 

  $sql = "SELECT COUNT(*) AS n FROM ver_vergola_default_framework_items  WHERE inventoryid='{$id}' ";
  //error_log( $sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');  
  $result = mysql_query($sql); 
  $d = mysql_fetch_assoc($result);

  if($d['n']>0){
    $has_error = 1;
    $notification = "Sorry, can't delete a linked inventory item."; 
  }

  $sql = "SELECT COUNT(*) AS n FROM ver_chronoforms_data_quote_vic AS q  WHERE q.cf_id > 216646 AND q.inventoryid='{$id}' ";

  $result = mysql_query($sql); 
  $d = mysql_fetch_assoc($result);

  if($d['n']>0){
    $has_error = 1;
    $notification = "Sorry, can't delete a linked inventory item."; 
  }

  $sql = "SELECT COUNT(*) AS n FROM ver_chronoforms_data_contract_items_vic  WHERE  inventoryid='{$id}' ";
  $result = mysql_query($sql); 
  $d = mysql_fetch_assoc($result);

  if($d['n']>0){
    $has_error = 1;
    $notification = "Sorry, can't delete a linked inventory item."; 
  }


  if($has_error==0){
    mysql_query("DELETE from ver_chronoforms_data_inventory_material_vic WHERE inventoryid = '$id'")
          or die(mysql_error()); 
    echo "Deleted";
    
    mysql_query("DELETE from ver_chronoforms_data_inventory_vic WHERE inventoryid = '$id'")
          or die(mysql_error()); 
    echo "Deleted";
    header('Location:'.JURI::base().'system-management-vic/inventory-listing-vic'); 
  } 
    
      
}


if(isset($_POST['save']) || isset($_POST['save_new']))
{  

  if(isset($_POST['save_new'])){
     
  }else{
    $id = mysql_real_escape_string($_POST['inventoryid']);
    // $id = mysql_real_escape_string($_REQUEST['inventoryid']); 
  }
//error_log("ID: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');

    $target = "images/inventory/"; 
    $target = $target . basename( $_FILES['photo']['name']); 

    $total_cost = $_POST['rawcost']; 
     //This gets all the other information from the form 
    $section_save = $_POST['section'] ;
    $category_save = $_POST['category'];
    $name_save=$_POST['name']; 
    $uom_save = $_POST['uom'];
    $rrp_save = $_POST['rrp'];
    $cost_save = $_POST['totalcost'] + array_sum($total_cost);
    $pic_save=($_FILES['photo']['size'] > 0?$_FILES['photo']['name']:'');

     
    //Updates the information to the database  
    if (isset($_POST['save'])) { 
      if ($pic_save != '' || $pic_save != 0){
        $sql = "UPDATE `ver_chronoforms_data_inventory_vic` SET   
          inventoryid = '$id',
          section ='$section_save', 
          category ='$category_save',  
          description ='$name_save', 
          photo ='$pic_save', 
          uom ='$uom_save',
          rrp ='$rrp_save', 
          cost ='$cost_save'
           
          WHERE inventoryid = '$id'";
        //error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
        mysql_query($sql) or die(mysql_error()); //echo "Saved! #a"; 
        }else{
          // echo ("Do not update photo");
		  $sql = "UPDATE `ver_chronoforms_data_inventory_vic` SET   
			 inventoryid = '$id',
			 section ='$section_save', 
			 category ='$category_save',  
			 description ='$name_save', 
			 -- photo ='$pic_save',  
			 uom ='$uom_save',
			 rrp ='$rrp_save', 
			 cost ='$cost_save'         
			 WHERE inventoryid = '$id'";

			 mysql_query($sql) or die(mysql_error()); //echo "Saved! #a"; 
        
		}
    }

    if (isset($_POST['save_new'])) { 
      $next_increment = 0;
      $qShowStatus = "SHOW TABLE STATUS LIKE 'ver_chronoforms_data_inventory_vic'";
      $qShowStatusResult = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
      $row = mysql_fetch_assoc($qShowStatusResult);
      $next_increment = $row['Auto_increment'];
      $getinventoryid = 'IRV'.$next_increment;

      $section_save = $_POST['section'];
      $sql = "INSERT INTO `ver_chronoforms_data_inventory_vic`(inventoryid, section, category, description, photo, uom, rrp) VALUES('{$getinventoryid}', '{$section_save}', '{$category_save}', '{$name_save}', '{$pic_save}', '{$uom_save}', '{$rrp_save}')";
      
      mysql_query($sql) or die(mysql_error()); //echo "Saved! #0"; 
      
      $CFID = mysql_insert_id();
      $id = $getinventoryid;
      $InventoryID = $getinventoryid;
      $inventoryid = $getinventoryid;
    

    }    

    // if ($_FILES['photo']['size']!= 0  && $Photo!="") { 
    //   $sql = "UPDATE `ver_chronoforms_data_inventory_vic` SET 
         
    //     inventoryid = '$id',
    //     section ='$section_save', 
    //     category ='$category_save', 
    //     description ='$name_save', 
    //     photo ='$pic_save', 
    //     uom ='$uom_save',
    //       rrp ='$rrp_save', 
    //     cost ='$cost_save'
         
    //     WHERE inventoryid = '$id'";
    //   //error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
    //   mysql_query($sql) or die(mysql_error()); echo "Saved! #1"; 
    // }else {
    //   $sql = "UPDATE `ver_chronoforms_data_inventory_vic` SET 
        
    //   inventoryid = '$id',
    //   section ='$section_save', 
    //   category ='$category_save', 
    //   description ='$name_save', 
    //   photo ='$Photo', 
    //   uom ='$uom_save',
    //     rrp ='$rrp_save', 
    //   cost ='$cost_save'
       
    //   WHERE inventoryid = '$id'";
    // // error_log("with ERROR: ".$sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    //  mysql_query($sql);// or die(mysql_error()); echo "Saved! #2";
    // }

 
   //error_log(print_r($_FILES,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    //Writes the photo to the server 
    if($_FILES['photo']['size']!= 0) 
    {  
      //Tells you if its all ok 
      //echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded, and your information has been added to the directory"; 
      if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){
        //$notification = "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded, and your information has been added to the directory";
      }else {  
        //Gives and error if its not 
        $notification = "Sorry, there was a problem uploading your file."; 
     } 
      //
    }

    //error_log(print_r($_POST,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    $rawdesc = implode(", ", $_POST['rawdesc']);
    $cnt = count($_POST['raw_material_id']);
     
    $queryn = "DELETE FROM ver_chronoforms_data_inventory_material_vic WHERE inventoryid='{$id}' ";
    //error_log($queryn, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    mysql_query($queryn);


    if ($cnt > 0) {
        $insertArr = array();
        
      for ($i=0; $i<$cnt; $i++) { 
            //$rawinvqty = mysql_real_escape_string($_POST['raw_qty'][$i]);
            //$rawinvcost = mysql_real_escape_string($_POST['raw_cost'][$i]);

            //$insertArr[] = "('{$id}', '" . mysql_real_escape_string($_POST['raw_material_id'][$i]) . "')";
            $insertArr[] = "('{$id}', '" . mysql_real_escape_string($_POST['raw_material_id'][$i]) . "', '" . mysql_real_escape_string($_POST['raw_invqty'][$i]) . "', '" . mysql_real_escape_string($_POST['raw_invcost'][$i]) . "')"; 
      }


     //$queryn = "INSERT INTO ver_chronoforms_data_inventory_material_vic (inventoryid, materialid) VALUES " . implode(", ", $insertArr);
     $queryn = "INSERT INTO ver_chronoforms_data_inventory_material_vic (inventoryid, materialid, inv_qty, inv_extcost) VALUES " . implode(", ", $insertArr);     
     // error_log($queryn, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
     mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error());

     $notification = "Successfully saved..";
    }
  
  //header('Location:'.JURI::base().'system-management-vic/inventory-listing-vic/inventory-updatelist-vic?inventoryid='.$id);   
}
//error_log("ID2: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');


// Begin delete image function
if (isset($_POST['delete-pic'])) {
    $id = mysql_real_escape_string($_POST['inventoryid']);
    //if ($photo!='')
    //{      
      $sql = "UPDATE `ver_chronoforms_data_inventory_vic` SET           
        photo = ''
        WHERE inventoryid = '$id'";
      //error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
      mysql_query($sql) or die(mysql_error()); $notification = "Image file has been deleted."; 
      //echo "Image file has been successfully Deleted!"; 


    //}else
}
// End delete image function



if(isset($_REQUEST['section'])){
  $_section = $_REQUEST['section'];
}

if(isset($_REQUEST['inventoryid']) && strlen($_REQUEST['inventoryid'])>0){
  //error_log("inside 1: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  //view inventory item based on request
  $inventoryid = mysql_real_escape_string($_REQUEST['inventoryid']);
  $id = mysql_real_escape_string($_REQUEST['inventoryid']);
}else if(!empty($id)){
  //error_log("inside 2: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  //view item after adding.
  $is_adding = 0;
}else{
  //error_log("inside 3: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  $is_adding = 1;
  $Section = $_section;
}

//error_log("ID3: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
//Get record for update inventory item..
if(!empty($id) && $is_adding==0){ 
  //error_log("here 1: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
  if($inventoryid>0 || $id>0 ){

  }else{
    $cf_id = $_REQUEST['cf_id'];
  }
$sql = "SELECT * FROM ver_chronoforms_data_inventory_vic WHERE inventoryid  = '$id'";  
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
$result = mysql_query($sql);


$retrieve = mysql_fetch_array($result);
if (!$result) 
    {
    die("Error: Data not found..");
    } 
  
  // Inventory Details
  $CFID = $retrieve['cf_id'];       
  $InventoryID = $retrieve['inventoryid'];

  $Section = (empty($_section)?$retrieve['section']:$_section);
  $Category = $retrieve['category'] ;
  $Description = $retrieve['description'];          
  $UOM = $retrieve['uom'] ;
  $RRP = $retrieve['rrp'] ; 
  $Cost = $retrieve['cost'] ;
  $Photo = $retrieve['photo'];

}else{
  //error_log("here 2: ".$id, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
} 

if(isset($_POST['duplicate']))
{  
    $target = "images/"; 
    $target = $target . basename( $_FILES['photo']['name']); 

    $total_cost = $_POST['rawcost']; 
     //This gets all the other information from the form 
    $section = $_POST['section'] ;
    $category = $_POST['category'];
    $name=$_POST['name']; 
    $uom = $_POST['uom'];
    $rrp = $_POST['rrp'];
    $cost = $_POST['totalcost'] + array_sum($total_cost);
    $pic=$Photo; 
     
    //Writes the information to the database 
    if($supplier_id !=$SupplierID) {

    mysql_query("INSERT INTO `ver_chronoforms_data_inventory_vic` (cf_id, inventoryid, section, category, description, photo, uom, rrp, cost) VALUES (NULL, '$id', '$section', '$category', '$name', '$pic', '$uom', '$rrp', '$cost')") ; 

    $rawdesc_ret = implode(", ", $_POST['rawdesc_ret']);
    $cnt_ret = count($_POST['rawcost_ret']);
    $cnt2_ret = count($_POST['rawdesc_ret']);

     
    $rawdesc = implode(", ", $_POST['rawdesc']);
    $cnt = count($_POST['rawcost']);
    $cnt2 = count($_POST['rawdesc']);



    if ($cnt > 0 && $cnt == $cnt2 && $rawdesc != '') {
        $insertArr = array();
        
      for ($i=0; $i<$cnt; $i++) {

            $insertArr[] = "('$id', '" . mysql_real_escape_string($_POST['rawdesc'][$i]) . "', '" . mysql_real_escape_string($_POST['rawcost'][$i]) . "')";
      }


     $queryn = "INSERT INTO ver_chronoforms_data_materials_vic (inventoryid, raw_description, raw_cost) VALUES " . implode(", ", $insertArr);

     mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error()); }


    if ($cnt_ret > 0 && $cnt_ret == $cnt2_ret && $rawdesc_ret != '') {
        $insertArr_ret = array();
        
      for ($i=0; $i<$cnt_ret; $i++) {

            $insertArr_ret[] = "('$id', '" . mysql_real_escape_string($_POST['rawdesc_ret'][$i]) . "', '" . mysql_real_escape_string($_POST['rawcost_ret'][$i]) . "')";
    }


     $queryn_ret = "INSERT INTO ver_chronoforms_data_materials_vic (inventoryid, raw_description, raw_cost) VALUES " . implode(", ", $insertArr_ret);
     
     mysql_query($queryn_ret) or trigger_error("Insert failed: " . mysql_error()); }

    }

    header('Location:'.JURI::base().'system-management-vic/inventory-listing-vic/inventory-updatelist-vic?inventoryid='.$id); 

}
 


if(isset($_POST['save_dimension']))
{ 
  $id = mysql_real_escape_string($_POST['id']);
  $inventoryid = mysql_real_escape_string($_POST['inventoryid']);
  $length_inch = mysql_real_escape_string($_POST['length_inch']);
  $dimension_a_inch = mysql_real_escape_string($_POST['dimension_a_inch']);
  $dimension_b_inch = mysql_real_escape_string($_POST['dimension_b_inch']);
  $dimension_c_inch = mysql_real_escape_string($_POST['dimension_c_inch']);
  $dimension_d_inch = mysql_real_escape_string($_POST['dimension_d_inch']);
  $dimension_e_inch = mysql_real_escape_string($_POST['dimension_e_inch']);
  $dimension_f_inch = mysql_real_escape_string($_POST['dimension_f_inch']);
  $dimension_g_inch = mysql_real_escape_string($_POST['dimension_g_inch']);
  $dimension_h_inch = mysql_real_escape_string($_POST['dimension_h_inch']);
  $dimension_p_inch = mysql_real_escape_string($_POST['dimension_p_inch']);

  $dimension_a_fraction = mysql_real_escape_string($_POST['dimension_a_fraction']);
  $dimension_b_fraction = mysql_real_escape_string($_POST['dimension_b_fraction']);
  $dimension_c_fraction = mysql_real_escape_string($_POST['dimension_c_fraction']);
  $dimension_d_fraction = mysql_real_escape_string($_POST['dimension_d_fraction']);
  $dimension_e_fraction = mysql_real_escape_string($_POST['dimension_e_fraction']);
  $dimension_f_fraction = mysql_real_escape_string($_POST['dimension_f_fraction']);
  $dimension_g_fraction = mysql_real_escape_string($_POST['dimension_g_fraction']);
  $dimension_h_fraction = mysql_real_escape_string($_POST['dimension_h_fraction']);
  $dimension_p_fraction = mysql_real_escape_string($_POST['dimension_p_fraction']);

  if (isset($_POST['id']) && strlen($_POST['id']) > 0) {
    $queryn = "UPDATE ver_chronoforms_data_contract_items_default_deminsions 
      SET inventoryid='{$inventoryid}', 
      length_inch={$length_inch}, 
      dimension_a_inch={$dimension_a_inch}, 
      dimension_b_inch={$dimension_b_inch}, 
      dimension_c_inch={$dimension_c_inch}, 
      dimension_d_inch={$dimension_d_inch}, 
      dimension_e_inch={$dimension_e_inch}, 
      dimension_f_inch={$dimension_f_inch},
      dimension_g_inch={$dimension_g_inch},
      dimension_h_inch={$dimension_h_inch}, 
      dimension_p_inch={$dimension_p_inch}, 
      dimension_a_fraction='{$dimension_a_fraction}', 
      dimension_b_fraction='{$dimension_b_fraction}', 
      dimension_c_fraction='{$dimension_c_fraction}', 
      dimension_d_fraction='{$dimension_d_fraction}', 
      dimension_e_fraction='{$dimension_e_fraction}', 
      dimension_f_fraction='{$dimension_f_fraction}',
      dimension_g_fraction='{$dimension_g_fraction}',
      dimension_h_fraction='{$dimension_h_fraction}', 
      dimension_p_fraction='{$dimension_p_fraction}' 
      WHERE id={$id}
    ";
  } else {
    $queryn = "INSERT INTO ver_chronoforms_data_contract_items_default_deminsions 
      SET inventoryid='{$inventoryid}', 
      length_inch={$length_inch}, 
      dimension_a_inch={$dimension_a_inch}, 
      dimension_b_inch={$dimension_b_inch}, 
      dimension_c_inch={$dimension_c_inch}, 
      dimension_d_inch={$dimension_d_inch}, 
      dimension_e_inch={$dimension_e_inch}, 
      dimension_f_inch={$dimension_f_inch},
      dimension_g_inch={$dimension_g_inch},
      dimension_h_inch={$dimension_h_inch}, 
      dimension_p_inch={$dimension_p_inch}, 
      dimension_a_fraction='{$dimension_a_fraction}', 
      dimension_b_fraction='{$dimension_b_fraction}', 
      dimension_c_fraction='{$dimension_c_fraction}', 
      dimension_d_fraction='{$dimension_d_fraction}', 
      dimension_e_fraction='{$dimension_e_fraction}', 
      dimension_f_fraction='{$dimension_f_fraction}',
      dimension_g_fraction='{$dimension_g_fraction}',
      dimension_h_fraction='{$dimension_h_fraction}', 
      dimension_p_fraction='{$dimension_p_fraction}'
    ";
  }

   mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error());
   header('Location:'.JURI::base().'system-management-vic/inventory-listing-vic/inventory-updatelist-vic?inventoryid='.$inventoryid);
   //header('Content-Type: application/json'); 
   //$arr = array ('message'=>'successfully deleted','result'=>1);
   //echo json_encode($arr);
   // echo "1";
   // exit;
}



// if(isset($_POST['delete']))
// {  
//     $raw_id = $_POST['raw_id'];
//  mysql_query("DELETE from ver_chronoforms_data_materials_vic WHERE cf_id = '$raw_id'")
//        or die(mysql_error()); 
//  echo "Deleted";
  
      
// }




if(isset($_POST['cancel']))
{ 
  header('Location:'.JURI::base().'system-management-vic/inventory-listing-vic');     
}

// if(isset($_POST['update']))
// {  
    
//  $rawid = $_POST['raw_id'];
//  $rawdesc_retrieve = $_POST['rawdesc_update'];
//  $rawcost_retrieve = $_POST['rawcost_update'];
//  $total_raw = $_POST['rawcost_ret'];
//  $total_rawcost = array_sum($total_raw);

//  mysql_query("UPDATE ver_chronoforms_data_materials_vic SET raw_description = '$rawdesc_retrieve', raw_cost = '$rawcost_retrieve' WHERE cf_id = '$rawid'")
//        or die(mysql_error()); 
//  echo "Saved!";
  
//  mysql_query("UPDATE ver_chronoforms_data_inventory_vic SET cost = '$total_rawcost' WHERE inventoryid = '$InventoryID'")
//        or die(mysql_error()); 
//  echo "Saved!";
    
// }

?>

<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/lightbox.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/jquery-ui-1.11.4/jquery-ui.css'; ?>" />  
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/custom.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/system-maintenance.css'; ?>" />
<!--
<script src="<?php echo JURI::base().'jscript/jsapi.js'; ?>"></script>
<script src="<?php echo JURI::base().'jscript/jquery.min.js'; ?>"></script>
<script src="<?php echo JURI::base().'jscript/jquery-ui.min.js'; ?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo JURI::base().'jscript/custom.css'; ?>" />
-->

<script src="<?php echo JURI::base().'jscript/jquery.min.js'; ?>"></script>
<script src="<?php echo JURI::base().'jscript/jquery-ui-1.11.4/jquery-ui.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo JURI::base().'jscript/lightbox.js'; ?>"></script>
<SCRIPT language="javascript">

 function change_section(){
      var section = $("#section option:selected").val();
      var inventoryid = $("#inventoryid").val();
      var inv_param = "";
      if(inventoryid.length>0){
        inv_param = "&inventoryid="+inventoryid;
      }

      location.href = "<?php echo JURI::base(); ?>system-management-vic/inventory-listing-vic/inventory-updatelist-vic?section="+section+inv_param;
  }


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
 

  function addRow(tableID) {

      var table = document.getElementById(tableID);

      var rowCount = table.rows.length;
      var row = table.insertRow(rowCount);

      var colCount = table.rows[0].cells.length;

      for(var i=0; i<colCount; i++) {

          var newcell = row.insertCell(i);

          newcell.innerHTML = table.rows[0].cells[i].innerHTML;
          //alert(newcell.childNodes);
          switch(newcell.childNodes[0].type) {
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

      for(var i=0; i<rowCount; i++) {
          var row = table.rows[i];

          var chkbox = row.cells[0].childNodes[0];
          if(null != chkbox && true == chkbox.checked) {
              if(rowCount <= 1) {
                  alert("Cannot delete all the rows.");
                  break;
              }
              table.deleteRow(i);
              rowCount--;
              i--;
          }


      }
      }catch(e) {
          alert(e);
      }
  }
 

</SCRIPT>
<h2><?php if($is_adding) echo "Add";  ?> Inventory</h2>
<?php if(strlen($notification)>0){echo "<div class='notification_result'>{$notification}</div>";} ?>
<div id="notification" class="notification_box hide"  ></div>
<form method="post"  enctype="multipart/form-data">
  <input type='hidden' name='inventoryid' id='inventoryid' value='<?php echo $inventoryid; ?>' />
  <input type='hidden' name='cf_id' id='cf_id' value='<?php echo $CFID; ?>' />
  <table class="inventory-table">
    <tr>
      <th>Section</th>
      <th>Categories</th>
      <th>Description</th>
      <th>UOM</th>
      <th width="100">RRP Price</th>
      <th></th>
    </tr>
    <tr>
      <td class="sec">
        <select name="section" onchange="change_section()" id="section">
          <option value=""></option>
          <?php
           $sql = "SELECT * FROM ver_chronoforms_data_section_vic GROUP BY section ORDER BY section";
           $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
              while ($sect = mysql_fetch_assoc($sql_result)) { 
                echo "<option value='".$sect["section"]."'".($sect["section"]==$Section ? " selected='selected'" : "").">".$sect["section"]."</option>"; } ?>
        </select>
      </td>
      <td class="cat">
        <select name="category" id="category">
          <?php 
           $sql = "SELECT * FROM ver_chronoforms_data_section_vic WHERE section='{$Section}' ORDER BY category";
           $sql_result = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
              while ($cat = mysql_fetch_assoc($sql_result)) { 
                echo "<option value='".$cat["category"]."'".($cat["category"]==$Category ? " selected='selected'" : "").">".$cat["category"]."</option>"; } 
          ?>
        </select></td>
      <td class="desc"><input type="text" id="desc" name="name" value="<?php echo htmlspecialchars($Description); ?>"></td>
      <!-- <td class="uom"><select name="uom"> <option value="Ea" <?php echo ($UOM=="Ea"?"selected":""); ?> >Ea</option><option value="Mtrs" <?php echo ($UOM=="Mtrs"?"selected":""); ?>>Mtrs</option></select> </td> -->
      <td class="uom"><select name="uom"> <option value="Ea" <?php echo ($UOM=="Ea"?"selected":""); ?> >Ea</option><option value="Inches" <?php echo ($UOM=="Inches"?"selected":""); ?>>Inches</option></select> </td>
      <td class="rrp"><input type="text" id="rrp" name="rrp" value="<?php echo $RRP; ?>"></td>
    </tr>
  </table>
  <div id="matcontainer">
    
   <?php
    $qitem = mysql_query("SELECT * FROM ver_chronoforms_data_inventory_vic WHERE inventoryid = '$InventoryID' ");
    $inv_item=mysql_fetch_assoc($qitem);
    //error_log(print_r($inv_item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    if($inv_item["section"]=="Guttering" || $inv_item["section"]=="Flashings"){
    ?>
      <INPUT type="button" class="del-section" name="set_dimension" value="Set default dimension" onclick="$('#default_dimension_box').dialog({
        minWidth: 790,maxWidth: 1090,
      });$('#default_dimension_box').dialog();" />
    <?php
    } 
    ?>

     
   
    
<!-- <input type="hidden" id="raw_id" name="raw_id" value=""/>
<input type="hidden" id="rawdesc_update" name="rawdesc_update" value=""/>
<input type="hidden" id="rawcost_update" name="rawcost_update" value=""/> -->
<input type="hidden" name="inventory_id" value="<?php echo $InventoryID; ?>"/>

    <table id="tbl-retrieve">
    <tr>
        <th  ><img src="<?php echo JURI::base()."images/trashcan_delete.png"; ?>" class="del" /> Raw Materials</th> 
        <th  ><span style="margin:0;">Qty</span></th> 
        <th  ><span style="margin:0;">Cost</span></th> 
		    <th  ><span style="margin-left:12px; width:80px;">Ext Cost</span></th> 
      </tr>
          <?php

$qry = "SELECT ms.id, ms.inventoryid,ms.materialid, ms.inv_qty , ms.inv_extcost,(ms.inv_qty * ms.inv_extcost) AS extended_cost, m.supplierid, m.raw_description, m.qty, m.raw_cost, s.company_name FROM ver_chronoforms_data_inventory_material_vic AS ms  LEFT JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id=materialid LEFT JOIN ver_chronoforms_data_supplier_vic AS s ON m.supplierid=s.supplierid WHERE ms.inventoryid = '$InventoryID'   ";          
//error_log($qry, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
$resultmat = mysql_query($qry);
if (!$resultmat) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
  $j=0; $k=0; $l=0; $m=0;
  while($row = mysql_fetch_assoc($resultmat))
  {  
echo '<tr>      
    <td class="tbl-desc"><input type="text" id="rawdesc_ret'.$j++.'" name="rawdesc_ret[]" value="'.htmlspecialchars($row['raw_description']).'" readonly /> <input type="hidden" name="raw_material_id[]" value="'.$row["materialid"].'" /> <input type="hidden" name="supplier_id[]" value="'.$row["supplierid"].'" /></td><td class="tbl-desc"><input style="margin-left:10px; width:80px;" readonly name="raw_invqty[]" value="'.$row["inv_qty"].'" /></td></td><input type="hidden" style="margin-left:10px; width:80px;" readonly name="raw_invcost[]" value="'.$row["inv_extcost"].'" />';

    echo "<td class=\"tbl-qty\" style=\"display:none;\"><input type=\"hidden;\" id=\"rawqty_ret".$l++."\" name=\"rawqty_ret[]\" value=\"{$row['qty']}\" readonly /></td>
    
    <td  class=\"tbl-desc\"><input style=\"margin-left:10px; width:80px;\" id=\"rawcost_ret".$l++."\" name=\"rawcost_ret[]\" value=\"{$row['raw_cost']}\" readonly /></td>
    <td class=\"tbl-cost\"><input id=\"rawinvcost_ret".$l++."\" name=\"rawinvcost_ret[]\" value=\"{$row['inv_extcost']}\" readonly /></td>
    <td class=\"tbl-desc\" style=\"display:none;\"><input type=\"hidden;\" id=\"rawextendedcost_ret".$l++."\" name=\"rawextendedcost_ret[]\" value=\"{$row['extended_cost']}\" readonly /></td>
    <td class=\"tbl-desc\" style=\"display:none;\"><input type=\"text\" id=\"rawcost_ret".$l++."\" name=\"rawcost_ret[]\" value=\"".$row['company_name']."\"  readonly /></td>
    <td class=\"btnupdate\">  <INPUT type=\"button\" value=\"Delete\" onclick=\"remove_raw_meterial(event,this)\" style=\"margin:0 0 0 5px;\" /></td>   
    </tr>";
  }
?>
</table>

<?php
   
  $result = mysql_query("SELECT * FROM ver_chronoforms_data_supplier_vic ");
    
  $suppliers = array();
  $cbo_suppliers = '<select id=\"suppliers\" style=\"padding:3px; margin:0 0 0 10px;\" >';
  while ($row = mysql_fetch_assoc($result)) { 
      $cbo_suppliers .= '<option value=\"'.$row['supplierid'].' >'.$row['company_name'].'</option>'; 
  } 
  $cbo_suppliers .='</select>';
   

  //error_log(print_r($raw_materials,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
 
?>


    <table id="tbl-raw" style="margin-top:15px;">
      <tr>
        <td><span style="  margin:0 0 0 12px; font-weight:bold;">Add Raw Matrial</span></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
       
        <td class="tbl-desc"><input type="text" id="raw_desc" name="raw_desc" value="" style="width:240px; margin:0 0 0 12px;"  placeholder="Type raw material"  > 
        <input type="hidden" id="raw_material_id" name="" value=""   >         
        <td class=" "><input type="text" id="raw_invqty" value="" class=" " style="width: 80px; margin-left: 12px;">         
        <input type="hidden" id="raw_qty" name="raw_qty" value="" class=" "> </td> 
        <td class=" "><input type="text" id="raw_cost" name="raw_cost" value="" class=" " style="width: 80px; margin-left: 10px;"> </td> 
        <!-- <td class=" "><td><input type="text" id="raw_invcost" value="" class=" " style="width: 80px; margin-left: 12px;"></td></td> -->
        <td class="tbl-add" style="">

            <INPUT type="button" value="Add Raw Material" onclick="add_raw_meterial(event,this)" style="margin:0 0 0 10px;" />
            
        </td>
      </tr>
      <tr>
        
        <td class="tbl-desc" style="text-align:right; padding: 8px;"> <span style="font-size:14px; font-weight:bold; margin-top:5px;">Total Cost :</span></td>
        <td class=" " style="text-align:left;"><span id="lbl_total_cost"  style="font-size:14px; font-weight:bold; margin-left:15px;"></span> </td>
        <td class="tbl-add" style=""> </td>
        <td class="tbl-add" style=""> </td>
      </tr>
    </table>
  </div>

 <!--  <div class="sum">
  </div> -->
  <div id="img-container">
  
  <h2>Image File</h2>
  
  <?php 
  if ($Photo!='') {
  echo "  
  <img src='".JURI::base()."images/inventory/".$Photo."' class='imgup' />
  ";
  } else { echo "<img src=".JURI::base()."images/vergola_inventory.png"." "."class='imgup'>";}?>
  
  <!-- Begin Code for deleting the picture -->
  <INPUT type="submit" name="delete-pic" value="Delete Picture"   />
  <input type="hidden" value="" id="picid" name="picid" />
  <!-- End Code for deleting the picture -->

  <br />
    <input type="file" id="uploadimg" name="photo" >
  </div>
  <div id="postbtn">
    <input type="submit" value="Save" id="savebtn" name="<?php echo ($is_adding?"save_new":"save"); ?>" class="update-btn">
    

    <input type="submit" value="Cancel" id="cancelbtn" name="cancel" class="update-btn" onclick=location.href='<?php echo JURI::base().'system-management-vic/inventory-listing-vic'; ?>' />
    <!--<input type="submit" value="Duplicate" id="dupebtn" name="duplicate" class="update-btn">-->
    <input type="submit" value="Delete" id="delbtn" name="delbtn" class="update-btn" onclick="return confirm('Are you sure you want to delete this item?');" >
  </div>
</form>


 <?php
    function generateFractionHTMLSelectBox($ref_name, $selected_value) {
      $fractions_list = '[
            {"ref_name":"1/32", "display_name":"1/32", "display_order":"1"}, 
            {"ref_name":"2/32", "display_name":"1/16", "display_order":"2"}, 
            {"ref_name":"3/32", "display_name":"3/32", "display_order":"3"}, 
            {"ref_name":"4/32", "display_name":"1/8", "display_order":"4"}, 
            {"ref_name":"5/32", "display_name":"5/32", "display_order":"5"}, 
            {"ref_name":"6/32", "display_name":"6/32", "display_order":"6"}, 
            {"ref_name":"7/32", "display_name":"7/32", "display_order":"7"}, 
            {"ref_name":"8/32", "display_name":"1/4", "display_order":"8"}, 
            {"ref_name":"9/32", "display_name":"9/32", "display_order":"9"}, 
            {"ref_name":"10/32", "display_name":"10/32", "display_order":"10"}, 
            {"ref_name":"11/32", "display_name":"11/32", "display_order":"11"}, 
            {"ref_name":"12/32", "display_name":"3/8", "display_order":"12"}, 
            {"ref_name":"13/32", "display_name":"13/32", "display_order":"13"}, 
            {"ref_name":"14/32", "display_name":"14/32", "display_order":"14"}, 
            {"ref_name":"15/32", "display_name":"15/32", "display_order":"15"}, 
            {"ref_name":"16/32", "display_name":"1/2", "display_order":"16"}, 
            {"ref_name":"17/32", "display_name":"17/32", "display_order":"17"}, 
            {"ref_name":"18/32", "display_name":"18/32", "display_order":"18"}, 
            {"ref_name":"19/32", "display_name":"19/32", "display_order":"19"}, 
            {"ref_name":"20/32", "display_name":"5/8", "display_order":"20"}, 
            {"ref_name":"21/32", "display_name":"21/32", "display_order":"21"}, 
            {"ref_name":"22/32", "display_name":"22/32", "display_order":"22"}, 
            {"ref_name":"23/32", "display_name":"23/32", "display_order":"23"}, 
            {"ref_name":"24/32", "display_name":"3/4", "display_order":"24"}, 
            {"ref_name":"25/32", "display_name":"25/32", "display_order":"25"}, 
            {"ref_name":"26/32", "display_name":"26/32", "display_order":"26"}, 
            {"ref_name":"27/32", "display_name":"27/32", "display_order":"27"}, 
            {"ref_name":"28/32", "display_name":"7/8", "display_order":"28"}, 
            {"ref_name":"29/32", "display_name":"29/32", "display_order":"29"}, 
            {"ref_name":"30/32", "display_name":"30/32", "display_order":"30"}, 
            {"ref_name":"31/32", "display_name":"31/32", "display_order":"31"}
      ]';
      $fractions_list = json_decode($fractions_list, true);


      $html_select_box_template = '
        <select id="[REF_NAME]" name="[REF_NAME]">
          <option value="">-- select --</option>
          [OPTIONS_LIST]
        </select>
      ';
      $html_select_box_option_template = '<option [SELECTED_TAG] value="[OPTION_VALUE]">[OPTION_TEXT]</option>';
      $html_select_box = '';
      $selected_tag = '';

      foreach ($fractions_list as $key1 => $value1) {
        $selected_tag = '';
        if ($value1['ref_name'] == $selected_value) {
          $selected_tag = 'selected';
        }
        $html_select_box .= str_replace(
          array('[SELECTED_TAG]', '[OPTION_VALUE]', '[OPTION_TEXT]'), 
          array($selected_tag, $value1['ref_name'], $value1['display_name']), 
          $html_select_box_option_template
        );
      }

      $html_select_box = str_replace(
        array('[REF_NAME]', '[OPTIONS_LIST]'), 
        array($ref_name, $html_select_box), 
        $html_select_box_template
      );

      return $html_select_box;
    }


    $qitem = mysql_query("SELECT * FROM ver_chronoforms_data_contract_items_default_deminsions WHERE inventoryid = '$InventoryID' ");
    $item=mysql_fetch_assoc($qitem);

?>

<div id="default_dimension_box" style="display:none; width:100%;" title="Default Dimension">
<form method="post" id="default_dimension_form" enctype="multipart/form-data">

  <table style="margin:5px 0 10px 0; width:760px" cellpadding="5" cellspacing="5">
  <tr><th> </th><th>A</th><th>B</th><th>C</th><th>D</th><th>E</th><th>F</th><th>G</th><th>H</th><th>P</th></tr>
  <tr>
      <td>
        <?php
          $default_dimension_length_inch = 0;
          if (isset($item["length_inch"]) && is_numeric($item["length_inch"])) {
            $default_dimension_length_inch = $item["length_inch"];
          }
          echo "<input type='hidden' value='{$item["id"]}' name='id' />";
          echo "<input type='hidden' value='{$InventoryID}' name='inventoryid' />";
          echo "<input type='hidden' value='{$default_dimension_length_inch}' name='length_inch' />";
          echo "<!-- <input type='text' name='length' value='{$item["length"]}' style='display:none;' /> --></td>
                    <td><input type='text' name='dimension_a_inch' value='{$item["dimension_a_inch"]}' /></td>
                    <td><input type='text' name='dimension_b_inch' value='{$item["dimension_b_inch"]}' /></td>
                    <td><input type='text' name='dimension_c_inch' value='{$item["dimension_c_inch"]}' /></td>
                    <td><input type='text' name='dimension_d_inch' value='{$item["dimension_d_inch"]}' /></td>
                    <td><input type='text' name='dimension_e_inch' value='{$item["dimension_e_inch"]}' /></td>
                    <td><input type='text' name='dimension_f_inch' value='{$item["dimension_f_inch"]}' /></td>
                    <td><input type='text' name='dimension_g_inch' value='{$item["dimension_g_inch"]}' /></td>
                    <td><input type='text' name='dimension_h_inch' value='{$item["dimension_h_inch"]}' /></td>
                    <td><input type='text' name='dimension_p_inch' value='{$item["dimension_p_inch"]}' /></td>
                ";
        ?>
      </tr>  
  <tr>
      <td>
        <?php
          echo "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_a_fraction', $item["dimension_a_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_b_fraction', $item["dimension_b_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_c_fraction', $item["dimension_c_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_d_fraction', $item["dimension_d_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_e_fraction', $item["dimension_e_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_f_fraction', $item["dimension_f_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_g_fraction', $item["dimension_g_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_h_fraction', $item["dimension_h_fraction"]) . "</td>
                    <td>" . generateFractionHTMLSelectBox('dimension_p_fraction', $item["dimension_p_fraction"]) . "</td>
                ";
        ?>
      </tr>  
  </table>
  <input type='submit' value='Save' name="save_dimension"   />
  <input type='button' value='Cancel' onclick="$(this).closest('.ui-dialog-content').dialog( 'close' );" />
</form>

<script type="text/javascript">
  <?php
    $result1 = mysql_query("SELECT cf_id, raw_description, qty, raw_cost FROM ver_chronoforms_data_materials_vic ");
    $result = mysql_query("SELECT m.cf_id, m.raw_description, m.qty, m.raw_cost, ms.inv_qty, ms.inv_extcost, (ms.inv_qty * ms.inv_extcost) AS extended_cost FROM ver_chronoforms_data_materials_vic AS m LEFT JOIN ver_chronoforms_data_inventory_material_vic AS ms ON ms.materialid=m.cf_id");
    
	$materials = array();
    while ($row = mysql_fetch_assoc($result)) {
    
        // Adding the necessary "value" and "label" fields and appending to result set
        $row_array['value'] = $row['raw_description'];
        $row_array['label'] = $row['raw_description'];
        $row_array['cf_id'] = $row['cf_id'];  
        $row_array['raw_description'] = $row['raw_description'];
        $row_array['raw_qty'] = $row['qty'];
        $row_array['raw_cost'] = $row['raw_cost'];

        $row_array['raw_invqty'] = $row['invqty'];
        $row_array['raw_extcost'] = $row['raw_extcost'];
        $row_array['extended_cost'] = $row['extended_cost'];
        array_push($materials,$row_array);
        
    } 
    //error_log(print_r($materials,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    // Truncate, encode and return the results
    //$matches = array_slice($matches, 0, 5);
    echo "var materials = ".json_encode($materials);


  ?>

  $(document).ready(function(){  
       $("#raw_desc").val("");
        $("#raw_cost").val("");

       var client_config = {
      source: materials,
        select: function(event, ui){
            
            $("#raw_material_id").val(ui.item.cf_id);
            $("#raw_invqty").val(ui.item.raw_qty);
            $("#raw_invcost").val(ui.item.raw_cost);
            $("#raw_desc").val(ui.item.raw_description);
            $("#raw_qty").val(ui.item.raw_qty);
            $("#raw_cost").val(ui.item.raw_cost);

            $("#extended_cost").val(ui.item.extended_cost);
        //     $("#csuburbpostcode").val(ui.item.suburb_postcode);
        // $("#csuburb_id").val(ui.item.cf_id);  
        },
        minLength:1
      };
      
       $("#raw_desc").autocomplete(client_config);
      
      //recompute the total cost.
      var total_cost = 0.00; var qty = 0; var cost=0;
      $(".tbl-cost input").each(function(){
          qty = parseFloat($(this).parent().parent().children('.tbl-qty').children('input').val());
          cost = parseFloat($(this).val()); 
          //total_cost += qty * cost; 
          total_cost += cost; 
          // if (qty > 1){            
          // total_cost +=  cost/qty; }
          // else{
          // total_cost +=  cost; }
      });

      $("#lbl_total_cost").html(total_cost.toFixed(2));

   });

   


   function setDefaultDimension(){
    //event.preventDefault();
     
    var action = $(this).closest('form').attr('action');
    //var action = "<?php echo JURI::base(); ?>";   
    var iData = $(this).closest('form').serialize(); 
     
    //var id = $(o).closest('form').children("table").children("tbody").children("tr").find("input.cf_id").val();
    $(this).closest('form').children("table").children("tbody").children("tr").find("input.cf_id").val();
    var id = $(this).closest('form').children("table").children("tbody").children("tr").find("input.cf_id").val();//children("input.cf_id").val();
    //alert(id); return;
    //console.log(iData);return; 
     
    $.ajax({
      type: "POST",
      url: action,
      dataType: 'json',   
      data: iData,  
      success: function(data) {         
        // alert(data); 
        // if(data["success"]==1){
        //   $(this).dialog("close");
        // }else{
        //   alert("Error while saving");
        // }
      }   
    });    


   }


   function add_raw_meterial(event,o){
    event.preventDefault();
    var tr="";
    var raw_description = $("#raw_desc").val();
    var raw_material_id =  $("#raw_material_id").val();

    if(raw_description.length<1 && raw_material_id.length<1){
        //notification_body

        $("#notification").html("Please choose a raw material in the dropdown list.");   
          //$("#notification").appendTo("."+dataClass+" .notification-area");
          $("#notification").removeClass('hide');  
          $("#notification").show(); 
          setTimeout(function() {
                $( "#notification" ).hide( "slow" );
          }, 7000);

          
          $("#raw_desc").css({ "border-color": "red"});
          $("#raw_desc").one("change",function(){ $(this).css({ "border-color": "#4d4c4c"}); });
          $("#raw_desc").focus(); 
          return;
    }

    var raw_invqty = $("#raw_invqty").val();
    var raw_invcost = $("#raw_invcost").val();
    var raw_qty = $("#raw_qty").val();
    var raw_cost = $("#raw_cost").val();
    //var extended_cost = raw_invqty * raw_cost;
    var extended_cost = parseFloat(raw_invqty * raw_cost).toFixed(2);
    var supplier_name = $("#suppliers option:selected").text();
    //var supplier_id = $("#suppliers option:selected").val();

    //extended_cost = $("#extended_cost").val(extended_cost.toFixed(2));
    tr = "<tr><td class='tbl-desc'><input type='text' value='"+raw_description+"' /><input type='hidden' value='"+raw_material_id+"' name='raw_material_id[]' /><td class='tbl-desc'><input type='text'style='margin-left:10px; width:80px;' value='"+raw_invqty+"' name='raw_invqty[]' /></td> <td class='tbl-qty1' style=\"display:none;\"><input type='hidden'style='margin-left:10px; width:80px;' value='"+raw_qty+"' /> </td> <td class='tbl-desc'><input type='text' style='margin-left:10px; width:80px;' value='"+raw_cost+"' /> </td> <td class='tbl-cost'><input type='text' value='"+extended_cost+"' name='raw_invcost[]' /></td> <input type='hidden'><input type='hidden' value='"+extended_cost+"' name='extended_cost[]' /><td><input type='button' value='Delete' onclick='remove_raw_meterial(event,this)' style='margin:0 0 0 5px;' /></td> </tr>";

    $("#tbl-retrieve tr:last").after(tr);

    $("#raw_desc").val("");
    $("#raw_material_id").val("");
    $("#raw_invqty").val("");
    $("#raw_invcost").val("");
    $("#raw_qty").val("");
    $("#raw_cost").val("");
    $("#extended_cost").val("");

    var total_cost = 0.00; var qty = 0; var cost=0;
    $(".tbl-cost input").each(function(){
        qty = parseFloat($(this).parent().parent().children('.tbl-qty').children('input').val());

        cost = parseFloat($(this).val());  
        //total_cost +=  qty*cost; 
        // if (qty > 1){
        //   total_cost +=  cost/qty; }
        // else{
        total_cost +=  cost; 
    });


    $("#lbl_total_cost").html(total_cost.toFixed(2));

    if($("#section option:selected").val()=="Disbursements" || $("#section option:selected").val()=="Extras" || $("#section option:selected").val()=="Misc"){

    }else{
      total_cost = total_cost*2; 
    }
    
    $("#rrp").val(total_cost.toFixed(2));
    
    
    

   }


   function remove_raw_meterial(event,o){
      
     // alert($(o).closest('tr').html());
      $(o).closest('tr').remove();

      var total_cost = 0.00;
      $(".tbl-cost input").each(function(){
          total_cost += parseFloat($(this).val()); 
      });
      $("#lbl_total_cost").html(total_cost.toFixed(2));
      
      if($("#section option:selected").val()=="Disbursements"){

      }else{
        total_cost = total_cost*2; 
      }
      
      $("#rrp").val(total_cost.toFixed(2));

   } 



  //alert("here");

</script>
</div>

 
