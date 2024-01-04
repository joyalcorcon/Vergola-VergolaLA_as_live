<?php
// if($_POST['framework'] != "Double Bay VR2"){
// 	 error_log("incorrect vr2: ".$_POST['framework'], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
// 	 //$framework = "Double Bay VR2"; //set default value for get default item in database.
// 	//return;
// }else{
// 	error_log("correct vr2: ".$_POST['framework'], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
// } 

//echo "HERE";return;
//error_log("INSIDE view double bay vr2", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
// $next_increment = 0;
// $qShowStatus = "SHOW TABLE STATUS LIKE 'ver_chronoforms_data_followup_vic'";
// $qShowStatusResult = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
// $row = mysql_fetch_assoc($qShowStatusResult);
// $next_increment = $row['Auto_increment'];
// $getprojectid = 'PRV'.$next_increment;

$ReplaceCHAR = $QuoteID;
$resultb = mysql_query("SELECT builderid, repname FROM ver_chronoforms_data_builderpersonal_vic WHERE builderid  = '$QuoteID'");
$retrieveb = mysql_fetch_array($resultb);
if (!$resultb) {die("Error: Data not found..");}
$BuilderID = $retrieveb['builderid'];
if($BuilderID == $QuoteID) {$PID = str_replace('BRV', '', $ReplaceCHAR); } 
else {$PID = str_replace('CRV', '', $ReplaceCHAR); }

// $salesrepb = $retrieveb['repname'];

// $resultc = mysql_query("SELECT clientid, repname FROM ver_chronoforms_data_clientpersonal_vic WHERE clientid  = '$QuoteID'");
// $retrievec = mysql_fetch_array($resultc);
// if (!$resultc) {die("Error: Data not found..");}

// $salesrepc = $retrievec['repname'];

// if($salesrepb != "") {$salesrep = $salesrepb; }
// elseif($salesrepc != ""){$salesrep = $salesrepc; }


// if(isset($_POST['quotedate'])){ 
// $date =  $_POST['quotedate']; 
// $timestamp = date('Y-m-d H:i:s', strtotime($date)); 
// $DateLodged = $timestamp;
// }


// $cbeam200ID = "1";
// $cbeam250ID = "3";
// $Inter250ID = "111";

if(isset($_POST['update']) && isset($_POST['projectid']))
{

	$ProjectName = $_POST['projectsite'];
	$DateQuote = $_POST['quotedate'];
	$FrameworkTYP = $_POST['frameworktype'];
	$Framework = $_POST['framework'];
	$projectid = mysql_real_escape_string($_POST['projectid']);

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

	    $queryn = "DELETE FROM ver_chronoforms_data_quote_vic WHERE projectid = '{$projectid}'";
   		mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error());
	    
		for ($i=0; $i<$cnt6; $i++) {  
			$insertArr[] = "('$QuoteID', '" . mysql_real_escape_string($_POST['invent'][$i]) . "', '{$projectid}', '$ProjectName', '$FrameworkTYP', '$Framework', '" . mysql_real_escape_string($_POST['slength'][$i]) . "', '" . mysql_real_escape_string($_POST['desc'][$i]) . "', '" . mysql_real_escape_string($_POST['colour'][$i]) . "', '" . mysql_real_escape_string($_POST['qty'][$i]) . "', '" . mysql_real_escape_string($_POST['webbing'][$i]) . "', '" . mysql_real_escape_string($_POST['finish'][$i]) . "', '" . mysql_real_escape_string($_POST['uom'][$i]) . "', '" . mysql_real_escape_string($_POST['rrp'][$i]) . "', '" . mysql_real_escape_string($_POST['cst'][$i]) . "')";
		}

		$queryn = "INSERT INTO ver_chronoforms_data_quote_vic (quoteid, inventoryid, projectid, project_name, framework_type, framework, length, description, colour, qty, webbing, finish, uom, rrp, cost) VALUES " . implode(", ", $insertArr);
		//error_log($queryn, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); exit();
		mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error());

	}

	//Old computation
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
	$SalesComm = $_POST['com_sales_commission'];
	$InstallCost = $_POST['com_installer_payment'];

	$payment_deposit = $_POST['payment_deposit'];
	$payment_progress = $_POST['payment_progress'];
	$payment_final = $_POST['payment_final'];
	$SalesComm = $_POST['com_sales_commission'];
	$com_pay1 = $_POST['com_pay1'];
	$com_pay2 = $_POST['com_pay2'];
	$com_final = $_POST['com_final'];
	 
	$queryp = "DELETE FROM ver_chronoforms_data_followup_vic WHERE projectid='{$projectid}'";  
	mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error()); 

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
	com_final) 

	VALUES 
	('$salesrep', 
	'$QuoteID', 
	'{$projectid}', 
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
	'$com_final')";
	 
	mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error());
	 
	$Bay = "";
	$cnt = count($_POST['dblength']);
	$cnt2 = count($_POST['dbwidth']);

	 
	if ($cnt > 0 ) {
	    $insertArr = array();

	    $queryp = "DELETE FROM ver_chronoforms_data_measurement_vic WHERE projectid='{$projectid}'";  
		mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error());
	    
		for ($i=0; $i<$cnt; $i++) { 
			$insertArr[] = "('{$projectid}', '$FrameworkTYP', '" . mysql_real_escape_string($_POST['dbwidth'][0]) . "', '" . mysql_real_escape_string($_POST['dblength'][$i]) . "', '$Bay')";
		}

		$querym = "INSERT INTO ver_chronoforms_data_measurement_vic (projectid, framework_type, width, length, bay) VALUES " . implode(", ", $insertArr); 
		//error_log($querym, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
		mysql_query($querym) or trigger_error("Insert failed: " . mysql_error());

	}
	    
	//header('Location:'.JURI::base().'view-quote-vic?projectid='.$getprojectid);
	$ProjectID = $projectid;
	$Framework = $FrameworkTYP;	
}

