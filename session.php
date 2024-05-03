<?php
   include('db.php');
   ob_start();
  session_start();
  if(!isset($_SESSION['u_name'])){
    header("Location: 404.php");
    die();
 }else{
       $user_check = $_SESSION['u_name'];
      $ses_sql = mysqli_query($con,"select u_name from s_user where u_name = '$user_check' ");
      $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
    $login_session = $row['u_name'];
 }
?>