<?php
$print_section = "";
if(isset($_GET["print_section"])){
	$print_section = $_GET["print_section"];
}

$QuoteID = 0;
if(isset($_REQUEST['pid']))
	$QuoteID =$_REQUEST['pid'];

$QuoteIDAlpha = substr($QuoteID, 0, 3);
$current_date = date('Y-m-d H:i:s');

//error_log($QuoteIDAlpha, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
if(isset($_POST['add']))
{	
    $template_clientid=$_POST['clientid'];
	$template_title=$_POST['title'] ; 
	$template_content=$_POST['htmlcontent'] ;
    
	 
	mysql_query("INSERT INTO ver_chronoforms_data_letters_vic (clientid, template_name, datecreated, template_content) 
		 VALUES ('$template_clientid','$template_title', '$current_date', '$template_content')"); 

	
	//$_GET['section'] = 'frame'; 
	//header("Location: ". JURI::base() . $_SERVER['REDIRECT_URI'] . '?' . http_build_query($_GET)); 		
    // echo('<script language="Javascript">opener.window.location.reload(false); window.close();</script>');
    //echo('<script language="Javascript">alert(opener.window.location.href);</script>');
    //var url = opener.window.location.href+'&section=frame';
    $titleID=$_POST['title'] ;
	echo('<script language="Javascript">window.opener.parent.location.href = opener.window.location.href + "&titleID='.$titleID.'"; window.close();</script>');
	 
}


?>

<html>
<title>Print PO</title>
<head>
<script src="<?php echo JURI::base().'media/editors/tinymce/jscripts/tiny_mce/tiny_mce.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
				tinyMCE.init({
					// General
					dialog_type : "modal",
					directionality: "ltr",
					editor_selector : "mce_editable",
					language : "en",
					mode : "specific_textareas",
					plugins : "paste,searchreplace,insertdatetime,table,emotions,media,advhr,directionality,fullscreen,layer,style,xhtmlxtras,visualchars,visualblocks,nonbreaking,wordcount,template,advimage,advlink,advlist,autosave,contextmenu,inlinepopups",
					skin : "default",
					theme : "advanced",
					// Cleanup/Output
					inline_styles : true,
					gecko_spellcheck : true,
					entity_encoding : "raw",
					extended_valid_elements : "hr[id|title|alt|class|width|size|noshade|style],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],a[id|class|name|href|hreflang|target|title|onclick|rel|style]",
					force_br_newlines : false, force_p_newlines : true, forced_root_block : 'p',
					invalid_elements : "script,applet",
					// URL
					relative_urls : true,
					remove_script_host : false,
					document_base_url : "<?php echo JURI::base(); ?>",
					//Templates
					template_external_list_url : "<?php echo JURI::base().'media/editors/tinymce/templates/template_list.js'; ?>",
					// Layout
					content_css : "<?php echo JURI::base().'templates/system/css/editor.css'; ?>",
					// Advanced theme
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_source_editor_height : "550",
					theme_advanced_source_editor_width : "750",
					theme_advanced_resizing : true,
					theme_advanced_resize_horizontal : false,
					theme_advanced_statusbar_location : "bottom", theme_advanced_path : true,
					theme_advanced_buttons1_add_before : "",
					theme_advanced_buttons2_add_before : "search,replace,|",
					theme_advanced_buttons3_add_before : "tablecontrols",
					theme_advanced_buttons1_add : "fontselect,fontsizeselect",
					theme_advanced_buttons2_add : "insertdate,inserttime,forecolor,backcolor,fullscreen",
					theme_advanced_buttons3_add : "emotions,media,advhr,ltr,rtl",
					theme_advanced_buttons4 : "cut,copy,paste,pastetext,pasteword,selectall,|,insertlayer,moveforward,movebackward,absolute,styleprops,cite,abbr,acronym,ins,del,attribs,visualchars,visualblocks,nonbreaking,blockquote,template",
					plugin_insertdate_dateFormat : "%Y-%m-%d",
					plugin_insertdate_timeFormat : "%H:%M:%S",
					fullscreen_settings : {
						theme_advanced_path_location : "top"
					}
				});

				function submitForm() { 
				    document.getElementById("add").click();
				}
				window.onload = submitForm;

				</script>
<style>
p {margin: 0;}
.btn {background-color: #4285F4;
    border: 1px solid #026695;
    color: #FFFFFF;
    cursor: pointer;
    margin: 5px 0;
    padding: 2px;
    width: 190px;}
 
.template_tbl {border:1px solid black;  min-width:900px;padding:0px; border-collapse:collapse;  }
 
</style>
</head>
<body>
<?php
 
 
$projectid = mysql_real_escape_string($_REQUEST['projectid']);
$section = mysql_real_escape_string($_REQUEST['section']);
$titleID = mysql_real_escape_string($_REQUEST['titleID']);
$supplierid = mysql_real_escape_string($_REQUEST['supplierid']);

//$sql = "SELECT * FROM ver_chronoforms_data_contract_list_vic  AS contract LEFT JOIN ver_chronoforms_data_clientpersonal_vic AS c ON c.clientid = contract.quoteid WHERE  contract.projectid = '{$projectid}' ";
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');exit();
$sql = "SELECT * FROM ver_chronoforms_data_contract_list_vic  AS contract JOIN ver_chronoforms_data_clientpersonal_vic AS c ON c.clientid = contract.quoteid WHERE  contract.projectid = '".$projectid."' ";
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
$qContract = mysql_query($sql);
$contract = mysql_fetch_array($qContract); 
//error_log(print_r($contract,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');exit();

 
$sql = "SELECT * FROM ver_chronoforms_data_supplier_vic  WHERE  supplierid = '".$supplierid."' ";
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
$qSupplier = mysql_query($sql);
$supplier = mysql_fetch_array($qSupplier);

?>

<form method="post">
<input name="clientid" id="clientid" type="hidden" value="<?php echo $projectid; ?>">
<input name="title" id="title" type="hidden" value="<?php echo $titleID; ?>">
 
<textarea name="htmlcontent" id="htmlcontent" class="mce_editable" style="width:100%;height:100%!important; ">
<div style="font-family:Arial, Helvetica, sans-serif; width:700px;  font-size: 10pt;">
<table class="template_tbl" cellspacing="0" cellpadding="0" width="600px">
	<tr>
		<td  style="width:50%; text-align:left; " >
		 	<img src="<?php echo JURI::base().'images/company_logo.png'; ?> " class="" style="float:left;padding:0px 0px 30px 0; width: 120px;"/>
			 
		</td>
		<td valign="middle" style="font-family:Arial, Helvetica, sans-serif;font-size:10pt;width:50%;">
			<br/>
			<b>Vergola (SA) Pty Ltd</b><br/>
			101 Port Road<br/>
			THEBARTON SA 5031<br/>
			Phone: 0881506888       FAX: 08 8150 6868 <br/>
			ABN: 14115578112
			Email: admin@vergola.com
  
		</td>
	</tr>
	<tr>
		<td style="border: 1px solid black; border-collapse: collapse;">
			 
			<div><b>To:</b></div>
			<div>
				<?php echo $supplier["company_name"]; ?> <br/>
				<?php echo $supplier["address1"]; ?> <br/>
				<?php echo $supplier["suburb"]." ".$supplier["state"]." ".$supplier["postcode"]; ?> <br/> 
				<?php echo $supplier["phone"] ?> <br/>
				<?php echo $supplier["fax"]  ?> <br/>  
			</div>
		</td>
		<td style="border: 1px solid black; border-collapse: collapse;">
			 
			<div><b>Deliver To:</b></div>
			<div>
				<?php if($contract['is_builder']==1){  
					  echo $contract["builder_name"];    
				}else{
					 echo $contract["client_firstname"]." ".$contract["client_lastname"]; 
				} ?> <br/>

				<?php if(empty($contract['site_address1'])==false){  
					echo $contract["site_address1"]." ".$contract["site_address2"];  
				}else{
					echo $contract["client_address1"]." ".$contract["client_address2"]; 
				} ?><br/>
				
				<?php if(empty($contract['site_suburb'])==false){ 
					echo $contract["site_suburb"]." ".$contract["site_state"]." ".$contract["site_postcode"]; 
				}else{
					echo $contract["client_suburb"]." ".$contract["client_state"]." ".$contract["client_postcode"]; 
				} ?><br/>

				<?php if(empty($contract["site_hmphone"])==false){ 
					 echo $contract["site_hmphone"];
				}else{
					echo $contract["client_hmphone"];
				} ?><br/>	
 
				<?php if(empty($contract["site_mobile"])==false){ 
					echo $contract["site_mobile"];
				}else{   
					echo $contract["client_mobile"];
				} ?><br/>		
			</div>
		</td>
	</tr>
	<tr><td colspan="2"></td></tr>	
	<tr>	
		<td colspan="2">
			<b>Client:</b> <?php if($contract["is_builder"]==1){ echo $contract["builder_name"]; }else{ echo $contract["client_firstname"]." ".$contract["client_lastname"];} ?> &nbsp;&nbsp;&nbsp;&nbsp; 
			<b>Project ID:</b> <?php echo $contract["projectid"]; ?>&nbsp;&nbsp;
			<b>Account No:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>Required Date:</b>  
		</td>
	</tr>	
</table>  
<br/>

 
<b>PO Order No.: <?php echo $contract["cf_id"]  ?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Ordered On:</b> <?php print(Date("d M Y")); ?>
<br/><br/>
<table class="" border="1" cellspacing="0" style="border-collapse:collapse;font-size:9pt;" >
	<tr>
		 	<th width="180" colspan="2">
				&nbsp;&nbsp;<b>Description</b> &nbsp;&nbsp;
			</th>
			<th width="50">
				&nbsp;&nbsp;<b>Qty</b>&nbsp;&nbsp;
			</th>
			<th width="50">
				 <b>Length</b> 
			</th>
			<th width="40">
				 <b>UOM</b> 
			</th>
			
			<th width="60">
				&nbsp;&nbsp;<b>Color</b> &nbsp;&nbsp;
			</th>
			<th width="60">
				&nbsp;&nbsp;<b>Unit Price</b> &nbsp;&nbsp;
			</th>
			<th width="90">
				&nbsp;&nbsp;<b>Unit Total</b> &nbsp;&nbsp;
			</th>
	</tr>

  
	<?php
	 
	//error_log($section, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	//$resultpurchase = mysql_query ($sqlpurchase) or die ('request "Could not execute SQL query" '.$sqlpurchase);

	 if($section=="reorder"){ 
		 $sql = " SELECT   *  FROM ver_chronoforms_data_contract_bom_vic AS i JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid=i.inventoryid WHERE i.projectid = '{$projectid}'  AND i.is_reorder=1  ";
		 
	}else{
		 $sql = " SELECT   *  FROM ver_chronoforms_data_contract_bom_vic AS i JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid=i.inventoryid WHERE i.projectid = '{$projectid}'  AND inv.section='{$section}'  "; 
	}
	//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');  

?>

	<?php
	 
			$resultpurchase = mysql_query ($sql) or die ('request "Could not execute SQL query" '.$sql);
			$totalRrp = 0;  
			while ($bm = mysql_fetch_assoc($resultpurchase)){   

				$order_by = "";
				if($bm['section']=="Frame"){
					$order_by = " ORDER BY  FIELD(bm.materialid, 'IRV122','IRV121','IRV26','IRV25','IRV24','IRV23','IRV15','162','3') DESC ";
				}
			  
				$sql = "SELECT bm.projectid, bm.inventoryid, bm.materialid, bm.raw_cost, bm.qty, bm.supplierid, m.raw_description, m.is_per_length, m.length_per_ea, m.uom, s.company_name FROM  ver_chronoforms_data_contract_bom_meterial_vic AS bm  
JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id=bm.materialid 
JOIN ver_chronoforms_data_supplier_vic AS s ON s.supplierid=m.supplierid  
WHERE bm.projectid = '{$projectid}' AND bm.inventoryid IN (SELECT i.inventoryid FROM ver_chronoforms_data_contract_bom_vic AS i 
        JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid=i.inventoryid WHERE i.projectid = '{$projectid}' AND bm.inventoryid = '{$bm['inventoryid']}' ) AND m.supplierid='{$supplierid}' GROUP BY bm.inventoryid, bm.materialid {$order_by} ";

 
				error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); //exit();
				$item_result = mysql_query ($sql);
				
				while ($m = mysql_fetch_assoc($item_result)){
					
					$amount = 0; $m_qty = 1; $m_length = 1;
					if($m['is_per_length']==1){
					// $amount = $m['raw_cost'] * $m['qty'] * $bm['qty'] * floor($bm['length'] / $m['length_per_ea']);
					if($m['uom']=="Ea" || $m['uom']=="$"){
						$m_qty = $bm['qty'] * floor($bm['length'] / $m['length_per_ea']);
						$m_length = $bm['length'];
						$amount = $m_qty * $m['raw_cost'];  
					}
					else{
						$m_qty = $bm['qty'];
						$m_length = $bm['length'];// * floor($bm['length'] / $m['length_per_ea']); 
						$amount = $m['raw_cost'] * $m_qty * $bm['length'];
					}
					
				}else{
					$amount = $m['raw_cost'] * $m['qty'] * $bm['qty']; 
					$m_qty = $m['qty'] * $bm['qty'];
					$m_length = $bm['length']; 
					 
				}
					// if($m['is_per_length']==1){
					// 	// $amount = $m['raw_cost'] * $bom_item['qty'] * $bom_item['length'];
					// 	// if($m['uom']=="Ea")
					// 	// 	$m_qty = $m['qty'] * $bom_item['qty'] * $bom_item['length'];
					// 	// else
					// 	// 	$m_qty = $m['qty'];

					// 	$amount = $m['raw_cost'] * $m['qty'] * $bom_item['qty'] * floor($bom_item['length'] / $m['length_per_ea']);
					// 	if($m['uom']=="Ea"){
					// 		$m_qty = $bom_item['qty'] * floor($bom_item['length'] / $m['length_per_ea']);
					// 		$m_length = $bom_item['length'];
					// 	}
					// 	else{
					// 		$m_length = $bom_item['length'] * floor($bom_item['length'] / $m['length_per_ea']); 
					// 	}
						

					// }else{
					// 	$amount = $m['raw_cost'] * $m['qty'] * $bom_item['qty'];
						   
					// 	$m_qty = $m['qty'] * $bom_item['qty'];
					// 	$m_length = $bom_item['length']; 


					// }	
					$totalRrp +=$amount; 

				?> 
					
					<tr> 
						<td colspan="2"><?php echo $m['raw_description']; ?></td>  
						<td style="text-align:right;"><?php echo number_format($m_qty); ?></td>
						<td style="text-align:right;"><?php if($m['uom']=="Mtrs") echo $m_length; ?></td>
						<td style="text-align:right;"><?php echo $m['uom']; ?></td> 
						<td><?php echo $bm['colour']; ?></td>
						<td style="text-align:right;">$<?php echo number_format($m['raw_cost'],2); ?></td>
						<td style="text-align:right;">$<?php echo number_format($amount,2); ?></td>
					</tr> 
					  
				<?php  
					}

					
				?>

		  	 
		<?php } //END OF contract_bom_vic loop. 

			$gst = $totalRrp * 0.1;
			$totalSum = $totalRrp + $gst;

		 ?>  	
  
 	<tr>
		<td  colspan="7" style="text-align:right"> 
			<span><b>Sub Total</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
		</td> 
		<td style="text-align:right">
		 	$<?php echo number_format($totalRrp,2); ?>
		</td>
	</tr>
	<tr>
		<td colspan="7" style="text-align:right"> 
			<span ><b>GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		 	
		<td style="text-align:right">
		 	$<?php echo number_format($gst,2); ?>
		</td>
	</tr>
	<tr>
		<td colspan="7" style="text-align:right"> 
			<span  ><b>Total Inclusive of GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	 			
		<td style="text-align:right">
		 	$<?php echo number_format($totalSum,2); ?>
		</td>
	</tr>  
	 
</table>

<br/><br/>
Measurement Tolerance - 0m / + 1mm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Length Tolerance - 0m / + 10mm <br/>
NOTE: all folds are 90&deg; unless otherwise stated



</div> 
</textarea>
<input type="submit" class="btn" name="add" id="add1" value="Download PDF"> <input class="btn" type="button" value="Close" onClick="window.opener=null; window.close(); return false;">

</form>
</body>
</html>