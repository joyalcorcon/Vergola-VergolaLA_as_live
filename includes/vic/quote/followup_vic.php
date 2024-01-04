<?php  
$resultff = mysql_query("SELECT * FROM ver_chronoforms_data_followup_vic WHERE cf_id  = '$cf_id'");
$retrieveff = mysql_fetch_array($resultff);
if (!$resultff) {die("Error: Data not found..");}
	$DateQuote = $retrieveff['quotedate']; //"NOW()" ;
	$DateDelivered = $retrieveff['qdelivered'];
	$DateFF1 = $retrieveff['ffdate1'] ;
	$DateFF2 = $retrieveff['ffdate2'] ;
	$DateFF3 = $retrieveff['ffdate3'] ;
	//$Status = $retrieveff['status'] ; 	 
	$date_contract_signed = $retrieveff['date_contract_signed'] ;
	$appointmentdate = "";
 
	$ProjectID = $retrieveff['projectid'];
	$ProjectName = mysql_real_escape_string($retrieveff['project_name']);
	$current_date = date('Y-m-d H:i:s');
	$SalesRep = $retrieveff['sales_rep'];
	$rep_id = $retrieveff['rep_id'];
	$FrameworkType = $retrieveff['framework_type'];
	$SubTotalVergola = $retrieveff['subtotal_vergola'];
	$SubTotalDis = $retrieveff['subtotal_disbursement'];
	$TotalRRP = $retrieveff['total_rrp'];
	$TotalRRPGST = $retrieveff['total_rrp_gst'];
	$TotalCOST = $retrieveff['total_cost'];
	$TotalCOSTGST = $retrieveff['total_cost_gst'];
	$SalesComm = $retrieveff['sales_comm'];
	$InstallComm = $retrieveff['install_comm'];
	$SalesCommCOST = $retrieveff['sales_comm_cost'];
	$InstallCommCOST = $retrieveff['install_comm_cost'];
	$is_builder_project = $retrieveff['is_builder_project'];
	
	
	//if ($QuoteIDAlpha == 'CRV') {
	$resultclient = mysql_query("SELECT * FROM ver_chronoforms_data_clientpersonal_vic WHERE clientid  = '$QuoteID'");
    $retrieveclient = mysql_fetch_array($resultclient);
	
    if (!$resultclient) {die("Error: Data not found..");}
	// if (empty($Status)) { $resultclient['status'] ;} 	 
    if($retrieveclient['is_builder']==1){
    	$CustomerName = $retrieveclient['builder_name'];
		
    }else{
    	$CustomerName = $retrieveclient['client_lastname'].", ".$retrieveclient['client_firstname'];
    }
	
	$Status_ = "";
	if($retrieveff['status'] != ""){
		$Status_ = $retrieveff['status'];
	}else{
		$Status_ = $retrieveclient['status'];
		}
	
	$SiteAddress = $retrieveclient['site_address1']." ".$retrieveclient['site_address2']."<br />".$retrieveclient['site_suburb']." ".$retrieveclient['site_state']." ".$retrieveclient['site_postcode'];
	$appointmentdate = $retrieveclient['appointmentdate'];


	$PreviousDateDelivered = $retrieveff['qdelivered'];
	$PreviousQuoteStatus = $Status_;
	$PreviousCustomisationOptions = $retrieveff['customisation_options'];
	if (trim($appointmentdate) == '' || substr($appointmentdate, 0, strlen('0000-00-00')) == '0000-00-00') {
		$appointmentdate = '';
	} else {
		$appointmentdate = date(PHP_DFORMAT,strtotime($appointmentdate));
	}
	if (trim($DateDelivered) == '' || substr($DateDelivered, 0, strlen('0000-00-00')) == '0000-00-00') {
		$DateDelivered = '';
	} else {
		$DateDelivered = date(PHP_DFORMAT,strtotime($DateDelivered));
	}
	if (trim($DateFF1) == '' || substr($DateFF1, 0, strlen('0000-00-00')) == '0000-00-00') {
		$DateFF1 = '';
	} else {
		$DateFF1 = date(PHP_DFORMAT,strtotime($DateFF1));
	}
	if (trim($date_contract_signed) == '' || substr($date_contract_signed, 0, strlen('0000-00-00')) == '0000-00-00') {
		$date_contract_signed = '';
	} else {
		$date_contract_signed = date(PHP_DFORMAT,strtotime($date_contract_signed));
	}


	//} 
	// else {
	// 	$resultbuilder = mysql_query("SELECT * FROM ver_chronoforms_data_builderpersonal_vic WHERE builderid  = '$QuoteID'");
 //        $retrievebuilder = mysql_fetch_array($resultbuilder);
 //        if (!$resultbuilder) {die("Error: Data not found..");}
	// 	$CustomerName = $retrievebuilder['builder_name'];
	// 	$SiteAddress = $retrievebuilder['site_address1']." ".$retrievebuilder['site_address2']."<br />".$retrievebuilder['site_suburb']." ".$retrievebuilder['site_state']." ".$retrievebuilder['site_postcode'];	
	// }

	//error_log("appointmentdate: ".$appointmentdate, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	
    $resulttype = mysql_query("SELECT * FROM ver_chronoforms_data_quote_vic WHERE projectid  = '$ProjectID' GROUP BY projectid");
    $retrievetype = mysql_fetch_array($resulttype);
    if (!$resulttype) {die("Error: Data not found..");}
	
	$FrameWork = $retrievetype['framework'];


