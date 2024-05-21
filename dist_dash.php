<?php
include('session.php');
include_once("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h2.php');
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>DashBoard</h1>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="row">

          <?php
          $dist_id = $_SESSION['dist'];
          $call_q1 = "call Dist_dash_count($dist_id)";
          $q22 = mysqli_query($con, $call_q1);
          while ($row = mysqli_fetch_array($q22)) {
            $CHC = $row['CHC'];
            $PHC = $row['PHC'];
            $DH = $row['DH'];
            $HWC = $row['HWC'];
            $UPHC = $row['UPHC'];
            $CHCcomp = $row['CHCcomp'];
            $PHCcomp = $row['PHCcomp'];
            $DHcomp = $row['DHCcomp'];
            $HWCcomp = $row['HWCcomp'];
            $UPHCcomp = $row['UPHCcomp'];
            //====
          ?>
            <div class="col">

              <div class="d-flex no-block align-items-center">
                <div>
                  <i class="mdi mdi-image font-20  text-muted"></i>
                  <p class="font-16 m-b-5">CHC</p>
                </div>
                <div class="ml-auto">
                  <h1 class="font-light text-right"><?php echo $CHCcomp; ?>/<?php echo $CHC; ?></h1>
                </div>
              </div>

            </div>
            <div class="col">

              <div class="d-flex no-block align-items-center">
                <div>
                  <i class="mdi mdi-image font-20  text-muted"></i>
                  <p class="font-16 m-b-5">PHC</p>
                </div>
                <div class="ml-auto">
                  <h1 class="font-light text-right"><?php echo $PHCcomp; ?>/<?php echo $PHC; ?></h1>
                </div>
              </div>

            </div>
            <div class="col">


              <div class="d-flex no-block align-items-center">
                <div>
                  <i class="mdi mdi-image font-20  text-muted"></i>
                  <p class="font-16 m-b-5">DH</p>
                </div>
                <div class="ml-auto">
                  <h1 class="font-light text-right"><?php echo $DHcomp; ?>/<?php echo $DH; ?></h1>
                </div>
              </div>



            </div>
            <div class="col">



              <div class="d-flex no-block align-items-center">
                <div>
                  <i class="mdi mdi-image font-20  text-muted"></i>
                  <p class="font-16 m-b-5">HWC</p>
                </div>
                <div class="ml-auto">
                  <h1 class="font-light text-right"><?php echo $HWCcomp; ?>/<?php echo $HWC; ?></h1>
                </div>
              </div>




            </div>
            <div class="col">

              <div class="d-flex no-block align-items-center">
                <div>
                  <i class="mdi mdi-image font-20  text-muted"></i>
                  <p class="font-16 m-b-5">UPHC</p>
                </div>
                <div class="ml-auto">
                  <h1 class="font-light text-right"><?php echo $UPHCcomp; ?>/<?php echo $UPHC; ?></h1>
                </div>
              </div>



            </div>

          <?php }
          mysqli_free_result($q22);
          $con->next_result();
          ?>
        </div>
      </div>
    </div>
    Drill Down For more detail*
    <div class="card">
      <div class="card-body">
        <form enctype="multipart/form-data" method="post" action="#">
          <div class="row mb-3">

            <div class="col-sm-2">
              <label>Block</label>
              <select class="form-select" id="District" name="District">
                <?php
                $dist_id = $_SESSION['dist'];
                $call_q1 = "SELECT distinct(block_id) ,Block_Name FROM sarbsoft_nqa.facilities where dist_id=$dist_id";
                $q22 = mysqli_query($con, $call_q1);
                while ($row = mysqli_fetch_array($q22)) {
                ?>
                  <option value="<?php $_SESSION['bid'] = $row['block_id'];
                                  echo $row['block_id']; ?>"><?php echo $row['Block_Name']; ?></option>
                <?php }
                mysqli_free_result($q22);
                $con->next_result();
                ?>
              </select>
            </div>
            <div class="col-sm-2">
              <label>Ins. Type</label>
              <select class="form-select" id="Block" name="Block">
                <?php
                $dist_id = $_SESSION['dist'];
                $call_q1 = "SELECT fac_type_id,facilities_type FROM sarbsoft_nqa.facilities_type";
                $q22 = mysqli_query($con, $call_q1);
                while ($row = mysqli_fetch_array($q22)) {
                ?>
                  <option value="<?php echo $row['fac_type_id']; ?>"><?php echo $row['facilities_type']; ?></option>
                <?php }
                mysqli_free_result($q22);
                $con->next_result();
                ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label>Institute </label>
              <select class="form-select" id="Village" name="Village">
                <option value=" ">Institute</option>
              </select>
            </div>
            <div class="col-sm-3">
              <label>Ass. Period </label>
              <select class="form-select" id="Period" name="Period">
                <option value=" ">Period</option>
              </select>
            </div>
            <div class="col-sm-2">
              <label></label></br>
              <button type="submit" value="Submit" name="postsubmit"  class="btn btn-secondary">View</button>
            </div>
        </form>
      </div>

    </div>

    </div>
    <!=========DIS /block/village load start=====================>

  </section>
  <script>
    $(document).ready(function() {
      $("#Block").on('change', function() {
        var Blockid = $(this).val();
        var Districtid1 = document.getElementById("District");
        var selectedValue1 = District.value;
        $.ajax({
          method: "POST",
          url: "responce_dist.php",
          data: {
            cid: selectedValue1,
            bid: Blockid,

          },
          datatype: "html",
          success: function(data) {
            $("#Village").html(data);

          }
        });
      });

    });
  </script>
  <script>
    $(document).ready(function() {
      $("#Village").on('change', function() {
        var Villageid = $(this).val();
        $.ajax({
          method: "POST",
          url: "responce_dist1.php",
          data: {
            cid: Villageid,
          },
          datatype: "html",
          success: function(data) {
            $("#Period").html(data);

          }
        });
      });

    });
  </script>
</main><!-- End #main -->
<!-- ----working area end ----->
<!-- ======= Footer ======= -->
<?php
include('f.php');
?>
<!-- Template Main JS File -->



</body>

</html>