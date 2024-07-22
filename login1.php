<?php
include("db.php");
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SAQSHI</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-1">
                             <a href="login1.php" class="logo d-flex align-items-center w-auto">
                             <span class="d-block d-lg-block"><h3>SA<img src="assets/img/n.jpg">SHI</h3></span>
                             
                 
                </a>
              </div><!-- End Logo -->
              <div class="card mb-5">
                <div class="card-body">
                  <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  <form class="row g-3 needs-validation" action="#" enctype="multipart/form-data" action method="POST" runat="server" novalidate>
                    <div class="col-12">
                      <center><label for="yourUsername" class="form-label">Username</label></center>
                      <div class="input-group has-validation">
                        <input type="text" name="myusername" class="form-control" id="myusername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <center><label for="yourPassword" class="form-label">Password</label></center>
                      <input type="password" name="mypassword" class="form-control" id="mypassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <center><label for="Select" class="form-label">Language</label></center>
                      <select class="form-select" aria-label="Default select example" id="lang" name="lang">
                        <option value="5">English</option>
                        <?php
                        $query = "select lang_id,lang_name from lang_mast";
                        
                        // $query = mysqli_query($con, $qr);
                        $result = $con->query($query);
                        if ($result->num_rows > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['lang_id']; ?>"><?php echo $row['lang_name']; ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? Kindly Contact you Facility Admin!</p>
                      
                    </div>
                  </form>
                  <?php
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // username and password sent from form 

                    $myusername = mysqli_real_escape_string($con, $_POST['myusername']);
                    $mypassword = mysqli_real_escape_string($con, $_POST['mypassword']);
                    $_SESSION['lang'] = $_POST['lang'];
                    $sql = " select * FROM s_user WHERE (u_name='$myusername' AND  u_password='$mypassword' and is_active=1)";
                    $result = mysqli_query($con, $sql);
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                      $userid = $row['u_id'];
                      $userrole = $row['role_id_fk'];
                      //$userfacility = $row['fac_id_fk'];
                      $myusername = $row['u_name'];
                      //$deptid = $row['dept_id'];
                      //  $utype = $row['user_type'];
                      // $ass_period = $row['assessment_id'];
                       $district_id = $row['dist_id'];
                      //  $_SESSION['f_type_id']=$row['Health_facilty_type'];
                      //echo "<script type='text/javascript'>alert('Login Success')</script>";
                      echo "Login Success";
                      if ($userrole == 1) {
                        $sql12 = "SELECT a.fac_id_fk,a.assessment_id,a.dist_id,b.Health_facilty_type FROM s_user as a , facilities as b WHERE (a.u_id=$userid and a.is_active=1) and  a.fac_id_fk=b.fac_id";
                        $result12 = mysqli_query($con, $sql12);
                        $row = mysqli_fetch_array($result12, MYSQLI_ASSOC);
                        //$count12 = mysqli_num_rows($result12);
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        $_SESSION['u_name'] = $myusername;
                        $district_id = $row['dist_id'];
                        $userfacility = $row['fac_id_fk'];
                        $userass =$row['assessment_id'];
                        $_SESSION['f_type_id'] = $row['Health_facilty_type'];
                        $_SESSION['u_facilityid'] = $userfacility;
                        $_SESSION['u_ass'] = $userass;
                        // Welcome message   
                        header("location:index1.php");
                      } elseif ($userrole == 2) {
                        $sql12 = "SELECT a.fac_id_fk,a.dept_id,a.assessment_id,b.Health_facilty_type
                        FROM s_user as a , facilities as b WHERE (a.u_id=$userid and a.is_active=1) and  a.fac_id_fk=b.fac_id";
                        $result12 = mysqli_query($con, $sql12);
                        $row = mysqli_fetch_array($result12, MYSQLI_ASSOC);
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        // $_SESSION['user_type'] = $utype;
                        $_SESSION['u_name'] = $myusername;
                        $_SESSION['u_facilityid'] = $row['fac_id_fk'];
                        $_SESSION['dept_id1'] = $row['dept_id'];
                        $_SESSION['assperiod'] = $row['assessment_id'];
                        $_SESSION['f_type_id'] = $row['Health_facilty_type'];
                        // Welcome message   
                        echo "Login Success";
                        header("location:index.php");
                      } elseif ($userrole == 3) {
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        $_SESSION['u_name'] = $myusername;
                        $_SESSION['u_facilityid'] = $userfacility;
                        $_SESSION['f_type_id'] = $row['Health_facilty_type'];
                        // Welcome message   
                        header("location:index.php");
                      } elseif ($userrole == 4) {
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        $_SESSION['u_name'] = $myusername;
                        $_SESSION['dist'] = $district_id;
                       
                        
                        // Welcome message   
                        header("location:dist_dash_test.php");
                      } elseif ($userrole == 5) {
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        $_SESSION['u_name'] = $myusername;
                        $_SESSION['f_type_id'] = $row['Health_facilty_type'];
                        // $_SESSION['u_facilityid']=$userfacility;
                        // Welcome message   
                        header("location:index.php");
                      } elseif ($userrole == 6) {
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        $_SESSION['u_name'] = $myusername;
                        $_SESSION['f_type_id'] = $row['Health_facilty_type'];
                        //$_SESSION['u_facilityid']=$userfacility;
                        // Welcome message   
                        header("location:index.php");
                      }elseif ($userrole == 8) {
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        $_SESSION['u_name'] = $myusername;
                        $_SESSION['dist'] = $district_id;                       
                        $_SESSION['block_id'] =  $row['block_id'];
                        header("location:block_dash_test.php");
                      }elseif ($userrole == 9) {
                        $_SESSION['urole'] = $userrole;
                        $_SESSION['userid'] = $userid;
                        $_SESSION['u_name'] = $myusername;
                       // $_SESSION['dist'] = $district_id;                       
                        //$_SESSION['block_id'] =  $row['block_id'];
                        header("location:s_dash_test.php");
                      }
                    }else {
                     
                      // echo "<script type='text/javascript'>alert('Enter valide credential')</script>";
                      echo  '<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
               Email or password wrong! Please try again!.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
                   // header("location:login1.php");
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
  <center><div class="copyright">
            &copy; Copyright <img src="/assets/img/p.png"/>Piramal Swasthya.</br> All Rights Reserved
        </div></center>
</body>

</html>