if(isset($_POST['save-close']) && isset($_POST['projectid'])) 
{
	$ProjectName = $_POST['projectsite'];
	$DateQuote = $_POST['quotedate'];
	$FrameworkTYP = $_POST['frameworktype'];
	$Framework = $_POST['framework'];
	$projectid = mysql_real_escape_string($_POST['projectid']);

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

	    $queryn = "DELETE FROM ver_chronoforms_data_quote_vic WHERE projectid = '{$projectid}'";
   		mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error());
	    
		for ($i=0; $i<$cnt6; $i++) { 
			$insertArr[] = "('$QuoteID', '" . mysql_real_escape_string($_POST['invent'][$i]) . "', '{$projectid}', '$ProjectName', '$FrameworkTYP', '$Framework', '" . mysql_real_escape_string($_POST['slength'][$i]) . "', '" . mysql_real_escape_string($_POST['desc'][$i]) . "', '" . mysql_real_escape_string($_POST['colour'][$i]) . "', '" . mysql_real_escape_string($_POST['qty'][$i]) . "', '" . mysql_real_escape_string($_POST['webbing'][$i]) . "', '" . mysql_real_escape_string($_POST['finish'][$i]) . "', '" . mysql_real_escape_string($_POST['uom'][$i]) . "', '" . mysql_real_escape_string($_POST['rrp'][$i]) . "', '" . mysql_real_escape_string($_POST['cst'][$i]) . "')";
		}

		$queryn = "INSERT INTO ver_chronoforms_data_quote_vic (quoteid, inventoryid, projectid, project_name, framework_type, framework, length, description, colour, qty, webbing, finish, uom, rrp, cost) VALUES " . implode(", ", $insertArr);
		//error_log($queryn, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');   
		mysql_query($queryn) or trigger_error("Insert failed: " . mysql_error());

	}

	//Old computation
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
	$SalesComm = $_POST['com_sales_commission'];
	$InstallCost = $_POST['com_installer_payment'];

	$payment_deposit = $_POST['payment_deposit'];
	$payment_progress = $_POST['payment_progress'];
	$payment_final = $_POST['payment_final'];
	$SalesComm = $_POST['com_sales_commission'];
	$com_pay1 = $_POST['com_pay1'];
	$com_pay2 = $_POST['com_pay2'];
	$com_final = $_POST['com_final'];


	$queryp = "DELETE FROM ver_chronoforms_data_followup_vic WHERE projectid='{$projectid}'";  
	mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error()); 
	 
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
	com_final) 

	VALUES 
	('$salesrep', 
	'$QuoteID', 
	'{$projectid}', 
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
	'$com_final')";
	 
	mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error());
	 
	$Bay = "";
	$cnt = count($_POST['dblength']);
	$cnt2 = count($_POST['dbwidth']);
	 

	if ($cnt > 0 && $cnt == $cnt2) {
	    $insertArr = array();
	    
	    $queryp = "DELETE FROM ver_chronoforms_data_measurement_vic WHERE projectid='{$projectid}'";  
		mysql_query($queryp) or trigger_error("Insert failed: " . mysql_error());

		for ($i=0; $i<$cnt; $i++) { 
			$insertArr[] = "('{$projectid}', '$FrameworkTYP', '" . mysql_real_escape_string($_POST['dbwidth'][0]) . "', '" . mysql_real_escape_string($_POST['dblength'][$i]) . "', '$Bay')";
		}

		$querym = "INSERT INTO ver_chronoforms_data_measurement_vic (projectid, framework_type, width, length, bay) VALUES " . implode(", ", $insertArr);
		 
		mysql_query($querym) or trigger_error("Insert failed: " . mysql_error()); 
	}
	    
	//header('Location:'.JURI::base().'view-quote-vic?projectid='.{$projectid});    
	//$ProjectID = $projectid;
	//if($BuilderID == $QuoteID) {header('Location:'.JURI::base().'builder-listing-vic/builder-folder-vic?pid='.$PID);} 
	//else {header('Location:'.JURI::base().'client-listing-vic/client-folder-vic?pid='.$PID);}
	header('Location:'.JURI::base().'client-listing-vic/client-folder-vic?cid='.$QuoteID);
	exit();
}

