<?php
//include('session.php');
include_once("db.php");
//$f_type_id= $_SESSION['f_type_id'];

if (!empty($_POST["cid"])) {
   // $cid = $_POST['cid'];
   include_once("nqst.php");
   $pi1= $_SESSION['assperiod'];
   $fsid = $_SESSION['u_facilityid'];
   $dept_id=$_SESSION['dept_id1'];
  $cid=$_POST['cid'];
 $ftype=$_SESSION['f_type_id'];
   $query="call get_Standards_count_load($cid,$ftype,$fsid,$dept_id,$pi1)";
   $result = mysqli_query($con, $query);   
   if ($result->num_rows > 0) {
       // echo '<option value="">   </option>';
       
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['c_subtype_id'] . '">' . $row['area_of_con_subtypedeatils'] . '</option>';
        }
        mysqli_free_result($result);
                           $con->next_result();
    }elseif($result->num_rows==0){
      
        echo  '<option value="0">-Select-</option>';
        
    }
} else {
    print_r($mysqli -> error_list);
}  
   
?>