if(isset($_POST['save'])){ //$cf_id is the id of the selected costing. if no cf_id no need to go in here.

	$cf_id = $_POST['cf_id']; 
	$date =  $_POST['qdelivered']; 
	$timestamp = date('Y-m-d H:i:s', strtotime($date));
	$SETDateDelivered = $timestamp;

	$date1 =  $_POST['appointmentdate']; 
	$timestamp1 = date('Y-m-d H:i:s', strtotime($date1)); 
	$appointmentdate = $timestamp1;
	//error_log(" appointmentdate: ".$appointmentdate, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 

	$date1 =  $_POST['ffdate1']; 
	$timestamp1 = date('Y-m-d H:i:s', strtotime($date1)); 
	$SETDateFF1 = $timestamp1;


	$date2 =  $_POST['ffdate2']; 
	$timestamp2 = date('Y-m-d H:i:s', strtotime($date2)); 
	$SETDateFF2 = $timestamp2;

	$date3 =  $_POST['ffdate3']; 
	$timestamp3 = date('Y-m-d H:i:s', strtotime($date3));
	$SETDateFF3 = $timestamp3;  

	$date_contract_signed =  $_POST['date_contract_signed']; 
	$set_date_contract_signed = date('Y-m-d', strtotime($date_contract_signed)); 
	 
	if($cf_id>0){  
		$sql = "UPDATE ver_chronoforms_data_followup_vic SET 
		updated_at = NOW(),  
		ffdate1 = ".(!empty($_POST['ffdate1']) ? "'$SETDateFF1'" : "NULL").", 
		ffdate2 = ".(!empty($_POST['ffdate2']) ? "'$SETDateFF2'" : "NULL").", 
		ffdate3 = ".(!empty($_POST['ffdate3']) ? "'$SETDateFF3'" : "NULL").", 
		qdelivered = ".(!empty($_POST['qdelivered']) ? "'$SETDateDelivered'" : "NULL").", 
		date_contract_signed = ".(!empty($_POST['date_contract_signed']) ? "'$set_date_contract_signed'" : "NULL").",
		status = '".$_POST['status']."'";
		if($_POST['status']=="Won"){
			$sql .= ", date_won=CURDATE() ";
		}
		$sql .= " WHERE cf_id = {$cf_id}";
		//error_log("SAVE followup: ". $sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
		mysql_query($sql)or die(mysql_error()); 
	}
	//Set all quote created to the next followup inputed. to unite all followup date from quotes to client table followup. this is use in checking the status in home page to do list.
	$sql = "UPDATE ver_chronoforms_data_followup_vic SET 
	ffdate1 = ".(!empty($_POST['ffdate1']) ? "'$SETDateFF1'" : "NULL")."";
	$sql .= " WHERE quoteid = '{$QuoteID}'";
	mysql_query($sql)or die(mysql_error()); 
 

 	$sql = "UPDATE ver_chronoforms_data_clientpersonal_vic SET 
		// appointmentdate = ".(!empty($_POST['appointmentdate']) ? "'$appointmentdate'" : "NULL").", 
		appointmentdate = ".(!empty($_POST['appointmentdate']) ? "0000-00-00 00:00:00" : "NULL").", 
		next_followup = ".(!empty($_POST['ffdate1']) ? "'$SETDateFF1'" : "NULL").",
		qdelivered = ".(!empty($_POST['qdelivered']) ? "'$SETDateDelivered'" : "NULL").", 
		date_contract_signed = ".(!empty($_POST['date_contract_signed']) ? "'$set_date_contract_signed'" : "NULL").",
		status = '".$_POST['status']."'
		WHERE clientid = '{$QuoteID}' "; 
	//error_log("SAVE client: ". $sql, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	mysql_query($sql)or die(mysql_error()); 


	if(isset($_REQUEST['ref'])){
      $ref = $_REQUEST['ref']; 
      header('Location:'.JURI::base().$ref); 
       //echo ('<script language="Javascript">opener.window.location.reload(); window.close();</script>'); //opener.window.location.reload(false);
       
    }else{
      header('Location:'.JURI::base().'client-listing-vic/client-folder-vic?pid='.$id); 
    }
 	
 	return;

}	
 
 

