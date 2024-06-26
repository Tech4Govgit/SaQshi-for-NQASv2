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
  </div>
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

              $fid = $_SESSION['u_facilityid'];


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
                $f_ty_id = $_SESSION['f_type_id'];
                $fid = $_SESSION['u_facilityid'];
                $assid = $_SESSION['u_ass'];

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
                    $f_ty_id = $_SESSION['f_type_id'];
                    $fid = $_SESSION['u_facilityid'];
                    $assid = $_SESSION['u_ass'];
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

                    $f_ty_id = $_SESSION['f_type_id'];
                    $fid = $_SESSION['u_facilityid'];
                    $assid = $_SESSION['u_ass'];
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
                    $f_ty_id = $_SESSION['f_type_id'];
                    $fid = $_SESSION['u_facilityid'];
                    $assid = $_SESSION['u_ass'];
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

                      $fid = $_SESSION['u_facilityid'];
                      $assid = $_SESSION['u_ass'];
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
</main><!-- End #main -->
<!-- ----working area end ----->
<!-- ======= Footer ======= -->
<?php
include('f.php');
?>
<!-- Template Main JS File -->



</body>

</html>