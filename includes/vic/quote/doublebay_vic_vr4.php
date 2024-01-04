<?php
// if($_POST['framework'] != "Double Bay VR2"){
// 	 error_log("incorrect vr2: ".$_POST['framework'], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
// 	 //$framework = "Double Bay VR2"; //set default value for get default item in database.
// 	//return;
// }else{
// 	error_log("correct vr2: ".$_POST['framework'], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
// } 

//echo "HERE";return;
//error_log(print_r($_POST,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
 
$next_increment = 0;
$qShowStatus = "SHOW TABLE STATUS LIKE 'ver_chronoforms_data_followup_vic'";
$qShowStatusResult = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
$row = mysql_fetch_assoc($qShowStatusResult);
$next_increment = $row['Auto_increment'];
$getprojectid = 'PRV'.$next_increment;

$ReplaceCHAR = $QuoteID;

$resultb = mysql_query("SELECT * FROM ver_chronoforms_data_builderpersonal_vic WHERE builderid  = '$QuoteID'");
$retrieveb = mysql_fetch_array($resultb);
if (!$resultb) {die("Error: Data not found..");}
$BuilderID = $retrieveb['builderid'];
if($BuilderID == $QuoteID) {$PID = str_replace('BRV', '', $ReplaceCHAR); } 
else {$PID = str_replace('CRV', '', $ReplaceCHAR); }

$salesrepb = $retrieveb['repname'];

$resultc = mysql_query("SELECT * FROM ver_chronoforms_data_clientpersonal_vic WHERE clientid  = '$QuoteID'");
$retrievec = mysql_fetch_array($resultc);
if (!$resultc) {die("Error: Data not found..");}

$salesrepc = $retrievec['repname'];

$user = JFactory::getUser();
$rep_id = $user->RepID;
// if($salesrepb != "") {$salesrep = $salesrepb; $rep_id = $retrieveb['repident']; }
//elseif($salesrepc != ""){$salesrep = $salesrepc; $rep_id = $retrievec['repident']; }


// if(isset($_POST['quotedate'])){ 
// $date =  $_POST['quotedate']; 
// $timestamp = date('Y-m-d H:i:s', strtotime($date)); 
// $DateLodged = $timestamp;
// }

//Use the client date created as the quoted date.
$DateLodged = "";
if($retrieveb){
	$DateLodged = $retrieveb['datelodged'];
}else{
	$DateLodged = $retrievec['datelodged'];
}



$cbeam200ID = "1";
$cbeam250ID = "3";
$Inter250ID = "111";


