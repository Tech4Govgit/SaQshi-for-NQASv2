<?php
include('session.php');
session_regenerate_id();
//$sid1=$_SESSION['$sid'];
session_unset();
//session_destroy();
  ob_end_clean();
  if(session_destroy()) {
     header("Location: login1.php");
  }
  exit();
?>