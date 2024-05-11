<?php
include('session.php');
include_once("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h.php');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>DashBoard</h1>
    </div><!-- End Page Title -->
    <!-- ----working area ----->
    <section class="section">
        <div class="row">

            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <?php $dept_id = $_SESSION['dept_id1'];
                        $Fa = $_SESSION['u_facilityid'];
                        $fat = $_SESSION['f_type_id'];
                        $p =  $_SESSION['assperiod'];
                        ?>
                        <h2 class="card-title">Areas of Concern wise Score % </h2>
                        <?php
                       
                        $tablequery1 = "call Area_of_concern_NQAS($fat,$Fa,$dept_id,$p)";
                        $q2 = mysqli_query($con, $tablequery1);
                        while ($row = mysqli_fetch_array($q2)) {
                        ?>
                            <!-- Progress Bars with labels-->
                            <label><?php echo  $row['concern_name']; ?></label>
                            <div class="progress">

                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                            </div>
                        <?php }
                        mysqli_free_result($q2);
                        $con->next_result();
                        ?>
                        <!-- End Progress Bars with labels -->

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h2 class="card-title">Areas of Concern wise compliance status</h2>
                        <?php
                        $dept_id = $_SESSION['dept_id1'];;
                        $Fa = $_SESSION['u_facilityid'];
                        $fat = $_SESSION['f_type_id'];
                        $p =  $_SESSION['assperiod'];
                        $tablequery1 = "call Area_of_concern_count_NQAS($fat,$Fa,$dept_id,$p)";
                        $q2 = mysqli_query($con, $tablequery1);
                        while ($row = mysqli_fetch_array($q2)) {
                        ?>
                             <td colspan="4"><button type="button" class="btn btn-outline-success">
                                <?php echo  $row['concern_name']; ?>
                                <span class="badge bg-primary rounded-pill">  <?php echo  $row['Obtained']; ?></span>out of<span class="badge bg-primary rounded-pill"><?php echo  $row['total']; ?></span>completed.
                                </td></button>
                        <?php }
                        mysqli_free_result($q2);
                        $con->next_result();
                        ?>
                        <!-- End Progress Bars with labels -->

                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Over All Progress</h5>
                        <?php
                        $dept_id1 = $_SESSION['dept_id1'];;
                        $Fa1 = $_SESSION['u_facilityid'];
                        $p1 =  $_SESSION['assperiod'];
                        $fat1 = $_SESSION['f_type_id'];
                        $tablequery1 = "call count_zero($Fa1,$dept_id1,$p1,$fat1)";
                        $q5 = mysqli_query($con, $tablequery1);
                        while ($row = mysqli_fetch_array($q5)) {

                        ?>
                            <button type="button" class="btn btn-warning mb-2">
                                Number of non compliance indicators(0): <span class="badge bg-white text-warning"><?php echo  $row['z']; ?></span>
                            </button>
                            <button type="button" class="btn btn-info mb-2">
                                Number of partialy compliance indicators(1): <span class="badge bg-white text-info"><?php echo  $row['o']; ?></span>
                            </button>

                            <button type="button" class="btn btn-success mb-2">
                                Number of fully compliance indicators(2): <span class="badge bg-white text-success"><?php echo  $row['t']; ?></span>
                            </button>
                            <button type="button" class="btn btn-primary mb-2">
                                Number of indicators completed : <span class="badge bg-white text-primary"><?php echo  $row['total']; ?></span>
                            </button>
                            <button type="button" class="btn btn-secondary mb-2">
                                Total Indicators: <span class="badge bg-white text-secondary"><?php echo  $row['total1']; ?></span>
                            </button>
                        <?php }
                        mysqli_free_result($q5);
                        $con->next_result();
                        ?>

                    </div>
                </div>

            </div>
        
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Assessment wise Progress</h5>
                        <!-- Radial Bar Chart -->
                        <div id="radialBarChart">
                            <?php

                            $fid = $_SESSION['u_facilityid'];
                            $did = $_SESSION['dept_id1'];
                            $fty = $_SESSION['f_type_id'];
                            $query = "CALL dept_dash_preriod_g($fid,$did,$fty)";
                            $result = $con->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $values[] = $row['total'];
                                    $values1[] = "'" . $row['period'] . "'";
                                }
                                $h = implode(", ", $values);
                                $h1 = implode(", ", $values1);

                            ?>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#radialBarChart"), {
                                            series: [<?php echo  $h; ?>],
                                            chart: {
                                                height: 250,
                                                type: 'radialBar',
                                                toolbar: {
                                                    show: true
                                                }
                                            },
                                            plotOptions: {
                                                radialBar: {
                                                    dataLabels: {
                                                        name: {
                                                            fontSize: '14px',
                                                        },
                                                        value: {
                                                            fontSize: '12px',
                                                        },
                                                        total: {
                                                            show: true,
                                                            label: 'Total',
                                                            formatter: function(w) {
                                                                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                                                return <?php
                                                                        mysqli_free_result($result);
                                                                        $con->next_result();
                                                                        $query = "CALL comp_t_g($did,$fty)";
                                                                        $result = $con->query($query);
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                                $values = $row['total'];
                                                                                echo $values;
                                                                            }
                                                                        }
                                                                        ?>
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            labels: [<?php echo $h1; ?>],
                                        }).render();
                                    });
                                </script>
                            <?php } ?>
                            <!-- End Radial Bar Chart -->

                        </div>
                    </div>
                </div>
                <!-----data end------->
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