if(isset($_POST['save-doublebay-vr4'])){	

	$ProjectName = $_POST['projectsite'];
	$DateQuote = $_POST['quotedate'];
	$FrameworkTYP = $_POST['frameworktype'];
	$Framework = $_POST['framework'];

	$qty = implode(", ", $_POST['qty']);
	$cnt = count($_POST['colour']);
	$cnt2 = count($_POST['uom']);
	$cnt3 = count($_POST['qty']);
	$cnt4 = count($_POST['webbing']);
	$cnt5 = count($_POST['paint']);
	$cnt6 = count($_POST['invent']);
	$cnt7 = count($_POST['slength']);
	$cnt8 = count($_POST['rrp']);
	$cnt9 = count($_POST['cst']);


	if ($cnt6 > 0) { // && $cnt == $cnt2 && $cnt2 == $cnt3 && $cnt3 == $cnt4 && $cnt4 == $cnt5 && $cnt5 == $cnt6 && $cnt6 == $cnt7 && $cnt7 == $cnt8 && $cnt8 == $cnt9
	    $insertArr = array();
	    
		for ($i=0; $i<$cnt6; $i++) { 
			$insertArr[] = "('$QuoteID', '" . mysql_real_escape_string($_POST['invent'][$i]) . "', '$getprojectid', '$ProjectName', '$FrameworkTYP', '$Framework', '" . mysql_real_escape_string($_POST['slength'][$i]) . "', '" . mysql_real_escape_string($_POST['desc'][$i]) . "', '" . mysql_real_escape_string($_POST['colour'][$i]) . "', '" . mysql_real_escape_string($_POST['qty'][$i]) . "', '" . mysql_real_escape_string($_POST['webbing'][$i]) . "', '" . mysql_real_escape_string($_POST['finish'][$i]) . "', '" . mysql_real_escape_string($_POST['uom'][$i]) . "', '" . mysql_real_escape_string($_POST['rrp'][$i]) . "', '" . mysql_real_escape_string($_POST['cst'][$i]) . "')";
		}

		$query = "INSERT INTO ver_chronoforms_data_quote_vic (quoteid, inventoryid, projectid, project_name, framework_type, framework, length, description, colour, qty, webbing, finish, uom, rrp, cost) VALUES " . implode(", ", $insertArr);
		//echo $queryn; return;
		//error_log($query, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');//  exit(); 
		mysql_query($query) or trigger_error("Insert failed: " . mysql_error());

	}

	//Old Computation
	// $SubtotalVergola = $_POST['subtotalvergola'];
	// $SubtotalDisbursement = $_POST['subtotaldisd'];
	// $Totalrrp = $_POST['totalrrp'];
	// $Totalgst = $_POST['totalgst'];
	// $Totalrrpgst = $_POST['totalrrpgst'];
	// $Totalcost = $_POST['totalcost'];
	// $Totalcostgst = $_POST['totalcostgst'];
	// $GSTPercent = $_POST['gst'];
	// $CommPercent = $_POST['commision'];
	// $SalesCost = $_POST['salescost'];
	// $InstallCost = $_POST['installercost'];

	//New computation
	$SubtotalVergola = $_POST['total_vergola'];
	$SubtotalDisbursement = $_POST['total_disbursement'];
	$Totalrrp = $_POST['total_rrp'];
	$Totalgst = $_POST['total_gst'];
	$Totalrrpgst = $_POST['total_sum'];

	$Totalcost = $_POST['totalcost'];
	$Totalcostgst = $_POST['totalcostgst'];
	$GSTPercent = $_POST['gst'];
	$CommPercent = $_POST['commision'];
	$SalesCost = $_POST['com_sales_commission'];
	$InstallCost = $_POST['com_installer_payment'];

	$payment_deposit = $_POST['payment_deposit'];
	$payment_progress = $_POST['payment_progress'];
	$payment_final = $_POST['payment_final'];
	$SalesComm = $_POST['com_sales_commission'];
	$com_pay1 = $_POST['com_pay1'];
	$com_pay2 = $_POST['com_pay2'];
	$com_final = $_POST['com_final'];

	 
	$queryp = "INSERT INTO ver_chronoforms_data_followup_vic 
	(sales_rep, 
	quoteid, 
	projectid, 
	quotedate, 
	project_name, 
	framework_type, 
	subtotal_vergola, 
	subtotal_disbursement, 
	total_rrp, 
	total_gst, 
	total_rrp_gst, 
	total_cost, 
	total_cost_gst, 
	gst_percent, 
	comm_percent, 
	sales_comm, 
	install_comm, 
	sales_comm_cost, 
	install_comm_cost, 
	status,
	payment_deposit,
	payment_progress,
	payment_final,
	com_pay1,
	com_pay2,
	com_final,
	rep_id) 

	VALUES 
	('$salesrep', 
	'$QuoteID', 
	'$getprojectid', 
	'$DateLodged', 
	'$ProjectName', 
	'$FrameworkTYP',
	'$SubtotalVergola',
	'$SubtotalDisbursement', 
	'$Totalrrp',
	'$Totalgst', 
	'$Totalrrpgst',
	'$Totalcost', 
	'$Totalcostgst',  
	'$GSTPercent', 
	'$CommPercent', 
	'$SalesComm', 
	'$InstallComm', 
	'$SalesCost', 
	'$InstallCost', 'Quoted',
	'$payment_deposit',  
	'$payment_progress',  
	'$payment_final', 
	'$com_pay1', 
	'$com_pay2',  
	'$com_final',
	'$rep_id')";

	//error_log($queryp, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
	mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error());
	 
	$Bay = mysql_real_escape_string($_POST['dbbay']);
	$cnt = count($_POST['bay_length']);
	$cnt2 = count($_POST['dbwidth']);
	 

	if ($cnt > 0) {
	    $insertArr = array();
	    
		for ($i=0; $i<$cnt; $i++) { 
			$insertArr[] = "('$getprojectid', '$FrameworkTYP', '" . mysql_real_escape_string($_POST['dbwidth'][0]) . "', '" . mysql_real_escape_string($_POST['bay_length'][$i]) . "', '$Bay')";
		}

		$query = "INSERT INTO ver_chronoforms_data_measurement_vic (projectid, framework_type, width, length, bay) VALUES " . implode(", ", $insertArr);
		//error_log($query, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
		mysql_query($query) or trigger_error("Insert failed: " . mysql_error()); 
	}


	// $num_bay = $Bay;
	// $insertArr = array();
	// //error_log("BAY : ".$num_bay."     ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
 // 	for ($i=0; $i<$num_bay; $i++) { 
	// 	$insertArr[] = "('$getprojectid', '$FrameworkTYP', '" . mysql_real_escape_string($_POST['dbwidth'][0]) . "', '" . mysql_real_escape_string($_POST['bay_length'][$i]) . "', '" . mysql_real_escape_string($_POST['dbbay']) . "')";
	// }

	// $querym = "INSERT INTO ver_chronoforms_data_measurement_vic (projectid, framework_type, width, length, bay) VALUES " . implode(", ", $insertArr);
	// error_log($querym, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
	// mysql_query($querym) or trigger_error("Insert failed: " . mysql_error());  


	    
	header('Location:'.JURI::base().'view-quote-vic?projectid='.$getprojectid);    
	// if($BuilderID == $QuoteID) {header('Location:'.JURI::base().'builder-listing-vic/builder-folder-vic?pid='.$PID);} 
	// else {header('Location:'.JURI::base().'client-listing-vic/client-folder-vic?pid='.$PID);}
	
}

