<?php
include_once("db.php");
if (!empty($_POST['cid'])) {
    
    $sid = $_POST['bid'];
    $sid1 = $_POST['cid'];
    
    $query1 = "SELECT fac_name , fac_id  FROM
     sarbsoft_nqa.facilities where block_id=$sid1 and dist_id=14 and Health_facilty_type=$sid";
    $result1 = mysqli_query($con, $query1);
    if ($result1->num_rows > 0) {
        echo '<option value=""></option>';
        while ($row = mysqli_fetch_assoc($result1)) {
            echo '<option value="' . $row['fac_id'] . '">' . $row['fac_name'] . '</option>';
        }
    }
}
?>
