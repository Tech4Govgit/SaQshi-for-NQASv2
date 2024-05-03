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
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title">Department wise Score(%) Card </h2>
            <?php
            $f_ty_id = $_SESSION['f_type_id'];
            $fid = $_SESSION['u_facilityid'];
            $assid = $_SESSION['u_ass'];
            $tablequery = "CALL depart_dash_dh($f_ty_id, $fid, $assid)";
            $q = mysqli_query($con, $tablequery);
            while ($row = mysqli_fetch_array($q)) {
            ?>
              <span class="badge bg-info text-dark"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
              <span class="badge bg-primary rounded-pill"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</span><br>
            <?php }
            mysqli_free_result($q);
            $con->next_result();
            ?>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">

          <div class="card-body">
            <h2 class="card-title">Department wise checkpoint assessed </h2>
            <?php
            $f_ty_id = $_SESSION['f_type_id'];
            $fid = $_SESSION['u_facilityid'];
            $assid = $_SESSION['u_ass'];
            $tablequery = "CALL depart_dash_indicator_count_dh($f_ty_id, $fid, $assid)";
            $q = mysqli_query($con, $tablequery);
            while ($row = mysqli_fetch_array($q)) {

            ?>
              <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
              <span class="badge bg-primary"> <?php echo  $row['Obtained']; ?></span>/<span class="badge bg-primary rounded-pill"><?php echo  $row['total']; ?></span><br>

            <?php }

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
            <h2 class="card-title">Areas of Concern wise Facility Score(%) Card </h2>
            <?php
            $f_ty_id = $_SESSION['f_type_id'];
            $fid = $_SESSION['u_facilityid'];
            $assid = $_SESSION['u_ass'];
            $tablequery = "CALL admin_dash($f_ty_id, $fid, $assid)";
            $q = mysqli_query($con, $tablequery);
            while ($row = mysqli_fetch_array($q)) {
            ?>
              <label><?php echo  $row['concern_name']; ?></label>
              <div class="progress">

                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
              </div>
            <?php }
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
                      name: 'Partialy Compliance',
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
                          return val +" "+ "indicators"
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