if(isset($_POST['save-close-doublebay-vr4'])){

	$ProjectName = $_POST['projectsite'];
	$DateQuote = $_POST['quotedate'];
	$FrameworkTYP = $_POST['frameworktype'];
	$Framework = $_POST['framework'];

	$qty = implode(", ", $_POST['qty']);
	$cnt = count($_POST['colour']);
	$cnt2 = count($_POST['uom']);
	$cnt3 = count($_POST['qty']);
	$cnt4 = count($_POST['webbing']);
	$cnt5 = count($_POST['paint']);
	$cnt6 = count($_POST['invent']);
	$cnt7 = count($_POST['slength']);
	$cnt8 = count($_POST['rrp']);
	$cnt9 = count($_POST['cst']);
	 
	if ($cnt6 > 0) {  
	    $insertArr = array();
	    
		for ($i=0; $i<$cnt6; $i++) {  
			$insertArr[] = "('$QuoteID', '" . mysql_real_escape_string($_POST['invent'][$i]) . "', '$getprojectid', '$ProjectName', '$FrameworkTYP', '$Framework', '" . mysql_real_escape_string($_POST['slength'][$i]) . "', '" . mysql_real_escape_string($_POST['desc'][$i]) . "', '" . mysql_real_escape_string($_POST['colour'][$i]) . "', '" . mysql_real_escape_string($_POST['qty'][$i]) . "', '" . mysql_real_escape_string($_POST['webbing'][$i]) . "', '" . mysql_real_escape_string($_POST['finish'][$i]) . "', '" . mysql_real_escape_string($_POST['uom'][$i]) . "', '" . mysql_real_escape_string($_POST['rrp'][$i]) . "', '" . mysql_real_escape_string($_POST['cst'][$i]) . "')";
		}

		$queryn = "INSERT INTO ver_chronoforms_data_quote_vic (quoteid, inventoryid, projectid, project_name, framework_type, framework, length, description, colour, qty, webbing, finish, uom, rrp, cost) VALUES " . implode(", ", $insertArr);
		// echo $queryn; return;
		mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error());

	}

	//Old compuation
	// $SubtotalVergola = $_POST['subtotalvergola'];
	// $SubtotalDisbursement = $_POST['subtotaldisd'];
	// $Totalrrp = $_POST['totalrrp'];
	// $Totalgst = $_POST['totalgst'];
	// $Totalrrpgst = $_POST['totalrrpgst'];
	// $Totalcost = $_POST['totalcost'];
	// $Totalcostgst = $_POST['totalcostgst'];
	// $GSTPercent = $_POST['gst'];
	// $CommPercent = $_POST['commision'];
	// $SalesCost = $_POST['salescost'];
	// $InstallCost = $_POST['installercost'];

	//New computation
	$SubtotalVergola = $_POST['total_vergola'];
	$SubtotalDisbursement = $_POST['total_disbursement'];
	$Totalrrp = $_POST['total_rrp'];
	$Totalgst = $_POST['total_gst'];
	$Totalrrpgst = $_POST['total_sum'];

	$Totalcost = $_POST['totalcost'];
	$Totalcostgst = $_POST['totalcostgst'];
	$GSTPercent = $_POST['gst'];
	$CommPercent = $_POST['commision'];
	$SalesCost = $_POST['com_sales_commission'];
	$InstallCost = $_POST['com_installer_payment'];

	$payment_deposit = $_POST['payment_deposit'];
	$payment_progress = $_POST['payment_progress'];
	$payment_final = $_POST['payment_final'];
	$SalesComm = $_POST['com_sales_commission'];
	$com_pay1 = $_POST['com_pay1'];
	$com_pay2 = $_POST['com_pay2'];
	$com_final = $_POST['com_final'];
	 

	$queryp = "INSERT INTO ver_chronoforms_data_followup_vic 
	(sales_rep, 
	quoteid, 
	projectid, 
	quotedate, 
	project_name, 
	framework_type, 
	subtotal_vergola, 
	subtotal_disbursement, 
	total_rrp, 
	total_gst, 
	total_rrp_gst, 
	total_cost, 
	total_cost_gst, 
	gst_percent, 
	comm_percent, 
	sales_comm, 
	install_comm, 
	sales_comm_cost, 
	install_comm_cost, 
	status,
	payment_deposit,
	payment_progress,
	payment_final,
	com_pay1,
	com_pay2,
	com_final,
	rep_id) 

	VALUES 
	('$salesrep', 
	'$QuoteID', 
	'$getprojectid', 
	'$DateLodged', 
	'$ProjectName', 
	'$FrameworkTYP',
	'$SubtotalVergola',
	'$SubtotalDisbursement', 
	'$Totalrrp',
	'$Totalgst', 
	'$Totalrrpgst',
	'$Totalcost', 
	'$Totalcostgst',  
	'$GSTPercent', 
	'$CommPercent', 
	'$SalesComm', 
	'$InstallComm', 
	'$SalesCost', 
	'$InstallCost', 'Quoted',
	'$payment_deposit',  
	'$payment_progress',  
	'$payment_final', 
	'$com_pay1', 
	'$com_pay2',  
	'$com_final,
	'$rep_id')";
	 
	mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error());
	 
	$Bay = "";
	$cnt = count($_POST['dblength']);
	$cnt2 = count($_POST['dbwidth']);

	 
	if ($cnt > 0) {
	    $insertArr = array();
	    
		for ($i=0; $i<$cnt; $i++) { 
			$insertArr[] = "('$getprojectid', '$FrameworkTYP', '" . mysql_real_escape_string($_POST['dbwidth'][0]) . "', '" . mysql_real_escape_string($_POST['dblength'][$i]) . "', '$Bay')";
		}

		$querym = "INSERT INTO ver_chronoforms_data_measurement_vic (projectid, framework_type, width, length, bay) VALUES " . implode(", ", $insertArr); 
		mysql_query($querym) or trigger_error("Insert failed: " . mysql_error());

	}
	    
	header('Location:'.JURI::base().'view-quote-vic?projectid='.$getprojectid);
	
}