if(isset($_POST['contract'])){
	$q_date = mysql_real_escape_string($_POST['qdelivered']); 
	$qdelivered = date(PHP_DFORMAT.'H:i:s', strtotime($q_date)); 

	mysql_query("START TRANSACTION");

	$rfollowup = mysql_query("UPDATE ver_chronoforms_data_followup_vic SET status = 'Won', date_contract_system_created=CURDATE() WHERE cf_id = '$cf_id'")or die(mysql_error());

	$rclient = mysql_query("UPDATE ver_chronoforms_data_clientpersonal_vic SET status = 'Won' WHERE clientid = '{$QuoteID}' "); 
	
	$querylists = "INSERT INTO ver_chronoforms_data_contract_list_vic 
	          (quoteid, 
			   projectid,
			   quotedate, 
			   contractdate, 
			   customer_name, 
			   site_address, 
			   sales_rep, 
			   project_name, 
			   framework_type, 
			   framework,
			   subtotal_vergola,
			   subtotal_disbursement, 
			   total_rrp, 
			   total_rrp_gst, 
			   total_cost,
			   total_cost_gst, 
			   sales_comm,
			   install_comm, 
			   sales_comm_cost, 
			   install_comm_cost,
			   rep_id,
			   date_won,
			   is_builder_project) 
			   
			   VALUES 
			   ('$QuoteID',
				'$ProjectID',
				'$DateQuote',
				'$current_date',
				'$CustomerName',
				'$SiteAddress',
				'$SalesRep',
				'$ProjectName',
				'$FrameworkType',
				'$FrameWork',
				'$SubTotalVergola',
				'$SubTotalDis',
				'$TotalRRP',
				'$TotalRRPGST',
				'$TotalCOST',
				'$TotalCOSTGST',
				'$SalesComm ',
				'$InstallComm',
				'$SalesCommCOST',
				'$InstallCommCOST',
				'$rep_id',
				 CURDATE(),
				'$is_builder_project')";

	$rcontract = mysql_query($querylists) or trigger_error("Insert failed: " . mysql_error());
	 
	 
	 $querydetails = "INSERT INTO ver_chronoforms_data_contract_details_vic 
	          (quoteid, 
			   projectid,
			   quotedate, 
			   contractdate) 
			   
			   VALUES 
			   ('$QuoteID',
				'$ProjectID',
				'$DateQuote',
				'$current_date'
				)";
 
    $rcdetails = mysql_query($querydetails) or trigger_error("Insert failed: " . mysql_error());
	 
	 $queryvergola = "INSERT INTO ver_chronoforms_data_contract_vergola_vic 
	          (quoteid, 
			   projectid,
			   quotedate, 
			   contractdate) 
			   
			   VALUES 
			   ('$QuoteID',
				'$ProjectID',
				'$DateQuote',
				'$current_date'
				)";
 
    $rcvergola = mysql_query($queryvergola) or trigger_error("Insert failed: " . mysql_error());
	 
	 $querystatutory = "INSERT INTO ver_chronoforms_data_contract_statutory_vic 
	          (quoteid, 
			   projectid,
			   quotedate, 
			   contractdate)  
			   VALUES 
			   ('$QuoteID',
				'$ProjectID',
				'$DateQuote',
				'$current_date'
				)";
 
    $rcstatutory = mysql_query($querystatutory) or trigger_error("Insert failed: " . mysql_error());
	 
	 $query = "INSERT INTO ver_chronoforms_data_contract_items_vic 
	          (quoteid, 
			   inventoryid,
			   projectid, 
			   project_name, 
			   framework_type,
			   framework, 
			   length_feet, 
			   length_inch, 
			   length_fraction, 
			   description,
			   colour,
			   qty,
			   webbing,
			   finish,
			   uom,
			   rrp,
			   cost, 
			   is_additional, 
			   customisation_options)
			   (SELECT 
			   q.quoteid,
			   q.inventoryid,
			   q.projectid, 
			   q.project_name,
			   q.framework_type,
			   q.framework, 
			   q.length_feet, 
			   q.length_inch, 
			   q.length_fraction, 
			   q.description,
			   q.colour,
			   q.qty,
			   q.webbing,
			   q.finish,
			   q.uom,
			   q.rrp, 
			   q.cost, 
			   q.is_additional, 
			   q.customisation_options 
               FROM ver_chronoforms_data_quote_vic AS q  WHERE projectid = '$ProjectID' and qty !='0.00')";
	
	//exclude mds.supplierid bec a inventoryid item does not need to set a supplier id, it is the raw id it is set.
	// LEFT JOIN (SELECT * FROM ver_chronoforms_data_material_default_supplier_vic GROUP BY inventoryid) AS mds ON mds.inventoryid=q.inventoryid
 	//error_log($query, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
    $rcitems = mysql_query($query) or trigger_error("Insert failed: " . mysql_error());
 
   	//error_log("rfollowup:".$rfollowup. " rclient:".$rclient." rcontract:".$rcontract." rcdetails:".$rcdetails." rcvergola:".$rcvergola." rcstatutory:".$rcstatutory." rcitems:".$rcitems , 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');

    if ($rfollowup AND $rclient AND $rcontract AND $rcdetails AND $rcvergola AND $rcstatutory AND $rcitems) {
	    mysql_query("COMMIT");
	} else {        
	    mysql_query("ROLLBACK");
	}
 	
 	//INSERT data for items default dimensions. Should Insert after transaction to get the data from ver_chronoforms_data_contract_items_vic.
    $queryitems = "INSERT INTO ver_chronoforms_data_contract_items_deminsions 
	          ( 
	          	cf_id,
	          	quoteid, 
	          	projectid, 
			    inventoryid,  
			    length_feet, 
			    length_inch, 
			    length_fraction, 
				dimension_a_inch, 
				dimension_a_fraction, 
				dimension_b_inch, 
				dimension_b_fraction, 
				dimension_c_inch, 
				dimension_c_fraction, 
				dimension_d_inch, 
				dimension_d_fraction, 
				dimension_e_inch, 
				dimension_e_fraction, 
				dimension_f_inch, 
				dimension_f_fraction, 
				dimension_p_inch, 
				dimension_p_fraction 
			  ) 
			   (SELECT 
				c.cf_id,
				c.quoteid, 
				c.projectid, 
				c.inventoryid,  
				c.length_feet, 
				c.length_inch, 
				c.length_fraction, 
				idd.dimension_a_inch, 
				idd.dimension_a_fraction, 
				idd.dimension_b_inch, 
				idd.dimension_b_fraction, 
				idd.dimension_c_inch, 
				idd.dimension_c_fraction, 
				idd.dimension_d_inch, 
				idd.dimension_d_fraction, 
				idd.dimension_e_inch, 
				idd.dimension_e_fraction, 
				idd.dimension_f_inch, 
				idd.dimension_f_fraction, 
				idd.dimension_p_inch, 
				idd.dimension_p_fraction 
			   FROM (
					SELECT * 
					FROM ver_chronoforms_data_contract_items_vic 
					WHERE projectid = '{$ProjectID}') AS c 
						LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=c.inventoryid 
						LEFT JOIN ver_chronoforms_data_contract_items_default_deminsions as idd ON i.inventoryid=idd.inventoryid 
					WHERE c.projectid = '{$ProjectID}' and c.qty !='0.00' AND i.section='Guttering' OR i.section='Flashings'
				) ";
 	//error_log($queryitems, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
     mysql_query($queryitems) or trigger_error("Insert failed: " . mysql_error());

		
	 
	header('Location:'.JURI::base().'contract-listing-vic/contract-folder-vic?quoteid='.$QuoteID."&projectid=".$ProjectID);}
	 

	echo "<div id=\"innerbox\"";
	//if ($cf_id != '') { echo "style=\"display:block\"";} else {echo "style=\"display:none\"";}
	echo">";
	
	// Test Begin
	// $Status_? echo "Follow-up": echo "Costing"; 
	// !empty($retrieveff['status'])?$retrieveff['status']:$retrieveclient['status'] ; 	 
	
	// !empty($Status)? $Status : !empty($retrieveff['status'])?$retrieveff['status']:$retrieveclient['status'] ; 
	
	
			// if (!empty($retrieveff['status'])){
							// alert("True");
							// $Status_= $retrieveff['status'];
						// }else{
							// alert('False');
							// $Status_= $resultclient['status']; 	 
						// }				
			// alert(!empty($Status)?$Status:empty($retrieveff['status'])?$retrieveclient['status']:$retrieveclient['status']); 
	if(!$isfollowup_btn = false && !empty($Status_)){
		$Status = $Status_;
	}
		
	// echo "<table class=\"table-ff\"><tr><th>Project Name: <span class=\"subhead\">".$ProjectName."</span></th><th>Project Status: <span class=\"subhead\">".
															// // !empty($Status)?$Status:empty($retrieveff['status'])?$retrieveclient['status']:$retrieveclient['status']
															// $Status_
															// ."</span></th></tr>";
	// Test End
	
	echo "<table class=\"table-ff\"><tr><th>Project Name: <span class=\"subhead\">".$ProjectName."</span></th><th>Project Status: <span class=\"subhead\">".$Status."</span></th></tr>";


	echo "<input type=\"hidden\" id=\"previous_date_delivered\" name=\"previous_date_delivered\" value=\"" . $PreviousDateDelivered . "\" />";
	echo "<input type=\"hidden\" id=\"previous_quote_status\" name=\"previous_quote_status\" value=\"" . $PreviousQuoteStatus . "\" />";
	echo "<input type=\"hidden\" id=\"contract_lost_reason\" name=\"contract_lost_reason\" value=\"\" />";
	echo "<input type=\"hidden\" id=\"previous_customisation_options\" name=\"previous_customisation_options\" value=\"" . $PreviousCustomisationOptions . "\" />";
	echo "<input type=\"hidden\" id=\"current_quote_id\" name=\"current_quote_id\" value=\"" . $QuoteID . "\" />";
	echo "<input type=\"hidden\" id=\"current_project_id\" name=\"current_project_id\" value=\"" . $ProjectID . "\" />";

	echo "<tr><td><span class=\"ffinfo\"><label>Appointment Date</label><input type=\"text\" value=\"" . $appointmentdate . "\" name=\"appointmentdate\" class=\"date_entered\" autocomplete=\"off\" readonly=\"readonly\" /></span>";
	echo "<span class=\"ffinfo\"><label>Date Delivered</label><input type=\"text\" value=\"" . $DateDelivered . "\" name=\"qdelivered\" class=\"date_entered\" autocomplete=\"off\" /></span>";
	echo " <span class=\"ffinfo\"><label>Next Follow Up</label><input type=\"text\" value=\"" . $DateFF1 . "\" name=\"ffdate1\" class=\"date_entered\" autocomplete=\"off\" /></span>";
	echo "<span class=\"ffinfo\"><label>Contract Delivered/Signed</label><input type=\"text\" value=\"" . $date_contract_signed . "\" name=\"date_contract_signed\" class=\"date_entered\" autocomplete=\"off\" /></span>";


	/*
	 error_log("Status: 2". $Status, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
	// Get Date Quote 
	//error_log("appointmentdate: ".$appointmentdate, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');

	if ($appointmentdate != "" && $appointmentdate != '0000-00-00 00:00:00') {
		echo "<tr><td><span class=\"ffinfo\"><label>Appointment Date</label><input type=\"text\" value=\"".date(PHP_DFORMAT,strtotime($appointmentdate))."\" name=\"appointmentdate\" class=\"date_entered\" autocomplete=\"off\" readonly=\"readonly\" /></span>";
	}else{
		echo "<tr><td><span class=\"ffinfo\"><label>Appointment Date</label><input type=\"text\" value=\"\" name=\"appointmentdate\" class=\"date_entered\" autocomplete=\"off\" readonly=\"readonly\" /></span>";
	}	
	// Get Quote Delivered
	if ($DateDelivered != "") {
	echo "<span class=\"ffinfo\"><label>Quote Delivered</label><input type=\"text\" value=\"".date(PHP_DFORMAT,strtotime($DateDelivered))."\" name=\"qdelivered\" class=\"date_entered\" autocomplete=\"off\" /></span>";} 
	else { echo "<span class=\"ffinfo\"><label>Date Delivered</label><input type=\"text\" value=\"\" name=\"qdelivered\" class=\"date_entered\" autocomplete=\"off\" /></span>";}
	
	// Get Follow Up Date 1
	if ($DateFF1 != "") {
	echo "<span class=\"ffinfo\"><span class=\"ffinfo\"><label>Next Follow up</label><input type=\"text\" value=\"".date(PHP_DFORMAT,strtotime($DateFF1))."\" name=\"ffdate1\" class=\"date_entered\" autocomplete=\"off\" /></span>"; }
	else {echo " <span class=\"ffinfo\"><label>Next Follow Up</label><input type=\"text\" value=\"\" name=\"ffdate1\" class=\"date_entered\" autocomplete=\"off\" /></span>";}

	if ($date_contract_signed != "") {
	echo "<span class=\"ffinfo\"><label>Contract Delivered/Signed</label><input type=\"text\" value=\"".date(PHP_DFORMAT,strtotime($date_contract_signed))."\" name=\"date_contract_signed\" class=\"date_entered\" autocomplete=\"off\" /></span>";} 
	else { echo "<span class=\"ffinfo\"><label>Contract Delivered/Signed</label><input type=\"text\" value=\"\" name=\"date_contract_signed\" class=\"date_entered\" autocomplete=\"off\" /></span>";} 
	*/
	echo "</td><td>";
	 
	

	$user = JFactory::getUser();
	$groups = $user->get('groups');

	if(isset($user->groups['9'])){
		$is_admin = 0;
	}else{
		$is_admin = 1;
	}

