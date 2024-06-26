<?php
//$db_host = 'localhost';
//$db_user = 'sarbsoft_sarbsoft_nqa_testadmin';
//$db_pass = '!@#897manish';
//$db_name = 'sarbsoft_nqa_test';
//$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
//$con = mysqli_connect("localhost","sarbsoft_sarbsoft_nqa_testadmin","!@#897manish","sarbsoft_nqa_test");
//if ($con->connect_error) {
 //   die("Connection failed: " . $conn->connect_error);
//    mysqli_close($con); 
//  }
$con = mysqli_connect("localhost","sarbsoft_sarbsoft_nqaadmin","!@#897manish","sarbsoft_nqa_test");
if (!$con) {
	die("Connection failed: " . mysqli_connect_error());
}
   
?>
