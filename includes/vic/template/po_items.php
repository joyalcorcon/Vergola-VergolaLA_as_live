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

//error_log($QuoteIDAlpha, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
if(isset($_POST['add']))
{	
    $template_clientid=$_POST['clientid'];
	$template_title=$_POST['title'] ; 
	// $template_content=addslashes($_POST['htmlcontent']);
	$template_content=$_POST['htmlcontent'] ;
     
	mysql_query("INSERT INTO ver_chronoforms_data_letters_vic (clientid, template_name, datecreated, template_content) 
		 VALUES ('$template_clientid','$template_title', '$current_date', '$template_content')"); 

	
	//$_GET['section'] = 'frame'; 
	//header("Location: ". JURI::base() . $_SERVER['REDIRECT_URI'] . '?' . http_build_query($_GET)); 		
    // echo('<script language="Javascript">opener.window.location.reload(false); window.close();</script>');
    //echo('<script language="Javascript">alert(opener.window.location.href);</script>');
    //var url = opener.window.location.href+'&section=frame';
    $titleID=$_POST['title'] ;
	echo('<script language="Javascript">window.opener.parent.location.href = opener.window.location.href + "&titleID='.$titleID.'"; </script>');
	// echo('<script language="Javascript">window.opener.parent.location.href = opener.window.location.href + "&titleID='.$titleID.'"; window.close();</script>');
	 
}

$config_vr_fractions_output_format = array(
    '1/32' => '1/32', 
    '2/32' => '1/16', 
    '3/32' => '3/32', 
    '4/32' => '1/8', 
    '5/32' => '5/32', 
    '6/32' => '6/32', 
    '7/32' => '7/32', 
    '8/32' => '1/4', 
    '9/32' => '9/32', 
    '10/32' => '10/32', 
    '11/32' => '11/32', 
    '12/32' => '3/8', 
    '13/32' => '13/32', 
    '14/32' => '14/32', 
    '15/32' => '15/32', 
    '16/32' => '1/2', 
    '17/32' => '17/32', 
    '18/32' => '18/32', 
    '19/32' => '19/32', 
    '20/32' => '5/8', 
    '21/32' => '21/32', 
    '22/32' => '22/32', 
    '23/32' => '23/32', 
    '24/32' => '3/4', 
    '25/32' => '25/32', 
    '26/32' => '26/32', 
    '27/32' => '27/32', 
    '28/32' => '7/8', 
    '29/32' => '29/32', 
    '30/32' => '30/32', 
    '31/32' => '31/32' 
);

$config_vr_decimal_output_format = array(
	'1/32' => '0.03125',
	'2/32' => '0.0625',
	'3/32' => '0.09375',
	'4/32' => '0.125',
	'5/32' => '0.15625',
	'6/32' => '0.1875',
	'7/32' => '0.21875',
	'8/32' => '0.25',
	'9/32' => '0.28125',
	'10/32' => '0.3125',
	'11/32' => '0.34375',
	'12/32' => '0.375',
	'13/32' => '0.40625',
	'14/32' => '0.4375',
	'15/32' => '0.46875',
	'16/32' => '0.5',
	'17/32' => '0.53125',
	'18/32' => '0.5625',
	'19/32' => '0.59375',
	'20/32' => '0.625',
	'21/32' => '0.65625',
	'22/32' => '0.6875',
	'23/32' => '0.71875',
	'24/32' => '0.75',
	'25/32' => '0.78125',
	'26/32' => '0.8125',
	'27/32' => '0.84375',
	'28/32' => '0.875',
	'29/32' => '0.90625',
	'30/32' => '0.9375',
	'31/32' => '0.96875'
);

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
					theme_advanced_source_editor_height : "950",
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
 
.template_tbl {border:1px solid black;  min-width:800px;padding:0px; border-collapse:collapse;  }

@media print {
.pagebreak { page-break-before: always; }
} 
 
</style>
</head>
<body>
<?php 
 
$projectid = mysql_real_escape_string($_REQUEST['projectid']);
$section = mysql_real_escape_string($_REQUEST['section']);
$titleID = mysql_real_escape_string($_REQUEST['titleID']);
$supplierid = mysql_real_escape_string($_REQUEST['supplierid']);
$is_uom_visible = 1;
$inventoryid = "";
$is_reorder = 0;
if($section=="reorder"){
	$is_reorder = 1;
	$inventoryid = mysql_real_escape_string($_REQUEST['inventoryid']);
}

//$sql = "SELECT * FROM ver_chronoforms_data_contract_list_vic  AS contract LEFT JOIN ver_chronoforms_data_clientpersonal_vic AS c ON c.clientid = contract.quoteid WHERE  contract.projectid = '{$projectid}' ";
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');exit();
$sql = "SELECT * FROM ver_chronoforms_data_contract_list_vic  AS contract JOIN ver_chronoforms_data_clientpersonal_vic AS c ON c.clientid = contract.quoteid WHERE  contract.projectid = '".$projectid."' ";
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
$qContract = mysql_query($sql);
$contract = mysql_fetch_array($qContract); 
//error_log(print_r($contract,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');exit();

 
$sql = "SELECT * FROM ver_chronoforms_data_supplier_vic  WHERE  supplierid = '".$supplierid."' ";
//error_log($sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
$qSupplier = mysql_query($sql);
$supplier = mysql_fetch_array($qSupplier);

?>

<form method="post">
<input name="clientid" id="clientid" type="hidden" value="<?php echo $projectid; ?>">
<input name="title" id="title" type="hidden" value="<?php echo $titleID; ?>">
 
<textarea name="htmlcontent" id="htmlcontent" class="mce_editable" style="width:100%;height:100%!important; ">
<div style="font-family:Arial, Helvetica, sans-serif; width:800px;  font-size: 10pt;">
<table class="template_tbl" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td colspan="3" style="width:50%; text-align:left; " >
		 	<img src="<?php echo JURI::base().'images/company_logo.png'; ?> " class="" style="float:left;padding:0px 0px 10px 0; width: 180px;"/>
			 
		
		</td>
		<td colspan="3" valign="top" style="padding-left: 5px; font-family:Arial, Helvetica, sans-serif;font-size:10pt;width:50%;text-align: right;">			
			<b>Vergola LA Inc</b><br/>
			13800 Crenshaw Boulevard<br/>
			Gardena CA 90249<br/>
			Phone: 855 949 8347<br/>
			Email: purchasingla@vergola.com  
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left: 5px; border-collapse: collapse;vertical-align: top;width: 33.3%;">
			 
			<!-- <div><b>To:</b></div> -->
			<div>				
				<b>PO Number: <?php echo $contract["cf_id"]  ?></b> &nbsp;&nbsp;
				<br/><br/><br/>
				<b>Order To:</b><br/>
				<?php if(empty($supplier["company_name"])==false){ 
					  echo $supplier["company_name"]; } ?> <br/>
				<?php if(empty($supplier["address1"])==false){ 
					  echo $supplier["address1"]; } ?> <br/>
				<?php if(empty($supplier["suburb"])==false){ 
					  echo $supplier["suburb"]." ".$supplier["state"]." ".$supplier["postcode"]; } ?> <br/>
				<?php if(empty($supplier["phone"])==false){ 
					  echo $supplier["phone"]; } ?> <br/>
			</div>
		</td>
		<td colspan="2" style="padding-left: 5px; border-collapse: collapse; vertical-align: top;width: 33.3%;">
			 
			<!-- <div><b>Deliver To:</b></div> -->
			<div>
				<b>Project ID:</b> <?php echo $contract["projectid"]; ?>&nbsp;&nbsp;<br/><br/>		
				<b>Client:</b> <?php if($contract["is_builder"]==1){ echo $contract["builder_name"]; }else{ echo $contract["client_firstname"]." ".$contract["client_lastname"];} ?> &nbsp;&nbsp;&nbsp;&nbsp; 
				<br/>
				<b>Deliver To:</b><br/>
				<?php if($contract['is_builder']==1){  
					  echo $contract["builder_name"];    
				}else{
					 echo $contract["client_firstname"]." ".$contract["client_lastname"]; 
				} ?> <br/>

				<?php if(empty($contract['site_address1'])==false){  
					echo $contract["site_address1"]." ".$contract["site_address2"];  
				}else if(empty($contract['client_address1'])==false){
					echo $contract["client_address1"]." ".$contract["client_address2"]; 
				} ?><br/>
				
				<?php if(empty($contract['site_suburb'])==false){ 
					echo $contract["site_suburb"]." ".$contract["site_state"]." ".$contract["site_postcode"]; 
				}else if(empty($contract['client_suburb'])==false){
					echo $contract["client_suburb"]." ".$contract["client_state"]." ".$contract["client_postcode"]; 
				} ?><br/>
				<?php if((empty($contract["site_hmphone"])==false) || (empty($contract["site_mobile"])==false)) { 
					 echo $contract["site_hmphone"] ."      ". $contract["site_mobile"];
				}else if((empty($contract["client_hmphone"])==false) || (empty($contract["client_mobile"])==false)){
					echo $contract["client_hmphone"] ."      ". $contract["client_mobile"];
				} ?><br/>			
			</div>
		</td>
		<td colspan="2" style="padding-left: 5px; border-collapse: collapse; vertical-align: top;width: 33.3%;">
			 
			<!-- <div><b>Deliver To:</b></div> -->
			<div>
				<b>Special Conditions:</b> &nbsp;&nbsp;<br/><br/>		
				<table>
				  <?php
				  $sql = "SELECT cf_id, datenotes, username, content, date_created 
					    FROM ver_chronoforms_data_special_condition_vic 
					    WHERE clientid = '$ClientID' 
					    ORDER by cf_id DESC";
				$sql = "SELECT
							* 
						FROM
							ver_chronoforms_data_contract_list_vic AS contract
							JOIN ver_chronoforms_data_special_condition_vic AS sc ON sc.clientid = contract.quoteid 
						WHERE
							contract.projectid = '{$projectid}'
							";
				  // echo $sql;
				  $resultnotes = mysql_query ($sql);
				  $i=1;
				  if (!$resultnotes) {
				    echo 'Could not run query: ' . mysql_error();
				    exit;
				  }
				  while($row = mysql_fetch_assoc($resultnotes))
				  {
				    echo "
				    <tr><td class=\"\"><p>". $i++ .".&nbsp;{$row['content']}</p>
				    <!-- <div class=\"layer-date\">Date: " .date(PHP_DFORMAT, strtotime ($row['date_created'])) . "</div>
				    <div class=\"layer-whom\">By Whom: {$row['username']}</div> -->
				    </td>
				    </tr>";
				  }
				  ?>
				</table>	
			</div>
		</td>
	</tr>
	<tr><td colspan="6"></td></tr>	
	<tr>	
		<td colspan="6" style="padding-left: 5px;" height="30">
			<b>Date Ordered:</b> &nbsp;&nbsp; <?php print(Date(PHP_DFORMAT)); ?><br/>
			<b>Date Required:</b> &nbsp;&nbsp;
		</td> 
	</tr> 
</table> 
<br/> 
 
<!-- <b>PO Order No.: <?php echo $contract["cf_id"]  ?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Ordered On:</b> <?php print(Date(PHP_DFORMAT)); ?> -->
<!-- <br/><br/> -->
<table class="template_tbl" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;font-size:9pt; " width="100%"> <tr></tr>

	<?php
$order_by = ""; 
if($section=="Vergola"){ 
	$order_by = " ORDER BY FIELD(inv.category,'Louvers') DESC, FIELD(inv.inventoryid, 'IRV66', 'IRV64', 'IRV63', 'IRV62', 'IRV60', 'IRV59','IRV58') DESC, id   "; 
}

//Main item of a raw material that should display first like beam and post.


// $sql = "SELECT bm.id,m.qty,(im.inv_qty*bm.qty) AS m_qty,(bm.qty*im.inv_qty) AS ls_qty,bm.length,CASE WHEN m.uom='Mtrs' THEN bm.raw_cost*(im.inv_qty*bm.qty)*bm.length ELSE bm.raw_cost*(im.inv_qty*bm.qty) END AS ls_amount,bm.projectid,bm.inventoryid,bm.materialid,bm.raw_cost,bm.qty AS bm_qty,bm.supplierid,m.raw_description,m.is_per_length,m.length_per_ea,m.uom,s.company_name,inv.photo,b.colour,b.finish FROM ver_chronoforms_data_contract_bom_meterial_vic AS bm JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.contract_item_cf_id=bm.contract_item_cf_id JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid=bm.inventoryid JOIN ver_chronoforms_data_inventory_material_vic AS im ON im.inventoryid=bm.inventoryid AND im.materialid=bm.materialid JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id=im.materialid JOIN ver_chronoforms_data_supplier_vic AS s ON s.supplierid=bm.supplierid WHERE bm.projectid='{$projectid}' AND b.projectid='{$projectid}' ".($is_reorder==1?" AND inv.inventoryid='{$inventoryid}' ":" AND bm.section='{$section}' ")." AND bm.supplierid='{$supplierid}' AND m.is_main_item=1 { $ order_by}  "; // ORDER BY is_per_length DESC, bm.id, b.length DESC, b.qty DESC

// $sql = "SELECT m.qty,(bm.qty) AS 1 _qty,(im.inv_qty*bm.qty) AS m_qty,bm.length,(bm.qty*im.inv_qty) AS ls_qty,SUM(b.qty*im.inv_qty) AS ts_qty,CASE WHEN m.is_per_length=1 THEN CASE WHEN m.uom='Ea' THEN SUM(im.inv_qty*bm.qty) ELSE SUM(floor(((bm.length_feet*12)+bm.length_inch)/m.length_per_ea_us)) END ELSE SUM(im.inv_qty*bm.qty) END AS ls_qty,CASE WHEN m.is_per_length=1 THEN CASE WHEN m.uom='Ea' THEN SUM(m.raw_cost*im.inv_qty*b.qty) ELSE SUM((m.raw_cost*im.inv_qty*(floor(((b.length_feet*12)+b.length_inch)/m.length_per_ea_us)+COALESCE ((((RIGHT (SUBSTRING_INDEX(bm.length_fraction,'/',1),1)+0)/(LEFT (SUBSTRING_INDEX(bm.length_fraction,'/',-1),1)+0))),0))*b.qty)) END ELSE SUM(m.raw_cost*im.inv_qty*b.qty) END AS ls_amount,CASE WHEN m.is_per_length=1 THEN CASE WHEN m.uom='Ea' THEN (m.raw_cost*im.inv_qty*bm.qty) ELSE ((m.raw_cost*im.inv_qty*floor((((bm.length_feet*12)+bm.length_inch)/m.length_per_ea_us)+COALESCE ((((RIGHT (SUBSTRING_INDEX(bm.length_fraction,'/',1),1)+0)/(LEFT (SUBSTRING_INDEX(bm.length_fraction,'/',-1),1)+0))),0))*bm.qty)) END ELSE (m.raw_cost*im.inv_qty*bm.qty) END AS 1 _amount,CASE WHEN m.is_per_length=1 THEN SUM((bm.length_feet*12)+bm.length_inch) END AS s_length,((bm.length_feet*12)+bm.length_inch) AS 1 _length,bm.raw_cost,bm.qty AS bm_qty,bm.length_fraction AS length_fraction,m.raw_description,m.uom,s.company_name,inv.photo,b.colour,b.finish FROM ver_chronoforms_data_contract_bom_meterial_vic AS bm JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid=bm.inventoryid JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.contract_item_cf_id=bm.contract_item_cf_id JOIN ver_chronoforms_data_inventory_material_vic AS im ON im.inventoryid=b.inventoryid JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id=im.materialid JOIN ver_chronoforms_data_supplier_vic AS s ON s.supplierid=bm.supplierid WHERE bm.projectid='{$projectid}' AND b.projectid='{$projectid}' AND s.supplierid='{$supplierid}' ".($is_reorder==" 1 "?" AND b.inventoryid='{$inventoryid}' ":" AND inv.section='{$section}' ")." AND is_main_item=1 GROUP BY CASE WHEN inv.section='Guttering' OR inv.section='Flashings' THEN bm.id ELSE bm.materialid END,bm.length_fraction,b.length,b.colour ORDER BY m.cf_id ASC,m.is_per_length DESC,bm.length DESC,bm.qty DESC,FIELD(inv.category,'Post Fixings','Beam Fixings','Intermediates','Beams') DESC; "
$sql = "
SELECT
	bm.id, b.contract_item_cf_id,
	m.qty,
	(bm.qty) AS 1_qty,
	( im.inv_qty * bm.qty ) AS m_qty_,
	SUM(bm.qty) AS m_qty,
	bm.length,
	( bm.qty * im.inv_qty ) AS ls_qty__,
	SUM( b.qty * im.inv_qty ) AS ts_qty,	

	CASE
		
		WHEN m.is_per_length = 1 THEN
	CASE
		
		WHEN m.uom = 'Ea' THEN
		SUM(im.inv_qty * bm.qty) ELSE SUM( floor( ( ( bm.length_feet * 12 ) + bm.length_inch ) / m.length_per_ea_us ) ) 
		END ELSE SUM(im.inv_qty * bm.qty) 
		END AS ls_qty,
	CASE
			
			WHEN m.is_per_length = 1 THEN
		CASE
				
				WHEN m.uom = 'Ea' THEN
				SUM(m.raw_cost * im.inv_qty * bm.qty) ELSE SUM(
					(
						m.raw_cost * im.inv_qty * floor(
							( ( ( bm.length_feet * 12 ) + bm.length_inch ) / m.length_per_ea_us ) + COALESCE (
								(
									(
										( RIGHT ( SUBSTRING_INDEX( bm.length_fraction, '/', 1 ), 1 ) + 0 ) / ( LEFT ( SUBSTRING_INDEX( bm.length_fraction, '/',- 1 ), 1 ) + 0 ) 
									) 
								),
								0 
							) 
						) * bm.qty 
					) 
				) 
			END ELSE SUM(m.raw_cost * im.inv_qty * bm.qty)
		END AS ls_amount,
	CASE
			
			WHEN m.is_per_length = 1 THEN
		CASE
				
				WHEN m.uom = 'Ea' THEN
				( m.raw_cost * im.inv_qty * bm.qty ) ELSE (
					(
						m.raw_cost * im.inv_qty * floor(
							( ( ( bm.length_feet * 12 ) + bm.length_inch ) / m.length_per_ea_us ) + COALESCE (
								(
									(
										( RIGHT ( SUBSTRING_INDEX( bm.length_fraction, '/', 1 ), 1 ) + 0 ) / ( LEFT ( SUBSTRING_INDEX( bm.length_fraction, '/',- 1 ), 1 ) + 0 ) 
									) 
								),
								0 
							) 
						) * bm.qty 
					) 
				) 
			END ELSE ( m.raw_cost * im.inv_qty * bm.qty ) 
		END AS 1_amount,
	CASE
			
			WHEN m.is_per_length = 1 THEN
			SUM( ( bm.length_feet * 12 ) + bm.length_inch ) 
		END AS s_length,
CASE			
		WHEN m.uom = 'Inches' THEN
		( ( bm.length_feet * 12 ) + bm.length_inch ) END AS 1_length,

	bm.projectid,
	bm.inventoryid,
	bm.materialid,
	bm.raw_cost,
	bm.qty AS bm_qty,
	bm.supplierid,
	bm.length_fraction AS length_fraction,
	m.raw_description,
	m.is_per_length,
	m.length_per_ea,
	m.uom,
	s.company_name,
	inv.photo,
	b.colour,
	b.finish 
FROM
	ver_chronoforms_data_contract_bom_meterial_vic AS bm
	JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid = bm.inventoryid
	JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.contract_item_cf_id = bm.contract_item_cf_id
	JOIN ver_chronoforms_data_inventory_material_vic AS im ON im.inventoryid = bm.inventoryid AND im.inventoryid = b.inventoryid
	AND im.materialid = bm.materialid
	JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id = im.materialid
	JOIN ver_chronoforms_data_supplier_vic AS s ON s.supplierid = bm.supplierid 
	
WHERE
	bm.projectid = '{$projectid}' 
	AND s.supplierid = '{$supplierid}' 	
	
	".($is_reorder==" 1 "?" AND b.inventoryid = '{$inventoryid}' ":" AND inv.section = '{$section}' ")." 
	AND is_main_item = 1 
	
GROUP BY
CASE
		
		WHEN inv.section = 'Guttering' 
		OR inv.section = 'Flashings' 
		THEN
			bm.id ELSE bm.materialid END,
CASE			
		WHEN m.uom = 'Inches' THEN
		( ( bm.length_feet * 12 ) + bm.length_inch ) END,
		bm.length_fraction,
		b.colour 
	ORDER BY
		CASE WHEN inv.section = 'Guttering' OR inv.section = 'Flashings' THEN m.display_order END ASC,
		m.cf_id ASC,
		m.is_per_length DESC,
		bm.length DESC,
	bm.qty DESC
	,FIELD( inv.category, 'Post Fixings', 'Beam Fixings', 'Intermediates', 'Beams' ) DESC ";

$sql2 = "
SELECT
	bm.id,
	m.qty,
	(bm.qty) AS 1_qty,
	( im.inv_qty * bm.qty ) AS m_qty_,
	SUM(bm.qty) AS m_qty,
	bm.length,
	( bm.qty * im.inv_qty ) AS ls_qty__,
	SUM( b.qty * im.inv_qty ) AS ts_qty,	

	CASE
		
		WHEN m.is_per_length = 1 THEN
	CASE
		
		WHEN m.uom = 'Ea' THEN
		SUM(im.inv_qty * bm.qty) ELSE SUM( floor( ( ( bm.length_feet * 12 ) + bm.length_inch ) / m.length_per_ea_us ) ) 
		END ELSE SUM(im.inv_qty * bm.qty) 
		END AS ls_qty,
	CASE
			
			WHEN m.is_per_length = 1 THEN
		CASE
				
				WHEN m.uom = 'Ea' THEN
				SUM( m.raw_cost * im.inv_qty * bm.qty ) ELSE SUM(
					(
					m.raw_cost * im.inv_qty * 
						(FLOOR(((bm.length_feet * 12 ) + bm.length_inch ) / m.length_per_ea_us ) + 
							(COALESCE (((LEFT (SUBSTRING_INDEX(bm.length_fraction,'/',-2),2)+0) / 
								(RIGHT (SUBSTRING_INDEX(bm.length_fraction,'/',2),2)+0)),0) 
							)
						) * b.qty 
					) 
				) 
			END ELSE SUM( m.raw_cost * im.inv_qty * b.qty ) 
		END AS ls_amount,
	CASE
			
			WHEN m.is_per_length = 1 THEN
		CASE
				
				WHEN m.uom = 'Ea' THEN
				( m.raw_cost * im.inv_qty * bm.qty ) ELSE (
					(
						m.raw_cost * im.inv_qty * floor(
							( ( ( bm.length_feet * 12 ) + bm.length_inch ) / m.length_per_ea_us ) + COALESCE (
								(
									(
										( RIGHT ( SUBSTRING_INDEX( bm.length_fraction, '/', 1 ), 1 ) + 0 ) / ( LEFT ( SUBSTRING_INDEX( bm.length_fraction, '/',- 1 ), 1 ) + 0 ) 
									) 
								),
								0 
							) 
						) * bm.qty 
					) 
				) 
			END ELSE ( m.raw_cost * im.inv_qty * bm.qty ) 
		END AS 1_amount,
	CASE
			
			WHEN m.is_per_length = 1 THEN
			SUM( ( bm.length_feet * 12 ) + bm.length_inch ) 
		END AS s_length,
	CASE			
			WHEN m.is_per_length = 1 THEN
		( ( bm.length_feet * 12 ) + bm.length_inch ) END AS 1_length,

	bm.length_fraction AS length_fraction,
	bm.projectid,
	bm.inventoryid,
	bm.materialid,
	bm.raw_cost,
	bm.qty AS bm_qty,
	bm.supplierid,
	m.raw_description,
	m.is_per_length,
	m.length_per_ea,
	m.uom,
	s.company_name,
	inv.photo,
	b.colour,
	b.finish 
FROM
-- OLD JOIN
	-- Begin
		-- ver_chronoforms_data_contract_bom_meterial_vic AS bm
		-- 	JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid = bm.inventoryid
		-- 	JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.contract_item_cf_id = bm.contract_item_cf_id
		-- 	-- JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.inventoryid = bm.inventoryid
		-- 	JOIN ver_chronoforms_data_inventory_material_vic AS im ON im.inventoryid = b.inventoryid
		-- 	-- im.inventoryid = bm.inventoryid AND im.inventoryid = b.inventoryid AND im.materialid = bm.materialid
		-- 	JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id = im.materialid
		-- 	JOIN ver_chronoforms_data_supplier_vic AS s ON s.supplierid = bm.supplierid 
	-- End
	
	-- 	ver_chronoforms_data_contract_bom_meterial_vic AS bm
-- 	JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.contract_item_cf_id = bm.contract_item_cf_id
-- 	JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.section = bm.section	
-- 	JOIN ver_chronoforms_data_inventory_material_vic AS im ON im.inventoryid = inv.inventoryid 	
-- 		AND im.materialid = bm.materialid
-- 	JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id = im.materialid
-- 	JOIN ver_chronoforms_data_supplier_vic AS s ON s.supplierid = bm.supplierid 

ver_chronoforms_data_contract_bom_meterial_vic AS bm
	JOIN ver_chronoforms_data_inventory_vic AS inv ON inv.inventoryid = bm.inventoryid
	JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.contract_item_cf_id = bm.contract_item_cf_id
	JOIN ver_chronoforms_data_inventory_material_vic AS im ON im.inventoryid = bm.inventoryid AND im.inventoryid = b.inventoryid
	AND im.materialid = bm.materialid
	JOIN ver_chronoforms_data_materials_vic AS m ON m.cf_id = im.materialid
	JOIN ver_chronoforms_data_supplier_vic AS s ON s.supplierid = bm.supplierid 
	
WHERE
	bm.projectid = '{$projectid}' 
	AND b.projectid = '{$projectid}' 
	AND s.supplierid = '{$supplierid}' 	
	
	".($is_reorder==" 1 "?" AND b.inventoryid = '{$inventoryid}' ":" AND inv.section = '{$section}' ")." 
	AND is_main_item = 0 
	
GROUP BY
CASE
		
		WHEN inv.section = 'Guttering' 
		OR inv.section = 'Flashings' THEN
			bm.id ELSE bm.materialid END,
CASE			
		WHEN m.uom = 'Inches' THEN
		( ( bm.length_feet * 12 ) + bm.length_inch ) END,
		b.colour 
	ORDER BY
		m.cf_id ASC,
		m.is_per_length DESC,
		bm.length DESC,
	bm.qty DESC
	,FIELD( inv.category, 'Post Fixings', 'Beam Fixings', 'Intermediates', 'Beams' ) DESC ";

// echo $sql;
//ORDER BY is_per_length DESC

 				$totalRrp = 0; 
 				$count = 0;
				//error_log("sql : ". $sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log'); 
				//error_log("sql 2: ". $sql2, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
				
				// echo $sql;
				$item_result = mysql_query ($sql);
				//$num_result = mysql_num_rows($item_result);
				$i = 1; $num_same_inv_id = 0;
				$prev_inv_id = "";
				$m_qty = 0; $m_amount = 0; $is_1st=1; $is_2nd = 0;  
				$m_qty_IRV59 = 0; $m_amount_IRV59 = 0; $m_qty_IRV60 = 0; $m_amount_IRV60 = 0; // Just only for link bar and pivot strip


			$image_header_first = "";
			$image_header_first .= "
				 <tr>
	 			 	<th height='23' width='300' colspan='6'>
	 					&nbsp;&nbsp;<b>Description</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='35'>
	 					&nbsp;&nbsp;<b>Qty</b>&nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='110' colspan='1'>
	 					 &nbsp;<b>Length</b> &nbsp;
	 				</th>				 				
	 				<th style='text-align:center;' width='65'>
	 					&nbsp;&nbsp;<b>Color</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='70'>
	 					&nbsp;&nbsp;<b>Finish</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='74' colspan='1'>
	 					&nbsp;&nbsp;<b>Price</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='74' colspan='1'>
	 					&nbsp;&nbsp;<b>Total</b> &nbsp;&nbsp;
	 				</th>		 			 
		 		</tr>";

		 	
			$image_header = "";
			$image_header .= "
				 <tr>
	 			 	<th height='23' width='200' colspan='3'>
	 					&nbsp;&nbsp;<b>Description</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='35'>
	 					&nbsp;&nbsp;<b>Qty</b>&nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='65' colspan='1'>
	 					 &nbsp;<b>Length</b> &nbsp;
	 				</th>				 				
	 				<th style='text-align:center;' width='65'>
	 					&nbsp;&nbsp;<b>Color</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='70'>
	 					&nbsp;&nbsp;<b>Finish</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='74'>
	 					&nbsp;&nbsp;<b>Price</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='74' >
	 					&nbsp;&nbsp;<b>Total</b> &nbsp;&nbsp;
	 				</th>
	 				<th colspan='3' rowspan='2' style=\"text-align:center;vertical-align: middle; padding-top:10px;\" width='145';>&nbsp;&nbsp;<b>Dimensions</b> &nbsp;&nbsp;</th>			 			 
		 		</tr>";

	 		$list_header = "";
	 		$list_header .= "
				<tr>
	 			 	<th height='23' width='240' colspan='2'>
	 					&nbsp;&nbsp;<b>Description</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='35'>
	 					&nbsp;&nbsp;<b>Qty</b>&nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='60'>
	 					 &nbsp;<b>Length</b> &nbsp;
	 				</th>
	 				<th style='text-align:center;' width='55'>
	 					<b>Fraction</b>
	 				</th>
	 				<th style='text-align:center;' width=45>
	 					<b>UOM</b> 
	 				</th>
	 				<th style='text-align:center;' width='65'>
	 					&nbsp;&nbsp;<b>Color</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='70'>
	 					&nbsp;&nbsp;<b>Finish</b> &nbsp;&nbsp;
	 				</th>
	 				<th style='text-align:center;' width='75'>
	 					&nbsp;&nbsp;<b>Price</b> &nbsp;&nbsp;
	 				</th>
	 				<th  style='text-align:center;' width='75' >
	 					&nbsp;&nbsp;<b>Total</b> &nbsp;&nbsp;
	 				</th>	 		 			 
		 		</tr>";
				 
				$is_first_page = 0;
				$align_number = 'right';
				if ($section == "Guttering" || $section == "Flashings"){ 
						$align_number = 'center';
						// $m['ts_qty'] = $m['1_qty']; 
						$m['ts_qty'] = $m['m_qty']; 
						$m['s_length'] = $m['1_length']; 
						$m['ls_amount'] = $m['1_amount'];
						$is_first_page = 1;

						$is_uom_visible = 0;

					}else{
						$is_uom_visible = 1;
						echo $list_header;
					}	
				 		
					/**/
					if($is_first_page){
						// echo "<div style='width:100%;  margin:15px; 0;'>";
						    // echo "<h3 style='margin:65px 0 10px 0; text-decoration:underline; '>Sales Summary</h3>";
						    // echo $sales_compare_table;
						    // echo $sales_compare_graph;
						    // echo "<table width=800>";
						    echo $image_header_first;
						    // echo '<br/><br/><br style="page-break-after: always !important;">';
						// echo "</div>";

						// echo "<div style='width:50%; display:inline-block '>";
						    // echo "&nbsp;";
						// echo "</div>";

						// echo $image_header_first;
						// echo $image_header;
						// echo $summary_footer;

						while ($m = mysql_fetch_assoc($item_result)){ //this is just to get get the sum of the link bar and pivot strip.
							if(fnmatch("*Double Bay VR*",$contract['framework']) && $section=="Vergola" && $m["inventoryid"]=="IRV59" ){ //IRV59 is a Pivot strip
								  
								$m_qty_IRV59 += $m['m_qty'];
								$m_amount_IRV59 += $m['ls_amount'];

							}else if(fnmatch("*Double Bay VR*",$contract['framework'])  && $section=="Vergola" && $m["inventoryid"]=="IRV60" ){ //IRV60 is a Link Bar

								$m_qty_IRV60 += $m['m_qty'];
								$m_amount_IRV60 += $m['ls_amount']; 

							}
						}	

						mysql_data_seek($item_result, 0); 
						$IRV59_1st=1; $IRV60_1st=1; 
						$record_counter = 0;
						while ($m = mysql_fetch_assoc($item_result)){
								$m_qty = 0; $m_amount = 0; $is_group = 1;
								if($m['id']==""){continue;} 
								$totalRrp += $m['ls_amount']; 
								$count++;
								$record_counter++;

								if(fnmatch("*Double Bay VR*",$contract['framework']) && $section=="Vergola" && $m["inventoryid"]=="IRV59" ){ //IRV59 is a Pivot strip
									  
									$m_qty = $m_qty_IRV59;
									$m_amount = $m_amount_IRV59;

									if($IRV59_1st==1){
										$IRV59_1st = 0;
									}else{
										continue;
									}
								}else if(fnmatch("*Double Bay VR*",$contract['framework'])  && $section=="Vergola" && $m["inventoryid"]=="IRV60" ){ //IRV60 is a Link Bar

									$m_qty = $m_qty_IRV60;
									$m_amount = $m_amount_IRV60;

									if($IRV60_1st==1){ 
										$IRV60_1st = 0;
									}else{
										continue;
									} 

									//error_log("INV: ".$m["inventoryid"]." m_qty:".$m_qty." m_amount:".$m_amount, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');

								}

							
							$total_records = mysql_num_rows($item_result);
							if ($record_counter <= $total_records) {
								$length_fraction = ((get_mm_value($config_vr_decimal_output_format[$m['length_fraction']])));
								$list_content = "";
								$list_content .= '
								<tr style="page-break-before: auto !important;"> 
									<td style="border-collapse:collapse;font-size:9.8; height: 24" colspan="6" >&nbsp; '.$m['raw_description'].' </td>  
									<td style="border-collapse:collapse;font-size:9.8;text-align:'.$align_number.';">'.number_format(($m_qty>0?$m_qty:$m['m_qty'])).' &nbsp;&nbsp;</td>
									<td style="border-collapse:collapse;font-size:9.8;text-align:'.$align_number.';">'.($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?get_feet_value($m['1_length']):($m['uom']=="Inches"?$m['1_length']:"")).'&nbsp;&nbsp;<br>'.($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?(feetInchesToMillimeters(get_feet_value($m['1_length'])) + $length_fraction):($m['uom']=="Inches"?$m['1_length']:"")).'mm&nbsp;&nbsp;</td> ';
									if($is_uom_visible==1){
										$list_content .= '<td style="border-collapse:collapse;font-size:9.8;text-align:center;">'.$m['uom'].' &nbsp;&nbsp;</td>';
									}
								$list_content .= '
									<td style="border-collapse:collapse;font-size:9.8;text-align:center;">'.($m['colour'] == null?"":$m['colour']).' &nbsp;&nbsp;</td>
									<td style="border-collapse:collapse;font-size:9.8;text-align:center;">'.($m['finish'] == "null"?" ":$m['finish']).' &nbsp;&nbsp;</td>					
									<td style="border-collapse:collapse;font-size:9.8;text-align:'.$align_number.';" colspan="1">$'.number_format($m['raw_cost'],2).' &nbsp;&nbsp;</td>
									<td style="border-collapse:collapse;font-size:9.8;text-align:'.$align_number.';" colspan="1">$'.number_format(($m_amount>0?$m_amount:$m['ls_amount']),2).' &nbsp;&nbsp;</td>
								</tr>';

								echo $list_content;
								// echo '<br/><br/><br style="page-break-after: always !important;">';


									?>


							<?php 
							}else{ ?>
								<?php //} //------------ bm END contract_bom_vic loop. 


								/*
								$gst = $totalRrp * 0.1;
								$totalSum = $totalRrp + $gst;

								// echo $summary_total;

								$summary_total_first_ = "";
								$summary_total_first_ .= '
								 <tr><td height="18" colspan="10" style="border-style: ; border-bottom-color: #eee;"></td></tr> 
								 <br/>
								  	<tr >								 		 
								 		<td  colspan="8" style="text-align:right;border-style: ; border-bottom-color: #eee;" >
								 			<span><b>Sub Total</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
								 		</td> 
								 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
								 		 	$'.number_format($totalRrp,2).' &nbsp;&nbsp;
								 		</td>
								 	</tr>
								 	<tr>
								 		<td colspan="8" style="text-align:right;border-style: ; border-bottom-color: #eee;"> 
								 			<span ><b>GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
								 		</td>								 		 	
								 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
								 		 	$'.number_format($gst,2).' &nbsp;&nbsp;
								 		</td>								 		
								 	</tr>
								 	<tr >
								 		<td colspan="8" style="text-align:right;border-style: ; border-bottom-color: #eee;"> 
								 			<span  ><b>Total Inclusive of GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
								 		</td>								 	 			
								 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
								 		 	$'.number_format($totalSum,2).' &nbsp;&nbsp;
								 		</td>								 		
								 	</tr>  

							 	<tr><td height="18" colspan="10" style="border-bottom-color: #eee;"></td></tr> 
								 <tr style="vertical-align: bottom;border-style: ;border-top-color: #fff; page-break-after:always;">
								 	<td colspan="10" style="padding: 5px 0px 0px 75px; vertical-align: bottom;border-top-color: #eee;">
								 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Measurement Tolerance - 0m / + 1mm  <br/>
								 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NOTE: 
								 		&nbsp; All folds are 90&deg; unless otherwise stated. &nbsp; All breaks are 10&deg; unless otherwise stated.
								 		</td>								 		
								 </tr> ';

								 echo $summary_total_first_;
								 	// echo "</table>";								 
									$gst = 0;
									$totalSum = 0;
									$totalRrp = 0;*/
									$is_first_page = 0; break;


							} 

							$gst = $totalRrp * 0.1;
							$totalSum = $totalRrp + $gst;

								$summary_total_first_ = "";
								$summary_total_first_ .= '
								 <tr><td height="18" colspan="12" style="border-style: ; border-bottom-color: #eee;"></td></tr> 
								 <br/>
								  	<tr >								 		 
								 		<td  colspan="10" style="text-align:right;border-style: ; border-bottom-color: #eee;" >
								 			<span><b>Sub Total</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
								 		</td> 
								 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
								 		 	$'.number_format($totalRrp,2).' &nbsp;&nbsp;
								 		</td>
								 	</tr>
								 	<tr>
								 		<td colspan="10" style="text-align:right;border-style: ; border-bottom-color: #eee;"> 
								 			<span ><b>GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
								 		</td>								 		 	
								 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
								 		 	$'.number_format($gst,2).' &nbsp;&nbsp;
								 		</td>								 		
								 	</tr>
								 	<tr >
								 		<td colspan="10" style="text-align:right;border-style: ; border-bottom-color: #eee;"> 
								 			<span  ><b>Total Inclusive of GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
								 		</td>								 	 			
								 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
								 		 	$'.number_format($totalSum,2).' &nbsp;&nbsp;
								 		</td>								 		
								 	</tr>  

							 	<tr><td height="18" colspan="12" style="border-bottom-color: #eee;"></td></tr> 
								 <tr style="vertical-align: bottom;border-style: ;border-top-color: #fff; page-break-after:always;">
								 	<td colspan="12" style="padding: 5px 0px 0px 75px; vertical-align: bottom;border-top-color: #eee;">
								 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NOTE: 
								 		&nbsp; &nbsp; 1. &nbsp; All folds are 90&deg; unless otherwise stated.  <br/>
								 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
								 		&nbsp; All breaks are 10&deg; unless otherwise stated.   <br/>
								 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
								 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. &nbsp; Measurement Tolerance - 0m / + 1mm  <br/>

								 		</td>								 		
								 </tr> ';
							}
							 echo $summary_total_first_;
							 	// echo "</table>";								 
								$gst = 0;
								$totalSum = 0;
								$totalRrp = 0;

						}	

					/**/
				
				while ($m = mysql_fetch_assoc($item_result)){ //this is just to get get the sum of the link bar and pivot strip.
					if(fnmatch("*Double Bay VR*",$contract['framework']) && $section=="Vergola" && $m["inventoryid"]=="IRV59" ){ //IRV59 is a Pivot strip
						  
						$m_qty_IRV59 += $m['m_qty'];
						$m_amount_IRV59 += $m['ls_amount'];
 
					}else if(fnmatch("*Double Bay VR*",$contract['framework'])  && $section=="Vergola" && $m["inventoryid"]=="IRV60" ){ //IRV60 is a Link Bar
 
						$m_qty_IRV60 += $m['m_qty'];
						$m_amount_IRV60 += $m['ls_amount']; 
 
					}
				}	

				mysql_data_seek($item_result, 0); 
				$IRV59_1st=1; $IRV60_1st=1; 
				while ($m = mysql_fetch_assoc($item_result)){
					$m_qty = 0; $m_amount = 0; $is_group = 1;
					if($m['id']==""){continue;} 
					$totalRrp += $m['ls_amount']; 
					$count++;
					

					if(fnmatch("*Double Bay VR*",$contract['framework']) && $section=="Vergola" && $m["inventoryid"]=="IRV59" ){ //IRV59 is a Pivot strip
						  
						$m_qty = $m_qty_IRV59;
						$m_amount = $m_amount_IRV59;
 
						if($IRV59_1st==1){
							$IRV59_1st = 0;
						}else{
							continue;
						}
					}else if(fnmatch("*Double Bay VR*",$contract['framework'])  && $section=="Vergola" && $m["inventoryid"]=="IRV60" ){ //IRV60 is a Link Bar
 
						$m_qty = $m_qty_IRV60;
						$m_amount = $m_amount_IRV60;
 
						if($IRV60_1st==1){ 
							$IRV60_1st = 0;
						}else{
							continue;
						} 

						//error_log("INV: ".$m["inventoryid"]." m_qty:".$m_qty." m_amount:".$m_amount, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
 
					}
					
					//error_log("HERE 2: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
					 // only 2nd of IRV59 and IRV60 will be displayed. 
					//error_log("Double Bay VR:".$contract['framework']." section:".$section." inventoryid:".$m["inventoryid"], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
					echo "<table>";	
				 	if($m["photo"] !="" && $count > 1 && $is_uom_visible == 0) { 
				 		$length_fraction = ((get_mm_value($config_vr_decimal_output_format[$m['length_fraction']])));
				 		// $length_fraction = ($config_vr_decimal_output_format[$m['length_fraction']]);
				 		echo $image_header;				 		
				 		}else{} 
				 		?>

					<tr style='page-break-before: auto !important;'> 
						<?php if($is_uom_visible==1){ ?>
							<td style="border-collapse:collapse;font-size:9.8; height: 24.7" colspan="2" >&nbsp;<?php echo $m['raw_description']; ?></td> 
						<?php }else{ ?>							 
						 	<td style="border-collapse:collapse;font-size:9.8; height: 45.7" colspan="3" >&nbsp;<?php echo $m['raw_description']; ?></td> 			
						<?php } ?>
						<!-- <td style="border-collapse:collapse;font-size:9.8; height: 24.7" colspan="2" >&nbsp;<?php echo $m['raw_description']; ?></td>   -->
						
						<!-- <td style="text-align:right;"><?php echo number_format(($m_qty>0?$m_qty:$m['ts_qty'])); ?></td>  -->
						<td style="border-collapse:collapse;font-size:9.8;text-align:<?php echo $align_number; ?>;"><?php echo number_format(($m_qty>0?$m_qty:$m['m_qty'])); ?>&nbsp;&nbsp;</td> 
						
						<!-- <td style="text-align:right;"><?php echo number_format(($m_qty>0?$m_qty:$m['m_qty'])); ?></td>  -->
						<!-- <td style="text-align:right;"><?php echo ($section = "Guttering"? number_format($m['m_qty']):($section = "Flashings"?number_format($m['m_qty']):number_format($m['ts_qty']))); ?></td> -->
						<!-- <td style="text-align:right;"><?php echo ($is_group== 1?number_format($m['m_qty']):number_format($m['ts_qty'])); ?></td> -->
						<!-- <td style="text-align:right;"><?php echo number_format(($m_qty>0?$m_qty:($is_group==1?$m['ts_qty']:$m['ls_qty']))); ?></td>  -->
					
						<!-- <td style="border-collapse:collapse;font-size:9.8;text-align:right;"><?php echo ($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?get_feet_value($m['1_length']):($m['uom']=="Inches"?$m['1_length']:"")); ?>&nbsp;&nbsp;</td> -->
						<?php if($is_uom_visible==1){ ?>
							<td style="border-collapse:collapse;font-size:9.8;text-align:right;"><?php echo ($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?get_feet_value($m['1_length']):($m['uom']=="Inches"?$m['1_length']:"")); ?>&nbsp;&nbsp;</td>
						<?php }else{ ?>							 
						 	<td style="border-collapse:collapse;font-size:9.8;text-align:<?php echo $align_number; ?>;">
						 		<?php 
						 		echo ($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?get_feet_value($m['1_length']):"");?>&nbsp;&nbsp;<br><?php 
						 		echo ($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?(feetInchesToMillimeters(get_feet_value($m['1_length'])) + $length_fraction):($m['uom']=="Inches"?$m['1_length']:""));?>mm&nbsp;&nbsp;</td>					
						<?php } ?>
						<?php if($is_uom_visible==1){ ?>
							<td style="border-collapse:collapse;font-size:9.8;text-align:right;"><?php echo $config_vr_fractions_output_format[$m['length_fraction']]; echo ($config_vr_fractions_output_format[$m['length_fraction']] > 0 ? '"' : ''); ?>&nbsp;&nbsp;</td>  <?php } ?>
						<?php 
						// if ($section != "Guttering" || $section != "Flashings"){ 
						// if($m["photo"] !="" && $count > 1) { 
							
						// echo "<td style=\'text-align:center;\'>"; echo $m['uom'] . '123</td>'  ;} ?>
						<!-- <td style="text-align:right;"><?php echo $m['uom']; ?></td>  -->
						<!-- <td><?php echo $m['colour']; ?></td> -->
						<?php if($is_uom_visible==1){ ?>
							<td style="border-collapse:collapse;font-size:9.8;text-align:center;"><?php echo $m['uom']; ?>&nbsp;&nbsp;</td> <?php } ?>
						<td style="border-collapse:collapse;font-size:9.8;text-align:center;"><?php echo ($m['colour'] == null?"":$m['colour']); ?>&nbsp;&nbsp;</td>
						<td style="border-collapse:collapse;font-size:9.8;text-align:center;"><?php echo ($m['finish'] == "null"?" ":$m['finish']); ?>&nbsp;&nbsp;</td>
						
						<td style="border-collapse:collapse;font-size:9.8;text-align:<?php echo $align_number; ?>;">$<?php echo number_format($m['raw_cost'],2); ?>&nbsp;&nbsp;</td>
						<td style="border-collapse:collapse;font-size:9.8;text-align:<?php echo $align_number; ?>;">$<?php echo number_format(($m_amount>0?$m_amount:$m['ls_amount']),2); ?>&nbsp;&nbsp;</td>
						<?php  if($is_uom_visible!=1){ ?> 
							<!-- <td> &nbsp; </td> <td> &nbsp; </td>   -->
						<?php } ?>
					</tr>  

				<?php
				$m_qty = 0; $m_amount = 0; $is_2nd = 0; 

				if($m["photo"] !=""  ){ //$section=="Guttering"

				?>
<table style='page-break-inside: avoid !important; table-row-group;'> 
	<tbody style='page-break-inside: avoid !important;'> 
		<tr style='page-break-inside: avoid !important;'>
					<tr >
						<?php if($is_uom_visible==1){ ?>
							<td colspan="9" rowspan="11" valign="middle" align="center" style="border:none; page-break-inside:avoid !important; table-row-group;"> 
							<?php }else{

							} ?>
			  			<td colspan="9" rowspan="11" valign="middle" align="center" style="border:none; page-break-inside:avoid !important; table-row-group;">
			  				<?php
				  			if($m["photo"] !="") { 
				  				echo " <img src='".JURI::base()."images/inventory/".$m['photo']."' class='' style='float:middle; margin:1px; height: 176px; max-width: 600px;'/>";
							} 
							?>
			  			</td>						

				<?php 
					//mysql_data_seek($item_result, 0); 
						
						if($prev_inv_id==""){
							$prev_inv_id = $m['inventoryid'];

						}else if($prev_inv_id == $m['inventoryid']){
							 
							$num_same_inv_id++;

						}else{
							$num_same_inv_id = 0;
						}

						$sql_1 = "SELECT id.length AS l, id.dimension_a, id.dimension_b, id.dimension_c, id.dimension_d, id.dimension_e, id.dimension_f, id.dimension_p,girth_side_a AS girth_a, girth_side_b AS girth_b FROM ver_chronoforms_data_contract_items_deminsions  AS id   WHERE projectid = '{$projectid}' AND inventoryid='{$m['inventoryid']}' LIMIT 1  OFFSET {$num_same_inv_id} ";

						/*
						//Modified query string to dicrectly get the dimension values from the defaults table
						$sql = "SELECT ((id.length_feet * 12 ) + id.length_inch) AS l, 
						        CONCAT( id.dimension_a_inch, '<br />', id.dimension_a_fraction ) AS dimension_a,
								CONCAT( id.dimension_b_inch, '<br />', id.dimension_b_fraction ) AS dimension_b,
								CONCAT( id.dimension_c_inch, '<br />', id.dimension_c_fraction ) AS dimension_c,
								CONCAT( id.dimension_d_inch, '<br />', id.dimension_d_fraction ) AS dimension_d,
								CONCAT( id.dimension_e_inch, '<br />', id.dimension_e_fraction ) AS dimension_e,
								CONCAT( id.dimension_f_inch, '<br />', id.dimension_f_fraction ) AS dimension_f,
								CONCAT( id.dimension_p_inch, '<br />', id.dimension_p_fraction ) AS dimension_p  
								FROM 
								-- ver_chronoforms_data_contract_items_default_deminsions  AS id  
								-- JOIN ver_chronoforms_data_contract_bom_vic AS b ON b.inventoryid = id.inventoryid
								ver_chronoforms_data_contract_bom_meterial_vic AS bm
								JOIN ver_chronoforms_data_contract_items_default_deminsions AS id ON id.inventoryid = bm.inventoryid
								WHERE bm.projectid = '{$projectid}' AND id.inventoryid='{$m['inventoryid']}' LIMIT 1 ";
						*/
						//re-modified query string to get all info for later output processing, instead of process output through sql query
						$sql = "SELECT ((id.length_feet * 12 ) + id.length_inch) AS l, 
					                CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_a_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_a_fraction ) AS dimension_a,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_b_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_b_fraction ) AS dimension_b,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_c_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_c_fraction ) AS dimension_c,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_d_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_d_fraction ) AS dimension_d,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_e_fraction ) AS dimension_e,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_f_fraction ) AS dimension_f,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_g_fraction ) AS dimension_g,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_h_fraction ) AS dimension_h,
					        		CONCAT( (FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_inch,'/',-2),2)+0))))), '&nbsp;&nbsp;', id.dimension_p_fraction ) AS dimension_p, 
								(id.dimension_a_inch + id.dimension_c_inch + id.dimension_e_inch + id.dimension_f_inch + id.dimension_g_inch + id.dimension_h_inch + id.dimension_p_inch) AS girth_side_a_inch,		
								CASE									
									WHEN 
										(((FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))) 
										 >= 1)
								THEN
								CONCAT(
									(FLOOR (32) * (
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))
										) - 32),'/',32
									) 
								ELSE 
								CONCAT(
									(FLOOR (32) * (
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))
										)),'/',32
									) 
								END AS girth_side_a_fraction,
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) )) AS girth_side_a_fraction_total,
								SUBSTRING_INDEX(
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_a_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_c_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))
								,'.',1)
								AS girth_side_a_fraction_total_whole,	
								(id.dimension_b_inch + id.dimension_d_inch + id.dimension_e_inch + id.dimension_f_inch + id.dimension_g_inch + id.dimension_h_inch + id.dimension_p_inch) AS girth_side_b_inch,								
								CASE									
									WHEN 
										(((FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))) 
										 >= 1)
								THEN
								CONCAT(
									(FLOOR (32) * (
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))
										) - 32),'/',32
									) 
								ELSE 
								CONCAT(
									(FLOOR (32) * (
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
										(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))
										)),'/',32
									) 
								END AS girth_side_b_fraction,
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) )) AS girth_side_b_fraction_total,
								SUBSTRING_INDEX(
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_b_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_d_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_e_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_f_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_g_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_h_fraction,'/',2),2)+0)),0) )) +
								(FLOOR (1) * (COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',-2),2)+0) / (RIGHT (SUBSTRING_INDEX(id.dimension_p_fraction,'/',2),2)+0)),0) ))
								,'.',1)
								AS girth_side_b_fraction_total_whole,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_a_inch,'/',-2),2)+0))) AS dimension_a_inch, id.dimension_a_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_b_inch,'/',-2),2)+0))) AS dimension_b_inch , id.dimension_b_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_c_inch,'/',-2),2)+0))) AS dimension_c_inch, id.dimension_c_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_d_inch,'/',-2),2)+0))) AS dimension_d_inch, id.dimension_d_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_e_inch,'/',-2),2)+0))) AS dimension_e_inch, id.dimension_e_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_f_inch,'/',-2),2)+0))) AS dimension_f_inch, id.dimension_f_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_g_inch,'/',-2),2)+0))) AS dimension_g_inch, id.dimension_g_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_h_inch,'/',-2),2)+0))) AS dimension_h_inch, id.dimension_h_fraction,
								COALESCE (((LEFT (SUBSTRING_INDEX(id.dimension_p_inch,'/',-2),2)+0))) AS dimension_p_inch, id.dimension_p_fraction 
								FROM 
									ver_chronoforms_data_contract_items_deminsions AS id
								WHERE 
									id.projectid = '{$projectid}' AND id.inventoryid='{$m['inventoryid']}' 
									AND id.cf_id = '{$m['contract_item_cf_id']}'
								LIMIT 1; -- End of query ";
						//error_log("sql G: ". $sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_sa\\my-error.log');
						 // echo $sql;
						$r_item_dimension = mysql_query ($sql);
						$item_dimension = mysql_fetch_assoc($r_item_dimension);	


						if($item_dimension["girth_side_a_fraction_total"] >= 1){
							$item_dimension["girth_side_a_inch"] += $item_dimension["girth_side_a_fraction_total_whole"];
							// $item_dimension["girth_side_a_fraction_numerator"] -= 32;
						}

						if($item_dimension["girth_side_b_fraction_total"] >= 1){
							// $item_dimension["girth_side_b_inch"] = $item_dimension["girth_side_b_inch"] + $item_dimension["girth_side_b_fraction_total_whole"];
							$item_dimension["girth_side_b_inch"] += $item_dimension["girth_side_b_fraction_total_whole"];
							// $item_dimension["girth_side_b_fraction_numerator"] -= 32;
						}
						$is_dimension = "";
						$girth_side_a_output = "";
						$girth_side_b_output = "";
						$dimension_a_output = "";
						$dimension_b_output = "";
						$dimension_c_output = "";
						$dimension_d_output = "";
						$dimension_e_output = "";
						$dimension_f_output = "";
						$dimension_g_output = "";
						$dimension_h_output = "";
						$dimension_p_output = "";
						// if(!empty($item_dimension) || $section == "Guttering" || $section == "Flashings"){
						if(!empty($item_dimension) || empty($item_dimension) || $section == "Guttering" || $section == "Flashings"){
							$is_dimension = "9";
							/*
							$girth_side_a_output = $item_dimension["girth_side_a_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["girth_side_a_fraction"]] . '"';
							$girth_side_b_output = $item_dimension["girth_side_b_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["girth_side_b_fraction"]] . '"';
							$dimension_a_output = $item_dimension["dimension_a_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_a_fraction"]] . '"';
							$dimension_b_output = $item_dimension["dimension_b_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_b_fraction"]] . '"';
							$dimension_c_output = $item_dimension["dimension_c_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_c_fraction"]] . '"';
							$dimension_d_output = $item_dimension["dimension_d_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_d_fraction"]] . '"';
							$dimension_e_output = $item_dimension["dimension_e_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_e_fraction"]] . '"';
							$dimension_f_output = $item_dimension["dimension_f_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_f_fraction"]] . '"';
							$dimension_p_output = $item_dimension["dimension_p_inch"] . '&nbsp;&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_p_fraction"]] . '"';*/



							$girth_side_a_output = ($item_dimension["girth_side_a_inch"] > 0 ? floor($item_dimension["girth_side_a_inch"]) :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["girth_side_a_fraction"]];
							$girth_side_b_output = ($item_dimension["girth_side_b_inch"] > 0 ? floor($item_dimension["girth_side_b_inch"]) : "") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["girth_side_b_fraction"]];
							$dimension_a_output = ($item_dimension["dimension_a_inch"] > 0 ? $item_dimension["dimension_a_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_a_fraction"]];
							$dimension_b_output = ($item_dimension["dimension_b_inch"] > 0 ? $item_dimension["dimension_b_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_b_fraction"]];
							$dimension_c_output = ($item_dimension["dimension_c_inch"] > 0 ? $item_dimension["dimension_c_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_c_fraction"]];
							$dimension_d_output = ($item_dimension["dimension_d_inch"] > 0 ? $item_dimension["dimension_d_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_d_fraction"]];
							$dimension_e_output = ($item_dimension["dimension_e_inch"] > 0 ? $item_dimension["dimension_e_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_e_fraction"]];
							$dimension_f_output = ($item_dimension["dimension_f_inch"] > 0 ? $item_dimension["dimension_f_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_f_fraction"]];
							$dimension_g_output = ($item_dimension["dimension_g_inch"] > 0 ? $item_dimension["dimension_g_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_g_fraction"]];
							$dimension_h_output = ($item_dimension["dimension_h_inch"] > 0 ? $item_dimension["dimension_h_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_h_fraction"]];
							$dimension_p_output = ($item_dimension["dimension_p_inch"] > 0 ? $item_dimension["dimension_p_inch"] :"") . '&nbsp;' . $config_vr_fractions_output_format[$item_dimension["dimension_p_fraction"]];


							$girth_side_a_output_decimal = ($item_dimension["girth_side_a_inch"] > -1 ? (get_mm_value(convertToDecimal($girth_side_a_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["girth_side_a_fraction"]])))).'<sup>mm</sup>' :"");
							$girth_side_b_output_decimal = ($item_dimension["girth_side_b_inch"] > -1 ? (get_mm_value(convertToDecimal($girth_side_b_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["girth_side_b_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_a_output_decimal = ($item_dimension["dimension_a_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_a_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_a_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_b_output_decimal = ($item_dimension["dimension_b_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_b_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_b_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_c_output_decimal = ($item_dimension["dimension_c_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_c_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_c_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_d_output_decimal = ($item_dimension["dimension_d_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_d_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_d_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_e_output_decimal = ($item_dimension["dimension_e_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_e_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_e_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_f_output_decimal = ($item_dimension["dimension_f_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_f_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_f_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_g_output_decimal = ($item_dimension["dimension_g_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_g_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_g_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_h_output_decimal = ($item_dimension["dimension_h_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_h_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_h_fraction"]])))).'<sup>mm</sup>' :"");
							$dimension_p_output_decimal = ($item_dimension["dimension_p_inch"] > -1 ? (get_mm_value(convertToDecimal($dimension_p_output)) + ((get_mm_value($config_vr_decimal_output_format[$item_dimension["dimension_p_fraction"]])))).'<sup>mm</sup>' :"");



							// $girth_side_a_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $girth_side_b_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $dimension_a_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $dimension_b_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $dimension_c_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $dimension_d_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $dimension_e_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $dimension_f_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";
							// $dimension_f_output != empty($girth_side_a_output) ? $girth_side_a_output . '"' : "";

					?>
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;width: 40.50;" align="center">GirthA&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($girth_side_a_output); echo ($girth_side_a_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>	
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($girth_side_a_output_decimal); echo (($girth_side_a_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>					
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">GirthB&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($girth_side_b_output); echo ($girth_side_b_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo (($girth_side_b_output_decimal)); echo (((($girth_side_b_output_decimal))) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>				
					</tr>							
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">A&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_a_output); echo ($dimension_a_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_a_output_decimal); echo (($dimension_a_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	 
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">B&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_b_output); echo ($dimension_b_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_b_output_decimal); echo (($dimension_b_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">C&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_c_output); echo ($dimension_c_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_c_output_decimal); echo (($dimension_c_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">D&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_d_output); echo ($dimension_d_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_d_output_decimal); echo (($dimension_d_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr>
					<tr > 
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">E&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_e_output); echo ($dimension_e_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_e_output_decimal); echo (($dimension_e_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">F&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_f_output); echo ($dimension_f_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_f_output_decimal); echo (($dimension_f_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">G&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_g_output); echo ($dimension_g_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_g_output_decimal); echo (($dimension_g_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">H&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_h_output); echo ($dimension_h_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_h_output_decimal); echo (($dimension_h_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr>
					<tr >
						<td colspan="1" valign="middle" align="left" style="background-color:#cccccc; height:21.10px;" align="center">P&nbsp;&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_p_output); echo ($dimension_p_output == '&nbsp;' ? '' : '"'); ?>&nbsp;</td>
						<td colspan="1" valign="middle" align="right" style="background-color:#cccccc; width: 52.50;" align="center"><?php echo ($dimension_p_output_decimal); echo (($dimension_p_output_decimal) == '&nbsp;' ? '' : ''); ?> &nbsp;</td>	
					</tr> 
			  	<?php 
			  		
			  	 	} //end if if it has a dimension
			   		
			   		$i++; 

			   		if($m["photo"] !="" ){

			   			// echo "<tr>
					  	// 		<td colspan=\"10\" style=\"border:none\">&nbsp;</td> 
					  	// 	</tr>";
						
						/*echo 
						"<tr style=\"background-color: #cccccc;\">
							  <td colspan=\"9\" style=\"border:none; page-break-after: auto; clear:both;\"></td> 
						  	</tr>*/

echo "</tr></tbody></table><br/> ";				
			   		}
					
			   	?>
<!-- </tr></tbody></table><br/> -->
			  	<?php 
			  		} //end of if it has a photo	
			  	} //end of while for the no main item materials
			  	?>

			  	<?php
					$item_result2 = mysql_query ($sql2);
					
					while ($m = mysql_fetch_assoc($item_result2)){ 
						$totalRrp += $m['ls_amount']; 
						if($m['id']==""){continue;} 
					?>  
						<!-- <tr> 
							<td colspan="2"><?php echo $m['raw_description']; ?></td>  
							<td style="text-align:right;"><?php echo number_format($m['ls_qty']); ?></td>
							<td style="text-align:right;"><?php echo ($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?get_feet_value($m['length']):($m['uom']=="Mtrs"?$m['length']:"")); ?></td>
							<td style="text-align:right;"><?php echo ($section = "Guttering"? number_format($m['m_qty']):($section = "Flashings"?number_format($m['ts_qty']):number_format($m['ls_qty']))); ?></td>
							<td style="text-align:right;"><?php echo ($section = "Guttering"? number_format($m['m_qty']):($section = "Flashings"?number_format($m['m_qty']):number_format($m['ts_qty']))); ?></td>
							<td style="text-align:right;"><?php echo number_format(($m_qty>0?$m_qty:$m['ts_qty'])); ?></td> 
							<td style="text-align:right;"><?php echo ($m['uom']=="Mtrs" && METRIC_SYSTEM == "inch"?get_feet_value($m['s_length']):($m['uom']=="Mtrs"?$m['s_length']:"")); ?></td>
							<td style="text-align:right;"><?php echo $m['uom']; ?></td> 
							<td> &nbsp; </td>
							<td> &nbsp; </td>
							<td style="text-align:right;">$<?php echo number_format($m['raw_cost'],2); ?></td>
							<td style="text-align:right;">$<?php echo number_format($m['ls_amount'],2); ?></td> 
						</tr> -->

<tr > 
	<td style="border-collapse:collapse;font-size:9.8; height: 24" colspan="2">&nbsp;<?php echo $m['raw_description']; ?></td>  
	<!-- <td style="text-align:right;"><?php echo number_format($m['s_qty']); ?></td> -->
	<!-- <td style="text-align:right;"><?php echo ($section = "Guttering"? number_format($m['m_qty']):($section = "Flashings"?number_format($m['ts_qty']):number_format($m['ls_qty']))); ?></td> -->
	<td style="border-collapse:collapse;font-size:9.8;text-align:right;"><?php echo number_format($m['ls_qty']); ?>&nbsp;&nbsp;</td> 
	<td style="border-collapse:collapse;font-size:9.8;text-align:right;"><?php echo ($m['uom']=="Inches" && METRIC_SYSTEM == "inch"?get_feet_value($m['1_length']):($m['uom']=="Inches"?$m['1_length']:"")); ?>&nbsp;&nbsp;</td>
	<td style="border-collapse:collapse;font-size:9.8;text-align:right;"><?php echo $config_vr_fractions_output_format[$m['length_fraction']]; echo ($config_vr_fractions_output_format[$m['length_fraction']] > 0 ? '"' : ''); ?>&nbsp;&nbsp;</td>
	<!-- <td style="border-collapse:collapse;font-size:9.8;text-align:right;"><?php echo $config_vr_fractions_output_format[$m['length_fraction']]; ?>&nbsp;&nbsp;</td>  -->
	<td style="border-collapse:collapse;font-size:9.8;text-align:center;"> <?php echo $m['uom']; ?>&nbsp;&nbsp;</td> 
	<td> &nbsp; </td>
	<td> &nbsp; </td>
	<td style="border-collapse:collapse;font-size:9.8;text-align:right;">$<?php echo number_format($m['raw_cost'],2); ?>&nbsp;&nbsp;</td>
	<td style="border-collapse:collapse;font-size:9.8;text-align:right;">$<?php echo number_format($m['ls_amount'],2); ?>&nbsp;&nbsp;</td> 
</tr>
					
<tr>

</tr>
			  	<?php

				
			} // end of loop of m	

				?>
  
		<?php //} //------------ bm END contract_bom_vic loop. 

			$gst = $totalRrp * 0.1;
			$totalSum = $totalRrp + $gst;

		 ?>  	
</table>


<br/>
<?php


	$summary_total = "";
	$summary_total .= '	 
	 	<tr>
	 		<td width="250" colspan="2">
				&nbsp;&nbsp; 
			</td>
			<td width="50">
				&nbsp;&nbsp; 
			</td>
			<td width="50">
				 &nbsp;&nbsp;
			</td>
			<td width="40">
				 &nbsp;&nbsp;
			</td> 
			 
			<td  colspan="2" style="text-align:right" width="120">
				<span><b>Sub Total</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
			</td> 
			<td style="text-align:right" width="90">
			 	'.number_format($totalRrp,2).'
			</td>
		</tr>
		<tr>
			<td colspan="7" style="text-align:right"> 
				<span ><b>GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			 	
			<td style="text-align:right">
			 	'.number_format($gst,2).'
			</td>
		</tr>
		<tr>
			<td colspan="7" style="text-align:right"> 
				<span  ><b>Total Inclusive of GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		 			
			<td style="text-align:right">
			 	'.number_format($totalSum,2).'
			</td>
		</tr>';  


	
	$summary_footer = "";
	$summary_footer .= '	
	<br/><br/>
	Measurement Tolerance - 0m / + 1mm &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Length Tolerance - 0m / + 10mm <br/>
	NOTE: all folds are 90&deg; unless otherwise stated';


		$summary_total_first_ = "";
		$summary_total_first_ .= '
		 <tr><td height="18" colspan="10" style="border-style: ; border-bottom-color: #eee;"></td></tr> 
		 <br/>
		  	<tr >								 		 
		 		<td  colspan="8" style="text-align:right;border-style: ; border-bottom-color: #eee;" >
		 			<span><b>Sub Total</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
		 		</td> 
		 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
		 		 	$'.number_format($totalRrp,2).' &nbsp;&nbsp;
		 		</td>
		 	</tr>
		 	<tr>
		 		<td colspan="8" style="text-align:right;border-style: ; border-bottom-color: #eee;"> 
		 			<span ><b>GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
		 		</td>								 		 	
		 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
		 		 	$'.number_format($gst,2).' &nbsp;&nbsp;
		 		</td>								 		
		 	</tr>
		 	<tr >
		 		<td colspan="8" style="text-align:right;border-style: ; border-bottom-color: #eee;"> 
		 			<span  ><b>Total Inclusive of GST</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
		 		</td>								 	 			
		 		<td colspan="2" style="text-align:right;border-style: ; border-bottom-color: #eee;">
		 		 	$'.number_format($totalSum,2).' &nbsp;&nbsp;
		 		</td>								 		
		 	</tr>  

	 	<tr><td height="18" colspan="10" style="border-bottom-color: #eee;"></td></tr> 
		 <tr style="vertical-align: bottom;border-style: ;border-top-color: #fff; page-break-after:always;">
		 	<td colspan="10" style="padding: 5px 0px 0px 75px; vertical-align: bottom;border-top-color: #eee;">
		 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NOTE: 
		 		&nbsp; &nbsp; 1. &nbsp; All folds are 90&deg; unless otherwise stated.  <br/>
		 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
		 		&nbsp; All breaks are 10&deg; unless otherwise stated.   <br/>
		 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. &nbsp; Measurement Tolerance - 0m / + 1mm  <br/>

		 		</td>								 		
		 </tr> ';
	
	// echo '<table width="100%">';
	// echo $summary_total;
	// echo '</table>';
	// echo $summary_footer;
	// if($m["photo"] !="" && $count > 1 && $is_uom_visible == 0) { 
	if($is_uom_visible == 1) { 
		echo '<table width="100%">';
		echo $summary_total_first_;
		// echo $summary_total;
		echo '</table>';
		// echo $summary_footer;
	}else{
		// echo $summary_footer;
	}

	?>
	<!-- echo $summary_footer; -->


<!-- 
<table width="100%"> 
 
 	<tr>
 		<td width="250" colspan="2">
			&nbsp;&nbsp; 
		</td>
		<td width="50">
			&nbsp;&nbsp; 
		</td>
		<td width="50">
			 &nbsp;&nbsp;
		</td>
		<td width="40">
			 &nbsp;&nbsp;
		</td> 
		 
		<td  colspan="2" style="text-align:right" width="120">
			<span><b>Sub Total</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
		</td> 
		<td style="text-align:right" width="90">
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
 -->


</div> 
</textarea>
<input type="submit" class="btn " name="add" id="add1" value="Download PDF" onClick="window.opener.location.replace(redirectUrl);
window.close;"> 
<input class="btn" type="button" value="Close" onClick="window.opener=null; window.close(); return false;">

<!-- echo('<script language="Javascript">window.opener.parent.location.href = opener.window.location.href + "&titleID='.$titleID.'"; window.close();</script>'); -->

<!-- <?php echo "<a href=\"".JURI::base()."contract-listing-vic/contract-folder-vic/contract-po-vic?quoteid=".$quoteid."&projectid=".$projectid."&page_name=po&view=summary\" class='btn ".($page_name=="po" && $is_summary_view==1?"btn-disabled":"")."'>&nbsp;&nbsp; PO Summary &nbsp;&nbsp;</a>&nbsp;"; ?> -->

</form>
</body>
</html>


<?php
	
function get_feet_value($inches){
	return floor($inches / 12)."&rsquo;" . floor($inches % 12);
     
}

function get_feet_whole($inches){
	return floor($inches / 12);
     
}

function get_feet_inch($inches){
	return floor($inches % 12);
     
}

function get_mm_value($inches){
	// return floor($inches * 25.4);
	$inches = $inches + ($feet * 12);
	return round($inches / 0.0393700787,1);
     
}

function feetInchesToMillimeters($feetinches,$precision = 2) {
   list($feet,$inches) = explode("&rsquo;",$feetinches);
   $inches = preg_replace('/[^0-9.]/','',$inches);
   $inches = $inches + ($feet * 12);
   return round($inches / 0.0393700787,$precision);
   // return floor($inches / 0.0393700787,$precision);
}

/*function feetInchesToMillimetersDimension($feetinches,$precision = 2) {
   list($feet,$inches) = explode("&nbsp;&nbsp;",$feetinches);
   $inches = preg_replace('/[^0-9.]/','',$inches);
   $inches = $inches + ($feet * 12);
   return round($inches / 0.0393700787,$precision);
   // return floor($inches / 0.0393700787,$precision);
}*/

/*function feetInchesToMillimetersDimension1($inchesfraction,$precision = 2) {
   list($inches,$fraction) = explode(".",$inchesfraction);
   $fraction = preg_replace('/[^0-9.]/','',$fraction);
   $fraction = $fraction + ($inches * 1);
   //$fraction = ($inches);
   // $fraction = round(($fraction * .100),0);
   // $fraction = ($fraction  / 10);
   return round($fraction ,$precision);
   // return floor($inches / 0.0393700787,$precision);
}*/

function convertToDecimal($fraction)
{
    $numbers=explode(".",$fraction);
    return round($numbers[0]+($numbers[1]*1),6);
}
 
?> 