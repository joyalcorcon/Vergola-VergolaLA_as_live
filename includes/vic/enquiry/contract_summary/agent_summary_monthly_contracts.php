<?php
/*
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
----- cli command -----
----- ----- ----- ----- ----- ----- ----- ----- ----- -----
*/
/*
// --- at local site --- //
C:\xampp_3\php\php C:\xampp_3\htdocs\vergola_contract_system_v4_la\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"local\", \"vergola_region\":\"la\", \"record_update_type\":\"flush\"}"
C:\xampp_3\php\php C:\xampp_3\htdocs\vergola_contract_system_v4_la\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"local\", \"vergola_region\":\"la\", \"record_update_type\":\"append\"}"

// --- at joy-local site --- //
C:\xampp\php\php C:\xampp\htdocs\VergolaLA\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"preproduction\", \"vergola_region\":\"la\", \"record_update_type\":\"flush\"}"
C:\xampp\php\php C:\xampp\htdocs\VergolaLA\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"preproduction\", \"vergola_region\":\"la\", \"record_update_type\":\"append\"}"

// --- at preproduction site --- //
C:\xampp\php\php C:\xampp\htdocs\vergola_contract_system_v4_us\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"preproduction\", \"vergola_region\":\"la\", \"record_update_type\":\"flush\"}"
C:\xampp\php\php C:\xampp\htdocs\vergola_contract_system_v4_us\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"preproduction\", \"vergola_region\":\"la\", \"record_update_type\":\"append\"}"

// --- at live site --- //
C:\xampp\php\php C:\xampp\htdocs\vergola_contract_system_v4_us\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"live\", \"vergola_region\":\"la\", \"record_update_type\":\"flush\"}"
C:\xampp\php\php C:\xampp\htdocs\vergola_contract_system_v4_us\includes\vic\enquiry\sales_summary\agent_summary_monthly_contracts.php data="{\"server_mode\":\"live\", \"vergola_region\":\"la\", \"record_update_type\":\"append\"}"
*/

// /*
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ----- include files -----
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// */
 require('functions_general.php');
 require('functions_module.php');
 require('html_templates.php');
 require('sql_templates.php');
 require('config_module.php');

// /*
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// ----- initialise variables -----
// ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
// */
/* 
 $db_connection = new mysqli(
     $config['db']['host_name'], 
     $config['db']['user_name'], 
     $config['db']['password'], 
     $config['db']['db_name'] 
 );
 if ($db_connection->connect_error) {
     die('error: ' . $db_connection->connect_error);
 }


$servername = "mysql.hostinger.co.uk";
$database = "u266072517_name";
$username = "u266072517_user";
$password = "buystuffpwd";
 */
 
 // Create connection

 $conn = mysqli_connect(
     $config['db']['host_name'], 
     $config['db']['user_name'], 
     $config['db']['password'], 
     $config['db']['db_name'] 
 
 );

 // Check connection

 if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
 }
 
				echo "Connected successfully";

				$cdate = new DateTime('first day of previous month'); 
		 		
				$target_date = date_format($cdate, 'Y-m-d');
				$mDate = date_format($cdate, 'F Y');		
		 		echo "target date: " . $target_date . "<br>" . mysqli_error($conn);
		 		$sql_get_table_summary_contracts = "
				INSERT tblcontractsummary (target_month, no_contract, no_check_measure, no_drawing_prep, no_drawing_approve, no_dev_approve, no_fw_complete_not_done, no_fw_complete_done, no_job_sched, no_job_complete)  
						
					SELECT   
						'{$target_date}' as target_month,
				        -- COUNT(cf_id) as no_contract,
			        	-- ( SELECT COUNT( cf_id ) FROM ver_chronoforms_data_contract_vergola_vic WHERE contractdate BETWEEN ( CURDATE() ) AND LAST_DAY( CURDATE() ) ) AS no_contract,	
						( SELECT COUNT( cf_id ) FROM ver_chronoforms_data_contract_vergola_vic WHERE contractdate BETWEEN DATE_SUB('{$target_date}', INTERVAL 1 MONTH) AND LAST_DAY('{$target_date}')) AS no_contract,	

						COUNT(IFNULL(check_measure_date, 1))-IF(check_measure_date = NULL,false,COUNT(check_measure_date)) as no_check_measure,
			        	COUNT(IFNULL(drawing_prepare_date, 1))-IF(drawing_prepare_date = NULL,false,COUNT(drawing_prepare_date)) as no_drawing_prep,
				        COUNT(IFNULL(drawing_approve_date, 1))-IF(drawing_approve_date = NULL,false,COUNT(drawing_approve_date)) as no_drawing_approve,
				        COUNT(IFNULL(da_date, 1))-IF(da_date = NULL,false,COUNT(da_date)) as no_dev_approve,
			        	COUNT(IFNULL(fw_complete, 1))-IF(fw_complete = NULL,false,COUNT(fw_complete)) as no_fw_complete_not_done, 
				        IF(fw_complete IS NOT NULL,false,COUNT(fw_complete)) AS no_fw_complete_done, 
				        IF(install_date IS NOT NULL,false,COUNT(install_date)) AS no_job_sched,
				        (SELECT COUNT(cf_id) FROM ver_chronoforms_data_contract_vergola_vic WHERE contractdate BETWEEN DATE_SUB('{$target_date}', INTERVAL 30 MONTH) AND LAST_DAY('{$target_date}') AND job_end_date IS NOT NULL ) AS no_job_complete
				     
						FROM ( 
							SELECT  c.cf_id, c.quoteid, c.projectid, c.contractdate, cv.drawing_approve_date, cs.permit_approved_date, cv.production_start_date, cv.job_start_date, cv.job_end_date, cv.handover_date, cs.da_date, cv.fw_complete, cv.install_date, cv.check_measure_date, cv.drawing_prepare_date 
						    FROM ver_chronoforms_data_contract_list_vic AS c 
						    JOIN ver_chronoforms_data_contract_vergola_vic AS cv ON cv.projectid=c.projectid 
						    JOIN ver_chronoforms_data_contract_statutory_vic AS cs ON cs.projectid=c.projectid 
						    WHERE c.contractdate BETWEEN DATE_SUB('{$target_date}', INTERVAL 30 MONTH) AND LAST_DAY('{$target_date}') AND handover_date is null 
						    ) AS t"; 
					
					
if (mysqli_query($conn, $sql_get_table_summary_contracts)) {
      echo "New record created successfully";
} else {
      echo "Error: " . $sql_get_table_summary_contracts . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

 ?>