//error_log("FRAMEWORK: ".$_POST['framework'], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
 
function generateItemVR4($section){ //type = double bay vr2, double bay vr3, double bay vr2 - gutter
	$tr = "";
	//$framework = $_POST['framework']; 
	//error_log("Inside generateRowItem2 framework: ".$_POST['framework'], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	if(isset($_POST['framework'])){
		$framework = $_POST['framework'];
	}else{
		$framework = "Double Bay VR4";//set default value.
	}
	
	

	if($section=="frame"){
		$filter_framework = "Double Bay VR4";
		$filter_framework = $framework;
	 	// if($framework == "Double Bay VR4"){
	 	// 	$filter_framework = $framework;
	 	// }else if($framework == "Double Bay VR3"){
	 	// 	$filter_framework = "Double Bay VR3"; //use vr2 item bec. they just the same. just the louvers are different side that will differ in length
	 	// }else if($framework == "Double Bay VR3 - Gutter"){
	 	// 	$filter_framework = $framework;
	 	// }else{
	 	// 	$framework = "Double Bay VR2";
	 	// }
	 	//error_log("Inside generateRowItem2 framework: ".$framework, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	 	//error_log("FRAMEWORK: ".$framework, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	 	$framework = mysql_query("SELECT  * FROM ver_vergola_default_framework_items WHERE framework = '{$filter_framework}'  AND (LOWER(section) = 'frame' OR LOWER(section) = 'posts') ORDER BY FIELD(inventoryid, 'IRV3','IRV4', 'IRV120', 'IRV121', 'IRV15', 'IRV23', 'IRV24', 'IRV25', 'IRV26', 'IRV121', 'IRV122') " ); // 
		//error_log("SELECT  * FROM ver_vergola_default_framework_items WHERE framework = '{$filter_framework}' AND LOWER(section) = 'frame'  ORDER BY FIELD(category, 'Beams', 'Beam Fixings', 'Posts')", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
		$isFirst = 1;$isSecond = 0;$isThird = 0;$isFourth = 0;//should be in order based on the list from the pulled record from database, beam(L), beam(L[2nd]), 
		while ($r = mysql_fetch_assoc($framework)) {

			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}'" )); 
			//error_log(print_r($item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
			if($isFirst){
				$tr .= "<tr id=\"cbeam_master\" style=\"display:none\">"; 

			}else{
				$tr .= "<tr>"; 
			}
								 
					$lw = ""; 
					if($isFirst==1){$lw = "length"; $isFirst = 0; $isSecond=1; }
					else if($isSecond==1){$lw = "width"; $isSecond=0; $isThird=1; }
					else if($isThird==1){$lw = "length"; $isThird=0; $isFourth=1; }
					else{$lw = "length";} 
					
					// else if($isFourth==1){$lw = "width"; $isFourth=0;   }
					// error_log(print_r($item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
					//error_log(print_r($item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
					if(  (strtolower($r["category"]) == "beams" || strtolower($r["category"])=="posts" || strtolower($r["category"])=="intermediate") && $r["inventoryid"] != "IRV4" ){ //
						//error_log(print_r($item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
						$tr .= "<td class=\"td-item\">".listItem2($r["category"],$item)." <input type=\"hidden\" class=\"price select\" value=\"{$item['rrp']}\" category=\"{$item['category']}\" inventoryid=\"{$item['inventoryid']}\" /> </td>";
						if(strtolower($item["category"])=="posts"){
							$tr .= "<td> </td>"; 
						}
						else{
							$tr .= "<td>".listWebbing("")."</td>"; 
						}
						$tr .= "<td>".listColours()."</td>";   
						$tr .= "<td class=\"td-finish-color\">".listColourBond(null,$item)."</td>";  
						$tr .= "<td>{$item["uom"]} </td>";  
						
						if($item["category"] == "Posts" && $isThird ==1){ //IRV15 = post 90 x 90

							$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"\" id=\"IRV43_qty2\" name=\"qty[]\" value=\"\"></td>"; 
						}else{
							$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
						}

						if($item["category"] == "Posts" && $isSecond ==1){ //IRV15 = post 90 x 90 
							$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"cbeam_total_length input-size\" value=\"0\"></td>";  
						}else if($item["category"] == "Posts"){ //IRV15 = post 90 x 90
							$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"input-size\" value=\"4\"></td>";  
						}else{
							$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw} input-size\" value=\"0\"></td>";  
						}
						//$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw}\" value=\"1\"></td>";  
						$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>";  

					}else{
						$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
						$tr .= "<td> </td>"; 
						$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
						$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
						$tr .= "<td > {$item["uom"]} </td>";  
						$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\" ></td>"; 
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"1\" style=\"display:none\"></td>";  	 
						$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>"; 
  
					}

					if($isFirst==1){
						$isFirst=0;
						$isSecond = 1;
					} 
					// if($item['inventoryid']=="IRV4"){
					// 	error_log(print_r($item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
					// }

					$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
					       "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

					
		   	$tr .= "</tr>";
 
	 	}

	 	$tr .= "<tr id=\"framework_last_row\">"; 

			$tr .= "<td class=\"td-item\"> <input type=\"button\" class=\"save-btn\" value=\"Add Post\" onclick=\"add_new_post()\" />   </td>";
			$tr .= "<td> </td>"; 
			$tr .= "<td> </td>";   
			$tr .= "<td> </td>";  
			$tr .= "<td>  </td>";  
			$tr .= "<td class=\"td-qty\"> </td>";  
			$tr .= "<td class=\"td-len\"> </td>";  
			$tr .= "<td class=\"td-rrp\"> </td>";  
	 		 

	 	$tr .= "</tr>";
	 	
	 	
	 }else if($section=="fixings"){
	 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items  WHERE LOWER(framework) = 'Double Bay VR4' AND LOWER(section) = 'fixings'" ); // 
		
		while ($r = mysql_fetch_assoc($framework)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>";  

			$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
			$tr .= "<td> </td>"; 
			$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
			$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
			$tr .= "<td> {$item["uom"]} </td>";  
			$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
			$tr .= "<td class=\"td-len\"> <input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"1\" style=\"display:none\"> </td>";  
			$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"><input type=\"hidden\" class=\"cst\" name=\"cst[]\" value=\"\"></td>";  
	    
	  		$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";
		  
		   	$tr .= "</tr>";
	 	}

	 }else if($section=="guttering"){
	 	
	 	//if($type=="Double Bay VR3 - Gutter"){
	 	// 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR3 - Guttering' AND LOWER(section) = 'guttering'" ); // 
			// $isFirst = 1;$isSecond = 0;$isThird = 0;$isFourth = 0;//should be in order based on the list from the pulled record from database, beam(L), beam(L[2nd]), 
	 	// }else{
 		$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'guttering'" ); // 
		 
 		$_isFirst = 1;$_isSecond = 0; $_isThird = 0;
		$isFirst = 1;$isSecond = 0;$isThird = 0;$isFourth = 0;//should be in order based on the list from the pulled record from database, beam(L), beam(L[2nd]), 
	   
		while ($r = mysql_fetch_assoc($framework)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			if($_isFirst==1){
				$tr .= "<tr id=\"gutter_master_l1\" style=\"display:none\">";  
				$_isFirst = 0;
				$_isSecond = 1;
			}else if($_isSecond==1){
				$tr .= "<tr id=\"gutter_master_l2\" style=\"display:none\">"; 
				$_isSecond = 0;
				$_isThird = 1;
			}else{
				$tr .= "<tr>"; 
			}
			

				$lw = ""; 
				if($isFirst==1){$lw = "length"; $isFirst=0; $isSecond=1; }
				else if($isSecond==1){$lw = "length2"; $isSecond=0; $isThird=1; } 
				else if($isThird==1){$lw = "width"; $isThird=0; $isFourth=1; }
				else if($isFourth==1){$lw = "width"; $isFourth=0;   }
				 
				$tr .= "<td class=\"td-item\">".listItem2("guttering",$item)." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\"  inventoryid=\"{$item['inventoryid']}\"  /> </td>";
				$tr .= "<td></td>"; 
				$tr .= "<td>".listColours()."</td>";   
				$tr .= "<td class=\"td-finish-color\">".listColourBond(null,$item)."</td>";  
				$tr .= "<td>{$item["uom"]} </td>";  
				$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				// if($isSecond==1){ 
				// 	$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"gutter_length\" value=\"0\" ></td>";  // id=\"IRV27_length\"
				// }else 
				if($item["inventoryid"] == "IRV31"){ 
					$tr .= "<td class=\"td-len\"><input type=\"text\"  id=\"gutterLiningLength\" name=\"slength[]\" class=\"\" value=\"0\"></td>";  
				}else if($_isSecond || $_isThird){
					$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"gutter_len_field\" value=\"0\"></td>";
					$_isThird = 0;
				}else{
					$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw}\" value=\"0\"></td>";
				}
				//$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw}\" value=\"0\"></td>";  
				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"><input type=\"hidden\" class=\"cst\" name=\"cst[]\" value=\"\"></td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";		
		   	$tr .= "</tr>";
	 	} 

	 	$tr .= "<tr id=\"gutter_last_row\" >";  
			$tr .= "<td class=\"td-item\"> <input type=\"button\" class=\"save-btn\" value=\"Add Non-Standard Gutter\" onclick=\"add_new_non_standard_gutter()\" />   </td>";
			$tr .= "<td> </td>"; 
			$tr .= "<td> </td>";   
			$tr .= "<td> </td>";  
			$tr .= "<td>  </td>";  
			$tr .= "<td class=\"td-qty\"> </td>";  
			$tr .= "<td class=\"td-len\"> </td>";  
			$tr .= "<td class=\"td-rrp\"> </td>";   
	 	$tr .= "</tr>";

 		$tr .= "<tr >";  
			$tr .= "<td class=\"td-item\"> <input type=\"button\" class=\"save-btn\" value=\"Add Standard Gutter\" onclick=\"add_new_gutter()\" />   </td>";
			$tr .= "<td> </td>"; 
			$tr .= "<td> </td>";   
			$tr .= "<td> </td>";  
			$tr .= "<td>  </td>";  
			$tr .= "<td class=\"td-qty\"> </td>";  
			$tr .= "<td class=\"td-len\"> </td>";  
			$tr .= "<td class=\"td-rrp\"> </td>";   
	 	$tr .= "</tr>";

	}else if($section=="flashings"){
	 	//return; 
	 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'flashings' ORDER BY field(inventoryid, 'IRV43','IRV44','IRV45','IRV46','IRV47') " ); // 
		$isFirst = 1;
		while ($r = mysql_fetch_assoc($framework)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			$tr .= "<tr>"; 
					 
					$tr .= "<td class=\"td-item\"> {$item['description']} <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
					$tr .= "<td></td>"; 
					$tr .= "<td>".listColours()."</td>";   
					$tr .= "<td class=\"td-finish-color\">".listColourBond(null,$item)."</td>";  
					$tr .= "<td>{$item["uom"]} </td>";  


					if($item["inventoryid"]=="IRV44" ){ 
						$tr .= "<td class=\"td-qty\"><input type=\"text\" id=\"IRV44_qty\"  name=\"qty[]\" value=\"{$r['qty']}\"></td>";
					}else{
						$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";
					}	
					//$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  

					if(($item["inventoryid"]=="IRV43" || $item["inventoryid"]=="IRV46" )  && $isFirst == 1 ){ 
						$input_id="";
						if($item["inventoryid"]=="IRV43"){
							$input_id="IRV43_length";
						}else if($item["inventoryid"]=="IRV46"){
							$input_id="IRV46_length";
						} 
							
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"0\" id=\"{$input_id}\"></td>"; 
						$isFirst = 0; 

					}else if($item["inventoryid"]=="IRV44"){ //error_log("2nd", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
						 
						$tr .= "<td class=\"td-len\"><input type=\"text\" id=\"IRV44_qty\"  name=\"slength[]\" class=\"width\" value=\"\"></td>";						 
					 
					}else if($item["inventoryid"]=="IRV45" ){ 
						$tr .= "<td class=\"td-len\"><input type=\"text\"    name=\"slength[]\" class=\"\" value=\"0\" id=\"IRV45_length\"></td>";
				 
					}else if(($item["inventoryid"]=="IRV43" || $item["inventoryid"]=="IRV46" )  || $item["inventoryid"]=="IRV47" ){ //error_log("2nd", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
						$input_id="";
						if($item["inventoryid"]=="IRV47"){
							$input_id="IRV47_length"; 
						} 
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"width\" value=\"0\" id=\"{$input_id}\"></td>";						 
						$isFirst = 1; //set it back to equal 1 for IRV46 as 1st item.


					}else{
						//error_log("here", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"0\"></td>"; 
					}  
					
					//$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"0\"></td>";  
					$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>";  
  
  					$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
					       "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";
		   	$tr .= "</tr>";
	 	} 
	}else if($section=="downpipe"){
	 	
	 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'downpipe'" ); // 
		$_isFirst=1;$_isSecond=0;
		while ($r = mysql_fetch_assoc($framework)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>"; 
				$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
				$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
				$tr .= "<td> {$item["uom"]} </td>";  
				$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				$tr .= "<td class=\"td-len\"> <input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"1\" style=\"display:none\"> </td>";  
				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

			$tr .= "</tr>";
	 	} 
	}else if($section=="vergola"){
	 	
	 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'vergola' ORDER BY FIELD(inventoryid, 'IRV54','IRV58', 'IRV59', 'IRV60', 'IRV62', 'IRV63', 'IRV64', 'IRV61', 'IRV54', 'IRV59')" ); // 
		
		$isFirst = 1; $isSecond = 0;$isThird = 0;$isFourth = 0; $isFifth = 0; $isSixth=0; $isSeventh=0;
		$_isFirst = 1; $_isSecond = 0;$_isThird = 0;
		$colorSelection = ""; $listColourBondSelection = "";

		while ($r = mysql_fetch_assoc($framework)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$itemName = ""; $lengthInput = "";$itemClassName = "";
			$itemQty = "";
			$itemLen = ""; $itemLen_ft = "";
			if($isFirst==1){ 
				$isSecond=1; 
				$colorSelection = listColours("",null,"vergola-colour");
				$listColourBondSelection = listColourBond("CBond");
				$itemQty = 'id=\"louvres-qty-1\"'; //1st Louvres Poly in ever meter.
				$itemLen = 'id=\"louvres-len-1\"'; 

				if(METRIC_SYSTEM=="inch"){
					$itemLen_ft = 'id="louvres-len-1_ft"';
				}	

				$itemClassName = "poly_qty_field";

			}else if($isSecond==1){ 
				$isSecond=0; $isThird=1; 
				$itemQty = 'id=\"louvres-qty-2\"'; //2nd Louvres Poly in ever meter.
				$itemLen = 'id=\"louvres-len-2\"';  

				if(METRIC_SYSTEM=="inch"){
					$itemLen_ft = 'id="louvres-len-2_ft"';
				}
			}
			else if($isThird==1){ 
				$isThird=0; $isFourth=1; 
				$colorSelection = listColours("",null,"vergola-colour");
				$listColourBondSelection = listColourBond("CBond");
				 
			}else if($isFourth==1){ 
				$isFourth=0; $isFifth=1;
				$colorSelection = listColours("",null,"vergola-colour");
				$listColourBondSelection = listColourBond("CBond");

				$itemQty = 'id=\"pivot-qty-1\"'; // 1st Pivot strip 
				$itemLen = 'id=\"pivot-len-1\"'; 

			}else if($isFifth==1){ 
				$isFifth=0;  $isSixth=1;
				$colorSelection = listColours("",null,"vergola-colour");
				$listColourBondSelection = listColourBond("CBond");

				$itemQty = 'id=\"pivot-qty-2\"'; // 2nd Pivot strip 
				$itemLen = 'id=\"pivot-len-2\"'; 
			}else{
				$colorSelection = "<input type=\"hidden\" name=\"colour[]\" />";
				$listColourBondSelection = "<input type=\"hidden\" name=\"finish[]\" />"; 
			}

			
			if($item["inventoryid"]=="IRV54" || $item["inventoryid"]=="IRV55"){ //5 Louvres Poly in ever meter.
			
			}else if($item["inventoryid"]=="IRV58"){ //2 Endcap  
				$itemQty = 'id=\"endcap-qty\"';
				$itemLen = 'id=\"endcap-len\"'; 
			}else if($item["inventoryid"]=="IRV59"){ //  Pivot strip 
				
			}else if($item["inventoryid"]=="IRV60" && $isSixth==1){ //  Link Bar 
				$isSixth=0; $isSeventh=1;
				$itemQty = 'id=\"linkBar-qty-1\"';
				$itemLen = 'id=\"linkBar-len-1\"'; 
			}else if($item["inventoryid"]=="IRV60" && $isSeventh==1){ //  Link Bar 
				$isSeventh=0;
				$itemQty = 'id=\"linkBar-qty-2\"';
				$itemLen = 'id=\"linkBar-len-2\"'; 
			}

			
			if($isFirst || $isThird){
				$itemName = listItem("louvres");
				$lengthInput = "<input type=\"text\"  {$itemLen} name=\"slength[]\" class=\"width input-in\" value=\"0\" readonly />";
				if(METRIC_SYSTEM=="inch"){
					$lengthInput_ft = "<input type=\"text\"  {$itemLen_ft}  class=\"width input-ft\" value=\"0\" />";
				}	
				//error_log("lengthInput :".$lengthInput, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
			}
			else{
				$itemName = $item["description"];
				$lengthInput = "<input type=\"text\"  {$itemLen} name=\"slength[]\" class=\"length input-in\" value=\"0\"  style=\"display:none\" />";
				if(METRIC_SYSTEM=="inch"){
					$lengthInput_ft = "<input type=\"text\"  {$itemLen_ft} class=\"length input-ft\" value=\"0\"  style=\"display:none\" />";
				}	
			}

			if($_isFirst==1){
				$tr .= "<tr id=\"poly_master\" style=\"display:none\">";  
				$_isFirst = 0;
				$_isSecond = 1;
			}else if($_isSecond==1){
				$tr .= "<tr id=\"poly_dummy\" style=\"display:none\">"; 
				$_isSecond = 0;
				$_isThird = 1;
			}else{
				$tr .= "<tr>"; 
			}

				$tr .= "<td class=\"td-item\"> {$itemName} <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" inventoryid=\"{$item['inventoryid']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> ".$colorSelection." </td>";  
				$tr .= "<td class=\"td-finish-color\">".$listColourBondSelection."</td>";   
				$tr .= "<td> {$item["uom"]} </td>";  
				if($item["inventoryid"] == "IRV64"){
					$tr .= "<td class=\"td-qty\"><input type=\"text\" {$itemQty} class=\"qtylen\" id=\"IRV64_qty\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  					 
				}else{
					$tr .= "<td class=\"td-qty\"><input type=\"text\" {$itemQty} class=\"qtylen {$itemClassName}\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				}

				$tr .= "<td class=\"td-len\"> {$lengthInput} </td>";  
				if(METRIC_SYSTEM=="inch"){
					$tr .= "<td class=\"td-ft\"> {$lengthInput_ft} </td>"; 
				} 

				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

			$tr .= "</tr>";
			$isFirst = 0;
	 	} 

	   	$tr .= "<tr id=\"vergola_last_row\" >";  
			$tr .= "<td class=\"td-item\"> <input type=\"button\" class=\"save-btn\" value=\"Add Louver\" onclick=\"add_new_louver()\" />   </td>";
			$tr .= "<td> </td>";  
			$tr .= "<td> </td>";  
			$tr .= "<td> </td>";  
			$tr .= "<td class=\"td-uom\">  </td>";  
			$tr .= "<td class=\"td-qty\"> </td>";  
			$tr .= "<td class=\"td-len\"> </td>";  
			if(METRIC_SYSTEM=="inch"){
				$tr .= "<td class=\"td-ft\"> </td>";  
			} 
			$tr .= "<td class=\"td-rrp\"> </td>";   
	 	$tr .= "</tr>";
	}else if($section=="misc"){
	 	
	 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'misc'" ); // 
		
		while ($r = mysql_fetch_assoc($framework)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>"; 
				$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
				$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
				$tr .= "<td> {$item["uom"]} </td>";
				if($item["inventoryid"] == "IRV66"){
					$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" id=\"IRV66_qty\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  					 
				}else{  
					$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				}
				$tr .= "<td class=\"td-len\"> <input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"1\" style=\"display:none\"> </td>";  
				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

			$tr .= "</tr>";
	 	} 

	 	$tr .= "<tr id=\"misc_last_row\" >";  
			$tr .= "<td class=\"td-item\"> <input type=\"button\" class=\"save-btn\" value=\"Add Misc\" onclick=\"add_new_misc()\" />   </td>";
			$tr .= "<td> </td>"; 
			$tr .= "<td> </td>";   
			$tr .= "<td> </td>";  
			$tr .= "<td>  </td>";  
			$tr .= "<td class=\"td-qty\"> </td>";  
			$tr .= "<td class=\"td-len\"> </td>";  
			$tr .= "<td class=\"td-rrp\"> </td>";   
	 	$tr .= "</tr>";

	}else if($section=="extras"){
	 	
	 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'extras'" ); // 
		
		while ($r = mysql_fetch_assoc($framework)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>"; 
				$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
				$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
				$tr .= "<td> {$item["uom"]} </td>";  
				$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				$tr .= "<td class=\"td-len\"> <input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"1\" style=\"display:none\"> </td>";  
				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
					   "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";
			$tr .= "</tr>";
	 	} 

	 	$tr .= "<tr id=\"extra_last_row\" >";  
			$tr .= "<td class=\"td-item\"> <input type=\"button\" class=\"save-btn\" value=\"Add Extra\" onclick=\"add_new_extra()\" />   </td>";
			$tr .= "<td> </td>"; 
			$tr .= "<td> </td>";   
			$tr .= "<td> </td>";  
			$tr .= "<td>  </td>";  
			$tr .= "<td class=\"td-qty\"> </td>";  
			$tr .= "<td class=\"td-len\"> </td>";  
			$tr .= "<td class=\"td-rrp\"> </td>";   
	 	$tr .= "</tr>";

	}else if($section=="disbursements"){
	 	
	 	$framework = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'disbursements'" ); // 

	 	//not wanted for u.s. market
		$unwanted_inventory_ids = array('IRV81', 'IRV84', 'IRV85');
		
		while ($r = mysql_fetch_assoc($framework)) { 
            if (!in_array($r["inventoryid"], $unwanted_inventory_ids)) {
				$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
				
				$tr .= "<tr>"; 
					$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
					$tr .= "<td> </td>"; 
					$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
					$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
					$tr .= "<td> {$item["uom"]} </td>";  
					$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
					$tr .= "<td class=\"td-len\"> <input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"1\" style=\"display:none\"> </td>";  
					$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp rrp-disbursement\" readonly=\"readonly\" name=\"rrp[]\" value=\"\"> </td>";  

					$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						       "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

				$tr .= "</tr>";
            }
	 	} 
	}     


	return $tr;

}

   
 

