<?php 
 
// Load the database configuration file 
include_once("db.php"); 
 
// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php'; 
 
// Excel file name for download 
$fileName = "Department_Score_Card_" . date('Y-m-d') . ".xlsx"; 
 
// Define column names 
$excelData[] = array('fac id', 'state', 'Dist', 'Block', 'fac'); 
 
// Fetch records from database and store in an array 
$query = $con->query("SELECT fac_id,state_name,Dist_Name,Block_Name,fac_name  FROM sarbsoft_nqa.facilities"); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['fac_id'], $row['state_name'], $row['Dist_Name'], $row['Block_Name'],$row['fac_name']);  
        $excelData[] = $lineData; 
    } 
} 
 
// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray( $excelData ); 
$xlsx->downloadAs($fileName); 
 
exit; 
 
?>