//error_log("VergolaType: ".$VergolaType, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
// if(isset($VergolaType) && ($VergolaType=="Double Bay VR2" || $VergolaType=="Double Bay VR3")){
// 	$projectId = $ProjectID;
// }else{
// 	$projectId = null;
// }
//error_log("project id: ".$ProjectID, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); exit();
 
function generateRowItem2($section,$projectId=null){
	$tr = ""; 
	//error_log("section : ".$section." projectID: ".$projectId, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 

	if($section=="frame"){  
		 
	 	$fw = mysql_query("SELECT  i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}'  AND (LOWER(i.section) = 'frame' OR  LOWER(i.section) = 'posts')   " ); // 
 
		//error_log("SELECT  i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}'  AND (LOWER(i.section) = 'frame' OR  LOWER(i.section) = 'posts') " , 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
		$isFirst = 1;$isSecond = 0;$isThird = 0;$isFourth = 0;//should be in order based on the list from the pulled record from database, beam(L), beam(L[2nd]), 
		while ($r = mysql_fetch_assoc($fw)) { 
			//error_log(print_r($r,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}'" ));
			//error_log(print_r($r,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
			$tr .= "<tr>"; 
					 
					$lw = ""; 
					if($isFirst==1){$lw = "length";  $isSecond=1; }
					else if($isSecond==1){$lw = "width"; $isSecond=0; $isThird=1; }
					else if($isThird==1){$lw = "length"; $isThird=0; $isFourth=1; }
					else{$lw = "length";} 
					 
					//error_log(", section: ".$item["section"].", category: ".$item["category"], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
					
					if(strtolower($item["section"])=="frame" && (strtolower($item["category"])=="beams" || strtolower($item["category"])=="posts" || strtolower($item["category"])=="intermediate")){ 
						//error_log(", inventoryid : ".$item["inventoryid"]." length: ".$r["length"], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');  
						$tr .= "<td class=\"td-item\">".listItem2($item["category"],$item)." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" category=\"{$item['category']}\"  inventoryid=\"{$item['inventoryid']}\" /> </td>";
						if(strtolower($item["category"])=="posts"){
							$tr .= "<td> </td>"; 
						}
						else{
							$tr .= "<td>".listWebbing2("",$r)."</td>"; 
						}
						$tr .= "<td>".listColours2("",$r)."</td>";   
						$tr .= "<td class=\"td-finish-color\">".listColourBond2(null,$r)."</td>";  
						$tr .= "<td>{$item["uom"]} </td>";  
						$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
						//$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw}\" value=\"{$r['length']}\"></td>"; 
						
						// if(strtolower($item["category"]) == "beams" && $isFirst ==1 ){ 
						// 	$tr .= "<td class=\"td-len\"><input type=\"text\"  id=\"cbeam_length\" name=\"slength[]\" class=\"input-size\" value=\"\"></td>";  
						// 	$isFirst = 0;
						// }else if($isSecond ==1 ){ 
						// 	$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw} input-size\" value=\"\"></td>";  
						// 	$isFirst = 0;
						// }else

						if($item["category"] == "Posts"){ //IRV15 = post 90 x 90
							$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"input-size\" value=\"{$r['length']}\"></td>";  
						}else{
							$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw} input-size\" value=\"{$r['length']}\"></td>";  
						}
						$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  

					}else{
						$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
						$tr .= "<td> </td>"; 
						$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
						$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
						$tr .= "<td > {$item["uom"]} </td>";  
						$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
						//$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"{$r['length']}\" style=\"display:none\"></td>";  
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"1\" style=\"display:none\"></td>";  	
						 
						$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  
					}

					if($isFirst==1){
						$isFirst=0;
						$isSecond = 1;
					} 

					$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
					       "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";
					
		   	$tr .= "</tr>";

		   	 ///error_log($tr, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log'); 
		   	// return $tr;
		   
	 	}
	 	
	 	
	 }else if($section=="fixings"){
	 	
		
		if($projectId == null){
	 		$fw = mysql_query("SELECT * FROM ver_vergola_default_framework_items  WHERE LOWER(framework) = 'Double Bay VR4' AND LOWER(section) = 'fixings'" ); // 
	 	}else{
	 		$fw = mysql_query("SELECT  i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(i.section) = 'fixings' " ); // 
	 	}

		while ($r = mysql_fetch_assoc($fw)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>"; 
 
			$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
			$tr .= "<td> </td>"; 
			$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
			$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
			$tr .= "<td> {$item["uom"]} </td>";  
			$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
			$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"\" value=\"{$r['length']}\" style=\"display:none\"> </td>";  
			$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"><input type=\"hidden\" class=\"cst\" name=\"cst[]\" value=\"\"></td>";  
		   

	  		$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
					"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";
		  
		   	$tr .= "</tr>";
	 	}

	 }else if($section=="guttering"){
	 	
	 	
		if($projectId == null){
	 		$fw = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'guttering'" ); // 
	 	}else{
	 		$fw = mysql_query("SELECT  i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(i.section) = 'guttering' " ); // 
	 	}

	 	$_isFirst = 1;$_isSecond = 0; $_isThird = 0;
		$isFirst = 1;$isSecond = 0;$isThird = 0;$isFourth = 0;//should be in order based on the list from the pulled record from database, beam(L), beam(L[2nd]), 
		
		while ($r = mysql_fetch_assoc($fw)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			// if($_isFirst==1){
			// 	$tr .= "<tr id=\"gutter_master_l1\" style=\"display:none\">";  
			// 	$_isFirst = 0;
			// 	$_isSecond = 1;
			// }else if($isSecond==1){
			// 	$tr .= "<tr id=\"gutter_master_l2\" style=\"display:none\">"; 
			// 	$_isSecond = 0;
			// 	$_isThird = 1;
			// }else{
				$tr .= "<tr>"; 
			//}
			//error_log("inventoryid: ".$r["inventoryid"]." length: ".$r["length"]." rrp: ".$r["rrp"], 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');

			$tr .= "<tr>"; 
					$lw = ""; 
					if($isFirst==1){$lw = "length"; $isFirst=0; $isSecond=1; }
					else if($isSecond==1){$lw = "length2"; $isSecond=0; $isThird=1; } 
					else if($isThird==1){$lw = "width"; $isThird=0; $isFourth=1; }
					else if($isFourth==1){$lw = "width"; $isFourth=0;   }
					 
					$tr .= "<td class=\"td-item\">".listItem2("guttering",$item,"Guttering")." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\"   inventoryid=\"{$item['inventoryid']}\"  /> </td>";
					$tr .= "<td></td>"; 
					$tr .= "<td>".listColours2("",$r)."</td>";   
					$tr .= "<td class=\"td-finish-color\">".listColourBond2(null,$r)."</td>";  
					$tr .= "<td>{$item["uom"]} </td>";  
					$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";
					if($item["inventoryid"] == "IRV31"){ 
						$tr .= "<td class=\"td-len\"><input type=\"text\"  id=\"gutterLiningLength\" name=\"slength[]\" class=\"\" value=\"{$r['length']}\"></td>";  
					}else{
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw}\" value=\"{$r['length']}\"></td>";
					}
					// else if($_isSecond || $_isThird){
					// 	$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"gutter_len_field\" value=\"0\"></td>";
					// 	$_isThird = 0;
					// }

					//$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"{$lw}\" value=\"{$r['length']}\"></td>";  
					$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"><input type=\"hidden\" class=\"cst\" name=\"cst[]\" value=\"\"></td>";  
 
					$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
							"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";		
		   	$tr .= "</tr>";
	 	} 
	}else if($section=="flashings"){
	 	 
	 	$fw = mysql_query("SELECT  i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(i.section) = 'flashings'   " ); // 
	 	 
	 	$isFirst = 1;
		while ($r = mysql_fetch_assoc($fw)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			$tr .= "<tr>"; 
					 
					$tr .= "<td class=\"td-item\"> {$item['description']} <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
					$tr .= "<td></td>"; 
					$tr .= "<td>".listColours2("",$r)."</td>";   
					$tr .= "<td class=\"td-finish-color\">".listColourBond2(null,$r)."</td>";  
					$tr .= "<td>{$item["uom"]} </td>";  
					

					if($item["inventoryid"]=="IRV44" ){ 
						$tr .= "<td class=\"td-qty\"><input type=\"text\" id=\"IRV44_qty\"  name=\"qty[]\" value=\"{$r['qty']}\"></td>";
					}else{
						$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";
					}	

					 
					//$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"{$r['length']}\"></td>";  
					if(($item["inventoryid"]=="IRV43" || $item["inventoryid"]=="IRV46" )  && $isFirst == 1 ){ 
						$input_id="";
						if($item["inventoryid"]=="IRV43"){
							$input_id="IRV43_length";
						}else if($item["inventoryid"]=="IRV46"){
							$input_id="IRV46_length";
						} 
							
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"{$r['length']}\" id=\"{$input_id}\"></td>"; 
						$isFirst = 0; 

					}else if($item["inventoryid"]=="IRV44"){ //error_log("2nd", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
						 
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"width\" value=\"{$r['length']}\"></td>";						 
					 
					}else if($item["inventoryid"]=="IRV45" ){ 
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" id=\"IRV45_length\" class=\"\" value=\"{$r['length']}\" ></td>";
				 
					}else if(($item["inventoryid"]=="IRV43" || $item["inventoryid"]=="IRV46" )   || $item["inventoryid"]=="IRV47" ){ //error_log("2nd", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
						$input_id="";
						if($item["inventoryid"]=="IRV47"){
							$input_id="IRV47_length"; 
						} 
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"width\" value=\"{$r['length']}\" id=\"{$input_id}\"></td>";						 
						$isFirst = 1; //set it back to equal 1 for IRV46 as 1st item.


					}else{
						//error_log("here", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
						$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"length\" value=\"{$r['length']}\"></td>"; 
					}

					$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  
  
  					$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
					       "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";
		   	$tr .= "</tr>";
	 	} 
	}else if($section=="downpipe"){
	 	
	 	
		if($projectId == null){
	 		$fw = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'downpipe'" ); // 
	 	}else{
	 		$fw = mysql_query("SELECT  i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(i.section) = 'downpipe' " ); // 
	 	}

		while ($r = mysql_fetch_assoc($fw)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>"; 
				$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
				$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
				$tr .= "<td> {$item["uom"]} </td>";  
				$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"\" value=\"{$r['length']}\" style=\"display:none\"> </td>";  
				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

			$tr .= "</tr>";
	 	} 
	}else if($section=="vergola"){
	 	
	 	
		if($projectId == null){
	 		$fw = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'vergola'" ); // 
	 	}else{
	 		$fw = mysql_query("SELECT i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(i.section) = 'vergola' " ); // 
	 	}

	 	$isFirst = 1; $isSecond = 0;$isThird = 0;$isFourth = 0; $isFifth = 0; $isSixth=0; $isSeventh=0; 
	 	$_isFirst = 1; $_isSecond = 0;$_isThird = 0;
		$colorSelection = ""; $listColourBondSelection = "";

		while ($r = mysql_fetch_assoc($fw)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
 
			$itemName = ""; $lengthInput = "";$itemClassName = "";
			$itemQty = "";
			$itemLen = ""; $itemLen_ft = "";
			if($isFirst==1){ 
				$isSecond=1; 
				$colorSelection = listColours2("",$r,"vergola-colour");
				$listColourBondSelection = listColourBond2(null,$r);
				$itemQty = 'id=\"louvres-qty-1\"'; //1st Louvres Poly in ever meter.
				$itemLen = 'id=\"louvres-len-1\"'; 

				if(METRIC_SYSTEM=="inch"){
					$itemLen_ft = 'id="louvres-len-1_ft"';
				}	

				$itemClassName = "poly_qty_field";

			}else if($isSecond==1){ 
				$isSecond=0; $isThird=1; 
				$colorSelection = listColours2("",$r);
				$listColourBondSelection = listColourBond2(null,$r);
				$itemQty = 'id=\"louvres-qty-2\"'; //2nd Louvres Poly in ever meter.
				$itemLen = 'id=\"louvres-len-2\"';  

				if(METRIC_SYSTEM=="inch"){
					$itemLen_ft = 'id="louvres-len-2_ft"';
				}
			}
			else if($isThird==1){ 
				$isThird=0; $isFourth=1; 
				$colorSelection = listColours2("",$r,"vergola-colour");
				$listColourBondSelection = listColourBond2(null,$r);
				 
			}else if($isFourth==1){ 
				$isFourth=0; $isFifth=1;
				$colorSelection = listColours2("",$r,"vergola-colour");
				$listColourBondSelection = listColourBond2(null,$r);

				$itemQty = 'id=\"pivot-qty-1\"'; // 1st Pivot strip 
				$itemLen = 'id=\"pivot-len-1\"'; 

			}else if($isFifth==1){ 
				$isFifth=0; $isSixth=1; 
				$colorSelection = listColours2("",$r,"vergola-colour");
				$listColourBondSelection = listColourBond2(null,$r);

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

			
			if($item["category"]=="Louvers"){
				$itemName = listItem2("louvres",$item);
				$lengthInput = "<input type=\"text\"  {$itemLen} name=\"slength[]\" class=\"width input-in\" value=\"{$r['length']}\" readonly />";
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

			// if($_isFirst==1){
			// 	$tr .= "<tr id=\"poly_master\" style=\"display:none\">";  
			// 	$_isFirst = 0;
			// 	$_isSecond = 1;
			// }else if($_isSecond==1){
			// 	$tr .= "<tr id=\"poly_dummy\" style=\"display:none\">"; 
			// 	$_isSecond = 0;
			// 	$_isThird = 1;
			// }else{
				$tr .= "<tr>"; 
			//}

				$tr .= "<td class=\"td-item\">{$itemName}<input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" inventoryid=\"{$item['inventoryid']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> ".$colorSelection." </td>";  
				$tr .= "<td class=\"td-finish-color\">".$listColourBondSelection." </td>";   
				$tr .= "<td> {$item["uom"]} </td>";  
				$tr .= "<td class=\"td-qty\"><input type=\"text\" {$itemQty} class=\"qtylen {$itemClassName}\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  

				$tr .= "<td class=\"td-len\">{$lengthInput}</td>";  
				if(METRIC_SYSTEM=="inch"){
					$tr .= "<td class=\"td-ft\"> {$lengthInput_ft} </td>"; 
				} 

				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  

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
	 	
	 	
		if($projectId == null){
	 		$fw = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'misc'" ); // 
	 	}else{
	 		$fw = mysql_query("SELECT i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(i.section) = 'misc' " ); // 
	 	}

		while ($r = mysql_fetch_assoc($fw)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>"; 
				$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
				$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
				$tr .= "<td> {$item["uom"]} </td>";  
				$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"\" value=\"{$r['length']}\" style=\"display:none\"> </td>";  
				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						"<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

			$tr .= "</tr>";
	 	} 
	}else if($section=="extra"){
	 	
	 	
		if($projectId == null){
	 		$fw = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'extras'" ); // 
	 	}else{
	 		$fw = mysql_query("SELECT i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(section) = 'extras' " ); // 
	 	}

		while ($r = mysql_fetch_assoc($fw)) { 
			$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
			
			$tr .= "<tr>"; 
				$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
				$tr .= "<td> </td>"; 
				$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
				$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
				$tr .= "<td> {$item["uom"]} </td>";  
				$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
				$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"\" value=\"{$r['length']}\" style=\"display:none\"> </td>";  
				$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  

				$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
					   "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";
			$tr .= "</tr>";
	 	} 
	}else if($section=="disbursements"){
	 	
	 	
		if($projectId == null){
	 		$fw = mysql_query("SELECT * FROM ver_vergola_default_framework_items   WHERE  framework = 'Double Bay VR4' AND LOWER(section) = 'Disbursements'" ); // 
	 	}else{
	 		$fw = mysql_query("SELECT i.inventoryid, q.* FROM ver_chronoforms_data_quote_vic AS q LEFT JOIN ver_chronoforms_data_inventory_vic AS i ON i.inventoryid=q.inventoryid WHERE projectid='{$projectId}' AND LOWER(section) = 'disbursements' " ); // 
	 	}

	 	//not wanted for u.s. market
		$unwanted_inventory_ids = array('IRV81', 'IRV84', 'IRV85');

		while ($r = mysql_fetch_assoc($fw)) { 
            if (!in_array($r["inventoryid"], $unwanted_inventory_ids)) {
				$item = mysql_fetch_assoc(mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic AS i  WHERE inventoryid='{$r["inventoryid"]}' " )); 
				
				$tr .= "<tr>"; 
					$tr .= "<td class=\"td-item\">".$item["description"]." <input type=\"hidden\" class=\"price\" value=\"{$item['rrp']}\" /> </td>";
					$tr .= "<td> </td>"; 
					$tr .= "<td> <input type=\"hidden\" name=\"colour[]\" /> </td>";  
					$tr .= "<td> <input type=\"hidden\" name=\"finish[]\" /> </td>";   
					$tr .= "<td> {$item["uom"]} </td>";  
					$tr .= "<td class=\"td-qty\"><input type=\"text\" class=\"qtylen\" name=\"qty[]\" value=\"{$r['qty']}\"></td>";  
					$tr .= "<td class=\"td-len\"><input type=\"text\"  name=\"slength[]\" class=\"\" value=\"{$r['length']}\" style=\"display:none\"> </td>";  
					$tr .= "<td class=\"td-rrp\"><input type=\"text\" class=\"rrp rrp-disbursement\" readonly=\"readonly\" name=\"rrp[]\" value=\"{$r['rrp']}\"> </td>";  

					$tr .= "<input type=\"hidden\" class=\"desc\" name=\"desc[]\" value=\"".$item['description']."\" readonly=\"readonly\" />".
						       "<input type=\"hidden\" class=\"invent\" name=\"invent[]\" value=\"".$item['inventoryid']."\" readonly=\"readonly\" />";

				$tr .= "</tr>";
            }
	 	} 
	}     
 
	return $tr;

}

   
function listItem2($framework_type,$item=null){
	$tag = "";  
	$framework_type = strtolower($framework_type);

	if($framework_type=="beams" || $framework_type=="intermediate"){
	 	
 		$result = mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic  WHERE  LOWER(section) = 'frame' AND (LOWER(category) = 'beams' OR LOWER(category) = 'intermediate')" ); // include the category intermediate bec. it is in the middle of the 2 beam in a double bay.
		$tag .= "<select class=\"desclist\" name=\"desclist[]\" >";
		while ($r = mysql_fetch_assoc($result)) {  
		    $tag .= "<option value=\"".$r['inventoryid']."\" price=\"".$r['rrp']."\"";
			if($r['inventoryid'] == $item["inventoryid"]) { $tag .= "selected=\"selected\""; } 
			$tag .= ">".$r['description'];
			$tag .= "</option>";
	        }	
		$tag .= "</select>"; 

		
	}else if($framework_type=="guttering"){
	 	
 		$result = mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic  WHERE  LOWER(section) = 'guttering'" ); // 
		$tag .= "<select class=\"desclist\" name=\"desclist[]\" >";
		while ($r = mysql_fetch_assoc($result)) {  
		    $tag .= "<option value=\"".$r['inventoryid']."\" price=\"".$r['rrp']."\"";
			if($r['inventoryid'] == $item["inventoryid"]) { $tag .= " selected"; } 
			$tag .= ">".$r['description'];
			$tag .= "</option>";
	        }	
		$tag .= "</select>"; 
		
	 }else if($framework_type=="posts"){
	 	
 		$result = mysql_query("SELECT * FROM  ver_chronoforms_data_inventory_vic  WHERE LOWER(section) = 'frame' AND LOWER(category) = 'posts'" ); // 
		$tag .= "<select class=\"desclist\" name=\"desclist[]\" >";
		while ($r = mysql_fetch_assoc($result)) {  
		    $tag .= "<option value=\"".$r['inventoryid']."\" price=\"".$r['rrp']."\" ";
			if($r['inventoryid'] == $item["inventoryid"]) { $tag .= " selected"; } 
			$tag .= ">".$r['description'];
			$tag .= "</option>";
	        }	
		$tag .= "</select>"; 
		
	 }else if($framework_type=="louvres"){
	 	
 		$result = mysql_query("SELECT * FROM ver_chronoforms_data_inventory_vic WHERE section = 'Vergola' and category  = 'Louvers'" ); // 
		$tag .= "<select class=\"desclist\" name=\"desclist[]\" >";
		while ($r = mysql_fetch_assoc($result)) {  
		    $tag .= "<option value=\"".$r['inventoryid']."\" price=\"".$r['rrp']."\" ";
			if($r['inventoryid'] == $item["inventoryid"]) { $tag .= "selected=\"selected\""; } 
			$tag .= ">".$r['description'];
			$tag .= "</option>";
	        }	
		$tag .= "</select>"; 
		
	 } 

	return $tag; 

}


function listWebbing2($selected="",$item){
	$querywebbing="SELECT cf_id, rrp, cost FROM ver_chronoforms_data_inventory_vic WHERE cf_id = '5'";
	$webbingItem = mysql_fetch_array(mysql_query($querywebbing));
	$sel1=""; $sel2="";
	//error_log("webbing Item :".print_r($item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	if($item["webbing"]=="Yes"){
		$sel2="selected";
	}else{
		$sel1="selected";
	}
	//error_log("Inside2 :".print_r($webbingItem,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	$tr = "<select class=\"webbing-list\" name=\"webbing[]\" webrrp=\"".$webbingItem["rrp"]."\" >".
	          "<option value=\"No\" {$sel1} >No</option>".
	          "<option value=\"Yes\" {$sel2} >Yes</option>".
	     "</select>";
	 
  
	return $tr;
}

function listColours2($selected=null,$item){  
	$sqlcolour = "SELECT * FROM ver_chronoforms_data_colour_vic ORDER BY colour";
	$resultcolour = mysql_query ($sqlcolour);
	$r = "<select class=\"colour\" name=\"colour[]\" >";
	while ($colour = mysql_fetch_assoc($resultcolour)) 
	{ 
		$r .= "<option value=\"{$colour['colour']}\" ";
		if ($colour['colour'] == $item['colour']) { $r .= " selected=\"selected\"";} 
		else {$r .= "";}
		$r .= ">{$colour['colour']}</option>";
	}
	$r .= "</select>";
	return $r;
}

function listColourBond2($selected=null,$item,$section="Frame"){  
	//error_log("Inside listColourBond2 :".print_r($item,true), 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
	$sql = "SELECT cf_id, rrp, cost, category, description FROM ver_chronoforms_data_inventory_vic WHERE section = '{$section}' AND category = 'Finish'  ";	
	$paints = mysql_query ($sql);

	$r = "<select class=\"paint-list\"  name=\"finish[]\" >";  
    while ($paint = mysql_fetch_array($paints)){
	  	$r .= "<option value=\"".$paint['description']."\"  finishrrp=\"".$paint["rrp"]."\""; 
		if($paint['description'] == $item['finish']){ $r .= "selected=\"selected\"";
		} else { $r .= "";}
		$r .= ">".$paint['description']."</option>";	
	}
	$r .= "</select>";

	return $r;

}



 
echo "<table class=\"listing-table\">";

// ***************************** Generate Framework Row ***********************************************//


// ***************************** Cbeam 200 Deep by 2.4mm ***********************************************//
echo "<tbody class=\"tbody_framework\">";
 
if($VergolaType != "Drop-In"){  

	echo "<tr><th>Description</th><th>Webbing</th><th>Colour</th><th>Finish</th><th>UOM</th><th>QTY</th><th>Length</th><th>RRP</th></tr>";
	echo "<tr><td colspan=\"8\" class=\"subheading\">Framework</td></tr>";
 	echo generateRowItem2("frame",$ProjectID); 
 
	  
	// ***************************** First Post 90 x 90 - 2mm Galv ********************************************//

	echo "<tr><td colspan=\"8\" class=\"subheading\">Fittings</td></tr>";
	 
	// ***************************** Fixing to Wall - Solid Brick ********************************************//
	echo generateRowItem2("fixings",$ProjectID); 

	 

	echo "</tbody>";
}

echo "<tbody class=\"tbody_non_framework\">";


echo "<tr><th>Description</th><th>Webbing</th><th>Colour</th><th>Finish</th><th>UOM</th><th>QTY</th><th>Length</th><th>RRP</th></tr>";
echo "<tr><td colspan=\"8\" class=\"subheading\">Gutters</td></tr>";

// ***************************** First Standard Vergola Gutter Lip Out 200 x 200 ********************************************//
echo generateRowItem2("guttering",$ProjectID); 
 

// ***************************** Cbeam Face Flashing Z al ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Flashing</td></tr>";
echo generateRowItem2("flashings",$ProjectID);  
 

// ***************************** Downpipe Plastic 3m ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Downpipe</td></tr>";
echo generateRowItem2("downpipe",$ProjectID);  

//error_log("INSIDE -- b4: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
// ***************************** Louvres Poly or Square ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Vergola System</td></tr>";
echo generateRowItem2("vergola",$ProjectID); 
//error_log("INSIDE -- after: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');

// ***************************** Opaque Enclosure ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Misc Items</td></tr>";
echo generateRowItem2("misc",$ProjectID); 
// ***************************** Misc Cost ********************************************//
 
// ***************************** Add Extra 1 ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Extras</td></tr>";
echo generateRowItem2("extra",$ProjectID); 

// ***************************** Shop Drawings ********************************************//
echo "<tr><td colspan=\"8\" class=\"subheading\">Disbursements</td></tr>";
echo generateRowItem2("disbursements",$ProjectID); 
//error_log("INSIDE -- last: ", 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
 
echo "</tbody>";
// End of Table
echo "</table>";
// error_log("output vr2: ".$framework, 3,'C:\\xampp\htdocs\\vergola_contract_system_v4_us\\my-error.log');
?>