if(isset($_POST['framework'])){
	$framework = $_POST['framework'];
}else{
	$framework = "Double Bay VR4";//set default value.
}

//error_log(" framework: ".$framework, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
echo "<table class=\"listing-table\">";

// ***************************** Generate Framework Row ***********************************************//


// ***************************** Cbeam 200 Deep by 2.4mm ***********************************************//
echo "<tbody class=\"tbody_framework\">";
echo "<tr><th>Description</th><th>Webbing</th><th>Colour</th><th>Finish</th><th>UOM</th><th>QTY</th><th>Length</th><th>RRP</th></tr>";
echo "<tr><td colspan=\"8\" class=\"subheading\">Framework</td></tr>";
echo generateItemVR4("frame"); 
  
// ***************************** First Post 90 x 90 - 2mm Galv ********************************************//


 
// ***************************** Fixing to Wall - Solid Brick ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Fittings</td></tr>";
echo generateItemVR4("fixings"); 


echo "</tbody>";
echo "<tbody class=\"tbody_non_framework\">";
echo "<tr><th>Description</th><th>Webbing</th><th>Colour</th><th>Finish</th><th>UOM</th><th>QTY</th><th>Length</th><th>RRP</th></tr>";


// ***************************** First Standard Vergola Gutter Lip Out 200 x 200 ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Gutters</td></tr>";
echo generateItemVR4("guttering"); 


// ***************************** Cbeam Face Flashing Z al ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Flashing</td></tr>";
echo generateItemVR4("flashings"); 
 

// ***************************** Downpipe Plastic 3m ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Downpipe</td></tr>";
echo generateItemVR4("downpipe"); 
 

// ***************************** Louvres Poly or Square ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Vergola System</td></tr>";
echo generateItemVR4("vergola"); 
 

// ***************************** Misc Cost ********************************************//
 echo "<tr><td colspan=\"8\" class=\"subheading\">Misc Items</td></tr>";
echo generateItemVR4("misc");  



// ***************************** Add Extra 1 ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Extras</td></tr>";
echo generateItemVR4("extras"); 


// ***************************** Shop Drawings ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Disbursements</td></tr>";
echo generateItemVR4("disbursements"); 
 

echo "</tbody>";
// End of Table
echo "</table>";
// error_log("output vr2: ".$framework, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
?>
