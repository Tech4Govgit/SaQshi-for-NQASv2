<?php
include('session.php');
// Load the database configuration file 
include_once("db.php");

// Include XLSX generator library 
require_once 'PhpXlsxGenerator.php';
$dist_id = $_SESSION['dist'];
$userid = $_SESSION['userid'];
// Excel file name for download 
$fileName = "Dist_Facility_indicators_Summary_" . date('Y-m-d') . ".xlsx";
// Define column names 
$excelData[] = array('District', 'Block', 'Fac. Type', 'Facility','Non Comp.','Partially Comp.','Fully Comp.','Compliance Completed','Indicators','Comp.%','Obtained Score','Tot Score','Score %');

// Fetch records from database and store in an array 
$tablequery1 = "call DQA_count_zero_o_t_dash($dist_id,$userid)";
$q2 = mysqli_query($con, $tablequery1);
while ($row = mysqli_fetch_array($q2)) {
    $obtained = $row['p'];
    $m = $row['marks'];
    $f = $row['f'];
    $p1 = round((($m / $f) * 100), 2);
    if ($obtained != null) {       

        $lineData = array($row['Dist_Name'],  $row['Block_Name'],$row['facilities_type'],$row['fac_name'],$row['zero'],$row['one'],$row['two'],$row['obt'],$row['tot'],$row['p'],$row['marks'],$row['f'],$p1);
        $excelData[] = $lineData;
    }
}

// Export data to excel and download as xlsx file 
$xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excelData);
$xlsx->downloadAs($fileName);

exit;
