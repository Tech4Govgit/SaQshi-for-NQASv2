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
    <!============================================================>
    <?php
     if (isset($_POST['postsubmit'])) {
$u_facilityid=$_POST['Block'];
$u_ass=$_POST['Period'];
$u_fid=$_POST['Village'];
    
    ?>
    <section class="section">
    <! -------------------------------------------->
      <div class="row">
        <div class="col-lg-6 col-xl-4">
          <div class="card mb-3 widget-content">
            <div class="widget-content-wrapper">
              <div class="widget-content-left">
                <div class="widget-heading">Departments</div>
                <div class="widget-subheading"> </div>
              </div>
              <?php

              $fid = $u_fid;


              $call_q1 = "SELECT count(fac_dept_id) FROM sarbsoft_nqa.fac_dept_map where fac_id=$fid";
              $q22 = mysqli_query($con, $call_q1);
              while ($row = mysqli_fetch_array($q22)) {
                $obtained = $row['count(fac_dept_id)'];

                //====
                if ($obtained != null) {
              ?>
                  <div class="widget-content-right">
                    <div class="widget-numbers text-primary"><span><?php echo $obtained; ?></span></div>
                <?php
                }
              }
              mysqli_free_result($q22);
              $con->next_result();
                ?>
                  </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xl-4">
          <div class="card mb-3 widget-content">
            <div class="widget-content-wrapper">
              <div class="widget-content-left">
                <div class="widget-heading">Score</div>
                <div class="widget-subheading"> </div>
              </div>
              <div class="widget-content-right">
                <?php
                $f_ty_id = $u_facilityid;
                $fid = $u_fid;
                $assid = $u_ass;

                $call_q1 = "call facility_dash_dh_perc($f_ty_id, $fid, $assid)";
                $q22 = mysqli_query($con, $call_q1);
                while ($row = mysqli_fetch_array($q22)) {
                  $obtained = $row['Obtained'];
                  $total = $row['total'];
                  //====
                  if ($obtained != null) {
                    $percentage = round((($obtained / $total) * 100), 2);
                    if ($percentage > 70) {
                ?>
                      <div class="widget-numbers text-success"><span><?php echo $percentage; ?>%</span></div>
                    <?php } else { ?>
                      <div class="widget-numbers text-danger"><span><?php echo $percentage; ?>%</span></div>
                    <?php
                    }
                  } else {
                    $percentage = 0;
                    ?>
                    <div class="widget-numbers text-danger"><span><?php echo $percentage; ?>%</span></div>
                <?php
                  }
                }
                mysqli_free_result($q22);
                $con->next_result();
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xl-4">
          <div class="card mb-3 widget-content">
            <div class="widget-content-wrapper">
              <div class="widget-content-left">
                <div class="widget-heading">Indicators</div>
                <div class="widget-subheading"> </div>
              </div>
              <div class="widget-content-right">
              <?php
                  $call_q2 = "call facility_dash_dh_perc($f_ty_id, $fid, $assid)";
                  $call_q2 = mysqli_query($con, $call_q2);
                  while ($row = mysqli_fetch_array($call_q2)) {
                    $obtained = $row['assessed_checklist'];
                    $total = $row['total_checklist'];
                    if ($obtained != null) {
                      $percentage = round((($obtained / $total) * 100), 2);
                      if ($percentage > 70) {
                  ?>
                <div class="widget-numbers text-success"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                <?php } else { ?>
                      <div class="widget-numbers text-danger"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                    <?php
                    }
                  } else {
                    $percentage = 0;
                    ?>
                    <div class="widget-numbers text-danger"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                    <?php
                  }?>
                  
              </div>
            </div>
          </div>
        </div>
      </div>
      <! -------------------------------------------->
        <div class="row">
          <div class="col-lg-6 col-xl-4">
            <div class="card mb-3 widget-content">
              <div class="widget-content-wrapper">
                <div class="widget-content-left">
                  <div class="widget-heading">Non Compliance</div>
                  <div class="widget-subheading"></div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-danger"><span><?php echo  $row['z']; ?></span></div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-6 col-xl-4">
            <div class="card mb-3 widget-content">
              <div class="widget-content-wrapper">
                <div class="widget-content-left">
                  <div class="widget-heading">Partially  Compliance</div>
                  <div class="widget-subheading"></div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-warning"><span><?php echo  $row['o']; ?></span></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-4">
            <div class="card mb-3 widget-content">
              <div class="widget-content-wrapper">
                <div class="widget-content-left">
                  <div class="widget-heading">Fully Compliance</div>
                  <div class="widget-subheading"></div>
                </div>
                <div class="widget-content-right">
                  <div class="widget-numbers text-success"><span><?php echo  $row['t']; ?></span></div>
                </div>
              </div>
            </div>
          </div>
          <?php
                }
                mysqli_free_result( $call_q2);
                $con->next_result();
                ?>
        </div>
        <! -------------------------------------------->
          <! -------------------------------------------->
            
            <div class="row">
              <div class="col-sm-6">
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title">Departments Score(%) Card </h6>
                    <?php
                    $f_ty_id = $u_facilityid;
                    $fid = $u_fid;
                    $assid = $u_ass;
                    $tablequery = "CALL depart_dash_dh($f_ty_id, $fid, $assid)";
                    $q = mysqli_query($con, $tablequery);
                    while ($row = mysqli_fetch_array($q)){
                      $perce=round(($row['Obtained'] / $row['total']) * 100, 2);
                    if ($perce>70){
                  ?>
                    <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                    <span class="badge bg-success"> <?php echo  $perce; ?>%</span><br>

                  <?php }elseif($perce>65 and $perce<70){
                    ?>
                    <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                    <span class="badge bg-warning"> <?php echo  $perce; ?>%</span><br>
                    <?php
                  }elseif($perce<65){

                   ?>
                    <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                    <span class="badge bg-danger"> <?php echo  $perce; ?>%</span><br>
                    <?php 
                    }else{
              $perce=0;
                        ?>
                       <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                    <span class="badge bg-danger"> <?php echo  $perce; ?>%</span><br>  
                    <?php }
                    }

                  mysqli_free_result($q);
                  $con->next_result();
                  ?>
                  </div>
                </div>
              </div>



              <div class="col-sm-6">
                <div class="card">

                  <div class="card-body">
                    <h4 class="card-title">Checkpoint assessed </h4>
                    <?php

                    $f_ty_id = $u_facilityid;
                    $fid = $u_fid;
                    $assid = $u_ass;
                    $tablequery = "CALL depart_dash_indicator_count_dh($f_ty_id, $fid, $assid)";
                    $q = mysqli_query($con, $tablequery);
                    while ($row = mysqli_fetch_array($q)) {
                      $perce=round(($row['Obtained'] / $row['total']) * 100, 2);
                      if ($perce>70){
                    ?>
                      <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                      <span class="badge bg-success"> <?php echo  $row['Obtained']; ?></span>/<span class="badge bg-secondary rounded-pill"><?php echo  $row['total']; ?></span><br>

                    <?php }else{
                      ?>
                      <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                      <span class="badge bg-danger"> <?php echo  $row['Obtained']; ?></span>/<span class="badge bg-secondary rounded-pill"><?php echo  $row['total']; ?></span><br>
                      <?php }
                    }

                    mysqli_free_result($q);
                    $con->next_result();
                    ?>
                  </div>
                </div>
              </div>
              <!------>
            </div>

            <div class=row>
              <div class="col-lg-6">
                <div class="card">

                  <div class="card-body">
                    <h5 class="card-title">Areas of Concern wise Facility Score(%) Card </h5>
                    <?php
                    $f_ty_id = $u_facilityid;
                    $fid = $u_fid;
                    $assid = $u_ass;
                    $tablequery = "CALL admin_dash($f_ty_id, $fid, $assid)";
                    $q = mysqli_query($con, $tablequery);
                    while ($row = mysqli_fetch_array($q)) {
                      $conc=$row['concern_name'];
                      $perce=round(($row['Obtained'] / $row['total']) * 100, 2);
                     
                      if ($perce>70){
                        ?>
                <!-- Progress Bars with labels-->
                <label><?php echo  $conc; ?></label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                </div>
                <?php }elseif($perce>65 and $perce<70) {
                          
                            ?>
                            <label><?php echo  $conc; ?></label>
                            <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                </div>
                <?php
                          }elseif($perce<65) {
                            ?> 
                            <label><?php echo $conc; ?></label>
                            <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                </div>
                <?php
            }else{
              $perce=0;
                        ?>
                        <label><?php echo  $conc; ?></label>
                        <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                </div>
            <?php }}
            mysqli_free_result($q);
            $con->next_result();
            ?>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Department Wise Compliance Status</h5>

                    <!-- Column Chart -->
                    <div id="columnChart">
                      <?php

                      $fid = $u_fid;
                      $assid = $u_ass;
                      $query = "CALL facility_dept_caht($fid,$assid)";
                      $result = $con->query($query);
                      if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          $values[] = $row['dept_name'];
                          $values1[] = "'" . $row['o'] . "'";
                          $values0[] = "'" . $row['z'] . "'";
                          $values2[] = "'" . $row['t'] . "'";
                        }
                        $h = "'" . implode("','", $values) . "'";
                        $h0 = implode(",", $values0);
                        $h1 = implode(",", $values1);
                        $h2 = implode(",", $values2);
                      ?>
                        <script>
                          document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#columnChart"), {
                              series: [{
                                name: 'Non compliance',
                                data: [<?php echo $h0; ?>]
                              }, {
                                name: 'Partially  Compliance',
                                data: [<?php echo $h1; ?>]
                              }, {
                                name: 'Fully compliance',
                                data: [<?php echo $h2; ?>]
                              }],
                              chart: {
                                type: 'bar',
                                height: 350
                              },
                              plotOptions: {
                                bar: {
                                  horizontal: false,
                                  columnWidth: '25%',
                                  endingShape: 'rounded'
                                },
                              },
                              dataLabels: {
                                enabled: false
                              },
                              stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                              },
                              xaxis: {
                                categories: [<?php echo $h; ?>],
                              },
                              yaxis: {
                                title: {
                                  text: 'No of Indicators'
                                }
                              },
                              fill: {
                                opacity: 1
                              },
                              tooltip: {
                                y: {
                                  formatter: function(val) {
                                    return val + " " + "indicators"
                                  }
                                }
                              }
                            }).render();
                          });
                        </script>
                      <?php } ?>
                      <!-- End Column Chart -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
  </section>
  <?php } ?>
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