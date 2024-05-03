<?php
//include('session.php');
include_once("db.php");
//$f_type_id= $_SESSION['f_type_id'];

if (!empty($_POST["cid"])) {
    $cid = $_POST['cid'];
    include_once("nqst.php");
    
       $query = "SELECT c_subtype_id,$area_of_con_subtypedeatils as area_of_con_subtypedeatils FROM area_of_concern_subtype where area_of_con_id=$cid and fac_type_id=$f_type_id";
     //  $query = "SELECT c_subtype_id,$area_of_con_subtypedeatils as area_of_con_subtypedeatils FROM area_of_concern_subtype where area_of_con_id=$cid";
       $result = mysqli_query($con, $query);
    if ($result->num_rows > 0) {
       // echo '<option value="">   </option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['c_subtype_id'] . '">' . $row['area_of_con_subtypedeatils'] . '</option>';
        }
    }   
} 
?>
