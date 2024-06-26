<?php
include('session.php');
include_once("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h1.php');
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>DashBoard</h1>
  </div><!-- End Page Title -->

  <!-- ----working area ----->

  <section class="section">

    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">
          <!-- HWC Card -->
          <?php
          $uid=$_SESSION['userid'] ;
          $sql12 = "SELECT count(f.fac_id) as fac,f.Health_facilty_type,fa.facilities_type
                 FROM facilities_type as fa,facilities as f, s_user as s
                  where s.u_id=$uid and s.dist_id=f.dist_id 
                  and fa.fac_type_id=f.Health_facilty_type 
                    group by Health_facilty_type";
          $result12 = mysqli_query($con, $sql12);
          while ($row = mysqli_fetch_array($result12)) {

          ?>
            <div class="col-xxl-4 col-md-5">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h6 class="card-title">
                    <i class="bi bi-house-door-fill"></i><?php echo  $row['facilities_type']; ?>- <?php echo  $row['fac']; ?></span>
                  </h6>
                </div>
              </div>
            </div>
          <?php } ?>
        </div> <!-- End HWC Card -->
      </div>
    </div>
    </div>
    </div>
    </div>

    <!-----data end------->

  </section>
</main><!-- End #main -->
<!-- ----working area end ----->
<!-- ======= Footer ======= -->

<script>
  $(document).ready(function() {
    $("#Period1").on('change', function() {
      var Concernid = $('#Period1').val();
      $.ajax({
        method: "POST",
        cache: false,
        url: "response_m.php",
        data: {
          cid: Concernid,
        },
        datatype: "html",
        success: function(data) {
          $("#Concern1").html(data);
        },
        error: function(data) {}
      });
    });
  });
</script>
<?php
include('f.php');
?>
<!-- Template Main JS File -->



</body>

</html>