// foreach($groups as $group) {
//     if($group == '10'){echo "<input type=\"submit\" value=\"Create Contract\" name=\"contract\" id=\"contract\" />";} else { echo "";}
// }

	 

	//echo "Status   ";
	$select_status = "<select name='status' class='cbo_status' onchange='' >"; 
		$select_status .= "<option value='Won' ".(strtolower($Status)=="won"?"selected":"")." >Won</option>";
		$select_status .= "<option value='Lost' ".(strtolower($Status)=="lost"?"selected":"")." >Lost</option>";
		$select_status .= "<option value='Quoted' ".(strtolower($Status)=="quoted"?"selected":"")." >Costing</option>";
		$select_status .= "<option value='Quote Delivered' ".(strtolower($Status)=="quote delivered"?"selected":"")." >Quote Delivered</option>"; 
		$select_status .= "<option value='Future' ".(strtolower($Status)=="future"?"selected":"")." >Future</option>";
	$select_status .= "</select>";

	//echo $select_status; 
 	echo " <input type=\"hidden\" value=\"{$Status}\" name=\"status\" id=\"costing_status\" />";
	
	
	// echo " <input type=\"disabled\" value=\"{$Status}\" name=\"status\" id=\"costing_status\" />";
	// echo "<input type=\"hidden\" value=\'Future' ".(strtolower($Status)=="future"?"selected":"")."\  class=\"submit-look\"  onclick=\"setCostingStatusAndSubmit('Not Interested')\" />";

	$isfollowup_btn = false;
	//process user_access_profiles
	if ($current_signed_in_user_access_profiles['tab follow up']['project status'] == true) {
		echo "<input type=\"button\" value=\"Not Interested \"  class=\"submit-look\"  onclick=\"setCostingStatusAndSubmit('Not Interested')\" />";		
		echo "<input type=\"hidden\" ".(strtolower($ProjectName)==""?"disabled":"")." value=\"Costed\" class=\"submit-look\" onclick=\"setCostingStatusAndSubmit('Costed')\"/>";
		echo "<input type=\"hidden\" ".(strtolower($ProjectName)==""?"disabled":"")." value=\"Quoted\" class=\"submit-look\"  onclick=\"setCostingStatusAndSubmit('Quoted')\" />";
		echo "<input type=\"button\" ".(strtolower($ProjectName)==""?"disabled":"")." value=\"Under Consideration\" class=\"submit-look\"  onclick=\"setCostingStatusAndSubmit('Under Consideration')\" />";
		echo "<input type=\"button\" ".(strtolower($ProjectName)==""?"disabled":"")." value=\"Future Project\"  class=\"submit-look\" onclick=\"setCostingStatusAndSubmit('Future Project')\" />";
		//echo "<input type=\"button\" ".(strtolower($ProjectName)==""?"disabled":"")." value=\"Won\" class=\"submit-look\" onclick=\"setCostingStatusAndSubmit('Won')\"/>";
		echo "<input type=\"button\" ".(strtolower($ProjectName)==""?"disabled":"")." value=\"Lost\" class=\"submit-look\" onclick=\"setCostingStatusAndSubmit('Lost')\"/>";
		$isfollowup_btn = true;
	} //end if

	// if($is_admin==1){
	// 	echo "<input type=\"submit\" value=\"Create Contract\" name=\"contract\" id=\"contract\"  />";
	// }

	//process user_access_profiles
	if ($current_signed_in_user_access_profiles['tab follow up']['create contract'] == true) {
		echo "<input type=\"submit\" value=\"Create Contract\" name=\"contract\" id=\"contract\"  />";
	} //end if
	 
   echo "</td></tr></table>";
	
	echo "</div>";
 

?>